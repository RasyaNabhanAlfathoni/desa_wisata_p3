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
                    <span class="mr-2"><a href="{{ route('home') }}">Home</a></span> |
                    <span><a href="{{ route('paket-wisata.detail', $paket->id) }}">{{ $paket->nama_paket }}</a></span> |
                    <span>Reservasi</span>
                </p>
                <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Form Reservasi</h1>
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
                        <h4 class="mb-0">Form Reservasi Paket Wisata</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('paket-wisata.reservasi.submit', $paket->id) }}" method="POST">
                            @csrf

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">Nama Pelanggan</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" value="{{ $pelanggan->nama_lengkap }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">Paket Wisata</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" value="{{ $paket->nama_paket }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">Harga per Pack</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" value="Rp {{ number_format($paket->harga_per_pack, 0, ',', '.') }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tanggal_mulai" class="col-md-4 col-form-label">Tanggal Mulai</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                           id="tanggal_mulai" name="tanggal_mulai"
                                           min="{{ date('Y-m-d') }}"
                                           value="{{ old('tanggal_mulai') }}" required>
                                    @error('tanggal_mulai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tanggal_akhir" class="col-md-4 col-form-label">Tanggal Akhir</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control @error('tanggal_akhir') is-invalid @enderror"
                                           id="tanggal_akhir" name="tanggal_akhir"
                                           min="{{ date('Y-m-d') }}"
                                           value="{{ old('tanggal_akhir') }}" required>
                                    @error('tanggal_akhir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jumlah_peserta" class="col-md-4 col-form-label">Jumlah Peserta</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control @error('jumlah_peserta') is-invalid @enderror"
                                           id="jumlah_peserta" name="jumlah_peserta"
                                           min="1" max="{{ $paket->kuota_peserta }}"
                                           value="{{ old('jumlah_peserta', 1) }}" required>
                                    @error('jumlah_peserta')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="text-muted">Kuota tersedia: {{ $paket->kuota_peserta }} peserta</small>
                                </div>
                            </div>

                            @if($paket->peserta_diskon && $paket->nilai_diskon)
                                <div class="alert alert-info">
                                    <i class="icon-info"></i> Diskon {{ $paket->nilai_diskon }}% untuk pemesanan minimal {{ $paket->peserta_diskon }} peserta!
                                </div>
                            @endif

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                        Lanjutkan Reservasi
                                    </button>
                                    <a href="{{ route('paket-wisata.detail', $paket->id) }}" class="btn btn-secondary btn-lg">
                                        Kembali
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

@section('scripts')
<script>
$(document).ready(function() {
    // Validasi tanggal
    $('#tanggal_mulai, #tanggal_akhir').change(function() {
        const startDate = new Date($('#tanggal_mulai').val());
        const endDate = new Date($('#tanggal_akhir').val());

        if (startDate && endDate && startDate > endDate) {
            alert('Tanggal akhir tidak boleh sebelum tanggal mulai');
            $('#tanggal_akhir').val('');
        }
    });

    // Validasi kuota
    $('#jumlah_peserta').change(function() {
        const max = parseInt($(this).attr('max'));
        const value = parseInt($(this).val());

        if (value > max) {
            alert('Jumlah peserta melebihi kuota tersedia');
            $(this).val(max);
        }
    });
});
</script>
@endsection
