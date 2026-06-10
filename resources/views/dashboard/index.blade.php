@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan operasional PT Yoko Fastener')

@section('content')
<div class="header">
    <div class="header-left">
        <h2 class="section-title">Dashboard</h2>
        <p class="section-subtitle">Ringkasan operasional PT Yoko Fastener</p>
    </div>
    <div class="header-right">
        <div class="header-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input id="searchInput" type="text" placeholder="Search...">
        </div>
        <div class="user-menu">
            <div class="user-avatar">{{ auth()->user()?->inisial ?? 'U' }}</div>
            <div class="user-info">
                <span class="user-name">{{ auth()->user()?->namapetugas ?? 'Guest' }}</span>
                <span class="user-role">{{ auth()->user()?->jabatan ?? 'Unknown' }}</span>
            </div>
        </div>
    </div>
</div>

    {{-- ── GREETING BANNER ── --}}
    <div class="greeting-banner">
        <div class="greeting-text">
            <h2 id="greetingMsg">Selamat datang!</h2>
            <p>Berikut ringkasan data real-time PT Yoko Fastener dari database.</p>
        </div>
        <div class="greeting-date" id="greetingDate"></div>
    </div>

    {{-- ── 6 STAT CARDS ── --}}
    <div class="stat-grid">
        <div class="stat-card copper">
            <div class="stat-top">
                <span class="stat-label">Purchase Order</span>
                <div class="stat-icon"><i class="fa-solid fa-receipt"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total_po'] }}</div>
            <div class="stat-sub">Total order masuk</div>
            <a href="{{ route('purchaseorder.index') }}" class="stat-link">Lihat semua &rarr;</a>
        </div>

        <div class="stat-card green">
            <div class="stat-top">
                <span class="stat-label">Invoice</span>
                <div class="stat-icon"><i class="fa-solid fa-file-invoice"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total_invoice'] }}</div>
            <div class="stat-sub">Total invoice diterbitkan</div>
            <a href="{{ route('invoice.index') }}" class="stat-link">Lihat semua &rarr;</a>
        </div>

        <div class="stat-card blue">
            <div class="stat-top">
                <span class="stat-label">Surat Jalan</span>
                <div class="stat-icon"><i class="fa-solid fa-truck-fast"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total_sj'] }}</div>
            <div class="stat-sub">Total pengiriman</div>
            <a href="{{ route('suratjalan.index') }}" class="stat-link">Lihat semua &rarr;</a>
        </div>

        <div class="stat-card rose">
            <div class="stat-top">
                <span class="stat-label">Customer</span>
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total_customer'] }}</div>
            <div class="stat-sub">Total customer terdaftar</div>
            <a href="{{ route('customer.index') }}" class="stat-link">Lihat semua &rarr;</a>
        </div>

        <div class="stat-card violet">
            <div class="stat-top">
                <span class="stat-label">Barang</span>
                <div class="stat-icon"><i class="fa-solid fa-boxes-packing"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total_barang'] }}</div>
            <div class="stat-sub">Total jenis barang</div>
            <a href="{{ route('barang.index') }}" class="stat-link">Lihat semua &rarr;</a>
        </div>

        <div class="stat-card teal">
            <div class="stat-top">
                <span class="stat-label">Petugas</span>
                <div class="stat-icon"><i class="fa-solid fa-id-badge"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total_petugas'] }}</div>
            <div class="stat-sub">Total petugas aktif</div>
            <a href="{{ route('petugas.index') }}" class="stat-link">Lihat semua &rarr;</a>
        </div>
    </div>

    {{-- ── TABEL PO & INVOICE ── --}}
    <div class="mid-grid">

        {{-- PO Terbaru --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">
                    <i class="fa-solid fa-receipt"></i> Purchase Order Terbaru
                </span>
                <a href="{{ route('purchaseorder.index') }}" class="dash-card-link">Lihat Semua</a>
            </div>
            <div class="table-scroll">
                <table class="mini-table">
                    <thead>
                        <tr>
                            <th>No Order</th>
                            <th>Customer</th>
                            <th>Tgl Order</th>
                            <th>Schedule Delivery</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestPO as $row)
                            @php
                                $status = $row->status_po;
                                $badge  = match($status) {
                                    'Selesai' => 'background:rgba(76,175,131,0.15);color:#4caf83;',
                                    'Proses'  => 'background:rgba(184,115,51,0.15);color:#daa57a;',
                                    default   => 'background:rgba(78,115,223,0.15);color:#79a0ff;',
                                };
                            @endphp
                            <tr>
                                <td>{{ $row->no_order }}</td>
                                <td>{{ $row->kepada_yth ?? '-' }}</td>
                                <td>{{ $row->tgl_order }}</td>
                                <td>{{ $row->schedule_delivery ?? '-' }}</td>
                                <td>
                                    <span style="display:inline-block;padding:3px 10px;border-radius:999px;font-size:11px;font-weight:600;{{ $badge }}">
                                        {{ $status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-dash">Belum ada data purchase order.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Invoice Terbaru --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">
                    <i class="fa-solid fa-file-invoice"></i> Invoice Terbaru
                </span>
                <a href="{{ route('invoice.index') }}" class="dash-card-link">Lihat Semua</a>
            </div>
            <div class="table-scroll">
                <table class="mini-table">
                    <thead>
                        <tr>
                            <th>No Invoice</th>
                            <th>No Order</th>
                            <th>Tgl Invoice</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestInvoice as $row)
                            <tr>
                                <td>{{ $row->no_invoice }}</td>
                                <td>
                                    @if(!empty($row->semua_no_order))
                                        @foreach(explode(', ', $row->semua_no_order) as $no_ord)
                                            <span style="display:inline-block;background:rgba(79,156,249,0.12);color:#4f9cf9;border:1px solid rgba(79,156,249,0.3);border-radius:6px;padding:2px 8px;font-size:0.75rem;margin:2px;font-weight:bold;">
                                                {{ $no_ord }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span style="color:var(--text-muted);font-style:italic;">-</span>
                                    @endif
                                </td>
                                <td>{{ $row->tgl_invoice }}</td>
                                <td class="num-val">Rp {{ number_format($row->total, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-dash">Belum ada data invoice.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ── CHART + QUICK ACCESS ── --}}
    <div class="bot-grid">

        {{-- Chart PO per Bulan --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">
                    <i class="fa-solid fa-chart-bar"></i> Purchase Order per Bulan
                </span>
                <span style="font-size:11px;color:var(--text-muted);">6 bulan terakhir</span>
            </div>
            <div class="chart-wrap">
                @foreach($chartLabels as $i => $lbl)
                    @php
                        $pct    = round(($chartVals[$i] / $chartMax) * 100);
                        $isLast = ($i === array_key_last($chartLabels));
                    @endphp
                    <div class="bar-row">
                        <span class="bar-month">{{ $lbl }}</span>
                        <div class="bar-track">
                            <div class="bar-fill{{ $isLast ? ' last' : '' }}"
                                style="width:0%"
                                data-pct="{{ $pct }}"></div>
                        </div>
                        <span class="bar-val">{{ $chartVals[$i] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Akses Cepat --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">
                    <i class="fa-solid fa-bolt"></i> Akses Cepat
                </span>
            </div>
            <div class="quick-grid">
                <a href="{{ route('purchaseorder.create') }}" class="quick-item">
                    <i class="fa-solid fa-plus-circle" style="color:#3498DB;"></i>
                    <span>Tambah Purchase Order</span>
                </a>
                <a href="{{ route('invoice.create') }}" class="quick-item">
                    <i class="fa-solid fa-file-circle-plus" style="color:#3498DB;"></i>
                    <span>Tambah Invoice</span>
                </a>
                <a href="{{ route('suratjalan.create') }}" class="quick-item">
                    <i class="fa-solid fa-truck-moving" style="color:#3498DB;"></i>
                    <span>Tambah Surat Jalan</span>
                </a>
                <a href="{{ route('customer.create') }}" class="quick-item">
                    <i class="fa-solid fa-user-plus" style="color:#3498DB;"></i>
                    <span>Tambah Customer</span>
                </a>
                <a href="{{ route('barang.create') }}" class="quick-item">
                    <i class="fa-solid fa-box-open" style="color:#3498DB;"></i>
                    <span>Tambah Barang</span>
                </a>
                <a href="{{ route('petugas.create') }}" class="quick-item">
                    <i class="fa-solid fa-user-tie" style="color:#3498DB;"></i>
                    <span>Tambah Petugas</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ── SURAT JALAN TERBARU ── --}}
    <div class="dash-card" style="margin-bottom:24px;">
        <div class="dash-card-header">
            <span class="dash-card-title">
                <i class="fa-solid fa-truck-fast"></i> Surat Jalan Terbaru
            </span>
            <a href="{{ route('suratjalan.index') }}" class="dash-card-link">Lihat Semua</a>
        </div>
        <div class="table-scroll">
            <table class="mini-table">
                <thead>
                    <tr>
                        <th>No Surat</th>
                        <th>No Order</th>
                        <th>Tanggal Surat</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestSuratJalan as $row)
                        <tr>
                            <td>{{ $row->no_surat }}</td>
                            <td>
                                @if(!empty($row->semua_no_order))
                                    @foreach(explode(', ', $row->semua_no_order) as $no_ord)
                                        <span style="display:inline-block;background:rgba(79,156,249,0.12);color:#4f9cf9;border:1px solid rgba(79,156,249,0.3);border-radius:6px;padding:2px 8px;font-size:0.75rem;margin:2px;font-weight:bold;">
                                            {{ $no_ord }}
                                        </span>
                                    @endforeach
                                @else
                                    <span style="color:var(--text-muted);font-style:italic;">-</span>
                                @endif
                            </td>
                            <td>{{ $row->tgl_surat }}</td>
                            <td class="num-val">Rp {{ number_format($row->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-dash">Belum ada data surat jalan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Greeting
    (function () {
        const h = new Date().getHours();
        const g = h < 11 ? 'Selamat Pagi!' : h < 15 ? 'Selamat Siang!' : h < 18 ? 'Selamat Sore!' : 'Selamat Malam!';
        document.getElementById('greetingMsg').textContent = g;
        const d = new Date();
        document.getElementById('greetingDate').innerHTML =
            d.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) +
            '<br><span style="color:var(--text-muted)">' +
            d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB</span>';
    })();

    // Animate chart bars on load
    window.addEventListener('load', function () {
        document.querySelectorAll('.bar-fill').forEach(function (el) {
            el.style.width = el.dataset.pct + '%';
        });
    });
</script>
@endpush
