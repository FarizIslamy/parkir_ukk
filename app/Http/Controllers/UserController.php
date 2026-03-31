<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogAktivitas; // <--- 1. Tambahkan model Log
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth; // <--- 2. Tambahkan Auth

class UserController extends Controller
{
    // 1. TAMPILKAN SEMUA USER (READ)
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', [
            'users' => $users,
            'title' => 'Data Pengguna' 
        ]);
    }

    // 2. FORM TAMBAH USER (CREATE)
    public function create() {
        return view('admin.user.create', ['title' => 'Tambah Pengguna Baru']);
    }

    // 3. PROSES SIMPAN DATA (STORE)
    public function store(Request $request) {
        // A. Validasi Input
        $request->validate([
            'username' => 'required|unique:tb_user,username', 
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,petugas,owner'
        ]);

        // B. Simpan ke Database
        User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password), 
            'role'     => $request->role
        ]);

        // === SENSOR LOG AKTIVITAS (TAMBAH DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Menambahkan Akun ' . ucfirst($request->role) . ': ' . $request->username
        ]);

        // C. Balik ke Halaman Index dengan pesan sukses
        return redirect()->route('data-user.index')->with('success', 'User berhasil ditambahkan!');
    }

    // 4. FORM EDIT USER
    public function edit($id) {
        $user = User::findOrFail($id);
        
        return view('admin.user.edit', [
            'user'  => $user,
            'title' => 'Edit Data Pengguna'
        ]);
    }

    // 5. PROSES UPDATE DATA
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        // A. Validasi
        $request->validate([
            'username' => 'required|unique:tb_user,username,'.$id.',id_user', 
            'role'     => 'required|in:admin,petugas,owner'
        ]);

        // B. Siapkan Data yang mau diupdate
        $data = [
            'username' => $request->username,
            'role'     => $request->role,
        ];

        // C. Cek apakah password diisi? Kalau iya, ganti password baru.
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // D. Lakukan Update
        $user->update($data);

        // === SENSOR LOG AKTIVITAS (UPDATE DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Memperbarui Akun ' . ucfirst($request->role) . ': ' . $request->username
        ]);

        return redirect()->route('data-user.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // 6. HAPUS DATA (DESTROY)
    public function destroy($id) {
        $user = User::findOrFail($id);
        
        // Simpan data username dan role sebelum dihapus untuk dicatat di log
        $namaUser = $user->username;
        $roleUser = ucfirst($user->role);

        // Hapus dari database
        $user->delete();

        // === SENSOR LOG AKTIVITAS (HAPUS DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Menghapus Akun ' . $roleUser . ': ' . $namaUser
        ]);

        return redirect()->route('data-user.index')->with('success', 'User berhasil dihapus!');
    }
}