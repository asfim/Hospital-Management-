@extends('layouts.frontend')
@section('title', 'Hospital Services & Clinical Facilities - MediDiag Hospital')

@section('content')

<x-frontend.page-banner title="Hospital Services & Facilities" :breadcrumbs="['Services' => '#']" />

<section class="section-padding py-5 bg-light-soft" style="background-color: #F8FAFC !important;">
    <div class="container py-4">

        {{-- Section Intro Header --}}
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="background: rgba(13, 148, 136, 0.12); color: #0D9488;">
                <i class="fa-solid fa-hospital-user me-1"></i> Tertiary Healthcare Excellence
            </span>
            <h2 class="fw-bold mb-3" style="color: #142D4E;">Comprehensive Hospital Clinical Services</h2>
            <p class="text-muted mx-auto" style="max-width: 680px; font-size: 0.95rem;">
                From round-the-clock emergency trauma resuscitation to state-of-the-art modular surgical theaters and inpatient care, explore our specialized medical infrastructure designed for patient safety and clinical precision.
            </p>
        </div>

        {{-- Services Grid --}}
        <div class="row g-4">
            @forelse($services as $i => $service)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden d-flex flex-column transition-all hover-lift bg-white" style="border: 1px solid #E2E8F0 !important;">
                    
                    {{-- Card Header with Icon & Badge --}}
                    <div class="p-4 pb-3">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center text-white shadow-sm" 
                                 style="width: 54px; height: 54px; background: {{ $service->gradient ?: 'linear-gradient(135deg, #0D9488, #0f766e)' }};">
                                <i class="{{ $service->icon ?: 'fa-solid fa-hospital' }} fs-5"></i>
                            </div>
                            @if($service->badge)
                                <span class="badge rounded-pill px-3 py-1.5 fw-semibold small bg-{{ $service->badge_color ?? 'teal' }} bg-opacity-10 text-{{ $service->badge_color ?? 'teal' }}" style="font-size: 0.75rem;">
                                    {{ $service->badge }}
                                </span>
                            @endif
                        </div>

                        <h4 class="fw-bold text-dark mb-1" style="font-size: 1.25rem;">
                            <a href="{{ url('/services/' . $service->slug) }}" class="text-dark text-decoration-none hover-teal">
                                {{ $service->title }}
                            </a>
                        </h4>
                        @if($service->tagline)
                            <div class="text-teal fw-semibold small mb-2" style="color: #0D9488; font-size: 0.8rem;">
                                {{ $service->tagline }}
                            </div>
                        @endif

                        <p class="text-muted small mb-3" style="line-height: 1.6;">
                            {{ $service->short_description ?: Str::limit($service->description, 130) }}
                        </p>

                        {{-- Bullet Highlights --}}
                        @if(!empty($service->points))
                            <ul class="list-unstyled small text-muted mb-0 d-flex flex-column gap-1.5 pt-2 border-top" style="border-color: #F1F5F9 !important;">
                                @foreach(array_slice($service->points, 0, 3) as $point)
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-circle-check text-teal me-2 flex-shrink-0" style="color: #0D9488; font-size: 0.8rem;"></i>
                                        <span class="text-truncate">{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    {{-- Card Footer Action Buttons --}}
                    <div class="mt-auto p-4 pt-3 border-top bg-light-soft d-flex justify-content-between align-items-center" style="border-color: #F1F5F9 !important; background-color: #FAFCFF;">
                        @if($service->contact_number)
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $service->contact_number) }}" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold" style="font-size: 0.78rem;">
                                <i class="fa-solid fa-phone me-1"></i> Hotline
                            </a>
                        @else
                            <span class="text-muted small"><i class="fa-regular fa-clock me-1 text-teal"></i> 24/7 Service</span>
                        @endif

                        <a href="{{ url('/services/' . $service->slug) }}" class="btn btn-sm rounded-pill px-3 fw-bold text-white shadow-sm" style="background: linear-gradient(135deg, #0D9488 0%, #0f766e 100%); font-size: 0.8rem;">
                            View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-hospital text-muted mb-3" style="font-size: 3rem;"></i>
                <h4 class="text-muted">No hospital services configured yet.</h4>
            </div>
            @endforelse
        </div>

        {{-- Emergency Help Banner --}}
        <div class="mt-5 p-4 p-lg-5 rounded-4 text-white position-relative overflow-hidden shadow-lg" 
             style="background: linear-gradient(135deg, #142D4E 0%, #0F172A 100%);" data-aos="fade-up">
            <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <span class="badge bg-danger rounded-pill px-3 py-1.5 fw-bold text-uppercase mb-2">
                        <i class="fa-solid fa-bolt me-1"></i> 24/7 Immediate Response
                    </span>
                    <h3 class="fw-bold mb-2">Need Urgent Medical Attention or Emergency Transfer?</h3>
                    <p class="text-white-50 mb-0" style="max-width: 600px;">
                        Our emergency resuscitation center, cardiac ambulance dispatch, and inpatient admission desk are active 24 hours a day, 7 days a week.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', \App\Models\Setting::get('site_phone', '+8801711000000')) }}" class="btn btn-danger btn-lg rounded-pill px-4 fw-bold shadow">
                            <i class="fa-solid fa-phone-volume me-2"></i> Call Ambulance Hotline
                        </a>
                        <a href="{{ url('/appointment') }}" class="btn btn-outline-light btn-lg rounded-pill px-4 fw-semibold">
                            <i class="fa-regular fa-calendar-check me-2"></i> Book OPD Visit
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
