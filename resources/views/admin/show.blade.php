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
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col">
                        <p class="text-muted">Pages / <span class="h6">{{$title}}</span></p>
                        <h2 class="h4 page-title" style="margin-top: -10px;">{{$page}}</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                            <i class="fe fe-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <h4 class="mb-0">Informasi Pengguna</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-muted mb-1">Email</label>
                                            <div class="h6">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-muted mb-1">Level</label>
                                            <div class="h6">{{ ucfirst($user->level) }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-muted mb-1">Status</label>
                                            <div class="h5">
                                                @if ($user->aktif)
                                                    <span class="badge badge-success text-white">Aktif</span>
                                                @else
                                                    <span class="badge badge-danger text-white">Nonaktif</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-muted mb-1">Tanggal Dibuat</label>
                                            <div class="h6">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-muted mb-1">Terakhir Update</label>
                                            <div class="h6">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($profileData)
                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-header text-center">
                                @if(in_array($user->level, ['admin', 'pemilik', 'bendahara']))
                                    <h4 class="mb-0">Profil Karyawan</h4>
                                @elseif($user->level == 'pelanggan')
                                    <h4 class="mb-0">Profil Pelanggan</h4>
                                @endif
                            </div>
                            <div class="card-body text-center">
                                @if($user->level == 'pelanggan' && $profileData->foto)
                                    <img src="{{ asset('Storage/' . $profileData->foto) }}" class="rounded-circle mb-3" width="120" height="120" alt="Foto Profil">
                                {{-- @else
                                    <img src="{{ asset('back-end/assets/avatars/default.png') }}" class="rounded-circle mb-3" width="120" height="120" alt="Foto Profil"> --}}
                                @endif

                                @if(in_array($user->level, ['admin', 'pemilik', 'bendahara']))
                                    <div class="form-group">
                                        <label class="text-muted mb-1">Nama Karyawan</label>
                                        <div class="h6">{{ $profileData->nama_karyawan }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-muted mb-1">Alamat</label>
                                        <div class="h6">{{ $profileData->alamat }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-muted mb-1">Nomor Handphone</label>
                                        <div class="h6">{{ $profileData->no_hp }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-muted mb-1">Jabatan</label>
                                        <div class="h6">{{ ucfirst($profileData->jabatan) }}</div>
                                    </div>
                                @elseif($user->level == 'pelanggan')
                                    <div class="form-group">
                                        <label class="text-muted mb-1">Nama Pelanggan</label>
                                        <div class="h6">{{ $profileData->nama_lengkap }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-muted mb-1">Alamat</label>
                                        <div class="h6">{{ $profileData->alamat }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-muted mb-1">No. HP</label>
                                        <div class="h6">{{ $profileData->no_hp }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</main>

<div class="invisible" id="pesan">@isset($pesan) {{$pesan}} @endisset</div>

<script>
    const body = document.getElementById('body');
    const pesan = document.getElementById('pesan');

    function tampil_pesan(){
        let pesan = "{{ session('pesan') }}";
        let error = "{{ session('error') }}";

        if (pesan.trim() !== '') {
            swal('Good Job', pesan.trim(), 'success');
        }

        if (error.trim() !== '') {
            swal('Error', error.trim(), 'error');
        }
    }

    body.onload = function(){
        tampil_pesan()
    }
</script>
@endsection
