<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">

      {{-- Navbar Pelanggan --}}
      @if($title === 'Pelanggan')
      <a class="navbar-brand" href="{{route('pelanggan.index')}}">pesonaDesa.</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>
       <!-- Navbar Links -->
       <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
            <!-- Home -->
            <li class="nav-item @if(@isset($menu) and $menu === 'Home') active @endif">
                <a href="{{ route('pelanggan.index') }}" class="nav-link">Home</a>
            </li>

            <!-- Tentang Kami -->
            {{-- <li class="nav-item @if(@isset($menu) and $menu === 'About') active @endif">
                <a href="{{ route('pelanggan.about') }}" class="nav-link">Tentang Kami</a>
            </li> --}}

            <!-- Paket Wisata -->
            <li class="nav-item @if(@isset($menu) and $menu === 'Paket_wisata') active @endif">
                <a href="{{ route('pelanggan.paket_wisata') }}" class="nav-link">Paket Wisata</a>
            </li>

            <!-- Obyek Wisata -->
            <li class="nav-item @if(@isset($menu) and $menu === 'Obyek_wisata') active @endif">
                <a href="{{ route('pelanggan.obyek_wisata') }}" class="nav-link">Obyek Wisata</a>
            </li>

            <!-- Penginapan -->
            <li class="nav-item @if(@isset($menu) and $menu === 'Penginapan') active @endif">
                <a href="{{ route('pelanggan.penginapan') }}" class="nav-link">Penginapan</a>
            </li>

            <!-- Berita -->
            <li class="nav-item @if(@isset($menu) and $menu === 'Berita') active @endif">
                <a href="{{ route('pelanggan.berita') }}" class="nav-link">Berita</a>
            </li>

            <!-- Contact -->
            <li class="nav-item @if(@isset($menu) and $menu === 'Reservasiku') active @endif">
                <a href="{{route('pelanggan.reservasiku')}}" class="nav-link">Reservasiku</a>
            </li>

            <!-- Notifikasi di Navbar -->
            <li class="nav-item nav-notif">
                <a
                    class="nav-link position-relative"
                    href="#"
                    data-toggle="modal"
                    data-target=".modal-notif"
                >
                    <i class="fas fa-bell"></i>
                    @if($jumlah_notif > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $jumlah_notif }}
                        </span>
                    @endif
                </a>
            </li>

            <!-- Dropdown Profil -->
            <li class="nav-item dropdown d-none d-lg-block">
                <a
                    class="nav-link dropdown-toggle pr-0 d-flex align-items-center"
                    href="#"
                    id="navbarDropdownMenuLink"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <!-- Avatar -->
                    <img
                        src="{{ asset($pelanggan->foto ? 'storage/' . $pelanggan->foto : 'back-end/assets/avatars/default.png') }}"
                        alt="Profil"
                        class="rounded-circle mr-2"
                        width="30"
                        height="30"
                    />
                    <!-- Nama (Hanya Tampil di Desktop) -->
                    <span class="d-lg-inline font-weight-bold">{{ explode(' ', $pelanggan->nama_lengkap ?? 'User')[0] }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item text-info" href="{{ route('profile-pelanggan.index') }}"><i class="fas fa-user mr-2"></i>Profile</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt mr-2"></i>Logout</button>
                    </form>
                </div>
            </li>
            <!-- MOBILE VERSION (NO DROPDOWN) -->
            <li class="nav-item d-lg-none">
                <a class="nav-link d-flex align-items-center" href="{{ route('profile-pelanggan.index') }}">
                    <img
                        src="{{ asset($pelanggan->foto ? 'storage/' . $pelanggan->foto : 'back-end/assets/avatars/default.png') }}"
                        class="rounded-circle mr-2"
                        width="30"
                        height="30"
                    />
                    Profile
                </a>
            </li>

            <li class="nav-item d-lg-none">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-danger ml-4">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Modal Notifikasi -->
    <div class="modal fade modal-notif modal-slide"
        data-backdrop="false"
        tabindex="-1"
        role="dialog"
        aria-labelledby="notifModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-scrollable" role="document">
            <div class="modal-content shadow-lg rounded-lg">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title font-weight-bold text-dark" id="notifModalLabel">
                        🔔 Notifikasi Terbaru
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-0">
                    <div class="list-group list-group-flush">
                        @if($notif_reservasi_diproses->count() > 0 ||
                        $notif_reservasi_dibayar->count() > 0 ||
                        $notif_reservasi_dibatalkan->count() > 0 ||
                        $notif_paket_wisata_baru->count() > 0 ||
                        $notif_berita_baru->count() > 0)
                        {{-- Notifikasi Reservasi Diproses --}}
                        @foreach($notif_reservasi_diproses as $reservasi)
                            <a href="{{ route('pelanggan.paket-wisata.reservasi.detail', $reservasi->id) }}" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fas fa-receipt text-primary fa-lg"></span></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-dark">Reservasi Diproses</strong>
                                        <small class="text-muted">{{ $reservasi->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-muted small">Reservasi Anda untuk tanggal <strong>{{ $reservasi->tgl_reservasi_mulai }}</strong> sedang diproses.</div>
                                </div>
                            </a>
                        @endforeach

                        {{-- Notifikasi Reservasi Dibayar --}}
                        @foreach($notif_reservasi_dibayar as $reservasi)
                            <a href="{{ route('pelanggan.paket-wisata.reservasi.detail', $reservasi->id) }}" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fas fa-check-circle text-success fa-lg"></span></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-dark">Reservasi Dikonfirmasi</strong>
                                        <small class="text-muted">{{ $reservasi->updated_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-muted small">Reservasi Anda untuk tanggal <strong>{{ $reservasi->tgl_reservasi_mulai }}</strong> telah dikonfirmasi.</div>
                                </div>
                            </a>
                        @endforeach

                        {{-- Notifikasi Reservasi Dibatalkan --}}
                        @foreach($notif_reservasi_dibatalkan as $reservasi)
                            <a href="{{ route('pelanggan.paket-wisata.reservasi.detail', $reservasi->id) }}" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fas fa-times-circle text-danger fa-lg"></span></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-dark">Reservasi Dibatalkan</strong>
                                        <small class="text-muted">{{ $reservasi->updated_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-muted small">Reservasi Anda untuk tanggal <strong>{{ $reservasi->tgl_reservasi_mulai }}</strong> telah dibatalkan.</div>
                                </div>
                            </a>
                        @endforeach

                        {{-- Notifikasi Paket Wisata Baru --}}
                        @foreach($notif_paket_wisata_baru as $paket)
                            <a href="{{ route('pelanggan.paket_wisata') }}" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fas fa-map-marked text-primary fa-lg"></span></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-dark">Paket Wisata Baru</strong>
                                        <small class="text-muted">{{ $paket->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-muted small">
                                        <strong>{{ $paket->nama_paket }}</strong> — {{ Str::limit($paket->deskripsi, 70) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach

                        {{-- Notifikasi Berita Baru --}}
                        @foreach($notif_berita_baru as $berita)
                            <a href="{{ route('pelanggan.berita') }}" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fas fa-newspaper text-info fa-lg"></span></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-dark">Berita Baru</strong>
                                        <small class="text-muted">{{ $berita->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-muted small">
                                        <strong>{{ $berita->judul }}</strong> — {{ Str::limit($berita->berita, 70) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        @else
                        <div class="list-group-item text-center py-4">
                            <span class="fas fa-bell-slash fa-2x text-muted mb-2"></span>
                            <p class="text-muted mb-0">Tidak ada notifikasi baru</p>
                            <small class="text-muted">Anda tidak memiliki notifikasi minggu ini</small>
                        </div>
                    @endif
                    </div>
                </div>

                <div class="modal-footer border-top">
                    <a href="{{ route('pelanggan.notifikasi') }}" class="btn btn-outline-primary btn-block">
                        🔍 Lihat Semua Notifikasi
                    </a>
                </div>
            </div>
        </div>
    </div>

      {{-- Navbar Guest Home --}}
      @elseif ($title === 'Home')
      <a class="navbar-brand" href="{{route('home')}}">pesonaDesa.</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>
      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item @if(@isset($menu) and $menu === 'Home') active @endif"><a href="{{route('home')}}" class="nav-link">Home</a></li>
          <li class="nav-item @if(@isset($menu) and $menu === 'About') active @endif"><a href="{{route('about')}}" class="nav-link">Tentang Kami</a></li>
          <li class="nav-item @if(@isset($menu) and $menu === 'Paket_wisata') active @endif"><a href="{{route('paket_wisata')}}" class="nav-link">Paket Wisata</a></li>
          <li class="nav-item @if(@isset($menu) and $menu === 'Obyek_wisata') active @endif"><a href="{{route('obyek_wisata')}}" class="nav-link">Obyek Wisata</a></li>
          <li class="nav-item @if(@isset($menu) and $menu === 'Penginapan') active @endif"><a href="{{route('penginapan')}}" class="nav-link">Penginapan</a></li>
          <li class="nav-item @if(@isset($menu) and $menu === 'Berita') active @endif"><a href="{{route('berita')}}" class="nav-link">Berita</a></li>
          <li class="nav-item cta"><a href="{{route('login')}}" class="nav-link"><span>Login</span></a></li>
        </ul>
      </div>

      @endif
    </div>
  </nav>
    <!-- END nav -->
