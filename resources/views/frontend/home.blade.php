@extends('layouts.frontend')

@section('title', ($siteSettings['site_name'] ?? 'Dhaka Central Hospital') . ' – ' . ($siteSettings['site_tagline'] ?? '24/7 Comprehensive Healthcare'))

@section('content')

{{-- ============================================================
     1. HERO SECTION - WORLD CLASS HEALTHCARE & 24/7 EMERGENCY
     ============================================================ --}}
<section class="hero-premium-section position-relative overflow-hidden py-5 py-lg-6" style="
    background: linear-gradient(135deg, #142D4E 0%, #0d1e35 55%, #091427 100%);
    @if(!empty($hero->bg_image)) 
        background-image: linear-gradient(135deg, rgba(20, 45, 78, 0.92) 0%, rgba(9, 20, 39, 0.90) 100%), url('{{ asset('storage/' . $hero->bg_image) }}'); 
        background-size: cover; 
        background-position: center; 
    @endif
    min-height: 480px;
">
    {{-- Ambient Glow Orbs --}}
    <div class="position-absolute" style="top: -100px; left: -100px; width: 420px; height: 420px; max-width: 100%; background: radial-gradient(circle, rgba(13,148,136,0.22) 0%, transparent 70%); filter: blur(60px); pointer-events: none;"></div>
    <div class="position-absolute" style="bottom: 0px; right: 0px; width: 500px; height: 500px; max-width: 100%; background: radial-gradient(circle, rgba(20,45,78,0.35) 0%, transparent 70%); filter: blur(70px); pointer-events: none;"></div>

    <div class="container position-relative" style="z-index: 3;">
        <div class="row align-items-center g-4 g-lg-5">
            {{-- Left Hero Content --}}
            <div class="col-lg-7" data-aos="fade-right" data-aos-duration="800">
                {{-- Live Emergency Pulsing Badge --}}
                <div class="d-inline-flex align-items-center gap-2 px-3 px-sm-3.5 py-1.5 rounded-pill mb-4 hero-live-badge text-nowrap" style="background: rgba(13, 148, 136, 0.18); backdrop-filter: blur(8px); border: 1px solid rgba(45, 212, 191, 0.35); max-width: 100%;">
                    <span class="d-inline-block rounded-circle bg-teal flex-shrink-0" style="width: 8px; height: 8px; background-color: #2dd4bf; box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.35);"></span>
                    <span class="fw-semibold small hero-live-badge-text text-truncate" style="color: #2dd4bf; letter-spacing: 0.4px; font-size: 0.82rem;">
                        <i class="fa-solid fa-hospital me-1"></i>
                        <span class="d-none d-lg-inline">{{ $hero->badge_text ?? '24/7 Multi-Specialty Hospital & Emergency Trauma Center' }}</span>
                        <span class="d-none d-sm-inline d-lg-none">{{ $hero->badge_mobile ?? '24/7 Multi-Specialty & Emergency Care' }}</span>
                        <span class="d-inline d-sm-none">{{ $hero->badge_compact ?? '24/7 Hospital & Emergency Care' }}</span>
                    </span>
                </div>

                {{-- Hero Headline --}}
                <h1 class="display-4 fw-extrabold text-white mb-3 lh-sm" style="font-weight: 800; letter-spacing: -0.5px;">
                    {{ $hero->title ?? 'Your Health, Our Priority' }}<br>
                    <span style="color: #2dd4bf; font-size: 0.85em;">{{ $hero->subtitle_highlight ?? ($siteSettings['site_tagline'] ?? 'World-Class Multi-Specialty Hospital') }}</span>
                </h1>

                {{-- Subtitle --}}
                <p class="mb-4" style="color: #CBD5E1; font-size: 1.12rem; line-height: 1.8; max-width: 600px;">
                    {!! nl2br(e($hero->subtitle ?? ($siteSettings['site_description'] ?? "Round-the-clock Emergency & Critical Care, renowned specialist physicians, modern Inpatient Cabins, and ISO-certified automated diagnostics — delivering excellence for you and your loved ones."))) !!}
                </p>

                {{-- Live Search Input --}}
                <div class="p-2 rounded-4 mb-4 shadow-lg border" style="background: rgba(255, 255, 255, 0.98); border-color: rgba(255, 255, 255, 0.4); max-width: 580px;">
                    <form action="{{ url('/tests') }}" method="GET" class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass text-muted fs-5 ps-3 flex-shrink-0"></i>
                        <input type="text" name="search" class="form-control border-0 shadow-none bg-transparent ps-2 text-dark" placeholder="Search doctor, department, or test..." style="font-size: 0.95rem;">
                        <button type="submit" class="btn px-3 px-sm-4 py-2 rounded-3 text-white fw-bold text-nowrap flex-shrink-0" style="background: linear-gradient(135deg, #0D9488 0%, #0f766e 100%);">
                            Find Now
                        </button>
                    </form>
                </div>

                {{-- Key Action Buttons --}}
                <div class="d-flex flex-wrap align-items-center gap-3 mb-5">
                    <a href="{{ $hero->button_link ?? url('/appointment') }}" class="btn px-4 py-3 rounded-pill fw-bold text-white shadow-lg text-decoration-none d-inline-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #0D9488 0%, #0f766e 100%); border: none;">
                        <i class="fa-regular fa-calendar-check fs-5"></i>
                        <span>{{ $hero->button_text ?? 'Book Doctor Appointment' }}</span>
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['site_phone'] ?? '01711000000') }}" class="btn px-4 py-3 rounded-pill fw-bold text-white shadow text-decoration-none d-inline-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #e11d48 0%, #be123c 100%); border: none;">
                        <i class="fa-solid fa-truck-medical fs-5"></i>
                        <span>24/7 Emergency Hotline</span>
                    </a>
                </div>

                {{-- Counter Strip --}}
                <div class="row g-3 pt-3 border-top" style="border-color: rgba(255, 255, 255, 0.12) !important; max-width: 600px;">
                    <div class="col-6 col-sm-3">
                        <div class="h3 fw-bold text-white mb-0">{{ $stats['doctors'] ?? ($doctorCount > 0 ? $doctorCount . '+' : '50+') }}</div>
                        <small style="color: #94A3B8;">Specialist Doctors</small>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="h3 fw-bold text-white mb-0">{{ $stats['beds'] ?? ($bedCount > 0 ? $bedCount . '+' : '40+') }}</div>
                        <small style="color: #94A3B8;">Beds &amp; Cabins</small>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="h3 fw-bold text-white mb-0">{{ $stats['tests'] ?? ($testCount > 0 ? $testCount . '+' : '500+') }}</div>
                        <small style="color: #94A3B8;">Diagnostic Tests</small>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="h3 fw-bold mb-0" style="color: #2dd4bf;">{{ $stats['support'] ?? '24/7' }}</div>
                        <small style="color: #94A3B8;">ICU &amp; Emergency</small>
                    </div>
                </div>
            </div>

            {{-- Right Hero Floating Healthcare Image & Interactive Badges --}}
            <div class="col-lg-5" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <div class="position-relative text-center">
                    {{-- Doctor Hero Image Wrapper with Ambient Glow --}}
                    <div class="position-relative d-inline-block w-100" style="max-width: 440px;">
                        <img src="{{ !empty($hero->image) ? asset('storage/' . $hero->image) : 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=800&q=80' }}" 
                             alt="{{ $siteSettings['site_name'] ?? 'Hospital' }} Chief Physician" 
                             class="img-fluid rounded-4 shadow-2xl w-100" 
                             style="max-height: 480px; object-fit: cover; border: 3px solid rgba(255, 255, 255, 0.2); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.65);"
                             onerror="this.src='https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=800&q=80'">

                        {{-- Floating Badge: Specialist Team --}}
                        <div class="position-absolute top-0 start-0 translate-middle-y bg-white p-2.5 px-3 rounded-pill shadow-lg d-flex align-items-center gap-2 hero-badge-top-left" style="border: 1px solid #E2E8F0;">
                            <span class="d-inline-block rounded-circle bg-teal" style="width: 8px; height: 8px; background: #0D9488;"></span>
                            <span class="text-dark fw-bold small"><i class="fa-solid fa-user-doctor text-primary me-1"></i> {{ $stats['doctors'] ?? ($doctorCount > 0 ? $doctorCount . '+' : '50+') }} Specialists</span>
                        </div>

                        {{-- Floating Badge: Emergency ICU Ready --}}
                        <div class="position-absolute bottom-0 end-0 translate-middle-y text-white p-3 rounded-4 shadow-lg text-start hero-badge-bottom-right" style="background: rgba(20, 45, 78, 0.95) !important; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(8px);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-danger p-2 d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px;">
                                    <i class="fa-solid fa-truck-medical fs-6"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small text-white">Emergency &amp; ICU</div>
                                    <small class="text-white-50" style="font-size: 0.72rem;">{{ $stats['support'] ?? '24/7' }} Rapid Response</small>
                                </div>
                            </div>
                        </div>

                        {{-- Floating Badge: ISO Certified Labs --}}
                        <div class="position-absolute bottom-0 start-0 translate-middle-y bg-white p-2 px-3 rounded-pill shadow-lg d-flex align-items-center gap-2 hero-badge-bottom-left" style="border: 1px solid #E2E8F0;">
                            <i class="fa-solid fa-shield-halved text-success"></i>
                            <span class="text-dark fw-bold small" style="font-size: 0.75rem;">ISO 9001:2015 Lab</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     2. QUICK ACCESS SHORTCUTS (6 PATIENT SHORTCUT CARDS)
     ============================================================ --}}
