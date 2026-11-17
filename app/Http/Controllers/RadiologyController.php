<?php

namespace App\Http\Controllers;

use App\Models\RadiologyOrder;
use App\Models\RadiologyReport;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Admission;
use App\Models\DailyCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RadiologyController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = RadiologyOrder::with(['patient', 'doctor', 'report'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(15);

        return view('radiology.index', compact('orders', 'status'));
    }

    public function create()
    {
        $patients = Patient::latest()->take(50)->get();
        $doctors = Doctor::where('status', true)->get();
        $admissions = Admission::where('status', 'admitted')->get();

        return view('radiology.create', compact('patients', 'doctors', 'admissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'admission_id' => 'nullable|exists:admissions,id',
            'test_name' => 'required|string|max:255',
            'modality' => 'required|string',
            'clinical_indication' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $lastOrd = RadiologyOrder::latest('id')->first();
        $nextId = $lastOrd ? $lastOrd->id + 1 : 1;
        $orderNo = 'RAD-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        $validated['order_no'] = $orderNo;
        $validated['status'] = 'pending';

        $order = RadiologyOrder::create($validated);

        // If inpatient, bill to admission
        if (!empty($validated['admission_id']) && $validated['amount'] > 0) {
            DailyCharge::create([
                'admission_id' => $validated['admission_id'],
                'charge_date' => now()->toDateString(),
                'charge_type' => 'radiology',
                'description' => "Radiology Investigation: {$validated['test_name']} ({$orderNo})",
                'amount' => $validated['amount'],
                'created_by' => auth()->id(),
            ]);
        }

        return redirect()->route('radiology.index')->with('success', 'Radiology order generated successfully!');
    }

    public function report(RadiologyOrder $order)
    {
        $order->load(['patient', 'doctor', 'report']);
        return view('radiology.report', compact('order'));
    }

    public function storeReport(Request $request, RadiologyOrder $order)
    {
        $validated = $request->validate([
            'findings' => 'required|string',
            'impression' => 'required|string',
            'image' => 'nullable|image|max:10240', // 10MB
        ]);

        $imagePath = $order->report ? $order->report->image_path : null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('radiology', 'public');
        }

        RadiologyReport::updateOrCreate(
            ['radiology_order_id' => $order->id],
            [
                'patient_id' => $order->patient_id,
                'radiologist_id' => auth()->id(),
                'findings' => $validated['findings'],
                'impression' => $validated['impression'],
                'image_path' => $imagePath,
                'status' => 'Final',
            ]
        );

        $order->update(['status' => 'reported']);

        return redirect()->route('radiology.print', $order->id)->with('success', 'Radiology report authored & verified!');
    }

    public function print(RadiologyOrder $order)
    {
        $order->load(['patient', 'doctor', 'report.radiologist']);
        return view('radiology.print', compact('order'));
    }
}
