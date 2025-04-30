@extends('be.master')
@section('navbar')
    @include('be.navbar')
@endsection
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')

<!-- main -->
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
                <!-- Widgets -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-3">
                    <div class="col mb-4">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-3 text-center">
                                        <span class="circle circle-sm bg-primary">
                                            <i class="fe fe-16 fe-user text-white mb-0"></i>
                                        </span>
                                    </div>
                                    <div class="col p-0">
                                        <p class="small text-muted mb-0">Total Pendapatan</p>
                                        <span class="h5 mb-0">Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col mb-4">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-3 text-center">
                                        <span class="circle circle-sm bg-primary">
                                            <i class="fe fe-16 fe-user text-white mb-0"></i>
                                        </span>
                                    </div>
                                    <div class="col p-0">
                                        <p class="small text-muted mb-0">Pendapatan Bulanan</p>
                                        <span class="h5 mb-0">Rp. {{ number_format($totalPendapatanPerBulan, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col mb-4">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-3 text-center">
                                        <span class="circle circle-sm bg-primary">
                                            <i class="fe fe-16 fe-map text-white mb-0"></i>
                                        </span>
                                    </div>
                                    <div class="col p-0">
                                        <p class="small text-muted mb-0">Total Pendapatan Tertunda</p>
                                        <span class="h5 mb-0">Rp. {{ number_format($totalPembayaranTertunda, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col mb-4">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-3 text-center">
                                        <span class="circle circle-sm bg-primary">
                                            <i class="fe fe-16 fe-book-open text-white mb-0"></i>
                                        </span>
                                    </div>
                                    <div class="col p-0">
                                        <p class="small text-muted mb-0">Total Reservasi</p>
                                        <span class="h5 mb-0">{{ $totalReservasi }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End Widgets -->

            </div>
        </div>
        {{-- End Section Widgets --}}

        <!-- New Chart Section -->
        <div class="card shadow my-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="pl-3">
                            <h2 class="h3 mb-3">Statistik Reservasi</h2>
                            <div class="mb-4">
                                <h2 class="mb-1">{{ $totalReservasi ?? 0 }}</h2>
                                <p class="text-muted mb-0">Total Reservasi</p>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle p-2 mr-3">
                                    <i class="fe fe-calendar text-white"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted">Reservasi Hari Ini</p>
                                    <h4 class="mb-0">+{{ $reservasiHariIni ?? 0 }}</h4>
                                    <small class="{{ $reservasiPerubahan >= 0 ? 'text-success' : 'text-danger' }}">
                                        <i class="fe fe-arrow-{{ $reservasiPerubahan >= 0 ? 'up' : 'down' }}"></i>
                                        {{ abs($reservasiPerubahan) }}%
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="reservasiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Small table -->
        <div class="card shadow">
            <div class="card-body">
                <!-- Header dengan tombol Tambah dan Search -->
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h2 class="h3 mb-3">Daftar Reservasi</h2>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('kelola_reservasi.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus mr-1"></i>Tambah
                        </a>
                    </div>

                    <div class="d-flex align-items-center">
                        <!-- Input Search -->
                        <form class="form mr-3">
                            <div class="form-group mb-0">
                                <label for="search1" class="sr-only">Search</label>
                                <input type="text" class="form-control" id="search1" placeholder="Search">
                            </div>
                        </form>
                    </div>
                </div>

                <form method="GET" action="{{ route('kelola_reservasi.index') }}">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center" style="font-size: .8rem">
                            <span>Show</span>
                            <select name="per_page" class="form-control form-control-sm rounded mx-2" onchange="this.form.submit()">
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            </select>
                            <span>entries</span>
                        </div>

                        <div class="d-flex align-items-center">
                            <!-- Filter Status -->
                            <select name="status" class="form-control form-control-sm mr-3 rounded" onchange="this.form.submit()">
                                <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                                <option value="pesan" {{ request('status') == 'pesan' ? 'selected' : '' }}>Pesan</option>
                                <option value="dibayar" {{ request('status') == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pelanggan</th>
                            <th>Paket Wisata</th>
                            <th>Tanggal Reservasi</th>
                            <th>Harga</th>
                            <th>Total Bayar</th>
                            <th>Status Reservasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($reservasis->count() > 0)
                            @foreach ($reservasis as $index => $reservasi)
                                <tr>
                                    <td>{{ ($reservasis->currentPage() - 1) * $reservasis->perPage() + $index + 1 }}</td>
                                        <td>{{ $reservasi->pelanggan->nama_lengkap }}</td>
                                        <td>{{ $reservasi->paket->nama_paket }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservasi->tgl_reservasi_mulai)->format('d/m/Y') }}</td>
                                        <td>Rp. {{ number_format($reservasi->harga, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</td>
                                        <td class="h4">
                                            @if ($reservasi->status_reservasi_wisata === 'pesan')
                                                <span class="badge badge-warning text-white">Pesan</span>
                                            @elseif ($reservasi->status_reservasi_wisata === 'dibayar')
                                                <span class="badge badge-primary text-white">Dibayar</span>
                                            @elseif ($reservasi->status_reservasi_wisata === 'selesai')
                                                <span class="badge badge-success text-white">Selesai</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($reservasi->status_reservasi_wisata) }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item text-info" href="{{ route('kelola_reservasi.show', $reservasi->id) }}"><i class="fe fe-info mr-1"></i>Detail</a>
                                                <a class="dropdown-item text-warning" href="{{ route('kelola_reservasi.edit', $reservasi->id) }}"><i class="fe fe-edit mr-1"></i>Edit</a>
                                                <a class="dropdown-item text-danger" href="{{route('kelola_reservasi.destroy', $reservasi->id)}}"><i class="fe fe-trash mr-1"></i>Delete</a>
                                            </div>
                                        </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    <i class="fe fe-alert-circle"></i> Tidak ada data yang ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>

                </table>

                <!-- Pagination -->
                <nav aria-label="Table Paging" class="mb-0 text-muted">
                    <ul class="pagination justify-content-center mb-0">
                        {{-- Previous Page Link --}}
                        @if ($reservasis->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $reservasis->previousPageUrl() }}" rel="prev">Previous</a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($reservasis->getUrlRange(1, $reservasis->lastPage()) as $page => $url)
                            @if ($page == $reservasis->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($reservasis->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $reservasis->nextPageUrl() }}" rel="next">Next</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Next</span></li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>

    <!-- customized table -->
    </div>
</main>


<form action="" method="POST" id="frmHapus">
    @method('DELETE')
    @csrf
</form>

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

    function hapus(event, el){
        event.preventDefault()
        swal({
        title: "Anda Yakin?",
        text: "Anda Akan Menghapus Data Reservasi Ini Secara Permanen!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Iya, Hapus Itu!",
        closeOnConfirm: false
        },
        function(){

            frm.setAttribute('action', el.getAttribute('href'))
            frm.submit()
        });
    }

    body.onload = function(){
        tampil_pesan()
    }

</script>
<!-- main -->

<!-- Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('reservasiChart').getContext('2d');

    // Data dari controller
    const labels = @json($chart_labels);
    const reservasiData = @json($reservasi_data).map(value => Math.round(value));

    // Cari nilai maksimum untuk skala Y
    const maxReservasi = Math.max(...reservasiData);
    const yMax = maxReservasi < 5 ? 5 : Math.ceil(maxReservasi + 1);

    const config = {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Reservasi',
                data: reservasiData,
                borderColor: 'rgba(94, 114, 228, 1)',
                backgroundColor: 'rgba(94, 114, 228, 0.3)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: { size: 12 },
                    bodyFont: { size: 12 },
                    padding: 10,
                    displayColors: true
                },
                title: {
                    display: true,
                    text: 'Statistik Reservasi Harian'
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 11 }
                    }
                },
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: yMax,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return Number.isInteger(value) ? value : '';
                        },
                        font: { size: 11 }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                }
            },
            elements: {
                line: {
                    borderCapStyle: 'round',
                    borderJoinStyle: 'round'
                }
            }
        }
    };

    new Chart(ctx, config);
});
</script>
@endsection
