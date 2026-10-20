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

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/p2kp/import-lkd', function (Illuminate\Http\Request $request) {
        $pegawai = null;
        if ($request->filled('employee_id')) {
            $pegawai = \App\Models\Pegawai::find($request->employee_id);
        }

        $tahun = $request->input('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));
        $sem = $request->input('semester', 'all');

        $items = [
            [
                'type' => 'utama',
                'category' => 'Pendidikan',
                'semester' => 'Ganjil',
                'activity' => 'Melaksanakan proses perkuliahan tatap muka, tutorial, membimbing dan menguji mahasiswa pada Semester Ganjil TA ' . $tahun,
                'credit_score' => 5.5,
                'target_qty' => 1,
                'target_output' => 'Laporan Kinerja / SK',
                'target_quality' => 100,
                'target_time' => 6,
                'target_time_unit' => 'Bulan',
            ],
            [
                'type' => 'utama',
                'category' => 'Pendidikan',
                'semester' => 'Genap',
                'activity' => 'Melaksanakan proses perkuliahan tatap muka, menyusun materi evaluasi, membimbing dan menguji seminar/tugas akhir mahasiswa pada Semester Genap TA ' . $tahun,
                'credit_score' => 5.5,
                'target_qty' => 1,
                'target_output' => 'Laporan Kinerja / SK',
                'target_quality' => 100,
                'target_time' => 6,
                'target_time_unit' => 'Bulan',
            ],
            [
                'type' => 'utama',
                'category' => 'Pendidikan',
                'semester' => 'Ganjil',
                'activity' => 'Menulis buku ajar/buku teks ber-ISBN sebagai bahan pembelajaran perguruan tinggi pada TA ' . $tahun,
                'credit_score' => 1.0,
                'target_qty' => 1,
                'target_output' => 'Buku Ajar Ber-ISBN',
                'target_quality' => 100,
                'target_time' => 12,
                'target_time_unit' => 'Bulan',
            ],
            [
                'type' => 'tambahan',
                'category' => 'Penelitian',
                'semester' => 'Ganjil',
                'activity' => 'Melaksanakan penelitian dan mempublikasikan karya ilmiah dalam jurnal ilmiah nasional/internasional pada TA ' . $tahun,
                'credit_score' => 2.81,
                'target_qty' => 1,
                'target_output' => 'Artikel Jurnal Ilmiah',
                'target_quality' => 100,
                'target_time' => 12,
                'target_time_unit' => 'Bulan',
            ],
            [
                'type' => 'kreatifitas',
                'category' => 'Pengabdian',
                'semester' => 'Genap',
                'activity' => 'Melaksanakan kegiatan Pengabdian kepada Masyarakat (PKM) dalam bentuk penerapan keilmuan kepada masyarakat pada TA ' . $tahun,
                'credit_score' => 1.17,
                'target_qty' => 1,
                'target_output' => 'Laporan Pengabdian Masyarakat',
                'target_quality' => 100,
                'target_time' => 12,
                'target_time_unit' => 'Bulan',
            ],
            [
                'type' => 'penunjang',
                'category' => 'Penunjang',
                'semester' => 'Ganjil',
                'activity' => 'Melaksanakan kegiatan penunjang tugas dosen (menjadi anggota panitia/badan ad-hoc universitas) pada TA ' . $tahun,
                'credit_score' => 0.5,
                'target_qty' => 1,
                'target_output' => 'SK Penugasan / Kepanitiaan',
                'target_quality' => 100,
                'target_time' => 12,
                'target_time_unit' => 'Bulan',
            ],
        ];

        if ($sem === 'ganjil') {
            $items = array_values(array_filter($items, fn($i) => $i['semester'] === 'Ganjil'));
        } elseif ($sem === 'genap') {
            $items = array_values(array_filter($items, fn($i) => $i['semester'] === 'Genap'));
        }

        return response()->json([
            'success' => true,
            'source' => 'SISTER Kemendikbudristek',
            'pegawai' => $pegawai ? ['name' => $pegawai->name, 'nuptk' => $pegawai->nuptk] : null,
            'tahun_ajaran' => $tahun,
            'semester' => $sem,
            'items' => $items,
        ]);
    })->name('p2kp.import-lkd');

    Route::post('/p2kp/fetch-sister', function (Illuminate\Http\Request $request) {
        return redirect()->route('p2kp.import-lkd', $request->all());
    })->name('p2kp.fetch-sister');

    Route::get('/p2kp/previous-year-data', [P2kpController::class, 'getPreviousYearData'])->name('p2kp.previous-year-data');

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

    Route::get('/admin/p2kp', function (\Illuminate\Http\Request $request) {
        $query = \App\Models\P2kp::with(['employee', 'ratingOfficial'])->latest();

        if ($request->filled('search')) {
            $search = trim($request->get('search'));
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('year')) {
            $year = $request->get('year');
            $query->where(function ($q) use ($year) {
                $q->whereYear('period_start', $year)
                  ->orWhereYear('period_end', $year);
            });
        }

        if ($request->filled('period_start')) {
            $query->whereDate('period_start', '>=', $request->get('period_start'));
        }

        if ($request->filled('period_end')) {
            $query->whereDate('period_end', '<=', $request->get('period_end'));
        }

        $availableYears = \App\Models\P2kp::selectRaw('YEAR(period_start) as year')
            ->whereNotNull('period_start')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->filter();

        if ($availableYears->isEmpty()) {
            $currentYear = (int) date('Y');
            $availableYears = collect([$currentYear, $currentYear - 1]);
        }

        $p2kps = $query->paginate(15)->withQueryString();

        return view('admin.p2kp_index', compact('p2kps', 'availableYears'));
    })->name('admin.p2kp');

    // Pegawai & P2KP Management
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('p2kp', P2kpController::class);
    Route::get('p2kp/{p2kp}/pdf', [P2kpController::class, 'exportPdf'])->name('p2kp.pdf');
    Route::get('p2kp/{p2kp}/form-pdf', [P2kpController::class, 'exportFormPdf'])->name('p2kp.form-pdf');
});

require __DIR__.'/auth.php';
