<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\NursingNote;
use App\Models\NursingAssignment;
use App\Models\MedicationChart;
use App\Models\MedicationAdministration;
use App\Models\IntakeOutputChart;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Http\Request;

class NursingController extends Controller
{
    public function index()
    {
        $admissions = Admission::with(['patient', 'ward', 'bed', 'doctor', 'vitals' => function($q) {
            $q->latest('recorded_at')->take(1);
        }])->where('status', 'admitted')->get();

        $recentNotes = NursingNote::with(['admission.patient', 'nurse'])->latest('recorded_at')->take(10)->get();

        $activeRosters = NursingAssignment::with(['admission.patient', 'nurse'])
            ->whereDate('date', today())
            ->get();

        return view('nursing.index', compact('admissions', 'recentNotes', 'activeRosters'));
    }

    public function mar(Request $request)
    {
        $admissionId = $request->get('admission_id');
        $admissions = Admission::with(['patient', 'ward', 'bed'])->where('status', 'admitted')->get();

        $medicationCharts = [];
        $selectedAdmission = null;

        if ($admissionId) {
            $selectedAdmission = Admission::with(['patient', 'ward', 'bed'])->find($admissionId);
            if ($selectedAdmission) {
                $medicationCharts = MedicationChart::with(['administrations.administrator'])
                    ->where('admission_id', $admissionId)
                    ->get();
            }
        }

        return view('nursing.mar', compact('admissions', 'selectedAdmission', 'medicationCharts', 'admissionId'));
    }

    public function storeMedication(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'medicine_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:100',
            'frequency' => 'required|string|max:50',
            'route' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'instructions' => 'nullable|string',
        ]);

        $validated['status'] = 'active';
        $validated['prescribed_by'] = auth()->id();

        MedicationChart::create($validated);

        return back()->with('success', 'Medication added to patient chart!');
    }

    public function administerMedication(Request $request, MedicationChart $chart)
    {
        $validated = $request->validate([
            'status' => 'required|in:given,missed,refused,held',
            'notes' => 'nullable|string',
        ]);

        MedicationAdministration::create([
            'medication_chart_id' => $chart->id,
            'scheduled_time' => now(),
            'administered_at' => now(),
            'administered_by' => auth()->id(),
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Medication dose logged as ' . ucfirst($validated['status']));
    }

    public function storeNote(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'shift' => 'required|string',
            'note_type' => 'required|string',
            'content' => 'required|string',
        ]);

        $validated['nurse_id'] = auth()->id();
        $validated['recorded_at'] = now();

        NursingNote::create($validated);

        return back()->with('success', 'Nursing note saved successfully!');
    }

    public function roster(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $nurses = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['Nurse', 'Admin']);
        })->get();

        $admissions = Admission::with(['patient', 'ward', 'bed'])->where('status', 'admitted')->get();
        $assignments = NursingAssignment::with(['admission.patient', 'nurse'])
            ->whereDate('date', $date)
            ->get();

        return view('nursing.roster', compact('nurses', 'admissions', 'assignments', 'date'));
    }

    public function storeRoster(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'nurse_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'shift' => 'required|string',
        ]);

        $validated['status'] = 'Assigned';

        NursingAssignment::create($validated);

        return back()->with('success', 'Nurse shift assignment created successfully!');
    }
}
