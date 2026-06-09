@extends('layouts.app')

@section('title', 'Detail PO - ' . $po->no_order)
@section('page-title', 'Detail Purchase Order')
@section('page-subtitle', 'No Order: ' . $po->no_order)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/detail-style.css') }}">
@endpush

@section('content')
<div class="section-header d-flex justify-content-between align-items-center mb-6">
    <div>
        <h2 class="h3 mb-0">Detail Purchase Order</h2>
        <p class="text-muted">No Order: <strong>{{ $po->no_order }}</strong></p>
    </div>
    <a href="{{ route('purchaseorder.index') }}" class="btn-back">&larr; Kembali</a>
</div>

{{-- ── CARD: INFO PO ── --}}
<div class="card custom-card mb-4">
    <div class="card-header custom-card-header">
        <h4 class="card-title mb-0">
            <i class="fa-solid fa-receipt me-2" style="color:var(--primary-color,#4f9cf9);"></i>
            Informasi Purchase Order
        </h4>
        <p class="text-muted small">Data header purchase order</p>
    </div>
    <div class="card-body custom-card-body">
        <div class="info-grid">
            <div class="info-item">
                <label>No Order</label>
                <div class="info-value">{{ $po->no_order }}</div>
            </div>
            <div class="info-item">
                <label>Nama Perusahaan (Customer)</label>
                <div class="info-value">{{ $po->customer->kepada_yth ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>Tanggal Order</label>
                <div class="info-value">
                    <i class="fa-regular fa-calendar me-1" style="opacity:.6;"></i>
                    {{ $po->tgl_order->translatedFormat('d F Y') }}
                </div>
            </div>
            <div class="info-item">
                <label>Schedule Delivery</label>
                <div class="info-value">
                    <i class="fa-solid fa-truck-fast me-1" style="opacity:.6;"></i>
                    {{ $po->schedule_delivery->translatedFormat('d F Y') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── SUMMARY CARDS ── --}}
<div class="summary-grid">
    <div class="summary-card">
        <div class="icon-wrap blue"><i class="fa-solid fa-boxes-packing"></i></div>
        <div>
            <div class="s-label">Total PCS</div>
            <div class="s-value">{{ number_format($grandTotalPcs, 0, ',', '.') }} pcs</div>
        </div>
    </div>
    <div class="summary-card">
        <div class="icon-wrap green"><i class="fa-solid fa-weight-hanging"></i></div>
        <div>
            <div class="s-label">Total KG</div>
            <div class="s-value">{{ number_format($grandTotalKg, 0, ',', '.') }} kg</div>
        </div>
    </div>
    <div class="summary-card">
        <div class="icon-wrap amber"><i class="fa-solid fa-money-bill-wave"></i></div>
        <div>
            <div class="s-label">Total Harga</div>
            <div class="s-value">Rp {{ number_format($grandTotalHarga, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

{{-- ── CARD: TABEL DETAIL ── --}}
<div class="card custom-card">
    <div class="card-header custom-card-header d-flex justify-content-between align-items-center" style="flex-wrap:wrap;gap:.75rem;">
        <div>
            <h4 class="card-title mb-0">
                <i class="fa-solid fa-list-check me-2" style="color:var(--primary-color,#4f9cf9);"></i>
                Tabel Detail Barang
            </h4>
            <p class="text-muted small">Daftar barang dalam purchase order ini</p>
        </div>
        <div class="action-bar" style="margin-bottom:0;">
            <a href="{{ route('purchaseorder.detail.create', $po->no_order) }}" class="btn-add">
                <i class="fa-solid fa-plus"></i> Tambah Barang
            </a>
        </div>
    </div>

    <div class="card-body custom-card-body" style="padding:0 0 1rem 0;">
        @if($details->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-inbox d-block"></i>
                <p>Belum ada barang dalam purchase order ini.<br>
                   Klik <strong>Tambah Barang</strong> untuk menambahkan.</p>
            </div>
        @else
            <div class="detail-table-wrap">
                <table class="detail-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="text-left">Ukuran</th>
                            <th class="text-left">Ukuran Tamu</th>
                            <th>Warna</th>
                            <th>PCS/Krg</th>
                            <th>Jml Krg</th>
                            <th>Total PCS</th>
                            <th>KG/Krg</th>
                            <th>Total KG</th>
                            <th class="text-right">Jumlah Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($details as $i => $d)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="text-left">{{ $d->barang->ukuran ?? '-' }}</td>
                            <td class="text-left">{{ $d->barang->ukuran_tamu ?? '-' }}</td>
                            <td><span class="badge-wrn">{{ $d->wrn }}</span></td>
                            <td>{{ number_format($d->pcs_krg, 0, ',', '.') }}</td>
                            <td>{{ number_format($d->jmlh_krg, 0, ',', '.') }}</td>
                            <td><strong>{{ number_format($d->total_pcs, 0, ',', '.') }}</strong></td>
                            <td>{{ number_format($d->kg_krg, 0, ',', '.') }}</td>
                            <td><strong>{{ number_format($d->total_kg, 0, ',', '.') }}</strong></td>
                            <td class="text-right">
                                <strong>Rp {{ number_format($d->jumlah_harga, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                <a class="btn-tbl-edit"
                                   href="{{ route('purchaseorder.detail.edit', [$po->no_order, $d->idbarang]) }}">
                                    <i class="fa-solid fa-pen"></i> Ubah
                                </a>
                                <form action="{{ route('purchaseorder.detail.destroy', [$po->no_order, $d->idbarang]) }}"
                                      method="POST" style="display:inline;"
                                      onsubmit="return confirm('Yakin hapus barang {{ $d->barang->ukuran ?? '' }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-tbl-del" style="background:none;border:none;cursor:pointer;">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="text-align:right;padding-right:1rem;">
                                <strong>GRAND TOTAL</strong>
                            </td>
                            <td><strong>{{ number_format($grandTotalPcs, 0, ',', '.') }}</strong></td>
                            <td></td>
                            <td><strong>{{ number_format($grandTotalKg, 0, ',', '.') }}</strong></td>
                            <td class="text-right">
                                <strong>Rp {{ number_format($grandTotalHarga, 0, ',', '.') }}</strong>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
