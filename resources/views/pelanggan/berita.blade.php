{{-- home / berita.blade.php --}}

@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection
@section('content')
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('front-end/images/lsp/berita/festival/IMG-20240707-WA0066.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
        <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
            <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="{{route('pelanggan.index')}}">{{$title}}</a></span>| <span>{{$title2}}</span></p>
          <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Berita Terkini</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section ftco-degree-bg">
    <div class="container">
      <div class="row">
          <div class="col-lg-3 sidebar ftco-animate">
              <div class="sidebar-wrap bg-light ftco-animate">
                  <h3 class="mb-4">Cari Berita</h3>
                  <form action="{{ url('pelanggan/berita') }}" method="GET">
                    <div class="fields">
                      <div class="form-group">
                        <div class="select-wrap one-third">
                          <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                          <select name="kategori_id" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriBeritas as $kategori)
                              <option value="{{$kategori->id}}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{$kategori->kategori_berita}}
                              </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <input type="text" name="judul" class="form-control" placeholder="Cari Judul Berita" value="{{ request('judul') }}">
                      </div>

                      <div class="form-group">
                        <input type="submit" value="Cari" class="btn btn-primary py-3 px-5">
                      </div>
                    </div>
                  </form>
              </div>

              <div class="sidebar-box ftco-animate">
                  <h3 class="heading">Berita Terbaru</h3>
                  @foreach($recentBeritas as $recent)
                  <div class="block-21 mb-4 d-flex">
                      <a href="{{ route('pelanggan.berita.detail', $recent->id) }}" class="blog-img mr-4" style="background-image: url('{{ asset('storage/' . $recent->foto) }}');"></a>
                      <div class="text">
                          <h3 class="heading-1"><a href="{{ route('pelanggan.berita.detail', $recent->id) }}">{{ Str::limit($recent->judul, 30) }}</a></h3>
                          <div class="meta">
                              <div><a href="#"><span class="icon-calendar"></span> {{ $recent->tgl_post->format('d M Y') }}</a></div>
                          </div>
                      </div>
                  </div>
                  @endforeach
              </div>

              <div class="sidebar-box ftco-animate">
                  <h3 class="heading">Kategori Berita</h3>
                  <ul class="categories">
                      @foreach($kategoriBeritas as $kategori)
                      <li><a href="{{ url('pelanggan/berita?kategori_id=' . $kategori->id) }}">{{ $kategori->kategori_berita }} </a><span>({{ $kategori->berita->count() }})</span></li>
                      @endforeach
                  </ul>
              </div>
          </div>

          <div class="col-lg-9">
              <div class="row">
                  @foreach($beritas as $berita)
                  <div class="col-md-12 ftco-animate">
                      <div class="blog-entry d-md-flex">
                          <a href="{{ route('pelanggan.berita.detail', $berita->id) }}" class="img img-2" style="background-image: url('{{ asset('storage/' . $berita->foto) }}');"></a>
                          <div class="text text-2 pl-md-4">
                              <h3 class="mb-2"><a href="{{ route('pelanggan.berita.detail', $berita->id) }}">{{ $berita->judul }}</a></h3>
                              <div class="meta-wrap">
                                  <p class="meta">
                                      <span><i class="icon-calendar mr-2"></i>{{ $berita->tgl_post->format('d M Y') }}</span>
                                      <span><a href="#"><i class="icon-folder-o mr-2"></i>{{ $berita->kategori->kategori_berita }}</a></span>
                                  </p>
                              </div>
                              <p class="mb-4">{{ Str::limit(strip_tags($berita->berita), 150) }}</p>
                              <p><a href="{{ route('pelanggan.berita.detail', $berita->id) }}" class="btn-custom">Baca Selengkapnya <span class="ion-ios-arrow-forward"></span></a></p>
                          </div>
                      </div>
                  </div>
                  @endforeach
              </div>

              <div class="row mt-5">
                  <div class="col text-center">
                      <div class="d-flex justify-content-center">
                          {{ $beritas->links('pagination::bootstrap-4') }}
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
          </div>
      </div>
    </div>
  </section>
@endsection
