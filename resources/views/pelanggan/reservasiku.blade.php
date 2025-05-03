@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('content')
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('front-end/images/lsp/wisata/jalanan utama/Penglipuran.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
                    <span class="mr-2"><a href="{{route('pelanggan.index')}}">Home</a></span> |
                    <span>Reservasiku</span>
                </p>
                <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Daftar Reservasi Saya</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0 text-center text-white"><i class="icon-calendar mr-2"></i> Riwayat Reservasi Saya</h4>
                    </div>
                    <div class="card-body p-4">
                        @if(session('pesan'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="icon-check"></i> {{ session('pesan') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="icon-warning"></i> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if($reservasis->isEmpty())
                            <div class="text-center py-5">
                                <i class="icon-calendar text-muted" style="font-size: 5rem;"></i>
                                <h4 class="mt-3">Anda belum memiliki reservasi</h4>
                                <p class="text-muted">Mulailah menjelajahi paket wisata kami dan buat reservasi pertama Anda!</p>
                                <a href="{{ route('pelanggan.paket_wisata') }}" class="btn btn-primary mt-3">
                                    <i class="icon-search mr-2"></i> Cari Paket Wisata
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Paket Wisata</th>
                                            <th>Tanggal</th>
                                            <th>Peserta</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reservasis as $reservasi)
                                        <tr>
                                            <td>#{{ $reservasi->id }}</td>
                                            <td>
                                                <a href="{{ route('pelanggan.paket-wisata.detail', $reservasi->paket->id) }}" class="font-weight-bold">
                                                    {{ $reservasi->paket->nama_paket }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ date('d M Y', strtotime($reservasi->tgl_reservasi_mulai)) }}<br>
                                                s/d {{ date('d M Y', strtotime($reservasi->tgl_reservasi_akhir)) }}
                                            </td>
                                            <td>{{ $reservasi->jumlah_peserta }} orang</td>
                                            <td>Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $statusClass = '';
                                                    switch($reservasi->status_reservasi_wisata) {
                                                        case 'pesan':
                                                            $statusClass = 'badge-info';
                                                            break;
                                                        case 'dibayar':
                                                            $statusClass = 'badge-primary';
                                                            break;
                                                        case 'dikonfirmasi':
                                                            $statusClass = 'badge-success';
                                                            break;
                                                        case 'dibatalkan':
                                                            $statusClass = 'badge-danger';
                                                            break;
                                                        case 'selesai':
                                                            $statusClass = 'badge-secondary';
                                                            break;
                                                        default:
                                                            $statusClass = 'badge-warning';
                                                    }
                                                @endphp
                                                <span class="badge {{ $statusClass }}">
                                                    {{ ucfirst($reservasi->status_reservasi_wisata) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('pelanggan.paket-wisata.reservasi.detail', $reservasi->id) }}"
                                                       class="btn btn-sm btn-info mr-2"
                                                       title="Detail Reservasi">
                                                        <i class="icon-eye"></i>
                                                    </a>

                                                    @if(is_null($reservasi->file_bukti_tf) && $reservasi->status_reservasi_wisata == 'pesan')
                                                        <a href="{{ route('pelanggan.paket-wisata.pembayaran', $reservasi->id) }}"
                                                           class="btn btn-sm btn-warning mr-2"
                                                           title="Lanjutkan Pembayaran">
                                                            <i class="icon-credit-card"></i>
                                                        </a>
                                                    @endif

                                                    @if(in_array($reservasi->status_reservasi_wisata, ['pesan', 'dibayar']))
                                                        <form id="frmHapus{{ $reservasi->id }}"
                                                              action="{{ route('pelanggan.paket-wisata.reservasi.batal', $reservasi->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                    onclick="hapus(event, this)"
                                                                    class="btn btn-sm btn-danger"
                                                                    title="Batalkan Reservasi">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $reservasis->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
    }

    function hapus(event, el){
        event.preventDefault();
        const form = el.closest('form');

        swal({
            title: "Anda Yakin?",
            text: "Anda Akan Membatalkan Reservasi Ini!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Iya, Batalkan!",
            closeOnConfirm: false
        },
        function(){
            form.submit();
        });
    }

    body.onload = function(){
        tampil_pesan();
    }
</script>

<style>
    /* .badge {
        padding: 0.5em 0.75em;
        font-size: 0.875rem;
        font-weight: 500;
    } */

    .table th, .table td {
        vertical-align: middle;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
    }

    .pagination {
        justify-content: center;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .pagination .page-link {
        color: #007bff;
    }
</style>
@endsection
