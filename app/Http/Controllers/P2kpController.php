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
            $search = trim($request->get('search'));
            $query->whereHas('employee', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('year')) {
            $year = $request->get('year');
            $query->where(function ($q) use ($year) {
                $q->whereYear('period_start', $year)
                  ->orWhereYear('period_end', $year);
            });
        }

        if ($request->filled('period_start')) {
            $query->whereDate('period_start', '>=', $request->get('period_start'));
        }

        if ($request->filled('period_end')) {
            $query->whereDate('period_end', '<=', $request->get('period_end'));
        }

        $availableYears = P2kp::selectRaw('YEAR(period_start) as year')
            ->whereNotNull('period_start')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->filter();

        if ($availableYears->isEmpty()) {
            $currentYear = (int) date('Y');
            $availableYears = collect([$currentYear, $currentYear - 1]);
        }

        $p2kps = $query->paginate(15)->withQueryString();
        return view('p2kp.index', compact('p2kps', 'availableYears'));
    }

    public function create()
    {
        $pegawais = Pegawai::all();
        $previousYears = P2kp::selectRaw('YEAR(period_start) as year')
            ->whereNotNull('period_start')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->filter();

        return view('p2kp.create', compact('pegawais', 'previousYears'));
    }

    public function getPreviousYearData(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $year = $request->get('year');

        $query = P2kp::with(['items' => function($q) {
            $q->orderBy('order', 'asc')->orderBy('id', 'asc');
        }]);

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        if ($year) {
            $query->where(function($q) use ($year) {
                $q->whereYear('period_start', $year)
                  ->orWhereYear('period_end', $year);
            });
        }

        // Ambil data P2KP tahun sebelumnya (yang paling baru di periode tersebut)
        $previousP2kp = $query->latest('period_start')->first();

        // Jika tidak ketemu berdasarkan pegawai spesifik di tahun itu, coba cari P2KP terakhir dari pegawai tersebut
        if (!$previousP2kp && $employeeId) {
            $previousP2kp = P2kp::with(['items' => function($q) {
                $q->orderBy('order', 'asc')->orderBy('id', 'asc');
            }])
            ->where('employee_id', $employeeId)
            ->latest('period_start')
            ->first();
        }

        if (!$previousP2kp) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ditemukan dokumen P2KP pada tahun/periode sebelumnya untuk pegawai yang dipilih.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'source_p2kp' => [
                'id' => $previousP2kp->id,
                'employee_id' => $previousP2kp->employee_id,
                'rating_official_id' => $previousP2kp->rating_official_id,
                'higher_official_id' => $previousP2kp->higher_official_id,
                'period_start' => $previousP2kp->period_start,
                'period_end' => $previousP2kp->period_end,
                'location' => $previousP2kp->location,
                'date_signed' => $previousP2kp->date_signed,
                'service_orientation' => $previousP2kp->service_orientation,
                'integrity' => $previousP2kp->integrity,
                'commitment' => $previousP2kp->commitment,
                'discipline' => $previousP2kp->discipline,
                'cooperation' => $previousP2kp->cooperation,
                'leadership' => $previousP2kp->leadership,
                'recommendation' => $previousP2kp->recommendation,
                'objection' => $previousP2kp->objection,
                'response' => $previousP2kp->response,
                'decision' => $previousP2kp->decision,
            ],
            'items' => $previousP2kp->items->map(function($item) {
                return [
                    'type' => $item->type,
                    'activity' => $item->activity,
                    'credit_score' => $item->credit_score,
                    'real_credit_score' => $item->real_credit_score,
                    'target_qty' => $item->target_qty,
                    'target_output' => $item->target_output,
                    'real_qty' => $item->real_qty,
                    'real_output' => $item->real_output,
                    'target_quality' => $item->target_quality,
                    'real_quality' => $item->real_quality,
                    'target_time' => $item->target_time,
                    'target_time_unit' => $item->target_time_unit,
                    'real_time' => $item->real_time,
                    'real_time_unit' => $item->real_time_unit,
                ];
            })
        ]);
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
