<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hospital Executive Dashboard') - {{ config('app.name', 'Dhaka Central Hospital') }}</title>

    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Core Hospital Management ERP Design System -->
    <link rel="stylesheet" href="{{ asset('css/hospital-erp.css') }}">

    @stack('styles')
</head>

<body class="erp-body">

    <!-- ====================================================================
         SIDEBAR NAVIGATION (DEEP NAVY ENTERPRISE LAYOUT)
         ==================================================================== -->
    <aside class="erp-sidebar" id="erpSidebar">
        <!-- Sidebar Brand Header -->
        <div class="sidebar-brand">
            @php
                $adminLogo = \App\Models\Setting::get('site_logo');
                $siteName  = \App\Models\Setting::get('site_name', 'Dhaka Central Hospital');
            @endphp
            @if($adminLogo)
                <img src="{{ asset('storage/' . $adminLogo) }}" alt="{{ $siteName }}" style="max-height: 42px; max-width: 150px; object-fit: contain;">
            @else
                <div class="sidebar-brand-icon">
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
                <div class="sidebar-brand-text">
                    <h5 class="sidebar-brand-title">{{ $siteName }}</h5>
                    <p class="sidebar-brand-sub">Hospital ERP</p>
                </div>
            @endif
        </div>

        <!-- Scrollable Navigation Menu -->
        <nav class="sidebar-nav">
            <!-- GROUP 1: DASHBOARD -->
            <div class="nav-group-title">Dashboard</div>

            <div class="sidebar-item">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-chart-pie"></i></span>
                    <span>Executive Overview</span>
                </a>
            </div>

            @can('view appointments')
            <div class="sidebar-item">
                <a href="{{ route('appointments.queue') }}" class="sidebar-link {{ request()->routeIs('appointments.queue') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-tv"></i></span>
                    <span>OPD Live Queue</span>
                </a>
            </div>
            @endcan

            <!-- GROUP 2: PATIENT SERVICES -->
            <div class="nav-group-title">Patient Services</div>

            @can('view patients')
            <div class="sidebar-item">
                <a href="{{ route('patients.index') }}" class="sidebar-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
                    <span>Patient Registry</span>
                </a>
            </div>
            @endcan

            @can('view appointments')
            <div class="sidebar-item">
                <a href="{{ route('appointments.index') }}" class="sidebar-link {{ request()->routeIs('appointments.index') || request()->routeIs('appointments.create') || request()->routeIs('appointments.show') || request()->routeIs('appointments.edit') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-calendar-check"></i></span>
                    <span>OPD Appointments</span>
                </a>
            </div>
            @endcan

            @can('view consultations')
            <div class="sidebar-item">
                <a href="{{ route('consultations.index') }}" class="sidebar-link {{ request()->routeIs('consultations.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-stethoscope"></i></span>
                    <span>Doctor Consultations</span>
                </a>
            </div>
            @endcan

            @can('view emergency')
            <div class="sidebar-item">
                <a href="{{ route('emergency.index') }}" class="sidebar-link {{ request()->routeIs('emergency.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-truck-medical text-danger"></i></span>
                    <span>Emergency (ER)</span>
                </a>
            </div>
            @endcan

            <!-- GROUP 3: HOSPITAL OPERATIONS (IPD, BEDS, NURSING, OT) -->
            <div class="nav-group-title">Hospital Operations</div>

            @can('view ipd')
            <div class="sidebar-item">
                <a href="{{ route('admissions.index') }}" class="sidebar-link {{ request()->routeIs('admissions.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-hospital-user text-primary"></i></span>
                    <span>IPD Admissions</span>
                </a>
            </div>
            @endcan

            @can('view beds')
            <div class="sidebar-item">
                <a href="{{ route('beds.matrix') }}" class="sidebar-link {{ request()->routeIs('beds.matrix') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-bed text-success"></i></span>
                    <span>Bed Matrix & Status</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('wards.index') }}" class="sidebar-link {{ request()->routeIs('wards.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-door-open"></i></span>
                    <span>Wards & Cabins</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('beds.index') }}" class="sidebar-link {{ request()->routeIs('beds.index') || request()->routeIs('beds.create') || request()->routeIs('beds.edit') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-bed-pulse"></i></span>
                    <span>Bed Units List</span>
                </a>
            </div>
            @endcan

            @can('view nursing')
            <div class="sidebar-item">
                <a href="{{ route('nursing.index') }}" class="sidebar-link {{ request()->routeIs('nursing.index') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-user-nurse"></i></span>
                    <span>Nursing Station</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('nursing.mar') }}" class="sidebar-link {{ request()->routeIs('nursing.mar') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-pills text-warning"></i></span>
                    <span>MAR Medication</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('nursing.roster') }}" class="sidebar-link {{ request()->routeIs('nursing.roster') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-calendar-days"></i></span>
                    <span>Nurse Duty Roster</span>
                </a>
            </div>
            @endcan

            @can('view ot')
            <div class="sidebar-item">
                <a href="{{ route('ot.index') }}" class="sidebar-link {{ request()->routeIs('ot.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-syringe text-danger"></i></span>
                    <span>Operation Theatre</span>
                </a>
            </div>
            @endcan

            <!-- GROUP 4: MEDICAL SERVICES -->
            <div class="nav-group-title">Medical Services</div>

            @can('view doctors')
            <div class="sidebar-item">
                <a href="{{ route('doctors.index') }}" class="sidebar-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-user-doctor"></i></span>
                    <span>Specialist Doctors</span>
                </a>
            </div>
            @endcan

            @can('view tests')
            <div class="sidebar-item">
                <a href="{{ route('tests.index') }}" class="sidebar-link {{ request()->routeIs('tests.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-microscope"></i></span>
                    <span>Master Tests Catalog</span>
                </a>
            </div>
            @endcan

            @can('view lab orders')
            <div class="sidebar-item">
                <a href="{{ route('samples.index') }}" class="sidebar-link {{ request()->routeIs('samples.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-vial text-info"></i></span>
                    <span>Sample Collection</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('diagnostic-orders.index') }}" class="sidebar-link {{ request()->routeIs('diagnostic-orders.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-vial-circle-check"></i></span>
                    <span>Diagnostic Orders</span>
                </a>
            </div>
            @endcan

            @can('view lab results')
            <div class="sidebar-item">
                <a href="{{ route('test-results.index') }}" class="sidebar-link {{ request()->routeIs('test-results.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-file-medical"></i></span>
                    <span>Lab Results & Reports</span>
                </a>
            </div>
            @endcan

            @can('view radiology')
            <div class="sidebar-item">
                <a href="{{ route('radiology.index') }}" class="sidebar-link {{ request()->routeIs('radiology.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-x-ray text-warning"></i></span>
                    <span>Radiology (X-Ray/USG)</span>
                </a>
            </div>
            @endcan

            @can('view pharmacy')
            <div class="sidebar-item">
                <a href="{{ route('pharmacy.pos') }}" class="sidebar-link {{ request()->routeIs('pharmacy.pos') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-cash-register text-success"></i></span>
                    <span>Pharmacy POS</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('pharmacy.index') }}" class="sidebar-link {{ request()->routeIs('pharmacy.index') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-prescription-bottle-medical"></i></span>
                    <span>Pharmacy Dispensary</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('pharmacy.medicines') }}" class="sidebar-link {{ request()->routeIs('pharmacy.medicines') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-tablets"></i></span>
                    <span>Medicines Directory</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('pharmacy.batches') }}" class="sidebar-link {{ request()->routeIs('pharmacy.batches') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
                    <span>Stock & Expiry Batches</span>
                </a>
            </div>
            @endcan

            @can('view blood bank')
            <div class="sidebar-item">
                <a href="{{ route('blood-bank.index') }}" class="sidebar-link {{ request()->routeIs('blood-bank.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-droplet text-danger"></i></span>
                    <span>Blood Bank Logistics</span>
                </a>
            </div>
            @endcan

            <!-- GROUP 5: FINANCE & ACCOUNTS -->
            <div class="nav-group-title">Finance & Billing</div>

            @can('view billing')
            <div class="sidebar-item">
                <a href="{{ route('invoices.index') }}" class="sidebar-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-file-invoice-dollar text-success"></i></span>
                    <span>Billing & Invoices</span>
                </a>
            </div>
            @endcan

            @can('view accounts')
            <div class="sidebar-item">
                <a href="{{ route('expenses.index') }}" class="sidebar-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-receipt text-danger"></i></span>
                    <span>Operating Expenses</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('accounts.index') }}" class="sidebar-link {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-scale-balanced text-primary"></i></span>
                    <span>Accounts Ledger</span>
                </a>
            </div>
            @endcan

            @can('view reports')
            <div class="sidebar-item">
                <a class="sidebar-link dropdown-toggle" data-bs-toggle="collapse" href="#reportsMenu" role="button"
                    aria-expanded="{{ request()->routeIs('reports.*') ? 'true' : 'false' }}">
                    <span class="nav-icon"><i class="fa-solid fa-chart-line"></i></span>
                    <span>Financial Reports</span>
                </a>
                <div class="collapse {{ request()->routeIs('reports.*') ? 'show' : '' }}" id="reportsMenu">
                    <ul class="sidebar-dropdown-menu">
                        <li><a href="{{ route('reports.account') }}" class="{{ request()->routeIs('reports.account') ? 'active' : '' }}">Account Summary</a></li>
                        <li><a href="{{ route('reports.patient') }}" class="{{ request()->routeIs('reports.patient') ? 'active' : '' }}">Patient Demographics</a></li>
                        <li><a href="{{ route('reports.doctor') }}" class="{{ request()->routeIs('reports.doctor') ? 'active' : '' }}">Doctor Analytics</a></li>
                        <li><a href="{{ route('reports.labOrder') }}" class="{{ request()->routeIs('reports.labOrder') ? 'active' : '' }}">Lab Order Stats</a></li>
                    </ul>
                </div>
            </div>
            @endcan

            <!-- GROUP 6: ADMINISTRATION -->
            <div class="nav-group-title">Administration</div>

            @can('view staff')
            <div class="sidebar-item">
                <a href="{{ route('staff.index') }}" class="sidebar-link {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-user-tie"></i></span>
                    <span>Staff Directory</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('payroll.index') }}" class="sidebar-link {{ request()->routeIs('payroll.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-money-check-dollar"></i></span>
                    <span>Attendance & Payroll</span>
                </a>
            </div>
            @endcan

            @can('view ambulance')
            <div class="sidebar-item">
                <a href="{{ route('ambulance.index') }}" class="sidebar-link {{ request()->routeIs('ambulance.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-van-shuttle text-primary"></i></span>
                    <span>Ambulance Dispatch</span>
                </a>
            </div>
            @endcan

            @can('view certificates')
            <div class="sidebar-item">
                <a href="{{ route('certificates.index') }}" class="sidebar-link {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-stamp text-secondary"></i></span>
                    <span>Vital Certificates</span>
                </a>
            </div>
            @endcan

            <!-- GROUP 7: SETTINGS & CONFIG -->
            <div class="nav-group-title">Settings & System</div>

            @can('view settings')
            <div class="sidebar-item">
                <a href="{{ route('roles.index') }}" class="sidebar-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-user-shield"></i></span>
                    <span>Roles & Permissions</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('branches.index') }}" class="sidebar-link {{ request()->routeIs('branches.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-building"></i></span>
                    <span>Hospital Branches</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('cms.index') }}" class="sidebar-link {{ request()->routeIs('cms.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-desktop"></i></span>
                    <span>Website CMS</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('home-collection-requests.index') }}" class="sidebar-link {{ request()->routeIs('home-collection-requests.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-house-medical"></i></span>
                    <span>Booking Requests</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('contact-messages.index') }}" class="sidebar-link {{ request()->routeIs('contact-messages.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-inbox"></i></span>
                    <span>Contact Inbox</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-gear"></i></span>
                    <span>General Settings</span>
                </a>
            </div>
            @endcan
        </nav>

        <!-- Sidebar Footer with User Details & Direct Logout -->
        <div class="sidebar-footer">
            <div class="sidebar-footer-user">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'A') }}&background=0D9488&color=fff&bold=true" 
                     alt="User" class="sidebar-footer-avatar">
                <div class="sidebar-footer-info">
                    <p class="sidebar-footer-name">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <p class="sidebar-footer-role">{{ Auth::user()->roles->first()->name ?? 'Admin' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger p-1 rounded-circle" style="width: 30px; height: 30px;" title="Sign Out">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Sidebar Backdrop for Mobile Screens -->
    <div class="erp-sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- ====================================================================
         MAIN CONTENT WRAPPER & TOP NAVBAR
         ==================================================================== -->
    <div class="erp-main-wrapper">
        <!-- Top Sticky Navbar -->
        <header class="erp-navbar">
            <div class="d-flex align-items-center gap-3">
                <!-- Mobile Offcanvas Sidebar Toggle Button -->
                <button id="sidebarToggle" class="btn btn-light border p-2 rounded-3 d-lg-none" type="button" aria-label="Toggle Navigation">
                    <i class="fa-solid fa-bars fs-5" style="color: var(--erp-primary);"></i>
                </button>

                <!-- Desktop Sidebar Compact Toggle Button -->
                <button id="desktopSidebarToggle" class="btn btn-light border p-2 rounded-3 d-none d-lg-inline-flex" type="button" title="Collapse / Expand Sidebar">
                    <i class="fa-solid fa-bars-staggered fs-6 text-secondary"></i>
                </button>

                <!-- Hospital Operational Status Pill -->
                <div class="d-none d-md-flex align-items-center gap-2 px-3 py-1 rounded-pill" style="background: rgba(13, 148, 136, 0.1); border: 1px solid rgba(13, 148, 136, 0.25);">
                    <span style="width: 8px; height: 8px; background: #0D9488; border-radius: 50%; display: inline-block;"></span>
                    <span style="font-size: 0.78rem; font-weight: 700; color: #0D9488; text-transform: uppercase; letter-spacing: 0.5px;">24/7 Clinical Active</span>
                </div>
            </div>

            <!-- Global Patient Search Input -->
            <div class="erp-global-search d-none d-sm-block">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <form action="{{ route('patients.index') }}" method="GET" class="m-0">
                    <input type="text" name="search" id="globalPatientSearch" placeholder="Search patient by ID, name, or phone..." autocomplete="off">
                </form>
                <span class="search-shortcut">/</span>
            </div>

            <!-- Navbar Right Actions -->
            <div class="d-flex align-items-center gap-2">
                <!-- Quick Hospital Action Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-erp-teal btn-sm dropdown-toggle rounded-pill px-3 py-1.5 shadow-sm fw-semibold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-circle-plus me-1"></i> Quick Action
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" style="font-size: 0.88rem; min-width: 200px;">
                        <li><h6 class="dropdown-header text-uppercase small fw-bold">Emergency & Inpatient</h6></li>
                        <li>
                            <a class="dropdown-item py-2 text-danger fw-semibold" href="{{ route('emergency.create') }}">
                                <i class="fa-solid fa-truck-medical me-2"></i> Emergency Intake
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 text-primary fw-semibold" href="{{ route('admissions.create') }}">
                                <i class="fa-solid fa-bed-pulse me-2"></i> IPD Admission
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header text-uppercase small fw-bold">Outpatient & Registration</h6></li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('patients.create') }}">
                                <i class="fa-solid fa-user-plus me-2 text-success"></i> Register Patient
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('appointments.create') }}">
                                <i class="fa-solid fa-calendar-plus me-2 text-warning"></i> Book Appointment
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('pharmacy.pos') }}">
                                <i class="fa-solid fa-cash-register me-2 text-teal"></i> Pharmacy POS
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Live Public Site Shortcut -->
                <a href="{{ url('/') }}" target="_blank" class="btn btn-light border p-2 rounded-circle d-none d-md-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" title="View Public Website">
                    <i class="fa-solid fa-arrow-up-right-from-square text-secondary"></i>
                </a>

                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <div class="d-flex align-items-center gap-2 p-1 px-2 rounded-pill bg-light border cursor-pointer" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'A') }}&background=142D4E&color=fff&bold=true" 
                             alt="User" class="rounded-circle" style="width: 32px; height: 32px;">
                        <div class="d-none d-xl-block text-start line-height-1" style="line-height: 1.15;">
                            <div class="fw-bold" style="font-size: 0.82rem; color: var(--erp-primary);">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <small class="text-muted" style="font-size: 0.68rem;">{{ Auth::user()->roles->first()->name ?? 'Staff' }}</small>
                        </div>
                        <i class="fa-solid fa-chevron-down text-muted small ps-1 pe-1"></i>
                    </div>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" style="font-size: 0.88rem; min-width: 220px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('settings.index') }}">
                                <i class="fa-solid fa-gear me-2 text-secondary"></i> System Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('beds.matrix') }}">
                                <i class="fa-solid fa-bed text-success me-2"></i> Live Bed Matrix
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger fw-semibold">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Page Content -->
        <main class="erp-content-body">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global Layout Interactions Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Offcanvas Sidebar
            const mobileToggle = document.getElementById('sidebarToggle');
            const desktopToggle = document.getElementById('desktopSidebarToggle');
            const sidebar = document.getElementById('erpSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            function toggleMobileSidebar() {
                if (sidebar) sidebar.classList.toggle('show');
                if (backdrop) backdrop.classList.toggle('show');
            }

            function closeMobileSidebar() {
                if (sidebar) sidebar.classList.remove('show');
                if (backdrop) backdrop.classList.remove('show');
            }

            if (mobileToggle) mobileToggle.addEventListener('click', toggleMobileSidebar);
            if (backdrop) backdrop.addEventListener('click', closeMobileSidebar);

            // Desktop Compact Sidebar Collapse
            if (desktopToggle) {
                desktopToggle.addEventListener('click', function() {
                    document.body.classList.toggle('erp-sidebar-collapsed');
                    // Persist state in localStorage
                    const isCollapsed = document.body.classList.contains('erp-sidebar-collapsed');
                    localStorage.setItem('hospital_sidebar_collapsed', isCollapsed ? '1' : '0');
                });

                // Restore saved desktop state
                if (localStorage.getItem('hospital_sidebar_collapsed') === '1' && window.innerWidth >= 992) {
                    document.body.classList.add('erp-sidebar-collapsed');
                }
            }

            // Keyboard shortcut for Global Patient Search ('/')
            const searchInput = document.getElementById('globalPatientSearch');
            document.addEventListener('keydown', function(e) {
                if (e.key === '/' && document.activeElement !== searchInput && !['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) {
                    e.preventDefault();
                    if (searchInput) searchInput.focus();
                }
            });

            // Auto-close mobile sidebar when clicking menu links
            if (sidebar) {
                sidebar.querySelectorAll('a:not(.dropdown-toggle)').forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth < 992) {
                            closeMobileSidebar();
                        }
                    });
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
