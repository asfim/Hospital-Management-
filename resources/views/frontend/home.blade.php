@extends('layouts.frontend')

@section('title', 'DHAKA CENTRAL HOSPITAL & ADVANCED DIAGNOSTICS – 24/7 Comprehensive Healthcare')

@section('content')

{{-- ============================================================
     HERO SECTION - WORLD CLASS HEALTHCARE & 24/7 EMERGENCY
     ============================================================ --}}
<section class="hero-premium-section position-relative overflow-hidden" style="
    background: linear-gradient(135deg, #091427 0%, #0f1f38 50%, #0a2540 100%);
    @if(!empty($hero->bg_image)) 
        background-image: linear-gradient(135deg, rgba(9, 20, 39, 0.92) 0%, rgba(15, 31, 56, 0.88) 100%), url('{{ asset('storage/' . $hero->bg_image) }}'); 
        background-size: cover; 
        background-position: center; 
    @endif
    padding: 100px 0 140px 0;
">
    {{-- Ambient Glow Orbs --}}
    <div class="ambient-orb orb-teal position-absolute" style="top: -80px; left: -80px; width: 380px; height: 380px; background: radial-gradient(circle, rgba(13,148,136,0.25) 0%, transparent 70%); filter: blur(50px); pointer-events: none;"></div>
    <div class="ambient-orb orb-blue position-absolute" style="bottom: 20px; right: -50px; width: 450px; height: 450px; background: radial-gradient(circle, rgba(37,99,235,0.2) 0%, transparent 70%); filter: blur(60px); pointer-events: none;"></div>

    <div class="container position-relative" style="z-index: 3;">
        <div class="row align-items-center g-5">
            {{-- Left Hero Content --}}
            <div class="col-lg-7" data-aos="fade-right" data-aos-duration="800">
                {{-- Live Emergency Pulsing Badge --}}
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-4 border border-teal-subtle" style="background: rgba(13, 148, 136, 0.15); backdrop-filter: blur(8px); border: 1px solid rgba(45, 212, 191, 0.3);">
                    <span class="pulse-indicator"></span>
                    <span class="text-teal-bright fw-semibold small" style="color: #2dd4bf; letter-spacing: 0.5px;">
                        <i class="fa-solid fa-hospital me-1"></i> 24/7 Multi-Specialty Hospital & Emergency Trauma Center
                    </span>
                </div>

                {{-- Hero Headline --}}
                <h1 class="display-4 fw-extrabold text-white mb-3 lh-sm" style="font-weight: 800; letter-spacing: -0.5px;">
                    {!! nl2br(e($hero->title ?? "World-Class Healthcare,\nCompassion in Healing")) !!}
                </h1>

                {{-- Subtitle --}}
                <p class="text-slate-light mb-4" style="color: #cbd5e1; font-size: 1.12rem; line-height: 1.8; max-width: 580px;">
                    {!! nl2br(e($hero->subtitle ?? "Round-the-clock Emergency & Critical Care, renowned specialist physicians, modern Inpatient Cabins, and ISO-certified automated diagnostics — delivering excellence for you and your loved ones.")) !!}
                </p>

                {{-- Live Search Input --}}
                <div class="hero-search-box p-2 rounded-4 mb-4 shadow-lg border" style="background: rgba(255, 255, 255, 0.95); border-color: rgba(255, 255, 255, 0.4); max-width: 580px;">
                    <form action="{{ url('/tests') }}" method="GET" class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass text-muted fs-5 ps-3 flex-shrink-0"></i>
                        <input type="text" name="search" class="form-control border-0 shadow-none bg-transparent ps-2 text-dark" placeholder="Search tests, specialist doctors, departments..." style="font-size: 0.95rem;">
                        <button type="submit" class="btn btn-teal px-4 py-2 rounded-3 text-white fw-bold text-nowrap" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
                            Find Now
                        </button>
                    </form>
                </div>

                {{-- Key Action Buttons --}}
                <div class="d-flex flex-wrap align-items-center gap-3 mb-5">
                    <a href="{{ $hero->button_link ?? url('/appointment') }}" class="btn btn-primary-gradient px-4 py-3 rounded-pill fw-bold text-white shadow-lg text-decoration-none d-inline-flex align-items-center gap-2">
                        <i class="fa-regular fa-calendar-check fs-5"></i>
                        <span>Book Doctor Appointment</span>
                    </a>
                    <a href="tel:{{ $siteSettings['site_phone'] ?? '01711000000' }}" class="btn btn-emergency-pulse px-4 py-3 rounded-pill fw-bold text-white shadow text-decoration-none d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);">
                        <i class="fa-solid fa-truck-medical fs-5"></i>
                        <span>Emergency: 24/7 Hotline</span>
                    </a>
                </div>

                {{-- Counter Strip --}}
                <div class="row g-3 pt-3 border-top border-secondary border-opacity-25" style="max-width: 600px;">
                    <div class="col-3">
                        <div class="h3 fw-bold text-white mb-0">{{ $stats['doctors'] ?? '50+' }}</div>
                        <small class="text-muted" style="color: #94a3b8 !important;">Specialist Doctors</small>
                    </div>
                    <div class="col-3">
                        <div class="h3 fw-bold text-white mb-0">40+</div>
                        <small class="text-muted" style="color: #94a3b8 !important;">Beds & Cabins</small>
                    </div>
                    <div class="col-3">
                        <div class="h3 fw-bold text-white mb-0">{{ $stats['tests'] ?? '500+' }}</div>
                        <small class="text-muted" style="color: #94a3b8 !important;">Diagnostic Tests</small>
                    </div>
                    <div class="col-3">
                        <div class="h3 fw-bold text-teal-bright mb-0" style="color: #2dd4bf;">24/7</div>
                        <small class="text-muted" style="color: #94a3b8 !important;">ICU & Emergency</small>
                    </div>
                </div>
            </div>

            {{-- Right Hero Floating Healthcare Image & Interactive Badges --}}
            <div class="col-lg-5" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <div class="position-relative text-center">
                    {{-- Doctor Hero Image Wrapper with Ambient Glow --}}
                    <div class="hero-image-wrapper position-relative d-inline-block">
                        <img src="{{ !empty($hero->image) ? asset('storage/' . $hero->image) : asset('storage/cms/08sJHJqIoNDw4aBajEyAzjv5mp6amU1km0teG9PO.jpg') }}" 
                             alt="Hospital Specialist Physician" 
                             class="img-fluid rounded-4 shadow-2xl" 
                             style="max-height: 480px; object-fit: cover; border: 3px solid rgba(255, 255, 255, 0.2); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);">

                        {{-- Floating Badge: Specialist Team --}}
                        <div class="position-absolute top-0 start-0 translate-middle-y bg-white p-2.5 px-3 rounded-pill shadow-lg d-flex align-items-center gap-2" style="border: 1px solid #e2e8f0; margin-top: 40px; margin-left: -20px;">
                            <span class="pulse-indicator"></span>
                            <span class="text-dark fw-bold small"><i class="fa-solid fa-user-doctor text-primary me-1"></i> 50+ Doctors</span>
                        </div>

                        {{-- Floating Badge: Emergency ICU Ready --}}
                        <div class="position-absolute bottom-0 end-0 translate-middle-y bg-dark text-white p-3 rounded-4 shadow-lg text-start" style="background: rgba(15, 23, 42, 0.95) !important; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(8px); margin-bottom: 20px; margin-right: -15px;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-danger p-2 d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px;">
                                    <i class="fa-solid fa-truck-medical fs-6"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small">Emergency & ICU</div>
                                    <small class="text-white-50" style="font-size: 0.72rem;">24/7 Rapid Response</small>
                                </div>
                            </div>
                        </div>

                        {{-- Floating Badge: ISO Certified Labs --}}
                        <div class="position-absolute bottom-0 start-0 translate-middle-y bg-white p-2 px-3 rounded-pill shadow-lg d-flex align-items-center gap-2" style="border: 1px solid #e2e8f0; margin-bottom: 30px; margin-left: -15px;">
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
     HOSPITAL SERVICES STRIP (OVERLAPPING CARDS)
     ============================================================ --}}
