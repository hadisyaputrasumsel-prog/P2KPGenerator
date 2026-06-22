<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <form action="{{ route('pegawai.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label class="block text-sm font-medium text-slate-700">Nama Lengkap (Beserta Gelar)</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label class="block text-sm font-medium text-slate-700">NUPTK</label>
                            <input type="text" name="nuptk" value="{{ old('nuptk') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" required>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label class="block text-sm font-medium text-slate-700">Pangkat / Golongan</label>
                            <select name="rank" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Pilih Pangkat/Golongan</option>
                                <option value="Juru Muda / I.a">Juru Muda / I.a</option>
                                <option value="Juru Muda Tingkat I / I.b">Juru Muda Tingkat I / I.b</option>
                                <option value="Juru / I.c">Juru / I.c</option>
                                <option value="Juru Tingkat I / I.d">Juru Tingkat I / I.d</option>
                                <option value="Pengatur Muda / II.a">Pengatur Muda / II.a</option>
                                <option value="Pengatur Muda Tingkat I / II.b">Pengatur Muda Tingkat I / II.b</option>
                                <option value="Pengatur / II.c">Pengatur / II.c</option>
                                <option value="Pengatur Tingkat I / II.d">Pengatur Tingkat I / II.d</option>
                                <option value="Penata Muda / III.a">Penata Muda / III.a</option>
                                <option value="Penata Muda Tingkat I / III.b">Penata Muda Tingkat I / III.b</option>
                                <option value="Penata / III.c">Penata / III.c</option>
                                <option value="Penata Tingkat I / III.d">Penata Tingkat I / III.d</option>
                                <option value="Pembina / IV.a">Pembina / IV.a</option>
                                <option value="Pembina Tingkat I / IV.b">Pembina Tingkat I / IV.b</option>
                                <option value="Pembina Utama Muda / IV.c">Pembina Utama Muda / IV.c</option>
                                <option value="Pembina Utama Madya / IV.d">Pembina Utama Madya / IV.d</option>
                                <option value="Pembina Utama / IV.e">Pembina Utama / IV.e</option>
                            </select>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label class="block text-sm font-medium text-slate-700">Jabatan</label>
                            <input type="text" name="position" value="{{ old('position') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label class="block text-sm font-medium text-slate-700">Unit Organisasi</label>
                            <input type="text" name="unit" value="{{ old('unit', 'Universitas Sumatera Selatan') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label class="block text-sm font-medium text-slate-700">Unit Kerja</label>
                            <input type="text" name="work_unit" value="{{ old('work_unit') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('pegawai.index') }}" class="bg-white py-2 px-4 border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Batal</a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Simpan Pegawai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
