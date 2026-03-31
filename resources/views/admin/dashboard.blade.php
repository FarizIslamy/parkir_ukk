@extends('dashboard') @section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="me-4 text-center" style="width: 60px;">
                    <i class="fas fa-user-shield fa-3x opacity-75"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold">Selamat Datang, {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}!</h4>
                    <p class="mb-0 opacity-75">Anda login sebagai Administrator. Berikut adalah ringkasan sistem hari ini.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 border-bottom border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted fw-bold mb-0">TOTAL PENGGUNA</h6>
                    <div class="bg-success bg-opacity-10 text-success rounded p-2">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0">{{ $totalUser }} <small class="text-muted fs-6">Akun Aktif</small></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 border-bottom border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted fw-bold mb-0">SEDANG PARKIR</h6>
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-2">
                        <i class="fas fa-parking fa-lg"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0">{{ $kendaraanParkir }} <small class="text-muted fs-6">Kendaraan</small></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 border-bottom border-info border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted fw-bold mb-0">TRANSAKSI SELESAI</h6>
                    <div class="bg-info bg-opacity-10 text-info rounded p-2">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0">{{ $kendaraanSelesai }} <small class="text-muted fs-6">Transaksi</small></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 border-bottom border-danger border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted fw-bold mb-0">SISA SLOT PARKIR</h6>
                    <div class="bg-danger bg-opacity-10 text-danger rounded p-2">
                        <i class="fas fa-car-side fa-lg"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0">{{ $sisaSlot }} <small class="text-muted fs-6">Slot Kosong</small></h3>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fas fa-history text-primary me-2"></i>Aktivitas Sistem Terkini</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Waktu</th>
                                <th>Pengguna</th>
                                <th>Deskripsi Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLogs as $log)
                            <tr>
                                <td class="ps-4 text-muted"><small>{{ $log->created_at->diffForHumans() }}</small></td>
                                <td>
                                    @if(isset($log->user))
                                        @if($log->user->role == 'admin')
                                            <span class="badge bg-danger">{{ $log->user->username }}</span>
                                        @elseif($log->user->role == 'petugas')
                                            <span class="badge bg-warning text-dark">{{ $log->user->username }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $log->user->username }}</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Sistem / ID: {{ $log->id_user }}</span>
                                    @endif
                                </td>
                                <td>{{ $log->aktivitas }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Belum ada aktivitas yang terekam.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-center py-3">
                <a href="{{ route('log.index') }}" class="text-decoration-none fw-bold text-primary">
                    Lihat Seluruh Log Aktivitas <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection