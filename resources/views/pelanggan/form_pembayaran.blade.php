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
                <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
                    <span class="mr-2"><a href="{{route('pelanggan.index')}}">{{$title}}</a></span>|
                    <span><a href="{{ route('pelanggan.paket-wisata.detail', $reservasi->id_paket) }}">{{ $reservasi->paket->nama_paket }}</a></span> |
                    <span>Pembayaran</span>
                </p>
                <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Form Pembayaran</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section contact-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0 text-center text-white"><i class="icon-credit-card mr-2"></i> Form Pembayaran Reservasi</h4>
                    </div>
                    <div class="card-body p-4">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="icon-warning"></i> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="icon-check"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Kolom Kiri - Detail Reservasi -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="icon-user mr-2"></i> Informasi Pelanggan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <!-- Avatar -->
                                                <img
                                                src="{{ asset($pelanggan->foto ? 'storage/' . $pelanggan->foto : 'back-end/assets/avatars/default.png') }}"
                                                alt="Profil"
                                                class="rounded-circle mr-2"
                                                width="50"
                                                height="50"
                                            />
                                            <div>
                                                <h5 class="mb-0">{{ Auth::user()->pelanggan->nama_lengkap }}</h5>
                                                <h6 class="text-muted">{{ Auth::user()->email }}</h6>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong><i class="icon-phone mr-2"></i> No. HP:</strong></p>
                                                <p>{{ Auth::user()->pelanggan->no_hp }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong><i class="icon-location-pin mr-2"></i> Alamat:</strong></p>
                                                <p>{{ Auth::user()->pelanggan->alamat }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan - Detail Reservasi -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="icon-calendar mr-2"></i> Detail Reservasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th width="40%">Kode Reservasi</th>
                                                        <td>: <span class="badge badge-primary">{{ $reservasi->id }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Paket Wisata</th>
                                                        <td>: {{ $reservasi->paket->nama_paket }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Reservasi</th>
                                                        <td>: {{ date('d-m-Y', strtotime($reservasi->tgl_reservasi_mulai)) }} s/d {{ date('d-m-Y', strtotime($reservasi->tgl_reservasi_akhir)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Durasi</th>
                                                        <td>: {{ $reservasi->paket->durasi_hari }} Hari</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Jumlah Peserta</th>
                                                        <td>: {{ $reservasi->jumlah_peserta }} orang</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Harga per orang</th>
                                                        <td>: Rp {{ number_format($reservasi->paket->harga_per_pack, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @if($reservasi->diskon > 0)
                                                    <tr class="text-success">
                                                        <th>Diskon ({{ $reservasi->paket->nilai_diskon }}%)</th>
                                                        <td>: -Rp {{ number_format($reservasi->diskon, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr class="font-weight-bold">
                                                        <th>Total Bayar</th>
                                                        <td>: Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Instruksi Pembayaran -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="icon-credit-card mr-2"></i> Instruksi Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-primary">
                                    <h5 class="alert-heading"><i class="icon-info"></i> Silakan lakukan pembayaran sebelum:</h5>
                                    <p class="mb-2"><strong>{{ date('d F Y H:i', strtotime($reservasi->created_at->addDays(1))) }}</strong></p>
                                    <hr>
                                    <p class="mb-0">Total yang harus dibayarkan: <strong class="h5">Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</strong></p>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="card border-primary">
                                            <div class="card-header bg-primary text-white">
                                                <h6 class="mb-0"><i class="icon-wallet mr-2"></i> Transfer Bank</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex mb-3">
                                                    <div class="bank-logo mr-3">
                                                        <img src="{{ asset('front-end/images/bca.png') }}" alt="BCA" style="height: 30px; width: 40px;">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Bank BCA</h6>
                                                        <p class="mb-0">1234567890<br>PT PesonaDesa Nusantara</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="bank-logo mr-3">
                                                        <img src="{{ asset('front-end/images/bri.png') }}" alt="BRI" style="height: 30px; width: 40px; ">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Bank BRI</h6>
                                                        <p class="mb-0">9876543210<br>PT PesonaDesa Nusantara</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-warning mt-3">
                                            <h6 class="alert-heading"><i class="icon-bell"></i> Penting!</h6>
                                            <ul class="mb-0 pl-3">
                                                <li>Harap transfer sesuai dengan total pembayaran</li>
                                                <li>Simpan bukti transfer Anda</li>
                                                <li>Proses verifikasi membutuhkan waktu 1x24 jam</li>
                                                <li>Setelah transfer, unggah bukti pembayaran pada form di bawah ini</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Upload Bukti Pembayaran -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="icon-upload mr-2"></i> Upload Bukti Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('pelanggan.paket-wisata.pembayaran.submit', $reservasi->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="file_bukti_tf" class="font-weight-bold">Bukti Transfer</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('file_bukti_tf') is-invalid @enderror" id="file_bukti_tf" name="file_bukti_tf" required>
                                            <label class="custom-file-label" for="file_bukti_tf">Pilih file...</label>
                                            @error('file_bukti_tf')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Format: JPG, PNG, atau PDF (Maksimal 3MB)</small>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <a href="{{ route('pelanggan.paket-wisata.reservasi.detail', $reservasi->id) }}" class="btn btn-outline-secondary btn-lg px-4">
                                            <i class="icon-arrow-left mr-2"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="icon-check mr-2"></i> Konfirmasi Pembayaran
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #f8f9fa;
        color: #6c757d;
    }

    .bank-logo {
        width: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
    }

    .custom-file-label::after {
        content: "Browse";
    }

    @media (max-width: 768px) {
        .btn-lg {
            padding: 0.5rem 1rem;
            font-size: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Menampilkan nama file yang dipilih
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("file_bukti_tf").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush
