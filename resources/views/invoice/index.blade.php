{{-- resources/views/invoice/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Invoice - Lihat')

@section('content')
<div class="header">
    <div class="header-left">
        <h2 class="section-title">Manajemen Invoice</h2>
        <p class="section-subtitle">Daftar invoice yang ada di PT Yoko Fastener</p>
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
        <a href="{{ route('invoice.create') }}" class="btn-add">+ Tambah Invoice</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="col-id">No Invoice</th>
                            <th class="col-name">Nama Petugas</th>
                            <th class="col-order">No Order</th>
                            <th class="col-date">Tanggal Invoice</th>
                            <th class="col-action">Aksi</th>
                            <th class="col-desc">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $data)
                        <tr>
                            <td class="cell-id">{{ $data->no_invoice }}</td>
                            <td class="cell-name">
                                <div class="user">
                                    <span class="user-name-text">{{ $data->namapetugas }}</span>
                                </div>
                            </td>
                            <td class="cell-order">
                                @if(!empty($data->semua_no_order))
                                <div class="order-badges">
                                    @foreach(explode(', ', $data->semua_no_order) as $no_ord)
                                    <span style="background:rgba(79,156,249,0.12); color:#4f9cf9;
                                                border:1px solid rgba(79,156,249,0.3); border-radius:6px;
                                                padding:2px 8px; font-size:0.78rem; font-weight:bold;
                                                white-space:nowrap;">
                                        {{ $no_ord }}
                                    </span>
                                    @endforeach
                                </div>
                                @endif
                            </td>
                            <td class="cell-date">{{ $data->tgl_invoice }}</td>
                            <td class="cell-action">
                                <div class="action-links">
                                    <a href="{{ route('invoice.edit', $data->no_invoice) }}" class="link-edit">Edit</a>
                                    <span style="color:#ccc; margin:0 5px;">|</span>
                                    <form method="POST" action="{{ route('invoice.destroy', $data->no_invoice) }}"
                                        style="display:inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus Invoice ini?')">
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
                                    <a href="{{ route('invoice.detail', $data->no_invoice) }}" class="link-detail">Detail</a>
                                    <span style="color:#ccc; margin:0 5px;">|</span>
                                    <a href="#" class="link-print btn-print-trigger"
                                        data-no-invoice="{{ $data->no_invoice }}">Cetak</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="empty-message" style="text-align:center;">
                                Belum ada data invoice.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination info & links --}}
            <div class="table-footer">
                <div class="table-info">
                    Showing {{ $invoices->firstItem() ?? 0 }} to {{ $invoices->lastItem() ?? 0 }}
                    of {{ $invoices->total() }} entries
                </div>
                <div class="pagination">
                    @if($invoices->onFirstPage())
                    <span class="btn-pag disabled">&larr; Back</span>
                    @else
                    <a class="btn-pag" href="{{ $invoices->previousPageUrl() }}">&larr; Back</a>
                    @endif

                    @foreach($invoices->getUrlRange(max(1, $invoices->currentPage()-1), min($invoices->lastPage(), $invoices->currentPage()+1)) as $page => $url)
                    @if($page == $invoices->currentPage())
                    <a class="btn-pag active" href="{{ $url }}">{{ $page }}</a>
                    @else
                    <a class="btn-pag page-num" href="{{ $url }}">{{ $page }}</a>
                    @endif
                    @endforeach

                    @if($invoices->hasMorePages())
                    <a class="btn-pag" href="{{ $invoices->nextPageUrl() }}">Next &rarr;</a>
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
    <a href="#" id="printLinkOri" target="_blank">Ori</a>
    <a href="#" id="printLinkCopy1" target="_blank">Copy 1</a>
    <a href="#" id="printLinkCopy2" target="_blank">Copy 2</a>
    <a href="#" id="printLinkCopy3" target="_blank">Copy 3</a>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ── Search ──────────────────────────────────────────────────────────────
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('.data-table tbody tr');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const q = this.value.trim().toLowerCase();
                rows.forEach(function(row) {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(q) ? '' : 'none';
                });
            });
        }

        // ── Print Dropdown ───────────────────────────────────────────────────────
        const triggers = document.querySelectorAll('.btn-print-trigger');
        const dropdown = document.getElementById('globalPrintDropdown');
        const printLinkOri = document.getElementById('printLinkOri');
        const printLinkC1 = document.getElementById('printLinkCopy1');
        const printLinkC2 = document.getElementById('printLinkCopy2');
        const printLinkC3 = document.getElementById('printLinkCopy3');
        const cetakBase = '{{ route("invoice.cetak", ":id") }}';

        triggers.forEach(function(trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const noInvoice = this.getAttribute('data-no-invoice');
                const base = cetakBase.replace(':id', encodeURIComponent(noInvoice));

                printLinkOri.href = base + '?copy=ori';
                printLinkC1.href = base + '?copy=copy1';
                printLinkC2.href = base + '?copy=copy2';
                printLinkC3.href = base + '?copy=copy3';

                const rect = this.getBoundingClientRect();
                const dropdownWidth = 110;
                let leftPos = rect.left + window.scrollX + (rect.width / 2) - (dropdownWidth / 2);
                let topPos = rect.top + window.scrollY + rect.height + 6;

                if (rect.bottom + 150 > window.innerHeight) {
                    topPos = rect.top + window.scrollY - 150 - 6;
                }

                dropdown.style.left = leftPos + 'px';
                dropdown.style.top = topPos + 'px';
                dropdown.style.display = 'block';
            });
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('#globalPrintDropdown') && !e.target.closest('.btn-print-trigger')) {
                if (dropdown) dropdown.style.display = 'none';
            }
        });

        window.addEventListener('resize', function() {
            if (dropdown) dropdown.style.display = 'none';
        });
        window.addEventListener('scroll', function() {
            if (dropdown) dropdown.style.display = 'none';
        });
    });
</script>
@endpush