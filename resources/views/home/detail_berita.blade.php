@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection
@section('content')
<!-- Hero Banner with Overlay and Text -->
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('storage/' . $berita->foto) }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
                    <span class="mr-2"><a href="{{ route('home') }}">{{ $title }}</a></span>|
                    <span><a href="{{ route('berita') }}">Berita</a></span>|
                    <span>{{ $title2 }}</span>
                </p>
                <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">{{ $berita->judul }}</h1>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Berita Content -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <span class="badge badge-info p-2">{{ $berita->kategori->kategori_berita }}</span>
                                <span class="text-muted ml-2"><i class="icon-calendar mr-1"></i> {{ $berita->tgl_post->format('d F Y') }}</span>
                            </div>
                            <div class="share-buttons">
                                <a href="#" class="btn btn-sm btn-outline-secondary"><i class="icon-facebook"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-secondary"><i class="icon-twitter"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-secondary"><i class="icon-instagram"></i></a>
                            </div>
                        </div>

                        <!-- News Photo -->
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/' . $berita->foto) }}" alt="{{ $berita->judul }}" class="img-fluid rounded" style="max-height: 500px; width: auto;">
                            <h2 class="mt-3 mb-4">{{ $berita->judul }}</h2>
                        </div>

                        <div class="berita-content text-justify">
                            {!! $berita->berita !!}
                        </div>
                    </div>
                </div>

                <!-- Related Berita -->
                @if($relatedBeritas->count() > 0)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h4 class="font-weight-bold mb-4">Berita Terkait</h4>
                        <div class="row">
                            @foreach($relatedBeritas as $related)
                            <div class="col-md-6 mb-4">
                                <div class="card border-0 h-100">
                                    <a href="{{ route('berita.detail', $related->id) }}">
                                        <img src="{{ asset('storage/' . $related->foto) }}" class="card-img-top" alt="{{ $related->judul }}" style="height: 200px; object-fit: cover;">
                                    </a>
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{ route('berita.detail', $related->id) }}" class="text-dark">{{ Str::limit($related->judul, 50) }}</a>
                                        </h5>
                                        <p class="card-text text-muted">{{ Str::limit(strip_tags($related->berita), 70) }}</p>
                                        <a href="{{ route('berita.detail', $related->id) }}" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                                    </div>
                                    <div class="card-footer bg-white border-0">
                                        <small class="text-muted"><i class="icon-calendar mr-1"></i> {{ $related->tgl_post->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <!-- Recent Posts -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h4 class="font-weight-bold mb-3">Berita Terbaru</h4>
                        @foreach($recentBeritas as $recent)
                        <div class="block-21 mb-4 d-flex">
                            <a href="{{ route('berita.detail', $recent->id) }}" class="blog-img mr-4" style="background-image: url('{{ asset('storage/' . $recent->foto) }}'); min-width: 80px; height: 80px;"></a>
                            <div class="text">
                                <h3 class="heading"><a href="{{ route('berita.detail', $recent->id) }}">{{ Str::limit($recent->judul, 40) }}</a></h3>
                                <div class="meta">
                                    <div><a href="#"><span class="icon-calendar"></span> {{ $recent->tgl_post->format('d M Y') }}</a></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Categories -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h4 class="font-weight-bold mb-3">Kategori Berita</h4>
                        <ul class="list-unstyled">
                            @foreach($kategoriBeritas as $kategori)
                            <li class="mb-2">
                                <a href="{{ url('berita?kategori_id=' . $kategori->id) }}" class="d-flex justify-content-between align-items-center">
                                    <span>{{ $kategori->kategori_berita }}</span>
                                    <span class="badge badge-primary">{{ $kategori->berita_count }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .berita-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .berita-content img {
        max-width: 100%;
        height: auto;
        margin: 20px 0;
        border-radius: 5px;
    }

    .share-buttons .btn {
        margin-left: 5px;
    }

    .tagcloud a {
        display: inline-block;
        padding: 5px 10px;
        background: #f8f9fa;
        border-radius: 4px;
        margin: 0 5px 5px 0;
        color: #555;
        font-size: 0.9rem;
    }

    .tagcloud a:hover {
        background: #dc3545;
        color: white;
        text-decoration: none;
    }
</style>
@endpush
