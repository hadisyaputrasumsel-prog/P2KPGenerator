@extends('layouts.app')

@section('content')
<div class="md:flex md:items-center md:justify-between mb-8">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:text-3xl sm:truncate">Detail P2KP: {{ $p2kp->employee->name }}</h2>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
        <a href="{{ route('p2kp.pdf', $p2kp) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
            Cetak P2KP
        </a>
        <a href="{{ route('p2kp.form-pdf', $p2kp) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 bg-white hover:bg-slate-50">
            Cetak Formulir
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Informasi Pegawai -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-slate-50 border-b border-slate-200">
            <h3 class="text-lg leading-6 font-medium text-slate-900">Data Pegawai yang Dinilai</h3>
        </div>
        <div class="border-t border-slate-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-slate-200">
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-slate-500">Nama</dt>
                    <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $p2kp->employee->name }}</dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-slate-500">NUPTK</dt>
                    <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $p2kp->employee->nuptk }}</dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-slate-500">Pangkat/Gol</dt>
                    <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $p2kp->employee->rank }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Informasi Pejabat -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-slate-50 border-b border-slate-200">
            <h3 class="text-lg leading-6 font-medium text-slate-900">Pejabat Penilai</h3>
        </div>
        <div class="border-t border-slate-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-slate-200">
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-slate-500">Nama</dt>
                    <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $p2kp->ratingOfficial->name }}</dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-slate-500">NUPTK</dt>
                    <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $p2kp->ratingOfficial->nuptk }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>

<div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 bg-slate-50 border-b border-slate-200">
        <h3 class="text-lg leading-6 font-medium text-slate-900">Kegiatan Tugas Jabatan</h3>
    </div>
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kegiatan</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">Target</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">Waktu</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-200">
            @foreach($p2kp->items as $index => $item)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $index + 1 }}</td>
                <td class="px-6 py-4 text-sm text-slate-900">{{ $item->activity }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-slate-900">{{ $item->target_qty }} {{ $item->target_output }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-slate-900">{{ $item->target_time }} {{ $item->target_time_unit }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
