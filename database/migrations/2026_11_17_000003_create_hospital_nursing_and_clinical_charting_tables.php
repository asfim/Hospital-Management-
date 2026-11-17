<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('patient_vitals')) {
            Schema::create('patient_vitals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
                $table->foreignId('admission_id')->nullable()->constrained('admissions')->cascadeOnDelete();
                $table->foreignId('emergency_case_id')->nullable()->constrained('emergency_cases')->nullOnDelete();
                $table->unsignedBigInteger('visit_id')->nullable();
                $table->string('systolic_bp')->nullable();
                $table->string('diastolic_bp')->nullable();
                $table->string('pulse_rate')->nullable();
                $table->string('temperature')->nullable(); // in Fahrenheit
                $table->string('respiratory_rate')->nullable();
                $table->string('spo2')->nullable(); // percentage
                $table->string('blood_sugar')->nullable();
                $table->decimal('weight', 6, 2)->nullable(); // kg
                $table->decimal('height', 6, 2)->nullable(); // cm
                $table->decimal('bmi', 5, 2)->nullable();
                $table->text('notes')->nullable();
                $table->dateTime('recorded_at');
                $table->unsignedBigInteger('recorded_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('nursing_notes')) {
            Schema::create('nursing_notes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admission_id')->constrained('admissions')->cascadeOnDelete();
                $table->unsignedBigInteger('nurse_id')->nullable();
                $table->string('shift')->default('Morning'); // Morning, Evening, Night
                $table->string('note_type')->default('Routine'); // Routine, Incident, Doctor Order, Handover
                $table->text('content');
                $table->dateTime('recorded_at');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('nursing_assignments')) {
            Schema::create('nursing_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admission_id')->constrained('admissions')->cascadeOnDelete();
                $table->foreignId('nurse_id')->nullable()->constrained('users')->nullOnDelete();
                $table->date('date');
                $table->string('shift')->default('Morning'); // Morning, Evening, Night
                $table->string('status')->default('Assigned'); // Assigned, Active, Completed
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('medication_charts')) {
            Schema::create('medication_charts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admission_id')->constrained('admissions')->cascadeOnDelete();
                $table->string('medicine_name');
                $table->string('dosage'); // e.g. 500mg, 1 ampoule
                $table->string('frequency'); // 1-0-1, TDS, QID, PRN
                $table->string('route')->default('Oral'); // Oral, IV, IM, SC, Topical
                $table->date('start_date');
                $table->date('end_date')->nullable();
                $table->text('instructions')->nullable();
                $table->string('status')->default('active'); // active, stopped, completed
                $table->unsignedBigInteger('prescribed_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('medication_administrations')) {
            Schema::create('medication_administrations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('medication_chart_id')->constrained('medication_charts')->cascadeOnDelete();
                $table->dateTime('scheduled_time');
                $table->dateTime('administered_at')->nullable();
                $table->unsignedBigInteger('administered_by')->nullable();
                $table->string('status')->default('given'); // given, missed, refused, held
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('intake_output_charts')) {
            Schema::create('intake_output_charts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admission_id')->constrained('admissions')->cascadeOnDelete();
                $table->dateTime('recorded_at');
                $table->string('intake_type')->nullable(); // Oral, IV Fluid, NG Tube, Blood
                $table->decimal('intake_amount_ml', 8, 2)->default(0);
                $table->string('output_type')->nullable(); // Urine, Drain, Vomitus, Stool
                $table->decimal('output_amount_ml', 8, 2)->default(0);
                $table->unsignedBigInteger('recorded_by')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('intake_output_charts');
        Schema::dropIfExists('medication_administrations');
        Schema::dropIfExists('medication_charts');
        Schema::dropIfExists('nursing_assignments');
        Schema::dropIfExists('nursing_notes');
        Schema::dropIfExists('patient_vitals');
    }
};
