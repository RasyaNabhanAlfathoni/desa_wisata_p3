@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('content')
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('storage/' . $reservasi->paket->foto1) }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
                    <span class="mr-2"><a href="{{route('pelanggan.index')}}">Home</a></span> |
                    <span class="mr-2"><a href="{{route('pelanggan.reservasiku')}}">Reservasiku</a></span> |
                    <span>Detail Reservasi #{{ $reservasi->id }}</span>
                </p>
                <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Detail Reservasi</h1>
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
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-white"><i class="icon-calendar mr-2"></i> Detail Reservasi #{{ $reservasi->id }}</h4>
                            <span class="badge badge-light">
                                @php
                                    $statusClass = '';
                                    switch($reservasi->status_reservasi_wisata) {
                                        case 'pesan':
                                            $statusClass = 'text-info';
                                            break;
                                        case 'dibayar':
                                            $statusClass = 'text-primary';
                                            break;
                                        case 'dikonfirmasi':
                                            $statusClass = 'text-success';
                                            break;
                                        case 'dibatalkan':
                                            $statusClass = 'text-danger';
                                            break;
                                        case 'selesai':
                                            $statusClass = 'text-secondary';
                                            break;
                                        default:
                                            $statusClass = 'text-warning';
                                    }
                                @endphp
                                <span class="{{ $statusClass }} font-weight-bold">
                                    {{ ucfirst($reservasi->status_reservasi_wisata) }}
                                </span>
                            </span>
                        </div>
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

                        <div class="row">
                            <!-- Kolom Kiri - Informasi Paket -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="icon-gift mr-2"></i> Paket Wisata</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('storage/' . $reservasi->paket->foto1) }}"
                                                 alt="{{ $reservasi->paket->nama_paket }}"
                                                 class="img-fluid rounded"
                                                 style="max-height: 200px;">
                                        </div>
                                        <h4 class="text-center">{{ $reservasi->paket->nama_paket }}</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong><i class="icon-calendar mr-2"></i> Durasi:</strong></p>
                                                <p>{{ $reservasi->paket->durasi_hari }} Hari</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong><i class="icon-tag mr-2"></i> Harga per orang:</strong></p>
                                                <p>Rp {{ number_format($reservasi->paket->harga_per_pack, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <p><strong><i class="icon-info mr-2"></i> Deskripsi:</strong></p>
                                            <p>{{ $reservasi->paket->deskripsi }}</p>
                                        </div>
                                        <div class="mt-3">
                                            <p><strong><i class="icon-list mr-2"></i> Fasilitas:</strong></p>
                                            <ul>
                                                @foreach(explode(',', $reservasi->paket->fasilitas) as $fasilitas)
                                                <li>{{ trim($fasilitas) }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan - Detail Reservasi -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="icon-calendar mr-2"></i> Detail Reservasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <h5 class="border-bottom pb-2"><i class="icon-user mr-2"></i> Data Pelanggan</h5>
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="{{ asset($pelanggan->foto ? 'storage/' . $pelanggan->foto : 'back-end/assets/avatars/default.png') }}"
                                                     alt="Profil"
                                                     class="rounded-circle mr-3"
                                                     width="60"
                                                     height="60">
                                                <div>
                                                    <h5 class="mb-0">{{ $pelanggan->nama_lengkap }}</h5>
                                                    <p class="mb-0 text-muted">{{ $pelanggan->user->email }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong><i class="icon-phone mr-2"></i> No. HP:</strong></p>
                                                    <p>{{ $pelanggan->no_hp }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong><i class="icon-location-pin mr-2"></i> Alamat:</strong></p>
                                                    <p>{{ $pelanggan->alamat }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <h5 class="border-bottom pb-2"><i class="icon-notebook mr-2"></i> Informasi Reservasi</h5>
                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <th width="40%">Tanggal Reservasi</th>
                                                            <td>: {{ date('d F Y', strtotime($reservasi->created_at)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Periode Wisata</th>
                                                            <td>: {{ date('d F Y', strtotime($reservasi->tgl_reservasi_mulai)) }} s/d {{ date('d F Y', strtotime($reservasi->tgl_reservasi_akhir)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Jumlah Peserta</th>
                                                            <td>: {{ $reservasi->jumlah_peserta }} orang</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Harga per orang</th>
                                                            <td>: Rp {{ number_format($reservasi->harga, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @if($reservasi->nilai_diskon > 0)
                                                        <tr class="text-success">
                                                            <th>Diskon ({{ $reservasi->nilai_diskon }}%)</th>
                                                            <td>: -Rp {{ number_format($reservasi->diskon, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @endif
                                                        <tr class="font-weight-bold">
                                                            <th>Total Bayar</th>
                                                            <td>: Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Bukti Pembayaran -->
                                        <div class="mb-4">
                                            <h5 class="border-bottom pb-2"><i class="icon-credit-card mr-2"></i> Pembayaran</h5>
                                            @if($reservasi->file_bukti_tf)
                                                <div class="alert alert-success">
                                                    <p><strong>Status Pembayaran:</strong>
                                                        @if($reservasi->status_reservasi_wisata == 'pesan')
                                                            <span class="badge badge-warning">Sedang Proses</span>
                                                        @elseif($reservasi->status_reservasi_wisata == 'dibayar')
                                                            <span class="badge badge-primary">Sudah Dikonfirmasi</span>
                                                        @elseif($reservasi->status_reservasi_wisata == 'dibatalkan')
                                                            <span class="badge badge-danger">Telah Dibatalkan</span>
                                                        @elseif($reservasi->status_reservasi_wisata == 'selesai')
                                                            <span class="badge badge-success">Selesai</span>
                                                        @endif
                                                    </p>
                                                    <p><strong>Bukti Transfer:</strong></p>
                                                    <a href="{{ asset('storage/' . $reservasi->file_bukti_tf) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-info">
                                                        <i class="icon-download mr-1"></i> Lihat Bukti Transfer
                                                    </a>

                                                    @if($reservasi->status_reservasi_wisata == 'pesan')
                                                        <button type="button"
                                                                class="btn btn-sm btn-warning mt-3"
                                                                data-toggle="modal"
                                                                data-target="#gantiBuktiModal">
                                                            <i class="icon-refresh mr-1"></i> Ganti Bukti Transfer
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                {{-- <div class="alert alert-warning">
                                                    <p><strong>Status Pembayaran:</strong>
                                                        <span class="badge badge-info">Belum Dibayar</span>
                                                    </p>
                                                    <p>Silakan lakukan pembayaran sebelum {{ date('d F Y H:i', strtotime($reservasi->created_at->addDays(1))) }}</p>
                                                    <a href="{{ route('pelanggan.paket-wisata.pembayaran', $reservasi->id) }}"
                                                       class="btn btn-sm btn-warning">
                                                        <i class="icon-credit-card mr-1"></i> Lanjutkan Pembayaran
                                                    </a>
                                                </div> --}}

                                                @if($reservasi->status_reservasi_wisata != 'dibatalkan')
                                                    <div class="alert alert-warning">
                                                        <p><strong>Status Pembayaran:</strong>
                                                            <span class="badge badge-info">Belum Dibayar</span>
                                                        </p>
                                                        <p>Silakan lakukan pembayaran sebelum {{ date('d F Y H:i', strtotime($reservasi->created_at->addDays(1))) }}</p>
                                                        <a href="{{ route('pelanggan.paket-wisata.pembayaran', $reservasi->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                            <i class="icon-credit-card mr-1"></i> Lanjutkan Pembayaran
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="alert alert-danger">
                                                        <p><strong>Status:</strong> Reservasi sudah {{ $reservasi->status_reservasi_wisata }}</p>
                                                        <p>Pembayaran tidak dapat dilakukan.</p>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>

                                        <!-- Modal Ganti Bukti Transfer -->
                                        <div class="modal fade" id="gantiBuktiModal" tabindex="-1" role="dialog" aria-labelledby="gantiBuktiModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="gantiBuktiModalLabel">Ganti Bukti Transfer</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('pelanggan.paket-wisata.update-bukti', $reservasi->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="file_bukti_tf">Upload Bukti Transfer Baru</label>
                                                                <input type="file" class="form-control-file" id="file_bukti_tf" name="file_bukti_tf" required>
                                                                <small class="form-text text-muted">
                                                                    Format: JPEG, PNG, JPG, PDF (Maksimal 3MB)
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tombol Aksi -->
                                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 gap-2">
                                            <a href="{{ route('pelanggan.reservasiku') }}" class="btn btn-secondary me-2 mb-2">
                                                <i class="icon-arrow-left me-2"></i> Kembali
                                            </a>

                                            @if(is_null($reservasi->file_bukti_tf) && $reservasi->status_reservasi_wisata == 'pesan')
                                                <a href="{{ route('pelanggan.paket-wisata.pembayaran', $reservasi->id) }}"
                                                class="btn btn-primary me-2 mb-2">
                                                    <i class="icon-credit-card me-2"></i> Bayar Sekarang
                                                </a>
                                            @endif

                                            @if(in_array($reservasi->status_reservasi_wisata, ['pesan', 'dibayar']))
                                                <form id="frmHapus"
                                                    action="{{ route('pelanggan.paket-wisata.reservasi.batal', $reservasi->id) }}"
                                                    method="POST" class="mb-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            onclick="hapus(event, this)"
                                                            class="btn btn-danger">
                                                        <i class="icon-trash me-2"></i> Batalkan Reservasi
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="invisible" id="pesan">@isset($pesan) {{$pesan}} @endisset</div>

<script>
    const body = document.getElementById('body');
    const pesan = document.getElementById('pesan');

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

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    .alert {
        border-radius: 8px;
    }

    .border-bottom {
        border-bottom: 1px solid #dee2e6 !important;
    }
</style>
@endsection
