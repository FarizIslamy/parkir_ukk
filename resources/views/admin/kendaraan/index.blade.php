@extends('dashboard')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary">Data Kendaraan Pelanggan</h5>
        <a href="{{ route('data-kendaraan.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Kendaraan
        </a>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Plat Nomor</th>
                        <th>Jenis</th>
                        <th>Warna / Pemilik</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kendaraans as $key => $k)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="fw-bold">{{ strtoupper($k->plat_nomor) }}</td>
                        <td>
                             @if($k->jenis_kendaraan == 'motor') <i class="fas fa-motorcycle text-primary"></i>
                             @elseif($k->jenis_kendaraan == 'mobil') <i class="fas fa-car text-success"></i>
                             @else <i class="fas fa-asterisk text-warning"></i> @endif
                             {{ ucfirst($k->jenis_kendaraan) }}
                        </td>
                        <td>
                            <div class="small text-muted">Warna: {{ $k->warna ?? '-' }}</div>
                            <div class="fw-bold">Pemilik: {{ $k->pemilik ?? '-' }}</div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('data-kendaraan.edit', $k->id_kendaraan) }}" class="btn btn-sm btn-info text-white me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form onsubmit="return confirm('Hapus data kendaraan ini? History transaksi mungkin akan hilang plat nomornya.');" 
                                  action="{{ route('data-kendaraan.destroy', $k->id_kendaraan) }}" 
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data kendaraan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection