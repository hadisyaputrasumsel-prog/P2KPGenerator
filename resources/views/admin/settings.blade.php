<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Email (SMTP)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-admin-menu />
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-4xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Konfigurasi Mail Server') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Atur konfigurasi SMTP agar sistem bisa mengirim email langsung ke pengguna.') }}
                            </p>
                        </header>

                        @if (session('status') === 'settings-updated')
                            <div class="mt-2 font-medium text-sm text-green-600">
                                {{ __('Pengaturan berhasil disimpan.') }}
                            </div>
                        @endif

                        <form method="post" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-6">
                            @csrf

                            <div class="flex flex-col sm:flex-row sm:items-start sm:gap-6">
                                <div class="flex-1">
                                    <x-input-label for="mail_host" :value="__('SMTP Host')" />
                                    <x-text-input id="mail_host" name="mail_host" type="text" class="mt-1 block w-full" :value="old('mail_host', $settings['mail_host'] ?? '')" />
                                </div>
                                <div class="flex-1 mt-1 sm:mt-7 text-sm text-gray-500 bg-blue-50 p-3 rounded border border-blue-100">
                                    Isi dengan host mail server Anda. <br>Untuk Gmail: <strong>smtp.gmail.com</strong> <br>Untuk Mailtrap: <strong>sandbox.smtp.mailtrap.io</strong>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-start sm:gap-6">
                                <div class="flex-1">
                                    <x-input-label for="mail_port" :value="__('SMTP Port')" />
                                    <x-text-input id="mail_port" name="mail_port" type="text" class="mt-1 block w-full" :value="old('mail_port', $settings['mail_port'] ?? '')" />
                                </div>
                                <div class="flex-1 mt-1 sm:mt-7 text-sm text-gray-500 bg-blue-50 p-3 rounded border border-blue-100">
                                    Port mail server. <br>Gmail: <strong>465</strong> (SSL) atau <strong>587</strong> (TLS) <br>Mailtrap: <strong>2525</strong>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-start sm:gap-6">
                                <div class="flex-1">
                                    <x-input-label for="mail_username" :value="__('SMTP Username')" />
                                    <x-text-input id="mail_username" name="mail_username" type="text" class="mt-1 block w-full" :value="old('mail_username', $settings['mail_username'] ?? '')" />
                                </div>
                                <div class="flex-1 mt-1 sm:mt-7 text-sm text-gray-500 bg-blue-50 p-3 rounded border border-blue-100">
                                    Username / Email pengirim. <br>Gmail: <strong>email.anda@gmail.com</strong> <br>Mailtrap: <em>(username dari dashboard mailtrap)</em>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-start sm:gap-6">
                                <div class="flex-1">
                                    <x-input-label for="mail_password" :value="__('SMTP Password')" />
                                    <x-text-input id="mail_password" name="mail_password" type="password" class="mt-1 block w-full" :value="old('mail_password', $settings['mail_password'] ?? '')" />
                                </div>
                                <div class="flex-1 mt-1 sm:mt-7 text-sm text-gray-700 bg-blue-50 p-3 rounded border border-blue-100">
                                    <p class="mb-2">Password email pengirim.</p>
                                    <p class="mb-2">Gmail: <strong>Gunakan "App Password"</strong> (BUKAN password login biasa).</p>
                                    <p class="mb-2">Mailtrap: <em>(password dari dashboard mailtrap)</em></p>
                                    
                                    <details class="mt-3 bg-white p-3 rounded border border-blue-200 cursor-pointer">
                                        <summary class="font-semibold text-blue-600 hover:text-blue-800">📖 Cara Mendapatkan App Password Gmail</summary>
                                        <div class="mt-3 text-xs space-y-2 cursor-auto text-gray-600">
                                            <p><strong>Syarat:</strong> Verifikasi 2 Langkah harus <strong>Aktif</strong>.</p>
                                            <ol class="list-decimal list-inside space-y-1 ml-1">
                                                <li>Buka tab baru: <a href="https://myaccount.google.com/security" target="_blank" class="text-blue-500 underline font-medium">Pengaturan Keamanan Google</a>.</li>
                                                <li>Gunakan kolom pencarian di bagian atas, ketik <strong>"Sandi aplikasi"</strong> atau <strong>"App passwords"</strong>, lalu klik hasilnya.</li>
                                                <li>Ketik nama aplikasi (misal: "P2KP Generator") lalu klik <strong>Buat</strong>.</li>
                                                <li>Copy 16 huruf kuning yang muncul (tanpa spasi) dan Paste ke kolom <strong>SMTP Password</strong> di samping kiri.</li>
                                            </ol>
                                        </div>
                                    </details>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-start sm:gap-6">
                                <div class="flex-1">
                                    <x-input-label for="mail_encryption" :value="__('SMTP Encryption (tls/ssl)')" />
                                    <x-text-input id="mail_encryption" name="mail_encryption" type="text" class="mt-1 block w-full" :value="old('mail_encryption', $settings['mail_encryption'] ?? '')" />
                                </div>
                                <div class="flex-1 mt-1 sm:mt-7 text-sm text-gray-500 bg-blue-50 p-3 rounded border border-blue-100">
                                    Protokol enkripsi. Isi dengan <strong>ssl</strong> atau <strong>tls</strong> sesuai dengan port yang digunakan.
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-start sm:gap-6">
                                <div class="flex-1">
                                    <x-input-label for="mail_from_address" :value="__('From Email Address')" />
                                    <x-text-input id="mail_from_address" name="mail_from_address" type="email" class="mt-1 block w-full" :value="old('mail_from_address', $settings['mail_from_address'] ?? '')" />
                                </div>
                                <div class="flex-1 mt-1 sm:mt-7 text-sm text-gray-500 bg-blue-50 p-3 rounded border border-blue-100">
                                    Alamat email yang akan muncul sebagai pengirim. Biasanya disamakan dengan <strong>SMTP Username</strong> (misal: <em>email.anda@gmail.com</em>).
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-start sm:gap-6">
                                <div class="flex-1">
                                    <x-input-label for="mail_from_name" :value="__('From Name')" />
                                    <x-text-input id="mail_from_name" name="mail_from_name" type="text" class="mt-1 block w-full" :value="old('mail_from_name', $settings['mail_from_name'] ?? '')" />
                                </div>
                                <div class="flex-1 mt-1 sm:mt-7 text-sm text-gray-500 bg-blue-50 p-3 rounded border border-blue-100">
                                    Nama pengirim yang muncul di email. Contoh: <strong>Admin P2KP</strong> atau <strong>P2KP Universitas Sumatera Selatan</strong>.
                                </div>
                            </div>

                            <div class="flex items-center gap-4 mt-6">
                                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
