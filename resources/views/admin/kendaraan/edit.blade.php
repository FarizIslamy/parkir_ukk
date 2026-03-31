@extends('dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-edit me-2"></i>Edit Data Kendaraan
                </h5>
            </div>
            
            <div class="card-body">
                <form action="{{ route('data-kendaraan.update', $kendaraan->id_kendaraan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Plat Nomor</label>
                        <input type="text" name="plat_nomor" 
                               class="form-control text-uppercase @error('plat_nomor') is-invalid @enderror" 
                               value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}">
                        
                        @error('plat_nomor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-select">
                            <option value="motor" {{ $kendaraan->jenis_kendaraan == 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ $kendaraan->jenis_kendaraan == 'mobil' ? 'selected' : '' }}>Mobil</option>
                            <option value="lainnya" {{ $kendaraan->jenis_kendaraan == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Warna Kendaraan</label>
                        <input type="text" name="warna" class="form-control" 
                               value="{{ old('warna', $kendaraan->warna) }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Nama Pemilik</label>
                        <input type="text" name="pemilik" class="form-control" 
                               value="{{ old('pemilik', $kendaraan->pemilik) }}">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('data-kendaraan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection