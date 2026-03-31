@extends('dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-edit me-2"></i>Edit Area Parkir
                </h5>
            </div>
            
            <div class="card-body">
                <form action="{{ route('data-area.update', $area->id_area) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Area / Lokasi</label>
                        <input type="text" name="nama_area" 
                               class="form-control @error('nama_area') is-invalid @enderror" 
                               value="{{ old('nama_area', $area->nama_area) }}" 
                               placeholder="Contoh: Area VIP, Lantai 2, Area Karyawan" required>
                        
                        @error('nama_area')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Kapasitas Maksimal</label>
                        <input type="number" name="kapasitas" 
                               class="form-control @error('kapasitas') is-invalid @enderror" 
                               value="{{ old('kapasitas', $area->kapasitas) }}" required>
                        
                        <div class="alert alert-info py-2 mt-2 small">
                            <i class="fas fa-info-circle me-1"></i>
                            Saat ini terisi: <strong>{{ $area->terisi }}</strong> kendaraan.
                            Kapasitas tidak boleh lebih kecil dari jumlah terisi.
                        </div>

                        @error('kapasitas')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('data-area.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Area
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection