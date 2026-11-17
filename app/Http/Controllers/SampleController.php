<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\DiagnosticOrder;
use App\Models\Test;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = Sample::with(['order', 'patient', 'test', 'collector', 'receiver'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $samples = $query->paginate(20);

        $counts = [
            'pending' => Sample::where('status', 'Pending')->count(),
            'collected' => Sample::where('status', 'Collected')->count(),
            'received' => Sample::where('status', 'Received')->count(),
            'processing' => Sample::where('status', 'Processing')->count(),
            'completed' => Sample::where('status', 'Completed')->count(),
        ];

        return view('samples.index', compact('samples', 'counts', 'status'));
    }

    public function collect(Request $request, Sample $sample)
    {
        $lastS = Sample::latest('id')->first();
        $nextId = $lastS ? $lastS->id + 1 : 1;
        $sampleCode = 'SMP-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        $barcode = 'BAR' . date('ymd') . str_pad($sample->id, 5, '0', STR_PAD_LEFT);

        $sample->update([
            'sample_code' => $sample->sample_code ?: $sampleCode,
            'barcode' => $sample->barcode ?: $barcode,
            'status' => 'Collected',
            'collected_by' => auth()->id(),
            'collected_at' => now(),
        ]);

        return back()->with('success', 'Sample successfully collected with Barcode: ' . $barcode);
    }

    public function receive(Request $request, Sample $sample)
    {
        $sample->update([
            'status' => 'Received',
            'received_by' => auth()->id(),
            'received_at' => now(),
        ]);

        return back()->with('success', 'Sample received in laboratory for processing.');
    }

    public function reject(Request $request, Sample $sample)
    {
        $request->validate(['rejection_reason' => 'required|string']);

        $sample->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('warning', 'Sample rejected. Re-collection required.');
    }
}
