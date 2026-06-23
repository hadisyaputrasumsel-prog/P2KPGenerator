<?php

namespace App\Http\Controllers;

use App\Models\P2kp;
use App\Models\P2kpItem;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class P2kpController extends Controller
{
    public function index(Request $request)
    {
        $query = P2kp::with(['employee', 'ratingOfficial'])->latest();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('employee', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%");
            });
        }

        $p2kps = $query->get();
        return view('p2kp.index', compact('p2kps'));
    }

    public function create()
    {
        $pegawais = Pegawai::all();
        return view('p2kp.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:pegawais,id',
            'rating_official_id' => 'required|exists:pegawais,id',
            'higher_official_id' => 'required|exists:pegawais,id',
            'period_start' => 'required|date',
            'period_end' => 'required|date',
            'location' => 'required|string',
            'date_signed' => 'required|date',
            'service_orientation' => 'required|numeric',
            'integrity' => 'required|numeric',
            'commitment' => 'required|numeric',
            'discipline' => 'required|numeric',
            'cooperation' => 'required|numeric',
            'leadership' => 'nullable|numeric',
            'recommendation' => 'nullable|string',
            'objection' => 'nullable|string',
            'response' => 'nullable|string',
            'decision' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.activity' => 'required|string',
            'items.*.credit_score' => 'nullable|numeric',
            'items.*.real_credit_score' => 'nullable|numeric',
            'items.*.target_qty' => 'required|integer',
            'items.*.target_output' => 'required|string',
            'items.*.real_output' => 'nullable|string',
            'items.*.target_quality' => 'required|integer',
            'items.*.target_time' => 'required|integer',
            'items.*.target_time_unit' => 'required|string',
            'items.*.real_time_unit' => 'nullable|string',
            'items.*.real_qty' => 'nullable|integer',
            'items.*.real_quality' => 'nullable|integer',
            'items.*.real_time' => 'nullable|integer',
            'items.*.real_cost' => 'nullable|numeric',
            'items.*.type' => 'required|string|in:utama,tambahan,kreatifitas,penunjang',
        ]);

        $p2kp = P2kp::create($validated);

        foreach ($request->items as $index => $item) {
            $p2kp->items()->create(array_merge($item, ['order' => $index]));
        }

        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.p2kp')->with('success', 'P2kp created successfully.');
        }
        return redirect()->route('p2kp.index')->with('success', 'P2kp created successfully.');
    }

    public function show(P2kp $p2kp)
    {
        $p2kp->load(['employee', 'ratingOfficial', 'higherOfficial', 'items']);
        return view('p2kp.show', compact('p2kp'));
    }

    public function exportPdf(P2kp $p2kp)
    {
        $p2kp->load(['employee', 'ratingOfficial', 'higherOfficial', 'items']);
        
        $pdf = Pdf::loadView('p2kp.pdf_main', compact('p2kp'))
                  ->setPaper('a4', 'landscape');
        
        return $pdf->stream("P2kp_Laporan_{$p2kp->employee->name}.pdf");
    }

    public function exportFormPdf(P2kp $p2kp)
    {
        $p2kp->load(['employee', 'ratingOfficial', 'items']);
        
        $pdf = Pdf::loadView('p2kp.pdf_form', compact('p2kp'))
                  ->setPaper('a4', 'portrait');
        
        return $pdf->stream("P2kp_Formulir_{$p2kp->employee->name}.pdf");
    }

    public function edit(P2kp $p2kp)
    {
        $p2kp->load('items');
        $pegawais = Pegawai::all();
        return view('p2kp.edit', compact('p2kp', 'pegawais'));
    }

    public function update(Request $request, P2kp $p2kp)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:pegawais,id',
            'rating_official_id' => 'required|exists:pegawais,id',
            'higher_official_id' => 'required|exists:pegawais,id',
            'period_start' => 'required|date',
            'period_end' => 'required|date',
            'location' => 'required|string',
            'date_signed' => 'required|date',
            'service_orientation' => 'required|numeric',
            'integrity' => 'required|numeric',
            'commitment' => 'required|numeric',
            'discipline' => 'required|numeric',
            'cooperation' => 'required|numeric',
            'leadership' => 'nullable|numeric',
            'recommendation' => 'nullable|string',
            'objection' => 'nullable|string',
            'response' => 'nullable|string',
            'decision' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.activity' => 'required|string',
            'items.*.credit_score' => 'nullable|numeric',
            'items.*.real_credit_score' => 'nullable|numeric',
            'items.*.target_qty' => 'required|integer',
            'items.*.target_output' => 'required|string',
            'items.*.real_output' => 'nullable|string',
            'items.*.target_quality' => 'required|integer',
            'items.*.target_time' => 'required|integer',
            'items.*.target_time_unit' => 'required|string',
            'items.*.real_time_unit' => 'nullable|string',
            'items.*.real_qty' => 'nullable|integer',
            'items.*.real_quality' => 'nullable|integer',
            'items.*.real_time' => 'nullable|integer',
            'items.*.real_cost' => 'nullable|numeric',
            'items.*.type' => 'required|string|in:utama,tambahan,kreatifitas,penunjang',
        ]);

        $p2kp->update($validated);
        
        $p2kp->items()->delete();
        foreach ($request->items as $index => $item) {
            $p2kp->items()->create(array_merge($item, ['order' => $index]));
        }

        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.p2kp')->with('success', 'P2kp updated successfully.');
        }
        return redirect()->route('p2kp.index')->with('success', 'P2kp updated successfully.');
    }

    public function destroy(P2kp $p2kp)
    {
        $p2kp->delete();
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.p2kp')->with('success', 'P2kp deleted successfully.');
        }
        return redirect()->route('p2kp.index')->with('success', 'P2kp deleted successfully.');
    }
}
