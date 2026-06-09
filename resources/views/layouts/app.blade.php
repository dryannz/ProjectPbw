<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PT Yoko Fastener')</title>
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
    <link rel="stylesheet" href="{{ asset('css/templatemo-crypto-pages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/new-style.css') }}">
    <script src="https://kit.fontawesome.com/84fd8ce536.js" crossorigin="anonymous"></script>
    @stack('styles')
</head>

<body>
    {{-- Tombol hamburger untuk mobile --}}
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="dashboard">

        {{-- ===================== SIDEBAR ===================== --}}
        <aside class="sidebar" id="sidebar">

            {{-- Logo --}}
            <div class="logo">
                <div class="logo-icon logo-icon-custom"
                     style="background-image: url('{{ asset('images/logoYoko.png') }}');
                            background-size: 30px;
                            background-position: center;
                            background-repeat: no-repeat;">
                </div>
                <span class="logo-text">PT Yoko Fastener</span>
            </div>

            {{-- Main Menu --}}
            <nav class="nav-section">
                <div class="nav-label">Main Menu</div>
                <a href="{{ route('dashboard') }}"
                   class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Dashboard
                </a>
            </nav>

            {{-- Data Master --}}
            <nav class="nav-section">
                <div class="nav-label">Data Master</div>
                <a href="{{ route('petugas.index') }}"
                   class="nav-item {{ request()->routeIs('petugas.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 00-3-3.87" />
                        <path d="M16 3.13a4 4 0 010 7.75" />
                    </svg>
                    Petugas
                </a>

                <a href="{{ route('customer.index') }}"
                   class="nav-item {{ request()->routeIs('customer.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Customer
                </a>

                <a href="{{ route('barang.index') }}"
                   class="nav-item {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                        <path d="M16 21v-4a2 2 0 012-2h4M2 7h20M5 7V5a2 2 0 012-2h10a2 2 0 012 2v2" />
                    </svg>
                    Barang
                </a>
            </nav>

            {{-- Data Transaksional --}}
            <nav class="nav-section">
                <div class="nav-label">Data Transaksional</div>
                <a href="{{ route('purchaseorder.index') }}"
                   class="nav-item {{ request()->routeIs('purchaseorder.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    Purchase Order
                </a>

                <a href="{{ route('invoice.index') }}"
                   class="nav-item {{ request()->routeIs('invoice.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                        <line x1="1" y1="10" x2="23" y2="10" />
                    </svg>
                    Invoice
                </a>

                <a href="{{ route('suratjalan.index') }}"
                   class="nav-item {{ request()->routeIs('suratjalan.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="3" width="15" height="13" />
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />
                        <circle cx="5.5" cy="18.5" r="2.5" />
                        <circle cx="18.5" cy="18.5" r="2.5" />
                    </svg>
                    Surat Jalan
                </a>
            </nav>



            {{-- Footer Sidebar: Theme Toggle + Logout --}}
            <div class="sidebar-footer">
                <div class="theme-toggle">
                    <div class="theme-toggle-label">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                        Light Mode
                    </div>
                    <div class="theme-switch" id="themeSwitch"></div>
                </div>

                {{-- PERUBAHAN: logout pakai form POST Laravel, bukan href --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>
        {{-- ===================== END SIDEBAR ===================== --}}

        {{-- ===================== KONTEN UTAMA ===================== --}}
        {{-- Setiap halaman (petugas, barang, dll) akan muncul di sini --}}
        <main class="main-content">
            @yield('content')
        </main>
        {{-- ===================== END KONTEN UTAMA ===================== --}}

    </div>

    <script src="{{ asset('js/templatemo-crypto-script.js') }}"></script>
    @stack('scripts')
</body>

</html>
