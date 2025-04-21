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
                        <form action="{{ route('kelola_berita.update', $berita->id) }}" id="frmBerita" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="judul">Judul Berita</label>
                                <input type="text" class="form-control" name="judul" id="judul" required value="{{ old('judul', $berita->judul) }}">
                            </div>

                            <div class="form-group">
                                <label for="berita">Isi Berita</label>
                                <textarea class="form-control" name="berita" id="berita" rows="8" required>{{ old('berita', $berita->berita) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="tgl_post">Tanggal Posting</label>
                                <input type="datetime-local" class="form-control" name="tgl_post" id="tgl_post"
                                       value="{{ old('tgl_post', $berita->tgl_post ? \Carbon\Carbon::parse($berita->tgl_post)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="id_kategori_berita">Kategori Wisata</label>
                                <select class="form-control" name="id_kategori_berita" id="id_kategori_berita" required>
                                    <option value="" disabled>Pilih Kategori</option>
                                    @foreach($kategori_beritas as $kategori)
                                        <option value="{{ $kategori->id }}" {{ ($berita->id_kategori_berita ?? old('id_kategori_berita')) == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->kategori_berita }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Upload Foto -->
                            <div class="form-group">
                                <label for="foto">Foto Berita</label>
                                <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                                <div class="form-text text-warning">Edit Foto Berita Anda! (Maks 3MB)</div>
                                @if($berita->foto)
                                <small class="text-muted">Foto sebelumnya:</small>
                                    <img src="{{ asset('Storage/' . $berita->foto) }}" alt="Foto Berita" class="img-thumbnail" width="150">
                                @endif
                            </div>

                            <button type="button" class="btn btn-primary" id="save"><i class="fe fe-save mr-1"></i>Simpan</button>
                            <a href="{{ route('kelola_berita.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
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
    const btnSimpan = document.getElementById('save');
    const frm = document.getElementById('frmBerita');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const body = document.getElementById('body');

    // Mengambil nilai dari semua input
    const judul = document.getElementById('judul');
    const berita = document.getElementById('berita');
    const id_kategori_berita = document.getElementById('id_kategori_berita');

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
         if (judul.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nama Wisata.", "error");
        } else if (berita.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Deskripsi Wisata.", "error");
        } else if (id_kategori_berita.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Kategori Wisata.", "error");
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
