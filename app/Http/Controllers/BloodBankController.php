<?php

namespace App\Http\Controllers;

use App\Models\BloodDonor;
use App\Models\BloodInventory;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BloodBankController extends Controller
{
    public function index(Request $request)
    {
        $groupCounts = [];
        $groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        foreach ($groups as $grp) {
            $groupCounts[$grp] = BloodInventory::where('blood_group', $grp)
                ->where('status', 'available')
                ->where('expiry_date', '>=', now()->toDateString())
                ->count();
        }

        $bloodGroupFilter = $request->get('blood_group');
        $statusFilter = $request->get('status', 'available');

        $query = BloodInventory::with(['donor', 'patient'])->latest();
        if ($bloodGroupFilter) {
            $query->where('blood_group', $bloodGroupFilter);
        }
        if ($statusFilter && $statusFilter != 'all') {
            $query->where('status', $statusFilter);
        }
        $bags = $query->paginate(20);

        $donors = BloodDonor::latest()->paginate(15, ['*'], 'donors_page');
        $patients = Patient::select('id', 'name', 'mobile', 'blood_group')->orderBy('name')->get();

        return view('blood_bank.index', compact('groupCounts', 'bags', 'donors', 'patients', 'bloodGroupFilter', 'statusFilter'));
    }

    public function storeDonor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'age' => 'nullable|integer|min:18|max:65',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'mobile' => 'required|string|max:30',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:255',
            'last_donated_at' => 'nullable|date',
            'medical_notes' => 'nullable|string',
        ]);

        $validated['donor_code'] = 'DNR-' . strtoupper(Str::random(6));
        $validated['status'] = 'Eligible';

        BloodDonor::create($validated);

        return redirect()->route('blood-bank.index')->with('success', 'Blood donor registered successfully.');
    }

    public function storeBag(Request $request)
    {
        $validated = $request->validate([
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'component_type' => 'required|string|max:100',
            'donor_id' => 'nullable|exists:blood_donors,id',
            'collected_at' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:collected_at',
            'storage_location' => 'nullable|string|max:100',
        ]);

        $validated['bag_number'] = 'BAG-' . strtoupper(Str::random(7));
        $validated['status'] = 'available';

        BloodInventory::create($validated);

        if (!empty($validated['donor_id'])) {
            BloodDonor::where('id', $validated['donor_id'])->update(['last_donated_at' => $validated['collected_at']]);
        }

        return redirect()->route('blood-bank.index')->with('success', 'Blood unit added to hospital inventory.');
    }

    public function issueBag(Request $request, BloodInventory $bag)
    {
        $validated = $request->validate([
            'issued_to_patient_id' => 'required|exists:patients,id',
        ]);

        $bag->update([
            'issued_to_patient_id' => $validated['issued_to_patient_id'],
            'issued_at' => now(),
            'status' => 'issued',
        ]);

        return redirect()->route('blood-bank.index')->with('success', "Blood unit #{$bag->bag_number} has been issued to the patient.");
    }
}
