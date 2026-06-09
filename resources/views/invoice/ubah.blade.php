{{-- resources/views/invoice/ubah.blade.php --}}
@extends('layouts.app')

@section('title', 'Ubah Invoice')

@section('content')
<div class="container-fluid">
    <div class="section-header d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="h3 mb-0">Ubah Data Invoice</h2>
            <p class="text-muted">Edit informasi untuk ID: <strong>{{ $invoice->no_invoice }}</strong></p>
        </div>
        <a href="{{ route('invoice.index') }}" class="btn-back" style="text-decoration:none;">&larr; Kembali</a>
    </div>

    @if($errors->any())
        <div class="alert-flash alert-error" style="margin-bottom:1rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="row">
        <div class="col-12 col-xl-10">
            <div class="card custom-card">
                <div class="card-header custom-card-header">
                    <h4 class="card-title mb-0">Edit Invoice</h4>
                </div>

                <form action="{{ route('invoice.update', $invoice->no_invoice) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body custom-card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">No Invoice</label>
                                <input type="text" value="{{ $invoice->no_invoice }}"
                                    class="custom-input" style="opacity:0.6; cursor:not-allowed;" readonly>
                                <small class="text-muted">ID tidak dapat diubah.</small>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">Nama Petugas</label>
                                <select name="idpetugas_admin" class="custom-input" required>
                                    @foreach($petugasList as $petugas)
                                        <option value="{{ $petugas->idpetugas }}"
                                            {{ $invoice->idpetugas_admin == $petugas->idpetugas ? 'selected' : '' }}>
                                            {{ $petugas->namapetugas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">No Order</label>
                                <select name="no_order" class="custom-input" required>
                                    @foreach($poList as $po)
                                        <option value="{{ $po->no_order }}"
                                            {{ $invoice->no_order == $po->no_order ? 'selected' : '' }}>
                                            {{ $po->no_order }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label-custom">Tanggal Invoice</label>
                                <input type="date" name="tgl_invoice"
                                    value="{{ old('tgl_invoice', \Carbon\Carbon::parse($invoice->tgl_invoice)->format('Y-m-d')) }}"
                                    class="custom-input" required>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label-custom">Subtotal</label>
                                <input type="text" name="subtotal"
                                    value="{{ old('subtotal', $invoice->subtotal) }}"
                                    class="custom-input" required>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label-custom">PPN</label>
                                <input type="text" name="ppn"
                                    value="{{ old('ppn', $invoice->ppn) }}"
                                    class="custom-input" required>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label-custom">DPP</label>
                                <input type="text" name="dpp"
                                    value="{{ old('dpp', $invoice->dpp) }}"
                                    class="custom-input" required>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer custom-card-footer">
                        <button type="submit" class="btn primary btn-save">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
