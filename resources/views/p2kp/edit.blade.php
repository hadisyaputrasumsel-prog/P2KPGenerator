<x-app-layout>
@push('styles')
<style>
    /* Sembunyikan panah atas/bawah pada input number agar hemat ruang */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit P2KP') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


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
                    <div class="col-span-6">
                        <label class="block text-sm font-medium text-slate-700">Pegawai yang Dinilai</label>
                        <select name="employee_id" class="select2-dropdown mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="">Pilih Pegawai</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}" {{ old('employee_id', $p2kp->employee_id) == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->nuptk }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6">
                        <label class="block text-sm font-medium text-slate-700">Pejabat Penilai</label>
                        <select name="rating_official_id" class="select2-dropdown mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="">Pilih Pejabat</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}" {{ old('rating_official_id', $p2kp->rating_official_id) == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->nuptk }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6">
                        <label class="block text-sm font-medium text-slate-700">Atasan Pejabat Penilai</label>
                        <select name="higher_official_id" class="select2-dropdown mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="">Pilih Atasan Pejabat</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}" {{ old('higher_official_id', $p2kp->higher_official_id) == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->nuptk }})</option>
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

    <!-- Import LKD Section -->
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mb-6">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-slate-900">Import LKD (2 Berkas)</h3>
                <p class="mt-1 text-sm text-slate-500">Unggah 2 file PDF LKD (Semester Ganjil & Genap) untuk menambahkan otomatis form.</p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">LKD Semester Ganjil</label>
                        <input type="file" id="lkd_file_1" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">LKD Semester Genap</label>
                        <input type="file" id="lkd_file_2" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    </div>
                    <button type="button" onclick="importLKD()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                        Import LKD
                    </button>
                </div>
                <p class="mt-2 text-xs text-slate-500">Sistem akan menambahkan baris otomatis ke formulir berdasarkan data LKD yang diunggah.</p>
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
                <table class="min-w-full border-collapse border border-slate-200" id="utama-table">
                    @foreach($p2kp->items->where('type', 'utama') as $index => $item)
                    <tbody class="border-b-4 border-slate-300">
                        <tr class="bg-indigo-50/50">
                            <td colspan="9" class="p-3 border-x border-t border-slate-300">
                                <div class="flex items-start gap-2">
                                    <span class="mt-2 text-sm font-semibold text-slate-700 whitespace-nowrap">Kegiatan:</span>
                                    <input type="hidden" name="items[{{ $index }}][type]" value="utama">
                                    <textarea name="items[{{ $index }}][activity]" class="flex-1 min-w-[60px] border-slate-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" rows="2" placeholder="Tuliskan deskripsi kegiatan..." required>{{ $item->activity }}</textarea>
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-slate-100 text-slate-700">
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">AK</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kuantitas & Output</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kualitas/Mutu</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Waktu & Satuan</th>
                            <th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-16">Aksi</th>
                        </tr>
                        <tr class="bg-slate-100 text-slate-700">
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                        </tr>
                        <tr>
                            <!-- AK -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><input type="number" step="0.001" name="items[{{ $index }}][credit_score]" value="{{ $item->credit_score + 0 }}" placeholder="AK" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><input type="number" step="0.001" name="items[{{ $index }}][real_credit_score]" value="{{ $item->real_credit_score }}" placeholder="AK" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"></td>
                            
                            <!-- Kuantitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][target_qty]" value="{{ $item->target_qty }}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[{{ $index }}][target_output]" value="{{ $item->target_output }}" placeholder="Output" class="w-28 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][real_qty]" value="{{ $item->real_qty }}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[{{ $index }}][real_output]" value="{{ $item->real_output }}" placeholder="Output" class="w-28 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <!-- Kualitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><div class="flex items-center gap-1"><input type="number" name="items[{{ $index }}][target_quality]" value="{{ $item->target_quality }}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required><span class="text-xs text-slate-500">%</span></div></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><div class="flex items-center gap-1"><input type="number" name="items[{{ $index }}][real_quality]" value="{{ $item->real_quality }}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"><span class="text-xs text-slate-500">%</span></div></td>

                            <!-- Waktu -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][target_time]" value="{{ $item->target_time }}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[{{ $index }}][target_time_unit]" value="{{ $item->target_time_unit }}" placeholder="Satuan" class="w-24 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][real_time]" value="{{ $item->real_time }}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[{{ $index }}][real_time_unit]" value="{{ $item->real_time_unit }}" placeholder="Satuan" class="w-24 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <td class="p-2 border border-slate-300 align-middle text-center bg-white">
                                <button type="button" onclick="this.closest('tbody').remove()" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-md transition-colors" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    {{-- 2. TUGAS TAMBAHAN --}}
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
        <div class="md:grid md:grid-cols-1 md:gap-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium leading-6 text-slate-900">2. Tugas Tambahan</h3>
                <button type="button" onclick="addRow('tambahan')" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Tambah Tugas Tambahan
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-slate-200" id="tambahan-table">
                    @foreach($p2kp->items->where('type', 'tambahan') as $index => $item)
                    <tbody class="border-b-4 border-slate-300">
                        <tr class="bg-indigo-50/50">
                            <td colspan="9" class="p-3 border-x border-t border-slate-300">
                                <div class="flex items-start gap-2">
                                    <span class="mt-2 text-sm font-semibold text-slate-700 whitespace-nowrap">Kegiatan:</span>
                                    <input type="hidden" name="items[{{ $index }}][type]" value="tambahan">
                                    <textarea name="items[{{ $index }}][activity]" class="flex-1 min-w-[60px] border-slate-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" rows="2" placeholder="Tuliskan deskripsi kegiatan..." required>{{ $item->activity }}</textarea>
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-slate-100 text-slate-700">
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">AK</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kuantitas & Output</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kualitas/Mutu</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Waktu & Satuan</th>
                            <th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-16">Aksi</th>
                        </tr>
                        <tr class="bg-slate-100 text-slate-700">
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                        </tr>
                        <tr>
                            <!-- AK -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><input type="number" step="0.001" name="items[{{ $index }}][credit_score]" value="{{ $item->credit_score + 0 }}" placeholder="AK" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><input type="number" step="0.001" name="items[{{ $index }}][real_credit_score]" value="{{ $item->real_credit_score }}" placeholder="AK" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"></td>
                            
                            <!-- Kuantitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][target_qty]" value="{{ $item->target_qty }}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[{{ $index }}][target_output]" value="{{ $item->target_output }}" placeholder="Output" class="w-28 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][real_qty]" value="{{ $item->real_qty }}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[{{ $index }}][real_output]" value="{{ $item->real_output }}" placeholder="Output" class="w-28 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <!-- Kualitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><div class="flex items-center gap-1"><input type="number" name="items[{{ $index }}][target_quality]" value="{{ $item->target_quality }}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required><span class="text-xs text-slate-500">%</span></div></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><div class="flex items-center gap-1"><input type="number" name="items[{{ $index }}][real_quality]" value="{{ $item->real_quality }}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"><span class="text-xs text-slate-500">%</span></div></td>

                            <!-- Waktu -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][target_time]" value="{{ $item->target_time }}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[{{ $index }}][target_time_unit]" value="{{ $item->target_time_unit }}" placeholder="Satuan" class="w-24 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][real_time]" value="{{ $item->real_time }}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[{{ $index }}][real_time_unit]" value="{{ $item->real_time_unit }}" placeholder="Satuan" class="w-24 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <td class="p-2 border border-slate-300 align-middle text-center bg-white">
                                <button type="button" onclick="this.closest('tbody').remove()" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-md transition-colors" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    {{-- 3. KREATIFITAS / PENUNJANG --}}
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
        <div class="md:grid md:grid-cols-1 md:gap-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium leading-6 text-slate-900">3. Kreatifitas / Unsur Penunjang</h3>
                <button type="button" onclick="addRow('kreatifitas')" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Tambah Kreatifitas
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-slate-200" id="kreatifitas-table">
                    @foreach($p2kp->items->whereIn('type', ['kreatifitas', 'penunjang']) as $index => $item)
                    <tbody class="border-b-4 border-slate-300">
                        <tr class="bg-indigo-50/50">
                            <td colspan="9" class="p-3 border-x border-t border-slate-300">
                                <div class="flex items-start gap-2">
                                    <span class="mt-2 text-sm font-semibold text-slate-700 whitespace-nowrap">Kegiatan:</span>
                                    <input type="hidden" name="items[{{ $index }}][type]" value="kreatifitas">
                                    <textarea name="items[{{ $index }}][activity]" class="flex-1 min-w-[60px] border-slate-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" rows="2" placeholder="Tuliskan deskripsi kegiatan..." required>{{ $item->activity }}</textarea>
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-slate-100 text-slate-700">
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">AK</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kuantitas & Output</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kualitas/Mutu</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Waktu & Satuan</th>
                            <th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-16">Aksi</th>
                        </tr>
                        <tr class="bg-slate-100 text-slate-700">
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                        </tr>
                        <tr>
                            <!-- AK -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><input type="number" step="0.001" name="items[{{ $index }}][credit_score]" value="{{ $item->credit_score + 0 }}" placeholder="AK" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><input type="number" step="0.001" name="items[{{ $index }}][real_credit_score]" value="{{ $item->real_credit_score }}" placeholder="AK" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"></td>
                            
                            <!-- Kuantitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][target_qty]" value="{{ $item->target_qty }}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[{{ $index }}][target_output]" value="{{ $item->target_output }}" placeholder="Output" class="w-28 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][real_qty]" value="{{ $item->real_qty }}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[{{ $index }}][real_output]" value="{{ $item->real_output }}" placeholder="Output" class="w-28 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <!-- Kualitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><div class="flex items-center gap-1"><input type="number" name="items[{{ $index }}][target_quality]" value="{{ $item->target_quality }}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required><span class="text-xs text-slate-500">%</span></div></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><div class="flex items-center gap-1"><input type="number" name="items[{{ $index }}][real_quality]" value="{{ $item->real_quality }}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"><span class="text-xs text-slate-500">%</span></div></td>

                            <!-- Waktu -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][target_time]" value="{{ $item->target_time }}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[{{ $index }}][target_time_unit]" value="{{ $item->target_time_unit }}" placeholder="Satuan" class="w-24 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[{{ $index }}][real_time]" value="{{ $item->real_time }}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[{{ $index }}][real_time_unit]" value="{{ $item->real_time_unit }}" placeholder="Satuan" class="w-24 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <td class="p-2 border border-slate-300 align-middle text-center bg-white">
                                <button type="button" onclick="this.closest('tbody').remove()" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-md transition-colors" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.p2kp') : route('p2kp.index') }}" class="bg-white py-2 px-4 border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Batal</a>
        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Simpan P2KP</button>
    </div>