<div class="hospital-services-strip position-relative" style="margin-top: -60px; z-index: 10;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="hospital-service-card bg-white p-4 rounded-4 shadow-sm h-100 border transition-all">
                    <div class="service-icon-box rounded-circle d-flex align-items-center justify-content-center mb-3 text-danger" style="width: 56px; height: 56px; background: rgba(225, 29, 72, 0.1);">
                        <i class="fa-solid fa-truck-medical fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">24/7 Emergency & ICU</h5>
                    <p class="text-muted small mb-3">Critical trauma care, ventilator support, resuscitation & round-the-clock ambulance dispatch.</p>
                    <a href="tel:{{ $siteSettings['site_phone'] ?? '01711000000' }}" class="fw-bold text-danger small text-decoration-none">
                        Call Emergency Hotline &rarr;
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="hospital-service-card bg-white p-4 rounded-4 shadow-sm h-100 border transition-all">
                    <div class="service-icon-box rounded-circle d-flex align-items-center justify-content-center mb-3 text-primary" style="width: 56px; height: 56px; background: rgba(37, 99, 235, 0.1);">
                        <i class="fa-solid fa-user-doctor fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Specialist OPD Clinics</h5>
                    <p class="text-muted small mb-3">Consult with professors & specialized doctors across Medicine, Surgery, Gynae, Pediatrics & more.</p>
                    <a href="{{ url('/doctors') }}" class="fw-bold text-primary small text-decoration-none">
                        View Specialist Doctors &rarr;
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="hospital-service-card bg-white p-4 rounded-4 shadow-sm h-100 border transition-all">
                    <div class="service-icon-box rounded-circle d-flex align-items-center justify-content-center mb-3 text-teal" style="width: 56px; height: 56px; background: rgba(13, 148, 136, 0.1); color: #0d9488;">
                        <i class="fa-solid fa-microscope fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Pathology & Imaging</h5>
                    <p class="text-muted small mb-3">Automated biochemistry, 3T MRI, 128-Slice CT, 4D Ultrasonography & digital X-ray with fast reports.</p>
                    <a href="{{ url('/tests') }}" class="fw-bold text-teal small text-decoration-none" style="color: #0d9488;">
                        Explore Diagnostic Tests &rarr;
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
                <div class="hospital-service-card bg-white p-4 rounded-4 shadow-sm h-100 border transition-all">
                    <div class="service-icon-box rounded-circle d-flex align-items-center justify-content-center mb-3 text-success" style="width: 56px; height: 56px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fa-solid fa-bed-pulse fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Inpatient Wards & Cabins</h5>
                    <p class="text-muted small mb-3">Air-conditioned VIP cabins, specialized general wards, central oxygen & dedicated 24-hour nursing care.</p>
                    <a href="{{ url('/appointment') }}" class="fw-bold text-success small text-decoration-none" style="color: #10b981;">
                        Admission Inquiries &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     HOSPITAL DEPARTMENTS & CLINICAL SPECIALTIES
     ============================================================ --}}
