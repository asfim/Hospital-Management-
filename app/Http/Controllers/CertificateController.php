<?php

namespace App\Http\Controllers;

use App\Models\BirthRecord;
use App\Models\DeathRecord;
use App\Models\MedicalCertificate;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'birth');

        $birthRecords = BirthRecord::with(['patient', 'doctor'])->latest()->paginate(15, ['*'], 'birth_page');
        $deathRecords = DeathRecord::with(['patient', 'doctor', 'admission'])->latest()->paginate(15, ['*'], 'death_page');
        $medicalCertificates = MedicalCertificate::with(['patient', 'doctor'])->latest()->paginate(15, ['*'], 'med_page');

        $patients = Patient::select('id', 'name', 'phone', 'blood_group', 'age', 'gender')->orderBy('name')->get();
        $doctors = Doctor::select('id', 'name', 'speciality')->orderBy('name')->get();
        $admissions = Admission::with('patient')->where('status', 'admitted')->get();

        return view('certificates.index', compact(
            'tab',
            'birthRecords',
            'deathRecords',
            'medicalCertificates',
            'patients',
            'doctors',
            'admissions'
        ));
    }

    public function storeBirth(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'baby_name' => 'nullable|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'birth_date' => 'required|date',
            'birth_time' => 'nullable',
            'weight_kg' => 'nullable|numeric|min:0.5|max:10',
            'mother_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'doctor_id' => 'nullable|exists:doctors,id',
            'remarks' => 'nullable|string',
        ]);

        $validated['record_no'] = 'BRT-' . strtoupper(Str::random(7));
        $record = BirthRecord::create($validated);

        return redirect()->route('certificates.index', ['tab' => 'birth'])
            ->with('success', "Birth record #{$record->record_no} registered successfully.");
    }

    public function storeDeath(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'admission_id' => 'nullable|exists:admissions,id',
            'death_date' => 'required|date',
            'death_time' => 'nullable',
            'cause_of_death' => 'required|string|max:255',
            'doctor_id' => 'nullable|exists:doctors,id',
            'remarks' => 'nullable|string',
        ]);

        $validated['record_no'] = 'DTH-' . strtoupper(Str::random(7));
        $record = DeathRecord::create($validated);

        return redirect()->route('certificates.index', ['tab' => 'death'])
            ->with('success', "Death record #{$record->record_no} registered successfully.");
    }

    public function storeMedical(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'type' => 'required|in:Medical Fitness,Sick Leave,Medical Exemption',
            'diagnosis' => 'nullable|string|max:255',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'recommendations' => 'nullable|string',
        ]);

        $validated['certificate_no'] = 'MED-' . strtoupper(Str::random(7));
        $cert = MedicalCertificate::create($validated);

        return redirect()->route('certificates.index', ['tab' => 'medical'])
            ->with('success', "Medical certificate #{$cert->certificate_no} issued successfully.");
    }

    public function printBirth(BirthRecord $record)
    {
        $record->load(['patient', 'doctor']);
        return view('certificates.birth_print', compact('record'));
    }

    public function printDeath(DeathRecord $record)
    {
        $record->load(['patient', 'doctor', 'admission']);
        return view('certificates.death_print', compact('record'));
    }

    public function printMedical(MedicalCertificate $certificate)
    {
        $certificate->load(['patient', 'doctor']);
        return view('certificates.medical_print', compact('certificate'));
    }
}
