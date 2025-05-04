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
                        <h4 class="mb-0 text-white"><i class="fe fe-user"></i> Detail Pelanggan</h4>
                    </div>
                    <div class="card-body text-center p-4">

                        @if($pelanggan->foto)
                            <img src="{{ asset('Storage/' . $pelanggan->foto) }}"
                                class="rounded-circle mb-3 border shadow-sm"
                                width="120" height="120"
                                alt="Foto Profil">
                        @else
                            <img src="{{ asset('back-end/assets/avatars/default.png') }}"
                                class="rounded-circle mb-3 border shadow-sm"
                                width="120" height="120"
                                alt="Default Foto">
                        @endif

                        <div class="row text-start">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted"><i class="bi bi-person-fill"></i> Nama Pelanggan</label>
                                    <div class="h6 fw-bold">{{ $pelanggan->nama_lengkap }}</div>
                                </div>
                                <div class="form-group">
                                    <label class="text-muted"><i class="bi bi-geo-alt-fill"></i> Alamat</label>
                                    <div class="h6">{{ $pelanggan->alamat }}</div>
                                </div>
                                <div class="form-group">
                                    <label class="text-muted"><i class="bi bi-telephone-fill"></i> Nomor Handphone</label>
                                    <div class="h6">{{ $pelanggan->no_hp }}</div>
                                </div>
                                <div class="form-group text-start">
                                    <label class="text-muted"><i class="bi bi-calendar-check-fill"></i> Jumlah Reservasi</label>
                                    <div class="h5 fw-bold">{{ $jumlahReservasi }} kali</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted"><i class="bi bi-briefcase-fill"></i> Jabatan</label>
                                    <div class="h6">{{ ucfirst($pelanggan->user->level) }}</div>
                                </div>
                                <div class="form-group">
                                    <label class="text-muted"><i class="bi bi-envelope-fill"></i> Email</label>
                                    <div class="h6">{{ $pelanggan->user->email }}</div>
                                </div>
                                <div class="form-group">
                                    <label class="text-muted"><i class="bi bi-check-circle-fill"></i> Status Akun</label>
                                    <div class="h6">
                                        @if($pelanggan->user->aktif)
                                            <span class="badge bg-success text-white">Aktif</span>
                                        @else
                                            <span class="badge bg-danger text-white">Non-Aktif</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="text-muted"><i class="bi bi-patch-check-fill"></i> Verifikasi Email</label>
                                    <div class="h6">
                                        @if ($pelanggan->user->email_verified_at)
                                            <span class="badge bg-success text-white">Terverifikasi</span><br>
                                            <small>{{ \Carbon\Carbon::parse($pelanggan->user->email_verified_at)->format('d M Y H:i') }}</small>
                                        @else
                                            <span class="badge bg-warning text-white">Belum Diverifikasi</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tambahan Jumlah Reservasi -->
                        <hr class="my-4">

                        <a href="{{ route('kelola_data_pelanggan.index') }}" class="btn btn-secondary mt-4">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
