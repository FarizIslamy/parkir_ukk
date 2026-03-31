@extends('dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-edit me-2"></i>Edit Tarif Parkir
                </h5>
            </div>
            
            <div class="card-body">
                <form action="{{ route('data-tarif.update', $tarif->id_tarif) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="motor" {{ old('jenis_kendaraan', $tarif->jenis_kendaraan) == 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ old('jenis_kendaraan', $tarif->jenis_kendaraan) == 'mobil' ? 'selected' : '' }}>Mobil</option>
                            <option value="lainnya" {{ old('jenis_kendaraan', $tarif->jenis_kendaraan) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        
                        @error('jenis_kendaraan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Tarif Per Jam (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="tarif_per_jam" 
                                   class="form-control @error('tarif_per_jam') is-invalid @enderror" 
                                   value="{{ old('tarif_per_jam', $tarif->tarif_per_jam) }}">
                        </div>

                        @error('tarif_per_jam')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('data-tarif.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Tarif
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection