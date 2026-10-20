<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Dokumen P2KP Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin-menu />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <h3 class="text-lg font-semibold">{{ __('Daftar Dokumen P2KP Pegawai') }}</h3>
                        <a href="{{ route('p2kp.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Baru
                        </a>
                    </div>
                    
                    <!-- Form Filter & Pencarian -->
                    <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 mb-6">
                        <form action="{{ route('admin.p2kp') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
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
                                    <a href="{{ route('admin.p2kp') }}" class="inline-flex justify-center items-center px-3 py-2 bg-slate-200 border border-transparent rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest hover:bg-slate-300 transition ease-in-out duration-150" title="Reset Filter">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Pegawai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Periode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($p2kps as $p2kp)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">{{ $p2kp->employee->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-slate-500">{{ $p2kp->employee->nuptk ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900">{{ $p2kp->period_start }} s/d {{ $p2kp->period_end }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $p2kp->status ?? 'Selesai' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-4">
                                        <a href="{{ route('p2kp.edit', $p2kp) }}" class="text-blue-600 hover:text-blue-900 font-bold">EDIT</a>
                                        <form action="{{ route('p2kp.destroy', $p2kp) }}" method="POST" onsubmit="return confirm('Hapus data ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">HAPUS</button>
                                        </form>
                                        <a href="{{ route('p2kp.pdf', $p2kp) }}" class="text-indigo-600 hover:text-indigo-900 font-bold" target="_blank">CETAK P2KP</a>
                                        <a href="{{ route('p2kp.form-pdf', $p2kp) }}" class="text-slate-600 hover:text-slate-900 font-bold" target="_blank">CETAK FORMULIR</a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                    @if(request()->hasAny(['search', 'year', 'period_start', 'period_end']))
                                        Tidak ada dokumen P2KP yang sesuai dengan kriteria pencarian/filter.
                                    @else
                                        Belum ada dokumen P2KP yang dibuat oleh pegawai.
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($p2kps->hasPages())
                    <div class="mt-4">
                        {{ $p2kps->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
