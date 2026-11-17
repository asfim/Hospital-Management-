<?php

namespace App\Http\Controllers;

use App\Models\PatientVital;
use Illuminate\Http\Request;

class VitalController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'admission_id' => 'nullable|exists:admissions,id',
            'emergency_case_id' => 'nullable|exists:emergency_cases,id',
            'visit_id' => 'nullable',
            'systolic_bp' => 'nullable|string',
            'diastolic_bp' => 'nullable|string',
            'pulse_rate' => 'nullable|string',
            'temperature' => 'nullable|string',
            'respiratory_rate' => 'nullable|string',
            'spo2' => 'nullable|string',
            'blood_sugar' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        if (!empty($validated['weight']) && !empty($validated['height'])) {
            $heightM = $validated['height'] / 100;
            if ($heightM > 0) {
                $validated['bmi'] = round($validated['weight'] / ($heightM * $heightM), 2);
            }
        }

        $validated['recorded_at'] = now();
        $validated['recorded_by'] = auth()->id();

        PatientVital::create($validated);

        return back()->with('success', 'Patient vitals charted successfully!');
    }
}
