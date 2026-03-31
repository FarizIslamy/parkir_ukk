@extends('dashboard')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-history me-2"></i>Log Aktivitas Sistem</h5>
    </div>
    
    <div class="card-body">
        <div class="alert alert-info border-0 shadow-sm mb-4">
            <i class="fas fa-info-circle me-2"></i> 
            Halaman ini memantau seluruh aktivitas pengguna di dalam sistem E-Parkir.
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="20%">Waktu</th>
                        <th width="20%">Pengguna (Role & Username)</th>
                        <th>Deskripsi Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $key => $log)
                    <tr>
                        <td class="text-center">{{ $logs->firstItem() + $key }}</td>
                        <td>{{ $log->created_at->format('d M Y, H:i:s') }} WIB</td>
                        <td>
                            @if(isset($log->user))
                                @if($log->user->role == 'admin')
                                    <span class="badge bg-danger px-2 py-1">
                                        <i class="fas fa-user-shield me-1"></i> Admin: {{ $log->user->username }}
                                    </span>
                                @elseif($log->user->role == 'petugas')
                                    <span class="badge bg-warning text-dark px-2 py-1">
                                        <i class="fas fa-user-tie me-1"></i> Petugas: {{ $log->user->username }}
                                    </span>
                                @else
                                    <span class="badge bg-success px-2 py-1">
                                        <i class="fas fa-user me-1"></i> Owner: {{ $log->user->username }}
                                    </span>
                                @endif
                            @else
                                <span class="badge bg-secondary px-2 py-1">
                                    <i class="fas fa-user-times me-1"></i> Akun Terhapus (ID: {{ $log->id_user }})
                                </span>
                            @endif
                        </td>
                        <td>{{ $log->aktivitas }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="fas fa-folder-open fa-2x mb-2 opacity-50"></i><br>
                            Belum ada log aktivitas yang terekam.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $logs->links() }}
        </div>

    </div>
</div>

@endsection