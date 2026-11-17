<?php

namespace App\Http\Controllers;

use App\Models\Surgery;
use App\Models\OtRoom;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Admission;
use App\Models\SurgeryStaff;
use App\Models\Staff;
use App\Models\DailyCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = Surgery::with(['patient', 'leadSurgeon', 'anesthesiologist', 'room'])->latest('scheduled_start');

        if ($status) {
            $query->where('status', $status);
        }

        $surgeries = $query->paginate(15);
        $rooms = OtRoom::withCount(['surgeries' => function($q) {
            $q->where('status', 'in_progress');
        }])->get();

        return view('ot.index', compact('surgeries', 'rooms', 'status'));
    }

    public function create()
    {
        $patients = Patient::latest()->take(50)->get();
        $doctors = Doctor::where('status', true)->get();
        $rooms = OtRoom::where('status', 'available')->get();
        $admissions = Admission::where('status', 'admitted')->get();

        return view('ot.create', compact('patients', 'doctors', 'rooms', 'admissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'admission_id' => 'nullable|exists:admissions,id',
            'ot_room_id' => 'required|exists:ot_rooms,id',
            'lead_surgeon_id' => 'required|exists:doctors,id',
            'anesthesiologist_id' => 'nullable|exists:doctors,id',
            'surgery_name' => 'required|string|max:255',
            'surgery_type' => 'required|string',
            'scheduled_start' => 'required|date',
            'scheduled_end' => 'required|date|after:scheduled_start',
            'anesthesia_type' => 'required|string',
            'pre_op_notes' => 'nullable|string',
            'surgeon_fee' => 'nullable|numeric|min:0',
            'anesthesia_fee' => 'nullable|numeric|min:0',
            'ot_room_charge' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generate Surgery No: SUR-YYYY-XXXXXX
            $lastSur = Surgery::latest('id')->first();
            $nextId = $lastSur ? $lastSur->id + 1 : 1;
            $surgeryNo = 'SUR-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

            $surgeonFee = $validated['surgeon_fee'] ?? 0;
            $anesthesiaFee = $validated['anesthesia_fee'] ?? 0;
            $otRoomCharge = $validated['ot_room_charge'] ?? 0;
            $totalCharge = $surgeonFee + $anesthesiaFee + $otRoomCharge;

            $surgery = Surgery::create([
                'surgery_no' => $surgeryNo,
                'patient_id' => $validated['patient_id'],
                'admission_id' => $validated['admission_id'] ?? null,
                'ot_room_id' => $validated['ot_room_id'],
                'lead_surgeon_id' => $validated['lead_surgeon_id'],
                'anesthesiologist_id' => $validated['anesthesiologist_id'] ?? null,
                'surgery_name' => $validated['surgery_name'],
                'surgery_type' => $validated['surgery_type'],
                'scheduled_start' => $validated['scheduled_start'],
                'scheduled_end' => $validated['scheduled_end'],
                'anesthesia_type' => $validated['anesthesia_type'],
                'pre_op_notes' => $validated['pre_op_notes'] ?? null,
                'surgeon_fee' => $surgeonFee,
                'anesthesia_fee' => $anesthesiaFee,
                'ot_room_charge' => $otRoomCharge,
                'total_charge' => $totalCharge,
                'status' => 'scheduled',
            ]);

            // If inpatient admission exists, add OT charge to admission daily charges
            if (!empty($validated['admission_id']) && $totalCharge > 0) {
                DailyCharge::create([
                    'admission_id' => $validated['admission_id'],
                    'charge_date' => date('Y-m-d', strtotime($validated['scheduled_start'])),
                    'charge_type' => 'service',
                    'description' => "OT & Surgery Charge: {$validated['surgery_name']} ({$surgeryNo})",
                    'amount' => $totalCharge,
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('ot.show', $surgery->id)
                ->with('success', 'Surgery scheduled successfully in OT Room!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Surgery scheduling failed: ' . $e->getMessage());
        }
    }

    public function show(Surgery $ot)
    {
        $ot->load(['patient', 'admission.bed', 'leadSurgeon', 'anesthesiologist', 'room', 'staffTeam.staff']);
        $staffMembers = Staff::all();

        return view('ot.show', compact('ot', 'staffMembers'));
    }

    public function updateNotes(Request $request, Surgery $ot)
    {
        $validated = $request->validate([
            'pre_op_notes' => 'nullable|string',
            'op_notes' => 'nullable|string',
            'post_op_notes' => 'nullable|string',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
        ]);

        if ($validated['status'] === 'in_progress' && !$ot->actual_start) {
            $validated['actual_start'] = now();
            if ($ot->room) $ot->room->update(['status' => 'in_use']);
        } elseif ($validated['status'] === 'completed' && !$ot->actual_end) {
            $validated['actual_end'] = now();
            if ($ot->room) $ot->room->update(['status' => 'cleaning']);
        }

        $ot->update($validated);

        return back()->with('success', 'Operative notes and surgery status updated!');
    }

    public function addStaff(Request $request, Surgery $ot)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'role' => 'required|string',
        ]);

        SurgeryStaff::create([
            'surgery_id' => $ot->id,
            'staff_id' => $validated['staff_id'],
            'role' => $validated['role'],
        ]);

        return back()->with('success', 'Staff member added to surgical team.');
    }
}
