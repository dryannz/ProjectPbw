{{-- resources/views/suratjalan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Surat Jalan')

@php
    $isHrd = str_contains(strtolower(trim(auth()->user()->jabatan ?? '')), 'hrd');
@endphp

@section('content')
<div class="header">
    <div class="header-left">
        <h2 class="section-title">Manajemen Surat Jalan</h2>
        <p class="section-subtitle">Daftar surat jalan yang ada di PT Yoko Fastener</p>
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

<div class="container-fluid">

    {{-- Tombol Tambah: disembunyikan untuk HRD --}}
    @if(!$isHrd)
    <div class="section-header">
        <a href="{{ route('suratjalan.create') }}" class="btn-add">+ Tambah Surat Jalan</a>
    </div>
    @endif

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="col-id">No Surat</th>
                            <th class="col-order">No Invoice</th>
                            <th class="col-order">No Order</th>
                            <th class="col-position">Petugas Admin</th>
                            <th class="col-position">Petugas Warehouse</th>
                            <th class="col-position">Petugas Driver</th>
                            <th class="col-date">Tanggal Surat</th>
                            {{-- Kolom Aksi (Edit+Hapus): hanya non-HRD --}}
                            @if(!$isHrd)
                            <th class="col-action">Aksi</th>
                            {{-- Kolom Keterangan (Detail+Cetak): hanya non-HRD --}}
                            <th class="col-desc">Keterangan</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suratJalans as $sj)
                            <tr>
                                <td class="cell-id">{{ $sj->no_surat }}</td>

                                {{-- Badge No Invoice --}}
                                <td class="cell-order">
                                    @if($sj->semua_no_invoice)
                                        <div class="order-badges">
                                            @foreach(explode(', ', $sj->semua_no_invoice) as $inv)
                                                <span style="background:rgba(79,156,249,0.12); color:#4f9cf9;
                                                             border:1px solid rgba(79,156,249,0.3); border-radius:6px;
                                                             padding:2px 8px; font-size:.78rem; font-weight:bold;
                                                             display:inline-block; margin:2px;">
                                                    {{ $inv }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span style="color:#888">-</span>
                                    @endif
                                </td>

                                {{-- Badge No Order --}}
                                <td class="cell-order">
                                    @if($sj->semua_no_order)
                                        <div class="order-badges">
                                            @foreach(explode(', ', $sj->semua_no_order) as $ord)
                                                <span style="background:rgba(120,200,120,0.12); color:#6fcf6f;
                                                             border:1px solid rgba(120,200,120,0.3); border-radius:6px;
                                                             padding:2px 8px; font-size:.78rem; font-weight:bold;
                                                             display:inline-block; margin:2px;">
                                                    {{ $ord }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span style="color:#888">-</span>
                                    @endif
                                </td>

                                <td class="cell-position">{{ $sj->nama_admin    ?? '-' }}</td>
                                <td class="cell-position">{{ $sj->nama_warehouse ?? '-' }}</td>
                                <td class="cell-position">{{ $sj->nama_driver   ?? '-' }}</td>
                                <td class="cell-date">{{ $sj->tgl_surat?->format('Y-m-d') }}</td>

                                {{-- Aksi & Keterangan: hanya non-HRD --}}
                                @if(!$isHrd)
                                <td class="cell-action">
                                    <div class="action-links">
                                        <a href="{{ route('suratjalan.edit', $sj->no_surat) }}" class="link-edit">Edit</a>
                                        <span style="color:#ccc; margin:0 5px">|</span>
                                        <form action="{{ route('suratjalan.destroy', $sj->no_surat) }}"
                                              method="POST" style="display:inline"
                                              onsubmit="return confirm('Yakin ingin menghapus surat jalan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="link-delete"
                                                    style="background:none; border:none; cursor:pointer; padding:0; font-size:inherit; font-family:inherit; color:#c20404ff;">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="cell-desc">
                                    <div class="desc-links">
                                        <a href="{{ route('suratjalan.detail', $sj->no_surat) }}" class="link-detail">Detail</a>
                                        <span style="color:#ccc; margin:0 5px">|</span>
                                        <a href="#" class="link-print btn-print-trigger"
                                           data-no-surat="{{ $sj->no_surat }}">Cetak</a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isHrd ? 7 : 9 }}" class="empty-message" style="text-align:center">
                                    Belum ada data surat jalan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div class="table-info">
                    Showing {{ $suratJalans->firstItem() ?? 0 }}
                    to {{ $suratJalans->lastItem() ?? 0 }}
                    of {{ $suratJalans->total() }} entries
                </div>
                <div class="pagination">
                    @if($suratJalans->onFirstPage())
                    <span class="btn-pag disabled">&larr; Back</span>
                    @else
                    <a class="btn-pag" href="{{ $suratJalans->previousPageUrl() }}">&larr; Back</a>
                    @endif

                    @foreach($suratJalans->getUrlRange(max(1, $suratJalans->currentPage()-1), min($suratJalans->lastPage(), $suratJalans->currentPage()+1)) as $page => $url)
                    @if($page == $suratJalans->currentPage())
                    <a class="btn-pag active" href="{{ $url }}">{{ $page }}</a>
                    @else
                    <a class="btn-pag page-num" href="{{ $url }}">{{ $page }}</a>
                    @endif
                    @endforeach

                    @if($suratJalans->hasMorePages())
                    <a class="btn-pag" href="{{ $suratJalans->nextPageUrl() }}">Next &rarr;</a>
                    @else
                    <span class="btn-pag disabled">Next &rarr;</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Global Print Dropdown --}}
<div id="globalPrintDropdown" class="print-dropdown-menu-global" style="display:none; position:absolute; z-index:9999;">
    <a href="#" id="printLinkOri"   target="_blank">Ori</a>
    <a href="#" id="printLinkCopy1" target="_blank">Copy 1</a>
    <a href="#" id="printLinkCopy2" target="_blank">Copy 2</a>
    <a href="#" id="printLinkCopy3" target="_blank">Copy 3</a>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Search filter ---
    const searchInput = document.getElementById('searchInput');
    const rows        = document.querySelectorAll('.data-table tbody tr');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            rows.forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }

    // --- Print dropdown ---
    const dropdown    = document.getElementById('globalPrintDropdown');
    const printBase   = '{{ url("suratjalan") }}/';
    const cetakSuffix = '/cetak';

    document.querySelectorAll('.btn-print-trigger').forEach(trigger => {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const no = encodeURIComponent(this.dataset.noSurat);
            document.getElementById('printLinkOri').href   = printBase + no + cetakSuffix + '?copy=ori';
            document.getElementById('printLinkCopy1').href = printBase + no + cetakSuffix + '?copy=copy1';
            document.getElementById('printLinkCopy2').href = printBase + no + cetakSuffix + '?copy=copy2';
            document.getElementById('printLinkCopy3').href = printBase + no + cetakSuffix + '?copy=copy3';

            const rect = this.getBoundingClientRect();
            const left = rect.left + window.scrollX + rect.width / 2 - 50;
            const top  = rect.top  + window.scrollY + rect.height + 6;
            dropdown.style.left    = left + 'px';
            dropdown.style.top     = top  + 'px';
            dropdown.style.display = 'block';
        });
    });

    document.addEventListener('click', e => {
        if (!e.target.closest('#globalPrintDropdown') && !e.target.closest('.btn-print-trigger')) {
            dropdown.style.display = 'none';
        }
    });
    window.addEventListener('resize', () => dropdown.style.display = 'none');
    window.addEventListener('scroll', () => dropdown.style.display = 'none');
});
</script>
@endpush