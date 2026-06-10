@extends('layouts.app')

@section('title', 'Tambah Customer')
@section('page-title', 'Tambah Customer Baru')
@section('page-subtitle', 'Daftarkan Customer ke dalam sistem')

@section('content')

    <div class="container-fluid">
        <div class="section-header d-flex justify-content-between align-items-center mb-6">
            <div>
                <h2 class="h3 mb-0">Tambah Customer Baru</h2>
                <p class="text-muted">Daftarkan Customer ke dalam sistem</p>
            </div>
            <a href="{{ route('customer.index') }}" class="btn-back">&larr; Kembali</a>
        </div>

        <div class="row">
            <div class="col-12 col-xl-10">
                <div class="card custom-card">
                    <div class="card-header custom-card-header">
                        <h4 class="card-title mb-0">Form Data Customer</h4>
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
                    <form action="{{ route('customer.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="card-body custom-card-body">
                            <div class="row">

                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">ID Customer</label>
                                    <input type="text"
                                           name="idcustomer"
                                           value="{{ old('idcustomer') }}"
                                           class="custom-input @error('idcustomer') is-invalid @enderror"
                                           placeholder="Contoh: C-XXX"
                                           required>
                                    @error('idcustomer')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">Nama Lengkap</label>
                                    <input type="text"
                                           name="kepada_yth"
                                           value="{{ old('kepada_yth') }}"
                                           class="custom-input @error('kepada_yth') is-invalid @enderror"
                                           placeholder="Masukkan nama lengkap..."
                                           required>
                                    @error('kepada_yth')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label class="form-label-custom">Alamat</label>
                                    <input type="text"
                                           name="alamat"
                                           value="{{ old('alamat') }}"
                                           class="custom-input @error('alamat') is-invalid @enderror"
                                           placeholder="Masukkan alamat lengkap..."
                                           required>
                                    @error('alamat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                            </div>
                        </div>

                        <div class="card-footer custom-card-footer">
                            <button type="submit" class="btn primary btn-save">
                                Simpan Data Customer
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
