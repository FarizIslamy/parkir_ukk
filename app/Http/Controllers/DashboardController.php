<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AreaParkir;
use App\Models\Transaksi;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Jika yang login adalah admin, siapkan data statistik
        if (Auth::user()->role == 'admin') {
            
            $hariIni = Carbon::today();

            // 1. Hitung Pendapatan Hari Ini
            $totalUseer = User::count();

            // 2. Kendaraan yang sedang parkir saat ini
            $kendaraanParkir = Transaksi::where('status', 'masuk')->count();

            // 3. Total Kendaraan yang sudah selesai parkir hari ini
            $kendaraanSelesai = Transaksi::where('status', 'keluar')
                                        ->whereDate('waktu_keluar', $hariIni)
                                        ->count();

            // 4. Hitung Sisa Slot Parkir (Kapasitas Total - Terisi)
            $totalKapasitas = AreaParkir::sum('kapasitas');
            $totalTerisi = AreaParkir::sum('terisi');
            $sisaSlot = $totalKapasitas - $totalTerisi;
            $recentLogs = LogAktivitas::orderBy('created_at', 'desc')->take(3)->get();

            return view('admin.dashboard', [
                'title' => 'Dashboard',
                'totalUser' => $totalUseer,
                'kendaraanParkir' => $kendaraanParkir,
                'kendaraanSelesai' => $kendaraanSelesai,
                'sisaSlot' => $sisaSlot,
                'recentLogs' => $recentLogs
            ]);
        }

        // Jika petugas/owner iseng masuk ke URL ini, lempar ke jalurnya masing-masing
        if (Auth::user()->role == 'petugas') return redirect('/transaksi');
        if (Auth::user()->role == 'owner') return redirect('/laporan');
    }
}