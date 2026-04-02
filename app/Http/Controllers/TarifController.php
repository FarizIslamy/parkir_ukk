<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use App\Models\LogAktivitas; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class TarifController extends Controller
{
    // 1. TAMPILKAN DAFTAR TARIF
    public function index()
    {
        $tarifs = Tarif::all();
        return view('admin.tarif.index', [
            'tarifs' => $tarifs,
            'title'  => 'Data Tarif Parkir'
        ]);
    }

    // 2. FORM TAMBAH
    public function create()
    {
        return view('admin.tarif.create', ['title' => 'Tambah Tarif Baru']);
    }

    // 3. SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan 'in:motor,mobil,lainnya'
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya|unique:tb_tarif,jenis_kendaraan',
            'tarif_per_jam'   => 'required|numeric|min:0'
        ]);

        Tarif::create([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_per_jam'   => $request->tarif_per_jam
        ]);

        // === SENSOR LOG AKTIVITAS (TAMBAH DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Menambahkan Tarif Baru: ' . ucfirst($request->jenis_kendaraan) . ' (Rp ' . number_format($request->tarif_per_jam, 0, ',', '.') . ')'
        ]);

        return redirect()->route('data-tarif.index')->with('success', 'Tarif berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $tarif = Tarif::findOrFail($id);
        return view('admin.tarif.edit', [
            'tarif' => $tarif,
            'title' => 'Edit Tarif Parkir'
        ]);
    }

    // 5. UPDATE DATA
    public function update(Request $request, $id)
    {
        $tarif = Tarif::findOrFail($id);

        $request->validate([
            // Tambahkan 'in:motor,mobil,lainnya' disini juga
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya|unique:tb_tarif,jenis_kendaraan,'.$id.',id_tarif',
            'tarif_per_jam'   => 'required|numeric|min:0'
        ]);

        $tarif->update([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_per_jam'   => $request->tarif_per_jam
        ]);

        // === SENSOR LOG AKTIVITAS (UPDATE DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Memperbarui Tarif: ' . ucfirst($request->jenis_kendaraan) . ' (Rp ' . number_format($request->tarif_per_jam, 0, ',', '.') . ')'
        ]);

        return redirect()->route('data-tarif.index')->with('success', 'Tarif berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $tarif = Tarif::findOrFail($id);
        
        // Simpan jenis kendaraan sebelum dihapus untuk dicatat di log
        $jenisKendaraan = ucfirst($tarif->jenis_kendaraan);

        $tarif->delete();

        // === SENSOR LOG AKTIVITAS (HAPUS DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Menghapus Tarif: ' . $jenisKendaraan
        ]);

        return redirect()->route('data-tarif.index')->with('success', 'Tarif berhasil dihapus!');
    }
}