@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('content')
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('storage/' . $reservasi->paket->foto1) }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
                    <span class="mr-2"><a href="{{route('pelanggan.index')}}">Home</a></span> |
                    <span class="mr-2"><a href="{{route('pelanggan.reservasiku')}}">Reservasiku</a></span> |
                    <span>Detail Reservasi #{{ $reservasi->id }}</span>
                </p>
                <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Detail Reservasi</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-white"><i class="icon-calendar mr-2"></i> Detail Reservasi #{{ $reservasi->id }}</h4>
                            <span class="badge badge-light">
                                @php
                                    $statusClass = '';
                                    switch($reservasi->status_reservasi_wisata) {
                                        case 'pesan':
                                            $statusClass = 'text-info';
                                            break;
                                        case 'dibayar':
                                            $statusClass = 'text-primary';
                                            break;
                                        case 'dikonfirmasi':
                                            $statusClass = 'text-success';
                                            break;
                                        case 'dibatalkan':
                                            $statusClass = 'text-danger';
                                            break;
                                        case 'selesai':
                                            $statusClass = 'text-secondary';
                                            break;
                                        default:
                                            $statusClass = 'text-warning';
                                    }
                                @endphp
                                <span class="{{ $statusClass }} font-weight-bold">
                                    {{ ucfirst($reservasi->status_reservasi_wisata) }}
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if(session('pesan'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="icon-check"></i> {{ session('pesan') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="icon-warning"></i> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Kolom Kiri - Informasi Paket -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="icon-gift mr-2"></i> Paket Wisata</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('storage/' . $reservasi->paket->foto1) }}"
                                                 alt="{{ $reservasi->paket->nama_paket }}"
                                                 class="img-fluid rounded"
                                                 style="max-height: 200px;">
                                        </div>
                                        <h4 class="text-center">{{ $reservasi->paket->nama_paket }}</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong><i class="icon-calendar mr-2"></i> Durasi:</strong></p>
                                                <p>{{ $reservasi->paket->durasi_hari }} Hari</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong><i class="icon-tag mr-2"></i> Harga per orang:</strong></p>
                                                <p>Rp {{ number_format($reservasi->paket->harga_per_pack, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <p><strong><i class="icon-info mr-2"></i> Deskripsi:</strong></p>
                                            <p>{{ $reservasi->paket->deskripsi }}</p>
                                        </div>
                                        <div class="mt-3">
                                            <p><strong><i class="icon-list mr-2"></i> Fasilitas:</strong></p>
                                            <ul>
                                                @foreach(explode(',', $reservasi->paket->fasilitas) as $fasilitas)
                                                <li>{{ trim($fasilitas) }}</li>
                                                @endforeach
                                            </ul>
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
                                        <div class="mb-4">
                                            <h5 class="border-bottom pb-2"><i class="icon-user mr-2"></i> Data Pelanggan</h5>
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="{{ asset($pelanggan->foto ? 'storage/' . $pelanggan->foto : 'back-end/assets/avatars/default.png') }}"
                                                     alt="Profil"
                                                     class="rounded-circle mr-3"
                                                     width="60"
                                                     height="60">
                                                <div>
                                                    <h5 class="mb-0">{{ $pelanggan->nama_lengkap }}</h5>
                                                    <p class="mb-0 text-muted">{{ $pelanggan->user->email }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong><i class="icon-phone mr-2"></i> No. HP:</strong></p>
                                                    <p>{{ $pelanggan->no_hp }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong><i class="icon-location-pin mr-2"></i> Alamat:</strong></p>
                                                    <p>{{ $pelanggan->alamat }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <h5 class="border-bottom pb-2"><i class="icon-notebook mr-2"></i> Informasi Reservasi</h5>
                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <th width="40%">Tanggal Reservasi</th>
                                                            <td>: {{ date('d F Y', strtotime($reservasi->created_at)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Periode Wisata</th>
                                                            <td>: {{ date('d F Y', strtotime($reservasi->tgl_reservasi_mulai)) }} s/d {{ date('d F Y', strtotime($reservasi->tgl_reservasi_akhir)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Jumlah Peserta</th>
                                                            <td>: {{ $reservasi->jumlah_peserta }} orang</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Harga per orang</th>
                                                            <td>: Rp {{ number_format($reservasi->harga, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @if($reservasi->nilai_diskon > 0)
                                                        <tr class="text-success">
                                                            <th>Diskon ({{ $reservasi->nilai_diskon }}%)</th>
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

                                        <!-- Bukti Pembayaran -->
                                        <div class="mb-4">
                                            <h5 class="border-bottom pb-2"><i class="icon-credit-card mr-2"></i> Pembayaran</h5>
                                            @if($reservasi->file_bukti_tf)
                                                <div class="alert alert-success">
                                                    <p><strong>Status Pembayaran:</strong>
                                                        @if($reservasi->status_reservasi_wisata == 'pesan')
                                                            <span class="badge badge-warning">Sedang Proses</span>
                                                        @elseif($reservasi->status_reservasi_wisata == 'dibayar')
                                                            <span class="badge badge-primary">Sudah Dikonfirmasi</span>
                                                        @elseif($reservasi->status_reservasi_wisata == 'dibatalkan')
                                                            <span class="badge badge-danger">Telah Dibatalkan</span>
                                                        @elseif($reservasi->status_reservasi_wisata == 'selesai')
                                                            <span class="badge badge-success">Selesai</span>
                                                        @endif
                                                    </p>
                                                    <p><strong>Bukti Transfer:</strong></p>
                                                    <a href="{{ asset('storage/' . $reservasi->file_bukti_tf) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-info">
                                                        <i class="icon-download mr-1"></i> Lihat Bukti Transfer
                                                    </a>

                                                    @php
                                                        $bendahara = App\Models\User::where('level', 'bendahara')
                                                                        ->where('aktif', true)
                                                                        ->with('karyawan')
                                                                        ->first();

                                                        $no_hp_bendahara = $bendahara->karyawan->no_hp ?? '628123456789';
                                                        $no_hp_bendahara = preg_replace('/^0/', '62', $no_hp_bendahara);

                                                        $pesan_wa = urlencode("Halo, saya {$pelanggan->nama_lengkap} ingin menanyakan status konfirmasi pembayaran reservasi ID {$reservasi->id}.");
                                                    @endphp

                                                    @if($reservasi->status_reservasi_wisata == 'pesan')
                                                        <button type="button"
                                                                class="btn btn-sm btn-warning mt-3"
                                                                data-toggle="modal"
                                                                data-target="#gantiBuktiModal">
                                                            <i class="icon-refresh mr-1"></i> Ganti Bukti Transfer
                                                        </button>
                                                        <div class="mt-3">
                                                            <div class="alert alert-info">
                                                                <p class="mb-2">
                                                                    ⏳ <strong>Menunggu Konfirmasi Pembayaran</strong><br>
                                                                    Pembayaran Anda sedang diverifikasi oleh tim kami.
                                                                </p>

                                                                <p class="mb-2">
                                                                    Proses konfirmasi maksimal <strong>3 x 24 jam</strong> pada hari kerja.
                                                                    Jika dalam waktu tersebut belum ada konfirmasi, silakan hubungi tim kami.
                                                                </p>

                                                                <a href="https://wa.me/{{ $no_hp_bendahara }}?text={{ $pesan_wa }}"
                                                                target="_blank"
                                                                class="btn btn-success btn-sm">
                                                                    <i class="icon-whatsapp mr-1"></i> Hubungi Kami
                                                                </a>
                                                            </div>
                                                        </div>

                                                    @elseif ($reservasi->status_reservasi_wisata == 'selesai')
                                                        <div class="mt-3">
                                                            <div class="alert alert-success">
                                                                <p class="mb-2">
                                                                    🏡 <strong>Wisata Selesai. Terima Kasih!</strong><br>
                                                                    Kami mengucapkan terima kasih atas kepercayaan Anda berkunjung ke Desa Wisata kami. Senang bisa menjadi bagian dari cerita liburan Anda. Jangan lupa rekomendasikan kami kepada kerabat!
                                                                </p>
                                                            </div>
                                                        </div>

                                                    @elseif($reservasi->status_reservasi_wisata == 'dibayar')
                                                        @php
                                                            $admin = App\Models\User::where('level', 'admin')
                                                                        ->where('aktif', true)
                                                                        ->with('karyawan')
                                                                        ->first();

                                                            $no_hp_admin = $admin->karyawan->no_hp ?? '628123456789';
                                                            $no_hp_admin = preg_replace('/^0/', '62', $no_hp_admin);

                                                            $pesan_admin = urlencode("Halo, saya {$pelanggan->nama_lengkap} dengan reservasi ID {$reservasi->id}. Saya ingin menanyakan informasi lebih lanjut terkait persiapan wisata.");
                                                        @endphp

                                                        <div class="mt-3">
                                                            <div class="alert alert-primary">
                                                                <p class="mb-2">
                                                                    ✅ <strong>Reservasi Anda Telah Dikonfirmasi</strong><br>
                                                                    Pembayaran Anda telah kami terima dan reservasi telah berhasil diproses.
                                                                </p>

                                                                <hr>

                                                                <p class="mb-2">
                                                                    🧳 <strong>Persiapan Sebelum Keberangkatan:</strong>
                                                                </p>
                                                                <ul class="mb-2">
                                                                    <li>Pastikan kondisi tubuh dalam keadaan sehat</li>
                                                                    <li>Siapkan perlengkapan pribadi sesuai kebutuhan</li>
                                                                    <li>Membawa dokumen penting (jika diperlukan)</li>
                                                                    <li>Datang tepat waktu sesuai jadwal keberangkatan</li>
                                                                </ul>

                                                                <p class="mb-2">
                                                                    📅 <strong>Jadwal Wisata Anda:</strong><br>
                                                                    {{ date('d F Y', strtotime($reservasi->tgl_reservasi_mulai)) }}
                                                                </p>

                                                                <p class="mb-2">
                                                                    Kami sangat menantikan kehadiran Anda 😊
                                                                </p>

                                                                <hr>

                                                                <p class="mb-2">
                                                                    📞 <strong>Butuh bantuan?</strong><br>
                                                                    Untuk informasi lebih lanjut, silakan hubungi admin kami:
                                                                </p>

                                                                <a href="https://wa.me/{{ $no_hp_admin }}?text={{ $pesan_admin }}"
                                                                target="_blank"
                                                                class="btn btn-success btn-sm">
                                                                    <i class="icon-whatsapp mr-1"></i> Hubungi Admin
                                                                </a>
                                                            </div>
                                                        </div>

                                                    @elseif($reservasi->status_reservasi_wisata == 'dibatalkan' && $reservasi->file_bukti_tf)
                                                        <div class="mt-3">
                                                            <div class="alert alert-danger">
                                                                <p class="mb-2">
                                                                    ❌ <strong>Reservasi Dibatalkan oleh Tim</strong><br>
                                                                    Mohon maaf atas ketidaknyamanannya, reservasi Anda telah dibatalkan oleh tim kami karena alasan tertentu.
                                                                </p>

                                                                <p class="mb-2">
                                                                    💰 Anda telah melakukan pembayaran. Untuk informasi lebih lanjut dan proses <strong>refund</strong>,
                                                                    silakan hubungi tim kami.
                                                                </p>

                                                                <p class="mb-2">
                                                                    Tim kami akan membantu proses pengembalian dana sesuai kebijakan yang berlaku.
                                                                </p>

                                                                <a href="https://wa.me/{{ $no_hp_bendahara }}?text={{ urlencode("Halo, saya {$pelanggan->nama_lengkap} dengan reservasi ID {$reservasi->id}. Reservasi saya dibatalkan oleh tim desa wisata. Mohon informasi refund dana sebesar Rp {$reservasi->total_bayar}. Terima kasih.") }}"
                                                                target="_blank"
                                                                class="btn btn-success btn-sm">
                                                                    <i class="icon-whatsapp mr-1"></i> Hubungi Kami
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                {{-- <div class="alert alert-warning">
                                                    <p><strong>Status Pembayaran:</strong>
                                                        <span class="badge badge-info">Belum Dibayar</span>
                                                    </p>
                                                    <p>Silakan lakukan pembayaran sebelum {{ date('d F Y H:i', strtotime($reservasi->created_at->addDays(1))) }}</p>
                                                    <a href="{{ route('pelanggan.paket-wisata.pembayaran', $reservasi->id) }}"
                                                       class="btn btn-sm btn-warning">
                                                        <i class="icon-credit-card mr-1"></i> Lanjutkan Pembayaran
                                                    </a>
                                                </div> --}}

                                                @if($reservasi->status_reservasi_wisata != 'dibatalkan')
                                                    <div class="alert alert-warning">
                                                        <p><strong>Status Pembayaran:</strong>
                                                            <span class="badge badge-info">Belum Dibayar</span>
                                                        </p>
                                                        <p>Silakan lakukan pembayaran sebelum {{ date('d F Y H:i', strtotime($reservasi->created_at->addDays(1))) }}</p>
                                                        <a href="{{ route('pelanggan.paket-wisata.pembayaran', $reservasi->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                            <i class="icon-credit-card mr-1"></i> Lanjutkan Pembayaran
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="alert alert-danger">
                                                        <p class="mb-2">
                                                            ❌ <strong>Reservasi Dibatalkan</strong><br>
                                                            Reservasi ini telah dibatalkan sebelum pembayaran dilakukan.
                                                            Karena itu, Anda <strong>tidak perlu melakukan pembayaran</strong> untuk reservasi ini.
                                                        </p>
                                                        <p class="mb-0 small">
                                                            💡 Ingin berwisata? Silakan buat reservasi paket wisata baru melalui halaman utama.
                                                        </p>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>

                                        <!-- Modal Ganti Bukti Transfer -->
                                        <div class="modal fade" id="gantiBuktiModal" tabindex="-1" role="dialog" aria-labelledby="gantiBuktiModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="gantiBuktiModalLabel">Ganti Bukti Transfer</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('pelanggan.paket-wisata.update-bukti', $reservasi->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="file_bukti_tf">Upload Bukti Transfer Baru</label>
                                                                <input type="file" class="form-control-file" id="file_bukti_tf" name="file_bukti_tf" required>
                                                                <small class="form-text text-muted">
                                                                    Format: JPEG, PNG, JPG, PDF (Maksimal 3MB)
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Pengajuan Pembatalan -->
                                        <div class="modal fade" id="batalReservasiModal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><i class="icon-info mr-2"></i> Ajukan Pembatalan Reservasi</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>

                                                    @php
                                                        $bendahara = App\Models\User::where('level', 'bendahara')
                                                                        ->where('aktif', true)
                                                                        ->with('karyawan')
                                                                        ->first();

                                                        $no_hp_bendahara = $bendahara->karyawan->no_hp ?? '628123456789';
                                                        $no_hp_bendahara = preg_replace('/^0/', '62', $no_hp_bendahara);

                                                        $pesan_batal = urlencode("Halo, saya {$pelanggan->nama_lengkap} ingin mengajukan pembatalan reservasi ID {$reservasi->id}. Mohon informasi lebih lanjut terkait proses dan refund.");
                                                    @endphp

                                                    <div class="modal-body">
                                                        <p>
                                                            Anda tidak dapat membatalkan reservasi secara langsung melalui sistem.
                                                            Silakan ajukan pembatalan dengan menghubungi tim kami.
                                                        </p>

                                                        <hr>

                                                        <h6>Ketentuan Pembatalan:</h6>
                                                        <p class="mb-2">
                                                            1. Pembatalan yang dilakukan <strong>5 hari sebelum tanggal keberangkatan</strong>
                                                            akan dikenakan biaya administrasi sebesar <strong>10%</strong> dari total pembayaran.
                                                        </p>

                                                        <p class="mb-2 text-danger">
                                                            2. Pembatalan dalam waktu <strong>kurang dari 5 hari</strong> tidak dapat dilakukan refund.
                                                        </p>

                                                        <p class="mt-3">
                                                            Silakan klik tombol di bawah untuk menghubungi bendahara:
                                                        </p>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <a href="https://wa.me/{{ $no_hp_bendahara }}?text={{ $pesan_batal }}"
                                                        target="_blank"
                                                        class="btn btn-success">
                                                            <i class="icon-whatsapp mr-1"></i> Hubungi Bendahara
                                                        </a>

                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                            Tutup
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tombol Aksi -->
                                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 gap-2">
                                            <a href="{{ route('pelanggan.reservasiku') }}" class="btn btn-secondary me-2 mb-2">
                                                <i class="icon-arrow-left me-2"></i> Kembali
                                            </a>

                                            @if(is_null($reservasi->file_bukti_tf) && $reservasi->status_reservasi_wisata == 'pesan')
                                                <a href="{{ route('pelanggan.paket-wisata.pembayaran', $reservasi->id) }}"
                                                class="btn btn-primary me-2 mb-2">
                                                    <i class="icon-credit-card me-2"></i> Bayar Sekarang
                                                </a>
                                            @endif

                                            @if(in_array($reservasi->status_reservasi_wisata, ['pesan', 'dibayar']))
                                                <button type="button"
                                                        class="btn btn-danger mb-2"
                                                        data-toggle="modal"
                                                        data-target="#batalReservasiModal">
                                                    <i class="icon-trash me-2"></i> Ajukan Pembatalan
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="invisible" id="pesan">@isset($pesan) {{$pesan}} @endisset</div>

<script>
    const body = document.getElementById('body');
    const pesan = document.getElementById('pesan');

    function tampil_pesan(){
        let pesan = "{{ session('pesan') }}";
        let error = "{{ session('error') }}";

        if (pesan.trim() !== '') {
            swal('Good Job', pesan.trim(), 'success');
        }

        if (error.trim() !== '') {
            swal('Error', error.trim(), 'error');
        }
    }

    body.onload = function(){
        tampil_pesan();
    }
</script>

<style>
    /* .badge {
        padding: 0.5em 0.75em;
        font-size: 0.875rem;
        font-weight: 500;
    } */

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    .alert {
        border-radius: 8px;
    }

    .border-bottom {
        border-bottom: 1px solid #dee2e6 !important;
    }
</style>
@endsection