<div class="position-relative quick-shortcuts-wrapper">
    <div class="container">
        <div class="row g-3">
            @foreach($quickActions as $i => $action)
            <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="{{ 100 + ($i * 50) }}">
                <a href="{{ $action['link'] ?? '#' }}" class="text-decoration-none">
                    <div class="bg-white p-3 rounded-4 shadow-sm h-100 border text-center transition-all hover-lift" style="border-color: #E2E8F0 !important;">
                        <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-2.5 text-{{ $action['color'] ?? 'teal' }}" style="width: 50px; height: 50px; background: rgba(13, 148, 136, 0.12);">
                            <i class="{{ $action['icon'] ?? 'fa-regular fa-calendar-check' }} fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1 small">{{ $action['title'] ?? 'Service' }}</h6>
                        <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">{{ $action['description'] ?? '' }}</small>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ============================================================
     3. ABOUT HOSPITAL & CLINICAL EXCELLENCE SECTION
     ============================================================ --}}
<section class="section-padding py-5 mt-4" id="about-hospital">
    <div class="container py-4">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <img src="{{ !empty($about['image']) ? asset('storage/' . $about['image']) : 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1000&q=80' }}"
                         alt="About {{ $siteSettings['site_name'] ?? 'Hospital' }}" 
                         class="img-fluid rounded-4 shadow-lg w-100 object-fit-cover" 
                         style="max-height: 480px; border: 1px solid #E2E8F0;"
                         onerror="this.src='https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1000&q=80'">

                    {{-- Experience Overlay Badge --}}
                    <div class="position-absolute bottom-0 start-0 text-white p-3.5 rounded-4 shadow-xl m-3.5" style="background: rgba(20, 45, 78, 0.95) !important; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.15);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="display-6 fw-bold text-teal" style="color: #2dd4bf;">{{ $about['years_number'] ?? '15+' }}</div>
                            <div class="lh-sm">
                                <span class="fw-bold d-block text-white">{{ $about['years_text'] ?? 'Years of Clinical Excellence' }}</span>
                                <small class="text-white-50">Healthcare Excellence</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background: rgba(13, 148, 136, 0.1); border: 1px solid rgba(13, 148, 136, 0.2);">
                    <span class="small fw-bold text-uppercase" style="color: #0D9488; letter-spacing: 0.5px;">{{ $about['label'] ?? ('About ' . ($siteSettings['site_name'] ?? 'Our Hospital')) }}</span>
                </div>
                <h2 class="display-6 fw-bold text-dark mb-3" style="color: #142D4E !important;">
                    {{ $about['title'] ?? 'Leading the Way in Patient-Centered Healthcare' }}
                </h2>
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    {{ $about['description'] ?? 'Dhaka Central Hospital provides comprehensive tertiary healthcare, advanced surgical facilities, 24/7 emergency trauma care, and state-of-the-art diagnostic laboratories with a dedication to patient safety and clinical excellence.' }}
                </p>

                {{-- Mission & Core Values Grid --}}
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 border bg-white h-100" style="border-color: #E2E8F0 !important;">
                            <div class="d-flex align-items-center gap-2 mb-2 text-teal" style="color: #0D9488;">
                                <i class="fa-solid fa-bullseye fs-5"></i>
                                <h6 class="fw-bold mb-0 text-dark">{{ $about['mission_title'] ?? 'Our Mission' }}</h6>
                            </div>
                            <p class="text-muted small mb-0">{{ $about['mission_text'] ?? 'Delivering ethical, precise, and affordable medical care to every patient with uncompromising quality.' }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 border bg-white h-100" style="border-color: #E2E8F0 !important;">
                            <div class="d-flex align-items-center gap-2 mb-2 text-primary" style="color: #142D4E;">
                                <i class="fa-solid fa-eye fs-5"></i>
                                <h6 class="fw-bold mb-0 text-dark">{{ $about['vision_title'] ?? 'Our Vision' }}</h6>
                            </div>
                            <p class="text-muted small mb-0">{{ $about['vision_text'] ?? 'To be South Asia\'s benchmark healthcare institution recognized for medical innovation and compassion.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-3">
                    <a href="{{ $about['button_link'] ?? url('/about') }}" class="btn px-4 py-2.5 rounded-pill fw-bold text-white shadow-sm" style="background: #142D4E; border: none;">
                        {{ $about['button_text'] ?? 'Learn More About Us' }} <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                    <a href="{{ url('/doctors') }}" class="btn btn-outline-dark px-4 py-2.5 rounded-pill fw-semibold" style="border-color: #CBD5E1;">
                        Meet Specialist Doctors
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     4. CLINICAL DEPARTMENTS & CENTERS OF EXCELLENCE
     ============================================================ --}}
<section class="section-padding py-5 bg-light-soft" id="clinical-departments" style="background-color: #F8FAFC !important;">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="background: rgba(13, 148, 136, 0.12); color: #0D9488;">Centers of Excellence</span>
                <h2 class="fw-bold text-dark mb-0" style="color: #142D4E !important;">Our Clinical Departments</h2>
                <p class="text-muted mt-2 mb-0">Multi-disciplinary specialized tertiary departments with dedicated physician teams.</p>
            </div>
            <a href="{{ url('/departments') }}" class="btn btn-outline-dark rounded-pill px-4 fw-semibold" style="border-color: #CBD5E1; color: #142D4E;">
                Explore All Departments <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($departments as $i => $dept)
            <div class="col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ ($i+1)*60 }}">
                <a href="{{ url('/departments/' . ($dept->slug ?? $dept->id)) }}" class="text-decoration-none">
                    <div class="department-card-premium bg-white p-4 rounded-4 shadow-sm text-center h-100 border transition-all hover-lift" style="border-color: #E2E8F0 !important;">
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 64px; height: 64px; background: rgba(13, 148, 136, 0.1); color: #0D9488;">
                            <i class="fa-solid {{ $dept->icon ?? 'fa-stethoscope' }} fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ $dept->name }}</h5>
                        <p class="text-muted small mb-3">{{ Str::limit($dept->description ?? 'Specialized clinical care, consultations and diagnostics.', 70) }}</p>
                        <div class="d-flex justify-content-center gap-3 pt-3 border-top text-muted small" style="border-color: #F1F5F9 !important;">
                            <span><i class="fa-solid fa-user-doctor text-primary me-1" style="color: #142D4E;"></i>{{ $dept->doctors_count ?? 0 }} Doctors</span>
                            <span><i class="fa-solid fa-vial text-teal me-1" style="color: #0D9488;"></i>{{ $dept->tests_count ?? 0 }} Tests</span>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">
                No clinical departments listed.
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================
     5. HOSPITAL FACILITIES & CLINICAL INFRASTRUCTURE (DEDICATED)
     ============================================================ --}}
