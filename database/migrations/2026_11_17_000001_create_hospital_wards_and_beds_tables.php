<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('wards')) {
            Schema::create('wards', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique()->nullable();
                $table->string('type')->default('General'); // General, Male, Female, ICU, CCU, NICU, PICU, Cabin, VIP
                $table->string('floor')->nullable();
                $table->string('gender_type')->default('Mixed'); // Male, Female, Mixed, Pediatric
                $table->integer('capacity')->default(0);
                $table->decimal('daily_charge', 12, 2)->default(0);
                $table->string('status')->default('Active'); // Active, Inactive, Maintenance
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('beds')) {
            Schema::create('beds', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ward_id')->constrained('wards')->cascadeOnDelete();
                $table->string('bed_number');
                $table->string('type')->default('Standard'); // Standard, Semi-Fowler, Fowler, Electric, ICU
                $table->decimal('daily_charge', 12, 2)->default(0);
                $table->string('status')->default('available'); // available, occupied, cleaning, maintenance
                $table->unsignedBigInteger('current_admission_id')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('admissions')) {
            Schema::create('admissions', function (Blueprint $table) {
                $table->id();
                $table->string('admission_no')->unique(); // ADM-2026-000001
                $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
                $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
                $table->string('referred_by')->nullable();
                $table->foreignId('ward_id')->nullable()->constrained('wards')->nullOnDelete();
                $table->foreignId('bed_id')->nullable()->constrained('beds')->nullOnDelete();
                $table->dateTime('admission_date');
                $table->dateTime('discharge_date')->nullable();
                $table->string('admission_reason')->nullable();
                $table->text('provisional_diagnosis')->nullable();
                $table->text('final_diagnosis')->nullable();
                $table->string('status')->default('admitted'); // admitted, transferred, discharged, deceased
                $table->decimal('total_deposit', 12, 2)->default(0);
                $table->decimal('total_billed', 12, 2)->default(0);
                $table->decimal('total_paid', 12, 2)->default(0);
                $table->decimal('total_due', 12, 2)->default(0);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('bed_transfers')) {
            Schema::create('bed_transfers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admission_id')->constrained('admissions')->cascadeOnDelete();
                $table->foreignId('from_bed_id')->nullable()->constrained('beds')->nullOnDelete();
                $table->foreignId('to_bed_id')->constrained('beds')->cascadeOnDelete();
                $table->dateTime('transferred_at');
                $table->string('reason')->nullable();
                $table->unsignedBigInteger('transferred_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('daily_charges')) {
            Schema::create('daily_charges', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admission_id')->constrained('admissions')->cascadeOnDelete();
                $table->date('charge_date');
                $table->string('charge_type')->default('bed'); // bed, doctor_round, nursing, equipment, service
                $table->string('description');
                $table->decimal('amount', 12, 2);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('discharge_summaries')) {
            Schema::create('discharge_summaries', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admission_id')->constrained('admissions')->cascadeOnDelete();
                $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
                $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
                $table->dateTime('discharge_date');
                $table->text('final_diagnosis')->nullable();
                $table->string('condition_on_discharge')->default('Improved'); // Cured, Improved, Unchanged, Deteriorated, Transferred, Dead
                $table->text('treatment_given')->nullable();
                $table->text('discharge_medications')->nullable();
                $table->text('dietary_advice')->nullable();
                $table->text('activity_advice')->nullable();
                $table->text('follow_up_instructions')->nullable();
                $table->date('follow_up_date')->nullable();
                $table->unsignedBigInteger('approved_by')->nullable();
                $table->dateTime('approved_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('discharge_summaries');
        Schema::dropIfExists('daily_charges');
        Schema::dropIfExists('bed_transfers');
        Schema::dropIfExists('admissions');
        Schema::dropIfExists('beds');
        Schema::dropIfExists('wards');
    }
};
