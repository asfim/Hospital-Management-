<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Test;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('doctors', 'tests')->get();
        return view('frontend.departments.index', compact('departments'));
    }

    public function show($slug)
    {
        $normalized = strtolower(trim($slug));

        $department = Department::where('slug', $normalized)
            ->orWhere('slug', $slug)
            ->orWhereRaw('LOWER(name) = ?', [$normalized])
            ->orWhere('id', is_numeric($slug) ? (int)$slug : 0)
            ->firstOrFail();

        $doctors = Doctor::where('department_id', $department->id)->where('status', 1)->get();
        if ($doctors->isEmpty()) {
            $doctors = Doctor::where('status', 1)
                ->where(function ($q) use ($department) {
                    $q->where('specialization', 'like', "%{$department->name}%")
                      ->orWhere('specialization', 'like', "%{$department->slug}%");
                })->get();
        }

        $tests = Test::where('department_id', $department->id)->where('status', 1)->get();

        return view('frontend.departments.show', compact('department', 'doctors', 'tests'));
    }
}
