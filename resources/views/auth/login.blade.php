<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT Yoko Fastener</title>
    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/templatemo-crypto-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/templatemo-crypto-login.css') }}">
</head>

<body class="auth-page">

    {{-- ===== KIRI: Branding ===== --}}
    <div class="auth-branding">
        <div class="branding-content">
            <div class="branding-logo">
                {{-- PERUBAHAN: src pakai asset() --}}
                <img src="{{ asset('images/logoYoko.png') }}" alt="Logo Yoko" class="branding-logo-img">
            </div>
            <h1 class="branding-title">PT Yoko Fastener Indonesia</h1>
            <p class="branding-subtitle">
                Sistem Informasi Manajemen Basis Data Yang Digunakan Untuk Pengelolaan Order,
                Invoice, dan Surat Jalan Secara Terintegrasi
            </p>
            <div class="branding-features">
                <div class="branding-feature">
                    <div class="feature-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1c1c1e" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                    </div>
                    Secure and user-friendly interface
                </div>
                <div class="branding-feature">
                    <div class="feature-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1c1c1e" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                    </div>
                    Manajemen Order & Stok
                </div>
                <div class="branding-feature">
                    <div class="feature-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1c1c1e" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                            <line x1="1" y1="10" x2="23" y2="10" />
                        </svg>
                    </div>
                    Invoice & Pembayaran
                </div>
            </div>
        </div>
    </div>

    {{-- ===== KANAN: Form Login ===== --}}
    <div class="auth-form-container">
        <button class="theme-toggle-btn" id="themeToggle">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="5" />
                <line x1="12" y1="1" x2="12" y2="3" />
                <line x1="12" y1="21" x2="12" y2="23" />
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                <line x1="1" y1="12" x2="3" y2="12" />
                <line x1="21" y1="12" x2="23" y2="12" />
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
            </svg>
        </button>

        <div class="auth-form-wrapper">
            <div class="form-header">
                <h1>Welcome Back</h1>
                <p>Enter your credentials to access your account</p>
            </div>

            {{-- PERUBAHAN: Tampilkan pesan error dari Laravel --}}
            @if ($errors->any())
                <div style="
                    background: rgba(239,68,68,0.1);
                    border: 1px solid rgba(239,68,68,0.3);
                    color: #ef4444;
                    padding: 12px 16px;
                    border-radius: 10px;
                    margin-bottom: 20px;
                    font-size: 14px;
                ">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- PERUBAHAN: form action ke route Laravel, method POST, tambah @csrf --}}
            <form class="auth-form active" id="loginForm" method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama</label>
                    <div class="form-input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        {{-- PERUBAHAN: tambah name="idpetugas" dan value old() --}}
                        <input type="text"
                               name="idpetugas"
                               class="form-input"
                               placeholder="Enter your ID Petugas"
                               value="{{ old('idpetugas') }}"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="form-input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0110 0v4" />
                        </svg>
                        {{-- PERUBAHAN: tambah name="password" --}}
                        <input type="password"
                               name="password"
                               class="form-input"
                               id="loginPassword"
                               placeholder="Enter your password"
                               required>
                        <button type="button" class="password-toggle" data-target="loginPassword">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-row">
                    <div class="checkbox-wrapper" id="rememberMe">
                        <div class="checkbox">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#1c1c1e" stroke-width="3">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </div>
                        <span class="checkbox-label">Remember me</span>
                    </div>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="submit-btn">Sign In</button>
            </form>
        </div>

        <p class="copyright">
            Copyright &copy; {{ date('Y') }} PT Yoko Fastener Indonesia
        </p>
    </div>

    {{-- PERUBAHAN: path JS pakai asset() --}}
    <script src="{{ asset('js/templatemo-crypto-script.js') }}"></script>

    {{-- PERUBAHAN: redirect JS dihapus, sudah dihandle Laravel di controller --}}

</body>
</html>