<section class="section-padding py-5 bg-white" id="hospital-facilities">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="background: rgba(20, 45, 78, 0.1); color: #142D4E;">Clinical Infrastructure</span>
            <h2 class="fw-bold mb-2" style="color: #142D4E;">World-Class Hospital Facilities</h2>
            <p class="text-muted mx-auto" style="max-width: 620px;">
                Designed to international healthcare standards with modern infection control, continuous vital monitoring, and rapid emergency intervention.
            </p>
        </div>

        <div class="row g-4" id="hospital-services">
            @foreach($facilities as $i => $fac)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 + ($i * 50) }}">
                <div class="p-4 rounded-4 border h-100 shadow-sm transition-all hover-lift bg-white" style="border-color: #E2E8F0 !important;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; background: {{ $fac['gradient'] ?? 'linear-gradient(135deg, #0D9488, #0f766e)' }};">
                            <i class="fa-solid {{ $fac['icon'] ?? 'fa-hospital' }} fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">{{ $fac['title'] }}</h5>
                            <span class="badge small bg-{{ $fac['badge_color'] ?? 'teal' }} bg-opacity-10 text-{{ $fac['badge_color'] ?? 'teal' }}">{{ $fac['badge'] }}</span>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        {{ $fac['description'] }}
                    </p>
                    @if(!empty($fac['points']))
                    <ul class="list-unstyled small text-muted mb-0 d-flex flex-column gap-1.5">
                        @foreach($fac['points'] as $pt)
                        <li><i class="fa-solid fa-circle-check text-teal me-2" style="color: #0D9488;"></i> {{ $pt }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     6. SPECIALIST DOCTORS DIRECTORY
     ============================================================ --}}
