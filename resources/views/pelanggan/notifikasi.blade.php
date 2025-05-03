{{-- pelanggan / notifikasi.blade.php --}}
@extends('fe.master')

@section('navbar')
    @include('fe.navbar')
@endsection

@section('content')
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('front-end/images/lsp/wisata/jalanan utama/1018586_720 (1).jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
            <div class="col-md-9 ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                <h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><strong>Notifikasi<br></strong> Anda</h1>
                <p data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Lihat semua aktivitas terbaru terkait reservasi, paket wisata, dan berita dalam sebulan terakhir</p>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 py-5 ftco-animate">
                <div class="heading-section mb-4 text-center">
                    <span class="subheading">Aktivitas Terkini</span>
                    <h2 class="mb-4"><strong>Semua Notifikasi</strong></h2>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-5">
                        <ul class="nav nav-tabs mb-4" id="notificationTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="reservasi-tab" data-toggle="tab" href="#reservasi" role="tab" aria-controls="reservasi" aria-selected="true">
                                    <span class="fas fa-receipt mr-2"></span>Reservasi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paket-tab" data-toggle="tab" href="#paket" role="tab" aria-controls="paket" aria-selected="false">
                                    <span class="fas fa-map-marked mr-2"></span>Paket Wisata
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="berita-tab" data-toggle="tab" href="#berita" role="tab" aria-controls="berita" aria-selected="false">
                                    <span class="fas fa-newspaper mr-2"></span>Berita
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content bg-white p-4 shadow-sm" id="notificationTabContent">
                            <!-- Reservasi Tab -->
                            <div class="tab-pane fade show active" id="reservasi" role="tabpanel" aria-labelledby="reservasi-tab">
                                <div class="list-group list-group-flush">
                                    @forelse($notif_reservasi as $reservasi)
                                        <div class="list-group-item list-group-item-action border-bottom py-3">
                                            <div class="d-flex w-100 justify-content-between align-items-center">
                                                <div>
                                                    <h5 class="mb-1">
                                                        @if($reservasi->status_reservasi_wisata == 'pesan')
                                                            <span class="badge badge-primary">Diproses</span>
                                                        @elseif($reservasi->status_reservasi_wisata == 'dibayar')
                                                            <span class="badge badge-success">Dikonfirmasi</span>
                                                        @elseif($reservasi->status_reservasi_wisata == 'dibatalkan')
                                                            <span class="badge badge-danger">Dibatalkan</span>
                                                        @else
                                                            <span class="badge badge-secondary">{{ $reservasi->status_reservasi_wisata }}</span>
                                                        @endif
                                                        Reservasi - {{ $reservasi->paket->nama_paket }}
                                                    </h5>
                                                    <p class="mb-1"><i class="icon-calendar mr-2"></i>Berangkat: {{ $reservasi->tgl_reservasi_mulai }}</p>
                                                    <p class="mb-1"><i class="icon-calendar mr-2"></i>Pulang: {{ $reservasi->tgl_reservasi_selesai }}</p>
                                                    <p class="mb-1"><i class="icon-users mr-2"></i>Peserta: {{ $reservasi->jumlah_peserta }}</p>
                                                </div>
                                                <small class="text-muted">{{ $reservasi->created_at->format('d M Y H:i') }}</small>
                                            </div>
                                            <div class="mt-2 text-right">
                                                <a href="{{ route('pelanggan.paket-wisata.reservasi.detail', $reservasi->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="icon-eye mr-1"></i> Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-5">
                                            <span class="fas fa-inbox fa-3x mb-3"></span>
                                            <h4>Belum ada notifikasi reservasi</h4>
                                            <p>Anda akan menerima notifikasi ketika ada pembaruan reservasi</p>
                                        </div>
                                    @endforelse
                                </div>
                                @if($notif_reservasi->hasPages())
                                <div class="row mt-4">
                                    <div class="col text-center">
                                        <div class="d-flex justify-content-center">
                                            {{ $notif_reservasi->links('pagination::bootstrap-4') }}
                                        </div>
                                        <style>
                                            .pagination .page-item.active .page-link {
                                                background-color: #dc3545;
                                                border-color: #dc3545;
                                            }
                                            .pagination .page-link {
                                                color: #dc3545;
                                            }
                                        </style>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Paket Wisata Tab -->
                            <div class="tab-pane fade" id="paket" role="tabpanel" aria-labelledby="paket-tab">
                                <div class="list-group list-group-flush">
                                    @forelse($notif_paket_wisata as $paket)
                                        <div class="list-group-item list-group-item-action border-bottom py-3">
                                            <div class="d-flex w-100 justify-content-between align-items-center">
                                                <div>
                                                    <h5 class="mb-1">{{ $paket->nama_paket }}</h5>
                                                    <p class="mb-1"><i class="icon-info mr-2"></i>{{ Str::limit($paket->deskripsi, 100) }}</p>
                                                    <p class="mb-0">
                                                        <span class="badge badge-success"><i class="icon-credit-card mr-1"></i>{{ number_format($paket->harga_per_pack, 0, ',', '.') }} IDR</span>
                                                        <span class="badge badge-info"><i class="icon-clock-o mr-1"></i>{{ $paket->durasi_hari }} Hari</span>
                                                    </p>
                                                </div>
                                                <small class="text-muted">{{ $paket->created_at->format('d M Y H:i') }}</small>
                                            </div>
                                            <div class="mt-2 text-right">
                                                <a href="{{ route('pelanggan.paket-wisata.detail', $paket->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="icon-eye mr-1"></i> Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-5">
                                            <span class="fas fa-map fa-3x mb-3"></span>
                                            <h4>Belum ada paket wisata baru</h4>
                                            <p>Anda akan menerima notifikasi ketika ada paket wisata terbaru</p>
                                        </div>
                                    @endforelse
                                </div>
                                @if($notif_paket_wisata->hasPages())
                                <div class="row mt-4">
                                    <div class="col text-center">
                                        <div class="d-flex justify-content-center">
                                            {{ $notif_paket_wisata->links('pagination::bootstrap-4') }}
                                        </div>
                                        <style>
                                            .pagination .page-item.active .page-link {
                                                background-color: #dc3545;
                                                border-color: #dc3545;
                                            }
                                            .pagination .page-link {
                                                color: #dc3545;
                                            }
                                        </style>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Berita Tab -->
                            <div class="tab-pane fade" id="berita" role="tabpanel" aria-labelledby="berita-tab">
                                <div class="list-group list-group-flush">
                                    @forelse($notif_berita as $berita)
                                        <div class="list-group-item list-group-item-action border-bottom py-3">
                                            <div class="d-flex w-100 justify-content-between align-items-center">
                                                <div>
                                                    <h5 class="mb-1">{{ $berita->judul }}</h5>
                                                    <p class="mb-1"><i class="icon-file-text mr-2"></i>{{ Str::limit($berita->berita, 150) }}</p>
                                                </div>
                                                <small class="text-muted">{{ $berita->created_at->format('d M Y H:i') }}</small>
                                            </div>
                                            <div class="mt-2 text-right">
                                                <a href="{{ route('pelanggan.berita.detail', $berita->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="icon-book mr-1"></i> Baca Selengkapnya
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-5">
                                            <span class="fas fa-newspaper fa-3x mb-3"></span>
                                            <h4>Belum ada berita baru</h4>
                                            <p>Anda akan menerima notifikasi ketika ada berita terbaru</p>
                                        </div>
                                    @endforelse
                                </div>
                                @if($notif_berita->hasPages())
                                <div class="row mt-4">
                                    <div class="col text-center">
                                        <div class="d-flex justify-content-center">
                                            {{ $notif_berita->links('pagination::bootstrap-4') }}
                                        </div>
                                        <style>
                                            .pagination .page-item.active .page-link {
                                                background-color: #dc3545;
                                                border-color: #dc3545;
                                            }
                                            .pagination .page-link {
                                                color: #dc3545;
                                            }
                                        </style>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
