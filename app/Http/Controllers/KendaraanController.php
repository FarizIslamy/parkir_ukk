<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\LogAktivitas; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class KendaraanController extends Controller
{
    // 1. TAMPILKAN DATA
    public function index()
    {
        // Urutkan dari yang terbaru
        $kendaraans = Kendaraan::latest()->get();
        return view('admin.kendaraan.index', [
            'kendaraans' => $kendaraans,
            'title'      => 'Data Kendaraan'
        ]);
    }

    // 2. FORM TAMBAH (Jarang dipakai, tapi syarat CRUD)
    public function create()
    {
        return view('admin.kendaraan.create', ['title' => 'Tambah Kendaraan Manual']);
    }

    // 3. SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor'      => 'required|unique:tb_kendaraan,plat_nomor|max:15',
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'warna'           => 'nullable|max:20',
            'pemilik'         => 'nullable|max:100'
        ]);

        Kendaraan::create($request->all());

        // === SENSOR LOG AKTIVITAS (TAMBAH DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Menambahkan Kendaraan Manual: ' . strtoupper($request->plat_nomor)
        ]);

        return redirect()->route('data-kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        return view('admin.kendaraan.edit', [
            'kendaraan' => $kendaraan,
            'title'     => 'Edit Kendaraan'
        ]);
    }

    // 5. UPDATE DATA
    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        $request->validate([
            // Unique tapi kecualikan diri sendiri
            'plat_nomor'      => 'required|max:15|unique:tb_kendaraan,plat_nomor,'.$id.',id_kendaraan',
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'warna'           => 'nullable|max:20',
            'pemilik'         => 'nullable|max:100'
        ]);

        $kendaraan->update($request->all());

        // === SENSOR LOG AKTIVITAS (UPDATE DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Memperbarui Data Kendaraan: ' . strtoupper($request->plat_nomor)
        ]);

        return redirect()->route('data-kendaraan.index')->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        
        // Simpan plat nomornya dulu ke variabel sebelum datanya benar-benar terhapus
        $platNomor = strtoupper($kendaraan->plat_nomor);
        
        $kendaraan->delete();

        // === SENSOR LOG AKTIVITAS (HAPUS DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Menghapus Data Kendaraan: ' . $platNomor
        ]);

        return redirect()->route('data-kendaraan.index')->with('success', 'Kendaraan berhasil dihapus!');
    }
}