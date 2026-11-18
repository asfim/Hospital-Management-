<!-- ================================================================
     PRE-FOOTER CTA BANNER (Deep Navy & Medical Teal Gradient)
     ================================================================ -->
<section class="py-5 text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #142D4E 0%, #0d1e35 50%, #0D9488 100%);">
    <div class="container position-relative py-3" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(45, 212, 191, 0.15); border: 1px solid rgba(45, 212, 191, 0.3);">
                    <span class="d-inline-block rounded-circle bg-danger" style="width: 8px; height: 8px; box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.4);"></span>
                    <span class="small fw-bold text-uppercase" style="color: #2dd4bf; letter-spacing: 0.5px;">24/7 Emergency &amp; Critical Care</span>
                </div>
                <h2 class="display-6 fw-bold text-white mb-3">{{ $footerSettings['cta_title'] ?? 'Need Immediate Medical Care or Doctor Consultation?' }}</h2>
                <p class="lead text-white-50 mb-4" style="font-size: 1.1rem; max-width: 640px; margin: 0 auto;">
                    {{ $footerSettings['cta_description'] ?? 'Our multi-specialty clinical team, rapid cardiac ambulance dispatch, and state-of-the-art diagnostic center are available 24 hours a day, 7 days a week.' }}
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ $footerSettings['cta_button_link'] ?? url('/appointment') }}" class="btn btn-lg px-4 py-2.5 rounded-pill fw-bold text-white shadow-lg" style="background: #0D9488; border: none;">
                        <i class="fa-regular fa-calendar-check me-2"></i>{{ $footerSettings['cta_button_text'] ?? 'Book Appointment Online' }}
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['site_phone'] ?? '+8801711000000') }}" class="btn btn-outline-light btn-lg px-4 py-2.5 rounded-pill fw-bold d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-phone-volume text-danger"></i>
                        <span>24/7 Emergency Hotline</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================
     MAIN 4-COLUMN FOOTER (Deep Navy #142D4E)
     ================================================================ -->
<footer class="main-footer pt-5 text-white" style="background: #0d1e35; border-top: 1px solid rgba(255, 255, 255, 0.08);">
    <div class="container pb-4">
        <div class="row g-4">
            <!-- Col 1: Hospital Identity & Mission -->
            <div class="col-lg-4 col-md-6 pe-lg-4">
                <a class="d-flex align-items-center gap-2 text-decoration-none mb-3" href="{{ url('/') }}">
                    @if(!empty($siteSettings['site_logo']))
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'Hospital' }}" style="height: 52px; object-fit: contain;">
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded-3 text-white flex-shrink-0 shadow-sm" style="width: 44px; height: 44px; background: linear-gradient(135deg, #142D4E 0%, #0D9488 100%);">
                            <i class="fa-solid fa-hospital-user fs-4"></i>
                        </div>
                        <div>
                            <span class="fw-bold text-white fs-5 d-block">{{ $siteSettings['site_name'] ?? 'Dhaka Central Hospital' }}</span>
                            <small class="text-teal text-uppercase fw-semibold" style="color: #2dd4bf; font-size: 0.7rem; letter-spacing: 0.08em;">Multi-Specialty &amp; Diagnostics</small>
                        </div>
                    @endif
                </a>
                <p class="text-white-50 small mb-3" style="line-height: 1.7;">
                    {{ $footerSettings['description'] ?? 'Dhaka Central Hospital is an advanced multi-specialty healthcare institution dedicated to delivering clinical excellence, modern patient care, and 24/7 trauma emergency management.' }}
                </p>
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-3 mb-4" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <i class="fa-solid fa-certificate text-warning"></i>
                    <span class="text-white small fw-semibold" style="font-size: 0.75rem;">ISO 9001:2015 &amp; DGHS Registered Hospital</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="#" class="rounded-circle d-flex align-items-center justify-content-center text-white text-decoration-none" style="width: 36px; height: 36px; background: rgba(255, 255, 255, 0.1);" title="Facebook"><i class="fa-brands fa-facebook-f small"></i></a>
                    <a href="#" class="rounded-circle d-flex align-items-center justify-content-center text-white text-decoration-none" style="width: 36px; height: 36px; background: rgba(255, 255, 255, 0.1);" title="Twitter"><i class="fa-brands fa-twitter small"></i></a>
                    <a href="#" class="rounded-circle d-flex align-items-center justify-content-center text-white text-decoration-none" style="width: 36px; height: 36px; background: rgba(255, 255, 255, 0.1);" title="LinkedIn"><i class="fa-brands fa-linkedin-in small"></i></a>
                    <a href="#" class="rounded-circle d-flex align-items-center justify-content-center text-white text-decoration-none" style="width: 36px; height: 36px; background: rgba(255, 255, 255, 0.1);" title="YouTube"><i class="fa-brands fa-youtube small"></i></a>
                </div>
            </div>

            <!-- Col 2: Hospital Quick Links -->
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="text-white fw-bold mb-3 text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.05em; color: #2dd4bf !important;">Quick Links</h6>
                <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                    <li><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-white">Hospital Home</a></li>
                    <li><a href="{{ url('/about') }}" class="text-white-50 text-decoration-none hover-white">About Us</a></li>
                    <li><a href="{{ url('/doctors') }}" class="text-white-50 text-decoration-none hover-white">Specialist Doctors</a></li>
                    <li><a href="{{ url('/departments') }}" class="text-white-50 text-decoration-none hover-white">Clinical Departments</a></li>
                    <li><a href="#hospital-facilities" class="text-white-50 text-decoration-none hover-white">Hospital Facilities</a></li>
                    <li><a href="{{ url('/packages') }}" class="text-white-50 text-decoration-none hover-white">Health Packages</a></li>
                    <li><a href="{{ url('/blog') }}" class="text-white-50 text-decoration-none hover-white">Medical Blog</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-white-50 text-decoration-none hover-white">Contact &amp; Location</a></li>
                </ul>
            </div>

            <!-- Col 3: Medical Services -->
            <div class="col-lg-3 col-md-6 col-6">
                <h6 class="text-white fw-bold mb-3 text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.05em; color: #2dd4bf !important;">Hospital Services</h6>
                <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                    <li><a href="#hospital-services" class="text-white-50 text-decoration-none hover-white">24/7 Trauma Emergency</a></li>
                    <li><a href="#hospital-facilities" class="text-white-50 text-decoration-none hover-white">Intensive Care Unit (ICU/CCU)</a></li>
                    <li><a href="#hospital-facilities" class="text-white-50 text-decoration-none hover-white">Inpatient Wards &amp; VIP Cabins</a></li>
                    <li><a href="#hospital-facilities" class="text-white-50 text-decoration-none hover-white">Modular Operation Theatres</a></li>
                    <li><a href="{{ url('/tests') }}" class="text-white-50 text-decoration-none hover-white">Automated Pathology &amp; MRI</a></li>
                    <li><a href="{{ url('/pharmacy') }}" class="text-white-50 text-decoration-none hover-white">24/7 Central Pharmacy</a></li>
                    <li><a href="{{ url('/home-collection') }}" class="text-white-50 text-decoration-none hover-white">Doorstep Sample Pickup</a></li>
                    <li><a href="{{ url('/reports') }}" class="text-white-50 text-decoration-none hover-white">Download Online Reports</a></li>
                </ul>
            </div>

            <!-- Col 4: Contact & Emergency -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white fw-bold mb-3 text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.05em; color: #2dd4bf !important;">Contact &amp; Emergency</h6>
                <ul class="list-unstyled small mb-3 d-flex flex-column gap-2 text-white-50">
                    <li class="d-flex align-items-start gap-2">
                        <i class="fa-solid fa-location-dot mt-1" style="color: #2dd4bf;"></i>
                        <span>{{ $siteSettings['site_address'] ?? '123 Health Avenue, Dhanmondi, Dhaka-1205' }}</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-phone-volume text-danger"></i>
                        <span>Hotline: <strong class="text-white">{{ $siteSettings['site_phone'] ?? '+880 1711 000 000' }}</strong></span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="fa-regular fa-envelope" style="color: #2dd4bf;"></i>
                        <span>{{ $siteSettings['site_email'] ?? 'info@hospital.com' }}</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="fa-regular fa-clock" style="color: #2dd4bf;"></i>
                        <span>OPD: 8 AM - 10 PM | Emergency: 24/7</span>
                    </li>
                </ul>

                <h6 class="text-white small fw-bold mb-2">Hospital Newsletter</h6>
                <form class="d-flex gap-1" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
                    <input type="email" class="form-control form-control-sm rounded-start-pill bg-dark border-secondary text-white ps-3" placeholder="Enter your email" required style="border-color: rgba(255,255,255,0.2) !important;">
                    <button class="btn btn-sm rounded-end-pill px-3 text-white fw-bold" type="submit" style="background: #0D9488;">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Footer Bottom Bar -->
    <div class="py-3 text-center" style="background: #091427; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small text-white-50">
            <p class="mb-0">&copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'Dhaka Central Hospital' }} – Multi-Specialty &amp; Diagnostic ERP. All Rights Reserved.</p>
            <div class="d-flex gap-3">
                <a href="{{ url('/about') }}" class="text-white-50 text-decoration-none hover-white">Privacy Policy</a>
                <span>&bull;</span>
                <a href="{{ url('/about') }}" class="text-white-50 text-decoration-none hover-white">Terms of Care</a>
                <span>&bull;</span>
                <a href="{{ url('/contact') }}" class="text-white-50 text-decoration-none hover-white">Patient Charter</a>
            </div>
        </div>
    </div>
</footer>
