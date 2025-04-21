{{-- home / index.blade.php --}}

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
            <h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><strong>Jelajahi <br></strong> keindahan Desa Penglipuran</h1>
            <p data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Temukan tempat terbaik untuk dikunjungi, aktivitas menarik, dan pengalaman tidak terlupakan</p>
            <div class="block-17 my-4">
              <form action="" method="post" class="d-block d-flex">
                <div class="fields d-block d-flex">
                  <div class="textfield-search one-third">
                  	<input type="text" class="form-control" placeholder="Cari paket wisata...">
                  </div>
                  <div class="select-wrap one-third">
                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                    <select name="" id="" class="form-control">
                      <option value="">Kategori Wisata</option>
                      <option value="alam">Wisata Alam</option>
                      <option value="budaya">Wisata Budaya</option>
                      <option value="kuliner">Wisata Kuliner</option>
                      <option value="edukasi">Wisata Edukasi</option>
                    </select>
                  </div>
                </div>
                <input type="submit" class="search-submit btn btn-primary" value="Search">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Widgets --}}
    <section class="ftco-section services-section bg-light">
        <div class="container">
        <div class="row d-flex">
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-center"><div class="icon"><span class="flaticon-detective"></span></div></div>
                </div>
                <div class="media-body p-2 mt-2">
                <h3 class="heading mb-3">Eksplorasi Desa Wisata</h3>
                <p>Temukan keindahan alam, budaya, dan tradisi khas desa dalam satu platform.</p>
                </div>
            </div>
            </div>
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-center"><div class="icon"><span class="flaticon-guarantee"></span></div></div>
                </div>
                <div class="media-body p-2 mt-2">
                <h3 class="heading mb-3">Reservasi Mudah</h3>
                <p>Booking penginapan, aktivitas, dan paket wisata desa hanya dalam beberapa klik.</p>
                </div>
            </div>
            </div>
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-center"><div class="icon"><span class="flaticon-like"></span></div></div>
                </div>
                <div class="media-body p-2 mt-2">
                <h3 class="heading mb-3">Pemandu Lokal</h3>
                <p>Dipandu langsung oleh warga desa yang ramah dan berpengalaman dalam budaya lokal.</p>
                </div>
            </div>
            </div>
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
                <div class="d-flex justify-content-center">
                <div class="icon"><span class="flaticon-support"></span></div>
                </div>
                <div class="media-body p-2 mt-2">
                <h3 class="heading mb-3">Dukungan Wisatawan</h3>
                <p>Tim kami siap membantu perjalanan Anda agar lebih nyaman dan tak terlupakan.</p>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>

    {{-- Obyek Wisata --}}
    <section class="ftco-section ftco-destination">
        <div class="container">
            <div class="row justify-content-start mb-5 pb-3">
                <div class="col-md-7 heading-section ftco-animate">
                    <span class="subheading">Istimewa</span>
                    <h2 class="mb-4"><strong>Objek Wisata</strong> Unggulan</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="destination-slider owl-carousel ftco-animate">
                        @foreach ($obyekWisatas as $obyek)
                        <div class="item">
                            <div class="destination">
                                <a href="#" class="img d-flex justify-content-center align-items-center"
                                    style="background-image: url('{{ asset('Storage/' . $obyek->foto1) }}');">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="icon-search2"></span>
                                    </div>
                                </a>
                                <div class="text p-3">
                                    <h3><a href="#">{{ $obyek->nama_wisata }}</a></h3>
                                    <span class="listing">{{ Str::limit($obyek->kategori->kategori_wisata, 30) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Paket Wisata --}}
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-start mb-5 pb-3">
                <div class="col-md-7 heading-section ftco-animate">
                    <span class="subheading">Penawaran Spesial</span>
                    <h2 class="mb-4"><strong>Paket Wisata</strong> Terbaik</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="owl-carousel item-carousel owl-theme">
                @foreach ($paketWisatas as $paket)
                <div class="item">
                    <div class="destination">
                        <a href="#" class="img d-flex justify-content-center align-items-center"
                                    style="background-image: url('{{ asset('Storage/' . $paket->foto1) }}');">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="icon-search2"></span>
                                    </div>
                        </a>
                        <div class="text p-3">
                            <div class="d-flex">
                                <div class="one">
                                    <h3><a href="#">{{$paket->nama_paket}}</a></h3>
                                         <span class="price text-success font-weight-bold h5">Rp. {{ number_format($paket->harga_per_pack, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <p>{{Str::limit($paket->deskripsi, 30)}}</p>

                            <hr>
                            <p class="bottom-area d-flex">
                                <span><i class="icon-map-o"></i> {{Str::limit($paket->fasilitas,25)}}</span>
                                <span class="ml-auto"><a href="{{ route('paket-wisata.detail', $paket->id) }}">Pesan</a></span>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Fun Fact --}}
    <section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url('{{ asset('front-end/images/lsp/wisata/jalanan utama/1018586_720 (1).jpg') }}');">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2 class="mb-4">Fakta Menarik</h2>
            <span class="subheading">Pengalaman terbaik bersama kami di Desa Penglipuran</span>
          </div>
        </div>
    		<div class="row justify-content-center">
    			<div class="col-md-10">
		    		<div class="row">
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number">{{$pelanggans->count()}}</strong>
		                <span>Pelanggan</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number">{{$obyekWisatas->count()}}</strong>
		                <span>Objek Wisata</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number">{{$penginapans->count()}}</strong>
		                <span>Penginapan</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number">{{$paketWisatas->count()}}</strong>
		                <span>Paket Wisata</span>
		              </div>
		            </div>
		          </div>
		        </div>
	        </div>
        </div>
    	</div>
    </section>

    {{-- Penginapan --}}
    <section class="ftco-section ftco-destination">
        <div class="container">
            <div class="row justify-content-start mb-5 pb-3">
                <div class="col-md-7 heading-section ftco-animate">
                    <span class="subheading">Rekomendasi</span>
                    <h2 class="mb-4"><strong>Penginapan</strong> Nyaman</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="owl-carousel item-carousel owl-theme">
                @foreach($penginapans as $penginapan)
                <!-- Item 1 -->
                <div class="item">
                    <div class="destination">
                        <a href="#" class="img d-flex justify-content-center align-items-center"
                                    style="background-image: url('{{ asset('Storage/' . $penginapan->foto1) }}');">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="icon-search2"></span>
                                    </div>
                        </a>
                        <div class="text p-3">
                            <div class="d-flex">
                                <div class="one">
                                    <h3><a href="#">{{$penginapan->nama_penginapan}}</a></h3>
                                    {{-- <p class="rate">
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star-o"></i>
                                        <span>15 Rating</span>
                                    </p> --}}
                                </div>
                                {{-- <div class="two">
                                    <span class="price">Rp 300.000</span>
                                </div> --}}
                            </div>
                            <p>{{Str::limit($penginapan->deskripsi, 35)}}</p>
                            <hr>
                            <p class="bottom-area d-flex">
                                <span><i class="icon-map-o"></i> {{Str::limit($penginapan->fasilitas,30)}}</span>
                                <span class="ml-auto"><a href="#">Detail</a></span>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Tambah item lainnya sesuai kebutuhan -->
            </div>
        </div>
    </section>

    {{-- Berita --}}
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-start mb-5 pb-3">
                <div class="col-md-7 heading-section ftco-animate">
                    <span class="subheading">Berita Terbaru</span>
                    <h2><strong>Info</strong> &amp; Artikel Desa Wisata</h2>
                </div>
            </div>
        </div>
        <div class="container-fluid position-relative px-lg-5">
            <div class="owl-carousel item-carousel owl-theme">

                @foreach ($beritas as $berita)
                <!-- Item 1 -->
                <div class="item px-2">
                    <div class="blog-entry h-100">
                        <a href="#" class="block-20 d-flex justify-content-center align-items-center"
                                    style="background-image: url('{{ asset('Storage/' . $berita->foto) }}'); min-height: 200px;">
                        </a>
                        <div class="text p-4">
                            <span class="tag badge badge-primary">{{$berita->kategori->kategori_berita}}</span>


                            @if(strlen($berita->judul) > 30)
                            <h3 class="heading mt-3" style="cursor: pointer" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$berita->judul}}">
                                <a href="berita-detail.html">{{substr($berita->judul, 0, 30) . '...'}}</a>
                            </h3>
                            @else
                            <h3 class="heading mt-3" style="cursor: pointer" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$berita->judul}}">
                                <a href="berita-detail.html">{{ $berita->judul }}</a>
                            </h3>
                            @endif

                            <div class="meta mb-3 d-flex justify-content-between">
                                <div><a href="#"><i class="icon-calendar mr-1"></i> {{$berita->tgl_post}}</a></div>
                                <div><a href="#" class="meta-chat"><i class="icon-chat mr-1"></i> 5</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>


    @endsection

