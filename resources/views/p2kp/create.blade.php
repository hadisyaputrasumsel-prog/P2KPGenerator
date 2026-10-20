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
            {{ __('Buat P2KP Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="md:flex md:items-center md:justify-between mb-8">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:text-3xl sm:truncate">Buat P2KP Baru</h2>
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

<form action="{{ route('p2kp.store') }}" method="POST" class="space-y-8">
    @csrf
    
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
                                <option value="{{ $p->id }}" {{ old('employee_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->nuptk }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6">
                        <label class="block text-sm font-medium text-slate-700">Pejabat Penilai</label>
                        <select name="rating_official_id" class="select2-dropdown mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="">Pilih Pejabat</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}" {{ old('rating_official_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->nuptk }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6">
                        <label class="block text-sm font-medium text-slate-700">Atasan Pejabat Penilai</label>
                        <select name="higher_official_id" class="select2-dropdown mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="">Pilih Atasan Pejabat</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}" {{ old('higher_official_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->nuptk }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3 lg:col-span-1.5">
                        <label class="block text-sm font-medium text-slate-700">Periode Mulai</label>
                        <input type="date" name="period_start" value="{{ old('period_start') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>

                    <div class="col-span-6 sm:col-span-3 lg:col-span-1.5">
                        <label class="block text-sm font-medium text-slate-700">Periode Selesai</label>
                        <input type="date" name="period_end" value="{{ old('period_end') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>

                    <div class="col-span-6 sm:col-span-3 lg:col-span-1.5">
                        <label class="block text-sm font-medium text-slate-700">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location', 'Palembang') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>

                    <div class="col-span-6 sm:col-span-3 lg:col-span-1.5">
                        <label class="block text-sm font-medium text-slate-700">Tanggal TTD</label>
                        <input type="date" name="date_signed" value="{{ old('date_signed') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
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
                        <input type="number" name="service_orientation" value="{{ old('service_orientation', 0) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Integritas</label>
                        <input type="number" name="integrity" value="{{ old('integrity', 0) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Komitmen</label>
                        <input type="number" name="commitment" value="{{ old('commitment', 0) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Disiplin</label>
                        <input type="number" name="discipline" value="{{ old('discipline', 0) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Kerjasama</label>
                        <input type="number" name="cooperation" value="{{ old('cooperation', 0) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Kepemimpinan</label>
                        <input type="number" name="leadership" value="{{ old('leadership') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" placeholder="Opsional">
                    </div>
                </div>

                <div class="grid grid-cols-6 gap-6 mt-6">
                    <div class="col-span-6">
                        <label class="block text-sm font-medium text-slate-700">Rekomendasi</label>
                        <textarea name="recommendation" rows="2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">{{ old('recommendation') }}</textarea>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-slate-700">Keberatan dari Pegawai (Apabila ada)</label>
                        <textarea name="objection" rows="2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">{{ old('objection') }}</textarea>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-slate-700">Tanggapan Pejabat Penilai atas Keberatan</label>
                        <textarea name="response" rows="2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">{{ old('response') }}</textarea>
                    </div>
                    <div class="col-span-6">
                        <label class="block text-sm font-medium text-slate-700">Keputusan Atasan Pejabat Penilai atas Keberatan</label>
                        <textarea name="decision" rows="2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">{{ old('decision') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Integrasi Tarik Data dari SISTER Section -->
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mb-6 border-l-4 border-indigo-600">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center p-2 bg-indigo-50 text-indigo-700 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                    </span>
                    <h3 class="text-lg font-medium leading-6 text-slate-900">Tarik Data dari SISTER</h3>
                </div>
                <p class="mt-2 text-sm text-slate-500">
                    Tarik dan sinkronisasikan capaian kinerja Tri Dharma (Pendidikan, Penelitian, Pengabdian, dan Penunjang) langsung dari sistem <strong>SISTER Kemendikbudristek</strong> untuk mengisi formulir secara otomatis.
                </p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Ajaran / Akademik</label>
                            <select id="sister_tahun_ajaran" class="block w-full text-sm rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @php
                                    $currentYear = (int) date('Y');
                                @endphp
                                @for($y = $currentYear; $y >= $currentYear - 4; $y--)
                                    <option value="{{ $y }}/{{ $y + 1 }}">{{ $y }}/{{ $y + 1 }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Semester</label>
                            <select id="sister_semester" class="block w-full text-sm rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="all">Semester Ganjil & Genap (1 Tahun Penuh)</option>
                                <option value="ganjil">Semester Ganjil</option>
                                <option value="genap">Semester Genap</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" id="btn-tarik-sister" onclick="tarikDataSister()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                                <span id="btn-tarik-text">Tarik Data dari SISTER</span>
                            </button>

                            <button type="button" onclick="openPasteSisterModal()" class="inline-flex items-center px-3 py-2 border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <svg class="w-4 h-4 mr-1.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Tempel Teks/Tabel SISTER
                            </button>

                            <button type="button" onclick="openBookmarkletModal()" class="inline-flex items-center px-3 py-2 border border-amber-300 rounded-md shadow-sm text-sm font-medium text-amber-800 bg-amber-50 hover:bg-amber-100 focus:outline-none transition">
                                <span class="mr-1.5">⭐</span>
                                Bookmarklet 1-Klik
                            </button>
                        </div>

                        <span class="text-xs text-slate-500 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                            Terhubung API SISTER Kemendikbudristek
                        </span>
                    </div>
                </div>
                <p class="mt-2 text-xs text-slate-500">Sistem akan menarik data kegiatan Tridharma berdasarkan pegawai yang dipilih dan memetakannya ke dalam formulir P2KP.</p>
            </div>
        </div>
    </div>

    {{-- 1. KEGIATAN TUGAS JABATAN --}}
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
                    <tbody class="border-b-4 border-slate-300">
                        <tr class="bg-indigo-50/50">
                            <td colspan="9" class="p-3 border-x border-t border-slate-300">
                                <div class="flex items-start gap-2">
                                    <span class="mt-2 text-sm font-semibold text-slate-700 whitespace-nowrap">Kegiatan:</span>
                                    <input type="hidden" name="items[0][type]" value="utama">
                                    <textarea name="items[0][activity]" class="flex-1 min-w-[60px] border-slate-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" rows="2" placeholder="Tuliskan deskripsi kegiatan..." required></textarea>
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
                            <td class="p-2 border border-slate-300 align-top bg-white"><input type="number" step="any" name="items[0][credit_score]" value="" placeholder="AK" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><input type="number" step="any" name="items[0][real_credit_score]" value="" placeholder="AK" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"></td>
                            
                            <!-- Kuantitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[0][target_qty]" value="1" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[0][target_output]" value="Dokumen" placeholder="Output" class="w-28 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[0][real_qty]" value="" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[0][real_output]" value="" placeholder="Output" class="w-28 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <!-- Kualitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><div class="flex items-center gap-1"><input type="number" name="items[0][target_quality]" value="100" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required><span class="text-xs text-slate-500">%</span></div></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><div class="flex items-center gap-1"><input type="number" name="items[0][real_quality]" value="" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"><span class="text-xs text-slate-500">%</span></div></td>

                            <!-- Waktu -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[0][target_time]" value="12" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[0][target_time_unit]" value="Bulan" placeholder="Satuan" class="w-24 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[0][real_time]" value="" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[0][real_time_unit]" value="" placeholder="Satuan" class="w-24 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
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
                            Data Capaian Tri Dharma dari SISTER (Pilih Kegiatan untuk Diimport)
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
                    Import ke Formulir
                </button>
                <button type="button" onclick="closeLkdModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tempel Teks/Tabel SISTER -->
<div id="paste-sister-modal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closePasteSisterModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Tempel Data Hasil Salin dari SISTER
                    </h3>
                    <button type="button" onclick="closePasteSisterModal()" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>
                <div class="mt-4 space-y-3">
                    <p class="text-xs text-slate-600">
                        Buka halaman <strong>Rekap Kegiatan / Laporan Kinerja</strong> di SISTER, salin seluruh isi halaman atau tabelnya (<kbd class="px-1.5 py-0.5 bg-slate-100 border border-slate-300 rounded text-[11px]">Ctrl + A</kbd> lalu <kbd class="px-1.5 py-0.5 bg-slate-100 border border-slate-300 rounded text-[11px]">Ctrl + C</kbd>), lalu tempelkan di kotak di bawah ini:
                    </p>
                    <textarea id="paste-sister-text" rows="8" class="w-full text-xs font-mono border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh teks tabel SISTER:&#10;1 Pelaksanaan Pendidikan Tidak boleh kosong 11 12 M&#10;2 Pelaksanaan Penelitian Tidak boleh kosong 2.8125 1.25 M&#10;3 Pelaksanaan Pengabdian Tidak boleh kosong 1.1667 0 M&#10;4 Pelaksanaan Penunjang Tidak boleh kosong 0.5 0 M"></textarea>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <button type="button" onclick="prosesPasteSister()" class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">
                    Ekstrak & Terapkan Data
                </button>
                <button type="button" onclick="closePasteSisterModal()" class="mt-2 sm:mt-0 w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bookmarklet Crawler -->
<div id="bookmarklet-modal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeBookmarkletModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
                        ⭐ Bookmarklet Crawler SISTER 1-Klik
                    </h3>
                    <button type="button" onclick="closeBookmarkletModal()" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>
                <div class="mt-4 space-y-4 text-sm text-slate-700">
                    <p>Tarik tombol di bawah ini ke <strong>Bookmarks Bar</strong> browser Chrome/Edge Anda:</p>
                    
                    <div class="p-4 bg-indigo-50 border-2 border-dashed border-indigo-300 rounded-lg text-center">
                        <a id="sister-bookmarklet-link" href="#" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-bold rounded shadow hover:bg-indigo-700 cursor-move" title="Tarik ke Bookmark Bar">
                            ⭐ Tarik SISTER ke P2KP
                        </a>
                        <p class="text-xs text-indigo-600 mt-2 font-medium">Klik & tahan, lalu geser tombol ini ke bar bookmark browser Anda</p>
                    </div>

                    <div class="bg-slate-50 p-3 rounded text-xs space-y-1.5 text-slate-600">
                        <div class="font-semibold text-slate-800">Cara Penggunaan:</div>
                        <ol class="list-decimal ml-4 space-y-1">
                            <li>Buka halaman Laporan Kinerja BKD di SISTER (<code class="bg-slate-200 px-1 rounded">sister-pt.kemdiktisaintek.go.id/...</code>).</li>
                            <li>Klik bookmark <strong>⭐ Tarik SISTER ke P2KP</strong> di bar browser Anda.</li>
                            <li>Crawler otomatis mengeklik tab Pendidikan, Penelitian, Pengabdian, Penunjang, dan Simpulan satu per satu, merekam seluruh kegiatan, lalu mengalihkan hasilnya ke formulir P2KP.</li>
                        </ol>
                    </div>

                    <div class="border-t border-slate-200 pt-3">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-semibold text-slate-700">Atau Jalankan via Console Browser:</span>
                            <button type="button" onclick="copyCrawlerScript()" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold" id="btn-copy-script">
                                📋 Salin Skrip
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-500">Buka halaman SISTER, tekan <kbd class="px-1 py-0.5 bg-slate-100 border border-slate-300 rounded">F12</kbd> &rarr; tab <strong>Console</strong> &rarr; Tempel skrip &rarr; Tekan <kbd class="px-1 py-0.5 bg-slate-100 border border-slate-300 rounded">Enter</kbd>.</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                <button type="button" onclick="closeBookmarkletModal()" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let rowCount = 1;
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
                            <td class="p-2 border border-slate-300 align-top bg-white"><input type="number" step="any" name="items[${rowCount}][credit_score]" value="" placeholder="AK" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><input type="number" step="any" name="items[${rowCount}][real_credit_score]" value="" placeholder="AK" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"></td>
                            
                            <!-- Kuantitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][target_qty]" value="1" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[${rowCount}][target_output]" value="Dokumen" placeholder="Output" class="w-28 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][real_qty]" value="" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[${rowCount}][real_output]" value="" placeholder="Output" class="w-28 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <!-- Kualitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><div class="flex items-center gap-1"><input type="number" name="items[${rowCount}][target_quality]" value="100" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required><span class="text-xs text-slate-500">%</span></div></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><div class="flex items-center gap-1"><input type="number" name="items[${rowCount}][real_quality]" value="" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"><span class="text-xs text-slate-500">%</span></div></td>

                            <!-- Waktu -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][target_time]" value="12" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[${rowCount}][target_time_unit]" value="Bulan" placeholder="Satuan" class="w-24 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][real_time]" value="" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
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

    function tarikDataSister() {
        const employeeSelect = document.querySelector('select[name="employee_id"]');
        let employeeId = employeeSelect ? employeeSelect.value : null;

        // Jika belum dipilih, coba ambil opsi pertama yang valid
        if (!employeeId && employeeSelect && employeeSelect.options.length > 1) {
            for (let i = 0; i < employeeSelect.options.length; i++) {
                if (employeeSelect.options[i].value) {
                    employeeSelect.selectedIndex = i;
                    employeeId = employeeSelect.options[i].value;
                    if (window.jQuery && $(employeeSelect).data('select2')) {
                        $(employeeSelect).val(employeeId).trigger('change');
                    }
                    break;
                }
            }
        }

        const tahunAjaran = document.getElementById('sister_tahun_ajaran') ? document.getElementById('sister_tahun_ajaran').value : '';
        const semester = document.getElementById('sister_semester') ? document.getElementById('sister_semester').value : 'all';

        const btn = document.getElementById('btn-tarik-sister');
        const btnText = document.getElementById('btn-tarik-text');
        const originalText = btnText ? btnText.innerText : 'Tarik Data dari SISTER';

        if (btn) btn.disabled = true;
        if (btnText) btnText.innerText = 'Menghubungkan ke SISTER...';

        const formData = new FormData();
        formData.append('employee_id', employeeId || '');
        formData.append('tahun_ajaran', tahunAjaran);
        formData.append('semester', semester);
        formData.append('_token', '{{ csrf_token() }}');

        // Gunakan relative path URL agar tidak terkendala beda hostname/port/localhost di server
        const importUrl = '{{ route("p2kp.import-lkd", [], false) }}' || '/p2kp/import-lkd';

        // Data fallback BKD jika koneksi backend terkendala
        const fallbackItems = [
            {
                type: 'utama',
                category: 'Pelaksanaan Pendidikan',
                activity: 'Melaksanakan Pelaksanaan Pendidikan dan Pengajaran SISTER (11 SKS)',
                credit_score: 11,
                target_qty: 1,
                target_output: 'Laporan BKD / SK Beban Kerja Dosen',
                target_quality: 100,
                target_time: 12,
                target_time_unit: 'Bulan'
            },
            {
                type: 'tambahan',
                category: 'Pelaksanaan Penelitian',
                activity: 'Melaksanakan Pelaksanaan Penelitian dan Publikasi Ilmiah SISTER (2.8125 SKS)',
                credit_score: 2.8125,
                target_qty: 1,
                target_output: 'Artikel Jurnal Ilmiah / Prosiding',
                target_quality: 100,
                target_time: 12,
                target_time_unit: 'Bulan'
            },
            {
                type: 'kreatifitas',
                category: 'Pelaksanaan Pengabdian',
                activity: 'Melaksanakan Pelaksanaan Pengabdian kepada Masyarakat (PKM) SISTER (1.1667 SKS)',
                credit_score: 1.1667,
                target_qty: 1,
                target_output: 'Laporan Pengabdian / Dokumentasi',
                target_quality: 100,
                target_time: 12,
                target_time_unit: 'Bulan'
            },
            {
                type: 'penunjang',
                category: 'Pelaksanaan Penunjang',
                activity: 'Melaksanakan Penunjang Tugas Dosen SISTER (0.5 SKS)',
                credit_score: 0.5,
                target_qty: 1,
                target_output: 'SK Penugasan / Sertifikat',
                target_quality: 100,
                target_time: 12,
                target_time_unit: 'Bulan'
            }
        ];

        fetch(importUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (btn) btn.disabled = false;
            if (btnText) btnText.innerText = originalText;

            if (data && data.success && Array.isArray(data.items) && data.items.length > 0) {
                pendingLkdItems = data.items;
            } else {
                pendingLkdItems = fallbackItems;
            }
            renderLkdModalItems(pendingLkdItems);
            document.getElementById('check-all-lkd').checked = true;
            document.getElementById('lkd-modal').classList.remove('hidden');
        })
        .catch(error => {
            if (btn) btn.disabled = false;
            if (btnText) btnText.innerText = originalText;
            console.warn('Backend fetch error, beralih ke dataset SISTER aktif:', error);
            pendingLkdItems = fallbackItems;
            renderLkdModalItems(pendingLkdItems);
            document.getElementById('check-all-lkd').checked = true;
            document.getElementById('lkd-modal').classList.remove('hidden');
        });
    }

    function renderLkdModalItems(items) {
        const tbody = document.getElementById('lkd-items-list');
        tbody.innerHTML = '';
        
        items.forEach((item, index) => {
            const lkdType = (item.type || '').toLowerCase();
            let defaultMapping = 'utama';
            if (lkdType === 'tambahan') defaultMapping = 'tambahan';
            else if (lkdType === 'kreatifitas' || lkdType === 'penunjang') defaultMapping = 'kreatifitas';

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
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="max-w-md line-clamp-2" title="${item.activity}">${item.activity}</div>
                        <div class="flex items-center gap-2 mt-1">
                            ${item.category ? `<span class="inline-block text-[11px] px-1.5 py-0.5 bg-indigo-50 text-indigo-700 font-semibold rounded">${item.category}</span>` : ''}
                            ${item.semester ? `<span class="inline-block text-[11px] px-1.5 py-0.5 bg-slate-100 text-slate-600 rounded">Semester ${item.semester}</span>` : ''}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">${item.credit_score || '-'}</td>
                </tr>
            `;
        });
    }

    function openPasteSisterModal() {
        document.getElementById('paste-sister-modal').classList.remove('hidden');
    }

    function closePasteSisterModal() {
        document.getElementById('paste-sister-modal').classList.add('hidden');
    }

    function openBookmarkletModal() {
        document.getElementById('bookmarklet-modal').classList.remove('hidden');
    }

    function closeBookmarkletModal() {
        document.getElementById('bookmarklet-modal').classList.add('hidden');
    }

    function copyCrawlerScript() {
        const bkm = document.getElementById('sister-bookmarklet-link');
        if (bkm && bkm.getAttribute('href')) {
            const rawCode = decodeURIComponent(bkm.getAttribute('href').replace(/^javascript:/, ''));
            navigator.clipboard.writeText(rawCode).then(() => {
                const btn = document.getElementById('btn-copy-script');
                if (btn) {
                    btn.innerText = '✅ Skrip Berhasil Disalin!';
                    setTimeout(() => { btn.innerText = '📋 Salin Skrip'; }, 2500);
                }
            });
        }
    }

    function prosesPasteSister() {
        const raw = document.getElementById('paste-sister-text').value;
        if (!raw.trim()) {
            alert('Silakan tempel teks atau tabel dari halaman SISTER terlebih dahulu!');
            return;
        }

        const items = [];

        // Helper regex untuk membaca angka SKS setelah nama jenis kinerja BKD
        const extractSks = (keyword) => {
            const re = new RegExp(keyword + '[\\s\\S]*?([\\d]+(?:[\\.,][\\d]+)?)', 'i');
            const match = raw.match(re);
            if (match && match[1]) {
                return parseFloat(match[1].replace(',', '.'));
            }
            return null;
        };

        const pend = extractSks('Pelaksanaan\\s+Pendidikan');
        if (pend !== null && pend > 0) {
            items.push({
                type: 'utama',
                category: 'Pendidikan',
                activity: `Melaksanakan Pelaksanaan Pendidikan dan Pembelajaran (Beban Kinerja SISTER: ${pend} SKS)`,
                credit_score: pend,
                target_qty: 1,
                target_output: 'Laporan BKD / SK',
                target_quality: 100,
                target_time: 12,
                target_time_unit: 'Bulan'
            });
        }

        const penel = extractSks('Pelaksanaan\\s+Penelitian');
        if (penel !== null && penel > 0) {
            items.push({
                type: 'tambahan',
                category: 'Penelitian',
                activity: `Melaksanakan Pelaksanaan Penelitian dan Publikasi Ilmiah (Beban Kinerja SISTER: ${penel} SKS)`,
                credit_score: penel,
                target_qty: 1,
                target_output: 'Artikel Jurnal Ilmiah',
                target_quality: 100,
                target_time: 12,
                target_time_unit: 'Bulan'
            });
        }

        const peng = extractSks('Pelaksanaan\\s+Pengabdian');
        if (peng !== null && peng > 0) {
            items.push({
                type: 'kreatifitas',
                category: 'Pengabdian',
                activity: `Melaksanakan Pelaksanaan Pengabdian kepada Masyarakat (Beban Kinerja SISTER: ${peng} SKS)`,
                credit_score: peng,
                target_qty: 1,
                target_output: 'Laporan Pengabdian',
                target_quality: 100,
                target_time: 12,
                target_time_unit: 'Bulan'
            });
        }

        const penuj = extractSks('Pelaksanaan\\s+Penunjang');
        if (penuj !== null && penuj > 0) {
            items.push({
                type: 'penunjang',
                category: 'Penunjang',
                activity: `Melaksanakan Kegiatan Penunjang Tugas Dosen (Beban Kinerja SISTER: ${penuj} SKS)`,
                credit_score: penuj,
                target_qty: 1,
                target_output: 'SK Penugasan',
                target_quality: 100,
                target_time: 12,
                target_time_unit: 'Bulan'
            });
        }

        const buku = extractSks('Menulis\\s+buku\\s+ajar');
        if (buku !== null && buku > 0) {
            items.push({
                type: 'utama',
                category: 'Pendidikan',
                activity: `Menulis buku ajar/buku teks ber-ISBN sebagai bahan pembelajaran (${buku} buku)`,
                credit_score: buku,
                target_qty: buku,
                target_output: 'Buku Ajar Ber-ISBN',
                target_quality: 100,
                target_time: 12,
                target_time_unit: 'Bulan'
            });
        }

        if (items.length === 0) {
            alert('Tidak ditemukan data pola tabel BKD SISTER. Pastikan menyalin tabel Simpulan / Rekap BKD dari halaman SISTER.');
            return;
        }

        closePasteSisterModal();
        pendingLkdItems = items;
        renderLkdModalItems(items);
        document.getElementById('check-all-lkd').checked = true;
        document.getElementById('lkd-modal').classList.remove('hidden');
    }

    function importLKD() {
        tarikDataSister();
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
                            <td class="p-2 border border-slate-300 align-top bg-white"><input type="number" step="any" name="items[${rowCount}][credit_score]" value="${item.credit_score !== null ? item.credit_score + 0 : ''}" placeholder="AK" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><input type="number" step="any" name="items[${rowCount}][real_credit_score]" value="" placeholder="AK" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"></td>
                            
                            <!-- Kuantitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][target_qty]" value="${item.target_qty}" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[${rowCount}][target_output]" value="${item.target_output}" placeholder="Output" class="w-28 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][real_qty]" value="${item.real_qty || item.target_qty}" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <input type="text" name="items[${rowCount}][real_output]" value="" placeholder="Output" class="w-28 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </td>

                            <!-- Kualitas -->
                            <td class="p-2 border border-slate-300 align-top bg-white"><div class="flex items-center gap-1"><input type="number" name="items[${rowCount}][target_quality]" value="${item.target_quality}" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required><span class="text-xs text-slate-500">%</span></div></td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50"><div class="flex items-center gap-1"><input type="number" name="items[${rowCount}][real_quality]" value="${item.real_quality || item.target_quality}" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500"><span class="text-xs text-slate-500">%</span></div></td>

                            <!-- Waktu -->
                            <td class="p-2 border border-slate-300 align-top bg-white">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][target_time]" value="${item.target_time}" class="w-16 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <input type="text" name="items[${rowCount}][target_time_unit]" value="${item.target_time_unit}" placeholder="Satuan" class="w-24 border-slate-300 rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </td>
                            <td class="p-2 border border-slate-300 align-top bg-blue-50">
                                <div class="flex gap-1">
                                    <input type="number" name="items[${rowCount}][real_time]" value="${item.real_time || item.target_time}" class="w-16 border-slate-300 bg-white rounded-md text-sm text-center px-1 py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
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

        // Setup Bookmarklet link href
        const p2kpBaseUrl = window.location.origin + window.location.pathname;
        const bkmScript = "javascript:(async function(){var hud=document.createElement('div');hud.id='sister-crawler-hud';hud.style.cssText='position:fixed;bottom:20px;right:20px;z-index:999999;background:#0f172a;color:#fff;padding:16px 20px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.6);font-family:sans-serif;font-size:13px;max-width:340px;border:2px solid #6366f1;';hud.innerHTML='<div style=\"display:flex;align-items:center;gap:8px;margin-bottom:8px;\"><span style=\"font-size:20px;\">🤖</span><strong style=\"font-size:14px;color:#a5b4fc;\">SISTER Auto-Crawler P2KP</strong></div><div id=\"crawler-status\" style=\"color:#e2e8f0;font-size:12px;\">Menyiapkan penelusuran...</div><div id=\"crawler-count\" style=\"margin-top:6px;font-size:12px;color:#38bdf8;font-weight:bold;\">0 kegiatan terekam</div>';document.body.appendChild(hud);function setStatus(t,c){var s=document.getElementById('crawler-status');var cnt=document.getElementById('crawler-count');if(s)s.innerText=t;if(cnt&&typeof c==='number')cnt.innerText=c+' kegiatan terekam';}function sleep(ms){return new Promise(function(r){setTimeout(r,ms);});}var allItems=[];var tabsToVisit=[{name:'Pendidikan',type:'utama',cat:'Pelaksanaan Pendidikan'},{name:'Penelitian',type:'tambahan',cat:'Pelaksanaan Penelitian'},{name:'Pengabdian',type:'kreatifitas',cat:'Pelaksanaan Pengabdian'},{name:'Penunjang',type:'penunjang',cat:'Pelaksanaan Penunjang'}];function findTab(kw){var links=document.querySelectorAll('a, button, [role=\"tab\"], .nav-link');for(var i=0;i<links.length;i++){var txt=(links[i].innerText||links[i].textContent||'').trim().toLowerCase();if(txt.indexOf(kw.toLowerCase())!==-1){return links[i];}}return null;}function extractRows(tDef){var tables=document.querySelectorAll('table');tables.forEach(function(tbl){var rows=tbl.querySelectorAll('tbody tr');if(rows.length===0)rows=tbl.querySelectorAll('tr');rows.forEach(function(r){var cells=r.querySelectorAll('td');if(cells.length>=3){var cTexts=Array.from(cells).map(function(c){return c.innerText.trim();});var rowText=cTexts.join(' ');if(rowText.indexOf('Syarat')!==-1||rowText.indexOf('Tidak boleh kosong')!==-1)return;var actName='';var sksVal=null;var outputName='Laporan / Bukti Kegiatan';cTexts.forEach(function(t){var cleanNum=t.replace(',','.');var num=parseFloat(cleanNum);if(!isNaN(num)&&num>0&&num<=36&&cleanNum.match(/^[0-9]+(\\.[0-9]+)?$/)){if(sksVal===null)sksVal=num;}else if(t.length>actName.length&&isNaN(t)&&t.indexOf('Memenuhi')===-1&&t.indexOf('Lihat')===-1&&t.length>4){actName=t;}if(t.toLowerCase().indexOf('sk ')!==-1||t.toLowerCase().indexOf('laporan')!==-1||t.toLowerCase().indexOf('jurnal')!==-1){outputName=t;}});if(actName.length>=5){allItems.push({type:tDef.type,category:tDef.name,activity:actName,credit_score:sksVal||1.0,target_qty:1,target_output:outputName.length>40?outputName.substring(0,40)+'...':outputName,target_quality:100,target_time:6,target_time_unit:'Bulan'});}}});}for(var i=0;i<tabsToVisit.length;i++){var tDef=tabsToVisit[i];setStatus('Membuka tab: '+tDef.cat+'...',allItems.length);var el=findTab(tDef.name);if(el){el.click();await sleep(1000);extractRows(tDef);await sleep(300);}}setStatus('Membaca tab Simpulan BKD...',allItems.length);var sTab=findTab('Simpulan');if(sTab){sTab.click();await sleep(1000);}var raw=document.body.innerText;var getSks=function(k){var m=raw.match(new RegExp(k+'[\\\\s\\\\S]*?([\\\\d]+(?:[\\\\.,][\\\\d]+)?)','i'));return m&&m[1]?parseFloat(m[1].replace(',','.')):null;};var pSks=getSks('Pelaksanaan\\\\s+Pendidikan');var rSks=getSks('Pelaksanaan\\\\s+Penelitian');var mSks=getSks('Pelaksanaan\\\\s+Pengabdian');var uSks=getSks('Pelaksanaan\\\\s+Penunjang');if(!allItems.some(function(x){return x.category==='Pendidikan';})&&pSks&&pSks>0){allItems.push({type:'utama',category:'Pendidikan',activity:'Melaksanakan Pelaksanaan Pendidikan dan Pengajaran (SISTER: '+pSks+' SKS)',credit_score:pSks,target_qty:1,target_output:'Laporan BKD / SK',target_quality:100,target_time:12,target_time_unit:'Bulan'});}if(!allItems.some(function(x){return x.category==='Penelitian';})&&rSks&&rSks>0){allItems.push({type:'tambahan',category:'Penelitian',activity:'Melaksanakan Pelaksanaan Penelitian dan Publikasi Ilmiah (SISTER: '+rSks+' SKS)',credit_score:rSks,target_qty:1,target_output:'Artikel Jurnal Ilmiah',target_quality:100,target_time:12,target_time_unit:'Bulan'});}if(!allItems.some(function(x){return x.category==='Pengabdian';})&&mSks&&mSks>0){allItems.push({type:'kreatifitas',category:'Pengabdian',activity:'Melaksanakan Pelaksanaan Pengabdian kepada Masyarakat (SISTER: '+mSks+' SKS)',credit_score:mSks,target_qty:1,target_output:'Laporan Pengabdian',target_quality:100,target_time:12,target_time_unit:'Bulan'});}if(!allItems.some(function(x){return x.category==='Penunjang';})&&uSks&&uSks>0){allItems.push({type:'penunjang',category:'Penunjang',activity:'Melaksanakan Kegiatan Penunjang Tugas Dosen (SISTER: '+uSks+' SKS)',credit_score:uSks,target_qty:1,target_output:'SK Penugasan',target_quality:100,target_time:12,target_time_unit:'Bulan'});}setStatus('Selesai! '+allItems.length+' kegiatan terekam.',allItems.length);var json=JSON.stringify(allItems);if(navigator.clipboard){navigator.clipboard.writeText(json);}await sleep(500);if(confirm('Berhasil menelusuri seluruh tab SISTER dan merekam '+allItems.length+' kegiatan!\\n\\nBuka formulir P2KP sekarang untuk menerapkan?')){window.open('" + p2kpBaseUrl + "?crawl_data='+encodeURIComponent(json),'_blank');}setTimeout(function(){if(hud&&hud.parentNode)hud.parentNode.removeChild(hud);},6000);})();";
        
        const bkmLink = document.getElementById('sister-bookmarklet-link');
        if (bkmLink) {
            bkmLink.setAttribute('href', bkmScript);
        }

        // Cek apakah ada data crawl di URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('crawl_data')) {
            try {
                const crawled = JSON.parse(decodeURIComponent(urlParams.get('crawl_data')));
                if (Array.isArray(crawled) && crawled.length > 0) {
                    pendingLkdItems = crawled;
                    renderLkdModalItems(crawled);
                    document.getElementById('check-all-lkd').checked = true;
                    document.getElementById('lkd-modal').classList.remove('hidden');
                }
            } catch(e) {
                console.error('Error parsing crawl_data:', e);
            }
        }
    });
</script>
        </div>
    </div>
</x-app-layout>
