<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\HomeSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $defaultSiteSettings = [
            'site_name'    => 'MediDiag Hospital & Diagnostic',
            'site_tagline' => 'Complete Hospital & Healthcare ERP',
            'site_phone'   => '+880 1711 000 000',
            'site_email'   => 'info@medidiag.com',
            'site_address' => '123 Health Avenue, Dhaka, Bangladesh',
            'site_logo'    => '',
            'site_favicon' => '',
        ];

        $defaultFooterSettings = [
            'description' => 'Committed to providing comprehensive inpatient, outpatient, and diagnostic healthcare services.',
            'cta_title' => 'Your Health. Our Priority.',
            'cta_description' => 'Experience world-class healthcare with state-of-the-art medical technology and compassionate care.',
            'cta_button_text' => 'Book an Appointment Now',
            'cta_button_link' => '/appointment',
            'socials' => [
                ['name' => 'Facebook', 'icon' => 'bi-facebook', 'url' => ''],
                ['name' => 'Twitter', 'icon' => 'bi-twitter', 'url' => ''],
                ['name' => 'LinkedIn', 'icon' => 'bi-linkedin', 'url' => ''],
                ['name' => 'YouTube', 'icon' => 'bi-youtube', 'url' => ''],
            ],
            'quick_links' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'About Us', 'url' => '/about'],
                ['label' => 'Our Doctors', 'url' => '/doctors'],
                ['label' => 'Download Report', 'url' => '/reports'],
                ['label' => 'Contact Us', 'url' => '/contact'],
            ],
            'service_links' => [
                ['label' => 'Emergency & Trauma', 'url' => '/appointment'],
                ['label' => 'Inpatient / Ward Care', 'url' => '/appointment'],
                ['label' => 'Pathology & Lab', 'url' => '/departments'],
                ['label' => 'Radiology & Imaging', 'url' => '/departments'],
                ['label' => 'Health Packages', 'url' => '/packages'],
            ],
        ];

        try {
            if (Schema::hasTable('settings')) {
                $siteSettings = [
                    'site_name'    => Setting::get('site_name', $defaultSiteSettings['site_name']),
                    'site_tagline' => Setting::get('site_tagline', $defaultSiteSettings['site_tagline']),
                    'site_phone'   => Setting::get('site_phone', $defaultSiteSettings['site_phone']),
                    'site_email'   => Setting::get('site_email', $defaultSiteSettings['site_email']),
                    'site_address' => Setting::get('site_address', $defaultSiteSettings['site_address']),
                    'site_logo'    => Setting::get('site_logo', ''),
                    'site_favicon' => Setting::get('site_favicon', ''),
                ];

                View::share('siteSettings', $siteSettings);

                if (Schema::hasTable('home_settings')) {
                    View::share('footerSettings', HomeSetting::getSection('footer_section', $defaultFooterSettings));
                } else {
                    View::share('footerSettings', $defaultFooterSettings);
                }
            } else {
                View::share('siteSettings', $defaultSiteSettings);
                View::share('footerSettings', $defaultFooterSettings);
            }
        } catch (\Throwable $e) {
            View::share('siteSettings', $defaultSiteSettings);
            View::share('footerSettings', $defaultFooterSettings);
        }
    }
}
