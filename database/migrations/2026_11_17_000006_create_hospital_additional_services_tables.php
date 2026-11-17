<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Blood Bank
        if (!Schema::hasTable('blood_donors')) {
            Schema::create('blood_donors', function (Blueprint $table) {
                $table->id();
                $table->string('donor_code')->unique(); // BD-0001
                $table->string('name');
                $table->string('gender')->default('Male');
                $table->integer('age')->nullable();
                $table->string('blood_group'); // A+, A-, B+, B-, AB+, AB-, O+, O-
                $table->string('mobile');
                $table->string('email')->nullable();
                $table->string('address')->nullable();
                $table->date('last_donated_at')->nullable();
                $table->string('status')->default('Eligible'); // Eligible, Ineligible, Deferred
                $table->text('medical_notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('blood_inventories')) {
            Schema::create('blood_inventories', function (Blueprint $table) {
                $table->id();
                $table->string('bag_number')->unique(); // BAG-2026-00001
                $table->string('blood_group');
                $table->string('component_type')->default('Whole Blood'); // Whole Blood, PRBC, Platelets, FFP, Cryoprecipitate
                $table->foreignId('donor_id')->nullable()->constrained('blood_donors')->nullOnDelete();
                $table->date('collected_at');
                $table->date('expiry_date');
                $table->string('status')->default('available'); // available, reserved, issued, expired, discarded
                $table->string('storage_location')->nullable(); // Refrigerator 1, Shelf B
                $table->unsignedBigInteger('issued_to_patient_id')->nullable();
                $table->dateTime('issued_at')->nullable();
                $table->timestamps();
            });
        }

        // 2. Ambulance
        if (!Schema::hasTable('ambulance_vehicles')) {
            Schema::create('ambulance_vehicles', function (Blueprint $table) {
                $table->id();
                $table->string('vehicle_number')->unique(); // DHA-MET-CHA-11-2233
                $table->string('vehicle_model')->nullable();
                $table->string('type')->default('Basic'); // Basic Life Support, Advanced Life Support, ICU, Neonatal
                $table->string('driver_name');
                $table->string('driver_phone');
                $table->string('status')->default('available'); // available, on_trip, maintenance
                $table->decimal('standard_fare', 10, 2)->default(0);
                $table->decimal('per_km_rate', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('ambulance_requests')) {
            Schema::create('ambulance_requests', function (Blueprint $table) {
                $table->id();
                $table->string('request_no')->unique(); // AMB-2026-000001
                $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
                $table->foreignId('ambulance_vehicle_id')->nullable()->constrained('ambulance_vehicles')->nullOnDelete();
                $table->string('contact_name');
                $table->string('contact_phone');
                $table->string('pickup_location');
                $table->string('destination');
                $table->decimal('distance_km', 6, 2)->nullable();
                $table->decimal('fare_amount', 10, 2)->default(0);
                $table->decimal('paid_amount', 10, 2)->default(0);
                $table->string('status')->default('pending'); // pending, dispatched, completed, cancelled
                $table->dateTime('requested_at');
                $table->dateTime('completed_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 3. Insurance & TPA
        if (!Schema::hasTable('insurance_companies')) {
            Schema::create('insurance_companies', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->string('contact_person')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->string('status')->default('Active');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('patient_insurances')) {
            Schema::create('patient_insurances', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
                $table->foreignId('insurance_company_id')->constrained('insurance_companies')->cascadeOnDelete();
                $table->string('policy_number');
                $table->decimal('coverage_amount', 12, 2)->default(0);
                $table->date('expiry_date')->nullable();
                $table->string('status')->default('Active');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 4. Vital Records & Certificates
        if (!Schema::hasTable('birth_records')) {
            Schema::create('birth_records', function (Blueprint $table) {
                $table->id();
                $table->string('record_no')->unique(); // BR-2026-00001
                $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete(); // Mother
                $table->string('baby_name')->nullable();
                $table->string('gender')->default('Male');
                $table->date('birth_date');
                $table->time('birth_time')->nullable();
                $table->decimal('weight_kg', 4, 2)->nullable();
                $table->string('mother_name');
                $table->string('father_name')->nullable();
                $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('death_records')) {
            Schema::create('death_records', function (Blueprint $table) {
                $table->id();
                $table->string('record_no')->unique(); // DR-2026-00001
                $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
                $table->foreignId('admission_id')->nullable()->constrained('admissions')->nullOnDelete();
                $table->date('death_date');
                $table->time('death_time')->nullable();
                $table->text('cause_of_death');
                $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('medical_certificates')) {
            Schema::create('medical_certificates', function (Blueprint $table) {
                $table->id();
                $table->string('certificate_no')->unique(); // MC-2026-00001
                $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
                $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
                $table->string('type')->default('Medical Fitness'); // Medical Fitness, Sick Leave, Discharge Certificate
                $table->string('diagnosis')->nullable();
                $table->date('from_date')->nullable();
                $table->date('to_date')->nullable();
                $table->text('recommendations')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_certificates');
        Schema::dropIfExists('death_records');
        Schema::dropIfExists('birth_records');
        Schema::dropIfExists('patient_insurances');
        Schema::dropIfExists('insurance_companies');
        Schema::dropIfExists('ambulance_requests');
        Schema::dropIfExists('ambulance_vehicles');
        Schema::dropIfExists('blood_inventories');
        Schema::dropIfExists('blood_donors');
    }
};
