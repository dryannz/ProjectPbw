@extends('layouts.app')

@section('title', 'Tambah Detail PO - ' . $po->no_order)
@section('page-title', 'Tambah Detail Barang')
@section('page-subtitle', 'Purchase Order: ' . $po->no_order)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/detail-style.css') }}">
@endpush

@section('content')
<div class="section-header d-flex justify-content-between align-items-center mb-6">
    <div>
        <h2 class="h3 mb-0">Tambah Detail Barang</h2>
        <p class="text-muted">
            Purchase Order: <strong>{{ $po->no_order }}</strong>
            &mdash; {{ $po->customer->kepada_yth ?? '' }}
        </p>
    </div>
    <a href="{{ route('purchaseorder.detail.index', $po->no_order) }}" class="btn-back">&larr; Kembali</a>
</div>

<div class="row">
    <div class="col-12 col-xl-10">

        <div class="info-banner">
            <i class="fa-solid fa-circle-info"></i>
            <span>Pastikan data yang dimasukkan sudah benar. Harga satuan dapat disesuaikan jika diperlukan.</span>
        </div>

        <div class="card custom-card">
            <div class="card-header custom-card-header">
                <h4 class="card-title mb-0">Form Tambah Detail Barang</h4>
                <p class="text-muted small">Pilih barang, sesuaikan harga jika perlu, lalu isi kuantitas.</p>
            </div>

            <form action="{{ route('purchaseorder.detail.store', $po->no_order) }}" method="POST" id="formTambah">
                @csrf
                <div class="card-body custom-card-body">

                    {{-- ── SECTION 1: Pilih Barang ── --}}
                    <div class="section-label"><i class="fa-solid fa-boxes-packing me-1"></i> Data Barang</div>
                    <div class="row">

                        <div class="col-md-5 mb-4">
                            <label class="form-label-custom">Pilih Barang <span style="color:#ef4444;">*</span></label>
                            <select name="idbarang" id="idbarang" class="custom-input @error('idbarang') is-invalid @enderror"
                                    required onchange="isiDataBarang(this)">
                                <option value="" disabled selected>-- Pilih Barang --</option>
                                @foreach($barangs as $b)
                                    @php
                                        $label = $b->ukuran . ($b->ukuran_tamu ? ' / ' . $b->ukuran_tamu : '');
                                    @endphp
                                    <option value="{{ $b->idbarang }}"
                                            data-harga="{{ $b->harga }}"
                                            data-ukuran="{{ $b->ukuran }}"
                                            data-ukuran-tamu="{{ $b->ukuran_tamu }}"
                                            {{ old('idbarang') == $b->idbarang ? 'selected' : '' }}>
                                        {{ $label }} — Rp {{ number_format($b->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idbarang')
                                <div style="color:#ef4444;font-size:.8rem;">{{ $message }}</div>
                            @enderror
                            <p class="input-hint">Harga satuan default akan terisi otomatis saat barang dipilih.</p>
                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">Warna <span style="color:#ef4444;">*</span></label>
                            <input type="text" class="custom-input @error('wrn') is-invalid @enderror"
                                   name="wrn" value="{{ old('wrn') }}" required placeholder="Contoh: K">
                            @error('wrn')
                                <div style="color:#ef4444;font-size:.8rem;">{{ $message }}</div>
                            @enderror
                            <p class="input-hint">Contoh: K (Kuning), P (Putih).</p>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label-custom">
                                Harga Satuan <span style="color:#ef4444;">*</span>
                                <span style="display:inline-flex;align-items:center;gap:4px;font-size:.68rem;color:#fbbf24;
                                            background:rgba(251,191,36,.1);border:1px solid rgba(251,191,36,.25);
                                            border-radius:20px;padding:2px 7px;margin-left:6px;vertical-align:middle;">
                                    <i class="fa-solid fa-pen" style="font-size:.6rem;"></i> Dapat Disesuaikan
                                </span>
                            </label>
                            <input type="number" name="harga_satuan" id="harga_satuan_input"
                                   class="custom-input" placeholder="Pilih barang dulu"
                                   min="0" step="1" required oninput="hitungOtomatis()"
                                   value="{{ old('harga_satuan') }}">
                            <div class="harga-default-tag" id="harga_default_tag" style="display:none;">
                                <i class="fa-solid fa-database"></i>
                                Harga default: <span id="harga_default_label">—</span>
                                <a href="#" onclick="kembalikanHargaDefault(); return false;"
                                   style="color:#fbbf24;text-decoration:underline;margin-left:4px;">Reset</a>
                            </div>
                        </div>
                    </div>

                    <hr class="section-divider">

                    {{-- ── SECTION 2: Kuantitas ── --}}
                    <div class="section-label"><i class="fa-solid fa-calculator me-1"></i> Kuantitas</div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">Jumlah Karung <span style="color:#ef4444;">*</span></label>
                            <input type="number" name="jmlh_krg" id="jmlh_krg" class="custom-input"
                                   placeholder="0" min="1" required oninput="hitungOtomatis()"
                                   value="{{ old('jmlh_krg') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">PCS / Karung</label>
                            <div class="field-optional-wrap" id="wrap_pcs_krg">
                                <input type="number" name="pcs_krg" id="pcs_krg" class="custom-input"
                                       placeholder="masukkan jumlah pcs" min="0" step="1"
                                       oninput="hitungOtomatis()" value="{{ old('pcs_krg') }}">
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">
                                Total PCS
                                <span class="calc-badge"><i class="fa-solid fa-bolt"></i> Auto</span>
                            </label>
                            <input type="number" name="total_pcs" id="total_pcs" class="custom-input" readonly placeholder="—">
                            <p class="input-hint">= PCS/Krg × Jml Karung</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">
                                KG / Karung
                                <span class="optional-badge"><i class="fa-solid fa-minus" style="font-size:.55rem;"></i> Opsional</span>
                            </label>
                            <div class="field-optional-wrap" id="wrap_kg_krg">
                                <input type="number" name="kg_krg" id="kg_krg" class="custom-input"
                                       placeholder="— kosongkan jika tidak ada —" min="0" step="0.01"
                                       oninput="hitungOtomatis()" value="{{ old('kg_krg') }}">
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="form-label-custom">
                                Total KG
                                <span class="calc-badge"><i class="fa-solid fa-bolt"></i> Auto</span>
                            </label>
                            <input type="number" name="total_kg" id="total_kg" class="custom-input" readonly placeholder="—">
                            <p class="input-hint">= KG/Krg × Jml Karung</p>
                        </div>
                    </div>

                    <hr class="section-divider">
                    <div class="section-label"><i class="fa-solid fa-money-bill-wave me-1"></i> Kalkulasi Harga</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">
                                Jumlah Harga
                                <span class="calc-badge"><i class="fa-solid fa-bolt"></i> Auto</span>
                            </label>
                            <input type="number" name="jumlah_harga" id="jumlah_harga"
                                   class="custom-input" readonly placeholder="0">
                            <p class="input-hint">= Total PCS × Harga Satuan</p>
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <div class="harga-preview w-100">
                                <div>
                                    <div class="preview-label">Total yang akan disimpan</div>
                                    <div class="preview-formula" id="preview_formula">Isi form untuk melihat kalkulasi</div>
                                </div>
                                <div class="preview-value" id="preview_harga">Rp 0</div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer custom-card-footer">
                    <button type="submit" class="btn primary btn-save">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Detail Barang
                    </button>
                    <button type="reset" class="btn-reset ms-2" onclick="resetForm()">Reset Form</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let hargaDefault = 0;

function isiDataBarang(sel) {
    const opt = sel.options[sel.selectedIndex];
    hargaDefault = parseFloat(opt.dataset.harga) || 0;
    document.getElementById('harga_satuan_input').value = hargaDefault;
    document.getElementById('harga_default_tag').style.display = 'flex';
    document.getElementById('harga_default_label').textContent =
        'Rp ' + hargaDefault.toLocaleString('id-ID');
    hitungOtomatis();
}

function kembalikanHargaDefault() {
    document.getElementById('harga_satuan_input').value = hargaDefault;
    hitungOtomatis();
}

function hitungOtomatis() {
    const jmlh_krg = parseFloat(document.getElementById('jmlh_krg').value) || 0;
    const pcs_val  = document.getElementById('pcs_krg').value;
    const kg_val   = document.getElementById('kg_krg').value;
    const pcs_krg  = pcs_val !== '' ? parseFloat(pcs_val) : null;
    const kg_krg   = kg_val  !== '' ? parseFloat(kg_val)  : null;
    const harga    = parseFloat(document.getElementById('harga_satuan_input').value) || 0;

    const total_pcs = pcs_krg !== null ? pcs_krg * jmlh_krg : 0;
    document.getElementById('total_pcs').value       = pcs_krg !== null ? total_pcs : '';
    document.getElementById('total_pcs').placeholder = pcs_krg !== null ? '' : '—';

    const total_kg = kg_krg !== null ? kg_krg * jmlh_krg : 0;
    document.getElementById('total_kg').value       = kg_krg !== null ? total_kg : '';
    document.getElementById('total_kg').placeholder = kg_krg !== null ? '' : '—';

    const jumlah_harga = pcs_krg !== null ? total_pcs * harga : 0;
    document.getElementById('jumlah_harga').value = jumlah_harga;

    document.getElementById('preview_harga').textContent =
        'Rp ' + jumlah_harga.toLocaleString('id-ID');

    const formulaEl = document.getElementById('preview_formula');
    if (pcs_krg !== null && jmlh_krg > 0 && harga > 0) {
        formulaEl.textContent = total_pcs.toLocaleString('id-ID') + ' pcs × Rp ' +
            harga.toLocaleString('id-ID') + ' = Rp ' + jumlah_harga.toLocaleString('id-ID');
    } else if (pcs_krg === null) {
        formulaEl.textContent = 'PCS tidak diisi — jumlah harga = 0';
    } else {
        formulaEl.textContent = 'Lengkapi jumlah karung & harga satuan';
    }

    document.getElementById('wrap_pcs_krg').classList.toggle('is-empty', pcs_val === '');
    document.getElementById('wrap_kg_krg').classList.toggle('is-empty', kg_val === '');
}

function resetForm() {
    hargaDefault = 0;
    document.getElementById('harga_satuan_input').value = '';
    document.getElementById('harga_default_tag').style.display = 'none';
    ['total_pcs','total_kg','jumlah_harga'].forEach(id => {
        document.getElementById(id).value = '';
    });
    document.getElementById('preview_harga').textContent   = 'Rp 0';
    document.getElementById('preview_formula').textContent = 'Isi form untuk melihat kalkulasi';
}
</script>
@endpush
