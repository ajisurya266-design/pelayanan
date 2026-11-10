<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas - Buku Tamu Dinas Pendidikan Kota Jambi</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #1d4ed8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            max-width: 440px;
            width: 100%;
            overflow: hidden;
            border: none;
        }

        .login-header {
            background: #f8fafc;
            padding: 2.25rem 2rem 1.75rem;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .login-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #ffffff;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.35);
            margin-bottom: 1rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            border: none;
            font-weight: 700;
            padding: 0.85rem;
            border-radius: 12px;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            transition: all 0.2s;
        }

        .btn-login:hover {
            color: white;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e1;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .quick-badge {
            cursor: pointer;
            transition: all 0.2s;
        }

        .quick-badge:hover {
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h4 class="fw-bold text-dark mb-1">DINAS PENDIDIKAN</h4>
            <div class="text-primary fw-bold small text-uppercase letter-spacing-1">Kota Jambi</div>
            <p class="text-muted small mt-2 mb-0">Sistem Informasi Buku Tamu Ruang Pelayanan</p>
        </div>

        <div class="p-4 p-md-4">
            @if(session('info'))
                <div class="alert alert-info small py-2 rounded-3 border-0 d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>{{ session('info') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger small py-2 rounded-3 border-0 mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-secondary">Alamat Email Petugas</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required autofocus placeholder="nama@disdik.jambikota.go.id">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold text-secondary">Kata Sandi (Password)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                               required placeholder="Masukkan kata sandi">
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                    </div>
                    <a href="{{ route('kiosk.index') }}" class="small text-decoration-none text-primary fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i>Ke Layar Tamu
                    </a>
                </div>

                <button type="submit" class="btn btn-login w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-box-arrow-in-right fs-5"></i>
                    <span>Masuk ke Sistem</span>
                </button>
            </form>

        </div>
    </div>

</body>
</html>

