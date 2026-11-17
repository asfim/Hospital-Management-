<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Comprehensive modules list
        $modules = [
            'dashboard',
            'patients',
            'doctors',
            'appointments',
            'consultations',
            'prescriptions',
            'tests',
            'lab orders',
            'lab results',
            'radiology',
            'billing',
            'accounts',
            'reports',
            'staff',
            'settings',
            'roles',
            'ipd',
            'wards',
            'beds',
            'emergency',
            'nursing',
            'ot',
            'pharmacy',
            'inventory',
            'blood bank',
            'ambulance',
            'certificates',
        ];

        $actions = ['view', 'create', 'edit', 'delete', 'approve', 'print'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "$action $module"]);
            }
        }

        // 1. Super Admin & Admin (All permissions)
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $roleSuperAdmin->givePermissionTo(Permission::all());

        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleAdmin->givePermissionTo(Permission::all());

        $roleHospitalAdmin = Role::firstOrCreate(['name' => 'Hospital Admin']);
        $roleHospitalAdmin->givePermissionTo(Permission::all());

        // 2. Doctor
        $roleDoctor = Role::firstOrCreate(['name' => 'Doctor']);
        $doctorPerms = [
            'view dashboard',
            'view patients', 'create patients', 'edit patients',
            'view appointments', 'create appointments', 'edit appointments',
            'view consultations', 'create consultations', 'edit consultations', 'print consultations',
            'view prescriptions', 'create prescriptions', 'edit prescriptions', 'print prescriptions',
            'view ipd', 'edit ipd', 'view wards', 'view beds',
            'view emergency', 'edit emergency',
            'view ot', 'edit ot',
            'view lab orders', 'create lab orders', 'view lab results', 'print lab results',
            'view radiology', 'create radiology',
            'view certificates', 'create certificates', 'print certificates',
        ];
        $roleDoctor->syncPermissions(Permission::whereIn('name', $doctorPerms)->get());

        // 3. Nurse
        $roleNurse = Role::firstOrCreate(['name' => 'Nurse']);
        $nursePerms = [
            'view dashboard',
            'view patients',
            'view ipd', 'edit ipd',
            'view wards', 'view beds', 'edit beds',
            'view nursing', 'create nursing', 'edit nursing', 'print nursing',
            'view emergency', 'edit emergency',
            'view consultations', 'view prescriptions',
            'view lab orders', 'view lab results',
        ];
        $roleNurse->syncPermissions(Permission::whereIn('name', $nursePerms)->get());

        // 4. Receptionist
        $roleReceptionist = Role::firstOrCreate(['name' => 'Receptionist']);
        $recPerms = [
            'view dashboard',
            'view patients', 'create patients', 'edit patients', 'print patients',
            'view appointments', 'create appointments', 'edit appointments', 'delete appointments',
            'view ipd', 'create ipd',
            'view wards', 'view beds',
            'view emergency', 'create emergency',
            'view billing', 'create billing', 'edit billing', 'print billing',
            'view ambulance', 'create ambulance',
            'view doctors',
        ];
        $roleReceptionist->syncPermissions(Permission::whereIn('name', $recPerms)->get());

        // 5. Pharmacist
        $rolePharmacist = Role::firstOrCreate(['name' => 'Pharmacist']);
        $pharmPerms = [
            'view dashboard',
            'view pharmacy', 'create pharmacy', 'edit pharmacy', 'delete pharmacy', 'print pharmacy',
            'view prescriptions',
            'view billing', 'create billing', 'print billing',
            'view inventory',
        ];
        $rolePharmacist->syncPermissions(Permission::whereIn('name', $pharmPerms)->get());

        // 6. Lab Technician
        $roleLabTech = Role::firstOrCreate(['name' => 'Lab Technician']);
        $labTechPerms = [
            'view dashboard',
            'view tests',
            'view lab orders', 'create lab orders', 'edit lab orders',
            'view lab results', 'create lab results', 'edit lab results', 'print lab results',
        ];
        $roleLabTech->syncPermissions(Permission::whereIn('name', $labTechPerms)->get());

        // 7. Pathologist
        $rolePathologist = Role::firstOrCreate(['name' => 'Pathologist']);
        $pathPerms = [
            'view dashboard',
            'view tests', 'edit tests',
            'view lab orders',
            'view lab results', 'create lab results', 'edit lab results', 'approve lab results', 'print lab results',
        ];
        $rolePathologist->syncPermissions(Permission::whereIn('name', $pathPerms)->get());

        // 8. Radiologist
        $roleRadiologist = Role::firstOrCreate(['name' => 'Radiologist']);
        $radPerms = [
            'view dashboard',
            'view radiology', 'create radiology', 'edit radiology', 'approve radiology', 'print radiology',
            'view patients',
        ];
        $roleRadiologist->syncPermissions(Permission::whereIn('name', $radPerms)->get());

        // 9. Accountant
        $roleAccountant = Role::firstOrCreate(['name' => 'Accountant']);
        $accPerms = [
            'view dashboard',
            'view billing', 'create billing', 'edit billing', 'delete billing', 'print billing',
            'view accounts', 'create accounts', 'edit accounts', 'print accounts',
            'view reports', 'print reports',
            'view ipd', 'view pharmacy',
        ];
        $roleAccountant->syncPermissions(Permission::whereIn('name', $accPerms)->get());

        // 10. HR Manager
        $roleHr = Role::firstOrCreate(['name' => 'HR Manager']);
        $hrPerms = [
            'view dashboard',
            'view staff', 'create staff', 'edit staff', 'delete staff', 'print staff',
            'view reports',
        ];
        $roleHr->syncPermissions(Permission::whereIn('name', $hrPerms)->get());

        // 11. Store Manager
        $roleStore = Role::firstOrCreate(['name' => 'Store Manager']);
        $storePerms = [
            'view dashboard',
            'view inventory', 'create inventory', 'edit inventory', 'delete inventory', 'print inventory',
            'view pharmacy',
        ];
        $roleStore->syncPermissions(Permission::whereIn('name', $storePerms)->get());

        // 12. OT Manager
        $roleOtManager = Role::firstOrCreate(['name' => 'OT Manager']);
        $otPerms = [
            'view dashboard',
            'view ot', 'create ot', 'edit ot', 'delete ot', 'print ot',
            'view doctors', 'view patients',
        ];
        $roleOtManager->syncPermissions(Permission::whereIn('name', $otPerms)->get());

        // 13. Ward Manager
        $roleWardManager = Role::firstOrCreate(['name' => 'Ward Manager']);
        $wardPerms = [
            'view dashboard',
            'view wards', 'create wards', 'edit wards',
            'view beds', 'create beds', 'edit beds', 'delete beds',
            'view ipd',
        ];
        $roleWardManager->syncPermissions(Permission::whereIn('name', $wardPerms)->get());

        // 14. Patient
        $rolePatient = Role::firstOrCreate(['name' => 'Patient']);
        $patientPerms = [
            'view dashboard',
            'view appointments', 'create appointments',
            'view prescriptions', 'print prescriptions',
            'view lab results', 'print lab results',
            'view billing', 'print billing',
        ];
        $rolePatient->syncPermissions(Permission::whereIn('name', $patientPerms)->get());

        // Find Admin user and assign role
        $adminUser = \App\Models\User::where('email', 'admin@example.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('Super Admin');
            $adminUser->assignRole('Admin');
        }
    }
}
