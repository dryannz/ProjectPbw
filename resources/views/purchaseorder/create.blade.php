@extends('layouts.app')

@section('title', 'Tambah Purchase Order')
@section('page-title', 'Tambah Purchase Order Baru')
@section('page-subtitle', 'Daftarkan purchase order baru ke dalam sistem')

@section('content')
<div class="section-header d-flex justify-content-between align-items-center mb-6">
    <div></div>
    <a href="{{ route('purchaseorder.index') }}" class="btn-back">&larr; Kembali</a>
</div>

<div class="row">
    <div class="col-12 col-xl-10">
        <div class="card custom-card">
            <div class="card-header custom-card-header">
                <h4 class="card-title mb-0">Form Data Purchase Order</h4>
                <p class="text-muted small">Isi semua kolom dengan benar.</p>
            </div>

            <form action="{{ route('purchaseorder.store') }}" method="POST">
                @csrf
                <div class="card-body custom-card-body">
                    <div class="row">

                        {{-- No Order --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">No Order <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="no_order" class="custom-input @error('no_order') is-invalid @enderror"
                                   placeholder="Contoh: PO-XXX"
                                   value="{{ old('no_order') }}" required>
                            @error('no_order')
                                <div class="invalid-feedback d-block" style="color:#ef4444;font-size:.8rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Customer --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Nama Perusahaan <span style="color:#ef4444;">*</span></label>
                            <select name="idcustomer" class="custom-input @error('idcustomer') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih Perusahaan</option>
                                @foreach($customers as $c)
                                    <option value="{{ $c->idcustomer }}" {{ old('idcustomer') == $c->idcustomer ? 'selected' : '' }}>
                                        {{ $c->kepada_yth }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idcustomer')
                                <div class="invalid-feedback d-block" style="color:#ef4444;font-size:.8rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Order --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Tanggal Order <span style="color:#ef4444;">*</span></label>
                            <input type="date" name="tgl_order"
                                   value="{{ old('tgl_order', date('Y-m-d')) }}"
                                   class="custom-input @error('tgl_order') is-invalid @enderror" required>
                            @error('tgl_order')
                                <div class="invalid-feedback d-block" style="color:#ef4444;font-size:.8rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Schedule Delivery --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Schedule Delivery <span style="color:#ef4444;">*</span></label>
                            <input type="date" name="schedule_delivery"
                                   value="{{ old('schedule_delivery', date('Y-m-d')) }}"
                                   class="custom-input @error('schedule_delivery') is-invalid @enderror" required>
                            @error('schedule_delivery')
                                <div class="invalid-feedback d-block" style="color:#ef4444;font-size:.8rem;">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card-footer custom-card-footer">
                    <button type="submit" class="btn primary btn-save">Simpan Data Purchase Order</button>
                    <button type="reset" class="btn-reset ms-2">Reset Form</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
