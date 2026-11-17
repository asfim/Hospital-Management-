<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::withCount([
            'beds as total_beds_count',
            'beds as occupied_beds_count' => function ($q) {
                $q->where('status', 'occupied');
            },
            'beds as available_beds_count' => function ($q) {
                $q->where('status', 'available');
            }
        ])->get();

        return view('wards.index', compact('wards'));
    }

    public function create()
    {
        return view('wards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:wards,code|max:50',
            'type' => 'required|string',
            'floor' => 'nullable|string|max:50',
            'gender_type' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'daily_charge' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $validated['status'] = 'Active';

        Ward::create($validated);

        return redirect()->route('wards.index')->with('success', 'Ward created successfully!');
    }

    public function edit(Ward $ward)
    {
        return view('wards.edit', compact('ward'));
    }

    public function update(Request $request, Ward $ward)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'floor' => 'nullable|string|max:50',
            'gender_type' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'daily_charge' => 'required|numeric|min:0',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $ward->update($validated);

        return redirect()->route('wards.index')->with('success', 'Ward updated successfully!');
    }

    public function destroy(Ward $ward)
    {
        if ($ward->beds()->where('status', 'occupied')->exists()) {
            return back()->with('error', 'Cannot delete ward with currently occupied beds.');
        }

        $ward->delete();
        return redirect()->route('wards.index')->with('success', 'Ward removed successfully.');
    }
}
