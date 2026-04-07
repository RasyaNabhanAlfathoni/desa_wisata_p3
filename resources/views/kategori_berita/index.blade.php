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
                    <!-- Header dengan tombol Tambah dan Search -->
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h2 class="h3 mb-3">Daftar Kategori Berita</h2>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        @if ($title == 'Admin')
                        <a href="{{ route('kelola_kategori_berita.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus mr-1"></i>Tambah
                        </a>
                        @else
                        <a href="{{ route('kelola_kategori_berita.create') }}" class="btn disabled">
                        </a>
                        @endif
                        <form class="form">
                            <div class="form-group mb-0">
                                <label for="search1" class="sr-only">Search</label>
                                <input type="text" class="form-control" id="search1" placeholder="Search">
                            </div>
                        </form>
                    </div>

                    <form method="GET" action="{{ route('kelola_kategori_berita.index') }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center" style="font-size: .8rem">
                                <span>Show</span>
                                <select name="per_page" class="form-control form-control-sm rounded mx-2" onchange="this.form.submit()">
                                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                </select>
                                <span>entries</span>
                            </div>

                        </div>
                    </form>

                    <!-- Table -->
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kategori Berita</th>
                                @if ($title == 'Admin')
                                <th>Aksi</th>
                                @else
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if($kategori_beritas->count() > 0)
                            @foreach ($kategori_beritas as $index => $kategori)
                            <tr>
                                <td><p class="mb-0">{{ ($kategori_beritas->currentPage() - 1) * $kategori_beritas->perPage() + $index + 1 }}</p></td>
                                <td><p class="mb-0">{{ $kategori->kategori_berita }}</p></td>
                                @if ($title == 'Admin')
                                <td>
                                    <a class="btn btn-warning text-white" href="{{ route('kelola_kategori_berita.edit', $kategori->id) }}"><i class="fe fe-edit"></i> Edit</a>
                                    <a type="button" class="btn btn-danger" href="{{ route('kelola_kategori_berita.destroy', $kategori->id) }}" onclick="hapus(event, this)"><i class="fe fe-trash"></i> Delete</a>
                                </td>
                                @else
                                <td></td>
                                @endif
                            </tr>
                        @endforeach

                        @else
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        <i class="fe fe-alert-circle"></i> Tidak ada data yang ditemukan.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <nav aria-label="Table Paging" class="mb-0 text-muted">
                        <ul class="pagination justify-content-center mb-0">
                            {{-- Previous Page Link --}}
                            @if ($kategori_beritas->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $kategori_beritas->previousPageUrl() }}" rel="prev">Previous</a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($kategori_beritas->getUrlRange(1, $kategori_beritas->lastPage()) as $page => $url)
                                @if ($page == $kategori_beritas->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($kategori_beritas->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $kategori_beritas->nextPageUrl() }}" rel="next">Next</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>

        <!-- customized table -->
    </div>
</main>

<form action="" method="POST" id="frmHapus">
    @method('DELETE')
    @csrf
</form>

{{-- <div class="invisible" id="status">@isset($status) {{$status}} @endisset</div> --}}
<div class="invisible" id="pesan">@isset($pesan) {{$pesan}} @endisset</div>

<script>
    const body = document.getElementById('body');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const frm = document.getElementById('frmHapus');

    function tampil_pesan(){
        let pesan = "{{ session('pesan') }}";
        let error = "{{ session('error') }}";

        if (pesan.trim() !== '') {
            swal('Good Job', pesan.trim(), 'success');
        }

        if (error.trim() !== '') {
            swal('Error', error.trim(), 'error');
        }
        // if(pesan.innerHTML.trim() !== ''){
        // swal('Good Job', pesan.innerHTML, 'success')
        // // }else if(status.innerHTML.trim() === 'edit'){
        // // swal('Good Job', pesan.innerHTML, 'success')
        // }
    }

    function hapus(event, el){
        event.preventDefault()
        swal({
        title: "Anda Yakin?",
        text: "Anda Akan Menghapus Data Kategori Wisata Ini Secara Permanen!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Iya, Hapus Itu!",
        closeOnConfirm: false
        },
        function(){

            frm.setAttribute('action', el.getAttribute('href'))
            frm.submit()
        });
    }

    body.onload = function(){
        tampil_pesan()
    }

</script>
@endsection
