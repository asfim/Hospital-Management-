<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - {{ $siteSettings['site_name'] ?? 'MediDiag' }}</title>

    @if(!empty($siteSettings['site_favicon']))
        <link rel="icon" href="{{ asset('storage/' . $siteSettings['site_favicon']) }}" type="image/png">
    @endif

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            background: #fff;
            max-width: 900px;
            width: 100%;
            margin: 2rem;
            display: flex;
        }
        .auth-left {
            background: linear-gradient(135deg, #142D4E 0%, #0d1e34 50%, #0D9488 100%);
            padding: 3rem;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex: 1;
            position: relative;
        }
        .auth-left::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle, rgba(45, 212, 191, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .auth-right {
            padding: 3rem 4rem;
            flex: 1;
            background: #fff;
        }
        .auth-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
        }
        .auth-logo img {
            height: 40px;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            background: #f8f9fa;
            border: 1px solid #e2e8f0;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
            border-color: #0D9488;
            background: #fff;
        }
        .btn-auth {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            background: #142D4E;
            color: #fff;
            border: none;
            transition: all 0.3s;
        }
        .btn-auth:hover {
            background: #0D9488;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.35);
        }
        @media (max-width: 768px) {
            .auth-card { flex-direction: column; }
            .auth-left { padding: 2rem; text-align: center; }
            .auth-right { padding: 2rem; }
            .auth-logo { justify-content: center; width: 100%; }
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <!-- Left Side: Hospital Branding -->
        <div class="auth-left">
            <a href="{{ url('/') }}" class="auth-logo">
                @if(!empty($siteSettings['site_logo']))
                    <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="Logo">
                @else
                    <i class="bi bi-hospital-fill text-teal" style="color: #2dd4bf;"></i>
                @endif
                {{ $siteSettings['site_name'] ?? 'Dhaka Central Hospital' }}
            </a>
            <h2 class="fw-bold mb-3 text-white" style="position:relative; z-index:2;">Hospital ERP Portal</h2>
            <p style="opacity: 0.9; position:relative; z-index:2; line-height: 1.6; color: #cbd5e1;">
                Authorized clinical workspace for physicians, nursing staff, emergency intake, laboratory specialists, pharmacists, and hospital administrators.
            </p>
            <div class="mt-4 pt-3 border-top border-white border-opacity-15 position-relative" style="z-index: 2;">
                <div class="d-flex align-items-center gap-2 mb-2 text-white-50 small">
                    <i class="bi bi-shield-check text-success" style="color: #4ade80 !important;"></i>
                    <span>Secure Healthcare Audit & Role-based Access</span>
                </div>
                <div class="d-flex align-items-center gap-2 text-white-50 small">
                    <i class="bi bi-clock-history" style="color: #2dd4bf !important;"></i>
                    <span>24/7 Real-time Emergency & Bed Management</span>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="auth-right">
            {{ $slot }}
        </div>
    </div>

</body>
</html>
