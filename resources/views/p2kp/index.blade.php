<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Penilaian Prestasi Kerja (P2KP)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="md:flex md:items-center md:justify-between mb-8">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:text-3xl sm:truncate">Daftar Penilaian Prestasi Kerja (P2KP)</h2>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
        <form action="{{ route('p2kp.index') }}" method="GET" class="flex">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NUPTK..." class="rounded-l-md border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:w-64">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-r-md shadow-sm text-sm font-medium text-white bg-slate-600 hover:bg-slate-700 focus:outline-none">
                Cari
            </button>
        </form>
        <a href="{{ route('p2kp.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Buat P2KP Baru
        </a>
    </div>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul class="divide-y divide-slate-200">
        @foreach($p2kps as $p2kp)
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
        @endforeach
    </ul>
</div>
        </div>
    </div>
</x-app-layout>
