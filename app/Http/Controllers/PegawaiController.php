<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::latest();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%");
            });
        }

        $pegawais = $query->get();
        return view('pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nuptk' => 'required|string|unique:pegawais,nuptk',
            'rank' => 'nullable|string',
            'position' => 'nullable|string',
            'unit' => 'nullable|string',
            'work_unit' => 'nullable|string',
        ]);

        Pegawai::create($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai created successfully.');
    }

    public function edit(Pegawai $pegawai)
    {
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nuptk' => 'required|string|unique:pegawais,nuptk,' . $pegawai->id,
            'rank' => 'nullable|string',
            'position' => 'nullable|string',
            'unit' => 'nullable|string',
            'work_unit' => 'nullable|string',
        ]);

        $pegawai->update($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai updated successfully.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai deleted successfully.');
    }
}