<section class="section-padding py-5 mt-5">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2">Centers of Excellence</span>
                <h2 class="fw-bold text-dark mb-0">Our Clinical Departments</h2>
                <p class="text-muted mt-2 mb-0">Comprehensive medical care backed by specialized multi-disciplinary doctor teams.</p>
            </div>
            <a href="{{ url('/departments') }}" class="btn btn-outline-primary rounded-pill px-4 fw-semibold">
                Explore All Departments <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($departments as $i => $dept)
            <div class="col-xl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-delay="{{ ($i+1)*60 }}">
                <a href="{{ url('/departments/' . ($dept->slug ?? '')) }}" class="text-decoration-none">
                    <div class="department-card-premium bg-white p-4 rounded-4 shadow-sm text-center h-100 border transition-all">
                        <div class="dept-icon-circle mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 64px; height: 64px; background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                            <i class="fa-solid {{ $dept->icon ?? 'fa-stethoscope' }} fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ $dept->name }}</h5>
                        <p class="text-muted small mb-3">{{ Str::limit($dept->description ?? 'Specialized tertiary healthcare and diagnostic services.', 65) }}</p>
                        <div class="d-flex justify-content-center gap-3 pt-3 border-top text-muted small">
                            <span><i class="fa-solid fa-user-doctor text-primary me-1"></i>{{ $dept->doctors_count ?? 0 }} Doctors</span>
                            <span><i class="fa-solid fa-vial text-teal me-1" style="color: #0d9488;"></i>{{ $dept->tests_count ?? 0 }} Tests</span>
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
     24/7 EMERGENCY & AMBULANCE DISPATCH HOTLINE BANNER
     ============================================================ --}}
