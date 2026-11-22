@extends('layouts.frontend')
@section('title', $service->title . ' - Hospital Services')

@section('content')

<x-frontend.page-banner :title="$service->title"
    :breadcrumbs="['Services' => url('/services'), $service->title => '#']" />

<section class="section-padding py-5 bg-light-soft" style="background-color: #F8FAFC !important;">
    <div class="container py-4">
        <div class="row g-4 g-xl-5">

            {{-- Main Content Column --}}
            <div class="col-lg-8" data-aos="fade-up">
                
                {{-- Service Hero Card --}}
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden bg-white mb-4" style="border: 1px solid #E2E8F0 !important;">
                    @if($service->image)
                        <div class="position-relative" style="max-height: 380px; overflow: hidden;">
                            <img src="{{ $service->image }}" alt="{{ $service->title }}" class="w-100 object-fit-cover" style="height: 340px;">
                            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(15, 23, 42, 0.2) 0%, rgba(15, 23, 42, 0.75) 100%);"></div>
                            
                            <div class="position-absolute bottom-0 start-0 p-4 text-white">
                                @if($service->badge)
                                    <span class="badge rounded-pill px-3 py-1.5 fw-bold text-uppercase mb-2 shadow-sm" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3);">
                                        {{ $service->badge }}
                                    </span>
                                @endif
                                <h2 class="fw-bold mb-1 text-white">{{ $service->title }}</h2>
                                @if($service->tagline)
                                    <p class="text-white-50 mb-0 fs-6">{{ $service->tagline }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="p-4 p-md-5 text-white" style="background: {{ $service->gradient ?: 'linear-gradient(135deg, #142D4E 0%, #0F172A 100%)' }};">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center bg-white bg-opacity-20 text-white" style="width: 58px; height: 58px;">
                                    <i class="{{ $service->icon ?: 'fa-solid fa-hospital' }} fs-4"></i>
                                </div>
                                <div>
                                    @if($service->badge)
                                        <span class="badge bg-white text-dark rounded-pill px-3 py-1 fw-bold small mb-1">{{ $service->badge }}</span>
                                    @endif
                                    <h2 class="fw-bold text-white mb-0">{{ $service->title }}</h2>
                                </div>
                            </div>
                            @if($service->tagline)
                                <p class="text-white-50 mb-0 fs-6">{{ $service->tagline }}</p>
                            @endif
                        </div>
                    @endif

                    <div class="p-4 p-md-5">
                        {{-- Overview Header --}}
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="d-inline-block rounded-circle" style="width: 10px; height: 10px; background: #0D9488;"></span>
                            <span class="text-uppercase fw-bold text-teal small" style="color: #0D9488; letter-spacing: 0.05em;">Clinical Overview</span>
                        </div>

                        <h3 class="fw-bold text-dark mb-3">About {{ $service->title }}</h3>
                        
                        <div class="text-secondary mb-4" style="line-height: 1.8; font-size: 1rem;">
                            <p>{{ $service->description ?: $service->short_description }}</p>
                        </div>

                        {{-- Key Features & Capabilities --}}
                        @if(!empty($service->points))
                            <div class="mt-4 pt-4 border-top" style="border-color: #E2E8F0 !important;">
                                <h4 class="fw-bold text-dark mb-3">Key Highlights &amp; Equipment Specifications</h4>
                                <div class="row g-3">
                                    @foreach($service->points as $point)
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-3 bg-light d-flex align-items-start h-100" style="border: 1px solid #EDF2F7; gap: 12px;">
                                                <i class="fa-solid fa-circle-check text-teal mt-1 flex-shrink-0" style="color: #0D9488; font-size: 1.05rem;"></i>
                                                <span class="text-dark small fw-medium" style="line-height: 1.5;">{{ $point }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="mt-5 pt-4 border-top d-flex flex-wrap gap-3 align-items-center" style="border-color: #E2E8F0 !important;">
                            @if($service->contact_number)
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $service->contact_number) }}" class="btn btn-danger btn-lg rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="fa-solid fa-phone-volume me-2"></i> {{ $service->emergency_button_text ?: 'Call Hotline: ' . $service->contact_number }}
                                </a>
                            @endif

                            <a href="{{ url('/appointment') }}" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow-sm" style="background: linear-gradient(135deg, #0D9488 0%, #0f766e 100%); border: none;">
                                <i class="fa-regular fa-calendar-check me-2"></i> Book Consultation
                            </a>

                            <a href="{{ url('/contact') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4 fw-semibold">
                                <i class="fa-regular fa-envelope me-2"></i> General Inquiries
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Related Departments & Doctors --}}
                @if($departments->isNotEmpty())
                    <div class="card border-0 rounded-4 shadow-sm p-4 bg-white" style="border: 1px solid #E2E8F0 !important;">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="fa-solid fa-stethoscope text-teal me-2" style="color: #0D9488;"></i> Related Medical Specialties
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($departments as $dept)
                                <a href="{{ url('/departments/' . ($dept->slug ?: $dept->id)) }}" class="badge rounded-pill text-dark text-decoration-none px-3 py-2 bg-light border hover-lift">
                                    {{ $dept->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            {{-- Right Sidebar --}}
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="150">
                <div class="d-flex flex-column gap-4">

                    {{-- Quick Hotline Widget --}}
                    <div class="card border-0 rounded-4 shadow-sm p-4 text-white overflow-hidden position-relative" 
                         style="background: linear-gradient(135deg, #142D4E 0%, #0F172A 100%);">
                        <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold text-uppercase mb-2 align-self-start">
                            <i class="fa-solid fa-headset me-1"></i> Direct Assistance
                        </span>
                        <h4 class="fw-bold mb-2 text-white" style="color: #ffffff !important;">Emergency &amp; Service Desk</h4>
                        <p class="text-white-50 small mb-3">
                            For immediate trauma transfer, admission intake, or ambulance dispatch, call our 24/7 central control line:
                        </p>

                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $service->contact_number ?: \App\Models\Setting::get('site_phone', '+8801711000000')) }}" 
                           class="btn btn-danger btn-lg rounded-pill fw-bold py-2.5 mb-3 shadow text-center d-flex align-items-center justify-content-center gap-2">
                            <i class="fa-solid fa-phone-volume"></i> 
                            <span>{{ $service->contact_number ?: \App\Models\Setting::get('site_phone', '+880 1711 000000') }}</span>
                        </a>

                        <div class="d-flex align-items-center justify-content-between text-white-50 small border-top pt-3 border-secondary border-opacity-25">
                            <span><i class="fa-regular fa-clock me-1 text-teal" style="color: #2DD4BF;"></i> Operational Hours:</span>
                            <strong class="text-white">24 Hours / 7 Days</strong>
                        </div>
                    </div>

                    {{-- All Hospital Services List --}}
                    <div class="card border-0 rounded-4 shadow-sm p-4 bg-white" style="border: 1px solid #E2E8F0 !important;">
                        <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom" style="font-size: 1.1rem;">
                            <i class="fa-solid fa-grid-2 me-2 text-teal" style="color: #0D9488;"></i> All Hospital Services
                        </h5>
                        <div class="d-flex flex-column gap-2">
                            @foreach($allServices as $other)
                                <a href="{{ url('/services/' . $other->slug) }}" 
                                   class="d-flex align-items-center justify-content-between rounded-3 text-decoration-none transition-all hover-lift"
                                   style="padding: 10px 14px; background: #F8FAFC; border: 1px solid #E2E8F0; color: #1E293B;">
                                    <div class="d-flex align-items-center flex-grow-1" style="min-width: 0;">
                                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white flex-shrink-0 me-3" 
                                             style="width: 38px; height: 38px; min-width: 38px; font-size: 0.9rem; background: {{ $other->gradient ?: 'linear-gradient(135deg, #0D9488, #0f766e)' }}; box-shadow: 0 2px 4px rgba(0,0,0,0.06);">
                                            <i class="{{ $other->icon ?: 'fa-solid fa-hospital' }}"></i>
                                        </div>
                                        <div class="flex-grow-1" style="min-width: 0;">
                                            <strong class="d-block text-dark text-truncate" style="font-size: 0.88rem; font-weight: 700; line-height: 1.25;">{{ $other->title }}</strong>
                                            @if($other->tagline)
                                                <small class="text-muted d-block text-truncate" style="font-size: 0.74rem; line-height: 1.3; margin-top: 2px;">{{ $other->tagline }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-muted flex-shrink-0 ms-2" style="font-size: 0.72rem; opacity: 0.6;"></i>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-3 text-center">
                            <a href="{{ url('/services') }}" class="small fw-bold text-teal text-decoration-none" style="color: #0D9488;">
                                View All Services &rarr;
                            </a>
                        </div>
                    </div>

                    {{-- Inpatient Admission Quick Card --}}
                    <div class="card border-0 rounded-4 shadow-sm p-4 bg-white" style="border: 1px solid #E2E8F0 !important;">
                        <h5 class="fw-bold text-dark mb-2">Hospital Admission</h5>
                        <p class="text-muted small mb-3">
                            Planning for planned surgery or inpatient medical admission? Connect with our dedicated patient billing &amp; admission coordinators.
                        </p>
                        <a href="{{ url('/appointment') }}" class="btn btn-outline-dark rounded-pill w-100 fw-semibold btn-sm py-2">
                            <i class="fa-solid fa-clipboard-list me-1"></i> Admission &amp; Bed Inquiry
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
