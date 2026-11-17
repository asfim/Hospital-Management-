<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Upgrade expense_categories
        if (Schema::hasTable('expense_categories')) {
            Schema::table('expense_categories', function (Blueprint $table) {
                if (!Schema::hasColumn('expense_categories', 'name')) {
                    $table->string('name')->after('id');
                }
                if (!Schema::hasColumn('expense_categories', 'description')) {
                    $table->text('description')->nullable()->after('name');
                }
                if (!Schema::hasColumn('expense_categories', 'status')) {
                    $table->boolean('status')->default(true)->after('description');
                }
            });
        }

        // 2. Upgrade expenses
        if (Schema::hasTable('expenses')) {
            Schema::table('expenses', function (Blueprint $table) {
                if (!Schema::hasColumn('expenses', 'expense_category_id')) {
                    $table->unsignedBigInteger('expense_category_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('expenses', 'branch_id')) {
                    $table->unsignedBigInteger('branch_id')->nullable()->after('expense_category_id');
                }
                if (!Schema::hasColumn('expenses', 'title')) {
                    $table->string('title')->after('branch_id');
                }
                if (!Schema::hasColumn('expenses', 'amount')) {
                    $table->decimal('amount', 12, 2)->default(0)->after('title');
                }
                if (!Schema::hasColumn('expenses', 'date')) {
                    $table->date('date')->after('amount');
                }
                if (!Schema::hasColumn('expenses', 'payment_method')) {
                    $table->string('payment_method')->default('Cash')->after('date');
                }
                if (!Schema::hasColumn('expenses', 'reference_no')) {
                    $table->string('reference_no')->nullable()->after('payment_method');
                }
                if (!Schema::hasColumn('expenses', 'note')) {
                    $table->text('note')->nullable()->after('reference_no');
                }
                if (!Schema::hasColumn('expenses', 'created_by')) {
                    $table->unsignedBigInteger('created_by')->nullable()->after('note');
                }
            });
        }

        // 3. Upgrade samples
        if (Schema::hasTable('samples')) {
            Schema::table('samples', function (Blueprint $table) {
                if (!Schema::hasColumn('samples', 'order_id')) {
                    $table->unsignedBigInteger('order_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('samples', 'patient_id')) {
                    $table->unsignedBigInteger('patient_id')->nullable()->after('order_id');
                }
                if (!Schema::hasColumn('samples', 'test_id')) {
                    $table->unsignedBigInteger('test_id')->nullable()->after('patient_id');
                }
                if (!Schema::hasColumn('samples', 'sample_code')) {
                    $table->string('sample_code')->nullable()->after('test_id');
                }
                if (!Schema::hasColumn('samples', 'specimen_type')) {
                    $table->string('specimen_type')->default('Blood')->after('sample_code');
                }
                if (!Schema::hasColumn('samples', 'barcode')) {
                    $table->string('barcode')->nullable()->after('specimen_type');
                }
                if (!Schema::hasColumn('samples', 'collected_by')) {
                    $table->unsignedBigInteger('collected_by')->nullable()->after('barcode');
                }
                if (!Schema::hasColumn('samples', 'collected_at')) {
                    $table->dateTime('collected_at')->nullable()->after('collected_by');
                }
                if (!Schema::hasColumn('samples', 'received_by')) {
                    $table->unsignedBigInteger('received_by')->nullable()->after('collected_at');
                }
                if (!Schema::hasColumn('samples', 'received_at')) {
                    $table->dateTime('received_at')->nullable()->after('received_by');
                }
                if (!Schema::hasColumn('samples', 'status')) {
                    $table->string('status')->default('Pending')->after('received_at'); // Pending, Collected, Received, Processing, Completed, Rejected
                }
                if (!Schema::hasColumn('samples', 'rejection_reason')) {
                    $table->text('rejection_reason')->nullable()->after('status');
                }
            });
        }

        // 4. Upgrade radiology_orders
        if (Schema::hasTable('radiology_orders')) {
            Schema::table('radiology_orders', function (Blueprint $table) {
                if (!Schema::hasColumn('radiology_orders', 'order_no')) {
                    $table->string('order_no')->nullable()->after('id');
                }
                if (!Schema::hasColumn('radiology_orders', 'patient_id')) {
                    $table->unsignedBigInteger('patient_id')->nullable()->after('order_no');
                }
                if (!Schema::hasColumn('radiology_orders', 'doctor_id')) {
                    $table->unsignedBigInteger('doctor_id')->nullable()->after('patient_id');
                }
                if (!Schema::hasColumn('radiology_orders', 'admission_id')) {
                    $table->unsignedBigInteger('admission_id')->nullable()->after('doctor_id');
                }
                if (!Schema::hasColumn('radiology_orders', 'test_name')) {
                    $table->string('test_name')->default('X-Ray')->after('admission_id'); // X-Ray, CT Scan, MRI, Ultrasound, ECG, Echo
                }
                if (!Schema::hasColumn('radiology_orders', 'modality')) {
                    $table->string('modality')->default('X-Ray')->after('test_name');
                }
                if (!Schema::hasColumn('radiology_orders', 'clinical_indication')) {
                    $table->text('clinical_indication')->nullable()->after('modality');
                }
                if (!Schema::hasColumn('radiology_orders', 'amount')) {
                    $table->decimal('amount', 12, 2)->default(0)->after('clinical_indication');
                }
                if (!Schema::hasColumn('radiology_orders', 'status')) {
                    $table->string('status')->default('pending')->after('amount'); // pending, in_progress, reported, cancelled
                }
            });
        }

        // 5. Upgrade radiology_reports
        if (Schema::hasTable('radiology_reports')) {
            Schema::table('radiology_reports', function (Blueprint $table) {
                if (!Schema::hasColumn('radiology_reports', 'radiology_order_id')) {
                    $table->unsignedBigInteger('radiology_order_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('radiology_reports', 'patient_id')) {
                    $table->unsignedBigInteger('patient_id')->nullable()->after('radiology_order_id');
                }
                if (!Schema::hasColumn('radiology_reports', 'radiologist_id')) {
                    $table->unsignedBigInteger('radiologist_id')->nullable()->after('patient_id');
                }
                if (!Schema::hasColumn('radiology_reports', 'findings')) {
                    $table->longText('findings')->nullable()->after('radiologist_id');
                }
                if (!Schema::hasColumn('radiology_reports', 'impression')) {
                    $table->text('impression')->nullable()->after('findings');
                }
                if (!Schema::hasColumn('radiology_reports', 'image_path')) {
                    $table->string('image_path')->nullable()->after('impression');
                }
                if (!Schema::hasColumn('radiology_reports', 'status')) {
                    $table->string('status')->default('Final')->after('image_path'); // Draft, Final
                }
            });
        }

        // 6. Upgrade invoices
        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                if (!Schema::hasColumn('invoices', 'invoice_type')) {
                    $table->string('invoice_type')->default('general')->after('invoice_no'); // opd, ipd, diagnostic, pharmacy, emergency, general
                }
                if (!Schema::hasColumn('invoices', 'admission_id')) {
                    $table->unsignedBigInteger('admission_id')->nullable()->after('patient_id');
                }
                if (!Schema::hasColumn('invoices', 'doctor_id')) {
                    $table->unsignedBigInteger('doctor_id')->nullable()->after('admission_id');
                }
                if (!Schema::hasColumn('invoices', 'created_by')) {
                    $table->unsignedBigInteger('created_by')->nullable()->after('payment_method');
                }
            });
        }

        // 7. Upgrade inventory_items, suppliers, purchases
        if (Schema::hasTable('inventory_categories')) {
            Schema::table('inventory_categories', function (Blueprint $table) {
                if (!Schema::hasColumn('inventory_categories', 'name')) {
                    $table->string('name')->after('id');
                }
                if (!Schema::hasColumn('inventory_categories', 'description')) {
                    $table->text('description')->nullable()->after('name');
                }
            });
        }

        if (Schema::hasTable('suppliers')) {
            Schema::table('suppliers', function (Blueprint $table) {
                if (!Schema::hasColumn('suppliers', 'name')) {
                    $table->string('name')->after('id');
                }
                if (!Schema::hasColumn('suppliers', 'contact_person')) {
                    $table->string('contact_person')->nullable()->after('name');
                }
                if (!Schema::hasColumn('suppliers', 'phone')) {
                    $table->string('phone')->nullable()->after('contact_person');
                }
                if (!Schema::hasColumn('suppliers', 'email')) {
                    $table->string('email')->nullable()->after('phone');
                }
                if (!Schema::hasColumn('suppliers', 'address')) {
                    $table->text('address')->nullable()->after('email');
                }
            });
        }

        if (Schema::hasTable('inventory_items')) {
            Schema::table('inventory_items', function (Blueprint $table) {
                if (!Schema::hasColumn('inventory_items', 'name')) {
                    $table->string('name')->after('id');
                }
                if (!Schema::hasColumn('inventory_items', 'category_id')) {
                    $table->unsignedBigInteger('category_id')->nullable()->after('name');
                }
                if (!Schema::hasColumn('inventory_items', 'unit')) {
                    $table->string('unit')->default('pcs')->after('category_id'); // pcs, box, bottle, roll, pair
                }
                if (!Schema::hasColumn('inventory_items', 'quantity')) {
                    $table->integer('quantity')->default(0)->after('unit');
                }
                if (!Schema::hasColumn('inventory_items', 'reorder_level')) {
                    $table->integer('reorder_level')->default(10)->after('quantity');
                }
                if (!Schema::hasColumn('inventory_items', 'unit_cost')) {
                    $table->decimal('unit_cost', 10, 2)->default(0)->after('reorder_level');
                }
            });
        }

        // 8. Upgrade staff_attendances & salary_payments
        if (Schema::hasTable('staff_attendances')) {
            Schema::table('staff_attendances', function (Blueprint $table) {
                if (!Schema::hasColumn('staff_attendances', 'staff_id')) {
                    $table->unsignedBigInteger('staff_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('staff_attendances', 'date')) {
                    $table->date('date')->after('staff_id');
                }
                if (!Schema::hasColumn('staff_attendances', 'sign_in')) {
                    $table->time('sign_in')->nullable()->after('date');
                }
                if (!Schema::hasColumn('staff_attendances', 'sign_out')) {
                    $table->time('sign_out')->nullable()->after('sign_in');
                }
                if (!Schema::hasColumn('staff_attendances', 'status')) {
                    $table->string('status')->default('Present')->after('sign_out'); // Present, Absent, Late, Half-Day, On Leave
                }
            });
        }

        if (Schema::hasTable('salary_payments')) {
            Schema::table('salary_payments', function (Blueprint $table) {
                if (!Schema::hasColumn('salary_payments', 'staff_id')) {
                    $table->unsignedBigInteger('staff_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('salary_payments', 'month_year')) {
                    $table->string('month_year')->after('staff_id'); // e.g. 2026-11
                }
                if (!Schema::hasColumn('salary_payments', 'basic_salary')) {
                    $table->decimal('basic_salary', 12, 2)->default(0)->after('month_year');
                }
                if (!Schema::hasColumn('salary_payments', 'allowances')) {
                    $table->decimal('allowances', 12, 2)->default(0)->after('basic_salary');
                }
                if (!Schema::hasColumn('salary_payments', 'deductions')) {
                    $table->decimal('deductions', 12, 2)->default(0)->after('allowances');
                }
                if (!Schema::hasColumn('salary_payments', 'net_salary')) {
                    $table->decimal('net_salary', 12, 2)->default(0)->after('deductions');
                }
                if (!Schema::hasColumn('salary_payments', 'payment_date')) {
                    $table->date('payment_date')->after('net_salary');
                }
                if (!Schema::hasColumn('salary_payments', 'payment_method')) {
                    $table->string('payment_method')->default('Bank Transfer')->after('payment_date');
                }
                if (!Schema::hasColumn('salary_payments', 'status')) {
                    $table->string('status')->default('Paid')->after('payment_method');
                }
            });
        }

        // 9. Enhance patients table
        if (Schema::hasTable('patients')) {
            Schema::table('patients', function (Blueprint $table) {
                if (!Schema::hasColumn('patients', 'allergies')) {
                    $table->text('allergies')->nullable()->after('notes');
                }
                if (!Schema::hasColumn('patients', 'medical_history')) {
                    $table->text('medical_history')->nullable()->after('allergies');
                }
                if (!Schema::hasColumn('patients', 'emergency_contact_relation')) {
                    $table->string('emergency_contact_relation')->nullable()->after('emergency_contact');
                }
                if (!Schema::hasColumn('patients', 'marital_status')) {
                    $table->string('marital_status')->nullable()->after('gender');
                }
                if (!Schema::hasColumn('patients', 'occupation')) {
                    $table->string('occupation')->nullable()->after('marital_status');
                }
            });
        }

        // 10. Enhance doctors table
        if (Schema::hasTable('doctors')) {
            Schema::table('doctors', function (Blueprint $table) {
                if (!Schema::hasColumn('doctors', 'designation')) {
                    $table->string('designation')->nullable()->after('specialization');
                }
                if (!Schema::hasColumn('doctors', 'room_no')) {
                    $table->string('room_no')->nullable()->after('designation');
                }
                if (!Schema::hasColumn('doctors', 'ipd_round_charge')) {
                    $table->decimal('ipd_round_charge', 10, 2)->default(500)->after('consultation_fee');
                }
                if (!Schema::hasColumn('doctors', 'emergency_charge')) {
                    $table->decimal('emergency_charge', 10, 2)->default(1000)->after('ipd_round_charge');
                }
            });
        }
    }

    public function down(): void
    {
        // Additive migrations can remain intact for safety
    }
};
