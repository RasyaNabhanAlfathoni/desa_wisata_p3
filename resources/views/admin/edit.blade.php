{{-- edit.blade.php / Admin --}}

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

                <form action="{{ route('admin.update', $user->id) }}" id="frmUser" method="POST" enctype="multipart/form-data">
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
                                                <select name="level" id="level" class="form-control @error('level') is-invalid @enderror" required>
                                                    <option value="admin" {{ old('level', $user->level) == 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <option value="pemilik" {{ old('level', $user->level) == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                                                    <option value="bendahara" {{ old('level', $user->level) == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                                    <option value="pelanggan" {{ old('level', $user->level) == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                                                </select>
                                                @error('level')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="aktif" id="aktif" class="form-control @error('aktif') is-invalid @enderror" required>
                                                    <option value="1" {{ old('aktif', $user->aktif) == 1 ? 'selected' : '' }}>Aktif</option>
                                                    <option value="0" {{ old('aktif', $user->aktif) == 0 ? 'selected' : '' }}>Nonaktif</option>
                                                </select>
                                                @error('aktif')
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

                        @if($profileData)
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
                                                value="{{ old('nama', $profileData->nama_karyawan) }}" required>
                                            @error('nama')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                                rows="3" required>{{ old('alamat', $profileData->alamat) }}</textarea>
                                            @error('alamat')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>No. HP</label>
                                            <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                                value="{{ old('no_hp', $profileData->no_hp) }}" required>
                                            @error('no_hp')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Jabatan</label>
                                            {{-- <select name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" readonly>
                                                <option value="administrasi" {{ old('jabatan', $profileData->jabatan) == 'administrasi' ? 'selected' : '' }}>Administrasi</option>
                                                <option value="pemilik" {{ old('jabatan', $profileData->jabatan) == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                                                <option value="bendahara" {{ old('jabatan', $profileData->jabatan) == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                            </select> --}}
                                            <select name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" readonly>
                                                <option value="administrasi">Administrasi</option>
                                                <option value="pemilik">Pemilik</option>
                                                <option value="bendahara">Bendahara</option>
                                            </select>
                                            @error('jabatan')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                    @elseif($user->level == 'pelanggan')
                                        <div class="form-group">
                                            <label>Nama Pelanggan</label>
                                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                                                value="{{ old('nama', $profileData->nama_lengkap) }}" required>
                                            @error('nama')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                                rows="3" required>{{ old('alamat', $profileData->alamat) }}</textarea>
                                            @error('alamat')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>No. HP</label>
                                            <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                                value="{{ old('no_hp', $profileData->no_hp) }}" required>
                                            @error('no_hp')
                                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                            @enderror
                                        </div>
                                         {{-- Tambahan Input Foto Pelanggan --}}
                                        <div class="form-group">
                                            <label>Foto Profil</label>
                                            <input type="file" accept="image/*" name="foto" class="form-control-file @error('foto') is-invalid @enderror">
                                            @error('foto')
                                                {{-- <div class="invalid-feedback d-block">{{ $message }}</div> --}}
                                            @enderror

                                            {{-- Menampilkan foto lama jika ada --}}
                                            @if($profileData->foto)
                                                <div class="mt-3">
                                                    <img src="{{ asset('storage/' . $profileData->foto) }}" alt="Foto Profil" class="img-thumbnail" width="150">
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
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
    document.addEventListener("DOMContentLoaded", function () {
        const level = document.getElementById("level");
        const jabatan = document.getElementById("jabatan");

        // Mapping level ke jabatan
        const levelToJabatan = {
            "admin": "administrasi",
            "pemilik": "pemilik",
            "bendahara": "bendahara",
            "pelanggan": ""
        };

        // Fungsi untuk mengupdate jabatan berdasarkan level
        function updateJabatan() {
            const selectedLevel = level.value;
            if (levelToJabatan[selectedLevel] !== undefined) {
                jabatan.value = levelToJabatan[selectedLevel];
            }
        }

        // Event listener ketika level berubah
        level.addEventListener("change", updateJabatan);

        // Panggil fungsi saat halaman dimuat agar jabatan terisi otomatis
        updateJabatan();
    });
</script>


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
    const body = document.getElementById('body');
    const pesan = document.getElementById('pesan');
    const status = document.getElementById('status');
    const frm = document.getElementById('frmUser');

    const nama = document.getElementById('nama');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const alamat = document.getElementById('alamat');
    const no_hp = document.getElementById('no_hp');
    const jabatan = document.getElementById('jabatan');
    const aktif = document.getElementById('aktif');
    const level = document.getElementById('level');

    function tampil_pesan(){
        let pesan = "{{ session('pesan') }}";
        let error = "{{ session('error') }}";

        if (pesan.trim() !== '') {
            swal('Good Job', pesan.trim(), 'success');
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
         if (nama.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nama.", "error");
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
        // } else if (jabatan.value === '') {
        //     event.preventDefault();
        //     swal("Invalid Data!", "Mohon isi bagian kolom Jabatan.", "error");
        } else if (aktif.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Status.", "error");
        } else if (level.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Level.", "error");
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
