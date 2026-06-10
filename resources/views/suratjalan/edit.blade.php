{{-- resources/views/suratjalan/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Ubah Surat Jalan')

@section('content')
<div class="container-fluid">
    <div class="section-header d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="h3 mb-0">Ubah Data Surat Jalan</h2>
            <p class="text-muted">Edit informasi untuk ID: <strong>{{ $suratJalan->no_surat }}</strong></p>
        </div>
        <a href="{{ route('suratjalan.index') }}" class="btn-back" style="text-decoration:none">&larr; Kembali</a>
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
                    <h4 class="card-title mb-0">Edit Data Surat Jalan</h4>
                </div>

                <form action="{{ route('suratjalan.update', $suratJalan->no_surat) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body custom-card-body">
                        <div class="row">

                            {{-- No Surat (readonly) --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">No Surat</label>
                                <input type="text" class="custom-input"
                                       value="{{ $suratJalan->no_surat }}"
                                       style="opacity:.6; cursor:not-allowed" readonly>
                                <small class="text-muted">ID tidak dapat diubah.</small>
                            </div>

                            {{-- No Invoice --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">No Invoice</label>
                                <select name="no_invoice" class="custom-input" required>
                                    @foreach($invoices as $inv)
                                        <option value="{{ $inv }}"
                                            {{ old('no_invoice', $suratJalan->no_invoice) == $inv ? 'selected' : '' }}>
                                            {{ $inv }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Petugas Admin --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label-custom">Petugas Admin</label>
                                <select name="idpetugas_admin" class="custom-input" required>
                                    @foreach($admins as $p)
                                        <option value="{{ $p->idpetugas }}"
                                            {{ old('idpetugas_admin', $suratJalan->idpetugas_admin) == $p->idpetugas ? 'selected' : '' }}>
                                            {{ $p->namapetugas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Petugas Warehouse --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label-custom">Petugas Warehouse</label>
                                <select name="idpetugas_warehouse" class="custom-input" required>
                                    @foreach($warehouses as $p)
                                        <option value="{{ $p->idpetugas }}"
                                            {{ old('idpetugas_warehouse', $suratJalan->idpetugas_warehouse) == $p->idpetugas ? 'selected' : '' }}>
                                            {{ $p->namapetugas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Petugas Driver --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label-custom">Petugas Driver</label>
                                <select name="idpetugas_driver" class="custom-input" required>
                                    @foreach($drivers as $p)
                                        <option value="{{ $p->idpetugas }}"
                                            {{ old('idpetugas_driver', $suratJalan->idpetugas_driver) == $p->idpetugas ? 'selected' : '' }}>
                                            {{ $p->namapetugas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tanggal Surat --}}
                            <div class="col-md-6 mb-2">
                                <label class="form-label-custom">Tanggal Surat</label>
                                <input type="date" name="tgl_surat" class="custom-input"
                                       value="{{ old('tgl_surat', $suratJalan->tgl_surat?->format('Y-m-d')) }}" required>
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
</div>
@endsection
