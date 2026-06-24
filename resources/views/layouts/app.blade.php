<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PT Yoko Fastener')</title>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/templatemo-crypto-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/templatemo-crypto-pages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/templatemo-crypto-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/new-style.css') }}">
    <script src="https://kit.fontawesome.com/84fd8ce536.js" crossorigin="anonymous" onerror="fallbackFontAwesome()"></script>
    @stack('styles')
</head>

<body>
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <div class="hamburger">
            <span></span><span></span><span></span>
        </div>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    @php
    $jabatan = strtolower(trim(auth()->user()->jabatan ?? ''));
    @endphp

    <div class="dashboard">

        <aside class="sidebar" id="sidebar">

            <div class="logo">
                @php $logoUrl = asset('images/logoYoko.png'); @endphp
                <div class="logo-icon logo-icon-custom"
                    style="background-image: url('{{ $logoUrl }}'); background-size: 30px; background-position: center; background-repeat: no-repeat;">
                </div>
                <span class="logo-text">PT Yoko Fastener</span>
            </div>

            <!-- {{-- Badge jabatan --}}
            <div style="padding: 0 16px 12px; margin-top: -4px;">
                <span style="
                    display: inline-block;
                    font-size: 11px;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: .05em;
                    padding: 3px 10px;
                    border-radius: 999px;
                    background: var(--accent, #3b82f6);
                    color: #fff;
                ">{{ auth()->user()->jabatan }}</span>
            </div> -->

            {{-- Main Menu --}}
            <nav class="nav-section">
                <div class="nav-label">Main Menu</div>
                <a href="{{ route('dashboard') }}"
                    class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house-chimney"></i>
                    Dashboard
                </a>
            </nav>

            {{-- Data Master --}}
            <nav class="nav-section">
                <div class="nav-label">Data Master</div>

                <a href="{{ route('petugas.index') }}"
                    class="nav-item {{ request()->routeIs('petugas.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    Petugas
                </a>

                <a href="{{ route('customer.index') }}"
                    class="nav-item {{ request()->routeIs('customer.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user"></i>
                    Pelanggan
                </a>

                <a href="{{ route('barang.index') }}"
                    class="nav-item {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-packing"></i>
                    Barang
                </a>
            </nav>

            {{-- Data Transaksional --}}
            <nav class="nav-section">
                <div class="nav-label">Data Transaksional</div>

                <a href="{{ route('purchaseorder.index') }}"
                    class="nav-item {{ request()->routeIs('purchaseorder.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt"></i>
                    Purchase Order
                </a>

                <a href="{{ route('invoice.index') }}"
                    class="nav-item {{ request()->routeIs('invoice.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice"></i>
                    Invoice
                </a>

                <a href="{{ route('suratjalan.index') }}"
                    class="nav-item {{ request()->routeIs('suratjalan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-truck-fast"></i>
                    Surat Jalan
                </a>
            </nav>

            {{-- Footer Sidebar --}}
            <div class="sidebar-footer">
                <div class="theme-toggle">
                    <div class="theme-toggle-label">
                        <i class="fa-solid fa-eye"></i>
                        Mode
                    </div>
                    <div class="theme-switch" id="themeSwitch"></div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            @yield('content')
        </main>

    </div>

    <script src="{{ asset('js/templatemo-crypto-script.js') }}"></script>
    @stack('scripts')
</body>

</html>