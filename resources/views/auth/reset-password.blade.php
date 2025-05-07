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

    {{-- CDN 5.3.0 --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

  </head>
  <body class="light " id="body" >
    <div class="wrapper vh-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50"
 style="background: url('{{asset('front-end/images/bg2.jpg')}}') center/cover no-repeat;">
    <div class="col-lg-4 col-md-6 col-10">
      <div class="card shadow-lg border-0 p-4 text-center" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-radius: 15px;">
        <div class="card-body">
          <form action="{{route('password.update')}}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <img src="{{ asset('back-end/assets/images/pesona_desa.png') }}"
            alt="Logo Pesona Desa"
            class="navbar-brand-img brand-md mb-3">
            <h1 class="h3 mb-3">Reset Password</h1>
            <div class="form-group">
              <label for="email" class="sr-only">Alamat Email</label>
              <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Alamat Email" value="{{ $email }}" required readonly>
            </div>
            <div class="form-group mt-3">
              <label for="password" class="sr-only">Password Baru</label>
              <div class="input-group">
                <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Masukkan Kata Password" required>
                    <div class="input-group-append">
                        <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                            <i class="fa fa-eye-slash" id="togglePasswordIcon"></i>
                        </span>
                    </div>
              </div>
            </div>
            <div class="form-group mt-3">
              <label for="password_confirmation" class="sr-only">Konfirmasi Password</label>
              <div class="input-group">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" placeholder="Konfirmasi Password" required>
                    <div class="input-group-append">
                        <span class="input-group-text" onclick="togglePassword2()" style="cursor: pointer;">
                            <i class="fa fa-eye-slash" id="togglePasswordIcon2"></i>
                        </span>
                    </div>
              </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block w-100 mt-3" type="submit">Reset Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>

    <div class="invisible" id="pesan">@isset($pesan) {{$pesan}} @endisset</div>

    <script>
        function togglePassword() {
            let passwordField = document.getElementById("password");
            let icon = document.getElementById("togglePasswordIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
    </script>

    <script>
        function togglePassword2() {
            let passwordField2 = document.getElementById("password_confirmation");
            let icon2 = document.getElementById("togglePasswordIcon2");
            if (passwordField2.type === "password") {
                passwordField2.type = "text";
                icon2.classList.remove("fa-eye-slash");
                icon2.classList.add("fa-eye");
            } else {
                passwordField2.type = "password";
                icon2.classList.remove("fa-eye");
                icon2.classList.add("fa-eye-slash");
            }
        }
    </script>
    <script>
        const btnSimpan = document.getElementById('save');
        const form = document.getElementById('frmLogin');
        const body = document.getElementById('body');
        const status = document.getElementById('status');
        const pesan = document.getElementById('pesan');
        const email = document.getElementById('inputEmail');
        const password = document.getElementById('inputPassword');

        function tampil_pesan(){
            let pesan = "{{ session('pesan') }}";
            let error = "{{ session('error') }}";

            if (pesan.trim() !== '') {
                swal('Good Job', pesan.trim(), 'success');
            }

            if (error.trim() !== '') {
                swal('Invalid Data!', error.trim(), 'error');
            }
            // if(pesan.innerHTML.trim() !== ''){
            // swal('Good Job', pesan.innerHTML, 'success')
            // // }else if(status.innerHTML.trim() === 'edit'){
            // // swal('Good Job', pesan.innerHTML, 'success')
            // }
        }

        function simpan(event) {
                     // Cek apakah ada field yang kosong dan tampilkan pesan error sesuai
                     if (email.value === '') {
                        event.preventDefault();
                        swal("Invalid Data!", "E-mail is required!", "error");
                    } else if (password.value === '') {
                        event.preventDefault();
                        swal("Invalid Data!", "Password is required", "error");
                    } else {
                        // Menampilkan pesan sukses saat form valid dan berhasil disubmit
                        form.submit();
                    }
        }

        body.onload = function(){
            tampil_pesan()
        }

        btnSimpan.onclick = function(event) {
            simpan(event); // Kirim event ke fungsi simpan
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
</body>
</html>
