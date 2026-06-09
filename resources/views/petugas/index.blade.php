@extends('layouts.app')

@section('title', 'Manajemen Petugas')
@section('page-title', 'Manajemen Petugas')
@section('page-subtitle', 'Daftar petugas yang ada di PT Yoko Fastener')

@section('content')
<div class="header">
    <div class="header-left">
        <h2 class="section-title">Manajemen Petugas</h2>
        <p class="section-subtitle">Daftar petugas yang ada di PT Yoko Fastener</p>
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

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:16px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="container-fluid">

        <div class="section-header">
            <a href="{{ route('petugas.create') }}" class="btn-add">+ Tambah Petugas</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="data-table" id="petugasTable">
                        <thead>
                            <tr>
                                <th class="col-id">ID</th>
                                <th class="col-name">Nama Petugas</th>
                                <th class="col-position">Jabatan</th>
                                <th class="col-action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($petugas as $p)
                                <tr>
                                    <td class="cell-id">{{ $p->idpetugas }}</td>
                                    <td class="cell-name">
                                        <div class="user">
                                            <span class="user-name-text">{{ $p->namapetugas }}</span>
                                        </div>
                                    </td>
                                    <td class="cell-position">{{ $p->jabatan }}</td>
                                    <td class="cell-action">
                                        <div class="action-links">
                                            <a href="{{ route('petugas.edit', $p->idpetugas) }}"
                                               class="link-edit">Edit</a>
                                            <span style="color:#ccc;margin:0 5px;">|</span>

                                            {{-- Form DELETE — menggantikan link petugas-hapus.php?idpetugas=... --}}
                                            <form action="{{ route('petugas.destroy', $p->idpetugas) }}"
                                                  method="POST"
                                                  style="display:inline;"
                                                  onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
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
                                    <td colspan="4" class="empty-message">Belum ada data petugas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination Laravel --}}
                    <div class="table-footer">
                        <div class="table-info">
                            Showing {{ $petugas->firstItem() ?? 0 }}
                            to {{ $petugas->lastItem() ?? 0 }}
                            of {{ $petugas->total() }} entries
                        </div>
                        <div class="pagination">
                            @if($petugas->onFirstPage())
                                <span class="btn-pag disabled">&larr; Back</span>
                            @else
                                <a class="btn-pag" href="{{ $petugas->previousPageUrl() }}">&larr; Back</a>
                            @endif

                            @foreach($petugas->getUrlRange(1, $petugas->lastPage()) as $page => $url)
                                @if($page == $petugas->currentPage())
                                    <a class="btn-pag active" href="{{ $url }}">{{ $page }}</a>
                                @else
                                    <a class="btn-pag page-num" href="{{ $url }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if($petugas->hasMorePages())
                                <a class="btn-pag" href="{{ $petugas->nextPageUrl() }}">Next &rarr;</a>
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
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const rows        = document.querySelectorAll('#petugasTable tbody tr');

        if (!searchInput) return;

        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            rows.forEach(function (row) {
                row.style.display = row.textContent.toLowerCase().includes(query) ? '' : 'none';
            });
        });
    });
</script>
@endpush
