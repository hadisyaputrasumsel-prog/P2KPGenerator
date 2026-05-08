<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\P2kpController;
use App\Http\Controllers\PegawaiController;

Route::get('/', function () {
    return redirect()->route('p2kp.index');
});

Route::resource('pegawai', PegawaiController::class);
Route::resource('p2kp', P2kpController::class);
Route::get('p2kp/{p2kp}/pdf', [P2kpController::class, 'exportPdf'])->name('p2kp.pdf');
Route::get('p2kp/{p2kp}/form-pdf', [P2kpController::class, 'exportFormPdf'])->name('p2kp.form-pdf');