<section class="py-5 bg-gradient-navy text-white position-relative overflow-hidden my-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);">
    <div class="container position-relative py-3" style="z-index: 2;">
        <div class="row align-items-center g-4">
            <div class="col-lg-8" data-aos="fade-right">
                <div class="d-inline-flex align-items-center gap-2 bg-danger bg-opacity-25 px-3 py-1 rounded-pill text-danger border border-danger border-opacity-25 small fw-bold mb-3">
                    <i class="fa-solid fa-bell fa-shake"></i> Critical Emergency Response
                </div>
                <h3 class="fw-extrabold text-white mb-2">Medical Emergency or Ambulance Needed?</h3>
                <p class="text-white-50 mb-0" style="font-size: 1.05rem;">Our fleet of ICU & Cardiac Support Ambulances with certified paramedics is stationed across Dhaka for prompt dispatch.</p>
            </div>
            <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-3">
                    <a href="tel:{{ $siteSettings['site_phone'] ?? '01711000000' }}" class="btn btn-danger btn-lg rounded-pill px-4 py-3 fw-bold d-inline-flex align-items-center justify-content-center gap-2 shadow">
                        <i class="fa-solid fa-phone-volume"></i>
                        <span>{{ $siteSettings['site_phone'] ?? '+880 1711 000 000' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     POPULAR DIAGNOSTIC TESTS & PACKAGES
     ============================================================ --}}
<section class="section-padding py-5 bg-light-soft">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <span class="badge bg-teal bg-opacity-10 text-teal px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="background: rgba(13,148,136,0.1); color: #0d9488;">Laboratory & Radiology</span>
                <h2 class="fw-bold text-dark mb-0">Popular Diagnostic Tests</h2>
                <p class="text-muted mt-2 mb-0">High-accuracy automated testing with same-day digital report delivery.</p>
            </div>
            <a href="{{ url('/tests') }}" class="btn btn-outline-teal rounded-pill px-4 fw-semibold" style="border-color: #0d9488; color: #0d9488;">
                View All Tests <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($tests->take(6) as $i => $test)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($i+1)*80 }}">
                <div class="test-card-modern bg-white rounded-4 p-4 shadow-sm h-100 border d-flex flex-column justify-content-between transition-all">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-light text-secondary border px-2.5 py-1.5 rounded-pill small">
                                <i class="fa-solid fa-flask-vial me-1 text-teal" style="color: #0d9488;"></i> {{ $test->category->name ?? 'Pathology' }}
                            </span>
                            <span class="text-teal fw-bold fs-5" style="color: #0d9488;">৳{{ number_format($test->price, 0) }}</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">
                            <a href="{{ url('/tests/'.$test->id) }}" class="text-dark text-decoration-none hover-primary">{{ $test->name }}</a>
                        </h5>
                        <p class="text-muted small mb-3">{{ Str::limit($test->description ?? 'Reliable laboratory test with automated analyzer verification.', 80) }}</p>
                    </div>
                    <div class="d-flex gap-2 pt-3 border-top">
                        <a href="{{ url('/tests/'.$test->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 flex-grow-1">Details</a>
                        <a href="{{ url('/appointment') }}?test={{ $test->id }}" class="btn btn-sm btn-primary rounded-pill px-4 fw-semibold flex-grow-1" style="background: #0d9488; border-color: #0d9488;">Book Test</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">No diagnostic tests available.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================
     FEATURED SPECIALIST DOCTORS
     ============================================================ --}}
