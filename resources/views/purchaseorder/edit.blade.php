@extends('layouts.app')

@section('title', 'Ubah Purchase Order')
@section('page-title', 'Ubah Data Purchase Order')
@section('page-subtitle', 'Edit informasi untuk No Order: ' . $po->no_order)

@section('content')
<div class="section-header d-flex justify-content-between align-items-center mb-5">
    <div></div>
    <a href="{{ route('purchaseorder.index') }}" class="btn-back">&larr; Kembali</a>
</div>

<div class="row">
    <div class="col-12 col-xl-10">
        <div class="card custom-card">
            <div class="card-header custom-card-header">
                <h4 class="card-title mb-0">Edit Purchase Order</h4>
            </div>

            <form action="{{ route('purchaseorder.update', $po->no_order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body custom-card-body">
                    <div class="row">

                        {{-- No Order (readonly) --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">No Order</label>
                            <input type="text" value="{{ $po->no_order }}"
                                   class="custom-input" style="opacity:0.6;cursor:not-allowed;" readonly>
                            <small class="text-muted">ID tidak dapat diubah.</small>
                        </div>

                        {{-- Customer --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Nama Perusahaan <span style="color:#ef4444;">*</span></label>
                            <select name="idcustomer" class="custom-input @error('idcustomer') is-invalid @enderror" required>
                                @foreach($customers as $c)
                                    <option value="{{ $c->idcustomer }}"
                                        {{ old('idcustomer', $po->idcustomer) == $c->idcustomer ? 'selected' : '' }}>
                                        {{ $c->kepada_yth }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idcustomer')
                                <div class="invalid-feedback d-block" style="color:#ef4444;font-size:.8rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Order --}}
                        <div class="col-md-12 mb-2">
                            <label class="form-label-custom">Tanggal Order <span style="color:#ef4444;">*</span></label>
                            <input type="date" name="tgl_order"
                                   value="{{ old('tgl_order', $po->tgl_order->format('Y-m-d')) }}"
                                   class="custom-input @error('tgl_order') is-invalid @enderror" required>
                            @error('tgl_order')
                                <div class="invalid-feedback d-block" style="color:#ef4444;font-size:.8rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Schedule Delivery --}}
                        <div class="col-md-12 mb-2">
                            <label class="form-label-custom">Schedule Delivery <span style="color:#ef4444;">*</span></label>
                            <input type="date" name="schedule_delivery"
                                   value="{{ old('schedule_delivery', $po->schedule_delivery->format('Y-m-d')) }}"
                                   class="custom-input @error('schedule_delivery') is-invalid @enderror" required>
                            @error('schedule_delivery')
                                <div class="invalid-feedback d-block" style="color:#ef4444;font-size:.8rem;">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card-footer custom-card-footer">
                    <button type="submit" class="btn primary btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
