@extends('layouts.app')

@section('title', 'Purchase Order')
@section('page-title', 'Manajemen Daftar Purchase Order')
@section('page-subtitle', 'Daftar purchase order yang ada di PT Yoko Fastener')

@section('content')
<div class="header">
    <div class="header-left">
        <h2 class="section-title">Manajemen Purchase Order</h2>
        <p class="section-subtitle">Daftar purchase order yang ada di PT Yoko Fastener</p>
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
    <div class="section-header">
        <a href="{{ route('purchaseorder.create') }}" class="btn-add">
            + Tambah Purchase Order
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="col-id">No Order</th>
                            <th class="col-name">Nama Perusahaan</th>
                            <th class="col-date">Tanggal Order</th>
                            <th class="col-date">Schedule Delivery</th>
                            <th class="col-action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchaseOrders as $po)
                        <tr>
                            <td class="cell-id">{{ $po->no_order }}</td>
                            <td class="cell-name">
                                <div class="user">
                                    <span class="user-name-text">{{ $po->customer->kepada_yth ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="cell-date">{{ $po->tgl_order->format('d-m-Y') }}</td>
                            <td class="cell-date">{{ $po->schedule_delivery->format('d-m-Y') }}</td>
                            <td class="cell-action">
                                <div class="action-links">
                                    <a href="{{ route('purchaseorder.edit', $po->no_order) }}" class="link-edit">Edit</a>
                                    <span style="color:#ccc;margin:0 5px;">|</span>
                                    <a href="{{ route('purchaseorder.detail.index', $po->no_order) }}" class="link-detail">Detail</a>
                                    <span style="color:#ccc;margin:0 5px;">|</span>
                                    <form action="{{ route('purchaseorder.destroy', $po->no_order) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus Purchase Order ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="link-delete" style="background:none;border:none;cursor:pointer;padding:0;">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-message">Belum ada data purchase order.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="table-footer">
                    <div class="table-info">
                        Showing {{ $purchaseOrders->firstItem() ?? 0 }}
                        to {{ $purchaseOrders->lastItem() ?? 0 }}
                        of {{ $purchaseOrders->total() }} entries
                    </div>
                    <div class="pagination">
                        @if($purchaseOrders->onFirstPage())
                        <span class="btn-pag disabled">&larr; Back</span>
                        @else
                        <a class="btn-pag" href="{{ $purchaseOrders->previousPageUrl() }}">&larr; Back</a>
                        @endif

                        @foreach($purchaseOrders->getUrlRange(1, $purchaseOrders->lastPage()) as $page => $url)
                        @if($page == $purchaseOrders->currentPage())
                        <a class="btn-pag active" href="{{ $url }}">{{ $page }}</a>
                        @else
                        <a class="btn-pag page-num" href="{{ $url }}">{{ $page }}</a>
                        @endif
                        @endforeach

                        @if($purchaseOrders->hasMorePages())
                        <a class="btn-pag" href="{{ $purchaseOrders->nextPageUrl() }}">Next &rarr;</a>
                        @else
                        <span class="btn-pag disabled">Next &rarr;</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const table = document.querySelector('.data-table');
        const rows = table ? table.querySelectorAll('tbody tr') : [];
        if (!searchInput || !table) return;

        searchInput.addEventListener('input', function() {
            const q = this.value.trim().toLowerCase();
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        });
    });
</script>
@endpush