{{-- resources/views/suratjalan/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Surat Jalan')

@section('content')
<div class="container-fluid">
    <div class="section-header d-flex justify-content-between align-items-center mb-6">
        <div>
            <h2 class="h3 mb-0">Tambah Surat Jalan Baru</h2>
            <p class="text-muted">Daftarkan Surat Jalan baru ke dalam sistem</p>
        </div>
        <a href="{{ route('suratjalan.index') }}" class="btn-back">&larr; Kembali</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row">
        <div class="col-12 col-xl-10">
            <div class="card custom-card">
                <div class="card-header custom-card-header">
                    <h4 class="card-title mb-0">Form Data Surat Jalan</h4>
                    <p class="text-muted small">Isi semua kolom dengan benar.</p>
                </div>

                <form action="{{ route('suratjalan.store') }}" method="POST">
                    @csrf
                    <div class="card-body custom-card-body">
                        <div class="row">

                            {{-- No Surat --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">No Surat</label>
                                <input type="text" name="no_surat" class="custom-input"
                                       value="{{ old('no_surat') }}"
                                       placeholder="Contoh: SJ-XXX" required>
                            </div>

                            {{-- No Invoice --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">No Invoice</label>
                                <select name="no_invoice" class="custom-input" required>
                                    <option value="" disabled selected>Pilih Nomor Invoice</option>
                                    @foreach($invoices as $inv)
                                        <option value="{{ $inv }}" {{ old('no_invoice') == $inv ? 'selected' : '' }}>
                                            {{ $inv }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Petugas Admin --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">Petugas Admin</label>
                                <select name="idpetugas_admin" class="custom-input" required>
                                    <option value="" disabled selected>Pilih Petugas</option>
                                    @foreach($admins as $p)
                                        <option value="{{ $p->idpetugas }}"
                                            {{ old('idpetugas_admin') == $p->idpetugas ? 'selected' : '' }}>
                                            {{ $p->namapetugas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Petugas Warehouse --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">Petugas Warehouse</label>
                                <select name="idpetugas_warehouse" class="custom-input" required>
                                    <option value="" disabled selected>Pilih Petugas</option>
                                    @foreach($warehouses as $p)
                                        <option value="{{ $p->idpetugas }}"
                                            {{ old('idpetugas_warehouse') == $p->idpetugas ? 'selected' : '' }}>
                                            {{ $p->namapetugas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Petugas Driver --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">Petugas Driver</label>
                                <select name="idpetugas_driver" class="custom-input" required>
                                    <option value="" disabled selected>Pilih Petugas</option>
                                    @foreach($drivers as $p)
                                        <option value="{{ $p->idpetugas }}"
                                            {{ old('idpetugas_driver') == $p->idpetugas ? 'selected' : '' }}>
                                            {{ $p->namapetugas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tanggal Surat --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">Tanggal Surat</label>
                                <input type="date" name="tgl_surat" class="custom-input"
                                       value="{{ old('tgl_surat', date('Y-m-d')) }}" required>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer custom-card-footer">
                        <button type="submit" class="btn primary btn-save">Simpan Data Surat Jalan</button>
                        <button type="reset"  class="btn-reset ms-2">Reset Form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