<section class="section-padding py-5 bg-white">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2">Medical Team</span>
                <h2 class="fw-bold text-dark mb-0">Our Specialist Consultants</h2>
                <p class="text-muted mt-2 mb-0">Highly qualified professors and doctors providing expert care.</p>
            </div>
            <a href="{{ url('/doctors') }}" class="btn btn-outline-primary rounded-pill px-4 fw-semibold">
                All Doctors Directory <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($doctors as $i => $doc)
            <div class="col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ ($i+1)*100 }}">
                <div class="doctor-card-modern bg-white rounded-4 shadow-sm overflow-hidden border h-100 d-flex flex-column transition-all">
                    <div class="doc-avatar-container position-relative bg-light text-center" style="height: 250px; overflow: hidden;">
                        <img src="{{ $doc->photo ? asset('storage/'.$doc->photo) : 'https://images.unsplash.com/photo-1594824436998-058a23116fc7?auto=format&fit=crop&w=500&q=80' }}" alt="{{ $doc->name }}" class="w-100 h-100 object-fit-cover">
                        <span class="badge bg-primary position-absolute bottom-0 start-0 m-3 rounded-pill px-3 py-1.5 shadow-sm">
                            {{ $doc->department ? $doc->department->name : 'Consultant' }}
                        </span>
                    </div>
                    <div class="p-4 text-center d-flex flex-column flex-grow-1 justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">{{ $doc->name }}</h5>
                            <div class="text-muted small mb-2">{{ $doc->qualification ?? 'MBBS' }}</div>
                            <div class="badge bg-light text-secondary border px-2.5 py-1 small mb-3">
                                <i class="fa-solid fa-stethoscope text-primary me-1"></i>{{ $doc->specialization ?? 'Specialist' }}
                            </div>
                        </div>
                        <div class="pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-3 text-muted small">
                                <span>Chamber Fee:</span>
                                <strong class="text-dark fs-6">৳{{ number_format($doc->consultation_fee ?? 0, 0) }}</strong>
                            </div>
                            <a href="{{ url('/appointment') }}?doctor={{ $doc->id }}" class="btn btn-primary rounded-pill w-100 fw-bold py-2" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                                <i class="fa-regular fa-calendar-check me-1"></i> Book Chamber
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
     HOSPITAL INFRASTRUCTURE & AMENITIES (WHY CHOOSE US)
     ============================================================ --}}
<section class="section-padding py-5 bg-light-soft">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <img src="{{ !empty($whyChoose['image']) ? asset('storage/' . $whyChoose['image']) : asset('storage/cms/ZrjUOCnrPbxzgKvSCkPn8fOQMSkGKXLW0MGqrDkH.webp') }}"
                         alt="Hospital Infrastructure" class="img-fluid rounded-4 shadow-lg w-100 object-fit-cover" style="max-height: 480px;">
                    <div class="position-absolute bottom-0 end-0 bg-dark text-white p-4 rounded-4 shadow-lg m-3" style="background: rgba(15, 23, 42, 0.95) !important; backdrop-filter: blur(8px);">
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
            <div class="col-lg-6" data-aos="fade-left">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2">Hospital Standards</span>
                <h2 class="fw-bold text-dark mb-3">Why Patients Trust Dhaka Central Hospital</h2>
                <p class="text-muted mb-4">We merge clinical expertise with world-class medical engineering to deliver safe, effective, and patient-centered hospital care.</p>

                <div class="d-flex flex-column gap-3">
                    <div class="d-flex gap-3 p-3 bg-white rounded-3 shadow-sm border">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-bed-pulse fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">State-of-the-Art Inpatient Cabins & ICU</h6>
                            <p class="text-muted small mb-0">Spacious VIP cabins, dedicated ICU, CCU & NICU beds with 24-hour vital monitoring.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 p-3 bg-white rounded-3 shadow-sm border">
                        <div class="rounded-circle bg-teal bg-opacity-10 text-teal d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background: rgba(13,148,136,0.1); color: #0d9488;">
                            <i class="fa-solid fa-microscope fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Fully Automated Pathology & 3T MRI</h6>
                            <p class="text-muted small mb-0">Zero manual error rate with robotic analyzers, 128-Slice CT scan, and digital X-ray.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 p-3 bg-white rounded-3 shadow-sm border">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-droplet fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">24/7 Central Pharmacy & Blood Bank</h6>
                            <p class="text-muted small mb-0">Genuine prescription medicines dispensed instantly with complete blood unit storage.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     HOW IT WORKS (4-STEP PATIENT JOURNEY)
     ============================================================ --}}
