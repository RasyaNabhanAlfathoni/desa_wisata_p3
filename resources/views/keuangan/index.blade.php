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
                <div class="row align-items-center mb-2">
                    <div class="col">
                        <p class="text-muted">Pages / <span class="h6">{{$title}}</span></p>
                        <h2 class="h4 page-title" style="margin-top: -10px;">{{$page}}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Small table -->
        <div class="card shadow">
            <div class="card-body">
                <h2 class="h4 mb-3">Laporan Transaksi</h2>
                <form action="{{ route('kelola_keuangan.index') }}" method="GET">
                    <input type="hidden" name="filter" value="1"> <!-- Tambahkan ini -->

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Pelanggan:</label>
                            <select class="form-control" id="nama_lengkap" name="nama_lengkap">
                                <option value="" {{ request('nama_lengkap') == 'All' ? 'selected' : 'All' }}>Semua</option>
                                @foreach ($pelanggan as $p)
                                    <option value="{{ $p->id }}" {{ request('nama_lengkap') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="paket_wisata" class="form-label">Paket Wisata:</label>
                            <select class="form-control" id="paket_wisata" name="paket_wisata">
                                <option value="" {{ request('paket_wisata') == 'All' ? 'selected' : 'All' }}>Semua</option>
                                @foreach ($paketWisata as $paket)
                                    <option value="{{ $paket->id }}" {{ request('paket_wisata') == $paket->id ? 'selected' : '' }}>
                                        {{ $paket->nama_paket }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="" {{ request('status') == 'All' ? 'selected' : 'All' }}>Semua</option>
                                @foreach ($statusReservasi as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tanggal_awal" class="form-label">Tanggal Awal:</label>
                            <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir:</label>
                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-md-row gap-2">
                        <button type="submit" class="btn btn-primary w-100 w-md-auto mr-2 mb-2"> <i class="fe fe-eye mr-1"></i> Tampilkan</button>

                        <a href="{{ route('kelola_keuangan.index') }}" class="btn btn-warning text-white w-100 w-md-auto mr-2 mb-2">
                            <i class="fe fe-refresh-cw mr-1"></i> Refresh
                        </a>

                        {{-- Tombol Export Excel --}}
                        <a
                        href="{{ route('download.excel-keuangan', [
                            'nama_lengkap' => request('nama_lengkap'),
                            'paket_wisata' => request('paket_wisata'),
                            'status' => request('status'),
                            'tanggal_awal' => request('tanggal_awal'),
                            'tanggal_akhir' => request('tanggal_akhir'),
                        ]) }}"
                        class="btn btn-success text-white w-100 w-md-auto mr-2 mb-2"
                        >
                            <i class="fe fe-file-text mr-1"></i> Download Format Excel
                        </a>

                        {{-- Tombol Export PDF --}}
                        <a
                            href="{{ route('download.pdf-keuangan', [
                                'nama_lengkap' => request('nama_lengkap'),
                                'paket_wisata' => request('paket_wisata'),
                                'status' => request('status'),
                                'tanggal_awal' => request('tanggal_awal'),
                                'tanggal_akhir' => request('tanggal_akhir'),
                            ]) }}"
                            class="btn btn-danger text-white w-100 w-md-auto mb-2"
                        >
                            <i class="fe fe-file mr-1"></i> Download Format PDF
                        </a>
                    </div>

                </form>


                <!-- Tabel Laporan -->
                <table class="table table-bordered mt-4">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Paket Wisata</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Akhir</th> <!-- Kolom baru -->
                            <th>Harga</th> <!-- Kolom baru -->
                            <th>Jumlah Peserta</th>
                            <th>Diskon (Rp)</th> <!-- Kolom baru -->
                            <th>Diskon (%)</th> <!-- Kolom baru -->
                            <th>Total Bayar</th>
                            <th>Bukti TF</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservasi as $key => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->pelanggan->nama_lengkap }}</td>
                                <td>{{ $data->paket->nama_paket }}</td>
                                <td>{{ $data->tgl_reservasi_mulai }}</td>
                                <td>{{ $data->tgl_reservasi_akhir }}</td> <!-- Data baru -->
                                <td>Rp {{ number_format($data->harga, 0, ',', '.') }}</td> <!-- Data baru -->
                                <td>{{ $data->jumlah_peserta }}</td>
                                <td>{{ $data->diskon ? 'Rp '.number_format($data->diskon, 0, ',', '.') : '-' }}</td>
                                <td>{{ $data->nilai_diskon }}%</td> <!-- Data baru -->
                                <td>Rp {{ number_format($data->total_bayar, 0, ',', '.') }}</td>
                                <td>
                                    <div class="avatar avatar-md">
                                        <img src="{{ !empty($data->file_bukti_tf) && file_exists(public_path('storage/' . $data->file_bukti_tf)) ? asset('storage/' . $data->file_bukti_tf) : asset('back-end/assets/avatars/no-imag.jpg') }}"
                                             alt="P" class="img-thumbnail rounded"
                                             style="cursor: pointer;"
                                             onclick="showModal(this)">
                                    </div>
                                </td>
                                <td class="text-white">
                                    @php
                                        $statusBadge = match ($data->status_reservasi_wisata) {
                                            'dibayar' => 'success',
                                            'pesan' => 'warning',
                                            'selesai' => 'info',
                                            'dibatalkan' => 'danger',
                                            default => 'info',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusBadge }}">
                                        {{ ucfirst($data->status_reservasi_wisata) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center"> <!-- Update colspan menjadi 11 -->
                                    <i class="fe fe-alert-circle"></i> Tidak ada data yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal untuk menampilkan gambar -->
        <div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Bukti TF</h5>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="fotoPreview" src="" alt="Foto Berita" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
    function showModal(imgElement) {
        const modalImage = document.getElementById("fotoPreview");
        modalImage.src = imgElement.src;
        const modal = new bootstrap.Modal(document.getElementById("modalFoto"));
        modal.show();
    }
</script>

<!-- main -->
@endsection
