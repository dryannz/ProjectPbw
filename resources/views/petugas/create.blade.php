@extends('layouts.app')

@section('title', 'Tambah Petugas')
@section('page-title', 'Tambah Petugas Baru')
@section('page-subtitle', 'Daftarkan pengelola ke dalam sistem')

@section('content')

    <div class="container-fluid">
        <div class="section-header d-flex justify-content-between align-items-center mb-6">
            <div>
                <h2 class="h3 mb-0">Tambah Petugas Baru</h2>
                <p class="text-muted">Daftarkan pengelola dana usaha ke dalam sistem</p>
            </div>
            <a href="{{ route('petugas.index') }}" class="btn-back">&larr; Kembali</a>
        </div>

        <div class="row">
            <div class="col-12 col-xl-10">
                <div class="card custom-card">
                    <div class="card-header custom-card-header">
                        <h4 class="card-title mb-0">Form Data Petugas</h4>
                        <p class="text-muted small">Isi semua kolom dengan benar.</p>
                    </div>

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
                        enctype="multipart/form-data" wajib ada karena ada upload file TTD.
                        Native: tidak ada fitur upload di tambah, ditambahkan di Laravel.
                    --}}
                    <form action="{{ route('petugas.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="card-body custom-card-body">
                            <div class="row">

                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">ID Petugas</label>
                                    <input type="text"
                                           name="idpetugas"
                                           value="{{ old('idpetugas') }}"
                                           class="custom-input @error('idpetugas') is-invalid @enderror"
                                           placeholder="Contoh: P-XXX"
                                           required>
                                    @error('idpetugas')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">Nama Lengkap</label>
                                    <input type="text"
                                           name="namapetugas"
                                           value="{{ old('namapetugas') }}"
                                           class="custom-input @error('namapetugas') is-invalid @enderror"
                                           placeholder="Masukkan nama lengkap..."
                                           required>
                                    @error('namapetugas')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label class="form-label-custom">Jabatan</label>
                                    <input type="text"
                                           name="jabatan"
                                           value="{{ old('jabatan') }}"
                                           class="custom-input @error('jabatan') is-invalid @enderror"
                                           placeholder="Masukkan jabatan"
                                           required>
                                    @error('jabatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                            </div>
                        </div>

                        <div class="card-footer custom-card-footer">
                            <button type="submit" class="btn primary btn-save">
                                Simpan Data Petugas
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