<section class="section-padding py-5 bg-white">
    <div class="container py-4 text-center">
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2">Seamless Experience</span>
        <h2 class="fw-bold text-dark mb-2">How It Works</h2>
        <p class="text-muted mb-5">Hassle-free access to hospital consultations, diagnostics, and patient care.</p>

        <div class="row g-4">
            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card p-4 rounded-4 bg-light-soft border h-100">
                    <div class="step-badge-number mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" style="width: 50px; height: 50px; background: linear-gradient(135deg, #2563eb, #1d4ed8); font-size: 1.2rem;">
                        1
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Choose Service</h5>
                    <p class="text-muted small mb-0">Select your preferred doctor, diagnostic test, or specialized health package.</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card p-4 rounded-4 bg-light-soft border h-100">
                    <div class="step-badge-number mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" style="width: 50px; height: 50px; background: linear-gradient(135deg, #0d9488, #0f766e); font-size: 1.2rem;">
                        2
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Schedule Slot</h5>
                    <p class="text-muted small mb-0">Pick your convenient date and time online or request home sample pickup.</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="step-card p-4 rounded-4 bg-light-soft border h-100">
                    <div class="step-badge-number mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b, #d97706); font-size: 1.2rem;">
                        3
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Consult & Care</h5>
                    <p class="text-muted small mb-0">Visit our doctor chambers or inpatient hospital wards for personalized treatment.</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
                <div class="step-card p-4 rounded-4 bg-light-soft border h-100">
                    <div class="step-badge-number mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #059669); font-size: 1.2rem;">
                        4
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Get Digital Report</h5>
                    <p class="text-muted small mb-0">Receive SMS notifications and download verified PDF diagnostic reports online.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     PATIENT REVIEWS & TESTIMONIALS (LIVE CAROUSEL)
     ============================================================ --}}
<section class="section-padding py-5 bg-gradient-navy text-white position-relative" style="background: linear-gradient(135deg, #091427 0%, #0f1f38 100%);">
    <div class="container py-4">
        {{-- Section Header with Live Badge and Carousel Controls --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3" data-aos="fade-up">
            <div class="text-center text-md-start">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background: rgba(45, 212, 191, 0.15); border: 1px solid rgba(45, 212, 191, 0.3);">
                    <span class="pulse-indicator"></span>
                    <span class="text-teal small fw-bold text-uppercase" style="color: #2dd4bf !important; letter-spacing: 0.5px;">Live Patient Experiences</span>
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
                                <div class="rounded-circle text-white fw-bold align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 48px; height: 48px; background: linear-gradient(135deg, #0d9488, #14b8a6); display: none;">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </div>
                            @else
                                <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 48px; height: 48px; background: linear-gradient(135deg, #0d9488, #14b8a6);">
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
                        <span class="h3 fw-bold text-white mb-0">4.9</span>
                        <div class="text-warning small">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <small class="text-white-50">15,000+ Verified Reviews</small>
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
                    <h3 class="fw-bold mb-1" style="color: #2dd4bf;">24/7</h3>
                    <small class="text-white-50">Emergency & Critical Care</small>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ============================================================
     LATEST HEALTH ARTICLES & NEWS
     ============================================================ --}}
@if($blogs->isNotEmpty())
<section class="section-padding py-5 bg-light-soft">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2">Health Articles</span>
                <h2 class="fw-bold text-dark mb-0">Latest Medical Insights</h2>
                <p class="text-muted mt-2 mb-0">Expert health advice and wellness guidance from our physicians.</p>
            </div>
            <a href="{{ url('/blog') }}" class="btn btn-outline-primary rounded-pill px-4 fw-semibold">
                Read All Articles <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($blogs as $i => $blog)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($i+1)*100 }}">
                <div class="blog-card-modern bg-white rounded-4 shadow-sm overflow-hidden border h-100 transition-all">
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
                            <span><i class="fa-regular fa-folder text-primary me-1"></i>{{ $blog->category ?? 'Health' }}</span>
                            <span><i class="fa-regular fa-clock me-1"></i>{{ $blog->published_at?->format('M d, Y') ?? 'Recent' }}</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">
                            <a href="{{ route('frontend.blog.show', $blog) }}" class="text-dark text-decoration-none hover-primary">{{ $blog->title }}</a>
                        </h5>
                        <p class="text-muted small mb-3">{{ Str::limit($blog->excerpt ?? '', 90) }}</p>
                        <a href="{{ route('frontend.blog.show', $blog) }}" class="fw-bold text-primary small text-decoration-none">
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

{{-- WhatsApp Floating Quick Button --}}
@php
    $waNumber = \App\Models\Setting::get('site_whatsapp', '8801711000000');
@endphp
<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waNumber) }}" class="floating-wa-btn d-flex align-items-center justify-content-center shadow-lg text-decoration-none" title="Live WhatsApp Chat" target="_blank" style="position: fixed; bottom: 25px; right: 25px; width: 60px; height: 60px; background: #25d366; color: #fff; border-radius: 50%; font-size: 2rem; z-index: 999; transition: all 0.3s ease; text-decoration: none !important;">
    <i class="fa-brands fa-whatsapp text-white" style="text-decoration: none !important; line-height: 1;"></i>
