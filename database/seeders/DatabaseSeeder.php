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
        $dept = Department::firstOrCreate(
            ['name' => 'Pathology'],
            [
                'description' => 'Pathology Department',
                'status' => true,
            ]
        );

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
