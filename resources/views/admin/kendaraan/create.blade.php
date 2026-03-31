@extends('dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Kendaraan
                </h5>
            </div> 
            
            <div class="card-body">
                <form action="{{ route('data-kendaraan.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Plat Nomor (Tanpa Spasi)</label>
                        <input type="text" name="plat_nomor" 
                               class="form-control text-uppercase @error('plat_nomor') is-invalid @enderror" 
                               value="{{ old('plat_nomor') }}" 
                               placeholder="Contoh: B1234XYZ" autofocus>
                        <small class="text-muted">Gunakan huruf kapital tanpa spasi.</small>
                        
                        @error('plat_nomor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="motor">Motor</option>
                            <option value="mobil">Mobil</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Warna Kendaraan</label>
                        <input type="text" name="warna" class="form-control" 
                               value="{{ old('warna') }}" placeholder="Contoh: Hitam">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Nama Pemilik (Opsional)</label>
                        <input type="text" name="pemilik" class="form-control" 
                               value="{{ old('pemilik') }}" placeholder="Contoh: Budi Santoso">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('data-kendaraan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection