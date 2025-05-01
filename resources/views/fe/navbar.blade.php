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

            <!-- Dropdown Profil -->
            <li class="nav-item dropdown">
                <a
                    class="nav-link dropdown-toggle text-muted pr-0 d-flex align-items-center"
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
                    <span class="d-lg-inline text-dark font-weight-bold">{{ explode(' ', $pelanggan->nama_lengkap ?? 'User')[0] }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item text-info" href="{{ route('profile-pelanggan.index') }}"><i class="fas fa-user mr-2"></i>Profile</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt mr-2"></i>Logout</button>
                    </form>
                </div>
            </li>
        </ul>
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
