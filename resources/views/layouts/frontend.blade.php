<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dhaka Central Hospital - 24/7 Multi-Specialty Hospital, Emergency Trauma Care, and Advanced Automated Diagnostics">
    <title>@yield('title', ($siteSettings['site_name'] ?? 'Dhaka Central Hospital') . ' – 24/7 Multi-Specialty Healthcare')</title>

    @if(!empty($siteSettings['site_favicon']))
        <link rel="icon" href="{{ asset('storage/' . $siteSettings['site_favicon']) }}" type="image/png">
    @endif

    <!-- Google Fonts: Inter & Plus Jakarta Sans & Noto Sans Bengali -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons & Font Awesome (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS (via Vite) -->
    @vite('resources/css/app.css')

    <style>
        :root {
            --bs-primary: #142D4E;
            --bs-secondary: #0D9488;
            --hospital-navy: #142D4E;
            --hospital-teal: #0D9488;
        }
        body {
            font-family: 'Inter', 'Plus Jakarta Sans', 'Noto Sans Bengali', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
            color: #1E293B;
            background-color: #F4F7FA;
            overflow-x: hidden;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', 'Plus Jakarta Sans', sans-serif !important;
            color: #142D4E;
        }
        /* Definitively eliminate any underline on floating WhatsApp button */
        a.floating-wa-btn, 
        a.floating-wa-btn:hover, 
        a.floating-wa-btn:focus, 
        a.floating-wa-btn:active, 
        a.floating-wa-btn:visited,
        a.floating-wa-btn i,
        a.btn-whatsapp,
        a.btn-whatsapp:hover,
        a.btn-whatsapp:focus,
        a.btn-whatsapp:active {
            text-decoration: none !important;
            text-decoration-line: none !important;
            -webkit-text-decoration-line: none !important;
            border: none !important;
            border-bottom: none !important;
            outline: none !important;
        }
        a.floating-wa-btn::after,
        a.floating-wa-btn::before,
        a.btn-whatsapp::after,
        a.btn-whatsapp::before {
            display: none !important;
            content: none !important;
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <!-- Header Component -->
    <x-frontend.header />

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Component -->
    <x-frontend.footer />

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Initialize AOS -->
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });
    </script>

    @stack('scripts')
</body>
</html>
