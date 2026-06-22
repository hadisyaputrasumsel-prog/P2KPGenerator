<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'admin':
                $total_pegawai = \App\Models\Pegawai::count();
                $total_p2kp = \App\Models\P2kp::count();
                return view('dashboard.admin', compact('total_pegawai', 'total_p2kp'));
            case 'dosen':
                return view('dashboard.dosen');
            case 'penilai':
                return view('dashboard.penilai');
            case 'atasan_penilai':
                return view('dashboard.atasan_penilai');
            default:
                return view('dashboard');
        }
    }
}
