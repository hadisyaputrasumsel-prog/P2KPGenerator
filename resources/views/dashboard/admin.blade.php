<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin-menu />

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm font-medium text-gray-500 uppercase">{{ __('Total Pegawai') }}</div>
                        <div class="mt-2 text-3xl font-bold text-indigo-600">{{ $total_pegawai }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm font-medium text-gray-500 uppercase">{{ __('Total Dokumen P2KP') }}</div>
                        <div class="mt-2 text-3xl font-bold text-green-600">{{ $total_p2kp }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
