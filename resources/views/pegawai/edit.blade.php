@extends('layouts.app')

@section('content')
<div class="md:flex md:items-center md:justify-between mb-8">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:text-3xl sm:truncate">Edit Pegawai</h2>
    </div>
</div>

<div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
    <form action="{{ route('pegawai.update', $pegawai) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-slate-700">Nama Lengkap (Beserta Gelar)</label>
                <input type="text" name="name" value="{{ old('name', $pegawai->name) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
            </div>

            <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-slate-700">NUPTK</label>
                <input type="text" name="nuptk" value="{{ old('nuptk', $pegawai->nuptk) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
            </div>

            <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-slate-700">Pangkat / Golongan</label>
                <select name="rank" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Pilih Pangkat/Golongan</option>
                    @foreach(['Juru Muda / I.a', 'Juru Muda Tingkat I / I.b', 'Juru / I.c', 'Juru Tingkat I / I.d', 'Pengatur Muda / II.a', 'Pengatur Muda Tingkat I / II.b', 'Pengatur / II.c', 'Pengatur Tingkat I / II.d', 'Penata Muda / III.a', 'Penata Muda Tingkat I / III.b', 'Penata / III.c', 'Penata Tingkat I / III.d', 'Pembina / IV.a', 'Pembina Tingkat I / IV.b', 'Pembina Utama Muda / IV.c', 'Pembina Utama Madya / IV.d', 'Pembina Utama / IV.e'] as $rank)
                        <option value="{{ $rank }}" {{ old('rank', $pegawai->rank) == $rank ? 'selected' : '' }}>{{ $rank }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-slate-700">Jabatan</label>
                <input type="text" name="position" value="{{ old('position', $pegawai->position) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
            </div>

            <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-slate-700">Unit Organisasi</label>
                <input type="text" name="unit" value="{{ old('unit', $pegawai->unit) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
            </div>

            <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-slate-700">Unit Kerja</label>
                <input type="text" name="work_unit" value="{{ old('work_unit', $pegawai->work_unit) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('pegawai.index') }}" class="bg-white py-2 px-4 border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Batal</a>
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
