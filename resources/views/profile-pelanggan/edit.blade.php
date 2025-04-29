{{-- profile-pelanggan/edit.blade.php --}}
@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection
@section('content')

<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('front-end/images/lsp/wisata/jalanan utama/1018586_720 (1).jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
        <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
            <h1 class="mb-2 bread">Edit Profil</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('pelanggan.index') }}">Beranda <i class="ion-ios-arrow-forward"></i></a></span> <span>Profil <i class="ion-ios-arrow-forward"></i></span></p>
        </div>
      </div>
    </div>
  </div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-white text-center">Form Edit Profil</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile-pelanggan.update', $user->id) }}" id="frmUser" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="text-center mb-4">
                                @if($user->pelanggan && $user->pelanggan->foto)
                                    <img id="previewFoto" src="{{ asset('Storage/' . $user->pelanggan->foto) }}"
                                         class="rounded-circle mb-3"
                                         width="150" height="150"
                                         alt="Foto Profil">
                                @else
                                    <img id="previewFoto" src="{{ asset('front-end/images/default-profile.png') }}"
                                         class="rounded-circle mb-3"
                                         width="150" height="150"
                                         alt="Foto Profil Default">
                                @endif

                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*">
                                    <label class="custom-file-label" for="foto">Pilih foto...</label>
                                    <small class="form-text text-muted">Ukuran maksimal 3MB</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                       id="nama_lengkap" name="nama_lengkap"
                                       value="{{ old('nama_lengkap', $user->pelanggan->nama_lengkap ?? '') }}" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="no_hp">Nomor HP</label>
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                       id="no_hp" name="no_hp"
                                       value="{{ old('no_hp', $user->pelanggan->no_hp ?? '') }}" required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror"
                                          id="alamat" name="alamat" rows="3">{{ old('alamat', $user->pelanggan->alamat ?? '') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3">Ubah Password</h5>

                            <div class="form-group">
                                <label for="password_lama">Password Lama</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password_lama') is-invalid @enderror"
                                    id="password_lama" name="password_lama">
                                    @error('password_lama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePasswordLama()" style="cursor: pointer;">
                                            <i class="fa fa-eye-slash" id="togglePasswordLamaIcon"></i>
                                        </span>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Diperlukan jika ingin mengubah password</small>
                            </div>

                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
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

                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation">
                                        <div class="input-group-append">
                                            <span class="input-group-text" onclick="togglePasswordConfrm()" style="cursor: pointer;">
                                            <i class="fa fa-eye-slash" id="togglePasswordConfrmIcon"></i>
                                            </span>
                                        </div>
                                </div>
                            </div>

                            <label class="text-warning">Note: Bagian Password (Kosongkan jika tidak diubah)</label>

                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="icon-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('profile-pelanggan.index') }}" class="btn btn-secondary px-5">
                                    <i class="icon-close"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Preview foto sebelum upload
    document.getElementById('foto').addEventListener('change', function(event) {
        const output = document.getElementById('previewFoto');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                output.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Update nama file di label
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih foto...';
        const nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>

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

    function togglePasswordConfrm() {
        let passwordField = document.getElementById("password_confirmation");
        let icon = document.getElementById("togglePasswordConfrmIcon");
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
