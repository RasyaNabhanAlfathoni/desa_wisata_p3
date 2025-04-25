{{-- home / paket_wisata.blade.php --}}

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
            <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="{{route('pelanggan.index')}}">{{$title}}</a></span>| <span>{{$title2}}</span></p>
          <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Paket Wisata</h1>
        </div>
      </div>
    </div>
  </div>


  <section class="ftco-section ftco-degree-bg">
    <div class="container">
      <div class="row">
          <div class="col-lg-3 sidebar ftco-animate">
              <div class="sidebar-wrap bg-light ftco-animate">
                  <h3 class="mb-4">Temukan Paket Wisata</h3>
                  <form action="{{ url('paket-wisata') }}" method="GET">
                    <div class="fields">
                      <div class="form-group">
                        <div class="select-wrap one-third">
                          <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                          <select name="paket_id" class="form-control">
                            <option value="">Pilih Paket Wisata</option>
                            @foreach($paketWisatasAll as $paket)
                              <option value="{{$paket->id}}" {{ request('paket_id') == $paket->id ? 'selected' : '' }}>
                                {{$paket->nama_paket}}
                              </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group mt-3">
                        <input type="number" name="jumlah_peserta" class="form-control" placeholder="Jumlah Peserta" value="{{ request('jumlah_peserta') }}">
                      </div>

                      <div class="form-group">
                        <input type="text" name="date_from" class="form-control" placeholder="Date from" value="{{ request('date_from') }}">
                      </div>

                      <div class="form-group">
                        <input type="text" name="date_to" class="form-control" placeholder="Date to" value="{{ request('date_to') }}">
                      </div>

                      <div class="form-group">
                        <div class="range-slider">
                          <span>
                            <input type="number" name="harga_min" value="{{ request('harga_min', 25000) }}" min="0" max="120000"/> -
                            <input type="number" name="harga_max" value="{{ request('harga_max', 50000) }}" min="0" max="120000"/>
                          </span>
                        </div>
                      </div>

                      <div class="form-group">
                        <input type="submit" value="Search" class="btn btn-primary py-3 px-5">
                      </div>
                    </div>
                  </form>
              </div>
        </div>
        <div class="col-lg-9">
            <div class="row">
                @foreach($paketWisatas as $paket)
                <div class="col-md-4 ftco-animate">
                    <div class="destination">
                        <a href="#" class="img img-2 d-flex justify-content-center align-items-center"
                           style="background-image: url('{{ asset('Storage/' . $paket->foto1) }}');">
                            <div class="icon d-flex justify-content-center align-items-center">
                                <span class="icon-search2"></span>
                            </div>
                        </a>
                        <div class="text p-3">
                            <div class="d-flex">
                                <div class="one">
                                    <h3><a href="#">{{$paket->nama_paket}}</a></h3>
                                         <span class="price text-info font-weight-bold h5">Rp. {{ number_format($paket->harga_per_pack, 0, ',', '.') }}</span>

                                </div>
                            </div>
                            <p>{{ Str::limit($paket->deskripsi, 50) }}</p>
                            <p class="days font-weight-bold">Durasi: <span class="text-danger">{{$paket->durasi_hari}} hari</span></p>
                            <hr>
                            <p class="bottom-area d-flex">
                                <span><i class="icon-map-o"></i> {{ Str::limit($paket->fasilitas, 20) }}</span>
                                <span class="ml-auto">
                                    <a href="{{ route('pelanggan.paket-wisata.detail', $paket->id) }}">Pesan</a>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row mt-5">
                <div class="col text-center">
                  <div class="block-27">
                    {{ $paketWisatas->links() }}
                  </div>
                </div>
              </div>
        </div> <!-- .col-md-8 -->
      </div>
    </div>
  </section> <!-- .section -->
@endsection
