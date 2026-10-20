<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Penilaian Prestasi Kerja (P2KP)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="md:flex md:items-center md:justify-between mb-6">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:text-3xl sm:truncate">Daftar Penilaian Prestasi Kerja (P2KP)</h2>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4">
        <a href="{{ route('p2kp.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Buat P2KP Baru
        </a>
    </div>
</div>

<!-- Form Filter & Pencarian -->
<div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200 mb-6">
    <form action="{{ route('p2kp.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
        <!-- Pencarian Nama / NUPTK -->
        <div class="md:col-span-4">
            <label for="search" class="block text-xs font-medium text-slate-700 mb-1">Cari Pegawai (Nama / NUPTK)</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ketik nama atau NUPTK..." class="w-full text-sm rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <!-- Filter Tahun Periode -->
        <div class="md:col-span-2">
            <label for="year" class="block text-xs font-medium text-slate-700 mb-1">Tahun Periode</label>
            <select name="year" id="year" class="w-full text-sm rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Semua Tahun</option>
                @foreach($availableYears as $yr)
                    <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                @endforeach
            </select>
        </div>

        <!-- Periode Mulai -->
        <div class="md:col-span-2">
            <label for="period_start" class="block text-xs font-medium text-slate-700 mb-1">Periode Dari</label>
            <input type="date" name="period_start" id="period_start" value="{{ request('period_start') }}" class="w-full text-sm rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <!-- Periode Selesai -->
        <div class="md:col-span-2">
            <label for="period_end" class="block text-xs font-medium text-slate-700 mb-1">Periode Sampai</label>
            <input type="date" name="period_end" id="period_end" value="{{ request('period_end') }}" class="w-full text-sm rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <!-- Tombol Aksi -->
        <div class="md:col-span-2 flex gap-2">
            <button type="submit" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Filter
            </button>
            @if(request()->hasAny(['search', 'year', 'period_start', 'period_end']))
                <a href="{{ route('p2kp.index') }}" class="inline-flex justify-center items-center px-3 py-2 bg-slate-200 border border-transparent rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest hover:bg-slate-300 transition ease-in-out duration-150" title="Reset Filter">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul class="divide-y divide-slate-200">
        @forelse($p2kps as $p2kp)
        <li>
            <div class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-indigo-600 truncate">
                        {{ $p2kp->employee->name }}
                    </p>
                    <div class="ml-2 flex-shrink-0 flex space-x-2">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $p2kp->period_start }} - {{ $p2kp->period_end }}
                        </span>
                        <a href="{{ route('p2kp.pdf', $p2kp) }}" target="_blank" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200">Cetak P2KP</a>
                        <a href="{{ route('p2kp.form-pdf', $p2kp) }}" target="_blank" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-green-700 bg-green-100 hover:bg-green-200">Cetak Formulir</a>
                    </div>
                </div>
                <div class="mt-2 sm:flex sm:justify-between">
                    <div class="sm:flex">
                        <p class="flex items-center text-sm text-slate-500">
                            Pejabat: {{ $p2kp->ratingOfficial->name }}
                        </p>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-slate-500 sm:mt-0">
                        <a href="{{ route('p2kp.show', $p2kp) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Lihat</a>
                        <a href="{{ route('p2kp.edit', $p2kp) }}" class="text-amber-600 hover:text-amber-900 mr-4">Edit</a>
                        <form action="{{ route('p2kp.destroy', $p2kp) }}" method="POST" onsubmit="return confirm('Hapus data ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </li>
        @empty
        <li class="px-6 py-8 text-center text-sm text-gray-500">
            @if(request()->hasAny(['search', 'year', 'period_start', 'period_end']))
                Tidak ada dokumen P2KP yang sesuai dengan kriteria pencarian/filter.
            @else
                Belum ada dokumen P2KP.
            @endif
        </li>
        @endforelse
    </ul>
</div>

@if($p2kps->hasPages())
    <div class="mt-4">
        {{ $p2kps->links() }}
    </div>
@endif
        </div>
    </div>
</x-app-layout>
