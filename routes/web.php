<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\P2kpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/p2kp/import-lkd', function (Illuminate\Http\Request $request) {
        return response()->json([
            'success' => true,
            'items' => [
                [
                    'type' => 'utama',
                    'activity' => 'Melaksanakan perkuliahan/tutorial/tatap muka dan/atau mandiri, serta menguji dan menyelenggarakan pendidikan di tingkat perguruan tinggi',
                    'credit_score' => 10,
                    'target_qty' => 1,
                    'target_output' => 'Dokumen',
                    'target_quality' => 100,
                    'target_time' => 12,
                    'target_time_unit' => 'Bulan',
                ],
                [
                    'type' => 'tambahan',
                    'activity' => 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya (Hasil Penelitian)',
                    'credit_score' => 5,
                    'target_qty' => 1,
                    'target_output' => 'Dokumen',
                    'target_quality' => 100,
                    'target_time' => 12,
                    'target_time_unit' => 'Bulan',
                ],
                [
                    'type' => 'kreatifitas',
                    'activity' => 'Memberikan layanan kepada masyarakat atau kegiatan lain yang menunjang pelaksanaan tugas umum pemerintah dan pembangunan (Pengabdian)',
                    'credit_score' => 3,
                    'target_qty' => 1,
                    'target_output' => 'Dokumen',
                    'target_quality' => 100,
                    'target_time' => 12,
                    'target_time_unit' => 'Bulan',
                ],
                [
                    'type' => 'penunjang',
                    'activity' => 'Menjadi anggota dalam suatu panitia/badan pada perguruan tinggi (Penunjang)',
                    'credit_score' => 2,
                    'target_qty' => 1,
                    'target_output' => 'Dokumen',
                    'target_quality' => 100,
                    'target_time' => 12,
                    'target_time_unit' => 'Bulan',
                ],
            ]
        ]);
    })->name('p2kp.import-lkd');

    // Admin Settings
    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');
    Route::get('/admin/users', function () {
        return view('admin.users', ['users' => \App\Models\User::with('pegawai')->get()]);
    })->name('admin.users');

    Route::patch('/admin/users/{user}/role', function (\Illuminate\Http\Request $request, \App\Models\User $user) {
        $request->validate([
            'role' => 'required|in:admin,dosen,penilai,atasan_penilai',
        ]);
        $user->update(['role' => $request->role]);
        return back()->with('status', 'Role berhasil diperbarui.');
    })->name('admin.users.update_role');

    Route::delete('/admin/users/{user}', function (\App\Models\User $user) {
        $user->delete();
        return back()->with('status', 'User/Role berhasil dihapus.');
    })->name('admin.users.delete');

    Route::get('/admin/users/create', function () {
        $pegawais = \App\Models\Pegawai::whereNull('user_id')->get();
        return view('admin.users_create', compact('pegawais'));
    })->name('admin.users.create');

    Route::post('/admin/users', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'pegawai_id' => 'nullable|exists:pegawais,id',
            'name' => 'required_without:pegawai_id|nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,dosen,penilai,atasan_penilai',
        ]);

        $name = $request->name;
        if ($request->pegawai_id) {
            $pegawai = \App\Models\Pegawai::find($request->pegawai_id);
            $name = $pegawai->name;
        }

        $user = \App\Models\User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(),
        ]);

        if ($request->pegawai_id) {
            $pegawai->update(['user_id' => $user->id]);
        }

        return redirect()->route('admin.users')->with('status', 'User berhasil dibuat.');
    })->name('admin.users.store');

    Route::patch('/admin/users/{user}/verify', function (\App\Models\User $user) {
        $user->update(['email_verified_at' => now()]);
        return redirect()->back()->with('status', 'User berhasil diverifikasi.');
    })->name('admin.users.verify');

    Route::get('/admin/p2kp', function () {
        return view('admin.p2kp_index', ['p2kps' => \App\Models\P2kp::with('employee')->get()]);
    })->name('admin.p2kp');

    // Pegawai & P2KP Management
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('p2kp', P2kpController::class);
    Route::get('p2kp/{p2kp}/pdf', [P2kpController::class, 'exportPdf'])->name('p2kp.pdf');
    Route::get('p2kp/{p2kp}/form-pdf', [P2kpController::class, 'exportFormPdf'])->name('p2kp.form-pdf');
});

require __DIR__.'/auth.php';
