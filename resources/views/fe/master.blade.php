<!DOCTYPE html>
<html lang="en">
  <head>
    <title>{{$title}} - {{$title2}} - PesonaDesa.</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('back-end/assets/images/pesona_desa.png2') }}" type="image/png">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alex+Brush" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('front-end/css/open-iconic-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/animate.css')}}">

    <link rel="stylesheet" href="{{asset('front-end/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/magnific-popup.css')}}">

    <link rel="stylesheet" href="{{asset('front-end/css/aos.css')}}">

    <link rel="stylesheet" href="{{asset('front-end/css/ionicons.min.css')}}">

    <link rel="stylesheet" href="{{asset('front-end/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/jquery.timepicker.css')}}">


    <link rel="stylesheet" href="{{asset('front-end/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/icomoon.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/style.css')}}">

    <!-- di <head> Swiper -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{asset('back-end/css/feather.css')}}" />

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- Carousel --}}
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    {{-- Alert --}}
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    {{-- Datepicker ID--}}
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">


  </head>
  <body id="body">


    @yield('navbar')

    @yield('content')


   <!-- loader -->
  {{-- <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div> --}}

  {{-- Footer --}}
  <footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md">
            <div class="ftco-footer-widget mb-4">
                <h2 class="ftco-heading-2">pesonaDesa.</h2>
                <p>Platform reservasi digital untuk menjelajahi keindahan dan budaya desa wisata. Temukan pengalaman unik, aktivitas lokal, dan keramahan masyarakat dalam satu aplikasi.</p>
                {{-- <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                  <li class="ftco-animate"><a href="#"><span class="icon-youtube"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                </ul> --}}
              </div>
        </div>
        <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Informasi</h2>
              <ul class="list-unstyled">
                @if($title !== 'Pelanggan')
                    <li>
                        <a href="{{ route('about') }}" class="pb-2 d-block">Tentang Kami</a>
                    </li>
                @endif
                <li><a href="{{ $title === 'Pelanggan' ? route('pelanggan.paket_wisata') : route('paket_wisata') }}" class="pb-2 d-block">Paket Wisata</a></li>
                <li><a href="{{ $title === 'Pelanggan' ? route('pelanggan.obyek_wisata') : route('obyek_wisata') }}" class="pb-2 d-block">Obyek Wisata</a></li>
                <li><a href="{{ $title === 'Pelanggan' ? route('pelanggan.penginapan') : route('penginapan') }}" class="pb-2 d-block">Penginapan</a></li>
                <li><a href="{{ $title === 'Pelanggan' ? route('pelanggan.berita') : route('berita') }}" class="pb-2 d-block">Berita</a></li>
              </ul>
            </div>
          </div>
        <div class="col-md">
           <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Hubungi Kami</h2>
            <ul class="list-unstyled">
                @php
                // Ambil data pemilik pertama yang valid
                $pemilik = App\Models\User::where('level', 'pemilik')
                            ->where('aktif', true)
                            ->with('karyawan')
                            ->first();
                @endphp

                @if($pemilik && $pemilik->karyawan)
                    <li><a><span class="icon icon-phone mr-2"></span><span class="text">{{ $pemilik->karyawan->no_hp ?? 'Nomor tidak tersedia' }}</span></a></li>
                    <li><a><span class="icon icon-envelope mr-2"></span><span class="text">{{ $pemilik->email }}</span></a></li>
                @else
                    <li><a><span class="icon icon-phone mr-2"></span><span class="text">+62 392 3929 210</span></a></li>
                    <li><a><span class="icon icon-envelope mr-2"></span><span class="text">pemilik@pesonaDesa.co.id</span></a></li>
                @endif
            </ul>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Alamat</h2>
              <div class="block-23 mb-3">
                <ul>
                  <li><span class="icon icon-map-marker"></span><span class="text">Jl. Raya Karadenan No.7, Karadenan, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16111</span></li>
                </ul>
              </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">

          <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
            </div>
        </div>
        </div>
    </footer>

  <script src="{{asset('front-end/js/jquery.min.js')}}"></script>
  <script src="{{asset('front-end/js/jquery-migrate-3.0.1.min.js')}}"></script>
  <script src="{{asset('front-end/js/popper.min.js')}}"></script>
  <script src="{{asset('front-end/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('front-end/js/jquery.easing.1.3.js')}}"></script>
  <script src="{{asset('front-end/js/jquery.waypoints.min.js')}}"></script>
  <script src="{{asset('front-end/js/jquery.stellar.min.js')}}"></script>
  <script src="{{asset('front-end/js/owl.carousel.min.js')}}"></script>
  <script src="{{asset('front-end/js/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{asset('front-end/js/aos.js')}}"></script>
  <script src="{{asset('front-end/js/jquery.animateNumber.min.js')}}"></script>
  <script src="{{asset('front-end/js/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('front-end/js/jquery.timepicker.min.js')}}"></script>
  <script src="{{asset('front-end/js/scrollax.min.js')}}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="{{asset('front-end/js/google-map.js')}}"></script>
  <script src="{{asset('front-end/js/main.js')}}"></script>

  {{-- Alert --}}
  <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <!-- Flatpickr JS -->

  <!-- sebelum </body> Swiper -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    {{-- Carousel --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Bootstrap Bundle (termasuk Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function(){
            $(".item-carousel").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                navText: [
                    "<i class='fa fa-chevron-left'></i>",
                    "<i class='fa fa-chevron-right'></i>"
                ],
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:2
                    },
                    1000:{
                        items:3
                    }
                }
            });
        });
    </script>

    {{-- ToolTips --}}
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
    @stack('scripts')

  </body>
</html>
