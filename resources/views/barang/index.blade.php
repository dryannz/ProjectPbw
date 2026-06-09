@extends('layouts.app')

@section('title', 'Manajemen Barang')
@section('page-title', 'Manajemen Barang')
@section('page-subtitle', 'Daftar barang yang ada di PT Yoko Fastener')

@section('content')
<div class="header">
    <div class="header-left">
        <h2 class="section-title">Manajemen Barang</h2>
        <p class="section-subtitle">Daftar barang yang ada di PT Yoko Fastener</p>
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

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:16px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="container-fluid">

        {{-- Tombol Tambah --}}
        <div class="section-header">
            <a href="{{ route('barang.create') }}" class="btn-add">+ Tambah Barang</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="data-table" id="barangTable">
                        <thead>
                            <tr>
                                <th class="col-id">ID Barang</th>
                                <th class="col-name">Ukuran</th>
                                <th class="col-position">Ukuran Tamu</th>
                                <th class="col-position">Harga Satuan</th>
                                <th class="col-action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangs as $barang)
                                <tr>
                                    <td class="cell-id">{{ $barang->idbarang }}</td>
                                    <td class="cell-name">
                                        <div class="user">
                                            <span class="user-name-text">{{ $barang->ukuran }}</span>
                                        </div>
                                    </td>
                                    <td class="cell-position">{{ $barang->ukuran_tamu }}</td>
                                    <td class="cell-position">
                                        Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="cell-action">
                                        <div class="action-links">
                                            <a href="{{ route('barang.edit', $barang->idbarang) }}"
                                               class="link-edit">Edit</a>
                                            <span style="color:#ccc;margin:0 5px;">|</span>

                                            {{-- Form DELETE (pengganti link barang-hapus.php?idbarang=...) --}}
                                            <form action="{{ route('barang.destroy', $barang->idbarang) }}"
                                                  method="POST"
                                                  style="display:inline;"
                                                  onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="link-delete"
                                                        style="background:none;border:none;cursor:pointer;padding:0;">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-message">Belum ada data barang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination Laravel (menggantikan logika sliding window manual) --}}
                    <div class="table-footer">
                        <div class="table-info">
                            Showing {{ $barangs->firstItem() ?? 0 }}
                            to {{ $barangs->lastItem() ?? 0 }}
                            of {{ $barangs->total() }} entries
                        </div>
                        <div class="pagination">
                            {{-- Previous --}}
                            @if($barangs->onFirstPage())
                                <span class="btn-pag disabled">&larr; Back</span>
                            @else
                                <a class="btn-pag" href="{{ $barangs->previousPageUrl() }}">&larr; Back</a>
                            @endif

                            {{-- Nomor halaman --}}
                            @foreach($barangs->getUrlRange(1, $barangs->lastPage()) as $page => $url)
                                @if($page == $barangs->currentPage())
                                    <a class="btn-pag active" href="{{ $url }}">{{ $page }}</a>
                                @else
                                    <a class="btn-pag page-num" href="{{ $url }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if($barangs->hasMorePages())
                                <a class="btn-pag" href="{{ $barangs->nextPageUrl() }}">Next &rarr;</a>
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
    // Client-side search (sama seperti di native)
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const rows        = document.querySelectorAll('#barangTable tbody tr');

        if (!searchInput) return;

        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });
</script>
@endpush
