<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title}} - UKK RPL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            overflow-x: hidden; 
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }
        
        .wrapper { 
            display: flex; 
            width: 100%; 
            align-items: stretch;
        }

        /* --- SIDEBAR STYLE --- */
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
        }
        
        #sidebar.active { margin-left: -250px; }

        .sidebar-header {
            padding: 20px;
            background: #212529;
            border-bottom: 1px solid #4b545c;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #sidebar ul.components { padding: 20px 0; }

        #sidebar ul li a {
            padding: 15px 20px;
            display: block;
            color: #cfd2d6;
            text-decoration: none;
            transition: 0.3s;
        }

        #sidebar ul li a:hover { color: #fff; background: #495057; }
        #sidebar ul li.active > a { background: #0d6efd; color: white; }

        /* --- CONTENT STYLE --- */
        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        #navbar-toggle { display: none; }
    </style>
</head>
<body>

<div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0"><i class="fas fa-parking me-2"></i>E-PARKIR</h4>
            <button type="button" id="sidebarCollapseInner" class="btn btn-sm text-white">
                <i class="fas fa-bars fa-lg"></i>
            </button>
        </div>

        <ul class="list-unstyled components">
            @if(Auth::user()->role == 'admin')
                <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="/dashboard"><i class="fas fa-home me-2"></i> Dashboard</a>
                </li>
                <li class="{{ request()->is('data-user*') ? 'active' : '' }}">
                    <a href="{{ route('data-user.index') }}"><i class="fas fa-users me-2"></i> Data User</a>
                </li>
                <li class="{{ request()->is('data-tarif*') ? 'active' : '' }}">
                    <a href="{{ route('data-tarif.index') }}"><i class="fas fa-tags me-2"></i> Data Tarif</a>
                </li>
                <li class="{{ request()->is('data-area*') ? 'active' : '' }}">
                    <a href="{{ route('data-area.index') }}"><i class="fas fa-map-marked-alt me-2"></i> Data Area</a>
                </li>
                <li class="{{ request()->is('data-kendaraan*') ? 'active' : '' }}">
                    <a href="{{ route('data-kendaraan.index') }}"><i class="fas fa-car me-2"></i> Data Kendaraan</a>
                </li>
                <li class="{{ request()->is('log-aktivitas*') ? 'active' : '' }}">
                    <a href="{{ route('log.index') }}"><i class="fas fa-history me-2"></i>log aktivitas</a>
                </li>
            @endif

            @if(Auth::user()->role == 'petugas')
                <li class="{{ request()->is('transaksi*') ? 'active' : '' }}">
                    <a href="/transaksi"><i class="fas fa-wallet me-2"></i> Transaksi</a>
                </li>
                @endif

            @if(Auth::user()->role == 'owner')
                <li class="{{ request()->is('laporan*') ? 'active' : '' }}">
                    <a href="{{ route('laporan.index') }}">
                        <i class="fas fa-chart-line me-2"></i> Laporan Pendapatan
                    </a>
                </li>
            @endif
        </ul>
    </nav>

    <div id="content">
        
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4 px-3">
            <div class="container-fluid">
                
                <button type="button" id="navbar-toggle" class="btn btn-primary shadow-sm me-3">
                    <i class="fas fa-bars"></i>
                </button>

                <h4 class="mb-0 text-dark">{{ $title ?? 'Dashboard' }}</h4>

                <div class="ms-auto">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <strong>{{ Auth::user()->username }}</strong>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser1">
                            <li><div class="dropdown-header">Role: <strong>{{ ucfirst(Auth::user()->role) }}</strong></div></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </nav>

        @if(session('print_id'))
            <div id="kotak-cetak" class="mb-4 fade show">
                <a href="{{ route('transaksi.cetak', session('print_id')) }}" 
                   target="_blank" 
                   onclick="document.getElementById('kotak-cetak').remove()" 
                   class="btn btn-success w-100 btn-lg py-3 fw-bold shadow border-0 text-uppercase"
                   style="font-size: 18px;">
                    <i class="fas fa-print me-2"></i> Transaksi Berhasil! Klik Disini Untuk Cetak Struk
                </a>
            </div>

        @elseif(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert" id="notif-login">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- 1. LOGIKA SIDEBAR ---
        const sidebar = document.getElementById('sidebar');
        const btnInside = document.getElementById('sidebarCollapseInner'); 
        const btnOutside = document.getElementById('navbar-toggle');

        if (localStorage.getItem('sidebar-active') === 'true') {
            sidebar.classList.add('active'); 
            if (btnOutside) btnOutside.style.display = 'inline-block'; 
        }

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            if (sidebar.classList.contains('active')) {
                btnOutside.style.display = 'inline-block';
                localStorage.setItem('sidebar-active', 'true'); 
            } else {
                btnOutside.style.display = 'none';
                localStorage.setItem('sidebar-active', 'false'); 
            }
        }

        if (btnInside) btnInside.addEventListener('click', toggleSidebar);
        if (btnOutside) btnOutside.addEventListener('click', toggleSidebar);


        // --- 2. LOGIKA AUTO-CLOSE NOTIFIKASI ---
        // Hanya menutup notifikasi biasa (#notif-login), TIDAK menutup tombol cetak (#kotak-cetak)
        setTimeout(function() {
            var alertNode = document.querySelector('#notif-login');
            if (alertNode) {
                var alert = new bootstrap.Alert(alertNode);
                alert.close();
            }
        }, 3000); // 3 Detik
    });
</script>

</body>
</html>