</a>

{{-- Mobile Sticky Bottom Action Bar --}}
<div class="d-lg-none fixed-bottom bg-white border-top p-2 shadow-lg" style="z-index: 998;">
    <div class="container d-flex gap-2">
        <a href="{{ url('/appointment') }}" class="btn btn-primary rounded-pill w-50 fw-bold py-2">
            <i class="fa-regular fa-calendar-check me-1"></i> Appointment
        </a>
        <a href="{{ url('/reports') }}" class="btn btn-outline-primary rounded-pill w-50 fw-bold py-2">
            <i class="fa-solid fa-file-medical me-1"></i> Reports
        </a>
    </div>
</div>

@push('styles')
<style>
/* Micro-interaction & Polish Styles */
.fw-extrabold { font-weight: 800; }
.text-teal { color: #0d9488 !important; }
.bg-teal { background-color: #0d9488 !important; }
.bg-light-soft { background-color: #f8fafc !important; }

/* Pulse Indicator */
.pulse-indicator {
    width: 10px;
    height: 10px;
    background-color: #2dd4bf;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.7);
    animation: pulsing 1.8s infinite;
}
@keyframes pulsing {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(45, 212, 191, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(45, 212, 191, 0); }
}

/* Hero Quick Tile */
.hero-quick-tile {
    background: rgba(255, 255, 255, 0.07);
    border: 1px solid rgba(255, 255, 255, 0.12);
    transition: all 0.25s ease;
}
.hero-quick-tile:hover {
    background: rgba(255, 255, 255, 0.16);
    transform: translateX(4px);
    border-color: rgba(255, 255, 255, 0.3);
}

/* Hover effects */
.transition-all { transition: all 0.3s ease; }
.hospital-service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 35px rgba(15, 23, 42, 0.08) !important;
    border-color: #0d9488 !important;
}

.department-card-premium:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 35px rgba(37, 99, 235, 0.1) !important;
    border-color: #2563eb !important;
}
.department-card-premium:hover .dept-icon-circle {
    background: #2563eb !important;
    color: #fff !important;
}

.test-card-modern:hover, .doctor-card-modern:hover, .blog-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 35px rgba(15, 23, 42, 0.09) !important;
}

.floating-wa-btn {
    text-decoration: none !important;
}
.floating-wa-btn:hover,
.floating-wa-btn:focus,
.floating-wa-btn:active,
.floating-wa-btn:visited {
    text-decoration: none !important;
    color: #fff !important;
    outline: none !important;
}
.floating-wa-btn i {
    text-decoration: none !important;
}
.floating-wa-btn:hover {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 12px 28px rgba(37, 211, 102, 0.45) !important;
}

.hover-primary:hover {
    color: #2563eb !important;
}

/* Testimonial Card Micro-interactions */
.testimonial-card-premium {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease, border-color 0.3s ease;
}
.testimonial-card-premium:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45) !important;
    border-color: rgba(45, 212, 191, 0.45) !important;
}

/* Swiper Live Carousel Styles */
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
    width: 44px;
    height: 44px;
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
    background: #0d9488 !important;
    border-color: #2dd4bf !important;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(13, 148, 136, 0.4);
}
.testimonial-ctrl-btn:active {
    transform: translateY(0);
}
.testimonial-play-btn {
    color: #2dd4bf;
    border-color: rgba(45, 212, 191, 0.35);
    background: rgba(13, 148, 136, 0.15);
}
.testimonial-play-btn:hover {
    background: rgba(45, 212, 191, 0.3) !important;
    color: #fff !important;
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
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 24,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 28,
                },
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
                    playPauseBtn.classList.remove('testimonial-play-btn');
                    playPauseBtn.style.color = '#fff';
                    isPlaying = false;
                } else {
                    testimonialSwiper.autoplay.start();
                    playPauseIcon.classList.remove('fa-play');
                    playPauseIcon.classList.add('fa-pause');
                    playPauseBtn.setAttribute('title', 'Pause Live Auto-scroll');
                    playPauseBtn.classList.add('testimonial-play-btn');
                    playPauseBtn.style.color = '#2dd4bf';
                    isPlaying = true;
                }
            });
        }
    }
});
</script>
@endpush

@endsection
