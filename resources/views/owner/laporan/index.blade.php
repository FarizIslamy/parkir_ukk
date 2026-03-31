@extends('dashboard')

@section('content')

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75 text-uppercase">Total Pendapatan (Periode Ini)</h6>
                    <h2 class="mb-0 fw-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h2>
                </div>
                <div>
                    <i class="fas fa-coins fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-table me-2"></i>Rincian Transaksi</h6>
            </div>
            <div class="card-body">
                
                <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 mb-4 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">DARI TANGGAL</label>
                        <input type="date" name="dari" class="form-control" value="{{ $dari ?? date('Y-m-01') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">SAMPAI TANGGAL</label>
                        <input type="date" name="sampai" class="form-control" value="{{ $sampai ?? date('Y-m-d') }}">
                    </div>
                    <div class="col-md">
                        <label class="d-none d-md-block">&nbsp;</label> 
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">
                                <i class="fas fa-filter me-2"></i> TAMPILKAN
                            </button>

                            <a href="{{ route('laporan.cetak', ['dari' => $dari, 'sampai' => $sampai]) }}" 
                                target="_blank" 
                                class="btn btn-danger w-100 fw-bold shadow-sm">
                                <i class="fas fa-file-pdf me-2"></i> EXPORT PDF
                            </a>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Waktu Keluar</th>
                                <th>Plat Nomor</th>
                                <th>Jenis</th>
                                <th>Durasi</th>
                                <th class="text-end">Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporan as $key => $row)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>
                                    <span class="fw-bold">{{ date('d M Y', strtotime($row->waktu_keluar)) }}</span><br>
                                    <small class="text-muted">{{ date('H:i', strtotime($row->waktu_keluar)) }} WIB</small>
                                </td>
                                <td class="fw-bold">{{ $row->kendaraan?->plat_nomor }}</td>
                                <td>{{ ucfirst($row->kendaraan?->jenis_kendaraan ?? 'Terhapus') }}</td>
                                <td>{{ $row->durasi_jam }} Jam</td>
                                <td class="text-end fw-bold text-success">
                                    Rp {{ number_format($row->biaya_total, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-info-circle fa-2x mb-3"></i><br>
                                    Tidak ada data transaksi pada periode tanggal ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light fw-bold border-top-2">
                            <tr>
                                <td colspan="5" class="text-end text-uppercase">Total Pendapatan</td>
                                <td class="text-end text-primary" style="font-size: 16px;">
                                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection