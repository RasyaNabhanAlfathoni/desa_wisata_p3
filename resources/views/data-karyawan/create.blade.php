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
                    <form action="{{ route('kelola_data_karyawan.store') }}" method="POST" id="frmKaryawan" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_karyawan">Nama Karyawan</label>
                            <input type="text" class="form-control" name="nama_karyawan" id="nama_karyawan" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <select class="form-control" name="jabatan" id="jabatan" required>
                                <option value="administrasi" {{ old('jabatan') == 'administrasi' ? 'selected' : '' }}>Administrasi</option>
                                <option value="bendahara" {{ old('jabatan') == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                <option value="pemilik" {{ old('jabatan') == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                        <i class="fa fa-eye-slash" id="togglePasswordIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <div id="password" class="form-text text-warning">Note: Pastikan memiliki kata sandi yang kuat dan mudah diingat.
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="save"><i class="fe fe-save mr-1"></i>Simpan</button>
                        <a href="{{ route('kelola_data_karyawan.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>

        <!-- customized table -->
    </div>
</main>

<!-- Form Start -->
@if(isset($status) && $status == 'Duplicate!')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 ">
            <div class="bg-light rounded h-100 p-4">
                {{-- <div class="form-text text-danger fs-4 fw-bold" id="status"> {{$status}} </div> --}}
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
</script>

<script>
    const btnSimpan = document.getElementById('save');
    const frm = document.getElementById('frmKaryawan');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const body = document.getElementById('body');

    // Mengambil nilai dari semua input
    const nama_karyawan = document.getElementById('nama_karyawan');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const alamat = document.getElementById('alamat');
    const no_hp = document.getElementById('no_hp');
    const jabatan = document.getElementById('jabatan');

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
         if (nama_karyawan.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nama Karyawan.", "error");
        } else if (email.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Email.", "error");
        } else if (password.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Password.", "error");
        } else if (alamat.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Alamat.", "error");
        } else if (no_hp.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nomor HP.", "error");
        } else if (jabatan.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Jabatan.", "error");
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
