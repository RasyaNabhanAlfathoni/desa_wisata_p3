{{-- home / obyek_wisata.blade.php --}}

{{-- home / obyek_wisata.blade.php --}}

@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection
@section('content')
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('front-end/images/lsp/wisata/hutan bambu/panglipuran-bamboo-forest.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
        <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
            <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="{{route('home')}}">{{$title}}</a></span>| <span>{{$title2}}</span></p>
          <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Obyek Wisata</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section ftco-degree-bg">
    <div class="container">
      <div class="row">
          <div class="col-lg-3 sidebar ftco-animate">
              <div class="sidebar-wrap bg-light ftco-animate">
                  <h3 class="mb-4">Cari Obyek Wisata</h3>
                  <form action="{{ url('obyek-wisata') }}" method="GET">
                    <div class="fields">
                      <div class="form-group">
                        <div class="select-wrap one-third">
                          <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                          <select name="kategori_id" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriWisatas as $kategori)
                              <option value="{{$kategori->id}}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{$kategori->kategori_wisata}}
                              </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <input type="text" name="nama_wisata" class="form-control" placeholder="Cari Nama Wisata" value="{{ request('nama_wisata') }}">
                      </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-primary py-3 px-5 w-100">
                            <i class="fas fa-search mr-2"></i> Cari Obyek
                        </button>
                        @if(request()->has('kategori_id') || request()->has('nama_wisata'))
                                <a href="{{ url('obyek-wisata') }}" class="btn btn-outline-secondary py-3 px-5 w-100 mt-2">
                                    Reset Pencarian
                                </a>
                            @endif
                      </div>
                    </div>
                  </form>
              </div>
          </div>
        <div class="col-lg-9">
            @if($obyekWisatas->isEmpty())
                <div class="col-12">
                    <div class="alert alert-warning">
                        <i class="icon-info-circle"></i>Tidak ditemukan obyek wisata yang sesuai dengan kriteria pencarian Anda.
                    </div>
                </div>
            @else
            <div class="row">
                @foreach($obyekWisatas as $obyek)
                <div class="col-md-4 ftco-animate">
                    <div class="destination">
                        <a href="{{ route('obyek-wisata.detail', $obyek->id) }}" class="img img-2 d-flex justify-content-center align-items-center"
                           style="background-image: url('{{ asset('storage/' . $obyek->foto1) }}');">
                            <div class="icon d-flex justify-content-center align-items-center">
                                <span class="icon-search2"></span>
                            </div>
                        </a>
                        <div class="text p-3">
                            <div class="d-flex">
                                <div class="one">
                                    <h3><a href="{{ route('obyek-wisata.detail', $obyek->id) }}">{{$obyek->nama_wisata}}</a></h3>
                                    <span class="badge badge-info">{{$obyek->kategori->kategori_wisata}}</span>
                                </div>
                            </div>
                            <p>{{ Str::limit($obyek->deskripsi_wisata, 50) }}</p>
                            <hr>
                            <p class="bottom-area d-flex">
                                <span><i class="icon-map-o"></i> {{ Str::limit($obyek->fasilitas, 20) }}</span>
                                <span class="ml-auto">
                                    <a href="{{ route('obyek-wisata.detail', $obyek->id) }}">Detail</a>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            <div class="row mt-5">
                <div class="col text-center">
                    <div class="d-flex justify-content-center">
                        {{ $obyekWisatas->links('pagination::bootstrap-4') }}
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
        </div> <!-- .col-md-8 -->
      </div>
    </div>
  </section> <!-- .section -->
@endsection
