<aside
    class="sidebar-left border-right bg-white shadow"
    id="leftSidebar"
    data-simplebar
>
    <a
        href="#"
        class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3"
        data-toggle="toggle"
    >
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>

    {{-- Sidebar Admin --}}
    @if ($title === 'Admin')

    <!-- nav bar -->
    <div class="w-100 mb-4 d-flex align-items-center justify-content-center">
        <a class="navbar-brand d-flex align-items-center mt-3 " href="{{route('admin.index')}}">
            <img
                    src="{{ asset('back-end/assets/images/pesona_desa2.png') }}"
                    alt="Logo Pesona Desa"
                    class="navbar-brand-img brand-sm"
                    style="width: 48px; height: 38px;"
                />
                <g>
                    <polygon class="st0" points="78,105 15,105 24,87 87,87" />
                    <polygon class="st0" points="96,69 33,69 42,51 105,51" />
                    <polygon class="st0" points="78,33 15,33 24,15 87,15" />
                </g>
            </svg>
            <h2 class="h5 page-title mb-0 ms-2 nav-heading">pesonaDesa.</h2>
        </a>
    </div>

    <nav class="vertnav navbar navbar-light">
        <ul class="navbar-nav flex-fill w-100 mb-2">
                <a
                    class="nav-link nav-item @if(@isset($menu) and $menu === 'Admin') active @endif"
                    href="{{route('admin.index')}}"
                >
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text nav-heading">Dashboard</span
                    ><span class="sr-only">(current)</span>
                </a>
        </ul>

        {{-- Data Pengguna --}}
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Data Karyawan & Pelanggan</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 @if(@isset($menu) and $menu === 'Data_karyawan') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_data_karyawan.index')}}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">Data Karyawan</span>
                </a>
            </li>
            <li class="nav-item w-100 @if(@isset($menu) and $menu === 'data_pelanggan') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_data_pelanggan.index')}}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">Data Pelanggan</span>
                </a>
            </li>
        </ul>

        {{-- Data Wisata --}}
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Data Wisata</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 @if(@isset($menu) and $menu === 'obyek_wisata') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_obyek_wisata.index')}}">
                    <i class="fe fe-compass fe-16"></i>
                    <span class="ml-3 item-text">Kelola Obyek Wisata</span>
                </a>
            </li>
            <li class="nav-item w-100 @if(@isset($menu) and $menu === 'paket_wisata') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_paket_wisata.index')}}">
                    <i class="fe fe-map fe-16"></i>
                    <span class="ml-3 item-text">Kelola Paket Wisata</span>
                </a>
            </li>
            <li class="nav-item w-100 @if(@isset($menu) and $menu === 'kategori_wisata') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_kategori_wisata.index')}}">
                    <i class="fe fe-airplay fe-16"></i>
                    <span class="ml-3 item-text">Kelola Kategori Wisata</span>
                </a>
            </li>
            <li class="nav-item w-100 @if(@isset($menu) and $menu === 'penginapan') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_penginapan.index')}}">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Kelola Penginapan</span>
                </a>
            </li>
        </ul>

        {{-- Data Berita --}}
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Data Berita</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 @if(@isset($menu) and $menu === 'berita') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_berita.index')}}">
                    <i class="fe fe-book-open fe-16"></i>
                    <span class="ml-3 item-text">Kelola Berita</span>
                </a>
            </li>
            <li class="nav-item w-100  @if(@isset($menu) and $menu === 'kategori_berita') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_kategori_berita.index')}}">
                    <i class="fe fe-file-text fe-16"></i>
                    <span class="ml-3 item-text">Kelola Kategori Berita</span>
                </a>
            </li>
        </ul>

        {{-- Notifikasi & Pengaturan --}}
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Notifikasi</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 @if(isset($menu) && $menu === 'Notifikasi') active @endif">
                <a class="nav-link nav-item d-flex align-items-center justify-content-between" href="{{ route('kelola_notifikasi.index') }}">
                    <div>
                        <i class="fe fe-bell fe-16"></i>
                        <span class="ml-3 item-text">Notifikasi</span>
                    </div>
                    {{-- $notifBaru dari AppServiceProvider --}}
                    @if(isset($notifBaru) && $notifBaru)
                        <span class="badge badge-danger ml-2">!</span>
                    @endif
                </a>
            </li>

            {{-- <li class="nav-item w-100 @if(@isset($menu) and $menu === '') active @endif">
                <a class="nav-link nav-item " href="widgets.html">
                    <i class="fe fe-settings fe-16"></i>
                    <span class="ml-3 item-text">Pengaturan</span>
                </a>
            </li> --}}
        </ul>
    </nav>

    {{-- Sidebar Pemilik --}}
    @elseif ($title === 'Pemilik')

    <!-- nav bar -->
    <div class="w-100 mb-4 d-flex align-items-center justify-content-center">
        <a class="navbar-brand d-flex align-items-center mt-3" href="{{route('pemilik.index')}}">
            <img
                src="{{ asset('back-end/assets/images/pesona_desa2.png') }}"
                alt="Logo Pesona Desa"
                class="navbar-brand-img brand-sm"
                style="width: 48px; height: 38px;"
            />
                <g>
                    <polygon class="st0" points="78,105 15,105 24,87 87,87" />
                    <polygon class="st0" points="96,69 33,69 42,51 105,51" />
                    <polygon class="st0" points="78,33 15,33 24,15 87,15" />
                </g>
            </svg>
            <h2 class="h5 page-title mb-0 ms-2">pesonaDesa.</h2>
        </a>
    </div>

    <nav class="vertnav navbar navbar-light">
        <ul class="navbar-nav flex-fill w-100 mb-2">
                <a
                    href="{{route('pemilik.index')}}"
                    class="nav-link nav-item @if(@isset($menu) and $menu === 'Pemilik') active @endif"
                >
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span
                    ><span class="sr-only">(current)</span>
                </a>
        </ul>

        {{-- Data Reservasi & Keuangan --}}
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Data Reservasi & Keuangan</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100  @if(@isset($menu) and $menu === 'reservasi') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_reservasi.index')}}">
                    <i class="fe fe-calendar fe-16"></i>
                    <span class="ml-3 item-text">Kelola Reservasi</span>
                </a>
            </li>
            <li class="nav-item w-100  @if(@isset($menu) and $menu === 'keuangan') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_keuangan.index')}}">
                    <i class="fe fe-dollar-sign fe-16"></i>
                    <span class="ml-3 item-text">Kelola Keuangan</span>
                </a>
            </li>
        </ul>

        {{-- Notifikasi & Pengaturan --}}
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Notifikasi</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 @if(@isset($menu) and $menu === 'Notifikasi') active @endif">
                <a class="nav-link nav-item " href="{{route('kelola_notifikasi.index')}}">
                    <i class="fe fe-bell fe-16"></i>
                    <span class="ml-3 item-text">Notifikasi</span>
                </a>
            </li>
        </ul>
    </nav>

    {{-- Sidebar Bendahara --}}
    @elseif ($title === 'Bendahara')

    <!-- nav bar -->
    <div class="w-100 mb-4 d-flex align-items-center justify-content-center">
        <a class="navbar-brand d-flex align-items-center mt-3 " href="{{route('bendahara.index')}}">
            <img
                src="{{ asset('back-end/assets/images/pesona_desa2.png') }}"
                alt="Logo Pesona Desa"
                class="navbar-brand-img brand-sm mb-3"
                style="width: 48px; height: 38px;"
            />
                <g>
                    <polygon class="st0" points="78,105 15,105 24,87 87,87" />
                    <polygon class="st0" points="96,69 33,69 42,51 105,51" />
                    <polygon class="st0" points="78,33 15,33 24,15 87,15" />
                </g>
            </svg>
            <h2 class="h5 page-title mb-0 ms-2">pesonaDesa.</h2>
        </a>
    </div>

    <nav class="vertnav navbar navbar-light">
        <ul class="navbar-nav flex-fill w-100 mb-2">
                <a
                    href="{{route('bendahara.index')}}"
                    class="nav-link nav-item @if(@isset($menu) and $menu === 'Bendahara') active @endif"
                >
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span
                    ><span class="sr-only">(current)</span>
                </a>
        </ul>

        {{-- Data Reservasi & Keuangan --}}
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Data Reservasi & Keuangan</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100  @if(@isset($menu) and $menu === 'reservasi') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_reservasi.index')}}">
                    <i class="fe fe-calendar fe-16"></i>
                    <span class="ml-3 item-text">Kelola Reservasi</span>
                </a>
            </li>
            <li class="nav-item w-100  @if(@isset($menu) and $menu === 'keuangan') active @endif">
                <a class="nav-link nav-item" href="{{route('kelola_keuangan.index')}}">
                    <i class="fe fe-dollar-sign fe-16"></i>
                    <span class="ml-3 item-text">Kelola Keuangan</span>
                </a>
            </li>
        </ul>

        {{-- Notifikasi & Pengaturan --}}
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Notifikasi</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 @if(@isset($menu) and $menu === 'Notifikasi') active @endif">
                <a class="nav-link nav-item " href="{{route('kelola_notifikasi.index')}}">
                    <i class="fe fe-bell fe-16"></i>
                    <span class="ml-3 item-text">Notifikasi</span>
                </a>
            </li>
        </ul>
    </nav>

    {{-- No Auth Back End User --}}
    @else
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
    </nav>
    @endif
</aside>
