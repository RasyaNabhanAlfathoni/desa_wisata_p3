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
                        <form action="{{ route('kelola_obyek_wisata.update', $obyek_wisata->id) }}" id="frmWisata" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nama_wisata">Nama Obyek Wisata</label>
                                <input type="text" class="form-control" name="nama_wisata" id="nama_wisata" required value="{{ old('nama_wisata', $obyek_wisata->nama_wisata) }}">
                            </div>

                            <div class="form-group">
                                <label for="id_kategori_wisata">Kategori Wisata</label>
                                <select class="form-control" name="id_kategori_wisata" id="id_kategori_wisata" required>
                                    <option value="" disabled>Pilih Kategori</option>
                                    @foreach($kategori_wisatas as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('id_kategori_wisata', $obyek_wisata->id_kategori_wisata) == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->kategori_wisata }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi_wisata">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi_wisata" id="deskripsi_wisata" rows="4" required>{{ old('deskripsi_wisata', $obyek_wisata->deskripsi_wisata) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="fasilitas">Fasilitas</label>
                                <input type="text" class="form-control" name="fasilitas" id="fasilitas" required value="{{ old('fasilitas', $obyek_wisata->fasilitas) }}">
                            </div>

                            <!-- Upload Foto -->
                            <div class="form-group">
                                <label>Upload Foto (Maks. 3 Mb per Foto)</label>
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="mb-3">
                                        <label for="foto{{ $i }}">Foto {{ $i }}</label>
                                        <input type="file" class="form-control" name="foto{{ $i }}" id="foto{{ $i }}" accept="image/*" onchange="previewImage(event, 'preview{{ $i }}')">
                                        @if (!empty($obyek_wisata['foto'.$i]))
                                            <small class="text-muted">Foto sebelumnya:</small>
                                            <img id="preview{{ $i }}" src="{{ asset('Storage/' . $obyek_wisata['foto'.$i]) }}" alt="Preview Foto" style="width:150px; margin-top:10px;">
                                        @else
                                            <small class="text-muted">Foto sebelumnya:</small>
                                            <img id="preview{{ $i }}" src="" alt="Preview Foto" style="display:none; width:150px; margin-top:10px;">
                                        @endif
                                    </div>
                                @endfor
                            </div>

                            <button type="button" class="btn btn-primary" id="save"><i class="fe fe-save mr-1"></i>Simpan</button>
                            <a href="{{ route('kelola_obyek_wisata.index') }}" class="btn btn-secondary">Kembali</a>
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
    const frm = document.getElementById('frmWisata');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const body = document.getElementById('body');

    // Mengambil nilai dari semua input
    const nama_wisata = document.getElementById('nama_wisata');
    const deskripsi_wisata = document.getElementById('deskripsi_wisata');
    const id_kategori_wisata = document.getElementById('id_kategori_wisata');
    const fasilitas = document.getElementById('fasilitas');

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
         if (nama_wisata.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nama Wisata.", "error");
        } else if (deskripsi_wisata.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Deskripsi Wisata.", "error");
        } else if (id_kategori_wisata.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Kategori Wisata.", "error");
        } else if (fasilitas.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Fasilitas.", "error");
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

    function previewImage(event, previewId) {
        const reader = new FileReader();
        reader.onload = function(){
            const imgElement = document.getElementById(previewId);
            imgElement.src = reader.result;
            imgElement.style.display = "block";
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
