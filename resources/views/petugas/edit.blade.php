@extends('layouts.app')

@section('title', 'Ubah Petugas')
@section('page-title', 'Ubah Data Petugas')
@section('page-subtitle', 'Edit informasi untuk ID: ' . $petugas->idpetugas)

@section('content')

    <div class="container-fluid">
        <div class="section-header d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="h3 mb-0">Ubah Data Petugas</h2>
                <p class="text-muted">
                    Edit informasi untuk ID: <strong>{{ $petugas->idpetugas }}</strong>
                </p>
            </div>
            <a href="{{ route('petugas.index') }}" class="btn-back" style="text-decoration:none;">
                &larr; Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-xl-10">
                <div class="card custom-card">
                    <div class="card-header custom-card-header">
                        <h4 class="card-title mb-0">Edit Profil Petugas</h4>
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

                    <form action="{{ route('petugas.update', $petugas->idpetugas) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body custom-card-body">
                            <div class="row">

                                {{-- ID readonly --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">ID Petugas</label>
                                    <input type="text"
                                           value="{{ $petugas->idpetugas }}"
                                           class="custom-input"
                                           style="opacity:0.6;cursor:not-allowed;"
                                           readonly>
                                    <small class="text-muted">ID tidak dapat diubah.</small>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label-custom">Nama Lengkap</label>
                                    <input type="text"
                                           name="namapetugas"
                                           value="{{ old('namapetugas', $petugas->namapetugas) }}"
                                           class="custom-input @error('namapetugas') is-invalid @enderror"
                                           required>
                                    @error('namapetugas')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label class="form-label-custom">Jabatan</label>
                                    <input type="text"
                                           name="jabatan"
                                           value="{{ old('jabatan', $petugas->jabatan) }}"
                                           class="custom-input @error('jabatan') is-invalid @enderror"
                                           required>
                                    @error('jabatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Tanda tangan: tampilkan preview jika sudah ada --}}
                                <div class="col-md-12 mb-2">
                                    <label class="form-label-custom">
                                        Tanda Tangan
                                        <small class="text-muted">(kosongkan jika tidak ingin mengubah)</small>
                                    </label>

                                    @if($petugas->ttdpetugas)
                                        <div style="margin-bottom:8px;">
                                            <img src="{{ asset('storage/ttd/' . $petugas->ttdpetugas) }}"
                                                 alt="TTD {{ $petugas->namapetugas }}"
                                                 style="max-height:80px;border:1px solid var(--border);border-radius:6px;padding:4px;">
                                            <small class="text-muted" style="display:block;margin-top:4px;">
                                                File saat ini: {{ $petugas->ttdpetugas }}
                                            </small>
                                        </div>
                                    @endif

                                    <input type="file"
                                           name="ttdpetugas"
                                           class="custom-input @error('ttdpetugas') is-invalid @enderror"
                                           accept=".jpg,.jpeg,.png,.svg">
                                    @error('ttdpetugas')
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
