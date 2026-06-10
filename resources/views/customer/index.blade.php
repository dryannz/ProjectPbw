@extends('layouts.app')
@section('title', 'Manajemen Customer')

@section('content')
<div class="header">
    <div class="header-left">
        <h2 class="section-title">Manajemen Customer</h2>
        <p class="section-subtitle">Daftar customer yang ada di PT Yoko Fastener</p>
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
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="section-header">
        <a href="{{ route('customer.create') }}" class="btn-add">+ Tambah Customer</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="col-id">ID</th>
                            <th class="col-name">Nama Customer</th>
                            <th class="col-position">Alamat</th>
                            <th class="col-action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer as $c)
                        <tr>
                            <td class="cell-id">{{ $c->idcustomer }}</td>
                            <td class="cell-name">
                                <div class="user">
                                    <span class="user-name-text">{{ $c->kepada_yth }}</span>
                                </div>
                            </td>
                            <td class="cell-position">{{ $c->alamat }}</td>
                            <td class="cell-action">
                                <div class="action-links">
                                    <a href="{{ route('customer.edit', $c->idcustomer) }}" class="link-edit">Edit</a>
                                    <form action="{{ route('customer.destroy', $c->idcustomer) }}" method="POST"
                                          style="display:inline"
                                          onsubmit="return confirm('Yakin ingin menghapus customer ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <span style="color:#ccc; margin:0 5px;">|</span>
                                        <button type="submit" class="link-delete"
                                                style="background:none; border:none; cursor:pointer; font-weight:600; color:#e74a3b;">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="empty-message">Belum ada data customer.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination Laravel --}}
                    <div class="table-footer">
                        <div class="table-info">
                            Showing {{ $customer->firstItem() ?? 0 }}
                            to {{ $customer->lastItem() ?? 0 }}
                            of {{ $customer->total() }} entries
                        </div>
                        <div class="pagination">
                            @if($customer->onFirstPage())
                                <span class="btn-pag disabled">&larr; Back</span>
                            @else
                                <a class="btn-pag" href="{{ $customer->previousPageUrl() }}">&larr; Back</a>
                            @endif

                            @foreach($customer->getUrlRange(1, $customer->lastPage()) as $page => $url)
                                @if($page == $customer->currentPage())
                                    <a class="btn-pag active" href="{{ $url }}">{{ $page }}</a>
                                @else
                                    <a class="btn-pag page-num" href="{{ $url }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if($customer->hasMorePages())
                                <a class="btn-pag" href="{{ $customer->nextPageUrl() }}">Next &rarr;</a>
                            @else
                                <span class="btn-pag disabled">Next &rarr;</span>
                            @endif
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('searchInput');
        var rows = document.querySelectorAll('.data-table tbody tr');
        searchInput.addEventListener('input', function() {
            var q = this.value.trim().toLowerCase();
            rows.forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    });
</script>
@endpush
@endsection