<section class="section-padding py-5 bg-light-soft" id="doctors-directory" style="background-color: #F8FAFC !important;">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="background: rgba(20, 45, 78, 0.1); color: #142D4E;">Medical Faculty</span>
                <h2 class="fw-bold text-dark mb-0" style="color: #142D4E !important;">Our Specialist Consultants</h2>
                <p class="text-muted mt-2 mb-0">Renowned professors and specialized clinicians dedicated to compassionate patient recovery.</p>
            </div>
            <a href="{{ url('/doctors') }}" class="btn btn-outline-dark rounded-pill px-4 fw-semibold" style="border-color: #CBD5E1; color: #142D4E;">
                View All Doctors <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($doctors as $i => $doc)
            <div class="col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ ($i+1)*100 }}">
                <div class="doctor-card-modern bg-white rounded-4 shadow-sm overflow-hidden border h-100 d-flex flex-column transition-all hover-lift" style="border-color: #E2E8F0 !important;">
                    <div class="position-relative bg-light text-center" style="height: 250px; overflow: hidden;">
                        <img src="{{ $doc->photo ? asset('storage/'.$doc->photo) : 'https://images.unsplash.com/photo-1594824436998-058a23116fc7?auto=format&fit=crop&w=500&q=80' }}" alt="{{ $doc->name }}" class="w-100 h-100 object-fit-cover" onerror="this.src='https://images.unsplash.com/photo-1594824436998-058a23116fc7?auto=format&fit=crop&w=500&q=80'">
                        <span class="badge position-absolute bottom-0 start-0 m-3 rounded-pill px-3 py-1.5 shadow-sm text-white" style="background: #142D4E; font-size: 0.75rem;">
                            {{ $doc->department ? $doc->department->name : 'Consultant' }}
                        </span>
                    </div>
                    <div class="p-4 text-center d-flex flex-column flex-grow-1 justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">{{ $doc->name }}</h5>
                            <div class="text-muted small mb-2">{{ $doc->qualification ?? 'MBBS, FCPS' }}</div>
                            <div class="badge bg-light text-secondary border px-2.5 py-1 small mb-2">
                                <i class="fa-solid fa-stethoscope me-1" style="color: #0D9488;"></i>{{ $doc->specialization ?? 'Specialist Consultant' }}
                            </div>
                            @if($doc->schedules && $doc->schedules->isNotEmpty())
                                <div class="text-teal small mb-2" style="font-size: 0.73rem; color: #0D9488;">
                                    <i class="fa-regular fa-clock me-1"></i>{{ $doc->schedules->pluck('day')->unique()->take(3)->implode(', ') }}
                                </div>
                            @endif
                        </div>
                        <div class="pt-3 border-top" style="border-color: #F1F5F9 !important;">
                            <div class="d-flex justify-content-between align-items-center mb-3 text-muted small">
                                <span>Chamber Fee:</span>
                                <strong class="text-dark fs-6">৳{{ number_format($doc->consultation_fee ?? 0, 0) }}</strong>
                            </div>
                            <a href="{{ url('/appointment') }}?doctor={{ $doc->id }}" class="btn w-100 rounded-pill fw-bold py-2 text-white shadow-sm" style="background: linear-gradient(135deg, #0D9488 0%, #0f766e 100%); border: none;">
                                <i class="fa-regular fa-calendar-check me-1"></i> Book Appointment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">No doctors currently listed.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================
     7. 24/7 EMERGENCY & AMBULANCE DISPATCH HOTLINE BANNER
     ============================================================ --}}
<section class="py-5 text-white position-relative overflow-hidden my-2" style="background: linear-gradient(135deg, #142D4E 0%, #0d1e35 50%, #991b1b 100%);">
    <div class="container position-relative py-3" style="z-index: 2;">
        <div class="row align-items-center g-4">
            <div class="col-lg-8" data-aos="fade-right">
                <div class="d-inline-flex align-items-center gap-2 bg-danger bg-opacity-25 px-3 py-1 rounded-pill text-white border border-danger border-opacity-25 small fw-bold mb-3">
                    <span class="d-inline-block rounded-circle bg-danger" style="width: 8px; height: 8px; box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.5);"></span>
                    Critical Trauma &amp; Emergency Care
                </div>
                <h3 class="fw-extrabold text-white mb-2 display-6">Immediate Medical Emergency or Ambulance Needed?</h3>
                <p class="text-white-50 mb-0" style="font-size: 1.05rem;">
                    Our fleet of specialized ICU &amp; Cardiac Support Ambulances with certified emergency paramedics is on standby 24/7 for prompt patient transfer.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-3">
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['site_phone'] ?? '01711000000') }}" class="btn btn-danger btn-lg rounded-pill px-4 py-3 fw-bold d-inline-flex align-items-center justify-content-center gap-2 shadow-lg" style="background: #dc2626; border: none;">
                        <i class="fa-solid fa-phone-volume fs-5"></i>
                        <span>{{ $siteSettings['site_phone'] ?? '+880 1711 000 000' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     8. DIAGNOSTIC TESTS & HEALTH CHECKUP PACKAGES
     ============================================================ --}}
