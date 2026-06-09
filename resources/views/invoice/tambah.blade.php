{{-- resources/views/invoice/tambah.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Invoice')

@section('content')
<div class="container-fluid">
    <div class="section-header d-flex justify-content-between align-items-center mb-6">
        <div>
            <h2 class="h3 mb-0">Tambah Invoice Baru</h2>
            <p class="text-muted">Daftarkan Invoice baru ke dalam sistem</p>
        </div>
        <a href="{{ route('invoice.index') }}" class="btn-back">&larr; Kembali</a>
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
                    <h4 class="card-title mb-0">Form Data Invoice</h4>
                    <p class="text-muted small">Isi semua kolom dengan benar.</p>
                </div>

                <form action="{{ route('invoice.store') }}" method="POST">
                    @csrf
                    <div class="card-body custom-card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">No Invoice</label>
                                <input type="text" name="no_invoice" class="custom-input"
                                    placeholder="Contoh: IN-XXX"
                                    value="{{ old('no_invoice') }}" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">Nama Petugas</label>
                                <select name="idpetugas_admin" class="custom-input" required>
                                    <option value="" disabled selected>Pilih Petugas</option>
                                    @foreach($petugasList as $petugas)
                                        <option value="{{ $petugas->idpetugas }}"
                                            {{ old('idpetugas_admin') == $petugas->idpetugas ? 'selected' : '' }}>
                                            {{ $petugas->namapetugas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">No Order</label>
                                <select name="no_order" class="custom-input" required>
                                    <option value="" disabled selected>Pilih Order</option>
                                    @foreach($poList as $po)
                                        <option value="{{ $po->no_order }}"
                                            {{ old('no_order') == $po->no_order ? 'selected' : '' }}>
                                            {{ $po->no_order }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">Tanggal Invoice</label>
                                <input type="date" name="tgl_invoice" class="custom-input"
                                    value="{{ old('tgl_invoice', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer custom-card-footer">
                        <button type="submit" class="btn primary btn-save">
                            Simpan Data Invoice
                        </button>
                        <button type="reset" class="btn-reset ms-2">Reset Form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
