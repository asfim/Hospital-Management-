<?php

namespace App\Http\Controllers;

use App\Models\EmergencyCase;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Ward;
use App\Models\Admission;
use App\Models\Bed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmergencyController extends Controller
{
    public function index(Request $request)
    {
        $priority = $request->get('priority');
        $status = $request->get('status', 'active');

        $query = EmergencyCase::with(['patient', 'doctor', 'nurse'])->latest('arrival_time');

        if ($priority) {
            $query->where('triage_priority', $priority);
        }

        if ($status === 'active') {
            $query->whereIn('status', ['triaged', 'under_treatment']);
        } elseif ($status !== 'all') {
            $query->where('status', $status);
        }

        $emergencyCases = $query->paginate(15);

        // Counts for Triage priority summary
        $counts = [
            'red' => EmergencyCase::whereIn('status', ['triaged', 'under_treatment'])->where('triage_priority', 'red')->count(),
            'orange' => EmergencyCase::whereIn('status', ['triaged', 'under_treatment'])->where('triage_priority', 'orange')->count(),
            'yellow' => EmergencyCase::whereIn('status', ['triaged', 'under_treatment'])->where('triage_priority', 'yellow')->count(),
            'green' => EmergencyCase::whereIn('status', ['triaged', 'under_treatment'])->where('triage_priority', 'green')->count(),
            'total_active' => EmergencyCase::whereIn('status', ['triaged', 'under_treatment'])->count(),
        ];

        return view('emergency.index', compact('emergencyCases', 'counts', 'priority', 'status'));
    }

    public function create()
    {
        $patients = Patient::latest()->take(50)->get();
        $doctors = Doctor::where('status', true)->get();
        $nurses = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['Nurse', 'Admin']);
        })->get();

        return view('emergency.create', compact('patients', 'doctors', 'nurses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            // Fast patient registration if patient_id is not selected
            'patient_name' => 'required_without:patient_id|nullable|string|max:255',
            'patient_mobile' => 'nullable|string|max:20',
            'patient_gender' => 'nullable|string|in:male,female,other',
            'patient_age' => 'nullable|integer|min:0',
            
            'doctor_id' => 'nullable|exists:doctors,id',
            'nurse_id' => 'nullable|exists:users,id',
            'triage_priority' => 'required|in:red,orange,yellow,green,black',
            'arrival_mode' => 'required|string',
            'arrival_time' => 'required|date',
            'presenting_complaints' => 'required|string',
            'treatment_given' => 'nullable|string',
            'treatment_fee' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Check if creating a new patient on the fly
            if (empty($validated['patient_id'])) {
                $lastP = Patient::latest('id')->first();
                $nextPid = $lastP ? $lastP->id + 1 : 1;
                $patient = Patient::create([
                    'patient_id' => 'P-' . date('Y') . '-' . str_pad($nextPid, 6, '0', STR_PAD_LEFT),
                    'name' => $validated['patient_name'],
                    'mobile' => $validated['patient_mobile'] ?? 'N/A',
                    'gender' => $validated['patient_gender'] ?? 'male',
                    'age' => $validated['patient_age'] ?? null,
                ]);
                $patientId = $patient->id;
            } else {
                $patientId = $validated['patient_id'];
            }

            // Generate Case No: EMG-YYYY-XXXXXX
            $lastCase = EmergencyCase::latest('id')->first();
            $nextCid = $lastCase ? $lastCase->id + 1 : 1;
            $caseNo = 'EMG-' . date('Y') . '-' . str_pad($nextCid, 6, '0', STR_PAD_LEFT);

            $emergencyCase = EmergencyCase::create([
                'case_no' => $caseNo,
                'patient_id' => $patientId,
                'doctor_id' => $validated['doctor_id'] ?? null,
                'nurse_id' => $validated['nurse_id'] ?? null,
                'triage_priority' => $validated['triage_priority'],
                'arrival_mode' => $validated['arrival_mode'],
                'arrival_time' => $validated['arrival_time'],
                'presenting_complaints' => $validated['presenting_complaints'],
                'treatment_given' => $validated['treatment_given'] ?? null,
                'status' => 'triaged',
                'treatment_fee' => $validated['treatment_fee'] ?? 0,
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('emergency.show', $emergencyCase->id)
                ->with('success', 'Emergency Case registered successfully with Priority ' . strtoupper($validated['triage_priority']));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error registering emergency case: ' . $e->getMessage());
        }
    }

    public function show(EmergencyCase $emergency)
    {
        $emergency->load(['patient', 'doctor', 'nurse', 'vitals', 'admission']);
        $wards = Ward::with('availableBeds')->where('status', 'Active')->get();

        return view('emergency.show', compact('emergency', 'wards'));
    }

    public function update(Request $request, EmergencyCase $emergency)
    {
        $validated = $request->validate([
            'triage_priority' => 'sometimes|in:red,orange,yellow,green,black',
            'status' => 'sometimes|string',
            'treatment_given' => 'nullable|string',
            'discharge_notes' => 'nullable|string',
            'treatment_fee' => 'nullable|numeric|min:0',
        ]);

        $emergency->update($validated);

        if ($request->get('status') === 'discharged') {
            $emergency->update(['discharged_at' => now()]);
        }

        return redirect()->route('emergency.show', $emergency->id)->with('success', 'Emergency Case updated successfully!');
    }

    public function transferToIpd(Request $request, EmergencyCase $emergency)
    {
        $validated = $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'bed_id' => 'required|exists:beds,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'admission_reason' => 'required|string',
            'deposit_amount' => 'nullable|numeric|min:0',
        ]);

        $bed = Bed::findOrFail($validated['bed_id']);
        if ($bed->status !== 'available') {
            return back()->with('error', 'Selected bed is no longer available. Please select another bed.');
        }

        DB::beginTransaction();
        try {
            $lastAdm = Admission::latest('id')->first();
            $nextAid = $lastAdm ? $lastAdm->id + 1 : 1;
            $admissionNo = 'ADM-' . date('Y') . '-' . str_pad($nextAid, 6, '0', STR_PAD_LEFT);

            $deposit = $validated['deposit_amount'] ?? 0;

            $admission = Admission::create([
                'admission_no' => $admissionNo,
                'patient_id' => $emergency->patient_id,
                'doctor_id' => $validated['doctor_id'] ?? $emergency->doctor_id,
                'ward_id' => $validated['ward_id'],
                'bed_id' => $validated['bed_id'],
                'admission_date' => now(),
                'admission_reason' => $validated['admission_reason'],
                'provisional_diagnosis' => $emergency->presenting_complaints,
                'status' => 'admitted',
                'total_deposit' => $deposit,
                'created_by' => auth()->id(),
            ]);

            // Update Bed status to occupied
            $bed->update([
                'status' => 'occupied',
                'current_admission_id' => $admission->id,
            ]);

            // Update Emergency Case status
            $emergency->update([
                'admission_id' => $admission->id,
                'status' => 'admitted_ipd',
                'discharged_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('admissions.show', $admission->id)
                ->with('success', 'Emergency patient transferred to Inpatient Ward successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to transfer to IPD: ' . $e->getMessage());
        }
    }
}
