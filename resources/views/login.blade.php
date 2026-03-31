<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-PARKIR UKK</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            /* Menyesuaikan warna background agar mirip dengan latar dashboard */
            background-color: #f4f6f9; 
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #fff;
            border-radius: 6px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); /* Bayangan sedikit dipertegas */
            width: 100%;
            max-width: 400px;
            overflow: hidden;
            /* Mengubah garis atas menjadi biru sesuai tema dashboard */
            border-top: 4px solid #0d6efd; 
        }

        .login-header {
            padding: 35px 20px 10px;
            text-align: center;
        }

        .login-title {
            font-weight: 800;
            font-size: 26px;
            color: #343a40; /* Warna teks gelap (dark grey) mirip sidebar */
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .brand-icon {
            font-size: 50px;
            /* Mengubah warna icon menjadi biru dashboard */
            color: #0d6efd; 
            margin-bottom: 15px;
        }

        /* Custom Style untuk Input Group */
        .input-group-text {
            background-color: #fff;
            border-left: none;
            color: #adb5bd;
        }
        
        .form-control {
            border-right: none;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        /* Efek Fokus agar border jadi warna biru primary */
        .form-control:focus, .form-control:focus + .input-group-text {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15); /* Glow biru khas Bootstrap */
        }

        /* Perbaikan tampilan jika auto-fill dari browser aktif */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 30px white inset !important;
        }

        /* Tombol Biru sesuai Dashboard */
        .btn-primary-custom {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            font-weight: 600;
            padding: 10px;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
            color: white;
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
        }

        .login-footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            border-top: 1px solid #eaeaea;
        }
    </style>
</head>
<body>

    <div class="login-card">
        
        <div class="login-header">
            <i class="fas fa-square-parking brand-icon"></i>
            <h1 class="login-title">E-PARKIR</h1>
            <p class="text-muted mb-3" style="font-size: 14px;">Masukkan Username dan Password!</p>
        </div>

        <div class="card-body px-4 pb-4 pt-0">
            
            @if(session('error'))
                <div class="alert alert-danger small py-2 text-center mb-3">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf

                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus value="{{ old('username') }}">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>

                <div class="input-group mb-4">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary-custom">Login</button>
                </div>

            </form>
        </div>
        
        <div class="login-footer">
            By : Peserta UKK 2026
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>