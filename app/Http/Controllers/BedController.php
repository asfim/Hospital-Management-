<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Ward;
use Illuminate\Http\Request;

class BedController extends Controller
{
    public function index(Request $request)
    {
        $wardId = $request->get('ward_id');
        $status = $request->get('status');

        $query = Bed::with(['ward', 'currentAdmission.patient'])->orderBy('ward_id');

        if ($wardId) {
            $query->where('ward_id', $wardId);
        }
        if ($status) {
            $query->where('status', $status);
        }

        $beds = $query->paginate(20);
        $wards = Ward::all();

        return view('beds.index', compact('beds', 'wards', 'wardId', 'status'));
    }

    public function matrix()
    {
        $wards = Ward::with(['beds.currentAdmission.patient'])->get();

        $stats = [
            'total' => Bed::count(),
            'available' => Bed::where('status', 'available')->count(),
            'occupied' => Bed::where('status', 'occupied')->count(),
            'cleaning' => Bed::where('status', 'cleaning')->count(),
            'maintenance' => Bed::where('status', 'maintenance')->count(),
        ];

        return view('beds.matrix', compact('wards', 'stats'));
    }

    public function create()
    {
        $wards = Ward::where('status', 'Active')->get();
        return view('beds.create', compact('wards'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'bed_number' => 'required|string|max:50',
            'type' => 'required|string',
            'daily_charge' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'available';

        Bed::create($validated);

        return redirect()->route('beds.index')->with('success', 'Bed added successfully!');
    }

    public function edit(Bed $bed)
    {
        $wards = Ward::all();
        return view('beds.edit', compact('bed', 'wards'));
    }

    public function update(Request $request, Bed $bed)
    {
        $validated = $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'bed_number' => 'required|string|max:50',
            'type' => 'required|string',
            'daily_charge' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,cleaning,maintenance',
            'notes' => 'nullable|string',
        ]);

        $bed->update($validated);

        return redirect()->route('beds.index')->with('success', 'Bed updated successfully!');
    }

    public function updateStatus(Request $request, Bed $bed)
    {
        $validated = $request->validate([
            'status' => 'required|in:available,cleaning,maintenance',
        ]);

        if ($bed->status === 'occupied') {
            return back()->with('error', 'Cannot change status of currently occupied bed.');
        }

        $bed->update(['status' => $validated['status']]);

        return back()->with('success', 'Bed status updated to ' . ucfirst($validated['status']));
    }

    public function destroy(Bed $bed)
    {
        if ($bed->status === 'occupied') {
            return back()->with('error', 'Cannot delete an occupied bed.');
        }

        $bed->delete();
        return redirect()->route('beds.index')->with('success', 'Bed removed successfully.');
    }
}
