<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('back-end/assets/images/pesona_desa2.png') }}" type="image/png">
    <title>{{$title}} - PesonaDesa</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{asset('back-end/css/simplebar.css')}}">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{asset('back-end/css/feather.css')}}">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{asset('back-end/css/daterangepicker.css')}}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{asset('back-end/css/app-light.css')}}" id="lightTheme">
    <link rel="stylesheet" href="{{asset('back-end/css/app-dark.css')}}" id="darkTheme" disabled>

    {{-- Alert --}}
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

     {{-- Font Awesome --}}
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  </head>
  <body class="light " id="body" >
    <div class="wrapper vh-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50"
     style="background: url('{{asset('front-end/images/bg2.jpg')}}') center/cover no-repeat;">
        <div class="col-lg-6 col-md-8 col-10 " >
          <div class="card shadow-lg border-0 p-4 text-center" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-radius: 15px;">
            <div class="card-body">
                <img src="{{ asset('back-end/assets/images/pesona_desa.png') }}"
                alt="Logo Pesona Desa"
                class="navbar-brand-img brand-md mb-3">
                <h1 class="h3 mb-3">Verifikasi Email Anda</h1>

                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">Periksa Email Anda!</h4>
                    <p>Link verifikasi telah dikirim ke alamat email Anda. <br>Silakan cek folder inbox atau spam untuk verifikasi.</p>
                </div>

                @if (session('pesan'))
                    <div class="alert alert-success" role="alert">
                        {{ session('pesan') }}
                    </div>
                @endif

                <div class="mt-4">
                    <p>Tidak menerima email verifikasi?</p>
                    <form action="{{ route('verification.send') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Kirim Ulang Link Verifikasi</button>
                    </form>
                </div>

                <p class="mt-3 text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none">Kembali ke halaman login</a>
                </p>

                <p class="mt-4 mb-2 text-center">© {{ date('Y') }}</p>
            </div>
          </div>
        </div>
      </div>

    <div class="invisible" id="pesan">@isset($pesan) {{$pesan}} @endisset</div>

    <script>
        const body = document.getElementById('body');
        const pesan = document.getElementById('pesan');

        function tampil_pesan(){
            let pesan = "{{ session('pesan') }}";
            let error = "{{ session('error') }}";

            if (pesan.trim() !== '') {
                swal('Good Job', pesan.trim(), 'success');
            }

            if (error.trim() !== '') {
                swal('Invalid Data!', error.trim(), 'error');
            }
        }

        body.onload = function(){
            tampil_pesan()
        }
    </script>

    {{-- Alert --}}
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script src="{{asset('back-end/js/jquery.min.js')}}"></script>
    <script src="{{asset('back-end/js/popper.min.js')}}"></script>
    <script src="{{asset('back-end/js/moment.min.js')}}"></script>
    <script src="{{asset('back-end/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('back-end/js/simplebar.min.js')}}"></script>
    <script src='{{asset('back-end/js/daterangepicker.js')}}'></script>
    <script src='{{asset('back-end/js/jquery.stickOnScroll.js')}}'></script>
    <script src="{{asset('back-end/js/tinycolor-min.js')}}"></script>
    <script src="{{asset('back-end/js/config.js')}}"></script>
    <script src="{{asset('back-end/js/apps.js')}}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>
  </body>
</html>
