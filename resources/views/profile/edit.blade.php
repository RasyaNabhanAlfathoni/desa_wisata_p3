{{-- edit.blade.php / Profile --}}

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
                        <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                            <i class="fe fe-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <form action="{{ route('profile.update', $user->id) }}" id="frmUser" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                                <label>Email</label>
                                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Level</label>
                                                <input type="text" class="form-control" value="{{ ucfirst($user->level) }}" readonly>
                                                <input type="hidden" name="level" value="{{ $user->level }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password Lama</label>
                                                <div class="input-group">
                                                    <input type="password" id="password_lama" name="password_lama" class="form-control @error('password_lama') is-invalid @enderror">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" onclick="togglePasswordLama()" style="cursor: pointer;">
                                                            <i class="fa fa-eye-slash" id="togglePasswordLamaIcon"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">Diperlukan jika ingin mengubah password</small>
                                                @error('password_lama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password Baru (Kosongkan jika tidak diubah)</label>
                                                <div class="input-group">
                                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                                            <i class="fa fa-eye-slash" id="togglePasswordIcon"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <h4 class="mb-0">
                                        @if(in_array($user->level, ['admin', 'pemilik', 'bendahara']))
                                            Profil Karyawan
                                        @elseif($user->level == 'pelanggan')
                                            Profil Pelanggan
                                        @endif
                                    </h4>
                                </div>
                                <div class="card-body">
                                    @if(in_array($user->level, ['admin', 'pemilik', 'bendahara']))
                                        <div class="form-group">
                                            <label>Nama Karyawan</label>
                                            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                                value="{{ old('nama', $user->karyawan ? $user->karyawan->nama_karyawan : '') }}" required>
                                            @error('nama')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                                rows="3" required>{{ old('alamat', $user->karyawan ? $user->karyawan->alamat : '') }}</textarea>
                                            @error('alamat')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>No. HP</label>
                                            <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                                value="{{ old('no_hp', $user->karyawan ? $user->karyawan->no_hp : '') }}" required>
                                            @error('no_hp')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Jabatan</label>
                                            <input type="text" class="form-control" value="{{ ucfirst($user->karyawan ? $user->karyawan->jabatan : $user->level) }}" readonly>
                                            <input type="hidden" name="jabatan" value="{{ $user->karyawan ? $user->karyawan->jabatan : $user->level }}">
                                        </div>
                                    @elseif($user->level == 'pelanggan')
                                        <div class="form-group">
                                            <label>Nama Pelanggan</label>
                                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                                                value="{{ old('nama', $user->pelanggan ? $user->pelanggan->nama_lengkap : '') }}" required>
                                            @error('nama')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                                rows="3" required>{{ old('alamat', $user->pelanggan ? $user->pelanggan->alamat : '') }}</textarea>
                                            @error('alamat')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>No. HP</label>
                                            <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                                value="{{ old('no_hp', $user->pelanggan ? $user->pelanggan->no_hp : '') }}" required>
                                            @error('no_hp')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                        {{-- Tambahan Input Foto Pelanggan --}}
                                        <div class="form-group">
                                            <label>Foto Profil</label>
                                            <input type="file" accept="image/*" name="foto" class="form-control-file @error('foto') is-invalid @enderror">
                                            <small class="form-text text-muted">Maksimal 3MB</small>
                                            @error('foto')
                                                {{-- <div class="invalid-feedback d-block">{{ $message }}</div> --}}
                                            @enderror

                                            {{-- Menampilkan foto lama jika ada --}}
                                            @if($user->pelanggan && $user->pelanggan->foto)
                                                <div class="mt-3">
                                                    <img src="{{ asset('storage/' . $user->pelanggan->foto) }}" alt="Foto Profil" class="img-thumbnail" width="150">
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-right mb-4">
                            <button type="button" id="save" class="btn btn-primary">
                                <i class="fe fe-save mr-1"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@if(isset($status) && $status == 'Duplicate!')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 ">
            <div class="bg-light rounded h-100 p-4">
                <div class="form-text text-danger fs-5" id="pesan"> {{$pesan}} </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    function togglePassword() {
        let passwordField = document.getElementById("password");
        let icon = document.getElementById("togglePasswordIcon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    }

    function togglePasswordLama() {
        let passwordField = document.getElementById("password_lama");
        let icon = document.getElementById("togglePasswordLamaIcon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    }
</script>

<script>
    const btnSimpan = document.getElementById('save');
    const frm = document.getElementById('frmUser');
    const body = document.getElementById('body');
    const pesan = document.getElementById('pesan');
    const status = document.getElementById('status');

    const nama = document.getElementById('nama');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const password_lama = document.getElementById('password_lama');
    const alamat = document.getElementById('alamat');
    const no_hp = document.getElementById('no_hp');

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

    function simpan(event) {
        // Validasi jika password baru diisi tetapi password lama kosong
        if (password.value !== '' && password_lama.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi Password Lama untuk mengubah Password.", "error");
            return;
        }

        // Cek apakah ada field yang kosong dan tampilkan pesan error sesuai
        if (nama.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nama.", "error");
        } else if (email.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Email.", "error");
        } else if (alamat.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Alamat.", "error");
        } else if (no_hp.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nomor HP.", "error");
        } else {
            // Menampilkan pesan sukses saat frm valid dan berhasil disubmit
            frm.submit();
        }
    }

    body.onload = function(){
        tampil_pesan()
    }

    btnSimpan.onclick = function(event) {
        simpan(event); // Kirim event ke fungsi simpan
    }
</script>
@endsection
