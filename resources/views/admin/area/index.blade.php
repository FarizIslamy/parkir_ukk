@extends('dashboard')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary">Data Area Parkir</h5>
        <a href="{{ route('data-area.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Area
        </a>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Area</th>
                        <th width="30%">Kapasitas (Terisi / Total)</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($areas as $key => $area)
                    @php
                        // Hitung Persentase Keterisian
                        $persen = ($area->kapasitas > 0) ? ($area->terisi / $area->kapasitas) * 100 : 0;
                        $warna = $persen >= 100 ? 'bg-danger' : ($persen >= 80 ? 'bg-warning' : 'bg-success');
                    @endphp
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="fw-bold">{{ $area->nama_area }}</td>
                        <td>
                            <div class="d-flex justify-content-between small mb-1">
                                <span>{{ $area->terisi }} Terisi</span>
                                <span>{{ $area->kapasitas }} Maks</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar {{ $warna }}" role="progressbar" 
                                     style="width: {{ $persen }}%"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($area->terisi >= $area->kapasitas)
                                <span class="badge bg-danger">PENUH</span>
                            @else
                                <span class="badge bg-success">TERSEDIA</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('data-area.edit', $area->id_area) }}" class="btn btn-sm btn-info text-white me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form onsubmit="return confirm('Hapus area ini?');" 
                                  action="{{ route('data-area.destroy', $area->id_area) }}" 
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
                        <td colspan="5" class="text-center text-muted py-4">Belum ada area parkir.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection