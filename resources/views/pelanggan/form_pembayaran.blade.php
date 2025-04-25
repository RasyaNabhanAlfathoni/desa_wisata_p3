@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('content')
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('front-end/images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
                    <span class="mr-2"><a href="{{route('pelanggan.index')}}">{{$title}}</a></span>|
                    <span><a href="{{ route('pelanggan.paket-wisata.detail', $reservasi->id_paket) }}">{{ $reservasi->paketWisata->nama_paket }}</a></span> |
                    <span>Pembayaran</span>
                </p>
                <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Form Pembayaran</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section contact-section">
    <div class="container">
        <div class="row d-flex mb-5 contact-info">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Pembayaran Reservasi</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Detail Reservasi</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-4 font-weight-bold">Kode Reservasi:</div>
                                    <div class="col-md-8">{{ $reservasi->id }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 font-weight-bold">Paket Wisata:</div>
                                    <div class="col-md-8">{{ $reservasi->paketWisata->nama_paket }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 font-weight-bold">Tanggal Mulai:</div>
                                    <div class="col-md-8">{{ date('d-m-Y', strtotime($reservasi->tgl_reservasi_mulai)) }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 font-weight-bold">Tanggal Akhir:</div>
                                    <div class="col-md-8">{{ date('d-m-Y', strtotime($reservasi->tgl_reservasi_akhir)) }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 font-weight-bold">Jumlah Peserta:</div>
                                    <div class="col-md-8">{{ $reservasi->jumlah_peserta }} orang</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 font-weight-bold">Harga Paket:</div>
                                    <div class="col-md-8">Rp {{ number_format($reservasi->harga, 0, ',', '.') }}</div>
                                </div>
                                @if($reservasi->diskon > 0)
                                <div class="row mb-2">
                                    <div class="col-md-4 font-weight-bold">Diskon ({{ $reservasi->nilai_diskon }}%):</div>
                                    <div class="col-md-8">Rp {{ number_format($reservasi->diskon, 0, ',', '.') }}</div>
                                </div>
                                @endif
                                <div class="row mb-2">
                                    <div class="col-md-4 font-weight-bold">Total Bayar:</div>
                                    <div class="col-md-8 font-weight-bold text-primary">Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Instruksi Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <p>Silakan transfer total pembayaran ke rekening berikut:</p>
                                <div class="alert alert-info">
                                    <strong>Bank BCA</strong><br>
                                    Rekening: 1234567890<br>
                                    Atas Nama: PT Wisata Indonesia
                                </div>
                                <p>Setelah transfer, unggah bukti pembayaran pada form di bawah ini.</p>
                            </div>
                        </div>

                        <form action="{{ route('pelanggan.pembayaran.submit', $reservasi->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="file_bukti_tf">Bukti Pembayaran</label>
                                <input type="file" name="file_bukti_tf" id="file_bukti_tf" class="form-control @error('file_bukti_tf') is-invalid @enderror" required>
                                @error('file_bukti_tf')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">Upload bukti transfer dalam format JPG, PNG, atau PDF. Maks 3MB.</small>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        Konfirmasi Pembayaran
                                    </button>
                                    <a href="{{ route('pelanggan.reservasi.index') }}" class="btn btn-secondary btn-lg">
                                        Kembali ke Daftar Reservasi
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
