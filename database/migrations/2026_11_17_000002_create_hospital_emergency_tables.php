<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('emergency_cases')) {
            Schema::create('emergency_cases', function (Blueprint $table) {
                $table->id();
                $table->string('case_no')->unique(); // EMG-2026-000001
                $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
                $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
                $table->unsignedBigInteger('nurse_id')->nullable();
                $table->string('triage_priority')->default('yellow'); // red (resuscitation), orange (emergent), yellow (urgent), green (less urgent), black (deceased)
                $table->string('arrival_mode')->default('Walk-in'); // Walk-in, Ambulance, Police, Transfer
                $table->dateTime('arrival_time');
                $table->text('presenting_complaints')->nullable();
                $table->text('treatment_given')->nullable();
                $table->foreignId('admission_id')->nullable()->constrained('admissions')->nullOnDelete();
                $table->string('status')->default('triaged'); // triaged, under_treatment, admitted_ipd, discharged, transferred, deceased
                $table->decimal('treatment_fee', 12, 2)->default(0);
                $table->string('payment_status')->default('Pending');
                $table->dateTime('discharged_at')->nullable();
                $table->text('discharge_notes')->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency_cases');
    }
};
