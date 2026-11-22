<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\TestCategory;
use App\Models\Test;
use App\Models\Invoice;
use App\Models\DiagnosticOrder;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles & Permissions first
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(ServiceSeeder::class);

        // 2. Admin User (Idempotent: create if missing, or retrieve existing)
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (!$admin->hasRole('Super Admin')) {
            $admin->assignRole('Super Admin');
        }

        // 3. Doctors
        $doc1 = Doctor::firstOrCreate(
            ['doctor_id' => 'DR-0001'],
            [
                'name' => 'Dr. Abul Hasan',
                'mobile' => '01711122233',
                'email' => 'abul@example.com',
                'specialization' => 'Medicine',
                'qualification' => 'MBBS, FCPS (Medicine)',
                'consultation_fee' => 1000,
                'status' => true,
            ]
        );

        $doc2 = Doctor::firstOrCreate(
            ['doctor_id' => 'DR-0002'],
            [
                'name' => 'Dr. Sadia Islam',
                'mobile' => '01822233344',
                'email' => 'sadia@example.com',
                'specialization' => 'Gynaecology',
                'qualification' => 'MBBS, DGO, MCPS',
                'consultation_fee' => 1200,
                'status' => true,
            ]
        );

        // 4. Patients
        $pat1 = Patient::firstOrCreate(
            ['patient_id' => 'PT-260916-0001'],
            [
                'name' => 'Rahim Uddin',
                'mobile' => '01511112222',
                'age' => 45,
                'gender' => 'Male',
                'blood_group' => 'O+',
                'address' => 'Mirpur, Dhaka',
            ]
        );

        $pat2 = Patient::firstOrCreate(
            ['patient_id' => 'PT-260916-0002'],
            [
                'name' => 'Fatema Begum',
                'mobile' => '01622223333',
                'age' => 32,
                'gender' => 'Female',
                'blood_group' => 'A+',
                'address' => 'Dhanmondi, Dhaka',
            ]
        );

        // 5. Departments & Categories
        $defaultDepts = [
            ['name' => 'Neurology', 'slug' => 'neurology', 'description' => 'Comprehensive diagnosis and treatment of complex neurological disorders, brain injuries, stroke management, spinal conditions, and neuro-rehabilitation with 24/7 neuro-critical care.', 'icon' => 'fa-solid fa-brain'],
            ['name' => 'Cardiology', 'slug' => 'cardiology', 'description' => 'Advanced cardiovascular diagnosis, coronary care, interventional cardiology, echo-cardiography, and emergency stroke and cardiac resuscitation with specialized CCU facilities.', 'icon' => 'fa-solid fa-heart-pulse'],
            ['name' => 'Orthopedics', 'slug' => 'orthopedics', 'description' => 'Specialized musculoskeletal care including bone trauma surgery, joint replacements, sports injuries, arthroscopic interventions, and specialized post-operative physiotherapy.', 'icon' => 'fa-solid fa-bone'],
            ['name' => 'Pediatrics', 'slug' => 'pediatrics', 'description' => 'Compassionate neonatal and pediatric care, newborn intensive care (NICU), child immunizations, developmental pediatrics, and pediatric emergency services.', 'icon' => 'fa-solid fa-baby'],
            ['name' => 'General Surgery', 'slug' => 'surgery', 'description' => 'State-of-the-art modular surgical theaters for minimally invasive laparoscopic, abdominal, trauma, and elective surgical procedures with dedicated post-op ICU support.', 'icon' => 'fa-solid fa-stethoscope'],
            ['name' => 'Gynecology & Obstetrics', 'slug' => 'gynecology', 'description' => 'Dedicated maternal and women health center offering antenatal care, high-risk pregnancy monitoring, normal & cesarean delivery, reproductive endocrinology, and fertility support.', 'icon' => 'fa-solid fa-venus'],
            ['name' => 'Nephrology', 'slug' => 'nephrology', 'description' => 'Kidney disease management, high-flux hemodialysis, peritoneal dialysis, hypertension clinic, and collaborative renal failure prevention programs.', 'icon' => 'fa-solid fa-hand-holding-droplet'],
            ['name' => 'Pathology', 'slug' => 'pathology', 'description' => 'Fully automated diagnostic laboratory providing accurate hematology, biochemistry, immunology, molecular diagnostics, and histopathology testing services.', 'icon' => 'fa-solid fa-flask-vial'],
            ['name' => 'Radiology', 'slug' => 'radiology', 'description' => 'Precision digital medical imaging including high-resolution digital X-rays, 4D ultrasonography, CT scan, and interventional radiology reports with rapid turnaround.', 'icon' => 'fa-solid fa-x-ray'],
            ['name' => 'Internal Medicine', 'slug' => 'medicine', 'description' => 'Adult preventive medicine, chronic disease management (diabetes, hypertension, asthma), geriatric care, infectious disease screening, and outpatient consultations.', 'icon' => 'fa-solid fa-capsules'],
        ];

        foreach ($defaultDepts as $d) {
            Department::firstOrCreate(
                ['slug' => $d['slug']],
                [
                    'name' => $d['name'],
                    'description' => $d['description'],
                    'icon' => $d['icon'],
                    'status' => true,
                ]
            );
        }

        $dept = Department::where('slug', 'pathology')->first();

        $cat = TestCategory::firstOrCreate(
            ['name' => 'Hematology'],
            [
                'department_id' => $dept->id,
                'status' => true,
            ]
        );

        // 6. Master Tests
        $test1 = Test::firstOrCreate(
            ['test_code' => 'CBC-01'],
            [
                'name' => 'Complete Blood Count (CBC)',
                'department_id' => $dept->id,
                'test_category_id' => $cat->id,
                'price' => 500,
                'cost' => 200,
                'status' => true,
            ]
        );

        $test2 = Test::firstOrCreate(
            ['test_code' => 'RBS-01'],
            [
                'name' => 'Random Blood Sugar (RBS)',
                'department_id' => $dept->id,
                'test_category_id' => $cat->id,
                'price' => 150,
                'cost' => 50,
                'status' => true,
            ]
        );

        // 7. Appointment
        Appointment::firstOrCreate(
            ['appointment_id' => 'APT-260916-0001'],
            [
                'patient_id' => $pat1->id,
                'doctor_id' => $doc1->id,
                'date' => date('Y-m-d'),
                'time' => '10:00:00',
                'status' => 'Pending',
            ]
        );

        // 8. Lab Order
        DiagnosticOrder::firstOrCreate(
            ['order_id' => 'ORD-260916-0001'],
            [
                'patient_id' => $pat2->id,
                'order_date' => date('Y-m-d'),
                'total_amount' => 650,
                'discount' => 50,
                'paid_amount' => 600,
                'due_amount' => 0,
                'payment_status' => 'Paid',
                'order_status' => 'Pending',
            ]
        );

        // 9. Invoice
        Invoice::firstOrCreate(
            ['invoice_no' => 'INV-260916-0001'],
            [
                'patient_id' => $pat1->id,
                'date' => date('Y-m-d'),
                'subtotal' => 1000,
                'discount' => 100,
                'total' => 900,
                'paid' => 900,
                'due' => 0,
                'payment_method' => 'Cash',
                'payment_status' => 'Paid',
            ]
        );

        // 10. Seed Hospital Wards, Beds, Medicines, Ambulances, etc.
        $this->call(HospitalSeeder::class);

        // 11. Seed Hospital Branches
        $this->call(BranchSeeder::class);

        // 12. Seed Patient Testimonials
        $this->call(TestimonialSeeder::class);
    }
}
