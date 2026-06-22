<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Role User untuk Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin-menu />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Buat Akun User Baru') }}</h3>
                    
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="pegawai_id" :value="__('Pilih Pegawai (Opsional)')" />
                            <select id="pegawai_id" name="pegawai_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">-- Buat User Baru (Bukan Pegawai) --</option>
                                @foreach($pegawais as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->nuptk }})</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Jika memilih pegawai, nama akan diambil dari data pegawai.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('pegawai_id')" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nama (Diisi jika bukan pegawai)')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <div>
                            <x-input-label for="role" :value="__('Role')" />
                            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="dosen">Dosen</option>
                                <option value="admin">Admin</option>
                                <option value="penilai">Penilai</option>
                                <option value="atasan_penilai">Atasan Penilai</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            <a href="{{ route('admin.users') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
