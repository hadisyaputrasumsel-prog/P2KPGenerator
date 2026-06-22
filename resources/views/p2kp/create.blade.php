<x-app-layout>
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

    <!-- Import LKD Section -->
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mb-6">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-slate-900">Import LKD (2 Berkas)</h3>
                <p class="mt-1 text-sm text-slate-500">Unggah 2 file PDF LKD (Semester Ganjil & Genap) untuk mengisi otomatis form.</p>
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
                <p class="mt-2 text-xs text-slate-500">Sistem akan mengisi otomatis formulir berdasarkan data LKD yang diunggah.</p>
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
                        <tr>
                            <td class="p-2">
                                <input type="hidden" name="items[0][type]" value="utama">
                                <textarea name="items[0][activity]" class="w-full border-slate-300 rounded-md text-sm" rows="6" required></textarea>
                            </td>
                            <td class="p-2"><input type="number" step="0.001" name="items[0][credit_score]" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="number" name="items[0][target_qty]" value="1" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[0][real_qty]" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="text" name="items[0][target_output]" value="Dokumen" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[0][target_quality]" value="100" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[0][real_quality]" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="number" name="items[0][target_time]" value="12" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2"><input type="number" name="items[0][real_time]" class="w-full border-slate-300 rounded-md text-sm"></td>
                            <td class="p-2"><input type="text" name="items[0][target_time_unit]" value="Bulan" class="w-full border-slate-300 rounded-md text-sm" required></td>
                            <td class="p-2 text-right"></td>
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
                    </tbody>
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
    let rowCount = 1;
    let pendingLkdItems = [];

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
                    // Default to utama (Kegiatan Tugas Jabatan) unless it's explicitly named tambahan or kreatifitas. 
                    // Actually, for SKP, most Tridharma maps to utama. Let's default to utama.
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
            
            const tbody = document.querySelector(`#${type}-table tbody`);
            if (!tbody) {
                console.error('Table not found for type:', type);
                return;
            }
            
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="p-2">
                    <input type="hidden" name="items[${rowCount}][type]" value="${type}">
                    <textarea name="items[${rowCount}][activity]" class="w-full border-slate-300 rounded-md text-sm" rows="6" required>${item.activity}</textarea>
                </td>
                <td class="p-2"><input type="number" step="0.001" name="items[${rowCount}][credit_score]" value="${item.credit_score}" class="w-full border-slate-300 rounded-md text-sm"></td>
                <td class="p-2"><input type="number" name="items[${rowCount}][target_qty]" value="${item.target_qty}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                <td class="p-2"><input type="number" name="items[${rowCount}][real_qty]" value="${item.real_qty || item.target_qty}" class="w-full border-slate-300 rounded-md text-sm"></td>
                <td class="p-2"><input type="text" name="items[${rowCount}][target_output]" value="${item.target_output}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                <td class="p-2"><input type="number" name="items[${rowCount}][target_quality]" value="${item.target_quality}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                <td class="p-2"><input type="number" name="items[${rowCount}][real_quality]" value="${item.real_quality || item.target_quality}" class="w-full border-slate-300 rounded-md text-sm"></td>
                <td class="p-2"><input type="number" name="items[${rowCount}][target_time]" value="${item.target_time}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                <td class="p-2"><input type="number" name="items[${rowCount}][real_time]" value="${item.real_time || item.target_time}" class="w-full border-slate-300 rounded-md text-sm"></td>
                <td class="p-2"><input type="text" name="items[${rowCount}][target_time_unit]" value="${item.target_time_unit}" class="w-full border-slate-300 rounded-md text-sm" required></td>
                <td class="p-2 text-right">
                    <button type="button" onclick="this.closest('tr').remove()" class="text-red-600 hover:text-red-900">Hapus</button>
                </td>
            `;
            tbody.appendChild(newRow);
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
