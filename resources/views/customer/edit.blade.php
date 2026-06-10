@extends('layouts.app')

@section('title', 'Ubah Customer')
@section('page-title', 'Ubah Data Customer')
@section('page-subtitle', 'Edit informasi untuk ID: ' . $customer->idcustomer)

@section('content')

    <div class="container-fluid">
        <div class="section-header d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="h3 mb-0">Ubah Data Customer</h2>
                <p class="text-muted">
                    Edit informasi untuk ID: <strong>{{ $customer->idcustomer }}</strong>
                </p>
            </div>
            <a href="{{ route('customer.index') }}" class="btn-back" style="text-decoration:none;">
                &larr; Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-xl-10">
                <div class="card custom-card">
                    <div class="card-header custom-card-header">
                        <h4 class="card-title mb-0">Edit Profil Customer</h4>
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

                    <form action="{{ route('customer.update', $customer->idcustomer) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body custom-card-body">
                            <div class="row">

                                {{-- ID readonly --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">ID Customer</label>
                                    <input type="text"
                                           value="{{ $customer->idcustomer }}"
                                           class="custom-input"
                                           style="opacity:0.6;cursor:not-allowed;"
                                           readonly>
                                    <small class="text-muted">ID tidak dapat diubah.</small>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">Nama Customer</label>
                                    <input type="text"
                                           name="kepada_yth"
                                           value="{{ old('kepada_yth', $customer->kepada_yth) }}"
                                           class="custom-input @error('kepada_yth') is-invalid @enderror"
                                           required>
                                    @error('kepada_yth')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label class="form-label-custom">Alamat</label>
                                    <input type="text"
                                           name="alamat"
                                           value="{{ old('alamat', $customer->alamat) }}"
                                           class="custom-input @error('alamat') is-invalid @enderror"
                                           required>
                                    @error('alamat')
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
