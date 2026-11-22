<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Test;
use App\Models\TestPackage;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\TestCategory;
use App\Models\DoctorSchedule;
use App\Models\Hero;
use App\Models\HomeSetting;
use App\Models\Testimonial;
use App\Models\Blog;
use App\Models\Bed;
use App\Models\Ward;
use App\Models\AmbulanceVehicle;
use App\Models\Branch;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// =====================================================================
// HOME
// =====================================================================
class HomeController extends Controller
{
    public function about()
    {
        $aboutDefaults = [
            'image' => null,
            'years_number' => '15+',
            'years_text' => "Years of\nExcellence",
            'label' => 'About MediDiag',
            'title' => 'Leading the Way in Medical Diagnostics',
            'description' => 'We provide comprehensive diagnostic services with a commitment to accuracy, reliability, and patient comfort.',
            'quote' => 'Precision in every result, compassion in every interaction.',
            'features' => ['Advanced Equipment', 'Expert Pathologists', 'Accurate Reports', 'Fast Turnaround'],
            'button_text' => 'Learn More',
            'button_link' => url('/about'),
            'mission_title' => 'Our Mission',
            'mission_text' => 'To deliver precise, timely, and affordable diagnostic services to all segments of society while maintaining the highest ethical standards.',
            'vision_title' => 'Our Vision',
            'vision_text' => 'To become the leading and most trusted healthcare diagnostic brand in South Asia.',
            'values' => [
                ['title' => 'Integrity', 'description' => 'We uphold the highest moral standards in our practices.', 'icon' => 'bi-shield-check', 'color' => 'primary'],
                ['title' => 'Compassion', 'description' => 'We treat every patient with empathy and respect.', 'icon' => 'bi-heart', 'color' => 'danger'],
                ['title' => 'Excellence', 'description' => 'We continuously strive for clinical and service excellence.', 'icon' => 'bi-award', 'color' => 'secondary'],
                ['title' => 'Innovation', 'description' => 'Embracing new technologies for better diagnostics.', 'icon' => 'bi-lightbulb', 'color' => 'warning'],
            ],
            'infrastructure_title' => 'World-Class Infrastructure',
            'infrastructure_text' => 'Our laboratories are equipped with fully automated analyzers, ensuring zero manual error and fastest report delivery.',
            'infrastructure_points' => ['ISO 9001:2015 Certified Laboratories', 'Fully Automated Pathology Workflow', '3 Tesla MRI & 128 Slice CT Scan', 'Internal & External Quality Control'],
            'infrastructure_image' => null,
        ];
        $about = array_replace_recursive($aboutDefaults, HomeSetting::getSection('about_page_section', HomeSetting::getSection('about_section', [])));
        $stats = HomeSetting::getSection('stats_section', [
            'doctors' => '50+',
            'tests' => '500+',
            'patients' => '100k+',
        ]);

        return view('frontend.about', compact('about', 'stats'));
    }

