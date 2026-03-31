<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function showLoginForm() {
        return view('login');
    }

    function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'    
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            $request->session()->regenerate(); // Simpan sesi ke database

            $user = Auth::user();
            $role = $user->role;

            // --- PERUBAHAN ADA DI BAWAH SINI (Menambahkan Pesan Notifikasi) ---
            
            if ($role == 'admin') {
                return redirect('/dashboard')->with('success', 'Selamat Datang Admin! Akses penuh diberikan.');
            }
            
            if ($role == 'petugas') {
                return redirect('/transaksi')->with('success', 'Selamat Bertugas! Silakan catat transaksi.');
            }
            
            if ($role == 'owner') {
                return redirect('/laporan')->with('success', 'Selamat Datang Owner! Laporan siap dipantau.');
            }
            
            // Default jika role tidak dikenali
            return redirect('/')->with('success', 'Login Berhasil!');
        }

        return back()->withErrors(['username' => 'Login Gagal! Username atau Password Salah.']);
    }

    function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}