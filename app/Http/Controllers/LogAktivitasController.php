<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas; 

class LogAktivitasController extends Controller
{
    public function index()
    {
        // Ambil data log aktivitas, urutkan dari yang paling baru, batasi 15 per halaman
        // Jika ada relasi ke tabel User, kita bisa pakai with('user')
        $logs = LogAktivitas::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.log.index', [
            'title' => 'Log Aktivitas Sistem',
            'logs' => $logs
        ]);
    }
}