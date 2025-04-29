{{-- profile-pelanggan/index.blade.php --}}
@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection
@section('content')

<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('front-end/images/lsp/wisata/jalanan utama/Penglipuran.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
        <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
            <h1 class="mb-2 bread">Profil Saya</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('pelanggan.index') }}">Beranda <i class="ion-ios-arrow-forward"></i></a></span> <span>Profil <i class="ion-ios-arrow-forward"></i></span></p>
        </div>
      </div>
    </div>
  </div>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        @if($user->pelanggan && $user->pelanggan->foto)
                            <img src="{{ asset('Storage/' . $user->pelanggan->foto) }}"
                                 class="rounded-circle mb-3"
                                 width="200" height="200"
                                 alt="Foto Profil">
                        @else
                            <img src="{{ asset('front-end/images/default-profile.png') }}"
                                 class="rounded-circle mb-3"
                                 width="200" height="200"
                                 alt="Foto Profil Default">
                        @endif

                        <h4 class="mb-2">{{ $user->pelanggan->nama_pelanggan ?? 'Pelanggan' }}</h4>
                        <p class="text-muted mb-3">Member sejak {{ $user->created_at->format('d M Y') }}</p>

                        <a href="{{ route('profile-pelanggan.edit', $user->id) }}" class="btn btn-primary btn-block">
                            <i class="icon-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Informasi Akun</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted">Email</label>
                                <p class="h5">{{ $user->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted">Status Akun</label>
                                <p class="h5">
                                    @if ($user->aktif)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3">Informasi Pribadi</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted">Nama Lengkap</label>
                                <p class="h5">{{ $user->pelanggan->nama_lengkap ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted">Nomor HP</label>
                                <p class="h5">{{ $user->pelanggan->no_hp ?? '-' }}</p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="text-muted">Alamat</label>
                                <p class="h5">{{ $user->pelanggan->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if(count($reservasis) > 0)
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0">Riwayat Reservasi Terakhir</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Paket</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservasis->take(3) as $reservasi)
                                    <tr>
                                        <td>{{ $reservasi->id }}</td>
                                        <td>{{ $reservasi->paket->nama_paket }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservasi->tgl_reservasi_mulai)->format('d M Y') }}</td>
                                        <td>
                                            @if($reservasi->status == 'selesai')
                                                <span class="badge badge-success">Selesai</span>
                                            @elseif($reservasi->status == 'dibatalkan')
                                                <span class="badge badge-danger">Dibatalkan</span>
                                            @elseif($reservasi->status == 'dibayar')
                                                <span class="badge badge-primary">Dibayar</span>
                                            @else
                                                <span class="badge badge-warning">Pesan</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <a href="{{ route('reservasi.detail', $reservasi->id) }}" class="btn btn-sm btn-info">
                                                Detail
                                            </a> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- <div class="invisible" id="status">@isset($status) {{$status}} @endisset</div> --}}
<div class="invisible" id="pesan">@isset($pesan) {{$pesan}} @endisset</div>

<script>
    const body = document.getElementById('body');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const frm = document.getElementById('frmHapus');

    function tampil_pesan(){
        let pesan = "{{ session('pesan') }}";
        let error = "{{ session('error') }}";

        if (pesan.trim() !== '') {
            swal('Good Job', pesan.trim(), 'success');
        }

        if (error.trim() !== '') {
            swal('Error', error.trim(), 'error');
        }
        // if(pesan.innerHTML.trim() !== ''){
        // swal('Good Job', pesan.innerHTML, 'success')
        // // }else if(status.innerHTML.trim() === 'edit'){
        // // swal('Good Job', pesan.innerHTML, 'success')
        // }
    }

    body.onload = function(){
        tampil_pesan()
    }

</script>
@endsection
