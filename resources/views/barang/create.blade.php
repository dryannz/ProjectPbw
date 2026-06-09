@extends('layouts.app')

@section('title', 'Tambah Barang')
@section('page-title', 'Tambah Barang Baru')
@section('page-subtitle', 'Daftarkan barang baru ke dalam sistem')

@section('content')

    <div class="container-fluid">
        <div class="section-header d-flex justify-content-between align-items-center mb-6">
            <div>
                <h2 class="h3 mb-0">Tambah Barang Baru</h2>
                <p class="text-muted">Daftarkan barang baru ke dalam sistem</p>
            </div>
            <a href="{{ route('barang.index') }}" class="btn-back">&larr; Kembali</a>
        </div>

        <div class="row">
            <div class="col-12 col-xl-10">
                <div class="card custom-card">
                    <div class="card-header custom-card-header">
                        <h4 class="card-title mb-0">Form Data Barang</h4>
                        <p class="text-muted small">Isi semua kolom dengan benar.</p>
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

                    {{-- Action → route('barang.store'), method POST --}}
                    <form action="{{ route('barang.store') }}" method="POST">
                        @csrf

                        <div class="card-body custom-card-body">
                            <div class="row">

                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">ID Barang</label>
                                    <input type="text"
                                           name="idbarang"
                                           value="{{ old('idbarang') }}"
                                           class="custom-input @error('idbarang') is-invalid @enderror"
                                           placeholder="Contoh: BR-XXX"
                                           required>
                                    @error('idbarang')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">Ukuran</label>
                                    <input type="text"
                                           name="ukuran"
                                           value="{{ old('ukuran') }}"
                                           class="custom-input @error('ukuran') is-invalid @enderror"
                                           placeholder="Masukkan ukuran..."
                                           required>
                                    @error('ukuran')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="form-label-custom">Ukuran Tamu</label>
                                    <input type="text"
                                           name="ukuran_tamu"
                                           value="{{ old('ukuran_tamu') }}"
                                           class="custom-input @error('ukuran_tamu') is-invalid @enderror"
                                           placeholder="Masukkan ukuran tamu"
                                           required>
                                    @error('ukuran_tamu')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="form-label-custom">Harga Satuan</label>
                                    <input type="number"
                                           name="harga"
                                           value="{{ old('harga') }}"
                                           class="custom-input @error('harga') is-invalid @enderror"
                                           placeholder="Masukkan harga satuan"
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
                                Simpan Data Barang
                            </button>
                            <button type="reset" class="btn-reset ms-2">
                                Reset Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
