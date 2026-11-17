<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ot_rooms')) {
            Schema::create('ot_rooms', function (Blueprint $table) {
                $table->id();
                $table->string('room_number')->unique();
                $table->string('name');
                $table->string('type')->default('General'); // General, Cardiac, Orthopedic, Neuro, Laparoscopic
                $table->decimal('daily_charge', 12, 2)->default(0);
                $table->decimal('hourly_rate', 12, 2)->default(0);
                $table->string('status')->default('available'); // available, in_use, cleaning, maintenance
                $table->text('equipment_details')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('surgeries')) {
            Schema::create('surgeries', function (Blueprint $table) {
                $table->id();
                $table->string('surgery_no')->unique(); // SUR-2026-000001
                $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
                $table->foreignId('admission_id')->nullable()->constrained('admissions')->nullOnDelete();
                $table->foreignId('ot_room_id')->nullable()->constrained('ot_rooms')->nullOnDelete();
                $table->foreignId('lead_surgeon_id')->constrained('doctors')->cascadeOnDelete();
                $table->foreignId('anesthesiologist_id')->nullable()->constrained('doctors')->nullOnDelete();
                $table->string('surgery_name');
                $table->string('surgery_type')->default('Major'); // Minor, Major, Emergency, Elective
                $table->dateTime('scheduled_start');
                $table->dateTime('scheduled_end');
                $table->dateTime('actual_start')->nullable();
                $table->dateTime('actual_end')->nullable();
                $table->string('anesthesia_type')->default('General Anesthesia'); // General, Spinal, Local, Epidural, Sedation
                $table->text('pre_op_notes')->nullable();
                $table->text('op_notes')->nullable();
                $table->text('post_op_notes')->nullable();
                $table->decimal('surgeon_fee', 12, 2)->default(0);
                $table->decimal('anesthesia_fee', 12, 2)->default(0);
                $table->decimal('ot_room_charge', 12, 2)->default(0);
                $table->decimal('total_charge', 12, 2)->default(0);
                $table->string('status')->default('scheduled'); // scheduled, in_progress, completed, cancelled
                $table->string('payment_status')->default('Pending');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('surgery_staff')) {
            Schema::create('surgery_staff', function (Blueprint $table) {
                $table->id();
                $table->foreignId('surgery_id')->constrained('surgeries')->cascadeOnDelete();
                $table->foreignId('staff_id')->nullable()->constrained('staff')->nullOnDelete();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('role')->default('Assistant Surgeon'); // Assistant Surgeon, Scrub Nurse, Circulating Nurse, Technician
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('surgery_staff');
        Schema::dropIfExists('surgeries');
        Schema::dropIfExists('ot_rooms');
    }
};
