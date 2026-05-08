@extends('layouts.app')

@section('content')
<div class="md:flex md:items-center md:justify-between mb-8">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:text-3xl sm:truncate">Edit P2KP</h2>
    </div>
</div>

@if ($errors->any())
    <div class="mb-4 bg-red-50 p-4 rounded-md border border-red-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan dalam pengisian form:</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

<form action="{{ route('p2kp.update', $p2kp) }}" method="POST" class="space-y-8">
    @csrf
    @method('PUT')
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-slate-900">Informasi Dasar</h3>
                <p class="mt-1 text-sm text-slate-500">Pilih pegawai dan periode penilaian.</p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2 space-y-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Pegawai yang Dinilai</label>
                        <select name="employee_id" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="">Pilih Pegawai</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}" {{ old('employee_id', $p2kp->employee_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Pejabat Penilai</label>
                        <select name="rating_official_id" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="">Pilih Pejabat</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}" {{ old('rating_official_id', $p2kp->rating_official_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Atasan Pejabat Penilai</label>
                        <select name="higher_official_id" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="">Pilih Atasan Pejabat</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}" {{ old('higher_official_id', $p2kp->higher_official_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3 lg:col-span-1.5">
                        <label class="block text-sm font-medium text-slate-700">Periode Mulai</label>
                        <input type="date" name="period_start" value="{{ old('period_start', $p2kp->period_start) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>

                    <div class="col-span-6 sm:col-span-3 lg:col-span-1.5">
                        <label class="block text-sm font-medium text-slate-700">Periode Selesai</label>
                        <input type="date" name="period_end" value="{{ old('period_end', $p2kp->period_end) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>

                    <div class="col-span-6 sm:col-span-3 lg:col-span-1.5">
                        <label class="block text-sm font-medium text-slate-700">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location', $p2kp->location) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>

                    <div class="col-span-6 sm:col-span-3 lg:col-span-1.5">
                        <label class="block text-sm font-medium text-slate-700">Tanggal TTD</label>
                        <input type="date" name="date_signed" value="{{ old('date_signed', $p2kp->date_signed) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-slate-900">Unsur Yang Dinilai</h3>
                <p class="mt-1 text-sm text-slate-500">Nilai perilaku kerja pegawai (1-100).</p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2 space-y-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Orientasi Pelayanan</label>
                        <input type="number" name="service_orientation" value="{{ old('service_orientation', $p2kp->service_orientation) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Integritas</label>
                        <input type="number" name="integrity" value="{{ old('integrity', $p2kp->integrity) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Komitmen</label>
                        <input type="number" name="commitment" value="{{ old('commitment', $p2kp->commitment) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Disiplin</label>
                        <input type="number" name="discipline" value="{{ old('discipline', $p2kp->discipline) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Kerjasama</label>
                        <input type="number" name="cooperation" value="{{ old('cooperation', $p2kp->cooperation) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Kepemimpinan</label>
                        <input type="number" name="leadership" value="{{ old('leadership', $p2kp->leadership) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" placeholder="Opsional">
                    </div>
                </div>

                <div class="grid grid-cols-6 gap-6 mt-6">
                    <div class="col-span-6">
                        <label class="block text-sm font-medium text-slate-700">Rekomendasi</label>
                        <textarea name="recommendation" rows="2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">{{ old('recommendation', $p2kp->recommendation) }}</textarea>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-slate-700">Keberatan dari Pegawai (Apabila ada)</label>
                        <textarea name="objection" rows="2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">{{ old('objection', $p2kp->objection) }}</textarea>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-slate-700">Tanggapan Pejabat Penilai atas Keberatan</label>
                        <textarea name="response" rows="2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">{{ old('response', $p2kp->response) }}</textarea>
                    </div>
                    <div class="col-span-6">
                        <label class="block text-sm font-medium text-slate-700">Keputusan Atasan Pejabat Penilai atas Keberatan</label>
                        <textarea name="decision" rows="2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">{{ old('decision', $p2kp->decision) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 1. UTAMA --}}
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
        <div class="md:grid md:grid-cols-1 md:gap-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium leading-6 text-slate-900">1. Kegiatan Tugas Jabatan</h3>
                <button type="button" onclick="addRow('utama')" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Tambah Baris
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200" id="utama-table">
                    <thead>
                        <tr>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider" style="width: 40%;">Kegiatan</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider" style="width: 100px;">AK</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kuantitas/Output (T)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kuantitas/Output (R)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider" style="width: 12%;">Output</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kualitas/Mutu (T)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kualitas/Mutu (R)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-20">Waktu (T)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-20">Waktu (R)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Satuan</th>
                            <th class="px-2 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($p2kp->items->where('type', 'utama') as $index => $item)
                        <tr>
                            <td class="p-2">
                                <input type="hidden" name="items[{{ $index }}][type]" value="utama">
                                <textarea name="items[{{ $index }}][activity]" class="w-full border-slate-300 rounded-md text-sm" rows="6" required>{{ $item->activity }}</textarea>
                            </td>
                            <td class="p-2"><input type="number" step="0.001" name="items[{{ $index }}][credit_score]" value="{{ $item->credit_score + 0 }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][target_qty]" value="{{ $item->target_qty }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][real_qty]" value="{{ $item->real_qty }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="text" name="items[{{ $index }}][target_output]" value="{{ $item->target_output }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][target_quality]" value="{{ $item->target_quality }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][real_quality]" value="{{ $item->real_quality }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][target_time]" value="{{ $item->target_time }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][real_time]" value="{{ $item->real_time }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="text" name="items[{{ $index }}][target_time_unit]" value="{{ $item->target_time_unit }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2 text-right">
                                <button type="button" onclick="this.closest('tr').remove()" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 2. TAMBAHAN --}}
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
        <div class="md:grid md:grid-cols-1 md:gap-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium leading-6 text-slate-900">2. Tugas Tambahan</h3>
                <button type="button" onclick="addRow('tambahan')" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Tambah Tugas Tambahan
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200" id="tambahan-table">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider" style="width: 40%;">Kegiatan</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider" style="width: 100px;">AK</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kuantitas/Output (T)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kuantitas/Output (R)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider" style="width: 12%;">Output</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kualitas/Mutu (T)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kualitas/Mutu (R)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-20">Waktu (T)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-20">Waktu (R)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Satuan</th>
                            <th class="px-2 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($p2kp->items->where('type', 'tambahan') as $index => $item)
                        <tr>
                            <td class="p-2">
                                <input type="hidden" name="items[{{ $index }}][type]" value="tambahan">
                                <textarea name="items[{{ $index }}][activity]" class="w-full border-slate-300 rounded-md text-sm" rows="6" required>{{ $item->activity }}</textarea>
                            </td>
                            <td class="p-2"><input type="number" step="0.001" name="items[{{ $index }}][credit_score]" value="{{ $item->credit_score + 0 }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][target_qty]" value="{{ $item->target_qty }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][real_qty]" value="{{ $item->real_qty }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="text" name="items[{{ $index }}][target_output]" value="{{ $item->target_output }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][target_quality]" value="{{ $item->target_quality }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][real_quality]" value="{{ $item->real_quality }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][target_time]" value="{{ $item->target_time }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][real_time]" value="{{ $item->real_time }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="text" name="items[{{ $index }}][target_time_unit]" value="{{ $item->target_time_unit }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2 text-right">
                                <button type="button" onclick="this.closest('tr').remove()" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 3. KREATIFITAS --}}
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
        <div class="md:grid md:grid-cols-1 md:gap-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium leading-6 text-slate-900">3. Kreatifitas / Unsur Penunjang</h3>
                <button type="button" onclick="addRow('kreatifitas')" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Tambah Kreatifitas
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200" id="kreatifitas-table">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider" style="width: 40%;">Kegiatan</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider" style="width: 100px;">AK</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kuantitas/Output (T)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kuantitas/Output (R)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider" style="width: 12%;">Output</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kualitas/Mutu (T)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Kualitas/Mutu (R)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-20">Waktu (T)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-20">Waktu (R)</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-32">Satuan</th>
                            <th class="px-2 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($p2kp->items->where('type', 'kreatifitas') as $index => $item)
                        <tr>
                            <td class="p-2">
                                <input type="hidden" name="items[{{ $index }}][type]" value="kreatifitas">
                                <textarea name="items[{{ $index }}][activity]" class="w-full border-slate-300 rounded-md text-sm" rows="6" required>{{ $item->activity }}</textarea>
                            </td>
                            <td class="p-2"><input type="number" step="0.001" name="items[{{ $index }}][credit_score]" value="{{ $item->credit_score + 0 }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][target_qty]" value="{{ $item->target_qty }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][real_qty]" value="{{ $item->real_qty }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="text" name="items[{{ $index }}][target_output]" value="{{ $item->target_output }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][target_quality]" value="{{ $item->target_quality }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][real_quality]" value="{{ $item->real_quality }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][target_time]" value="{{ $item->target_time }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[{{ $index }}][real_time]" value="{{ $item->real_time }}" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="text" name="items[{{ $index }}][target_time_unit]" value="{{ $item->target_time_unit }}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2 text-right">
                                <button type="button" onclick="this.closest('tr').remove()" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('p2kp.index') }}" class="bg-white py-2 px-4 border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Batal</a>
        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Simpan P2KP</button>
    </div>
