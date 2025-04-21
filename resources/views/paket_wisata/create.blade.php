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
                        <form action="{{ route('kelola_paket_wisata.store') }}" id="frmPaketWisata" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="nama_paket">Nama Paket Wisata</label>
                                <input type="text" class="form-control" name="nama_paket" id="nama_paket" required value="{{ old('nama_paket') }}">
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="fasilitas">Fasilitas</label>
                                <input type="text" class="form-control" name="fasilitas" id="fasilitas" required value="{{ old('fasilitas') }}">
                            </div>

                            <div class="form-group">
                                <label for="durasi_hari">Durasi (hari)</label>
                                <input type="number" class="form-control" name="durasi_hari" id="durasi_hari" required min="1" value="{{ old('durasi_hari') }}">
                            </div>

                            <div class="form-group">
                                <label for="harga_per_pack">Harga Paket (Rp)</label>
                                <input type="number" class="form-control" name="harga_per_pack" id="harga_per_pack" required value="{{ old('harga_per_pack') }}">
                            </div>

                            <div class="form-group">
                                <label for="kuota_peserta">Kuota Peserta</label>
                                <input type="number" class="form-control" name="kuota_peserta" id="kuota_peserta" required value="{{ old('kuota_peserta') }}">
                            </div>

                            <div class="form-group">
                                <label for="nilai_diskon">Nilai Diskon (%)</label>
                                <input type="number" class="form-control" name="nilai_diskon" id="nilai_diskon" step="0.1" min="0" max="100" value="{{ old('nilai_diskon') }}">
                            </div>

                            <div class="form-group">
                                <label for="peserta_diskon">Jumlah Peserta Minimum untuk Diskon</label>
                                <input type="number" class="form-control" name="peserta_diskon" id="peserta_diskon" value="{{ old('peserta_diskon') }}">
                                <div id="peserta_diskon" class="form-text text-warning">Note: Pastikan mengisi field ini jika sudah mengisi field diskon.</div>
                            </div>

                            <!-- Upload Foto -->
                            <div class="form-group">
                                <label>Upload Foto (Maks. 3 Mb per Poto)</label>
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="mb-3">
                                        <label for="foto{{ $i }}">Foto {{ $i }}</label>
                                        <input type="file" class="form-control" name="foto{{ $i }}" id="foto{{ $i }}" accept="image/*" onchange="previewImage(event, 'preview{{ $i }}')">
                                        <img id="preview{{ $i }}" src="" alt="Preview Foto" style="display:none; width:150px; margin-top:10px;">
                                    </div>
                                @endfor
                            </div>

                            <button type="button" class="btn btn-primary" id="save">Simpan</button>
                            <a href="{{ route('kelola_paket_wisata.index') }}" class="btn btn-secondary">Kembali</a>
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
    const frm = document.getElementById('frmPaketWisata');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const body = document.getElementById('body');

    // Mengambil nilai dari semua input
    const nama_paket = document.getElementById('nama_paket');
    const deskripsi = document.getElementById('deskripsi');
    const harga_per_pack = document.getElementById('harga_per_pack');
    const fasilitas = document.getElementById('fasilitas');
    const durasi_hari = document.getElementById('durasi_hari');
    const kuota_peserta = document.getElementById('kuota_peserta');

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
         if (nama_paket.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nama Paket Wisata.", "error");
        } else if (deskripsi.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Deskripsi Paket Wisata.", "error");
        } else if (harga_per_pack.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Harga.", "error");
        } else if (fasilitas.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Fasilitas.", "error");
        } else if (durasi_hari.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Durasi Hari.", "error");
        } else if (kuota_peserta.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Kuota Peserta.", "error");
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
