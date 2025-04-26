{{-- home / detail_paket_wisata --}}

@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection
@section('content')
<!-- Hero Banner with Overlay and Text -->
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('front-end/images/lsp/wisata/warung kopi/snapedit_1717637144253-1597509247.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="{{route('pelanggan.index')}}">{{$title}}</a></span>| <span>{{$title2}}</span></p>
                <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">{{ $title2 }}</h1>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Image Gallery Carousel -->
                <div class="card shadow-sm border-0 overflow-hidden mb-4">
                    <div id="paketCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach(['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $index => $foto)
                                @if(!empty($paket->$foto) && file_exists(public_path('storage/' . $paket->$foto)))
                                    <li data-target="#paketCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                @endif
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @php $active = true; @endphp
                            @foreach(['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto)
                                @if(!empty($paket->$foto) && file_exists(public_path('storage/' . $paket->$foto)))
                                    <div class="carousel-item {{ $active ? 'active' : '' }}" style="height: 400px;">
                                        <img src="{{ asset('storage/' . $paket->$foto) }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Foto Paket Wisata">
                                    </div>
                                    @php $active = false; @endphp
                                @endif
                            @endforeach

                            @if($active)
                                <div class="carousel-item active" style="height: 400px;">
                                    <img src="{{asset('back-end/assets/avatars/no-imag.jpg')}}" class="d-block w-100 h-100" style="object-fit: cover;" alt="No Image Available">
                                </div>
                            @endif
                        </div>
                        <a class="carousel-control-prev" href="#paketCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#paketCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>

                <!-- Package Details -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="card-title font-weight-bold mb-0">{{ $paket->nama_paket }}</h2>
                            <span class="badge badge-success p-2" style="font-size: 1.2rem;">Rp{{ number_format($paket->harga_per_pack, 0, ',', '.') }}</span>
                        </div>

                        <hr>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary p-3 text-white mr-3">
                                        <i class="icon-calendar"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-weight-bold">Durasi</h6>
                                        <p class="mb-0">{{ $paket->durasi_hari }} Hari</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-info p-3 text-white mr-3">
                                        <i class="icon-user"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-weight-bold">Kuota Peserta</h6>
                                        <p class="mb-0">{{$paket->kuota_peserta}} Peserta</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-warning p-3 text-white mr-3">
                                        <i class="icon-dollar"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-weight-bold">Hitungan Harga</h6>
                                        <p class="mb-0">Per peserta</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="font-weight-bold mb-3">Deskripsi</h4>
                        <p style="text-align: justify;">{{ $paket->deskripsi }}</p>

                        <h4 class="font-weight-bold mb-3 mt-4">Fasilitas</h4>
                        <div class="bg-light p-3 rounded">
                            <ul class="list-group list-group-flush bg-transparent">
                                @foreach(explode(',', $paket->fasilitas) as $fasilitas)
                                    <li class="list-group-item bg-transparent pl-0"><i class="icon-check text-success mr-2"></i>{{ trim($fasilitas) }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-4">
                            @auth
                                <a href="{{ route('pelanggan.paket-wisata.reservasi', $paket->id) }}" class="btn btn-primary btn-lg btn-block">
                                    Pesan Paket Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg btn-block">
                                    Login untuk Memesan
                                </a>
                                <div class="text-center mt-2">
                                    <small>Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a></small>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan (4 Grids) -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h4 class="font-weight-bold mb-3">Dapatkan Diskon Menarik!</h4>
                        <p class="mb-4">
                            Nikmati potongan harga eksklusif dengan syarat minimal jumlah peserta.
                        </p>

                        <!-- Informasi Diskon -->
                        @if ($paket->nilai_diskon > 0)
                            <div class="alert alert-success mb-3" role="alert">
                                <h5 class="font-weight-bold mb-1">Diskon Spesial:</h5>
                                <p class="mb-0">
                                    <strong>{{ $paket->nilai_diskon }}%</strong> off jika Anda memesan dengan minimal <strong>{{ $paket->peserta_diskon }}</strong> peserta!
                                </p>
                            </div>
                        @else
                            <div class="alert alert-danger mb-3" role="alert">
                                <h5 class="font-weight-bold mb-1">Tidak Ada Diskon Saat Ini</h5>
                                <p class="mb-0">
                                    Maaf, saat ini tidak ada promo diskon tersedia untuk paket ini.
                                </p>
                            </div>
                        @endif

                        <!-- Tips dan Trik -->
                        <div class="mt-4">
                            <h5 class="font-weight-bold mb-2">Tips untuk Mendapatkan Diskon:</h5>
                            <ul class="list-unstyled">
                                <li>
                                    <i class="icon-check text-success mr-2"></i>
                                    Ajak teman atau keluarga untuk bergabung agar mencapai kuota minimal.
                                </li>
                                <li>
                                    <i class="icon-check text-success mr-2"></i>
                                    Booking lebih awal untuk mendapatkan harga terbaik.
                                </li>
                                <li>
                                    <i class="icon-check text-success mr-2"></i>
                                    Pantau halaman promosi kami untuk penawaran spesial lainnya.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Packages as Full Width Carousel -->
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-start mb-5 pb-3">
            <div class="col-md-7 heading-section">
                <h2 class="mb-4"><strong>Paket Wisata</strong> Terkait</h2>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Carousel dengan indikator, kontrol, dan opsi data-* dari Bootstrap 4 -->
        <div id="relatedPackagesCarousel" class="carousel slide" data-ride="carousel" data-interval="5000" data-pause="hover">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach($paketWisatas->chunk(3) as $index => $chunk)
                    <li data-target="#relatedPackagesCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner shadow-sm rounded">
                @foreach($paketWisatas->chunk(3) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row mx-0">
                            @foreach($chunk as $item)
                                <div class="col-md-4 p-3">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <a href="{{ route('pelanggan.paket-wisata.detail', $item->id) }}">
                                            <div class="bg-image rounded-top" style="background-image: url('{{ asset('storage/' . $item->foto1) }}'); height: 250px; background-size: cover; background-position: center;">
                                                <div class="d-flex justify-content-center align-items-center h-100 bg-dark-transparent">
                                                    <span class="icon-search2 text-white"></span>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="card-title">
                                                        <a href="{{ route('pelanggan.paket-wisata.detail', $item->id) }}" class="text-dark">{{ $item->nama_paket }}</a>
                                                    </h5>
                                                    <p class="text-success font-weight-bold h5 mb-2">Rp. {{ number_format($item->harga_per_pack, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                            <p class="card-text text-muted">{{ Str::limit($item->deskripsi, 30) }}</p>
                                            <hr>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted"><i class="icon-map-o"></i> {{ Str::limit($item->fasilitas, 25) }}</small>
                                                <a href="{{ route('pelanggan.paket-wisata.detail', $item->id) }}" class="btn btn-sm btn-outline-primary">Pesan</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <a class="carousel-control-prev" href="#relatedPackagesCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#relatedPackagesCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <!-- Navigation buttons alternatif di bawah carousel (Bootstrap 4 native) -->
        <div class="d-flex justify-content-center mt-4">
            <div class="btn-group" role="group" aria-label="Carousel Navigation">
                <button type="button" class="btn btn-outline-primary" data-target="#relatedPackagesCarousel" data-slide="prev">
                    <i class="icon-chevron-left"></i> Sebelumnya
                </button>
                <button type="button" class="btn btn-outline-primary" data-target="#relatedPackagesCarousel" data-slide="next">
                    Berikutnya <i class="icon-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Script Bootstrap 4 Native untuk fungsionalitas tambahan -->
<script>
$(document).ready(function(){
    $('#relatedPackagesCarousel').carousel({
        interval: 5000,
        pause: 'hover',
        wrap: true,
        keyboard: true
    });
});
</script>
@endsection
