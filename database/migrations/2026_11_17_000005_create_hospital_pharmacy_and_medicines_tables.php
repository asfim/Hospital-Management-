<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pharmacy_medicines')) {
            Schema::create('pharmacy_medicines', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('generic_name')->nullable();
                $table->string('category')->default('General'); // Antibiotics, Analgesics, Antipyretics, Cardiovascular, Gastrointestinal, etc.
                $table->string('dosage_form')->default('Tablet'); // Tablet, Capsule, Syrup, Injection, Ointment, IV Fluid, Drop, Inhaler
                $table->string('strength')->nullable(); // 500mg, 10mg/5ml
                $table->string('manufacturer')->nullable(); // Square, Beximco, Incepta, etc.
                $table->decimal('unit_price', 10, 2)->default(0);
                $table->decimal('purchase_price', 10, 2)->default(0);
                $table->integer('reorder_level')->default(20);
                $table->string('status')->default('active'); // active, inactive
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('medicine_batches')) {
            Schema::create('medicine_batches', function (Blueprint $table) {
                $table->id();
                $table->foreignId('medicine_id')->constrained('pharmacy_medicines')->cascadeOnDelete();
                $table->string('batch_no');
                $table->date('expiry_date');
                $table->integer('quantity_in')->default(0);
                $table->integer('quantity_available')->default(0);
                $table->decimal('purchase_rate', 10, 2)->default(0);
                $table->decimal('sale_rate', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('pharmacy_sales')) {
            Schema::create('pharmacy_sales', function (Blueprint $table) {
                $table->id();
                $table->string('bill_no')->unique(); // PHM-2026-000001
                $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
                $table->foreignId('admission_id')->nullable()->constrained('admissions')->nullOnDelete();
                $table->unsignedBigInteger('prescription_id')->nullable();
                $table->string('customer_name')->nullable();
                $table->string('customer_phone')->nullable();
                $table->decimal('subtotal', 12, 2)->default(0);
                $table->decimal('discount', 12, 2)->default(0);
                $table->decimal('tax', 12, 2)->default(0);
                $table->decimal('total', 12, 2)->default(0);
                $table->decimal('paid', 12, 2)->default(0);
                $table->decimal('due', 12, 2)->default(0);
                $table->string('payment_method')->default('Cash'); // Cash, Card, bKash, Nagad, IPD Credit
                $table->string('payment_status')->default('Paid'); // Paid, Partial, Unpaid
                $table->unsignedBigInteger('sold_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('pharmacy_sale_items')) {
            Schema::create('pharmacy_sale_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pharmacy_sale_id')->constrained('pharmacy_sales')->cascadeOnDelete();
                $table->foreignId('medicine_id')->constrained('pharmacy_medicines')->cascadeOnDelete();
                $table->foreignId('medicine_batch_id')->nullable()->constrained('medicine_batches')->nullOnDelete();
                $table->integer('quantity');
                $table->decimal('unit_price', 10, 2);
                $table->decimal('total_price', 10, 2);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('medicine_returns')) {
            Schema::create('medicine_returns', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pharmacy_sale_id')->constrained('pharmacy_sales')->cascadeOnDelete();
                $table->foreignId('medicine_id')->constrained('pharmacy_medicines')->cascadeOnDelete();
                $table->foreignId('medicine_batch_id')->nullable()->constrained('medicine_batches')->nullOnDelete();
                $table->integer('quantity');
                $table->decimal('refund_amount', 10, 2)->default(0);
                $table->string('reason')->nullable();
                $table->unsignedBigInteger('returned_by')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('medicine_returns');
        Schema::dropIfExists('pharmacy_sale_items');
        Schema::dropIfExists('pharmacy_sales');
        Schema::dropIfExists('medicine_batches');
        Schema::dropIfExists('pharmacy_medicines');
    }
};
