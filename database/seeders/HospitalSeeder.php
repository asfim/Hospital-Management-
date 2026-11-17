<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\OtRoom;
use App\Models\PharmacyMedicine;
use App\Models\MedicineBatch;
use App\Models\BloodDonor;
use App\Models\BloodInventory;
use App\Models\AmbulanceVehicle;
use App\Models\ExpenseCategory;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\Supplier;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Wards
        $wardsData = [
            ['name' => 'General Ward (Male)', 'code' => 'GWM-01', 'type' => 'Male', 'floor' => '2nd Floor', 'gender_type' => 'Male', 'capacity' => 10, 'daily_charge' => 800],
            ['name' => 'General Ward (Female)', 'code' => 'GWF-01', 'type' => 'Female', 'floor' => '2nd Floor', 'gender_type' => 'Female', 'capacity' => 10, 'daily_charge' => 800],
            ['name' => 'Intensive Care Unit (ICU)', 'code' => 'ICU-01', 'type' => 'ICU', 'floor' => '3rd Floor', 'gender_type' => 'Mixed', 'capacity' => 6, 'daily_charge' => 5000],
            ['name' => 'Coronary Care Unit (CCU)', 'code' => 'CCU-01', 'type' => 'CCU', 'floor' => '3rd Floor', 'gender_type' => 'Mixed', 'capacity' => 6, 'daily_charge' => 4500],
            ['name' => 'VIP Cabin Block', 'code' => 'CAB-VIP', 'type' => 'VIP', 'floor' => '4th Floor', 'gender_type' => 'Mixed', 'capacity' => 5, 'daily_charge' => 3500],
            ['name' => 'Pediatric / NICU', 'code' => 'NICU-01', 'type' => 'NICU', 'floor' => '3rd Floor', 'gender_type' => 'Pediatric', 'capacity' => 4, 'daily_charge' => 4000],
        ];

        foreach ($wardsData as $w) {
            $ward = Ward::firstOrCreate(['code' => $w['code']], $w);

            // Create Beds for this ward if none exist
            if ($ward->beds()->count() == 0) {
                for ($i = 1; $i <= $w['capacity']; $i++) {
                    Bed::create([
                        'ward_id' => $ward->id,
                        'bed_number' => $w['code'] . '-B' . str_pad($i, 2, '0', STR_PAD_LEFT),
                        'type' => ($w['type'] == 'ICU' || $w['type'] == 'CCU') ? 'ICU Bed' : 'Standard Hospital Bed',
                        'daily_charge' => $w['daily_charge'],
                        'status' => 'available',
                    ]);
                }
            }
        }

        // 2. OT Rooms
        $otRooms = [
            ['room_number' => 'OT-01', 'name' => 'Main Surgery Theatre', 'type' => 'General', 'daily_charge' => 10000, 'hourly_rate' => 2000, 'status' => 'available'],
            ['room_number' => 'OT-02', 'name' => 'Laparoscopic Theatre', 'type' => 'Laparoscopic', 'daily_charge' => 12000, 'hourly_rate' => 2500, 'status' => 'available'],
            ['room_number' => 'OT-03', 'name' => 'Orthopedic Theatre', 'type' => 'Orthopedic', 'daily_charge' => 15000, 'hourly_rate' => 3000, 'status' => 'available'],
        ];
        foreach ($otRooms as $ot) {
            OtRoom::firstOrCreate(['room_number' => $ot['room_number']], $ot);
        }

        // 3. Medicines & Batches
        $medicines = [
            ['name' => 'Napa Extra 500mg/65mg', 'generic_name' => 'Paracetamol + Caffeine', 'category' => 'Analgesics', 'dosage_form' => 'Tablet', 'strength' => '500mg/65mg', 'manufacturer' => 'Beximco Pharmaceuticals', 'unit_price' => 3.00, 'purchase_price' => 2.20, 'reorder_level' => 50],
            ['name' => 'Seclo 20mg', 'generic_name' => 'Omeprazole', 'category' => 'Gastrointestinal', 'dosage_form' => 'Capsule', 'strength' => '20mg', 'manufacturer' => 'Square Pharmaceuticals', 'unit_price' => 6.00, 'purchase_price' => 4.50, 'reorder_level' => 40],
            ['name' => 'Moxacil 500mg', 'generic_name' => 'Amoxicillin', 'category' => 'Antibiotics', 'dosage_form' => 'Capsule', 'strength' => '500mg', 'manufacturer' => 'Square Pharmaceuticals', 'unit_price' => 8.00, 'purchase_price' => 6.00, 'reorder_level' => 30],
            ['name' => 'Ceftron 1g IV/IM', 'generic_name' => 'Ceftriaxone', 'category' => 'Antibiotics', 'dosage_form' => 'Injection', 'strength' => '1g', 'manufacturer' => 'Square Pharmaceuticals', 'unit_price' => 180.00, 'purchase_price' => 140.00, 'reorder_level' => 20],
            ['name' => 'Normal Saline 0.9% 1000ml', 'generic_name' => 'Sodium Chloride', 'category' => 'IV Fluid', 'dosage_form' => 'IV Fluid', 'strength' => '0.9%', 'manufacturer' => 'Orion Infusion', 'unit_price' => 95.00, 'purchase_price' => 70.00, 'reorder_level' => 25],
            ['name' => 'Compath 500mg', 'generic_name' => 'Ciprofloxacin', 'category' => 'Antibiotics', 'dosage_form' => 'Tablet', 'strength' => '500mg', 'manufacturer' => 'Incepta Pharmaceuticals', 'unit_price' => 15.00, 'purchase_price' => 11.50, 'reorder_level' => 30],
        ];

        foreach ($medicines as $medData) {
            $med = PharmacyMedicine::firstOrCreate(['name' => $medData['name']], $medData);
            if ($med->batches()->count() == 0) {
                MedicineBatch::create([
                    'medicine_id' => $med->id,
                    'batch_no' => 'BCH-' . date('Y') . '-' . rand(1000, 9999),
                    'expiry_date' => now()->addMonths(rand(12, 24))->toDateString(),
                    'quantity_in' => 500,
                    'quantity_available' => 500,
                    'purchase_rate' => $med->purchase_price,
                    'sale_rate' => $med->unit_price,
                ]);
            }
        }

        // 4. Blood Donors & Inventory
        $donors = [
            ['donor_code' => 'BD-0001', 'name' => 'Kamal Hossain', 'gender' => 'Male', 'age' => 28, 'blood_group' => 'O+', 'mobile' => '01700112233', 'address' => 'Mirpur-10, Dhaka', 'status' => 'Eligible'],
            ['donor_code' => 'BD-0002', 'name' => 'Tanvir Ahmed', 'gender' => 'Male', 'age' => 32, 'blood_group' => 'A+', 'mobile' => '01811223344', 'address' => 'Uttara, Dhaka', 'status' => 'Eligible'],
            ['donor_code' => 'BD-0003', 'name' => 'Shakil Mahmud', 'gender' => 'Male', 'age' => 25, 'blood_group' => 'B+', 'mobile' => '01922334455', 'address' => 'Dhanmondi, Dhaka', 'status' => 'Eligible'],
        ];

        foreach ($donors as $d) {
            $donor = BloodDonor::firstOrCreate(['donor_code' => $d['donor_code']], $d);
            if ($donor->donations()->count() == 0) {
                BloodInventory::create([
                    'bag_number' => 'BAG-' . date('Y') . '-' . rand(10000, 99999),
                    'blood_group' => $donor->blood_group,
                    'component_type' => 'Whole Blood',
                    'donor_id' => $donor->id,
                    'collected_at' => now()->subDays(5)->toDateString(),
                    'expiry_date' => now()->addDays(30)->toDateString(),
                    'status' => 'available',
                    'storage_location' => 'Blood Bank Refrigerator #1',
                ]);
            }
        }

        // 5. Ambulance Fleet
        $ambulances = [
            ['vehicle_number' => 'DHA-MET-CHA-11-2024', 'vehicle_model' => 'Toyota HiAce Ambulance', 'type' => 'Advanced Life Support', 'driver_name' => 'Md. Rafiqul Islam', 'driver_phone' => '01712345678', 'standard_fare' => 2500, 'per_km_rate' => 35],
            ['vehicle_number' => 'DHA-MET-CHA-11-2025', 'vehicle_model' => 'Hyundai H1 Ambulance', 'type' => 'Basic Life Support', 'driver_name' => 'Md. Jahangir Alam', 'driver_phone' => '01812345678', 'standard_fare' => 1500, 'per_km_rate' => 25],
        ];

        foreach ($ambulances as $amb) {
            AmbulanceVehicle::firstOrCreate(['vehicle_number' => $amb['vehicle_number']], $amb);
        }

        // 6. Expense Categories
        $expCats = [
            ['name' => 'Hospital Utilities & Bills', 'description' => 'Electricity, Water, Gas, Internet bills'],
            ['name' => 'Medical Consumables & Supplies', 'description' => 'Gloves, Syringes, Bandages, Disinfectants'],
            ['name' => 'Equipment Maintenance & Repair', 'description' => 'Biomedical engineering, MRI/CT servicing'],
            ['name' => 'Staff Salaries & Overtime', 'description' => 'Monthly payroll and staff allowances'],
            ['name' => 'Office Stationery & Printing', 'description' => 'Prescription pads, admission files, receipts'],
        ];
        foreach ($expCats as $ec) {
            ExpenseCategory::firstOrCreate(['name' => $ec['name']], $ec);
        }

        // 7. Inventory Items & Suppliers
        $sup = Supplier::firstOrCreate(['name' => 'Popular Diagnostic & Medical Suppliers Ltd.'], [
            'contact_person' => 'Md. Enamul Haque',
            'phone' => '01711223399',
            'email' => 'sales@popularmed.com',
            'address' => 'Motijheel C/A, Dhaka'
        ]);

        $invCat = InventoryCategory::firstOrCreate(['name' => 'Medical Disposables'], ['description' => 'Single use medical items']);
        $invItems = [
            ['name' => 'Disposable Syringes 5ml', 'category_id' => $invCat->id, 'unit' => 'box', 'quantity' => 120, 'reorder_level' => 20, 'unit_cost' => 250],
            ['name' => 'Latex Examination Gloves (M)', 'category_id' => $invCat->id, 'unit' => 'box', 'quantity' => 80, 'reorder_level' => 15, 'unit_cost' => 380],
            ['name' => 'Sterile Gauze Bandages', 'category_id' => $invCat->id, 'unit' => 'roll', 'quantity' => 200, 'reorder_level' => 30, 'unit_cost' => 45],
        ];
        foreach ($invItems as $item) {
            InventoryItem::firstOrCreate(['name' => $item['name']], $item);
        }
    }
}
