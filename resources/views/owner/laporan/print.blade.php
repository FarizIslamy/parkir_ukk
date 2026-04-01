<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pendapatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; background-color: #fff; }
        .kop-surat { border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .table-laporan th, .table-laporan td { border: 1px solid #000 !important; padding: 8px; }
        .table-laporan th { background-color: #e9ecef !important; }
        
        /* Hilangkan elemen yang tidak perlu saat di-print */
        @media print {
            @page { margin: 1.5cm; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body onload="window.print()"> <div class="container mt-4">
        
        <div class="mb-3 no-print">
            <button onclick="window.close()" class="btn btn-secondary btn-sm">&laquo; Tutup Halaman Ini</button>
            <button onclick="window.print()" class="btn btn-primary btn-sm"><i class="fas fa-print"></i> Cetak / Simpan PDF</button>
        </div>

        <div class="kop-surat text-center">
            <h3 class="fw-bold mb-1">E-PARKIR SYSTEM</h3>
            <p class="mb-0">Jl. Contoh Alamat Parkir No. 123, Kota Bandung</p>
            <p class="mb-0">Telp: (022) 1234567 | Email: info@eparkir.com</p>
        </div>

        <div class="text-center mb-4">
            <h5 class="fw-bold text-uppercase">LAPORAN PENDAPATAN PARKIR</h5>
            <p class="mb-0">
                Periode: 
                @if($dari && $sampai)
                    {{ date('d/m/Y', strtotime($dari)) }} s.d {{ date('d/m/Y', strtotime($sampai)) }}
                @else
                    Keseluruhan (Semua Waktu)
                @endif
            </p>
        </div>

        <table class="table table-laporan text-center align-middle">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Waktu Keluar</th>
                    <th width="20%">Plat Nomor</th>
                    <th width="20%">Durasi</th>
                    <th width="35%">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ date('d/m/Y H:i', strtotime($item->waktu_keluar)) }}</td>
                    <td class="text-uppercase">{{ $item->kendaraan?->plat_nomor ?? 'TERHAPUS' }}</td>
                    <td>{{ $item->durasi_jam }} Jam</td>
                    <td class="text-end pe-4">Rp {{ number_format($item->biaya_total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">Tidak ada data transaksi pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end pe-3 fs-5">TOTAL PENDAPATAN:</th>
                    <th class="text-end pe-4 fs-5">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-5">Bandung, {{ date('d F Y') }}<br>Mengetahui,</p>
                <p class="fw-bold text-uppercase underline mt-5 mb-0">( {{ Auth::user()->username }} )</p>
                <p>Owner / Pimpinan</p>
            </div>
        </div>

    </div>
</body>
</html>