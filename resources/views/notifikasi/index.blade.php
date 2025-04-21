@extends('be.master')
@section('navbar')
    @include('be.navbar')
@endsection
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<!-- main -->
<main role="main" class="main-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <p class="text-muted">Pages / <span class="h6">{{$title}}</span></p>
                        <h2 class="h4 page-title" style="margin-top: -10px;">{{$page}}</h2>
                    </div>
                    <div class="col-auto">
                        <form method="GET" action="" class="form-inline">
                            <label for="filter" class="mr-2 text-muted">Filter Waktu:</label>
                            <select name="filter" id="filter" class="form-control form-control-sm" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                                <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                                <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        {{-- <span class="fe fe-bell fe-20 mr-2"></span> --}}
                        <h4 class="mb-0 text-white">🔔 Semua Notifikasi </h4>
                    </div>
                    <div class="card-body p-0">
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
                                            <div class="text-muted small">Reservasi oleh Pelanggan <strong>{{ $reservasi->pelanggan->nama_lengkap }}</strong> untuk tanggal <strong>{{ $reservasi->tanggal_reservasi }}</strong>.</div>
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
                                            <div class="text-muted small">Reservasi Anda untuk tanggal <strong>{{ $reservasi->tanggal_reservasi }}</strong> telah diterima.</div>
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

                            @if(collect([$notif_user_baru, $notif_karyawan_baru, $notif_pelanggan_baru, $notif_reservasi_baru, $notif_reservasi_diterima, $notif_berita_baru, $notif_paket_wisata_baru])->every->isEmpty())
                                <div class="p-4 text-center text-muted">
                                    <span class="fe fe-bell-off fe-24 mb-2"></span>
                                    <p class="mb-0">Tidak ada notifikasi pada periode ini.</p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection
