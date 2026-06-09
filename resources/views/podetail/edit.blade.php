@extends('layouts.app')

@section('title', 'Ubah Detail PO - ' . $po->no_order)
@section('page-title', 'Ubah Detail Barang')
@section('page-subtitle', 'Purchase Order: ' . $po->no_order)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/detail-style.css') }}">
@endpush

@section('content')
<div class="section-header d-flex justify-content-between align-items-center mb-6">
    <div>
        <h2 class="h3 mb-0">Ubah Detail Barang</h2>
        <p class="text-muted">
            Purchase Order: <strong>{{ $po->no_order }}</strong>
            &mdash; {{ $po->customer->kepada_yth ?? '' }}
        </p>
    </div>
    <a href="{{ route('purchaseorder.detail.index', $po->no_order) }}" class="btn-back">&larr; Kembali</a>
</div>

<div class="row">
    <div class="col-12 col-xl-10">

        <div class="info-banner-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>
                Anda sedang mengubah data barang <strong>{{ $detail->barang->ukuran ?? '' }}</strong>.
                ID Barang tidak dapat diubah. Perubahan akan menghitung ulang Total PCS, Total KG, dan Jumlah Harga.
            </span>
        </div>

        <div class="card custom-card">
            <div class="card-header custom-card-header">
                <h4 class="card-title mb-0">Form Ubah Detail Barang</h4>
                <p class="text-muted small">Ubah data yang diperlukan, lalu simpan.</p>
            </div>

            <form action="{{ route('purchaseorder.detail.update', [$po->no_order, $detail->idbarang]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body custom-card-body">

                    {{-- Info Barang (readonly) --}}
                    <div class="section-label"><i class="fa-solid fa-boxes-packing me-1"></i> Info Barang (Tidak Dapat Diubah)</div>
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">ID Barang</label>
                            <div class="field-locked">
                                <input type="text" class="custom-input" value="{{ $detail->idbarang }}" readonly>
                                <span class="lock-icon"><i class="fa-solid fa-lock"></i></span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label-custom">Ukuran</label>
                            <div class="field-locked">
                                <input type="text" class="custom-input" value="{{ $detail->barang->ukuran ?? '-' }}" readonly>
                                <span class="lock-icon"><i class="fa-solid fa-lock"></i></span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label-custom">Ukuran Tamu</label>
                            <div class="field-locked">
                                <input type="text" class="custom-input" value="{{ $detail->barang->ukuran_tamu ?? '-' }}" readonly>
                                <span class="lock-icon"><i class="fa-solid fa-lock"></i></span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">Harga Satuan</label>
                            <div class="field-locked">
                                <input type="text" class="custom-input"
                                       value="Rp {{ number_format($detail->barang->harga ?? 0, 0, ',', '.') }}" readonly>
                                <span class="lock-icon"><i class="fa-solid fa-lock"></i></span>
                            </div>
                            <input type="hidden" id="harga_satuan" value="{{ $detail->barang->harga ?? 0 }}">
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">Warna <span style="color:#ef4444;">*</span></label>
                            <input type="text" class="custom-input @error('wrn') is-invalid @enderror"
                                   name="wrn" value="{{ old('wrn', $detail->wrn) }}" required placeholder="Contoh: K">
                            @error('wrn')
                                <div style="color:#ef4444;font-size:.8rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="section-divider">

                    {{-- Kuantitas (editable) --}}
                    <div class="section-label"><i class="fa-solid fa-calculator me-1"></i> Kuantitas</div>
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">PCS / Karung <span style="color:#ef4444;">*</span></label>
                            <input type="number" name="pcs_krg" id="pcs_krg" class="custom-input"
                                   value="{{ old('pcs_krg', $detail->pcs_krg) }}"
                                   min="1" required oninput="hitungOtomatis()">
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">Jumlah Karung <span style="color:#ef4444;">*</span></label>
                            <input type="number" name="jmlh_krg" id="jmlh_krg" class="custom-input"
                                   value="{{ old('jmlh_krg', $detail->jmlh_krg) }}"
                                   min="1" required oninput="hitungOtomatis()">
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">
                                Total PCS
                                <span class="calc-badge"><i class="fa-solid fa-bolt"></i> Auto</span>
                            </label>
                            <input type="number" name="total_pcs" id="total_pcs" class="custom-input"
                                   value="{{ $detail->total_pcs }}" readonly>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">KG / Karung <span style="color:#ef4444;">*</span></label>
                            <input type="number" name="kg_krg" id="kg_krg" class="custom-input"
                                   value="{{ old('kg_krg', $detail->kg_krg) }}"
                                   min="0" step="0.01" required oninput="hitungOtomatis()">
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">
                                Total KG
                                <span class="calc-badge"><i class="fa-solid fa-bolt"></i> Auto</span>
                            </label>
                            <input type="number" name="total_kg" id="total_kg" class="custom-input"
                                   value="{{ $detail->total_kg }}" readonly>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">
                                Jumlah Harga
                                <span class="calc-badge"><i class="fa-solid fa-bolt"></i> Auto</span>
                            </label>
                            <input type="number" name="jumlah_harga" id="jumlah_harga" class="custom-input"
                                   value="{{ $detail->jumlah_harga }}" readonly>
                            <p class="input-hint">= Total PCS &times; Harga Satuan</p>
                        </div>
                    </div>

                </div>

                <div class="card-footer custom-card-footer">
                    <button type="submit" class="btn-update">
                        <i class="fa-solid fa-pen-to-square"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('purchaseorder.detail.index', $po->no_order) }}" class="btn-reset ms-2">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function hitungOtomatis() {
    const pcs_krg  = parseFloat(document.getElementById('pcs_krg').value)  || 0;
    const jmlh_krg = parseFloat(document.getElementById('jmlh_krg').value) || 0;
    const kg_krg   = parseFloat(document.getElementById('kg_krg').value)   || 0;
    const harga    = parseFloat(document.getElementById('harga_satuan').value) || 0;

    const total_pcs    = pcs_krg * jmlh_krg;
    const total_kg     = kg_krg  * jmlh_krg;
    const jumlah_harga = total_pcs * harga;

    document.getElementById('total_pcs').value    = total_pcs;
    document.getElementById('total_kg').value     = total_kg;
    document.getElementById('jumlah_harga').value = jumlah_harga;
}
</script>
@endpush
