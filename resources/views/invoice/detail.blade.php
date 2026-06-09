{{-- resources/views/invoice/detail.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Invoice - ' . $invoice->no_invoice)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/detail-style.css') }}">
<style>
    .order-list-container {
        background: var(--card-bg, rgba(255,255,255,0.03));
        border: 1px solid var(--border-color, rgba(255,255,255,0.08));
        border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem;
    }
    html[data-theme="light"] .order-list-container { background:#fff; border-color:rgba(0,0,0,0.08); }
    .order-items-wrapper { display:flex; flex-direction:column; gap:0.75rem;
        margin-bottom:1.25rem; max-height:250px; overflow-y:auto; padding-right:4px; }
    .order-item-row { display:flex; align-items:center; justify-content:space-between;
        background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.06);
        border-radius:8px; padding:10px 14px; transition:all .2s ease; }
    html[data-theme="light"] .order-item-row { background:#f8fafc; border-color:rgba(0,0,0,0.05); }
    .order-item-row:hover { background:rgba(255,255,255,0.08); border-color:rgba(79,156,249,0.3); }
    .order-item-info { display:flex; align-items:center; gap:10px; }
    .order-item-avatar { width:32px; height:32px; border-radius:50%; background:rgba(79,156,249,0.15);
        color:#4f9cf9; display:flex; align-items:center; justify-content:center;
        font-weight:700; font-size:0.75rem; }
    .order-item-text { font-weight:600; font-size:0.875rem; color:var(--text-primary,#e2e8f0); }
    html[data-theme="light"] .order-item-text { color:#1e293b; }
    .order-item-remove-btn { background:rgba(239,68,68,0.12); color:#ef4444;
        border:1px solid rgba(239,68,68,0.25); width:28px; height:28px; border-radius:50%;
        display:flex; align-items:center; justify-content:center; cursor:pointer;
        transition:all .2s; text-decoration:none; }
    .order-item-remove-btn:hover { background:rgba(239,68,68,0.25); transform:scale(1.1); }
    .order-add-form-group { display:flex; gap:8px; }
    .order-add-select { flex:1; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);
        color:var(--text-primary,#e2e8f0); padding:8px 12px; border-radius:8px; font-size:0.85rem;
        outline:none; }
    html[data-theme="light"] .order-add-select { background:#fff; border-color:rgba(0,0,0,0.15); color:#1e293b; }
    .order-add-select:focus { border-color:#4f9cf9; }
    .order-add-btn { background:#4f9cf9; color:#fff; border:none; border-radius:8px;
        width:38px; height:38px; display:flex; align-items:center; justify-content:center;
        cursor:pointer; font-size:1rem; transition:opacity .2s; }
    .order-add-btn:hover { opacity:0.9; }
    .order-items-wrapper::-webkit-scrollbar { width:4px; }
    .order-items-wrapper::-webkit-scrollbar-track { background:transparent; }
    .order-items-wrapper::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.1); border-radius:4px; }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="section-header d-flex justify-content-between align-items-center mb-6">
        <div>
            <h2 class="h3 mb-0">Detail Invoice</h2>
            <p class="text-muted">No Invoice: <strong>{{ $invoice->no_invoice }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <a href="#" class="btn-print btn-print-trigger"
                data-no-invoice="{{ $invoice->no_invoice }}" style="text-decoration:none;">
                <i class="fa-solid fa-print"></i> Cetak Invoice
            </a>
            <a href="{{ route('invoice.index') }}" class="btn-back" style="text-decoration:none;">&larr; Kembali</a>
        </div>
    </div>

    <div class="row">
        {{-- ── KIRI: Info Invoice + Manage Orders ── --}}
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="card custom-card mb-4">
                <div class="card-header custom-card-header">
                    <h4 class="card-title mb-0">
                        <i class="fa-solid fa-file-invoice me-2" style="color:var(--primary-color,#4f9cf9);"></i>
                        Informasi Invoice
                    </h4>
                </div>
                <div class="card-body custom-card-body" style="padding:1.25rem;">
                    <div class="info-grid" style="grid-template-columns:1fr; gap:0.75rem;">
                        <div class="info-item">
                            <label>No Invoice</label>
                            <div class="info-value">{{ $invoice->no_invoice }}</div>
                        </div>
                        <div class="info-item">
                            <label>Petugas Admin</label>
                            <div class="info-value">{{ $invoice->petugas->namapetugas ?? '-' }}</div>
                        </div>
                        <div class="info-item">
                            <label>Tanggal Invoice</label>
                            <div class="info-value">
                                <i class="fa-regular fa-calendar me-1" style="opacity:0.6;"></i>
                                {{ \Carbon\Carbon::parse($invoice->tgl_invoice)->translatedFormat('d F Y') }}
                            </div>
                        </div>
                        <div class="info-item">
                            <label>Perusahaan (Customer)</label>
                            <div class="info-value" style="white-space:normal; line-height:1.4;">
                                {{ $customerName }}
                            </div>
                        </div>

                        {{-- Daftar No Order yang terhubung --}}
                        <div class="info-item" style="margin-top:0.5rem;">
                            <label style="display:flex; align-items:center; justify-content:space-between;">
                                <span><i class="fa-solid fa-receipt me-1" style="color:#34d399;"></i> Nomor Order</span>
                                <span class="badge-wrn"
                                    style="padding:2px 8px; font-size:0.7rem; background:rgba(52,211,153,0.1);
                                           color:#34d399; border-color:rgba(52,211,153,0.3);">
                                    {{ count($linkedOrders) }} Order
                                </span>
                            </label>
                            <div class="order-items-wrapper" style="max-height:200px; margin-top:0.5rem;">
                                @forelse($linkedOrders as $order_no)
                                    <div class="order-item-row">
                                        <div class="order-item-info">
                                            <div class="order-item-avatar">PO</div>
                                            <div class="order-item-text">{{ $order_no }}</div>
                                        </div>
                                        <form method="POST"
                                            action="{{ route('invoice.detail.removeOrder', $invoice->no_invoice) }}"
                                            onsubmit="return confirm('Hapus nomor order {{ $order_no }} dari invoice ini?')">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="no_order" value="{{ $order_no }}">
                                            <button type="submit" class="order-item-remove-btn" title="Hapus Order">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <div style="font-size:0.8rem; color:var(--text-muted,#8a9bb0); padding:0.5rem 0; font-style:italic;">
                                        <i class="fa-solid fa-link-slash me-1"></i> Belum ada Order terhubung.
                                    </div>
                                @endforelse
                            </div>

                            {{-- Form Tambah Order --}}
                            <form action="{{ route('invoice.detail.addOrder', $invoice->no_invoice) }}" method="POST"
                                class="order-add-form-group" style="margin-top:0.75rem;">
                                @csrf
                                <select name="no_order" class="order-add-select" required>
                                    <option value="" disabled selected>Tambah No Order...</option>
                                    @if($availablePo->isEmpty())
                                        <option value="" disabled>Semua PO sudah terhubung</option>
                                    @else
                                        @foreach($availablePo as $avail)
                                            <option value="{{ $avail->no_order }}">{{ $avail->no_order }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <button type="submit" class="order-add-btn" title="Tambah Order">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </form>
                        </div>

                        {{-- DPP --}}
                        <div class="info-item">
                            <form action="{{ route('invoice.detail.saveDpp', $invoice->no_invoice) }}" method="POST"
                                style="display:flex; flex-direction:column; gap:4px; width:100%;">
                                @csrf
                                <label>DPP NILAI LAIN</label>
                                <div style="display:flex; gap:8px; width:100%;">
                                    <input type="number" name="dpp"
                                        value="{{ $invoice->dpp ?? 0 }}"
                                        class="order-add-select" style="padding:6px 10px; font-size:0.85rem;" required>
                                    <button type="submit" class="order-add-btn"
                                        style="width:38px; height:38px; border-radius:8px;" title="Simpan DPP">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- PPN --}}
                        <div class="info-item">
                            <label>PPN 12% (Otomatis)</label>
                            <div class="info-value" style="font-weight:bold; color:#34d399;">
                                Rp {{ number_format($invoice->ppn, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── KANAN: Summary + Tabel Detail Barang ── --}}
        <div class="col-lg-8 col-md-7">
            {{-- Summary Cards --}}
            <div class="summary-grid-4" style="padding-top:0; margin-bottom:1.5rem;">
                <div class="summary-card">
                    <div class="icon-wrap blue"><i class="fa-solid fa-boxes-stacked"></i></div>
                    <div>
                        <div class="s-label">Jumlah Karung</div>
                        <div class="s-value">{{ number_format($subKrg, 0, ',', '.') }} krg</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="icon-wrap blue"><i class="fa-solid fa-boxes-packing"></i></div>
                    <div>
                        <div class="s-label">Total PCS</div>
                        <div class="s-value">{{ number_format($subPcs, 0, ',', '.') }} pcs</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="icon-wrap green"><i class="fa-solid fa-weight-hanging"></i></div>
                    <div>
                        <div class="s-label">Total KG</div>
                        <div class="s-value">{{ number_format($subKg, 0, ',', '.') }} kg</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="icon-wrap amber"><i class="fa-solid fa-money-bill-wave"></i></div>
                    <div>
                        <div class="s-label">Total Harga</div>
                        <div class="s-value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            {{-- Tabel Detail Barang --}}
            <div class="card custom-card">
                <div class="card-header custom-card-header d-flex justify-content-between align-items-center"
                    style="flex-wrap:wrap; gap:0.75rem;">
                    <div>
                        <h4 class="card-title mb-0">
                            <i class="fa-solid fa-list-check me-2" style="color:var(--primary-color,#4f9cf9);"></i>
                            Tabel Detail Barang
                        </h4>
                        <p class="text-muted small">Daftar barang dari semua order yang terhubung</p>
                    </div>
                </div>

                <div class="card-body custom-card-body" style="padding:0 0 1rem 0;">
                    @if(empty($rows))
                        <div class="empty-state">
                            <i class="fa-solid fa-inbox d-block"></i>
                            <p>Belum ada barang.<br>
                               Gunakan form di samping kiri untuk menghubungkan <strong>No Order</strong> terlebih dahulu.</p>
                        </div>
                    @else
                        <div class="detail-table-wrap">
                            <table class="detail-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Order</th>
                                        <th class="text-left">Ukuran</th>
                                        <th class="text-left">Ukuran Tamu</th>
                                        <th>Warna</th>
                                        <th>PCS/Krg</th>
                                        <th>Jml Krg</th>
                                        <th>Total PCS</th>
                                        <th>KG/Krg</th>
                                        <th>Total KG</th>
                                        <th class="text-right">Harga Satuan</th>
                                        <th class="text-right">Jumlah Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $i => $row)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <span class="badge-wrn"
                                                style="background:rgba(251,191,36,0.08); color:#fbbf24;
                                                       border-color:rgba(251,191,36,0.25); font-size:0.72rem; padding:2px 7px;">
                                                {{ $row->no_order }}
                                            </span>
                                        </td>
                                        <td class="text-left">{{ $row->ukuran }}</td>
                                        <td class="text-left">{{ $row->ukuran_tamu }}</td>
                                        <td><span class="badge-wrn">{{ $row->wrn }}</span></td>
                                        <td>{{ number_format($row->pcs_krg, 0, ',', '.') }}</td>
                                        <td>{{ number_format($row->jmlh_krg, 0, ',', '.') }}</td>
                                        <td><strong>{{ number_format($row->total_pcs, 0, ',', '.') }}</strong></td>
                                        <td>{{ number_format($row->kg_krg, 0, ',', '.') }}</td>
                                        <td><strong>{{ number_format($row->total_kg, 0, ',', '.') }}</strong></td>
                                        <td class="text-right">Rp {{ number_format($row->harga, 0, ',', '.') }}</td>
                                        <td class="text-right">
                                            <strong>Rp {{ number_format($row->jumlah_harga, 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" style="text-align:right; padding-right:1rem;">
                                            <strong>SUB TOTAL</strong>
                                        </td>
                                        <td><strong>{{ number_format($subKrg, 0, ',', '.') }}</strong></td>
                                        <td><strong>{{ number_format($subPcs, 0, ',', '.') }}</strong></td>
                                        <td></td>
                                        <td><strong>{{ number_format($subKg, 0, ',', '.') }}</strong></td>
                                        <td></td>
                                        <td class="text-right">
                                            <strong>Rp {{ number_format($subHarga, 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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
    const triggers  = document.querySelectorAll('.btn-print-trigger');
    const dropdown  = document.getElementById('globalPrintDropdown');
    const cetakBase = '{{ route("invoice.cetak", ":id") }}';

    triggers.forEach(function (trigger) {
        trigger.addEventListener('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            const noInvoice = this.getAttribute('data-no-invoice');
            const base      = cetakBase.replace(':id', encodeURIComponent(noInvoice));

            document.getElementById('printLinkOri').href   = base + '?copy=ori';
            document.getElementById('printLinkCopy1').href = base + '?copy=copy1';
            document.getElementById('printLinkCopy2').href = base + '?copy=copy2';
            document.getElementById('printLinkCopy3').href = base + '?copy=copy3';

            const rect    = this.getBoundingClientRect();
            let leftPos   = rect.left + window.scrollX + rect.width / 2 - 55;
            let topPos    = rect.top  + window.scrollY + rect.height + 6;
            if (rect.bottom + 150 > window.innerHeight) topPos = rect.top + window.scrollY - 156;

            dropdown.style.left    = leftPos + 'px';
            dropdown.style.top     = topPos  + 'px';
            dropdown.style.display = 'block';
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#globalPrintDropdown') && !e.target.closest('.btn-print-trigger')) {
            if (dropdown) dropdown.style.display = 'none';
        }
    });
    window.addEventListener('resize', () => { if (dropdown) dropdown.style.display = 'none'; });
    window.addEventListener('scroll', () => { if (dropdown) dropdown.style.display = 'none'; });
});
</script>
@endpush
