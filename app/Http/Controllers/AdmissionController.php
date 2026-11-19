<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\BedTransfer;
use App\Models\DailyCharge;
use App\Models\DischargeSummary;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'admitted');
        $search = $request->get('search');

        $query = Admission::with(['patient', 'doctor', 'ward', 'bed'])->latest('admission_date');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('admission_no', 'like', "%{$search}%")
                  ->orWhereHas('patient', function($p) use ($search) {
                      $p->where('name', 'like', "%{$search}%")
                        ->orWhere('patient_id', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%");
                  });
            });
        }

        $admissions = $query->paginate(15);

        return view('admissions.index', compact('admissions', 'status', 'search'));
    }

    public function create(Request $request)
    {
        $patientId = $request->get('patient_id');
        $patients = Patient::latest()->take(50)->get();
        $doctors = Doctor::where('status', true)->get();
        $wards = Ward::with('availableBeds')->where('status', 'Active')->get();

        return view('admissions.create', compact('patients', 'doctors', 'wards', 'patientId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'referred_by' => 'nullable|string|max:255',
            'ward_id' => 'required|exists:wards,id',
            'bed_id' => 'required|exists:beds,id',
            'admission_date' => 'required|date',
            'admission_reason' => 'required|string',
            'provisional_diagnosis' => 'nullable|string',
            'deposit_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
        ]);

        $bed = Bed::findOrFail($validated['bed_id']);
        if ($bed->status !== 'available') {
            return back()->withInput()->with('error', 'Selected bed is no longer available. Please select another bed.');
        }

        DB::beginTransaction();
        try {
            // Generate Admission No: ADM-YYYY-XXXXXX
            $lastAdm = Admission::latest('id')->first();
            $nextId = $lastAdm ? $lastAdm->id + 1 : 1;
            $admissionNo = 'ADM-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

            $deposit = $validated['deposit_amount'] ?? 0;

            $admission = Admission::create([
                'admission_no' => $admissionNo,
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $validated['doctor_id'],
                'referred_by' => $validated['referred_by'] ?? null,
                'ward_id' => $validated['ward_id'],
                'bed_id' => $validated['bed_id'],
                'admission_date' => $validated['admission_date'],
                'admission_reason' => $validated['admission_reason'],
                'provisional_diagnosis' => $validated['provisional_diagnosis'] ?? null,
                'status' => 'admitted',
                'total_deposit' => $deposit,
                'total_billed' => $bed->daily_charge,
                'total_paid' => $deposit,
                'total_due' => max(0, $bed->daily_charge - $deposit),
                'created_by' => auth()->id(),
            ]);

            // Mark Bed as occupied
            $bed->update([
                'status' => 'occupied',
                'current_admission_id' => $admission->id,
            ]);

            // Add First Day Bed Charge
            DailyCharge::create([
                'admission_id' => $admission->id,
                'charge_date' => date('Y-m-d', strtotime($validated['admission_date'])),
                'charge_type' => 'bed',
                'description' => "Bed Charge: {$bed->bed_number} ({$bed->ward->name})",
                'amount' => $bed->daily_charge,
                'created_by' => auth()->id(),
            ]);

            // If deposit was paid, create invoice and payment record
            if ($deposit > 0) {
                $lastInv = Invoice::latest('id')->first();
                $nextInvId = $lastInv ? $lastInv->id + 1 : 1;
                $invoiceNo = 'INV-' . date('Y') . '-' . str_pad($nextInvId, 6, '0', STR_PAD_LEFT);

                $invoice = Invoice::create([
                    'invoice_no' => $invoiceNo,
                    'invoice_type' => 'ipd',
                    'patient_id' => $validated['patient_id'],
                    'admission_id' => $admission->id,
                    'doctor_id' => $validated['doctor_id'],
                    'date' => now()->toDateString(),
                    'subtotal' => $deposit,
                    'discount' => 0,
                    'total' => $deposit,
                    'paid' => $deposit,
                    'due' => 0,
                    'payment_status' => 'Paid',
                    'payment_method' => $validated['payment_method'] ?? 'Cash',
                    'created_by' => auth()->id(),
                ]);

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_name' => "Admission Intake Deposit ({$admission->admission_no})",
                    'amount' => $deposit,
                ]);

                Payment::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $deposit,
                    'date' => now()->toDateString(),
                    'method' => $validated['payment_method'] ?? 'Cash',
                    'transaction_id' => 'DEP-' . time(),
                ]);
            }

            DB::commit();

            return redirect()->route('admissions.show', $admission->id)
                ->with('success', 'Patient admitted successfully to ' . $bed->bed_number . '!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Admission failed: ' . $e->getMessage());
        }
    }

    public function show(Admission $admission)
    {
        $admission->load([
            'patient', 'doctor', 'ward', 'bed',
            'bedTransfers.fromBed', 'bedTransfers.toBed',
            'dailyCharges', 'vitals.recorder',
            'nursingNotes.nurse', 'medicationCharts.administrations',
            'dischargeSummary', 'invoices'
        ]);

        $wards = Ward::with('availableBeds')->where('status', 'Active')->get();
        $totalCharges = $admission->dailyCharges()->sum('amount');
        $totalDeposit = $admission->total_deposit;
        $balance = $totalCharges - $totalDeposit;

        return view('admissions.show', compact('admission', 'wards', 'totalCharges', 'totalDeposit', 'balance'));
    }

    public function transferBed(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'new_bed_id' => 'required|exists:beds,id',
            'reason' => 'required|string|max:255',
        ]);

        $newBed = Bed::findOrFail($validated['new_bed_id']);
        if ($newBed->status !== 'available') {
            return back()->with('error', 'Target bed is not available.');
        }

        DB::beginTransaction();
        try {
            $oldBedId = $admission->bed_id;
            $oldBed = Bed::find($oldBedId);

            // Log Bed Transfer
            BedTransfer::create([
                'admission_id' => $admission->id,
                'from_bed_id' => $oldBedId,
                'to_bed_id' => $newBed->id,
                'transferred_at' => now(),
                'reason' => $validated['reason'],
                'transferred_by' => auth()->id(),
            ]);

            // Release old bed to cleaning
            if ($oldBed) {
                $oldBed->update([
                    'status' => 'cleaning',
                    'current_admission_id' => null,
                ]);
            }

            // Occupy new bed
            $newBed->update([
                'status' => 'occupied',
                'current_admission_id' => $admission->id,
            ]);

            // Update admission
            $admission->update([
                'ward_id' => $newBed->ward_id,
                'bed_id' => $newBed->id,
            ]);

            DB::commit();

            return redirect()->route('admissions.show', $admission->id)
                ->with('success', 'Patient transferred to ' . $newBed->bed_number . ' successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Bed transfer failed: ' . $e->getMessage());
        }
    }

    public function addDailyCharge(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'charge_type' => 'required|string',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'charge_date' => 'required|date',
        ]);

        $validated['admission_id'] = $admission->id;
        $validated['created_by'] = auth()->id();

        DailyCharge::create($validated);

        // Update running total billed
        $totalCharges = $admission->dailyCharges()->sum('amount');
        $admission->update([
            'total_billed' => $totalCharges,
            'total_due' => max(0, $totalCharges - $admission->total_deposit),
        ]);

        return back()->with('success', 'Charge item added to patient bill.');
    }

    public function discharge(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'discharge_date' => 'required|date',
            'final_diagnosis' => 'required|string',
            'condition_on_discharge' => 'required|string',
            'treatment_given' => 'required|string',
            'discharge_medications' => 'nullable|string',
            'dietary_advice' => 'nullable|string',
            'follow_up_instructions' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            // 1. Create or update Discharge Summary
            DischargeSummary::updateOrCreate(
                ['admission_id' => $admission->id],
                [
                    'patient_id' => $admission->patient_id,
                    'doctor_id' => $admission->doctor_id,
                    'discharge_date' => $validated['discharge_date'],
                    'final_diagnosis' => $validated['final_diagnosis'],
                    'condition_on_discharge' => $validated['condition_on_discharge'],
                    'treatment_given' => $validated['treatment_given'],
                    'discharge_medications' => $validated['discharge_medications'] ?? null,
                    'dietary_advice' => $validated['dietary_advice'] ?? null,
                    'follow_up_instructions' => $validated['follow_up_instructions'] ?? null,
                    'follow_up_date' => $validated['follow_up_date'] ?? null,
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]
            );

            // 2. Free Bed & set to cleaning
            if ($admission->bed) {
                $admission->bed->update([
                    'status' => 'cleaning',
                    'current_admission_id' => null,
                ]);
            }

            // 3. Mark Admission Discharged
            $totalCharges = $admission->dailyCharges()->sum('amount');
            $admission->update([
                'status' => 'discharged',
                'discharge_date' => $validated['discharge_date'],
                'final_diagnosis' => $validated['final_diagnosis'],
                'total_billed' => $totalCharges,
                'total_due' => max(0, $totalCharges - $admission->total_deposit),
            ]);

            DB::commit();

            return redirect()->route('admissions.show', $admission->id)
                ->with('success', 'Patient successfully discharged! Discharge summary generated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Discharge failed: ' . $e->getMessage());
        }
    }
}
