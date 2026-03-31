<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kendaraan;
use App\Models\AreaParkir;
use App\Models\Tarif;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // 1. TAMPILAN UTAMA PETUGAS
    public function index()
    {
        $areas = AreaParkir::all();
        
        $kendaraan_sedang_parkir = Transaksi::where('status', 'masuk')
                                       ->orderBy('id_parkir', 'desc')
                                       ->get();

        return view('petugas.transaksi.index', [
            'title' => 'Transaksi Parkir',
            'areas' => $areas,
            'recent' => $kendaraan_sedang_parkir
        ]);
    }

    // 2. PROSES KENDARAAN MASUK 
    public function store(Request $request)
    {
        // Validasi form
        $request->validate([
            'plat_nomor' => 'required|max:15',
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'id_area' => 'required' 
        ]);

        $plat = strtoupper(str_replace(' ', '', $request->plat_nomor)); 
        $jenis = $request->jenis_kendaraan;

        // Cek 1: Apakah kendaraan masih ada di dalam?
        $cekDouble = Transaksi::whereHas('kendaraan', function($q) use($plat){
            $q->where('plat_nomor', $plat);
        })->where('status', 'masuk')->first();

        if($cekDouble) {
            return back()->with('error', 'Kendaraan '.$plat.' tercatat MASIH DI DALAM (Belum Checkout)!');
        }

        // Cek 2: Apakah tarif sudah dibuat admin?
        $tarif = Tarif::where('jenis_kendaraan', $jenis)->first();
        if(!$tarif) return back()->with('error', 'Tarif untuk '.$jenis.' belum disetting Admin!');

        // Cek 3: Apakah area valid dan kapasitasnya masih muat?
        $area = AreaParkir::find($request->id_area);
        if(!$area) return back()->with('error', 'Area parkir tidak valid atau belum dipilih!');
        
        if($area->terisi >= $area->kapasitas) {
            return back()->with('error', 'MOHON MAAF! '.$area->nama_area.' SUDAH PENUH.');
        }

        // --- PROSES SIMPAN KE DATABASE ---

        // A. Simpan data plat kendaraan (buat baru jika belum ada)
        $kendaraan = Kendaraan::firstOrCreate(
            ['plat_nomor' => $plat],
            ['jenis_kendaraan' => $jenis, 'id_user' => null]
        );

        // B. Buat data transaksi masuk
        Transaksi::create([
            'id_kendaraan' => $kendaraan->id_kendaraan,
            'id_tarif'     => $tarif->id_tarif,
            'id_area'      => $area->id_area,
            'id_user'      => Auth::user()->id_user,
            'waktu_masuk'  => Carbon::now(),
            'status'       => 'masuk',
            'biaya_total'  => 0
        ]);

        // C. Tambah kuota terisi di area parkir
        $area->increment('terisi');

        // D. Catat aktivitas petugas ke log
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Input Masuk: ' . $plat . ' di ' . $area->nama_area
        ]);

        return back()->with('success', 'Berhasil! Karcis Masuk untuk '.$plat.' ('.$area->nama_area.')');
    }

    // 3. HALAMAN PENCARIAN & CHECKOUT KELUAR
    public function checkoutIndex(Request $request)
    {
        $keyword = $request->keyword;
        
        $transaksiList = collect([]); 
        $singleTransaksi = null;
        $biaya = 0;
        $durasi = 0;

        if($keyword) {
            $search = strtoupper(str_replace(' ', '', $keyword));
            
            $transaksiList = Transaksi::whereHas('kendaraan', function($q) use($search){
                $q->where('plat_nomor', 'LIKE', '%'.$search.'%');
            })->where('status', 'masuk')->get();

            if($transaksiList->count() == 1) {
                $singleTransaksi = $transaksiList->first();

                // Hitung Durasi & Biaya
                $masuk = Carbon::parse($singleTransaksi->waktu_masuk);
                $keluar = now();
                
                $totalMenit = $masuk->diffInMinutes($keluar);
                $durasi = ceil($totalMenit / 60);

                if ($durasi < 1) $durasi = 1;

                $tarifPerJam = Tarif::find($singleTransaksi->id_tarif)->tarif_per_jam;
                $biaya = $durasi * $tarifPerJam;
            }
        }

        return view('petugas.transaksi.checkout', [
            'title'           => 'Transaksi Keluar',
            'transaksiList'   => $transaksiList,  
            'transaksi'       => $singleTransaksi, 
            'biaya'           => $biaya,
            'durasi'          => $durasi,
            'keyword'         => $keyword
        ]);
    }

    // 4. PROSES SIMPAN KELUAR (SEDERHANA)
    public function processCheckout(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        // Mencegah double checkout
        if($transaksi->status == 'keluar') {
            return redirect()->route('transaksi.index')->with('error', 'Transaksi ini sudah selesai sebelumnya!');
        }

        // --- PROSES UPDATE DATABASE ---

        // A. Ubah status transaksi jadi keluar & simpan biaya
        $transaksi->update([
            'waktu_keluar' => now(),
            'biaya_total'  => $request->biaya_total,
            'durasi_jam'   => $request->durasi_jam,
            'status'       => 'keluar'
        ]);

        // B. Kurangi kuota terisi di area parkir (slot kembali kosong)
        $area = AreaParkir::find($transaksi->id_area);
        if($area && $area->terisi > 0) {
            $area->decrement('terisi');
        }

        // C. Catat aktivitas pembayaran ke log
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aktivitas' => 'Proses Keluar: ' . $transaksi->kendaraan->plat_nomor . ' (Rp '.number_format($request->biaya_total).')'
        ]);
        
        // Kirim notif sukses dan trigger cetak struk
        return redirect()->route('transaksi.index')
             ->with('success', 'Transaksi Selesai! Kendaraan checkout.')
             ->with('print_id', $transaksi->id_parkir); 
    }

    // 5. FITUR CETAK STRUK
    public function cetakStruk($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        if($transaksi->status != 'keluar') {
            return back()->with('error', 'Kendaraan belum checkout, tidak bisa cetak struk!');
        }

        return view('petugas.transaksi.struk', [
            'transaksi' => $transaksi
        ]);
    }

    // 6. FITUR LAPORAN (KHUSUS OWNER)
    public function laporan(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        $query = Transaksi::where('status', 'keluar');

        if ($dari && $sampai) {
            $query->whereDate('waktu_keluar', '>=', $dari)
                  ->whereDate('waktu_keluar', '<=', $sampai);
        }

        $laporan = $query->orderBy('waktu_keluar', 'desc')->get();
        $totalPemasukan = $laporan->sum('biaya_total');

        return view('owner.laporan.index', [
            'title' => 'Laporan Pendapatan',
            'laporan' => $laporan,
            'totalPemasukan' => $totalPemasukan,
            'dari' => $dari,
            'sampai' => $sampai
        ]);
    }

    // 7. CETAK LAPORAN PDF (KHUSUS OWNER)
    public function cetakLaporan(Request $request)
    {
        // Logikanya sama persis dengan fungsi laporan()
        $dari = $request->dari;
        $sampai = $request->sampai;

        $query = Transaksi::where('status', 'keluar');

        if ($dari && $sampai) {
            $query->whereDate('waktu_keluar', '>=', $dari)
                  ->whereDate('waktu_keluar', '<=', $sampai);
        }

        $laporan = $query->orderBy('waktu_keluar', 'desc')->get();
        $totalPemasukan = $laporan->sum('biaya_total');

        // Kita arahkan ke view khusus cetak (tanpa sidebar & navbar)
        return view('owner.laporan.print', [
            'laporan' => $laporan,
            'totalPemasukan' => $totalPemasukan,
            'dari' => $dari,
            'sampai' => $sampai
        ]);
    }
}