    public function index()
    {
        $doctorCount     = Doctor::where('status', 1)->count();
        $bedCount        = Bed::count();
        $testCount       = Test::where('status', 1)->count();
        $departmentCount = Department::count();
        $ambulanceCount  = class_exists(AmbulanceVehicle::class) ? AmbulanceVehicle::count() : 0;
        $patientCount    = Patient::count();
        $branchCount     = Branch::where('status', 1)->count();

        $departments  = Department::withCount([
            'doctors' => function ($q) { $q->where('status', 1); },
            'tests'   => function ($q) { $q->where('status', 1); }
        ])->limit(8)->get();

        $doctors      = Doctor::with(['department', 'schedules'])->where('status', 1)->limit(8)->get();
        $tests        = Test::with('category')->where('status', 1)->limit(6)->get();
        $packages     = TestPackage::withCount('tests')->where('status', 'active')->orderBy('sort_order')->limit(6)->get();
        $testimonials = Testimonial::where('status', true)->latest()->get();
        $blogs        = Blog::where('status', true)->latest('published_at')->latest()->limit(3)->get();
        $hero         = Hero::first();

        // Dynamic Real DB Stats with CMS override option
        $dbStats = [
            'doctors'  => ($doctorCount > 0 ? $doctorCount . '+' : '50+'),
            'beds'     => ($bedCount > 0 ? $bedCount . '+' : '40+'),
            'tests'    => ($testCount > 0 ? $testCount . '+' : '500+'),
            'patients' => ($patientCount > 0 ? ($patientCount > 1000 ? round($patientCount / 1000) . 'k+' : $patientCount . '+') : '100k+'),
            'support'  => '24/7'
        ];
        $stats = array_merge($dbStats, HomeSetting::getSection('stats_section', []));

        $quickActions = HomeSetting::getSection('quick_actions', [
            [
                'icon' => 'fa-regular fa-calendar-check',
                'color' => 'teal',
                'title' => 'Book Appointment',
                'description' => 'OPD Specialist Visit',
                'button_text' => 'Book Now',
                'link' => url('/appointment')
            ],
            [
                'icon' => 'fa-solid fa-user-doctor',
                'color' => 'primary',
                'title' => 'Find a Doctor',
                'description' => ($doctorCount > 0 ? $doctorCount . '+ Specialists' : '50+ Specialists'),
                'button_text' => 'View Doctors',
                'link' => url('/doctors')
            ],
            [
                'icon' => 'fa-solid fa-microscope',
                'color' => 'info',
                'title' => 'Diagnostic Tests',
                'description' => ($testCount > 0 ? $testCount . '+ Tests' : 'Pathology & Imaging'),
                'button_text' => 'Browse Tests',
                'link' => url('/tests')
            ],
            [
                'icon' => 'fa-solid fa-file-pdf',
                'color' => 'success',
                'title' => 'Online Reports',
                'description' => 'Instant PDF Download',
                'button_text' => 'View Reports',
                'link' => url('/reports')
            ],
            [
                'icon' => 'fa-solid fa-truck-medical',
                'color' => 'danger',
                'title' => '24/7 Emergency',
                'description' => 'Trauma & Ambulance',
                'button_text' => 'Call Hotline',
                'link' => 'tel:' . preg_replace('/[^0-9+]/', '', \App\Models\Setting::get('site_phone', '+8801711000000'))
            ],
            [
                'icon' => 'fa-regular fa-id-badge',
                'color' => 'warning',
                'title' => 'Patient Portal',
                'description' => 'Login to Health Record',
                'button_text' => 'Patient Login',
                'link' => url('/login')
            ]
        ]);

        $about = HomeSetting::getSection('about_section', [
            'image' => null,
            'years_number' => '15+',
            'years_text' => "Years of Clinical\nHealthcare Excellence",
            'label' => 'About Hospital',
            'title' => 'Leading the Way in Patient-Centered Healthcare',
            'description' => 'We provide comprehensive tertiary healthcare, advanced surgical facilities, 24/7 emergency trauma care, and state-of-the-art diagnostic laboratories with a dedication to patient safety and clinical excellence.',
            'mission_title' => 'Our Mission',
            'mission_text' => 'Delivering ethical, precise, and affordable medical care to every patient with uncompromising quality.',
            'vision_title' => 'Our Vision',
            'vision_text' => 'To be South Asia\'s benchmark healthcare institution recognized for medical innovation and compassion.',
            'features' => [
                'Advanced Equipment',
                'Expert Pathologists',
                'Accurate Reports',
                'Fast Turnaround'
            ],
            'button_text' => 'Learn More About Us',
            'button_link' => url('/about')
        ]);

        $dbServices = Service::active()->ordered()->get();
        if ($dbServices->isNotEmpty()) {
            $facilities = $dbServices->map(function ($s) {
                return [
                    'slug' => $s->slug,
                    'title' => $s->title,
                    'badge' => $s->badge ?: 'Clinical Facility',
                    'badge_color' => $s->badge_color ?: 'teal',
                    'icon' => str_replace(['fa-solid ', 'fa-regular '], '', $s->icon ?: 'fa-hospital'),
                    'gradient' => $s->gradient ?: 'linear-gradient(135deg, #0D9488, #0f766e)',
                    'description' => $s->short_description ?: \Illuminate\Support\Str::limit($s->description, 130),
                    'points' => !empty($s->points) ? array_slice($s->points, 0, 2) : [],
                    'link' => url('/services/' . $s->slug),
                ];
            })->toArray();
        } else {
            $facilities = HomeSetting::getSection('facilities_section', [
                [
                    'slug' => 'emergency-icu',
                    'title' => '24/7 ICU & CCU Units',
                    'badge' => 'Critical Care',
                    'badge_color' => 'danger',
                    'icon' => 'fa-heart-pulse',
                    'gradient' => 'linear-gradient(135deg, #e11d48, #be123c)',
                    'description' => 'Advanced multi-parameter ventilators, invasive arterial monitoring, central telemetry, and round-the-clock intensivist & critical care nurse presence.',
                    'points' => ['High-end Dräger Ventilators', '1:1 Critical Care Nursing Ratio'],
                ],
                [
                    'slug' => 'operation-theatre',
                    'title' => 'Modular Operation Theatres',
                    'badge' => 'Surgical Suites',
                    'badge_color' => 'teal',
                    'icon' => 'fa-shield-virus',
                    'gradient' => 'linear-gradient(135deg, #0D9488, #0f766e)',
                    'description' => 'HEPA-filtered ultra-clean laminar airflow systems, advanced C-Arm fluoroscopy, Zeiss surgical microscopes, and high-definition laparoscopy suites.',
                    'points' => ['Class 100 Laminar Airflow (HEPA)', 'Minimally Invasive Laparoscopic Setup'],
                ],
                [
                    'slug' => 'inpatient-cabins',
                    'title' => 'Inpatient Cabins & Wards',
                    'badge' => ($bedCount > 0 ? $bedCount . '+ Bed Capacity' : '40+ Bed Capacity'),
                    'badge_color' => 'primary',
                    'icon' => 'fa-bed-pulse',
                    'gradient' => 'linear-gradient(135deg, #142D4E, #1e3a63)',
                    'description' => 'Air-conditioned VIP & Deluxe cabins, specialized male/female general wards, central medical oxygen outlets, and dedicated bedside attendant support.',
                    'points' => ['Motorized Hill-Rom ICU Beds', 'Central Medical Gas & Suction'],
                ],
                [
                    'slug' => 'emergency-icu',
                    'title' => '24/7 Trauma & Emergency',
                    'badge' => 'Immediate Triage',
                    'badge_color' => 'danger',
                    'icon' => 'fa-truck-medical',
                    'gradient' => 'linear-gradient(135deg, #e11d48, #9f1239)',
                    'description' => 'Dedicated resuscitation bays, acute trauma management, immediate stroke protocols, on-call surgical consultants, and ambulance dispatch.',
                    'points' => ['Immediate Resuscitation & Defibrillation', 'Cardiac Ambulances with Paramedics'],
                ],
                [
                    'slug' => 'central-pharmacy',
                    'title' => '24/7 Pharmacy & Blood Bank',
                    'badge' => 'Always In-Stock',
                    'badge_color' => 'success',
                    'icon' => 'fa-pills',
                    'gradient' => 'linear-gradient(135deg, #16A34A, #15803d)',
                    'description' => 'Hospital central pharmacy stocked with 100% genuine medications, temperature-controlled biological storage, and screened blood component bank.',
                    'points' => ['24/7 Direct Inpatient Medication Supply', 'Screened Whole Blood, Plasma & Platelets'],
                ],
            ]);
        }

        $whyChoose = HomeSetting::getSection('why_choose_section', [
            'image' => null,
            'label' => 'Quality & Standards',
            'title' => 'Why Patients Choose Our Hospital',
            'description' => 'We merge clinical expertise with world-class medical engineering to deliver safe, effective, and patient-centered hospital care.',
            'features' => [
                ['icon'=>'fa-user-doctor','color'=>'primary','title'=>'Board-Certified Specialists','desc'=>'Senior professors and multi-disciplinary doctors with international clinical fellowships.'],
                ['icon'=>'fa-microscope','color'=>'teal','title'=>'Fully Automated Pathology &amp; 3T MRI','desc'=>'Zero manual error rate with robotic analyzers, 128-Slice CT scan, and digital X-ray.'],
                ['icon'=>'fa-receipt','color'=>'success','title'=>'100% Transparent &amp; Ethical Billing','desc'=>'Clear itemized pricing with zero hidden charges and direct corporate insurance coverage.'],
                ['icon'=>'fa-shield-heart','color'=>'danger','title'=>'24/7 Critical Trauma &amp; ICU Care','desc'=>'Round-the-clock emergency admission, critical life support, and rapid response units.'],
            ]
        ]);

        $howItWorks = HomeSetting::getSection('how_it_works_section', [
            'label' => 'Seamless Experience',
            'title' => 'How It Works',
            'description' => 'Hassle-free access to hospital consultations, diagnostics, and patient care.',
            'steps' => [
                ['n'=>'1','icon'=>'fa-stethoscope','color'=>'#142D4E','title'=>'Choose Service','desc'=>'Select your preferred doctor, diagnostic test, or specialized health package.'],
                ['n'=>'2','icon'=>'fa-calendar-check','color'=>'#0D9488','title'=>'Schedule Slot','desc'=>'Pick your convenient date and time online or request home sample pickup.'],
                ['n'=>'3','icon'=>'fa-hospital-user','color'=>'#F59E0B','title'=>'Consult &amp; Care','desc'=>'Visit our doctor chambers or inpatient hospital wards for personalized treatment.'],
                ['n'=>'4','icon'=>'fa-file-medical-check','color'=>'#16A34A','title'=>'Get Digital Report','desc'=>'Receive SMS notifications and download verified PDF diagnostic reports online.'],
            ]
        ]);

        return view('frontend.home', compact(
            'tests', 'packages', 'departments', 'doctors', 'hero', 
            'stats', 'quickActions', 'about', 'facilities', 'whyChoose', 
            'howItWorks', 'testimonials', 'blogs',
            'doctorCount', 'bedCount', 'testCount', 'departmentCount', 'ambulanceCount', 'patientCount'
        ));
    }
}