<section class="section-padding py-5 bg-white" id="diagnostic-services">
    <div class="container py-4">
        {{-- Section 1: Popular Tests --}}
        <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="background: rgba(13, 148, 136, 0.1); color: #0D9488;">Pathology &amp; Imaging</span>
                <h2 class="fw-bold text-dark mb-0" style="color: #142D4E !important;">Popular Diagnostic Tests</h2>
                <p class="text-muted mt-2 mb-0">High-accuracy automated testing with same-day verified online report delivery.</p>
            </div>
            <a href="{{ url('/tests') }}" class="btn btn-outline-teal rounded-pill px-4 fw-semibold" style="border-color: #0D9488; color: #0D9488;">
                View All Tests <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4 mb-5">
            @forelse($tests->take(6) as $i => $test)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($i+1)*80 }}">
                <div class="bg-white rounded-4 p-4 shadow-sm h-100 border d-flex flex-column justify-content-between transition-all hover-lift" style="border-color: #E2E8F0 !important;">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-light text-secondary border px-2.5 py-1.5 rounded-pill small">
                                <i class="fa-solid fa-flask-vial me-1" style="color: #0D9488;"></i> {{ $test->category->name ?? 'Pathology' }}
                            </span>
                            <span class="fw-bold fs-5" style="color: #0D9488;">৳{{ number_format($test->price, 0) }}</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">
                            <a href="{{ url('/tests/'.$test->id) }}" class="text-dark text-decoration-none hover-teal">{{ $test->name }}</a>
                        </h5>
                        <p class="text-muted small mb-3">{{ Str::limit($test->description ?? 'Reliable diagnostic test verified by senior consultant pathologists.', 80) }}</p>
                    </div>
                    <div class="d-flex gap-2 pt-3 border-top" style="border-color: #F1F5F9 !important;">
                        <a href="{{ url('/tests/'.$test->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 flex-grow-1">Details</a>
                        <a href="{{ url('/appointment') }}?test={{ $test->id }}" class="btn btn-sm rounded-pill px-4 fw-semibold flex-grow-1 text-white" style="background: #0D9488; border-color: #0D9488;">Book Test</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">No diagnostic tests available.</div>
            @endforelse
        </div>

        {{-- Section 2: Health Packages --}}
        @if($packages->isNotEmpty())
        <div class="d-flex justify-content-between align-items-end mb-4 pt-3 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="background: rgba(20, 45, 78, 0.1); color: #142D4E;">Preventive Wellness</span>
                <h3 class="fw-bold text-dark mb-0" style="color: #142D4E !important;">Comprehensive Health Packages</h3>
                <p class="text-muted mt-2 mb-0">Multi-panel screening packages designed for early detection and lifestyle wellness.</p>
            </div>
            <a href="{{ url('/packages') }}" class="btn btn-outline-dark rounded-pill px-4 fw-semibold" style="border-color: #CBD5E1; color: #142D4E;">
                All Packages <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($packages as $pkg)
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="bg-white rounded-4 p-4 shadow-sm h-100 border d-flex flex-column justify-content-between position-relative overflow-hidden transition-all hover-lift" style="border-color: #E2E8F0 !important;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge px-3 py-1.5 rounded-pill text-white fw-bold" style="background: #142D4E;">
                            <i class="fa-solid fa-box-open me-1"></i> {{ $pkg->tests_count ?? 'Multiple' }} Tests Included
                        </span>
                        <div class="text-end">
                            <span class="h4 fw-bold mb-0 d-block" style="color: #0D9488;">৳{{ number_format($pkg->discount_price ?? $pkg->price, 0) }}</span>
                            @if($pkg->discount_price && $pkg->discount_price < $pkg->price)
                                <small class="text-muted text-decoration-line-through">৳{{ number_format($pkg->price, 0) }}</small>
                            @endif
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ $pkg->name }}</h5>
                    <p class="text-muted small mb-4">{{ Str::limit($pkg->description ?? 'Complete health evaluation with certified physician consultation.', 90) }}</p>
                    <a href="{{ url('/packages/'.$pkg->id) }}" class="btn w-100 rounded-pill fw-bold py-2 text-white shadow-sm" style="background: #142D4E; border: none;">
                        Explore Package &amp; Book &rarr;
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- ============================================================
     9. WHY PATIENTS TRUST US (CLINICAL PILLARS)
     ============================================================ --}}
<section class="section-padding py-5 bg-light-soft" style="background-color: #F8FAFC !important;">
    <div class="container py-4">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="background: rgba(13, 148, 136, 0.1); color: #0D9488;">{{ $whyChoose['label'] ?? 'Quality & Standards' }}</span>
                <h2 class="display-6 fw-bold text-dark mb-3" style="color: #142D4E !important;">{{ $whyChoose['title'] ?? ('Why Patients Choose ' . ($siteSettings['site_name'] ?? 'Our Hospital')) }}</h2>
                <p class="text-muted mb-4">{{ $whyChoose['description'] ?? 'We merge clinical expertise with world-class medical engineering to deliver safe, effective, and patient-centered hospital care.' }}</p>

                <div class="d-flex flex-column gap-3">
                    @if(!empty($whyChoose['features']))
                        @foreach($whyChoose['features'] as $feat)
                        <div class="d-flex gap-3 p-3 bg-white rounded-3 shadow-sm border" style="border-color: #E2E8F0 !important;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background: rgba(20, 45, 78, 0.1); color: #142D4E;">
                                <i class="fa-solid {{ $feat['icon'] ?? 'fa-circle-check' }} fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{!! $feat['title'] !!}</h6>
                                <p class="text-muted small mb-0">{!! $feat['desc'] ?? ($feat['description'] ?? '') !!}</p>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <img src="{{ !empty($whyChoose['image']) ? asset('storage/' . $whyChoose['image']) : 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1000&q=80' }}"
                         alt="Clinical Quality &amp; Standards" 
                         class="img-fluid rounded-4 shadow-lg w-100 object-fit-cover" 
                         style="max-height: 480px; border: 1px solid #E2E8F0;"
                         onerror="this.src='https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1000&q=80'">
                    <div class="position-absolute bottom-0 end-0 text-white p-4 rounded-4 shadow-lg m-3" style="background: rgba(20, 45, 78, 0.95) !important; backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15);">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-award text-warning display-6"></i>
                            <div>
                                <div class="h5 fw-bold mb-0">Tertiary Level Care</div>
                                <small class="text-white-50">Accredited Clinical Protocols</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     10. HOW IT WORKS (4-STEP PATIENT JOURNEY)
     ============================================================ --}}
