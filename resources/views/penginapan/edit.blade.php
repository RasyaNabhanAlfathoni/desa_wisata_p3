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
                        <form action="{{ route('kelola_penginapan.update', $penginapan->id) }}" id="frmPenginapan" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nama_penginapan">Nama Penginapan</label>
                                <input type="text" class="form-control" name="nama_penginapan" id="nama_penginapan" required value="{{ old('nama_penginapan', $penginapan->nama_penginapan) }}">
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" required>{{ old('deskripsi', $penginapan->deskripsi) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="fasilitas">Fasilitas</label>
                                <input type="text" class="form-control" name="fasilitas" id="fasilitas" required value="{{ old('fasilitas', $penginapan->fasilitas) }}">
                            </div>

                            <!-- Upload Foto -->
                            <div class="form-group">
                                <label>Upload Foto (Maks. 3 Mb per Foto)</label>
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="mb-3">
                                        <label for="foto{{ $i }}">Foto {{ $i }}</label>
                                        <input type="file" class="form-control" name="foto{{ $i }}" id="foto{{ $i }}" accept="image/*" onchange="previewImage(event, 'preview{{ $i }}')">
                                        @if(isset($penginapan["foto{$i}"]))
                                            <small class="text-muted">Foto saat ini:</small>
                                            <img id="preview{{ $i }}" src="{{ asset('storage/' . $penginapan["foto{$i}"]) }}" alt="Preview Foto" style="width:150px; margin-top:10px;">
                                        @else
                                            <small class="text-muted">Foto saat ini:</small>
                                            <img id="preview{{ $i }}" src="" alt="Preview Foto" style="display:none; width:150px; margin-top:10px;">
                                        @endif
                                    </div>
                                @endfor
                            </div>

                            <button type="button" class="btn btn-primary" id="save"><i class="fe fe-save mr-1"></i>Simpan</button>
                            <a href="{{ route('kelola_penginapan.index') }}" class="btn btn-secondary">Kembali</a>
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
    const frm = document.getElementById('frmPenginapan');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const body = document.getElementById('body');

    // Mengambil nilai dari semua input
    const nama_penginapan = document.getElementById('nama_penginapan');
    const deskripsi = document.getElementById('deskripsi');
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
         if (nama_penginapan.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nama Penginapan.", "error");
        } else if (deskripsi.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Deskripsi Penginapan.", "error");
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
