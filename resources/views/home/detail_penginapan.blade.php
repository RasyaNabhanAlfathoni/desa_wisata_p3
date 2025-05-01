@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection
@section('content')
<!-- Hero Banner with Overlay and Text -->
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('front-end/images/lsp/wisata/hutan bambu/panglipuran-bamboo-forest.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
                    <span class="mr-2"><a href="{{ route('home') }}">{{ $title }}</a></span>|
                    <span><a href="{{ route('penginapan') }}">Penginapan</a></span>|
                    <span>{{ $title2 }}</span>
                </p>
                <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">{{ $penginapan->nama_penginapan }}</h1>
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
                    <div id="penginapanCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach(['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $index => $foto)
                                @if(!empty($penginapan->$foto) && file_exists(public_path('storage/' . $penginapan->$foto)))
                                    <li data-target="#penginapanCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                @endif
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @php $active = true; @endphp
                            @foreach(['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto)
                                @if(!empty($penginapan->$foto) && file_exists(public_path('storage/' . $penginapan->$foto)))
                                    <div class="carousel-item {{ $active ? 'active' : '' }}" style="height: 400px;">
                                        <img src="{{ asset('storage/' . $penginapan->$foto) }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Foto Penginapan">
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
                        <a class="carousel-control-prev" href="#penginapanCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#penginapanCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>

                <!-- Penginapan Details -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="card-title font-weight-bold mb-0">{{ $penginapan->nama_penginapan }}</h2>
                        </div>

                        <hr>

                        <h4 class="font-weight-bold mb-3">Deskripsi</h4>
                        <p style="text-align: justify;">{{ $penginapan->deskripsi }}</p>

                        <h4 class="font-weight-bold mb-3 mt-4">Fasilitas</h4>
                        <div class="bg-light p-3 rounded">
                            <ul class="list-group list-group-flush bg-transparent">
                                @foreach(explode(',', $penginapan->fasilitas) as $fasilitas)
                                    <li class="list-group-item bg-transparent pl-0"><i class="icon-check text-success mr-2"></i>{{ trim($fasilitas) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan (4 Grids) -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="alert alert-info" role="alert">
                            <h5 class="font-weight-bold mb-1">Kontak Penginapan:</h5>
                            <p class="mb-0">
                                Hubungi penginapan untuk informasi lebih lanjut
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="font-weight-bold mb-3">Tips Menginap</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="icon-check-circle text-success mr-2"></i>
                                Bawa perlengkapan pribadi yang diperlukan
                            </li>
                            <li class="mb-2">
                                <i class="icon-check-circle text-success mr-2"></i>
                                Patuhi peraturan penginapan
                            </li>
                            <li class="mb-2">
                                <i class="icon-check-circle text-success mr-2"></i>
                                Jaga kebersihan kamar
                            </li>
                            <li class="mb-2">
                                <i class="icon-check-circle text-success mr-2"></i>
                                Gunakan fasilitas dengan bijak
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Penginapan as Full Width Carousel -->
@if($relatedPenginapans->count() > 0)
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-start mb-5 pb-3">
            <div class="col-md-7 heading-section">
                <h2 class="mb-4"><strong>Penginapan</strong> Terkait</h2>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Carousel dengan indikator, kontrol, dan opsi data-* dari Bootstrap 4 -->
        <div id="relatedPenginapanCarousel" class="carousel slide" data-ride="carousel" data-interval="5000" data-pause="hover">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach($relatedPenginapans->chunk(3) as $index => $chunk)
                    <li data-target="#relatedPenginapanCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner shadow-sm rounded">
                @foreach($relatedPenginapans->chunk(3) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row mx-0">
                            @foreach($chunk as $penginapan)
                                <div class="col-md-4 p-3">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <a href="{{ route('penginapan.detail', $penginapan->id) }}">
                                            <div class="bg-image rounded-top" style="background-image: url('{{ asset('storage/' . $penginapan->foto1) }}'); height: 250px; background-size: cover; background-position: center;">
                                                <div class="d-flex justify-content-center align-items-center h-100 bg-dark-transparent">
                                                    <span class="icon-search2 text-white"></span>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="card-title">
                                                        <a href="{{ route('penginapan.detail', $penginapan->id) }}" class="text-dark">{{ $penginapan->nama_penginapan }}</a>
                                                    </h5>
                                                </div>
                                            </div>
                                            <p class="card-text text-muted">{{ Str::limit($penginapan->deskripsi, 30) }}</p>
                                            <hr>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted"><i class="icon-map-o"></i> {{ Str::limit($penginapan->fasilitas, 25) }}</small>
                                                <a href="{{ route('penginapan.detail', $penginapan->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
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
            <a class="carousel-control-prev" href="#relatedPenginapanCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#relatedPenginapanCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <!-- Navigation buttons alternatif di bawah carousel (Bootstrap 4 native) -->
        <div class="d-flex justify-content-center mt-4">
            <div class="btn-group" role="group" aria-label="Carousel Navigation">
                <button type="button" class="btn btn-outline-primary" data-target="#relatedPenginapanCarousel" data-slide="prev">
                    <i class="icon-chevron-left"></i> Sebelumnya
                </button>
                <button type="button" class="btn btn-outline-primary" data-target="#relatedPenginapanCarousel" data-slide="next">
                    Berikutnya <i class="icon-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Script Bootstrap 4 Native untuk fungsionalitas tambahan -->
<script>
$(document).ready(function(){
    $('#relatedPenginapanCarousel').carousel({
        interval: 5000,
        pause: 'hover',
        wrap: true,
        keyboard: true
    });
});
</script>
@endif
@endsection