<section class="section-padding py-5 bg-white">
    <div class="container py-4 text-center">
        <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="background: rgba(13, 148, 136, 0.1); color: #0D9488;">{{ $howItWorks['label'] ?? 'Seamless Experience' }}</span>
        <h2 class="fw-bold text-dark mb-2" style="color: #142D4E !important;">{{ $howItWorks['title'] ?? 'How It Works' }}</h2>
        <p class="text-muted mb-5">{{ $howItWorks['description'] ?? 'Hassle-free access to hospital consultations, diagnostics, and patient care.' }}</p>

        <div class="row g-4">
            @if(!empty($howItWorks['steps']))
                @foreach($howItWorks['steps'] as $i => $step)
                <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="{{ 100 + ($i * 100) }}">
                    <div class="step-card p-4 rounded-4 bg-light-soft border h-100" style="border-color: #E2E8F0 !important;">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" style="width: 50px; height: 50px; background: {{ $step['color'] ?? ($i % 2 == 0 ? '#142D4E' : '#0D9488') }}; font-size: 1.2rem;">
                            {{ $step['n'] ?? ($i + 1) }}
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ $step['title'] }}</h5>
                        <p class="text-muted small mb-0">{{ $step['desc'] ?? ($step['description'] ?? '') }}</p>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

{{-- ============================================================
     11. PATIENT REVIEWS & TESTIMONIALS (LIVE CAROUSEL)
     ============================================================ --}}
<section class="section-padding py-5 text-white position-relative" style="background: linear-gradient(135deg, #142D4E 0%, #0d1e35 100%);">
    <div class="container py-4">
        {{-- Section Header with Live Badge and Carousel Controls --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3" data-aos="fade-up">
            <div class="text-center text-md-start">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background: rgba(45, 212, 191, 0.15); border: 1px solid rgba(45, 212, 191, 0.3);">
                    <span class="d-inline-block rounded-circle bg-teal" style="width: 8px; height: 8px; background: #2dd4bf;"></span>
                    <span class="small fw-bold text-uppercase" style="color: #2dd4bf !important; letter-spacing: 0.5px;">Live Patient Experiences</span>
                </div>
                <h2 class="fw-bold text-white mb-2">What Our Patients Say</h2>
                <p class="text-white-50 mb-0" style="max-width: 640px; font-size: 1.05rem;">
                    Real experiences from patients and families who trusted our specialized doctors, critical care units, inpatient cabins, and automated diagnostic laboratories.
                </p>
            </div>

            {{-- Carousel Navigation Controls --}}
            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                <button type="button" class="testimonial-ctrl-btn testimonial-prev-btn" aria-label="Previous Testimonial" title="Previous Review">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button type="button" class="testimonial-ctrl-btn testimonial-play-btn" id="testimonialPlayPauseBtn" aria-label="Pause or Play Auto-scroll" title="Pause / Play Live Auto-scroll">
                    <i class="fa-solid fa-pause" id="carouselPlayPauseIcon"></i>
                </button>
                <button type="button" class="testimonial-ctrl-btn testimonial-next-btn" aria-label="Next Testimonial" title="Next Review">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>

        @if($testimonials->isNotEmpty())
        {{-- Swiper Live Carousel Container --}}
        <div class="swiper testimonialSwiper position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper py-2">
                @foreach($testimonials as $testimonial)
                <div class="swiper-slide h-auto">
                    <div class="testimonial-card-premium p-4 rounded-4 h-100 d-flex flex-column justify-content-between position-relative overflow-hidden w-100" 
                         style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); backdrop-filter: blur(12px); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);">
                        <div>
                            {{-- Top Row: Stars + Verified Badge --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="text-warning">
                                    @for($star = 1; $star <= 5; $star++)
                                        <i class="fa-solid fa-star {{ $star <= $testimonial->rating ? 'text-warning' : 'text-secondary' }} small"></i>
                                    @endfor
                                </div>
                                <span class="badge bg-success bg-opacity-20 text-white border border-success border-opacity-30 rounded-pill px-2.5 py-1 small" style="font-size: 0.72rem; color: #86efac !important;">
                                    <i class="fa-solid fa-circle-check text-success me-1"></i>Verified Patient
                                </span>
                            </div>

                            {{-- Decorative Quote Icon --}}
                            <div class="mb-2">
                                <i class="fa-solid fa-quote-left fa-2x" style="color: #2dd4bf; opacity: 0.35;"></i>
                            </div>

                            {{-- Review Text --}}
                            <p class="text-light fst-italic mb-4" style="line-height: 1.75; font-size: 0.95rem; color: #e2e8f0 !important;">
                                &ldquo;{{ $testimonial->review }}&rdquo;
                            </p>
                        </div>

                        {{-- Patient Profile Footer --}}
                        <div class="d-flex align-items-center gap-3 pt-3 border-top border-white border-opacity-15">
                            @if(!empty($testimonial->photo))
                                <img src="{{ asset('storage/' . $testimonial->photo) }}" 
                                     alt="{{ $testimonial->name }}" 
                                     class="rounded-circle object-fit-cover shadow-sm border border-2 flex-shrink-0" 
                                     style="width: 48px; height: 48px; border-color: #2dd4bf !important;"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="rounded-circle text-white fw-bold align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 48px; height: 48px; background: linear-gradient(135deg, #0D9488, #14b8a6); display: none;">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </div>
                            @else
                                <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 48px; height: 48px; background: linear-gradient(135deg, #0D9488, #14b8a6);">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h6 class="fw-bold text-white mb-0" style="font-size: 1rem;">{{ $testimonial->name }}</h6>
                                <small class="text-white-50 d-flex align-items-center gap-1 mt-0.5">
                                    <i class="fa-solid fa-location-dot small" style="color: #2dd4bf;"></i>
                                    {{ $testimonial->location ?? 'Dhaka, Bangladesh' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Live Carousel Pagination Bullets --}}
            <div class="swiper-pagination testimonial-pagination position-relative mt-4"></div>
        </div>

        {{-- Hospital Trust & Patient Satisfaction Metrics --}}
        <div class="mt-4 p-4 rounded-4" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(8px);" data-aos="fade-up">
            <div class="row g-4 text-center align-items-center">
                <div class="col-6 col-md-3 border-end border-white border-opacity-10">
                    <div class="d-flex align-items-center justify-content-center gap-1 mb-1">
                        <span class="h3 fw-bold text-white mb-0">{{ number_format($testimonials->avg('rating') ?: 4.9, 1) }}</span>
                        <div class="text-warning small">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <small class="text-white-50">{{ $testimonials->count() > 0 ? number_format($testimonials->count() * 120) . '+' : '15,000+' }} Verified Reviews</small>
                </div>
                <div class="col-6 col-md-3 border-end border-white border-opacity-10">
                    <h3 class="fw-bold mb-1" style="color: #2dd4bf;">99.4%</h3>
                    <small class="text-white-50">Clinical Satisfaction Rate</small>
                </div>
                <div class="col-6 col-md-3 border-end border-white border-opacity-10">
                    <h3 class="fw-bold text-white mb-1">100%</h3>
                    <small class="text-white-50">Online Report Delivery</small>
                </div>
                <div class="col-6 col-md-3">
                    <h3 class="fw-bold mb-1" style="color: #2dd4bf;">{{ $stats['support'] ?? '24/7' }}</h3>
                    <small class="text-white-50">Emergency &amp; Critical Care</small>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ============================================================
     12. LATEST HEALTH ARTICLES & NEWS
     ============================================================ --}}
@if($blogs->isNotEmpty())
<section class="section-padding py-5 bg-light-soft" style="background-color: #F8FAFC !important;">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="background: rgba(20, 45, 78, 0.1); color: #142D4E;">Medical Blog</span>
                <h2 class="fw-bold text-dark mb-0" style="color: #142D4E !important;">Latest Healthcare Insights</h2>
                <p class="text-muted mt-2 mb-0">Expert health advice and wellness guidance from our medical specialists.</p>
            </div>
            <a href="{{ url('/blog') }}" class="btn btn-outline-dark rounded-pill px-4 fw-semibold" style="border-color: #CBD5E1; color: #142D4E;">
                Read All Articles <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($blogs as $i => $blog)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($i+1)*100 }}">
                <div class="blog-card-modern bg-white rounded-4 shadow-sm overflow-hidden border h-100 transition-all hover-lift" style="border-color: #E2E8F0 !important;">
                    <div class="blog-img-container" style="height: 200px; overflow: hidden;">
                        @if($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-100 h-100 object-fit-cover">
                        @else
                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                <i class="fa-solid fa-newspaper fs-1 opacity-25"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2 text-muted small">
                            <span><i class="fa-regular fa-folder me-1" style="color: #0D9488;"></i>{{ $blog->category ?? 'Health' }}</span>
                            <span><i class="fa-regular fa-clock me-1"></i>{{ $blog->published_at?->format('M d, Y') ?? 'Recent' }}</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">
                            <a href="{{ route('frontend.blog.show', $blog) }}" class="text-dark text-decoration-none hover-teal">{{ $blog->title }}</a>
                        </h5>
                        <p class="text-muted small mb-3">{{ Str::limit($blog->excerpt ?? '', 90) }}</p>
                        <a href="{{ route('frontend.blog.show', $blog) }}" class="fw-bold small text-decoration-none" style="color: #0D9488;">
                            Read Full Article &rarr;
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     13. HOSPITAL LOCATION & VISITING HOURS STRIP
     ============================================================ --}}
