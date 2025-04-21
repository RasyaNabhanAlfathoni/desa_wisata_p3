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
                        <form action="{{ route('kelola_kategori_wisata.update', $kategori_wisata->id) }}" id="frmKategoriWisata" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="kategori_wisata">Nama Kategori Wisata</label>
                                <input type="text" class="form-control" name="kategori_wisata" id="kategori_wisata" required value="{{ old('kategori_wisata', $kategori_wisata->kategori_wisata) }}">
                            </div>

                            <button type="button" class="btn btn-primary" id="save"><i class="fe fe-save mr-1"></i>Simpan</button>
                            <a href="{{ route('kelola_kategori_wisata.index') }}" class="btn btn-secondary">Kembali</a>
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
    const frm = document.getElementById('frmKategoriWisata');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const body = document.getElementById('body');

    // Mengambil nilai dari semua input
    const kategori_wisata = document.getElementById('kategori_wisata');

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
         if (kategori_wisata.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nama Kategori Wisata.", "error");
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
