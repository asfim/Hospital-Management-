<?php

namespace App\Http\Controllers;

use App\Models\AmbulanceVehicle;
use App\Models\AmbulanceRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AmbulanceController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = AmbulanceVehicle::all();
        $totalVehicles = $vehicles->count();
        $availableVehicles = $vehicles->where('status', 'available')->count();
        $onDutyVehicles = $vehicles->where('status', 'on_duty')->count();

        $statusFilter = $request->get('status');
        $query = AmbulanceRequest::with(['vehicle', 'patient'])->latest();
        if ($statusFilter && $statusFilter != 'all') {
            $query->where('status', $statusFilter);
        }
        $requests = $query->paginate(15);

        $patients = Patient::select('id', 'name', 'mobile')->orderBy('name')->get();

        return view('ambulance.index', compact('vehicles', 'totalVehicles', 'availableVehicles', 'onDutyVehicles', 'requests', 'patients', 'statusFilter'));
    }

    public function storeVehicle(Request $request)
    {
        $validated = $request->validate([
            'vehicle_number' => 'required|string|max:100|unique:ambulance_vehicles,vehicle_number',
            'vehicle_model' => 'nullable|string|max:100',
            'type' => 'required|in:Basic,ICU / Cardiac Support,Freezer,Neonatal',
            'driver_name' => 'required|string|max:100',
            'driver_phone' => 'required|string|max:30',
            'standard_fare' => 'required|numeric|min:0',
            'per_km_rate' => 'nullable|numeric|min:0',
        ]);

        $validated['status'] = 'available';
        AmbulanceVehicle::create($validated);

        return redirect()->route('ambulance.index')->with('success', 'Ambulance vehicle added to hospital fleet.');
    }

    public function updateVehicleStatus(Request $request, AmbulanceVehicle $vehicle)
    {
        $validated = $request->validate([
            'status' => 'required|in:available,on_duty,maintenance',
        ]);

        $vehicle->update(['status' => $validated['status']]);

        return redirect()->route('ambulance.index')->with('success', "Ambulance #{$vehicle->vehicle_number} status updated to {$vehicle->status}.");
    }

    public function storeRequest(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'ambulance_vehicle_id' => 'required|exists:ambulance_vehicles,id',
            'contact_name' => 'required|string|max:100',
            'contact_phone' => 'required|string|max:30',
            'pickup_location' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'distance_km' => 'nullable|numeric|min:0',
            'fare_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['request_no'] = 'AMB-' . strtoupper(Str::random(6));
        $validated['status'] = 'dispatched';
        $validated['requested_at'] = now();
        $validated['paid_amount'] = $validated['paid_amount'] ?? 0;

        $trip = AmbulanceRequest::create($validated);

        // Mark vehicle on duty
        AmbulanceVehicle::where('id', $validated['ambulance_vehicle_id'])->update(['status' => 'on_duty']);

        return redirect()->route('ambulance.index')->with('success', "Ambulance trip #{$trip->request_no} dispatched successfully.");
    }

    public function updateRequestStatus(Request $request, AmbulanceRequest $ambulanceRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:dispatched,completed,cancelled',
            'paid_amount' => 'nullable|numeric|min:0',
        ]);

        $data = ['status' => $validated['status']];
        if (isset($validated['paid_amount'])) {
            $data['paid_amount'] = $validated['paid_amount'];
        }

        if ($validated['status'] == 'completed') {
            $data['completed_at'] = now();
        }

        $ambulanceRequest->update($data);

        // Free up vehicle if completed or cancelled
        if (in_array($validated['status'], ['completed', 'cancelled']) && $ambulanceRequest->ambulance_vehicle_id) {
            AmbulanceVehicle::where('id', $ambulanceRequest->ambulance_vehicle_id)->update(['status' => 'available']);
        }

        return redirect()->route('ambulance.index')->with('success', "Ambulance trip #{$ambulanceRequest->request_no} status changed to {$ambulanceRequest->status}.");
    }
}