<section class="py-5 bg-white border-top" style="border-color: #E2E8F0 !important;">
    <div class="container">
        <div class="row g-4 text-center text-md-start">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px; background: rgba(20, 45, 78, 0.1); color: #142D4E;">
                        <i class="fa-solid fa-location-dot fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Hospital Location</h6>
                        <small class="text-muted">{{ $siteSettings['site_address'] ?? '123 Health Avenue, Dhanmondi, Dhaka-1205' }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px; background: rgba(13, 148, 136, 0.1); color: #0D9488;">
                        <i class="fa-regular fa-clock fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Visiting &amp; Consultation Hours</h6>
                        <small class="text-muted">{{ $siteSettings['site_visiting_hours'] ?? ($siteSettings['visiting_hours'] ?? 'OPD: 8:00 AM – 10:00 PM | Patient Visit: 4:00 PM – 7:00 PM') }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px; background: rgba(220, 38, 38, 0.1); color: #DC2626;">
                        <i class="fa-solid fa-phone-volume fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Emergency Trauma Hotline</h6>
                        <small class="text-muted">24/7 Hotline: <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['site_phone'] ?? '01711000000') }}" class="text-danger fw-bold text-decoration-none">{{ $siteSettings['site_phone'] ?? '+880 1711 000 000' }}</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     14. FLOATING WHATSAPP BUTTON (NO UNDERLINE GUARANTEED)
     ============================================================ --}}
@php
    $waNumber = \App\Models\Setting::get('site_whatsapp', '8801711000000');
@endphp
<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waNumber) }}" 
   class="floating-wa-btn d-flex align-items-center justify-content-center text-decoration-none" 
   title="Live WhatsApp Patient Chat" 
   target="_blank" 
   rel="noopener"
   style="position: fixed; bottom: 25px; right: 25px; width: 60px; height: 60px; background: #25d366; color: #fff !important; border-radius: 50%; font-size: 2rem; z-index: 1049; transition: all 0.3s ease; text-decoration: none !important; border: none !important; outline: none !important; box-shadow: 0 8px 24px rgba(37, 211, 102, 0.45);">
    <i class="fa-brands fa-whatsapp text-white" style="text-decoration: none !important; line-height: 1; display: inline-block;"></i>
