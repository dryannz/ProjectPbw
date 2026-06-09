@extends('layouts.app')

@section('title', 'Ubah Barang')
@section('page-title', 'Ubah Data Barang')
@section('page-subtitle', 'Edit informasi untuk ID: ' . $barang->idbarang)

@section('content')

    <div class="container-fluid">
        <div class="section-header d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="h3 mb-0">Ubah Data Barang</h2>
                <p class="text-muted">
                    Edit informasi untuk ID: <strong>{{ $barang->idbarang }}</strong>
                </p>
            </div>
            <a href="{{ route('barang.index') }}" class="btn-back" style="text-decoration:none;">
                &larr; Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-xl-10">
                <div class="card custom-card">
                    <div class="card-header custom-card-header">
                        <h4 class="card-title mb-0">Edit Profil Barang</h4>
                    </div>

                    {{-- Tampilkan error validasi --}}
                    @if($errors->any())
                        <div class="alert alert-danger" style="margin:16px 16px 0;">
                            <ul style="margin:0;padding-left:18px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{--
                        Action → route('barang.update', $barang->idbarang)
                        Method spoofing: PUT via @method('PUT')
                    --}}
                    <form action="{{ route('barang.update', $barang->idbarang) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body custom-card-body">
                            <div class="row">

                                {{-- ID Barang: readonly, tidak dikirim ke server --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">ID Barang</label>
                                    <input type="text"
                                           value="{{ $barang->idbarang }}"
                                           class="custom-input"
                                           style="opacity:0.6;cursor:not-allowed;"
                                           readonly>
                                    <small class="text-muted">ID tidak dapat diubah.</small>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">Ukuran</label>
                                    <input type="text"
                                           name="ukuran"
                                           value="{{ old('ukuran', $barang->ukuran) }}"
                                           class="custom-input @error('ukuran') is-invalid @enderror"
                                           required>
                                    @error('ukuran')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="form-label-custom">Ukuran Tamu</label>
                                    <input type="text"
                                           name="ukuran_tamu"
                                           value="{{ old('ukuran_tamu', $barang->ukuran_tamu) }}"
                                           class="custom-input @error('ukuran_tamu') is-invalid @enderror"
                                           required>
                                    @error('ukuran_tamu')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="form-label-custom">Harga Satuan</label>
                                    <input type="number"
                                           name="harga"
                                           value="{{ old('harga', $barang->harga) }}"
                                           class="custom-input @error('harga') is-invalid @enderror"
                                           min="0"
                                           required>
                                    @error('harga')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
