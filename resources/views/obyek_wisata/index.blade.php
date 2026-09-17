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
                        <h2 class="h3 mb-3">Daftar Obyek Wisata</h2>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        @if ($title == 'Admin')
                        <a href="{{ route('kelola_obyek_wisata.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus mr-1"></i>Tambah
                        </a>
                        @else
                        <a href="{{ route('kelola_obyek_wisata.create') }}" class="btn disabled">
                        </a>
                        @endif
                        <form class="form">
                            <div class="form-group mb-0">
                                <label for="search1" class="sr-only">Search</label>
                                <input type="text" class="form-control" id="search1" placeholder="Search">
                            </div>
                        </form>
                    </div>

                    <form method="GET" action="{{ route('kelola_obyek_wisata.index') }}">
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
                                    <option value="" {{ request('kategori') == '' ? 'selected' : '' }}>Semua Kategori</option>
                                    @foreach ($kategori_wisatas as $kategori)
                                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->kategori_wisata }}
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
                                <th>Nama Wisata</th>
                                <th>Deskripsi Wisata</th>
                                <th>Kategori Wisata</th>
                                <th>Fasilitas</th>
                                <th>Foto 1</th>
                                <th>Foto 2</th>
                                <th>Foto 3</th>
                                <th>Foto 4</th>
                                <th>Foto 5</th>
                                @if ($title == 'Admin')
                                <th>Aksi</th>
                                @else
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if($obyek_wisatas->count() > 0)
                            @foreach ($obyek_wisatas as $index => $obyek)
                            <tr>
                                <td><p class="mb-0">{{ ($obyek_wisatas->currentPage() - 1) * $obyek_wisatas->perPage() + $index + 1 }}</p></td>
                                <td><p class="mb-0">{{ $obyek->nama_wisata }}</p></td>

                                @if(strlen($obyek->deskripsi_wisata) > 20)
                                <td style="cursor: pointer"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$obyek->deskripsi_wisata}}">
                                    <p class="mb-0">{{substr($obyek->deskripsi_wisata, 0, 20) . '...'}}</p>
                                </td>
                                @else
                                <td><p class="mb-0">{{ $obyek->deskripsi_wisata }}</p></td>
                                @endif

                                @if(strlen($obyek->kategori->kategori_wisata) > 20)
                                <td style="cursor: pointer"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$obyek->kategori->kategori_wisata}}">
                                    <p class="mb-0">{{substr($obyek->kategori->kategori_wisata, 0, 20) . '...'}}</p>
                                </td>
                                @else
                                <td><p class="mb-0">{{ $obyek->kategori->kategori_wisata }}</p></td>
                                @endif

                                @if(strlen($obyek->fasilitas) > 20)
                                <td style="cursor: pointer"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$obyek->fasilitas}}">
                                    <p class="mb-0">{{substr($obyek->fasilitas, 0, 20) . '...'}}</p>
                                </td>
                                @else
                                <td><p class="mb-0">{{ $obyek->fasilitas }}</p></td>
                                @endif

                                @foreach(['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto)
                                    <td>
                                        @if(!empty($obyek->$foto) && file_exists(public_path('storage/' . $obyek->$foto)))
                                            <div class="avatar avatar-md">
                                                <img src="{{ asset('storage/' . $obyek->$foto) }}" alt="Foto Paket" class="img-thumbnail rounded" style="cursor: pointer;"
                                                    onclick="showModal(this)">
                                            </div>
                                        @else
                                            <div class="avatar avatar-md">
                                                <img src="{{ asset('back-end/assets/avatars/no-imag.jpg') }}" alt="Tidak Ada Foto" class="img-thumbnail rounded" style="cursor: pointer;"
                                                    onclick="showModal(this)">
                                            </div>
                                        @endif
                                    </td>
                                @endforeach

                                @if ($title == 'Admin')
                                <td>
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted sr-only">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item text-warning" href="{{ route('kelola_obyek_wisata.edit', $obyek->id) }}"><i class="fe fe-edit mr-1"></i>Edit</a>
                                        <a class="dropdown-item text-danger" href="{{ route('kelola_obyek_wisata.destroy', $obyek->id) }}" type="button" onclick="hapus(event, this)">
                                            <i class="fe fe-trash mr-1"></i>Delete
                                        </a>
                                    </div>
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
                            @if ($obyek_wisatas->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $obyek_wisatas->previousPageUrl() }}" rel="prev">Previous</a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($obyek_wisatas->getUrlRange(1, $obyek_wisatas->lastPage()) as $page => $url)
                                @if ($page == $obyek_wisatas->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($obyek_wisatas->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $obyek_wisatas->nextPageUrl() }}" rel="next">Next</a></li>
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
                                    <h5 class="modal-title" id="modalLabel">Foto Pelanggan</h5>
                                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="fotoPreview" src="" alt="Foto Pelanggan" class="img-fluid rounded shadow">
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
        text: "Anda Akan Menghapus Data Obyek Wisata Ini Secara Permanen!",
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
