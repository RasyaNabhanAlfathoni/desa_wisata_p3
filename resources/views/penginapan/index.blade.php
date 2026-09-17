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
                        <h2 class="h3 mb-3">Daftar Penginapan</h2>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        @if ($title == 'Admin')
                        <a href="{{ route('kelola_penginapan.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus mr-1"></i>Tambah
                        </a>
                        @else
                        <a href="{{ route('kelola_penginapan.create') }}" class="btn disabled">
                        </a>
                        @endif
                        <form class="form">
                            <div class="form-group mb-0">
                                <label for="search1" class="sr-only">Search</label>
                                <input type="text" class="form-control" id="search1" placeholder="Search">
                            </div>
                        </form>
                    </div>

                    <form method="GET" action="{{ route('kelola_penginapan.index') }}">
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
                                <th>Nama Penginapan</th>
                                <th>Deskripsi Penginapan</th>
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
                            @if($penginapans->count() > 0)
                            @foreach($penginapans as $index => $penginapan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $penginapan->nama_penginapan }}</td>
                                @if(strlen($penginapan->deskripsi) > 20)
                                <td style="cursor: pointer"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$penginapan->deskripsi}}">
                                    <p class="mb-0">{{substr($penginapan->deskripsi, 0, 20) . '...'}}</p>
                                </td>
                                @else
                                <td><p class="mb-0">{{ $penginapan->deskripsi }}</p></td>
                                @endif
                                @if(strlen($penginapan->fasilitas) > 20)
                                <td style="cursor: pointer"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$penginapan->fasilitas}}">
                                    <p class="mb-0">{{substr($penginapan->fasilitas, 0, 20) . '...'}}</p>
                                </td>
                                @else
                                <td><p class="mb-0">{{ $penginapan->fasilitas }}</p></td>
                                @endif
                                @foreach(['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto)
                                    <td>
                                        @if(!empty($penginapan->$foto) && file_exists(public_path('storage/' . $penginapan->$foto)))
                                            <div class="avatar avatar-md">
                                                <img src="{{ asset('storage/' . $penginapan->$foto) }}" alt="Foto Paket" class="img-thumbnail rounded" style="cursor: pointer;"
                                                onclick="showModal(this)">
                                            </div>
                                        @else
                                            {{-- <p class="text-muted">Tidak ada foto</p> --}}
                                            <div class="avatar avatar-md">
                                                <img src="{{asset('back-end/assets/avatars/no-imag.jpg')}}" alt="P" class="img-thumbnail rounded" style="cursor: pointer;"
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
                                        <a class="dropdown-item text-warning" href="{{ route('kelola_penginapan.edit', $penginapan->id) }}"><i class="fe fe-edit mr-1"></i>Edit</a>
                                        <a class="dropdown-item text-danger" href="{{ route('kelola_penginapan.destroy', $penginapan->id) }}" type="button" onclick="hapus(event, this)">
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
                            @if ($penginapans->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $penginapans->previousPageUrl() }}" rel="prev">Previous</a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($penginapans->getUrlRange(1, $penginapans->lastPage()) as $page => $url)
                                @if ($page == $penginapans->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($penginapans->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $penginapans->nextPageUrl() }}" rel="next">Next</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Modal untuk menampilkan gambar -->
            <div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Foto Penginapan</h5>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="fotoPreview" src="" alt="Foto Pelanggan" class="img-fluid rounded shadow">
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
        text: "Anda Akan Menghapus Data Penginapan Ini Secara Permanen!",
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
