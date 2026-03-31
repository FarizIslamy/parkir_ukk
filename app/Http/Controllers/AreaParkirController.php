<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\LogAktivitas; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class AreaParkirController extends Controller
{
    // 1. TAMPILKAN DATA
    public function index()
    {
        $areas = AreaParkir::all();
        return view('admin.area.index', [
            'areas' => $areas,
            'title' => 'Data Area Parkir'
        ]);
    }

    // 2. FORM TAMBAH
    public function create()
    {
        return view('admin.area.create', ['title' => 'Tambah Area Baru']);
    }

    // 3. SIMPAN DATA (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required|string|max:100|unique:tb_area_parkir,nama_area',
            'kapasitas' => 'required|numeric|min:1'
        ]);

        AreaParkir::create([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            'terisi'    => 0 // Default nol
        ]);

        // === SENSOR LOG AKTIVITAS (TAMBAH DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Menambahkan Area Parkir Baru: ' . $request->nama_area
        ]);

        return redirect()->route('data-area.index')->with('success', 'Area parkir berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $area = AreaParkir::findOrFail($id);
        return view('admin.area.edit', [
            'area'  => $area,
            'title' => 'Edit Area Parkir'
        ]);
    }

    // 5. UPDATE DATA
    public function update(Request $request, $id)
    {
        $area = AreaParkir::findOrFail($id);

        $request->validate([
            'nama_area' => 'required|string|max:100|unique:tb_area_parkir,nama_area,'.$id.',id_area',
            'kapasitas' => 'required|numeric|min:1'
        ]);

        if ($request->kapasitas < $area->terisi) {
            return back()->withErrors(['kapasitas' => 'Kapasitas tidak boleh lebih kecil dari jumlah kendaraan yang sedang parkir saat ini!']);
        }

        $area->update([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas
        ]);

        // === SENSOR LOG AKTIVITAS (UPDATE DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Memperbarui Data Area Parkir: ' . $request->nama_area
        ]);

        return redirect()->route('data-area.index')->with('success', 'Data area berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $area = AreaParkir::findOrFail($id);
        
        if ($area->terisi > 0) {
            return back()->with('error', 'Area tidak bisa dihapus karena masih ada kendaraan parkir!');
        }

        // Simpan nama area sebelum dihapus untuk dicatat di log
        $namaArea = $area->nama_area; 

        $area->delete();

        // === SENSOR LOG AKTIVITAS (HAPUS DATA) ===
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Menghapus Area Parkir: ' . $namaArea
        ]);

        return redirect()->route('data-area.index')->with('success', 'Area berhasil dihapus!');
    }
}