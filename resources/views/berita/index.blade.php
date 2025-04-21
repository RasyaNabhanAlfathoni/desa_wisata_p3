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
                        <h2 class="h3 mb-3">Daftar Berita</h2>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('kelola_berita.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus mr-1"></i>Tambah
                        </a>
                        <form class="form">
                            <div class="form-group mb-0">
                                <label for="search1" class="sr-only">Search</label>
                                <input type="text" class="form-control" id="search1" placeholder="Search">
                            </div>
                        </form>
                    </div>

                    <form method="GET" action="{{ route('kelola_berita.index') }}">
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

                            <div class="d-flex align-items-center">
                                <!-- Filter Status -->
                                <select name="kategori" class="form-control form-control-sm mr-3 rounded" onchange="this.form.submit()">
                                    <option value="" {{ request('berita') == '' ? 'selected' : '' }}>Semua Kategori</option>
                                    @foreach ($kategori_beritas as $kategori)
                                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->kategori_berita }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul Berita</th>
                                <th>Isi Berita</th>
                                <th>Tanggal Post</th>
                                <th>Kategori Berita</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($beritas->count() > 0)
                            @foreach ($beritas as $index => $berita)
                            <tr>
                                <td><p class="mb-0">{{ ($beritas->currentPage() - 1) * $beritas->perPage() + $index + 1 }}</p></td>
                                @if(strlen($berita->judul) > 20)
                                <td style="cursor: pointer"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$berita->judul}}">
                                    <p class="mb-0">{{substr($berita->judul, 0, 20) . '...'}}</p>
                                </td>
                                @else
                                <td><p class="mb-0">{{ $berita->judul }}</p></td>
                                @endif
                                @if(strlen($berita->berita) > 20)
                                <td style="cursor: pointer"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$berita->berita}}">
                                    <p class="mb-0">{{substr($berita->berita, 0, 20) . '...'}}</p>
                                </td>
                                @else
                                <td><p class="mb-0">{{ $berita->berita }}</p></td>
                                @endif
                                <td><p class="mb-0">{{ $berita->tgl_post->format('d/m/Y H:i') }}</p></td>
                                <td><p class="mb-0">{{ $berita->kategori->kategori_berita }}</p></td>
                                <td>
                                    <div class="avatar avatar-md">
                                        <img src="{{ !empty($berita->foto) && file_exists(public_path('storage/' . $berita->foto)) ? asset('storage/' . $berita->foto) : asset('back-end/assets/avatars/no-imag.jpg') }}"
                                             alt="P" class="img-thumbnail rounded"
                                             style="cursor: pointer;"
                                             onclick="showModal(this)">
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted sr-only">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item text-warning" href="{{ route('kelola_berita.edit', $berita->id) }}"><i class="fe fe-edit mr-1"></i>Edit</a>
                                        <a class="dropdown-item text-danger" href="{{ route('kelola_berita.destroy', $berita->id) }}" type="button" onclick="hapus(event, this)">
                                            <i class="fe fe-trash mr-1"></i>Delete
                                        </a>
                                    </div>
                                </td>
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
                            @if ($beritas->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $beritas->previousPageUrl() }}" rel="prev">Previous</a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($beritas->getUrlRange(1, $beritas->lastPage()) as $page => $url)
                                @if ($page == $beritas->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($beritas->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $beritas->nextPageUrl() }}" rel="next">Next</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                        </ul>
                    </nav>

                    <!-- Modal untuk menampilkan gambar -->
                    <div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Foto Berita</h5>
                                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="fotoPreview" src="" alt="Foto Berita" class="img-fluid rounded shadow">
                                </div>
                            </div>
                        </div>
                    </div>

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
        text: "Anda Akan Menghapus Data Berita Ini Secara Permanen!",
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

<script>
    function showModal(imgElement) {
        const modalImage = document.getElementById("fotoPreview");
        modalImage.src = imgElement.src;
        const modal = new bootstrap.Modal(document.getElementById("modalFoto"));
        modal.show();
    }
</script>
@endsection
