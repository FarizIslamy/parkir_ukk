@extends('dashboard')

@section('content')

<div class="row mb-3">
    @foreach($areas as $area)
    <div class="col-md-4 mb-2">
        <div class="card text-center border-0 shadow-sm {{ $area->terisi >= $area->kapasitas ? 'bg-danger text-white' : 'bg-white' }}">
            <div class="card-body py-2"> 
                <div class="d-flex align-items-center justify-content-between">
                    <div class="text-start">
                        <h6 class="mb-0 fw-bold">{{ $area->nama_area }}</h6>
                        <small class="{{ $area->terisi >= $area->kapasitas ? 'text-white' : 'text-muted' }}" style="font-size: 11px;">Kapasitas: {{ $area->kapasitas }}</small>
                    </div>
                    <h2 class="mb-0 fw-bold">{{ $area->kapasitas - $area->terisi }}</h2>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fas fa-sign-in-alt me-2"></i>Parkir Masuk</h6>
                <a href="{{ route('transaksi.keluar') }}" class="btn btn-light btn-sm fw-bold text-primary shadow-sm" style="font-size: 12px;">
                    <i class="fas fa-exchange-alt me-1"></i> KE MODE KELUAR
                </a>
            </div>
            
            <div class="card-body p-3"> 
                <form action="{{ route('transaksi.masuk') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">PLAT NOMOR</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-primary"><i class="fas fa-car-side"></i></span>
                            <input type="text" name="plat_nomor" 
                                   class="form-control form-control-lg text-uppercase fw-bold border-primary" 
                                   placeholder="B 1234 XYZ" autofocus required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">JENIS KENDARAAN</label>
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="jenis_kendaraan" id="motor" value="motor" checked>
                                <label class="btn btn-outline-primary w-100 py-2" for="motor">
                                    <i class="fas fa-motorcycle mb-1"></i><br>
                                    <small class="fw-bold">MOTOR</small>
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="jenis_kendaraan" id="mobil" value="mobil">
                                <label class="btn btn-outline-success w-100 py-2" for="mobil">
                                    <i class="fas fa-car mb-1"></i><br>
                                    <small class="fw-bold">MOBIL</small>
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="jenis_kendaraan" id="lainnya" value="lainnya">
                                <label class="btn btn-outline-secondary w-100 py-2" for="lainnya">
                                    <i class="fas fa-truck mb-1"></i><br>
                                    <small class="fw-bold">LAINNYA</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">PILIH AREA PARKIR</label>
                        <select name="id_area" class="form-select form-select-lg border-primary fw-bold" required>
                            <option value="" selected disabled>-- Pilih Area Parkir --</option>
                            @foreach($areas as $area)
                                @php $sisa = $area->kapasitas - $area->terisi; @endphp
                                <option value="{{ $area->id_area }}" {{ $sisa <= 0 ? 'disabled' : '' }}>
                                    {{ strtoupper($area->nama_area) }} (Sisa: {{ $sisa }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm py-2">
                        <i class="fas fa-print me-2"></i> SIMPAN & CETAK KARCIS
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-2">
                <h6 class="mb-0 fw-bold text-muted small">KENDARAAN SEDANG PARKIR (BELUM BAYAR)</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-sm"> 
                    <thead class="table-light">
                        <tr>
                            <th>Jam</th>
                            <th>Plat Nomor</th>
                            <th>Area</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent as $t)
                        <tr>
                            <td>{{ date('H:i', strtotime($t->waktu_masuk)) }}</td>
                            <td class="fw-bold">{{ strtoupper($t->kendaraan->plat_nomor) }}</td>
                            <td><small class="fw-bold text-primary">{{ $t->area->nama_area ?? '-' }}</small></td>
                            <td>
                                <span class="badge bg-warning text-dark" style="font-size: 10px;">PARKIR</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted small">
                                <i class="fas fa-info-circle me-1"></i> Belum ada kendaraan masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection