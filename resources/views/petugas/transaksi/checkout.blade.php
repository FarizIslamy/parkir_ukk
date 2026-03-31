@extends('dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-danger text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-search me-2"></i>Cari Kendaraan Keluar</h5>
            </div>
            
            <div class="card-body p-4">
                
                <form action="{{ route('transaksi.keluar') }}" method="GET" class="mb-4">
                    <div class="input-group input-group-lg">
                        <input type="text" name="keyword" class="form-control text-uppercase fw-bold" 
                               placeholder="Ketik sebagian plat (Contoh: 123)..." 
                               value="{{ $keyword }}" autofocus autocomplete="off">
                        <button class="btn btn-danger" type="submit">
                            <i class="fas fa-search me-1"></i> CARI
                        </button>
                    </div>
                    <small class="text-muted">Tips: Cukup ketik angka belakang atau huruf depan saja.</small>
                </form>

                <hr>

                @if(isset($transaksiList) && $transaksiList->count() > 1)
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-1"></i> 
                        Ditemukan <b>{{ $transaksiList->count() }} kendaraan</b>. Silakan pilih salah satu:
                    </div>
                    
                    <div class="list-group">
                        @foreach($transaksiList as $t)
                        <a href="{{ route('transaksi.keluar', ['keyword' => $t->kendaraan->plat_nomor]) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                            <div>
                                <h5 class="mb-0 fw-bold text-uppercase">{{ $t->kendaraan->plat_nomor }}</h5>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i> Masuk: {{ date('H:i', strtotime($t->waktu_masuk)) }}
                                    ({{ ucfirst($t->kendaraan->jenis_kendaraan) }})
                                </small>
                            </div>
                            <span class="btn btn-sm btn-outline-primary">Pilih <i class="fas fa-chevron-right ms-1"></i></span>
                        </a>
                        @endforeach
                    </div>

                @elseif($transaksi)
                    <div class="alert alert-success border-0 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-1">Kendaraan</h6>
                                <h2 class="fw-bold mb-0 text-uppercase">{{ $transaksi->kendaraan->plat_nomor }}</h2>
                                <span class="badge bg-dark mt-2">{{ ucfirst($transaksi->kendaraan->jenis_kendaraan) }}</span>
                                <div class="mt-2 small text-muted">
                                    Masuk: {{ date('H:i', strtotime($transaksi->waktu_masuk)) }}
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <h6 class="text-muted mb-1">Total Tagihan</h6>
                                <h1 class="fw-bold text-danger mb-0">Rp {{ number_format($biaya) }}</h1>
                                <small class="text-muted fw-bold">{{ $durasi }} Jam Parkir</small>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('transaksi.proses_keluar', $transaksi->id_parkir) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="biaya_total" value="{{ $biaya }}">
                        <input type="hidden" name="durasi_jam" value="{{ $durasi }}">

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg py-3 fw-bold" 
                                    onclick="return confirm('Terima uang Rp {{ number_format($biaya) }} dan buka palang?')">
                                <i class="fas fa-money-bill-wave me-2"></i> TERIMA PEMBAYARAN
                            </button>
                        </div>
                    </form>

                @elseif($keyword)
                    <div class="text-center py-5">
                        <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ditemukan kendaraan dengan kata kunci <b>"{{ $keyword }}"</b></h5>
                        <p class="text-muted">Pastikan kendaraan tersebut berstatus MASUK.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection