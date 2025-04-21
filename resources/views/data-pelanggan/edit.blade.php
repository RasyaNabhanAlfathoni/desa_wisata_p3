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
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <p class="text-muted">Pages / <span class="h6">{{$title}}</span></p>
                        <h2 class="h4 page-title" style="margin-top: -10px;">{{$page}}</h2>
                    </div>
                </div>

        <!-- Small table -->
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('kelola_data_pelanggan.update', $pelanggan->id) }}" method="POST" id="frmPelanggan" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama">Nama Pelanggan</label>
                            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="{{ $pelanggan->nama_lengkap }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $pelanggan->user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp" value="{{ $pelanggan->no_hp }}" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" required>{{ $pelanggan->alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="aktif">Status Aktif</label>
                            <select class="form-control" name="aktif" id="aktif" required>
                                <option value="1" {{ old('aktif', $pelanggan->user->aktif) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('aktif', $pelanggan->user->aktif) == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password (Kosongkan jika tidak diubah)</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password">
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                        <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" accept="image/*" class="form-control" name="foto" id="foto">
                            <div id="foto" class="form-text text-warning">Edit Foto Profile Anda! (Maks 3MB)</div>
                            @if($pelanggan->foto)
                                <small class="text-muted">Foto sebelumnya:</small>
                                <img src="{{ asset('Storage/'.$pelanggan->foto) }}" alt="Foto Pelanggan" class="img-thumbnail" width="100">
                            @endif
                        </div>
                        <button type="button" class="btn btn-primary" id="save"><i class="fe fe-save mr-1"></i>Simpan</button>
                        <a href="{{ route('kelola_data_pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
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
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>

<script>
    const btnSimpan = document.getElementById('save');
    const frm = document.getElementById('frmPelanggan');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const body = document.getElementById('body');

    // Mengambil nilai dari semua input
    const nama_lengkap = document.getElementById('nama_lengkap');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const alamat = document.getElementById('alamat');
    const no_hp = document.getElementById('no_hp');

    function tampil_pesan(){
        let pesan = "{{ session('pesan') }}";
        let error = "{{ session('error') }}";

        if (pesan.trim() !== '') {
            swal('Duplicate!', pesan.trim(), 'error');
        }

        if (error.trim() !== '') {
            swal('Error', error.trim(), 'error');
        }

        if(pesan.innerHTML.trim() !== ''){
            swal('Duplicate Data!', pesan.innerHTML, 'error')
        }
    }

    function simpan(event) {
         // Cek apakah ada field yang kosong dan tampilkan pesan error sesuai
         if (nama_lengkap.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nama Lengkap.", "error");
        } else if (email.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Email.", "error");
        // } else if (password.value === '') {
        //     event.preventDefault();
        //     swal("Invalid Data!", "Mohon isi bagian kolom Password.", "error");
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
