@extends('dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Area Parkir
                </h5>
            </div>
            
            <div class="card-body">
                <form action="{{ route('data-area.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Area / Lokasi</label>
                        <input type="text" name="nama_area" 
                               class="form-control @error('nama_area') is-invalid @enderror" 
                               value="{{ old('nama_area') }}" 
                               placeholder="Contoh: Area VIP, Lantai 2, Area Karyawan" required>
                        
                        @error('nama_area')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Kapasitas Maksimal</label>
                        <input type="number" name="kapasitas" 
                               class="form-control @error('kapasitas') is-invalid @enderror" 
                               value="{{ old('kapasitas') }}" 
                               placeholder="Contoh: 50" required>
                        <small class="text-muted">Masukkan jumlah maksimal kendaraan.</small>

                        @error('kapasitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('data-area.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Area
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection