<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of hospital clinical & diagnostic services.
     */
    public function index()
    {
        $services = Service::active()->ordered()->get();
        return view('frontend.services.index', compact('services'));
    }

    /**
     * Display the specified hospital service.
     */
    public function show($slug)
    {
        $normalized = strtolower(trim($slug));

        $service = Service::where('slug', $normalized)
            ->orWhere('slug', $slug)
            ->orWhere('id', is_numeric($slug) ? (int)$slug : 0)
            ->firstOrFail();

        $allServices = Service::active()->ordered()->where('id', '!=', $service->id)->get();
        $doctors = Doctor::where('status', 1)->take(4)->get();
        $departments = Department::where('status', 1)->take(6)->get();

        return view('frontend.services.show', compact('service', 'allServices', 'doctors', 'departments'));
    }
}
