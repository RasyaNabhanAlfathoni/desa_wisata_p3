@extends('be.master')
@section('navbar')
    @include('be.navbar')
@endsection
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')

<!-- main -->
<main role="main" class="main-content">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top">
                    <h4 class="mb-0 text-white"><i class="fe fe-user"></i> Detail Karyawan</h4>
                </div>
                <div class="card-body text-center p-4">

                    {{-- @if($karyawan->foto)
                        <img src="{{ asset('storage/' . $karyawan->foto) }}"
                            class="rounded-circle mb-3 border shadow-sm"
                            width="120" height="120"
                            alt="Foto Profil">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}"
                            class="rounded-circle mb-3 border shadow-sm"
                            width="120" height="120"
                            alt="Default Foto">
                    @endif --}}

                    <div class="row text-start">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-muted"><i class="bi bi-person-fill"></i> Nama Karyawan</label>
                                <div class="h6 fw-bold">{{ $karyawan->nama_karyawan }}</div>
                            </div>
                            <div class="form-group">
                                <label class="text-muted"><i class="bi bi-geo-alt-fill"></i> Alamat</label>
                                <div class="h6">{{ $karyawan->alamat }}</div>
                            </div>
                            <div class="form-group">
                                <label class="text-muted"><i class="bi bi-telephone-fill"></i> Nomor Handphone</label>
                                <div class="h6">{{ $karyawan->no_hp }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-muted"><i class="bi bi-briefcase-fill"></i> Jabatan</label>
                                <div class="h6">{{ ucfirst($karyawan->jabatan) }}</div>
                            </div>
                            <div class="form-group">
                                <label class="text-muted"><i class="bi bi-envelope-fill"></i> Email</label>
                                <div class="h6">{{ $karyawan->user->email }}</div>
                            </div>
                            <div class="form-group">
                                <label class="text-muted"><i class="bi bi-check-circle-fill"></i> Status Akun</label>
                                <div class="h6">
                                    @if($karyawan->user->aktif)
                                        <span class="badge bg-success text-white">Aktif</span>
                                    @else
                                        <span class="badge bg-danger text-white">Non-Aktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('kelola_data_karyawan.index') }}" class="btn btn-secondary mt-4">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