</a>

{{-- Mobile Sticky Bottom Quick Action Bar --}}
<div class="d-lg-none fixed-bottom bg-white border-top p-2 shadow-lg" style="z-index: 998;">
    <div class="container d-flex gap-2">
        <a href="{{ url('/appointment') }}" class="btn rounded-pill w-50 fw-bold py-2 text-white shadow-sm" style="background: #0D9488; font-size: 0.9rem;">
            <i class="fa-regular fa-calendar-check me-1"></i> Appoint
        </a>
        <a href="{{ url('/reports') }}" class="btn btn-outline-dark rounded-pill w-50 fw-bold py-2" style="border-color: #CBD5E1; font-size: 0.9rem;">
            <i class="fa-solid fa-file-medical me-1"></i> Reports
        </a>
    </div>
</div>

@push('styles')
<style>
/* Responsive adjustments for hero badges and shortcuts */
.quick-shortcuts-wrapper {
    margin-top: -30px;
    position: relative;
    z-index: 10;
}
@media (min-width: 992px) {
    .quick-shortcuts-wrapper {
        margin-top: -65px;
    }
}
@media (max-width: 767.98px) {
    .hero-badge-top-left {
        margin-top: 12px !important;
        margin-left: 8px !important;
        font-size: 0.75rem !important;
        padding: 6px 10px !important;
    }
    .hero-badge-bottom-right {
        margin-bottom: 12px !important;
        margin-right: 8px !important;
        padding: 8px 12px !important;
    }
    .hero-badge-bottom-left {
        margin-bottom: 12px !important;
        margin-left: 8px !important;
        padding: 6px 10px !important;
        font-size: 0.7rem !important;
    }
}
@media (min-width: 768px) {
    .hero-badge-top-left {
        margin-top: 25px;
        margin-left: -15px;
    }
    .hero-badge-bottom-right {
        margin-bottom: 25px;
        margin-right: -15px;
    }
    .hero-badge-bottom-left {
        margin-bottom: 30px;
        margin-left: -15px;
    }
}

/* Hospital ERP Redesign Utility Tokens */
.hover-lift {
    transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s ease, border-color 0.25s ease;
}
.hover-lift:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 32px rgba(20, 45, 78, 0.1) !important;
    border-color: #0D9488 !important;
}

.hover-teal:hover {
    color: #0D9488 !important;
}

/* WhatsApp Floating Button & Underline Reset */
a.floating-wa-btn, 
a.floating-wa-btn:hover, 
a.floating-wa-btn:focus, 
a.floating-wa-btn:active, 
a.floating-wa-btn:visited {
    text-decoration: none !important;
    text-decoration-line: none !important;
    -webkit-text-decoration-line: none !important;
    border-bottom: none !important;
    color: #fff !important;
    outline: none !important;
}
a.floating-wa-btn:hover {
    transform: scale(1.1) rotate(4deg);
    box-shadow: 0 12px 28px rgba(37, 211, 102, 0.55) !important;
}
a.floating-wa-btn i {
    text-decoration: none !important;
    text-decoration-line: none !important;
    border-bottom: none !important;
    display: inline-block;
}

/* Testimonial Carousel Styles */
.testimonial-card-premium {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease, border-color 0.3s ease;
}
.testimonial-card-premium:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45) !important;
    border-color: rgba(45, 212, 191, 0.45) !important;
}

.testimonialSwiper {
    width: 100%;
    padding: 10px 4px 35px 4px !important;
    overflow: hidden;
}
.testimonialSwiper .swiper-slide {
    height: auto !important;
    display: flex;
}
.testimonialSwiper .swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: rgba(255, 255, 255, 0.35);
    opacity: 1;
    transition: all 0.3s ease;
    border-radius: 6px;
    margin: 0 5px !important;
}
.testimonialSwiper .swiper-pagination-bullet-active {
    width: 30px;
    background: #2dd4bf !important;
    box-shadow: 0 0 12px rgba(45, 212, 191, 0.7);
    border-radius: 6px;
}
.testimonial-ctrl-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.08);
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s ease;
    backdrop-filter: blur(8px);
}
.testimonial-ctrl-btn:hover {
    background: #0D9488 !important;
    border-color: #2dd4bf !important;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(13, 148, 136, 0.4);
}
.testimonial-play-btn {
    color: #2dd4bf;
    border-color: rgba(45, 212, 191, 0.35);
    background: rgba(13, 148, 136, 0.15);
}
</style>
<link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper !== 'undefined') {
        const testimonialSwiper = new Swiper('.testimonialSwiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            speed: 700,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            pagination: {
                el: '.testimonial-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.testimonial-next-btn',
                prevEl: '.testimonial-prev-btn',
            },
            breakpoints: {
                640: { slidesPerView: 1, spaceBetween: 20 },
                768: { slidesPerView: 2, spaceBetween: 24 },
                1024: { slidesPerView: 3, spaceBetween: 28 },
            },
        });

        // Live Auto-scroll Play / Pause Toggle Button
        const playPauseBtn = document.getElementById('testimonialPlayPauseBtn');
        const playPauseIcon = document.getElementById('carouselPlayPauseIcon');
        let isPlaying = true;

        if (playPauseBtn && playPauseIcon) {
            playPauseBtn.addEventListener('click', function () {
                if (isPlaying) {
                    testimonialSwiper.autoplay.stop();
                    playPauseIcon.classList.remove('fa-pause');
                    playPauseIcon.classList.add('fa-play');
                    playPauseBtn.setAttribute('title', 'Resume Live Auto-scroll');
                    isPlaying = false;
                } else {
                    testimonialSwiper.autoplay.start();
                    playPauseIcon.classList.remove('fa-play');
                    playPauseIcon.classList.add('fa-pause');
                    playPauseBtn.setAttribute('title', 'Pause Live Auto-scroll');
                    isPlaying = true;
                }
            });
        }
    }
});
</script>
@endpush

@endsection
