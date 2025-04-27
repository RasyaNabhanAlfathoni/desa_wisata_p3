<nav class="topnav navbar navbar-light">
    <button
        type="button"
        class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar"
    >
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>

    {{-- <form class="form-inline mr-auto searchform text-muted">
        <input
            class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted"
            type="search"
            placeholder="Type something..."
            aria-label="Search"
        />
    </form> --}}

    <ul class="nav">
        <li class="nav-item">
            <a
                class="nav-link text-muted my-2"
                href=""
                id="modeSwitcher"
                data-mode="light"
            >
                <i class="fe fe-sun fe-16"></i>
            </a>
        </li>

        {{-- <li class="nav-item nav-notif">
            <a
                class="nav-link text-muted my-2"
                href="./#"
                data-toggle="modal"
                data-target=".modal-notif"
            >
                <span class="fe fe-bell fe-16"></span>
                <span class="dot dot-md bg-success"></span>
            </a>
        </li> --}}

        <!-- Notifikasi di Navbar -->
        <li class="nav-item nav-notif">
            <a
                class="nav-link text-muted my-2"
                href="#"
                data-toggle="modal"
                data-target=".modal-notif"
            >
                <span class="fe fe-bell fe-16"></span>
                @php
                    $jumlah_notif = $notif_user_baru->count() + $notif_karyawan_baru->count() + $notif_pelanggan_baru->count()
                        + $notif_reservasi_baru->count() + $notif_reservasi_diterima->count()
                        + $notif_berita_baru->count() + $notif_paket_wisata_baru->count();
                @endphp
                @if($jumlah_notif > 0)
                    <span class="dot dot-md bg-danger"></span>
                @endif
            </a>
        </li>

        <li class="nav-item dropdown">
            <a
                class="nav-link dropdown-toggle text-muted pr-0"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <span class="avatar avatar-sm mt-2">
                    <img
                        src="{{asset('back-end/assets/avatars/default.png')}}"
                        alt="..."
                        class="avatar-img rounded-circle"
                    />
                </span>
            </a>
            <div
                class="dropdown-menu dropdown-menu-right"
                aria-labelledby="navbarDropdownMenuLink"
            >
                <a class="dropdown-item text-info" href="{{route('profile.index')}}"><i class="fe fe-user fe-16 mr-1"></i>Profile</a>
                <form action="{{ route('logout') }}" method="POST">
                @csrf
                    <button type="submit" class="dropdown-item text-danger" href="#"><i class="fe fe-log-out fe-16 mr-1"></i>Logout</button>
                </form>
            </div>
        </li>
    </ul>

            <!-- Modal Notifikasi -->
            <div class="modal fade modal-notif modal-slide"
            tabindex="-1"
            role="dialog"
            aria-labelledby="notifModalLabel"
            aria-hidden="true" >
            <div class="modal-dialog modal-sm modal-dialog-scrollable" role="document" >
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
                        {{-- Admin --}}
                        @if(Auth::user()->level == 'admin')
                        @foreach($notif_karyawan_baru as $karyawan)
                            <a href="{{ route('kelola_data_karyawan.show', $karyawan->id) }}" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fe fe-briefcase fe-20 text-warning"></span></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-dark">Karyawan Baru</strong>
                                        <small class="text-muted">{{ $karyawan->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-muted small">Karyawan <strong>{{ $karyawan->nama_karyawan }}</strong> baru bergabung.</div>
                                </div>
                            </a>
                        @endforeach

                        @foreach($notif_pelanggan_baru as $pelanggan)
                            <a href="{{ route('kelola_data_pelanggan.show', $pelanggan->id) }}" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fe fe-user fe-20 text-success"></span></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-dark">Pelanggan Baru</strong>
                                        <small class="text-muted">{{ $pelanggan->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-muted small">Pelanggan <strong>{{ $pelanggan->nama_lengkap }}</strong> baru saja mendaftar.</div>
                                </div>
                            </a>
                        @endforeach
                    @endif

                    {{-- Admin, Pemilik --}}
                    @if(in_array(Auth::user()->level, ['admin', 'pemilik']))
                        @foreach($notif_berita_baru as $berita)
                            <a href="{{ route('kelola_berita.index') }}" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fe fe-book fe-20 text-info"></span></div>
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

                        @foreach($notif_paket_wisata_baru as $paket)
                            <a href="{{ route('kelola_paket_wisata.index') }}" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fe fe-map fe-20 text-primary"></span></div>
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
                    @endif

                    {{-- Admin, Pemilik, Bendahara --}}
                    @if(in_array(Auth::user()->level, ['admin', 'pemilik', 'bendahara']))
                        @foreach($notif_reservasi_baru as $reservasi)
                            <a href="{{ route('kelola_reservasi.show', $reservasi->id) }}" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fe fe-calendar fe-20 text-danger"></span></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-dark">Reservasi Baru</strong>
                                        <small class="text-muted">{{ $reservasi->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-muted small">Reservasi oleh Pelanggan <strong>{{ $reservasi->pelanggan->nama_lengkap }}</strong> untuk tanggal <strong>{{ $reservasi->tgl_reservasi_mulai }}</strong>.</div>
                                </div>
                            </a>
                        @endforeach
                    @endif

                    {{-- Pelanggan --}}
                    @if(Auth::user()->level == 'pelanggan')
                        @foreach($notif_reservasi_diterima as $reservasi)
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fe fe-check-circle fe-20 text-success"></span></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-dark">Reservasi Diterima</strong>
                                        <small class="text-muted">{{ $reservasi->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-muted small">Reservasi Anda untuk tanggal <strong>{{ $reservasi->tgl_reservasi_mulai }}</strong> telah diterima.</div>
                                </div>
                            </a>
                        @endforeach

                        @foreach($notif_berita_baru as $berita)
                            <a href="{{ route('berita_pelanggan') }}" class="list-group-item list-group-item-action d-flex align-items-start">
                                <div class="mr-3"><span class="fe fe-book-open fe-20 text-info"></span></div>
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
                    @endif

                        {{-- dst: berita baru, pembayaran masuk, paket wisata baru, dll --}}
                    </div>
                </div>

                <div class="modal-footer border-top">
                    <a href="{{ route('kelola_notifikasi.index') }}"
                        class="btn btn-outline-primary btn-block">
                        🔍 Lihat Semua Notifikasi
                    </a>
                </div>
            </div>
            </div>
            </div>
        </div>
</nav>

