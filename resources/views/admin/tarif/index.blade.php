@extends('dashboard')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary">Data Tarif Parkir</h5>
        <a href="{{ route('data-tarif.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Tarif
        </a>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Jenis Kendaraan</th>
                        <th>Tarif Per Jam</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tarifs as $key => $tarif)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>
                            @if(strtolower($tarif->jenis_kendaraan) == 'motor')
                                <i class="fas fa-motorcycle me-2 text-muted"></i>
                            @elseif(strtolower($tarif->jenis_kendaraan) == 'mobil')
                                <i class="fas fa-car me-2 text-muted"></i>
                            @else
                                <i class="fas fa-asterisk me-2 text-muted"></i>
                            @endif
                            {{ ucfirst($tarif->jenis_kendaraan) }}
                        </td>
                        <td>
                            Rp {{ number_format($tarif->tarif_per_jam, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('data-tarif.edit', $tarif->id_tarif) }}" class="btn btn-sm btn-info text-white me-1">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form onsubmit="return confirm('Yakin ingin menghapus tarif ini?');" 
                                  action="{{ route('data-tarif.destroy', $tarif->id_tarif) }}" 
                                  method="POST" 
                                  style="display:inline;">
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
                        <td colspan="4" class="text-center text-muted py-4">
                            Belum ada data tarif parkir.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection