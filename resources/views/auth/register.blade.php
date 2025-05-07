<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Register Page">
    <meta name="author" content="Your Website Name">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('back-end/assets/images/pesona_desa2.png') }}" type="image/png">
    <title>{{$title}} - PesonaDesa</title>

    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{ asset('back-end/css/simplebar.css') }}">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@100;200;300;400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset('back-end/css/feather.css') }}">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{ asset('back-end/css/daterangepicker.css') }}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('back-end/css/app-light.css') }}" id="lightTheme">
    <link rel="stylesheet" href="{{ asset('back-end/css/app-dark.css') }}" id="darkTheme" disabled>

    {{-- Alert --}}
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  </head>
  <body class="light" id="body" >

    <div class="wrapper vh-100 d-flex align-items-center justify-content-center" style="background: url('{{asset('front-end/images/bg1.jpg')}}') center/cover no-repeat;">
        <form class="col-lg-6 col-md-8 col-10 mx-auto p-4 shadow-lg" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-radius: 15px;" id="registerForm" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mx-auto text-center my-4">
                <img src="{{ asset('back-end/assets/images/pesona_desa.png') }}"
                alt="Logo Pesona Desa"
                class=" brand-md mb-3">
                <h2 class="h3 mt-3">{{$title}}</h2>
                <label class="form-label text-danger fs-5">( Khusus Pelanggan )</label>
            </div>

            <!-- Step 1: Data Pribadi -->
            <div class="form-step active">
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label text-muted fs-5">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control form-control-lg" id="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label text-muted fs-5">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="Masukkan Alamat Email" required>
                </div>

                <button type="button" class="btn btn-primary  next-step">Next</button>
            </div>

            <!-- Step 2: Akun -->
            <div class="form-step d-none">
                <div class="mb-3">
                    <label for="no_hp" class="form-label text-muted fs-5">No HP</label>
                    <input type="text" name="no_hp" class="form-control form-control-lg" id="no_hp" placeholder="Masukkan Nomor HP" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label text-muted fs-5">Alamat</label>
                    <textarea name="alamat" class="form-control form-control-lg" id="alamat" placeholder="Masukkan Alamat Rumah" required></textarea>
                </div>

                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                <button type="button" class="btn btn-primary next-step">Next</button>
            </div>

            <!-- Step 3: Keamanan -->
            <div class="form-step d-none">
                <div class="mb-3">
                    <label for="password" class="form-label text-muted fs-5">Kata Password</label>
                    <div class="input-group">
                        <input type="password" id="Password" name="password" class="form-control form-control-lg" placeholder="Masukkan Password" required>
                          <div class="input-group-append">
                              <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                  <i class="fa fa-eye-slash" id="togglePasswordIcon"></i>
                              </span>
                              </div>
                      </div>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label text-muted fs-5">Konfirmasi Password</label>
                    <div class="input-group">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" placeholder="Konfirmasi Password" required>
                          <div class="input-group-append">
                              <span class="input-group-text" onclick="togglePassword2()" style="cursor: pointer;">
                                  <i class="fa fa-eye-slash" id="togglePasswordIcon2"></i>
                              </span>
                              </div>
                      </div>
                </div>

                <p class="h6 text-warning">Note: Pastikan memiliki password yang kuat dan mudah diingat.</p>

                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                <button type="button" id="save" class="btn btn-info text-white"><i class="fe fe-save mr-1"></i> Register</button>
            </div>

            <p class="mt-3 text-center h6">
                Sudah Memiliki Akun? <a type="button" href="{{ route('login') }}" class="text-success fw-bold">Login Disini</a>
            </p>

            <p class="mt-3 mb-3 text-center">© {{ date('Y') }}</p>
        </form>
    </div>

    <div class="invisible" id="pesan">@isset($pesan) {{$pesan}} @endisset</div>

    <script>
        function togglePassword() {
            let passwordField = document.getElementById("Password");
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
        document.addEventListener("DOMContentLoaded", function () {
            const steps = document.querySelectorAll(".form-step");
            const nextBtns = document.querySelectorAll(".next-step");
            const prevBtns = document.querySelectorAll(".prev-step");
            let currentStep = 0;

            function updateStep() {
                steps.forEach((step, index) => {
                    step.classList.toggle("d-none", index !== currentStep);
                });
            }

            nextBtns.forEach(button => {
                button.addEventListener("click", () => {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        updateStep();
                    }
                });
            });

            prevBtns.forEach(button => {
                button.addEventListener("click", () => {
                    if (currentStep > 0) {
                        currentStep--;
                        updateStep();
                    }
                });
            });

            updateStep();
        });
    </script>

    <script>
        const btnSimpan = document.getElementById('save');
        const form = document.getElementById('registerForm');
        const body = document.getElementById('body');
        const status = document.getElementById('status');
        const pesan = document.getElementById('pesan');
        const nama = document.getElementById("nama_lengkap");
        const email = document.getElementById('email');
        const no_hp = document.getElementById("no_hp");
        const alamat = document.getElementById("alamat");
        const password = document.getElementById('Password');
        const password_confirmation = document.getElementById("password_confirmation");

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
                        swal("Invalid Data!", "Mohon isi bagian email!", "error");
                    } else if (nama.value === '') {
                        event.preventDefault();
                        swal("Invalid Data!", "Mohon isi bagian nama lengkap!", "error");
                    } else if (no_hp.value === '') {
                        event.preventDefault();
                        swal("Invalid Data!", "Mohon isi bagian nomor handphone!", "error");
                    } else if (alamat.value === '') {
                        event.preventDefault();
                        swal("Invalid Data!", "Mohon isi bagian alamat!", "error");
                    } else if (password.value === '') {
                        event.preventDefault();
                        swal("Invalid Data!", "Mohon isi bagian password!", "error");
                    } else if (password_confirmation.value === '') {
                        event.preventDefault();
                        swal("Invalid Data!", "Mohon isi bagian konfirmasi password!", "error");
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Alert --}}
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <!-- Scripts -->
    <script src="{{ asset('back-end/js/jquery.min.js') }}"></script>
    <script src="{{ asset('back-end/js/popper.min.js') }}"></script>
    <script src="{{ asset('back-end/js/moment.min.js') }}"></script>
    <script src="{{ asset('back-end/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('back-end/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('back-end/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('back-end/js/jquery.stickOnScroll.js') }}"></script>
    <script src="{{ asset('back-end/js/tinycolor-min.js') }}"></script>
    <script src="{{ asset('back-end/js/config.js') }}"></script>
    <script src="{{ asset('back-end/js/apps.js') }}"></script>

    <!-- Google Analytics (Optional) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() { dataLayer.push(arguments); }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>
  </body>
</html>
