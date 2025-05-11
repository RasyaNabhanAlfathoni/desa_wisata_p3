{{-- index.blade.php / Profile --}}

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
                                <div class="h6">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-muted mb-1">Level</label>
                                <div class="h6">{{ ucfirst(Auth::user()->level) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-muted mb-1">Status</label>
                                <div class="h5">
                                    @if (Auth::user()->aktif)
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
                                <div class="h6">{{ Auth::user()->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-muted mb-1">Terakhir Update</label>
                                <div class="h6">{{ Auth::user()->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- Tombol Edit -->
                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('profile.edit', Auth::user()->id) }}" class="btn btn-primary">Edit Profil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(Auth::user()->karyawan || Auth::user()->pelanggan)
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header text-center">
                    @if(in_array(Auth::user()->level, ['admin', 'pemilik', 'bendahara']))
                        <h4 class="mb-0">Profil Karyawan</h4>
                    @elseif(Auth::user()->level == 'pelanggan')
                        <h4 class="mb-0">Profil Pelanggan</h4>
                    @endif
                </div>
                <div class="card-body text-center">
                    @if(Auth::user()->level == 'pelanggan' && Auth::user()->pelanggan->foto)
                        <img src="{{ asset('storage/' . Auth::user()->pelanggan->foto) }}"
                            class="rounded-circle mb-3"
                            width="120" height="120"
                            alt="Foto Profil">
                    @endif

                    @if(Auth::user()->karyawan)
                        <div class="form-group">
                            <label class="text-muted mb-1">Nama Karyawan</label>
                            <div class="h6">{{ Auth::user()->karyawan->nama_karyawan }}</div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted mb-1">Alamat</label>
                            <div class="h6">{{ Auth::user()->karyawan->alamat }}</div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted mb-1">Nomor Handphone</label>
                            <div class="h6">{{ Auth::user()->karyawan->no_hp }}</div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted mb-1">Jabatan</label>
                            <div class="h6">{{ ucfirst(Auth::user()->karyawan->jabatan) }}</div>
                        </div>
                    @elseif(Auth::user()->pelanggan)
                        <div class="form-group">
                            <label class="text-muted mb-1">Nama Pelanggan</label>
                            <div class="h6">{{ Auth::user()->pelanggan->nama_lengkap }}</div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted mb-1">Alamat</label>
                            <div class="h6">{{ Auth::user()->pelanggan->alamat }}</div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted mb-1">No. HP</label>
                            <div class="h6">{{ Auth::user()->pelanggan->no_hp }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    </div>
</div>
</main>

{{-- <div class="invisible" id="status">@isset($status) {{$status}} @endisset</div> --}}
<div class="invisible" id="pesan">@isset($pesan) {{$pesan}} @endisset</div>

<script>
    const body = document.getElementById('body');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const frm = document.getElementById('frmHapus');

    function tampil_pesan(){
        let pesan = "{{ session('pesan') }}";
        let error = "{{ session('error') }}";

        if (pesan.trim() !== '') {
            swal('Good Job', pesan.trim(), 'success');
        }

        if (error.trim() !== '') {
            swal('Error', error.trim(), 'error');
        }
        // if(pesan.innerHTML.trim() !== ''){
        // swal('Good Job', pesan.innerHTML, 'success')
        // // }else if(status.innerHTML.trim() === 'edit'){
        // // swal('Good Job', pesan.innerHTML, 'success')
        // }
    }

    body.onload = function(){
        tampil_pesan()
    }

</script>

@endsection