</form>

<!-- Modal Pilih LKD -->
<div id="lkd-modal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Pilih Kegiatan untuk Diimport
                        </h3>
                        <div class="mt-4 max-h-96 overflow-y-auto border border-gray-200 rounded-md">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                            <input type="checkbox" id="check-all-lkd" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" checked>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-56">Mapping Tujuan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kegiatan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">AK</th>
                                    </tr>
                                </thead>
                                <tbody id="lkd-items-list" class="bg-white divide-y divide-gray-200">
                                    <!-- Items will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="insertSelectedLKD()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Import Terpilih
                </button>
                <button type="button" onclick="closeLkdModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let rowCount = {{ $p2kp->items->count() }};
    let pendingLkdItems = [];

    function addRow(type) {
        const table = document.getElementById(`${type}-table`);
        const newBody = document.createElement('tbody');
        newBody.className = 'border-b-4 border-slate-300';
        newBody.innerHTML = `
            <tr class="bg-indigo-50/50">
                <td colspan="9" class="p-3 border-x border-t border-slate-300">
                    <div class="flex items-start gap-2">
                        <span class="mt-2 text-sm font-semibold text-slate-700 whitespace-nowrap">Kegiatan:</span>
                        <input type="hidden" name="items[${rowCount}][type]" value="${type}">
                        <textarea name="items[${rowCount}][activity]" class="flex-1 min-w-[60px] border-slate-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" rows="2" placeholder="Tuliskan deskripsi kegiatan..." required></textarea>
                    </div>
                </td>
                        </tr>
                <tr class="bg-slate-100 text-slate-700">
                    <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">AK</th>
                    <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kuantitas & Output</th>
                    <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kualitas/Mutu</th>
                    <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Waktu & Satuan</th>
                    <th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-16">Aksi</th>
                </tr>
                <tr class="bg-slate-100 text-slate-700">
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                </tr>
                        <tr class="bg-slate-100 text-slate-700">
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">AK</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kuantitas & Output</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kualitas/Mutu</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Waktu & Satuan</th>
                            <th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-16">Aksi</th>
                        </tr>
                        <tr class="bg-slate-100 text-slate-700">
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                        </tr>
                        <tr>
                            <!-- AK -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><input type="number" step="0.001" name="items[${rowCount}][credit_score]" value="" placeholder="AK" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><input type="number" step="0.001" name="items[${rowCount}][real_credit_score]" value="" placeholder="AK" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"></td>
                            
                            <!-- Kuantitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][target_qty]" value="1" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[${rowCount}][target_output]" value="Dokumen" placeholder="Output" class="w-28 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][real_qty]" value="" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[${rowCount}][real_output]" value="" placeholder="Output" class="w-28 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <!-- Kualitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><div class="flex items-center gap-1"><input type="number" name="items[${rowCount}][target_quality]" value="100" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required><span class="text-xs text-slate-500">%</span></div></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><div class="flex items-center gap-1"><input type="number" name="items[${rowCount}][real_quality]" value="" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"><span class="text-xs text-slate-500">%</span></div></td>

                            <!-- Waktu -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][target_time]" value="12" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[${rowCount}][target_time_unit]" value="Bulan" placeholder="Satuan" class="w-24 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][real_time]" value="" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[${rowCount}][real_time_unit]" value="" placeholder="Satuan" class="w-24 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <td class="p-2 border border-slate-300 align-middle text-center bg-white">
                    <button type="button" onclick="this.closest('tbody').remove()" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-md transition-colors" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </td>
                        </tr>
        `;
        table.appendChild(newBody);
        rowCount++;
    }

    function importLKD() {
        const fileInput1 = document.getElementById('lkd_file_1');
        const fileInput2 = document.getElementById('lkd_file_2');
        
        if (!fileInput1.files.length && !fileInput2.files.length) {
            alert('Pilih setidaknya satu file LKD!');
            return;
        }
        
        const formData = new FormData();
        if (fileInput1.files.length) formData.append('file1', fileInput1.files[0]);
        if (fileInput2.files.length) formData.append('file2', fileInput2.files[0]);
        formData.append('_token', '{{ csrf_token() }}');
        
        fetch('{{ route("p2kp.import-lkd") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                pendingLkdItems = data.items;
                const tbody = document.getElementById('lkd-items-list');
                tbody.innerHTML = '';
                
                pendingLkdItems.forEach((item, index) => {
                    const lkdType = item.type.toLowerCase();
                    const defaultMapping = 'utama';

                    tbody.innerHTML += `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" value="${index}" class="lkd-item-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" checked>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <select class="mapping-select mt-1 block w-full py-1 px-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" data-index="${index}">
                                    <option value="utama" ${defaultMapping === 'utama' ? 'selected' : ''}>1. Kegiatan Tugas Jabatan</option>
                                    <option value="tambahan" ${defaultMapping === 'tambahan' ? 'selected' : ''}>2. Tugas Tambahan</option>
                                    <option value="kreatifitas" ${defaultMapping === 'kreatifitas' ? 'selected' : ''}>3. Kreatifitas / Penunjang</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900"><div class="max-w-md line-clamp-2" title="${item.activity}">${item.activity}</div></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.credit_score || '-'}</td>
                        </tr>
                    `;
                });
                
                document.getElementById('check-all-lkd').checked = true;
                document.getElementById('lkd-modal').classList.remove('hidden');
            } else {
                alert('Gagal mengambil LKD: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses LKD.');
        });
    }

    function closeLkdModal() {
        document.getElementById('lkd-modal').classList.add('hidden');
    }

    function insertSelectedLKD() {
        const checkboxes = document.querySelectorAll('.lkd-item-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Pilih setidaknya satu kegiatan untuk diimport.');
            return;
        }
        
        checkboxes.forEach(cb => {
            const index = cb.value;
            const item = pendingLkdItems[index];
            const selectEl = document.querySelector(`.mapping-select[data-index="${index}"]`);
            const type = selectEl ? selectEl.value : 'utama'; 
            
            const table = document.getElementById(`${type}-table`);
            if (!table) {
                console.error('Table not found for type:', type);
                return;
            }
            
            const newBody = document.createElement('tbody');
            newBody.className = 'border-b-4 border-slate-300';
            newBody.innerHTML = `
                <tr class="bg-indigo-50/50">
                    <td colspan="9" class="p-3 border-x border-t border-slate-300">
                        <div class="flex items-start gap-2">
                            <span class="mt-2 text-sm font-semibold text-slate-700 whitespace-nowrap">Kegiatan:</span>
                            <input type="hidden" name="items[${rowCount}][type]" value="${type}">
                            <textarea name="items[${rowCount}][activity]" class="flex-1 min-w-[60px] border-slate-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" rows="2" placeholder="Tuliskan deskripsi kegiatan..." required>${item.activity}</textarea>
                        </div>
                    </td>
                        </tr>
                <tr class="bg-slate-100 text-slate-700">
                    <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">AK</th>
                    <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kuantitas & Output</th>
                    <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kualitas/Mutu</th>
                    <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Waktu & Satuan</th>
                    <th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-16">Aksi</th>
                </tr>
                <tr class="bg-slate-100 text-slate-700">
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                    <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                </tr>
                        <tr class="bg-slate-100 text-slate-700">
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">AK</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kuantitas & Output</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Kualitas/Mutu</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 ">Waktu & Satuan</th>
                            <th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-16">Aksi</th>
                        </tr>
                        <tr class="bg-slate-100 text-slate-700">
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 bg-blue-50">Realisasi</th>
                        </tr>
                        <tr>
                            <!-- AK -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><input type="number" step="0.001" name="items[${rowCount}][credit_score]" value="${item.credit_score}" placeholder="AK" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><input type="number" step="0.001" name="items[${rowCount}][real_credit_score]" value="" placeholder="AK" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"></td>
                            
                            <!-- Kuantitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][target_qty]" value="${item.target_qty}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[${rowCount}][target_output]" value="${item.target_output}" placeholder="Output" class="w-28 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][real_qty]" value="${item.real_qty || item.target_qty}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[${rowCount}][real_output]" value="" placeholder="Output" class="w-28 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <!-- Kualitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><div class="flex items-center gap-1"><input type="number" name="items[${rowCount}][target_quality]" value="${item.target_quality}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required><span class="text-xs text-slate-500">%</span></div></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><div class="flex items-center gap-1"><input type="number" name="items[${rowCount}][real_quality]" value="${item.real_quality || item.target_quality}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"><span class="text-xs text-slate-500">%</span></div></td>

                            <!-- Waktu -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][target_time]" value="${item.target_time}" class="w-12 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[${rowCount}][target_time_unit]" value="${item.target_time_unit}" placeholder="Satuan" class="w-24 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][real_time]" value="${item.real_time || item.target_time}" class="w-12 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[${rowCount}][real_time_unit]" value="" placeholder="Satuan" class="w-24 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <td class="p-2 border border-slate-300 align-middle text-center bg-white">
                        <button type="button" onclick="this.closest('tbody').remove()" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-md transition-colors" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </td>
                        </tr>
            `;
            table.appendChild(newBody);
            rowCount++;
        });
        
        closeLkdModal();
    }
</script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-dropdown').select2({
            width: '100%',
            matcher: function(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                if (typeof data.text === 'undefined') {
                    return null;
                }
                var term = params.term.toLowerCase();
                var text = data.text.toLowerCase();
                if (text.indexOf(term) > -1) {
                    return data;
                }
                return null;
            }
        });
        
        // Select All checkbox logic for LKD Modal
        $(document).on('change', '#check-all-lkd', function() {
            $('.lkd-item-checkbox').prop('checked', $(this).prop('checked'));
        });
    });
</script>
        </div>
    </div>
</x-app-layout>
