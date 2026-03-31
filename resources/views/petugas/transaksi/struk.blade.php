<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Parkir - {{ $transaksi->kendaraan->plat_nomor }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            /* Font lebih besar agar jelas */
            font-size: 14px; 
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        /* Container sekarang mengikuti lebar kertas printer */
        .container {
            width: 100%; 
            max-width: 80mm; /* Batas aman printer 80mm (Standar umum) */
            margin: 0 auto;
            padding: 5px;
            box-sizing: border-box;
        }

        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        
        /* Garis lebih tebal biar kelihatan pembatasnya */
        .garis {
            border-top: 2px dashed #000; 
            margin: 10px 0;
        }

        .item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* Biar rapi kalau teks panjang */
            margin-bottom: 5px;
        }
        
        /* Judul besar */
        .judul {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        /* Bagian Total Harga dibuat sangat menonjol */
        .total-box {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
            padding: 5px 0;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
        }

        /* Settingan khusus Printer Thermal */
        @media print {
            @page { 
                margin: 0; 
                size: auto; /* Biarkan printer yang atur ukuran kertas */
            }
            body { 
                margin: 0.5cm; /* Beri sedikit jarak aman dari pinggir kertas */
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container">
        <div class="text-center">
            <div class="judul">PARKIR UKK</div>
            <span style="font-size: 12px;">Jl. Pendidikan No. 1, Bandung</span>
        </div>

        <div class="garis"></div>

        <div class="item">
            <span>Tiket</span>
            <span class="fw-bold">#{{ $transaksi->id_parkir }}</span>
        </div>
        <div class="item" style="font-size: 16px;"> <span>Plat</span>
            <span class="fw-bold">{{ strtoupper($transaksi->kendaraan->plat_nomor) }}</span>
        </div>
        <div class="item">
            <span>Area</span>
            <span>{{ $transaksi->area->nama_area }}</span>
        </div>

        <div class="garis"></div>

        <div class="item">
            <span>Masuk</span>
            <span>{{ date('d/m H:i', strtotime($transaksi->waktu_masuk)) }}</span>
        </div>
        <div class="item">
            <span>Keluar</span>
            <span>{{ date('d/m H:i', strtotime($transaksi->waktu_keluar)) }}</span>
        </div>
        <div class="item">
            <span>Durasi</span>
            <span>{{ $transaksi->durasi_jam }} Jam</span>
        </div>

        <div class="item total-box">
            <span>TOTAL</span>
            <span>Rp {{ number_format($transaksi->biaya_total, 0, ',', '.') }}</span>
        </div>

        <div class="item">
            <span>Bayar</span>
            <span>TUNAI</span>
        </div>
        <div class="item">
            <span>Petugas</span>
            <span>{{ Str::limit(Auth::user()->nama_lengkap, 10) }}</span>
        </div>

        <div class="garis"></div>

        <div class="text-center" style="margin-top: 15px;">
            <span style="font-size: 16px; font-weight:bold;">TERIMA KASIH</span><br>
            <span style="font-size: 12px;">Hati-hati di jalan</span>
        </div>
    </div>

</body>
</html>