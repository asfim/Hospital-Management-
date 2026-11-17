<?php

namespace App\Http\Controllers;

use App\Models\PharmacyMedicine;
use App\Models\MedicineBatch;
use App\Models\PharmacySale;
use App\Models\PharmacySaleItem;
use App\Models\MedicineReturn;
use App\Models\Patient;
use App\Models\Admission;
use App\Models\Prescription;
use App\Models\DailyCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmacyController extends Controller
{
    public function index()
    {
        $today = today();

        $todaySales = PharmacySale::whereDate('created_at', $today)->sum('total');
        $todaySalesCount = PharmacySale::whereDate('created_at', $today)->count();
        $totalMedicines = PharmacyMedicine::where('status', 'active')->count();

        // Low stock medicines (available stock <= reorder_level)
        $lowStockMedicines = PharmacyMedicine::with('batches')
            ->get()
            ->filter(function($med) {
                return $med->totalStock() <= $med->reorder_level;
            });

        // Near expiry batches (expiring within 90 days)
        $nearExpiryBatches = MedicineBatch::with('medicine')
            ->where('quantity_available', '>', 0)
            ->where('expiry_date', '<=', now()->addDays(90)->toDateString())
            ->orderBy('expiry_date')
            ->take(10)
            ->get();

        $recentSales = PharmacySale::with('patient')->latest()->take(10)->get();

        return view('pharmacy.index', compact(
            'todaySales', 'todaySalesCount', 'totalMedicines',
            'lowStockMedicines', 'nearExpiryBatches', 'recentSales'
        ));
    }

    public function medicines(Request $request)
    {
        $search = $request->get('search');
        $query = PharmacyMedicine::with('batches')->latest();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('generic_name', 'like', "%{$search}%")
                  ->orWhere('manufacturer', 'like', "%{$search}%");
        }

        $medicines = $query->paginate(20);

        return view('pharmacy.medicines', compact('medicines', 'search'));
    }

    public function storeMedicine(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'category' => 'required|string',
            'dosage_form' => 'required|string',
            'strength' => 'nullable|string|max:100',
            'manufacturer' => 'nullable|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        $validated['status'] = 'active';

        PharmacyMedicine::create($validated);

        return redirect()->route('pharmacy.medicines')->with('success', 'Medicine added to pharmacy formulary!');
    }

    public function batches(Request $request)
    {
        $medicineId = $request->get('medicine_id');
        $medicines = PharmacyMedicine::where('status', 'active')->orderBy('name')->get();

        $query = MedicineBatch::with('medicine')->latest('expiry_date');

        if ($medicineId) {
            $query->where('medicine_id', $medicineId);
        }

        $batches = $query->paginate(20);

        return view('pharmacy.batches', compact('batches', 'medicines', 'medicineId'));
    }

    public function storeBatch(Request $request)
    {
        $validated = $request->validate([
            'medicine_id' => 'required|exists:pharmacy_medicines,id',
            'batch_no' => 'required|string|max:100',
            'expiry_date' => 'required|date|after:today',
            'quantity_in' => 'required|integer|min:1',
            'purchase_rate' => 'required|numeric|min:0',
            'sale_rate' => 'required|numeric|min:0',
        ]);

        $validated['quantity_available'] = $validated['quantity_in'];

        MedicineBatch::create($validated);

        return redirect()->route('pharmacy.batches')->with('success', 'Stock batch received successfully!');
    }

    public function pos(Request $request)
    {
        $patients = Patient::latest()->take(50)->get();
        $admissions = Admission::where('status', 'admitted')->with('patient')->get();
        $medicines = PharmacyMedicine::with('activeBatches')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('pharmacy.pos', compact('patients', 'admissions', 'medicines'));
    }

    public function storeSale(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'admission_id' => 'nullable|exists:admissions,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:pharmacy_medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Generate Bill No: PHM-YYYY-XXXXXX
            $lastSale = PharmacySale::latest('id')->first();
            $nextId = $lastSale ? $lastSale->id + 1 : 1;
            $billNo = 'PHM-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

            $subtotal = 0;
            $itemsToInsert = [];

            foreach ($validated['items'] as $item) {
                $medicine = PharmacyMedicine::with('activeBatches')->findOrFail($item['medicine_id']);
                $qtyNeeded = $item['quantity'];

                // Deduct from available batches (FIFO: earliest expiry first)
                $batches = $medicine->activeBatches;
                $batchId = null;

                foreach ($batches as $batch) {
                    if ($qtyNeeded <= 0) break;

                    if ($batch->quantity_available >= $qtyNeeded) {
                        $batch->decrement('quantity_available', $qtyNeeded);
                        $batchId = $batch->id;
                        $qtyNeeded = 0;
                    } else {
                        $qtyNeeded -= $batch->quantity_available;
                        $batch->update(['quantity_available' => 0]);
                        $batchId = $batch->id;
                    }
                }

                $itemTotal = $medicine->unit_price * $item['quantity'];
                $subtotal += $itemTotal;

                $itemsToInsert[] = [
                    'medicine_id' => $medicine->id,
                    'medicine_batch_id' => $batchId,
                    'quantity' => $item['quantity'],
                    'unit_price' => $medicine->unit_price,
                    'total_price' => $itemTotal,
                ];
            }

            $discount = $validated['discount'] ?? 0;
            $tax = $validated['tax'] ?? 0;
            $total = max(0, $subtotal - $discount + $tax);

            $sale = PharmacySale::create([
                'bill_no' => $billNo,
                'patient_id' => $validated['patient_id'] ?? null,
                'admission_id' => $validated['admission_id'] ?? null,
                'customer_name' => $validated['customer_name'] ?? 'Walk-in Customer',
                'customer_phone' => $validated['customer_phone'] ?? null,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'paid' => ($validated['payment_method'] === 'IPD Credit') ? 0 : $total,
                'due' => ($validated['payment_method'] === 'IPD Credit') ? $total : 0,
                'payment_method' => $validated['payment_method'],
                'payment_status' => ($validated['payment_method'] === 'IPD Credit') ? 'Unpaid' : 'Paid',
                'sold_by' => auth()->id(),
            ]);

            foreach ($itemsToInsert as $ins) {
                $ins['pharmacy_sale_id'] = $sale->id;
                $ins['created_at'] = now();
                $ins['updated_at'] = now();
                PharmacySaleItem::create($ins);
            }

            // If IPD Credit, link to admission daily charges
            if (!empty($validated['admission_id']) && $validated['payment_method'] === 'IPD Credit') {
                DailyCharge::create([
                    'admission_id' => $validated['admission_id'],
                    'charge_date' => now()->toDateString(),
                    'charge_type' => 'pharmacy',
                    'description' => "Pharmacy Medicine Dispense: {$billNo}",
                    'amount' => $total,
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('pharmacy.print', $sale->id)
                ->with('success', 'Pharmacy POS transaction completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Pharmacy sale failed: ' . $e->getMessage());
        }
    }

    public function print(PharmacySale $sale)
    {
        $sale->load(['patient', 'items.medicine', 'seller']);
        return view('pharmacy.bill_print', compact('sale'));
    }
}
