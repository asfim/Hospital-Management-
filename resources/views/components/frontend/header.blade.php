<!-- ================================================================
     FIXED HEADER WRAPPER (Houses Topbar + Navbar smoothly)
     ================================================================ -->
<header class="header-fixed-wrapper fixed-top shadow-sm" id="siteHeader" style="background: #ffffff; z-index: 1040;">

    <!-- TOPBAR (Deep Navy & Medical Teal) -->
    <div class="site-topbar d-none d-lg-block" style="background: #142D4E; border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 0.82rem;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between py-1.5" style="min-height: 36px;">
                {{-- Left: Hotline & Email & Hours --}}
                <div class="d-flex align-items-center gap-3">
                    <div class="d-inline-flex align-items-center gap-1.5">
                        <span class="d-inline-block rounded-circle bg-danger" style="width: 7px; height: 7px; box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.4);"></span>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['site_phone'] ?? '+8801711000000') }}" class="text-white text-decoration-none fw-bold" title="24/7 Hospital Emergency Hotline">
                            <i class="fa-solid fa-phone-volume text-danger me-1"></i>
                            <span class="text-danger fw-semibold">24/7 Emergency:</span> {{ $siteSettings['site_phone'] ?? '+880 1711 000 000' }}
                        </a>
                    </div>

                    <span class="text-white-50">|</span>

                    <a href="mailto:{{ $siteSettings['site_email'] ?? 'info@hospital.com' }}" class="text-white-50 text-decoration-none hover-white">
                        <i class="fa-regular fa-envelope me-1" style="color: #2dd4bf;"></i> {{ $siteSettings['site_email'] ?? 'info@hospital.com' }}
                    </a>

                    <span class="text-white-50">|</span>

                    <span class="text-white-50">
                        <i class="fa-regular fa-clock me-1" style="color: #2dd4bf;"></i> OPD: 8:00 AM – 10:00 PM | Trauma: 24/7
                    </span>
                </div>

                {{-- Right: Reports & Location & Socials --}}
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ url('/reports') }}" class="text-white-50 text-decoration-none hover-white small">
                        <i class="fa-solid fa-file-medical me-1" style="color: #2dd4bf;"></i> Online Reports
                    </a>
                    <span class="text-white-50">|</span>
                    <span class="text-white-50 small">
                        <i class="fa-solid fa-location-dot me-1" style="color: #2dd4bf;"></i> Dhaka, BD
                    </span>
                    <div class="d-inline-flex align-items-center gap-2 ms-1">
                        <a href="#" class="text-white-50 hover-white small" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="text-white-50 hover-white small" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="text-white-50 hover-white small" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN NAVBAR -->
    <nav class="navbar navbar-expand-lg main-header py-2 bg-white" id="mainNavbar">
        <div class="container">

            <!-- Hospital Logo & Brand -->
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none me-auto me-lg-3 py-0" href="{{ url('/') }}">
                @if(!empty($siteSettings['site_logo']))
                    <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'Hospital' }}" class="site-logo-img" style="height: 38px; max-height: 42px; object-fit: contain;">
                @else
                    <div class="d-flex align-items-center justify-content-center rounded-3 text-white flex-shrink-0 shadow-sm" style="width: 38px; height: 38px; background: linear-gradient(135deg, #142D4E 0%, #0D9488 100%);">
                        <i class="fa-solid fa-hospital-user fs-5"></i>
                    </div>
                    <div class="lh-1">
                        <span class="fw-bold d-block text-truncate" style="color: #142D4E; font-size: clamp(0.95rem, 3.8vw, 1.25rem); letter-spacing: -0.3px; max-width: 170px;">{{ $siteSettings['site_name'] ?? 'Dhaka Central' }}</span>
                        <small class="text-uppercase fw-semibold d-block text-truncate" style="color: #0D9488; font-size: 0.62rem; letter-spacing: 0.05em; max-width: 170px;">Hospital &amp; Diagnostics</small>
                    </div>
                @endif
            </a>

            <!-- Mobile Header Quick Actions & Hamburger -->
            <div class="d-flex align-items-center gap-1.5 d-lg-none flex-shrink-0">
                <button class="btn btn-link text-dark p-1.5 rounded-circle" data-bs-toggle="modal" data-bs-target="#searchModal" title="Search">
                    <i class="fa-solid fa-magnifying-glass fs-5"></i>
                </button>
                <a href="{{ url('/appointment') }}" class="btn btn-sm rounded-pill px-2.5 px-sm-3 py-1.5 fw-bold text-white d-inline-flex align-items-center shadow-sm" style="background: #0D9488; font-size: 0.78rem;">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span class="d-none d-sm-inline ms-1">Book</span>
                </a>
                <button class="navbar-toggler border-0 shadow-none p-1 ms-0.5" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars fs-4" style="color: #142D4E;"></i>
                </button>
            </div>

            <!-- Desktop Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-center">

                    {{-- Home --}}
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-2.5 py-2 {{ request()->is('/') ? 'active text-teal' : '' }}" href="{{ url('/') }}" style="color: #1E293B; font-size: 0.9rem; white-space: nowrap;">Home</a>
                    </li>

                    {{-- About Us --}}
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-2.5 py-2 {{ request()->is('about') ? 'active text-teal' : '' }}" href="{{ url('/about') }}" style="color: #1E293B; font-size: 0.9rem; white-space: nowrap;">About Us</a>
                    </li>

                    {{-- Clinical Departments Hover Dropdown --}}
                    <li class="nav-item nav-hover-dropdown">
                        <a class="nav-link fw-semibold px-2.5 py-2 d-flex align-items-center gap-1 {{ request()->is('departments*') ? 'active text-teal' : '' }}" href="{{ url('/departments') }}" style="color: #1E293B; font-size: 0.9rem; white-space: nowrap;">
                            Departments <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.65rem;"></i>
                        </a>
                        <div class="hover-dropdown-menu" style="min-width: 480px; padding: 1.25rem;">
                            <div class="row g-3">
                                <div class="col-6">
                                    <span class="dropdown-section-label fw-bold text-uppercase mb-2 d-block" style="font-size: 0.72rem; color: #0D9488; letter-spacing: 0.05em;">Clinical Specialties</span>
                                    <a class="dropdown-item py-1.5 px-2 rounded-2" href="{{ url('/departments/cardiology') }}">
                                        <i class="fa-solid fa-heart-pulse text-danger me-2"></i> Cardiology &amp; CCU
                                    </a>
                                    <a class="dropdown-item py-1.5 px-2 rounded-2" href="{{ url('/departments/neurology') }}">
                                        <i class="fa-solid fa-brain text-primary me-2"></i> Neurology &amp; Stroke
                                    </a>
                                    <a class="dropdown-item py-1.5 px-2 rounded-2" href="{{ url('/departments/orthopedics') }}">
                                        <i class="fa-solid fa-bone text-warning me-2"></i> Orthopedics &amp; Trauma
                                    </a>
                                    <a class="dropdown-item py-1.5 px-2 rounded-2" href="{{ url('/departments/pediatrics') }}">
                                        <i class="fa-solid fa-baby text-info me-2"></i> Pediatrics &amp; NICU
                                    </a>
                                </div>
                                <div class="col-6 border-start ps-3">
                                    <span class="dropdown-section-label fw-bold text-uppercase mb-2 d-block" style="font-size: 0.72rem; color: #142D4E; letter-spacing: 0.05em;">Surgical &amp; Diagnostics</span>
                                    <a class="dropdown-item py-1.5 px-2 rounded-2" href="{{ url('/departments/surgery') }}">
                                        <i class="fa-solid fa-stethoscope text-success me-2"></i> General Surgery
                                    </a>
                                    <a class="dropdown-item py-1.5 px-2 rounded-2" href="{{ url('/departments/gynecology') }}">
                                        <i class="fa-solid fa-venus text-danger me-2"></i> Gynecology &amp; Obs
                                    </a>
                                    <a class="dropdown-item py-1.5 px-2 rounded-2" href="{{ url('/departments/nephrology') }}">
                                        <i class="fa-solid fa-hand-holding-droplet text-primary me-2"></i> Nephrology &amp; Dialysis
                                    </a>
                                    <div class="dropdown-divider my-2"></div>
                                    <a class="dropdown-item py-1.5 px-2 rounded-2 fw-bold text-teal" href="{{ url('/departments') }}" style="color: #0D9488 !important;">
                                        <i class="fa-solid fa-grid-2 me-2"></i> View All Departments &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>

                    {{-- Our Doctors --}}
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-2.5 py-2 {{ request()->is('doctors*') ? 'active text-teal' : '' }}" href="{{ url('/doctors') }}" style="color: #1E293B; font-size: 0.9rem; white-space: nowrap;">Our Doctors</a>
                    </li>

                    {{-- Hospital Services Hover Dropdown --}}
                    <li class="nav-item nav-hover-dropdown">
                        <a class="nav-link fw-semibold px-2.5 py-2 d-flex align-items-center gap-1 {{ request()->is('services*') ? 'active text-teal' : '' }}" href="#hospital-services" style="color: #1E293B; font-size: 0.9rem; white-space: nowrap;">
                            Services <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.65rem;"></i>
                        </a>
                        <div class="hover-dropdown-menu" style="min-width: 260px; padding: 0.9rem;">
                            <a class="dropdown-item py-2 px-2.5 rounded-2 d-flex align-items-center" href="#hospital-services">
                                <i class="fa-solid fa-truck-medical text-danger me-2 fs-6"></i>
                                <div>
                                    <strong class="d-block text-dark small">24/7 Emergency &amp; ICU</strong>
                                    <small class="text-muted" style="font-size: 0.72rem;">Critical trauma care</small>
                                </div>
                            </a>
                            <a class="dropdown-item py-2 px-2.5 rounded-2 d-flex align-items-center" href="#hospital-facilities">
                                <i class="fa-solid fa-bed-pulse text-primary me-2 fs-6"></i>
                                <div>
                                    <strong class="d-block text-dark small">Inpatient Cabins &amp; Wards</strong>
                                    <small class="text-muted" style="font-size: 0.72rem;">AC VIP cabins &amp; nursing</small>
                                </div>
                            </a>
                            <a class="dropdown-item py-2 px-2.5 rounded-2 d-flex align-items-center" href="#hospital-facilities">
                                <i class="fa-solid fa-shield-virus text-success me-2 fs-6"></i>
                                <div>
                                    <strong class="d-block text-dark small">Operation Theatre (OT)</strong>
                                    <small class="text-muted" style="font-size: 0.72rem;">Modular surgical theaters</small>
                                </div>
                            </a>
                            <a class="dropdown-item py-2 px-2.5 rounded-2 d-flex align-items-center" href="{{ url('/pharmacy') }}">
                                <i class="fa-solid fa-pills text-warning me-2 fs-6"></i>
                                <div>
                                    <strong class="d-block text-dark small">24/7 Central Pharmacy</strong>
                                    <small class="text-muted" style="font-size: 0.72rem;">Genuine medication dispensing</small>
                                </div>
                            </a>
                            <a class="dropdown-item py-2 px-2.5 rounded-2 d-flex align-items-center" href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['site_phone'] ?? '01711000000') }}">
                                <i class="fa-solid fa-ambulance text-danger me-2 fs-6"></i>
                                <div>
                                    <strong class="d-block text-dark small">Ambulance Dispatch</strong>
                                    <small class="text-muted" style="font-size: 0.72rem;">Prompt cardiac ambulance</small>
                                </div>
                            </a>
                        </div>
                    </li>

                    {{-- Diagnostic Hover Dropdown --}}
                    <li class="nav-item nav-hover-dropdown">
                        <a class="nav-link fw-semibold px-2.5 py-2 d-flex align-items-center gap-1 {{ request()->is('tests*','packages*','reports*') ? 'active text-teal' : '' }}" href="{{ url('/tests') }}" style="color: #1E293B; font-size: 0.9rem; white-space: nowrap;">
                            Diagnostic <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.65rem;"></i>
                        </a>
                        <div class="hover-dropdown-menu" style="min-width: 250px; padding: 0.9rem;">
                            <a class="dropdown-item py-2 px-2.5 rounded-2" href="{{ url('/tests') }}">
                                <i class="fa-solid fa-vials text-teal me-2" style="color: #0D9488;"></i> All Diagnostic Tests
                            </a>
                            <a class="dropdown-item py-2 px-2.5 rounded-2" href="{{ url('/packages') }}">
                                <i class="fa-solid fa-box-open text-primary me-2"></i> Health Checkup Packages
                            </a>
                            <a class="dropdown-item py-2 px-2.5 rounded-2" href="{{ url('/home-collection') }}">
                                <i class="fa-solid fa-house-chimney-medical text-success me-2"></i> Home Sample Pickup
                            </a>
                            <a class="dropdown-item py-2 px-2.5 rounded-2" href="{{ url('/reports') }}">
                                <i class="fa-solid fa-file-pdf text-danger me-2"></i> Online Digital Reports
                            </a>
                            <a class="dropdown-item py-2 px-2.5 rounded-2" href="{{ url('/pricing') }}">
                                <i class="fa-solid fa-tags text-warning me-2"></i> Transparent Price List
                            </a>
                        </div>
                    </li>

                    {{-- Hospital Facilities --}}
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-2.5 py-2" href="#hospital-facilities" style="color: #1E293B; font-size: 0.9rem; white-space: nowrap;">Facilities</a>
                    </li>

                    {{-- Contact --}}
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-2.5 py-2 {{ request()->is('contact*') ? 'active text-teal' : '' }}" href="{{ url('/contact') }}" style="color: #1E293B; font-size: 0.9rem; white-space: nowrap;">Contact</a>
                    </li>

                </ul>

                {{-- Right Actions: Search + Login + Book Appointment CTA --}}
                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <button class="btn btn-light rounded-circle p-2 text-dark border-0" data-bs-toggle="modal" data-bs-target="#searchModal" title="Search medical directory" style="width: 38px; height: 38px;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <a href="{{ url('/login') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5" style="border-color: #CBD5E1; color: #142D4E; font-size: 0.85rem; white-space: nowrap;">
                        <i class="fa-regular fa-user"></i>
                        <span>Login</span>
                    </a>
                    <a href="{{ url('/appointment') }}" class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-bold text-white d-inline-flex align-items-center gap-1.5 shadow-sm" style="background: linear-gradient(135deg, #0D9488 0%, #0f766e 100%); font-size: 0.88rem; border: none; white-space: nowrap;">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Appointment</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- ================================================================
     MOBILE OFFCANVAS
     ================================================================ -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header border-bottom py-3" style="background: #142D4E; color: #fff;">
        <a class="d-flex align-items-center gap-2 text-decoration-none text-white" href="{{ url('/') }}">
            @if(!empty($siteSettings['site_logo']))
                <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'Hospital' }}" style="height: 40px; max-width: 180px; object-fit: contain;">
            @else
                <i class="fa-solid fa-hospital-user text-teal fs-3" style="color: #2dd4bf;"></i>
                <div>
                    <h6 class="fw-bold mb-0 text-white">{{ $siteSettings['site_name'] ?? 'Dhaka Central Hospital' }}</h6>
                    <small class="text-white-50" style="font-size: .68rem; letter-spacing: .05em;">24/7 HEALTHCARE &amp; TRAUMA</small>
                </div>
            @endif
        </a>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0 py-0">
        <div class="accordion border-0" id="mobileAccordion">

            <div class="border-bottom">
                <a class="nav-link px-4 py-3 fw-semibold text-dark" href="{{ url('/') }}">
                    <i class="fa-solid fa-house me-2 text-muted"></i> Home
                </a>
            </div>
            <div class="border-bottom">
                <a class="nav-link px-4 py-3 fw-semibold text-dark" href="{{ url('/about') }}">
                    <i class="fa-solid fa-circle-info me-2 text-muted"></i> About Hospital
                </a>
            </div>

            <!-- Departments Accordion -->
            <div class="accordion-item rounded-0 border-0 border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed px-4 py-3 fw-semibold bg-white text-dark shadow-none" type="button"
                            data-bs-toggle="collapse" data-bs-target="#mobDepts">
                        <i class="fa-solid fa-stethoscope me-2 text-muted"></i> Clinical Departments
                    </button>
                </h2>
                <div id="mobDepts" class="accordion-collapse collapse" data-bs-parent="#mobileAccordion">
                    <div class="accordion-body pt-0 ps-4 pb-3">
                        <a class="d-block text-muted py-1.5" href="{{ url('/departments') }}">All Clinical Departments</a>
                        <a class="d-block text-muted py-1.5" href="{{ url('/departments/cardiology') }}">Cardiology &amp; CCU</a>
                        <a class="d-block text-muted py-1.5" href="{{ url('/departments/neurology') }}">Neurology &amp; Stroke Unit</a>
                        <a class="d-block text-muted py-1.5" href="{{ url('/departments/orthopedics') }}">Orthopedics &amp; Trauma</a>
                        <a class="d-block text-muted py-1.5" href="{{ url('/departments/pediatrics') }}">Pediatrics &amp; NICU</a>
                    </div>
                </div>
            </div>

            <div class="border-bottom">
                <a class="nav-link px-4 py-3 fw-semibold text-dark" href="{{ url('/doctors') }}">
                    <i class="fa-solid fa-user-doctor me-2 text-muted"></i> Our Doctors
                </a>
            </div>

            <!-- Services & Facilities Accordion -->
            <div class="accordion-item rounded-0 border-0 border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed px-4 py-3 fw-semibold bg-white text-dark shadow-none" type="button"
                            data-bs-toggle="collapse" data-bs-target="#mobServices">
                        <i class="fa-solid fa-hospital me-2 text-muted"></i> Hospital Services
                    </button>
                </h2>
                <div id="mobServices" class="accordion-collapse collapse" data-bs-parent="#mobileAccordion">
                    <div class="accordion-body pt-0 ps-4 pb-3">
                        <a class="d-block text-muted py-1.5" href="#hospital-services">24/7 ICU &amp; Emergency</a>
                        <a class="d-block text-muted py-1.5" href="#hospital-facilities">Inpatient Wards &amp; Cabins</a>
                        <a class="d-block text-muted py-1.5" href="#hospital-facilities">Modular Operation Theatre (OT)</a>
                        <a class="d-block text-muted py-1.5" href="{{ url('/pharmacy') }}">24/7 Central Pharmacy</a>
                        <a class="d-block text-muted py-1.5" href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['site_phone'] ?? '01711000000') }}">Ambulance Dispatch</a>
                    </div>
                </div>
            </div>

            <!-- Diagnostic Accordion -->
            <div class="accordion-item rounded-0 border-0 border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed px-4 py-3 fw-semibold bg-white text-dark shadow-none" type="button"
                            data-bs-toggle="collapse" data-bs-target="#mobDiagnostic">
                        <i class="fa-solid fa-vials me-2 text-muted"></i> Diagnostic &amp; Lab
                    </button>
                </h2>
                <div id="mobDiagnostic" class="accordion-collapse collapse" data-bs-parent="#mobileAccordion">
                    <div class="accordion-body pt-0 ps-4 pb-3">
                        <a class="d-block text-muted py-1.5" href="{{ url('/tests') }}">Diagnostic Lab Tests</a>
                        <a class="d-block text-muted py-1.5" href="{{ url('/packages') }}">Health Checkup Packages</a>
                        <a class="d-block text-muted py-1.5" href="{{ url('/reports') }}">Download Online Reports</a>
                        <a class="d-block text-muted py-1.5" href="{{ url('/home-collection') }}">Doorstep Sample Pickup</a>
                        <a class="d-block text-muted py-1.5" href="{{ url('/pricing') }}">Diagnostic Price List</a>
                    </div>
                </div>
            </div>

            <div class="border-bottom">
                <a class="nav-link px-4 py-3 fw-semibold text-dark" href="{{ url('/contact') }}">
                    <i class="fa-solid fa-envelope me-2 text-muted"></i> Contact Us
                </a>
            </div>

        </div>

        <div class="p-4 border-top mt-auto" style="background: #F8FAFC;">
            <a href="{{ url('/appointment') }}" class="btn w-100 rounded-pill fw-bold mb-2 text-white shadow-sm py-2.5" style="background: linear-gradient(135deg, #0D9488 0%, #0f766e 100%);">
                <i class="fa-regular fa-calendar-check me-1"></i> Book Appointment
            </a>
            <a href="{{ url('/login') }}" class="btn btn-outline-dark w-100 rounded-pill fw-bold py-2" style="border-color: #CBD5E1;">
                <i class="fa-regular fa-user me-1"></i> Patient &amp; Doctor Login
            </a>
            <div class="text-center mt-3 text-muted small">
                <i class="fa-solid fa-phone-volume text-danger me-1"></i>
                Emergency Hotline: <strong>{{ $siteSettings['site_phone'] ?? '+880 1711 000 000' }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================
     GLOBAL SEARCH MODAL
     ================================================================ -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-2xl overflow-hidden">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0">Search Hospital Directory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ url('/search') }}" method="GET">
                    <div class="input-group input-group-lg shadow-sm rounded-4 overflow-hidden border">
                        <span class="input-group-text bg-white border-0 ps-3">
                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        </span>
                        <input type="text" name="q" class="form-control border-0 ps-2"
                               placeholder="Search doctor name, department, diagnostic test, or service…" autofocus style="font-size: 1rem;">
                        <button class="btn text-white fw-bold px-4" type="submit" style="background: #0D9488;">
                            Search
                        </button>
                    </div>
                </form>
                <div class="mt-4">
                    <p class="text-muted small fw-semibold mb-2 text-uppercase" style="letter-spacing: 0.05em; font-size: 0.72rem;">Suggested Medical Searches:</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ url('/doctors') }}" class="badge bg-light text-dark border text-decoration-none px-3 py-2 rounded-pill">Cardiology Specialist</a>
                        <a href="{{ url('/tests') }}" class="badge bg-light text-dark border text-decoration-none px-3 py-2 rounded-pill">Complete Blood Count (CBC)</a>
                        <a href="{{ url('/tests') }}" class="badge bg-light text-dark border text-decoration-none px-3 py-2 rounded-pill">3T MRI Brain</a>
                        <a href="{{ url('/packages') }}" class="badge bg-light text-dark border text-decoration-none px-3 py-2 rounded-pill">Executive Health Package</a>
                        <a href="{{ url('/reports') }}" class="badge bg-light text-dark border text-decoration-none px-3 py-2 rounded-pill">Online Report Portal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    // Dynamically calculate and set body padding-top based on the header's actual rendered height
    function syncHeaderHeight() {
        const header = document.getElementById('siteHeader');
        if (header) {
            const h = header.offsetHeight;
            if (h > 0) {
                document.body.style.paddingTop = h + 'px';
            }
        }
    }

    syncHeaderHeight();
    window.addEventListener('load', syncHeaderHeight);
    window.addEventListener('resize', syncHeaderHeight);

    // Navbar scroll elevation
    const headerWrapper = document.getElementById('siteHeader');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 25) {
            headerWrapper?.classList.add('scrolled', 'shadow');
        } else {
            headerWrapper?.classList.remove('scrolled');
        }
    }, { passive: true });

    // Hover dropdown dynamic positioning
    document.querySelectorAll('.nav-hover-dropdown').forEach(item => {
        const menu = item.querySelector('.hover-dropdown-menu');
        if (!menu) return;

        const position = () => {
            const rect   = item.getBoundingClientRect();
            const menuW  = menu.offsetWidth || parseInt(menu.style.minWidth) || 240;
            const vw     = window.innerWidth;

            menu.style.top = (rect.bottom + 2) + 'px';
            let left = rect.left + (rect.width / 2) - (menuW / 2);
            if (left + menuW > vw - 16) left = vw - menuW - 16;
            if (left < 8) left = 8;
            menu.style.left = left + 'px';
            menu.style.right = 'auto';
        };

        item.addEventListener('mouseenter', position);
        window.addEventListener('scroll', () => {
            if (item.matches(':hover')) position();
        }, { passive: true });
    });
})();
</script>
@endpush