</form>

<script>
    let rowCount = {{ $p2kp->items->count() }};
    function addRow(type) {
        const tbody = document.querySelector(`#${type}-table tbody`);
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="p-2">
                <input type="hidden" name="items[${rowCount}][type]" value="${type}">
                <textarea name="items[${rowCount}][activity]" class="w-full border-slate-300 rounded-md text-sm" rows="6" required></textarea>
            </td>
            <td class="p-2"><input type="number" step="0.001" name="items[${rowCount}][credit_score]" class="w-full border-slate-300 rounded-md text-sm"></td>
            <td class="p-2"><input type="number" name="items[${rowCount}][target_qty]" value="1" class="w-full border-slate-300 rounded-md text-sm" required></td>
            <td class="p-2"><input type="number" name="items[${rowCount}][real_qty]" class="w-full border-slate-300 rounded-md text-sm"></td>
            <td class="p-2"><input type="text" name="items[${rowCount}][target_output]" value="Dokumen" class="w-full border-slate-300 rounded-md text-sm" required></td>
            <td class="p-2"><input type="number" name="items[${rowCount}][target_quality]" value="100" class="w-full border-slate-300 rounded-md text-sm" required></td>
            <td class="p-2"><input type="number" name="items[${rowCount}][real_quality]" class="w-full border-slate-300 rounded-md text-sm"></td>
            <td class="p-2"><input type="number" name="items[${rowCount}][target_time]" value="12" class="w-full border-slate-300 rounded-md text-sm" required></td>
            <td class="p-2"><input type="number" name="items[${rowCount}][real_time]" class="w-full border-slate-300 rounded-md text-sm"></td>
            <td class="p-2"><input type="text" name="items[${rowCount}][target_time_unit]" value="Bulan" class="w-full border-slate-300 rounded-md text-sm" required></td>
            <td class="p-2 text-right">
                <button type="button" onclick="this.closest('tr').remove()" class="text-red-600 hover:text-red-900">Hapus</button>
            </td>
        `;
        tbody.appendChild(newRow);
        rowCount++;
    }
</script>
@endsection
