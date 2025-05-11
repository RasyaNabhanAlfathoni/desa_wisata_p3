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
            <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="{{route('home')}}">{{$title}}</a></span>| <span>{{$title2}}</span></p>
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
                            <label for="paket_id" class="form-label">Jenis Paket</label>
                            <div class="select-wrap one-third">
                                <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                <select name="paket_id" id="paket_id" class="form-control">
                                    <option value="">Semua Paket Wisata</option>
                                    @foreach($paketWisatasAll as $paket)
                                        <option value="{{$paket->id}}" {{ request('paket_id') == $paket->id ? 'selected' : '' }}>
                                            {{$paket->nama_paket}} (Rp {{ number_format($paket->harga_per_pack, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                            <input type="number" name="jumlah_peserta" id="jumlah_peserta" class="form-control"
                                   placeholder="Contoh: 5" min="1" value="{{ request('jumlah_peserta') }}">
                            <small class="text-muted">Paket dengan kapasitas tersedia akan ditampilkan</small>
                        </div>

                        <div class="form-group">
                            <label for="date_from" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="date_from" id="date_from" class="form-control datepicker"
                                   placeholder="Pilih tanggal" value="{{ request('date_from') }}"
                                   min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group">
                            <label for="date_to" class="form-label">Tanggal Akhir</label>
                            <input type="date" name="date_to" id="date_to" class="form-control datepicker"
                                   placeholder="Pilih tanggal" value="{{ request('date_to') }}"
                                   min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Rentang Harga (Rp)</label>
                            <div class="range-slider">
                                <div class="d-flex align-items-center mb-2">
                                    <input type="number" name="harga_min" class="form-control form-control-sm"
                                           value="{{ request('harga_min', 250000) }}" min="0" placeholder="Min">
                                    <span class="mx-2">-</span>
                                    <input type="number" name="harga_max" class="form-control form-control-sm"
                                           value="{{ request('harga_max', 500000) }}" min="0" placeholder="Max">
                                </div>
                                <div id="harga-slider" class="slider mb-3"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary py-3 px-5 w-100">
                                <i class="fas fa-search mr-2"></i> Cari Paket
                            </button>
                            @if(request()->has('paket_id') || request()->has('jumlah_peserta') ||
                               request()->has('date_from') || request()->has('harga_min'))
                                <a href="{{ url('paket-wisata') }}" class="btn btn-outline-secondary py-3 px-5 w-100 mt-2">
                                    Reset Pencarian
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
              </div>
        </div>
        <div class="col-lg-9">
            @if($paketWisatas->isEmpty())
                <div class="col-12">
                    <div class="alert alert-warning">
                        <i class="icon-info-circle"></i>Tidak ditemukan paket wisata yang sesuai dengan kriteria pencarian Anda.
                    </div>
                </div>
            @else
            <div class="row">
                @foreach($paketWisatas as $paket)
                <div class="col-md-4 ftco-animate">
                    <div class="destination">
                        <a href="{{ route('paket-wisata.detail', $paket->id) }}" class="img img-2 d-flex justify-content-center align-items-center"
                           style="background-image: url('{{ asset('storage/' . $paket->foto1) }}');">
                            <div class="icon d-flex justify-content-center align-items-center">
                                <span class="icon-search2"></span>
                            </div>
                        </a>
                        <div class="text p-3">
                            <div class="d-flex">
                                <div class="one">
                                    <h3><a href="{{ route('paket-wisata.detail', $paket->id) }}">{{$paket->nama_paket}}</a></h3>
                                         <span class="price text-info font-weight-bold h5">Rp. {{ number_format($paket->harga_per_pack, 0, ',', '.') }}</span>

                                </div>
                            </div>
                            <p>{{ Str::limit($paket->deskripsi, 50) }}</p>
                            <p class="days font-weight-bold">Durasi: <span class="text-danger">{{$paket->durasi_hari}} hari</span></p>
                            <hr>
                            <p class="bottom-area d-flex">
                                <span><i class="icon-map-o"></i> {{ Str::limit($paket->fasilitas, 20) }}</span>
                                <span class="ml-auto">
                                    <a href="{{ route('paket-wisata.detail', $paket->id) }}">Pesan</a>
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
                        {{ $paketWisatas->links('pagination::bootstrap-4') }}
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
