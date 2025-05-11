{{-- home/penginapan.blade.php --}}

@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection
@section('content')
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('front-end/images/lsp/Penginapan/villa/604391307.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
        <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
            <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="{{route('home')}}">{{$title}}</a></span>| <span>{{$title2}}</span></p>
          <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Penginapan</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section ftco-degree-bg">
    <div class="container">
      <div class="row">
          <div class="col-lg-3 sidebar ftco-animate">
              <div class="sidebar-wrap bg-light ftco-animate">
                  <h3 class="mb-4">Cari Penginapan</h3>
                  <form action="{{ url('penginapan') }}" method="GET">
                    <div class="fields">
                      <div class="form-group">
                        <input type="text" name="nama_penginapan" class="form-control" placeholder="Cari Nama Penginapan" value="{{ request('nama_penginapan') }}">
                      </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-primary py-3 px-5 w-100">
                            <i class="fas fa-search mr-2"></i> Cari Penginapan
                        </button>
                        @if(request()->has('nama_penginapan'))
                            <a href="{{ url('penginapan') }}" class="btn btn-outline-secondary py-3 px-5 w-100 mt-2">
                                Reset Pencarian
                            </a>
                        @endif
                      </div>
                    </div>
                  </form>
              </div>
          </div>
        <div class="col-lg-9">
            @if($penginapans->isEmpty())
                <div class="col-12">
                    <div class="alert alert-warning">
                        <i class="icon-info-circle"></i>Tidak ditemukan penginapan yang sesuai dengan kriteria pencarian Anda.
                    </div>
                </div>
            @else
            <div class="row">
                @foreach($penginapans as $penginapan)
                <div class="col-md-4 ftco-animate">
                    <div class="destination">
                        <a href="{{ route('penginapan.detail', $penginapan->id) }}" class="img img-2 d-flex justify-content-center align-items-center"
                           style="background-image: url('{{ asset('storage/' . $penginapan->foto1) }}');">
                            <div class="icon d-flex justify-content-center align-items-center">
                                <span class="icon-search2"></span>
                            </div>
                        </a>
                        <div class="text p-3">
                            <div class="d-flex">
                                <div class="one">
                                    <h3><a href="{{ route('penginapan.detail', $penginapan->id) }}">{{$penginapan->nama_penginapan}}</a></h3>
                                </div>
                            </div>
                            <p>{{ Str::limit($penginapan->deskripsi, 50) }}</p>
                            <hr>
                            <p class="bottom-area d-flex">
                                <span><i class="icon-map-o"></i> {{ Str::limit($penginapan->fasilitas, 20) }}</span>
                                <span class="ml-auto">
                                    <a href="{{ route('penginapan.detail', $penginapan->id) }}">Detail</a>
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
                        {{ $penginapans->links('pagination::bootstrap-4') }}
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
