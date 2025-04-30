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

                <!-- widgets 1 -->
                <div class="row mt-3">
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-0">
                          <div class="card-body">
                            <div class="row align-items-center">
                              <div class="col-3 text-center">
                                <span class="circle circle-sm bg-primary">
                                  <i class="fe fe-16 fe-briefcase text-white mb-0"></i>
                                </span>
                              </div>
                              <div class="col pr-0">
                                <p class="small text-muted mb-0">Total Karyawan</p>
                                <span class="h3 mb-0">{{$karyawan ?? 0}}</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    <div class="col-md-6 col-xl-3 mb-4">
                      <div class="card shadow border-0">
                        <div class="card-body">
                          <div class="row align-items-center">
                            <div class="col-3 text-center">
                              <span class="circle circle-sm bg-primary">
                                <i class="fe fe-16 fe-users text-white mb-0"></i>
                              </span>
                            </div>
                            <div class="col pr-0">
                              <p class="small text-muted mb-0">Total Pelanggan</p>
                              <span class="h3 mb-0">{{$pelanggan ?? 0}}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 col-xl-3 mb-4">
                      <div class="card shadow border-0">
                        <div class="card-body">
                          <div class="row align-items-center">
                            <div class="col-3 text-center">
                              <span class="circle circle-sm bg-primary">
                                <i class="fe fe-16 fe-user-check text-white mb-0"></i>
                              </span>
                            </div>
                            <div class="col">
                              <p class="small text-muted mb-0">Pengguna Aktif</p>
                              <div class="row align-items-center no-gutters">
                                <div class="col-auto">
                                  <span class="h3 mr-2 mb-0">{{$user_aktif ?? 0}}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                      <div class="card shadow border-0">
                        <div class="card-body">
                          <div class="row align-items-center">
                            <div class="col-3 text-center">
                              <span class="circle circle-sm bg-primary">
                                <i class="fe fe-16 fe-user-x text-white mb-0"></i>
                              </span>
                            </div>
                            <div class="col">
                              <p class="small text-muted mb-0">Pengguna Nonaktif</p>
                              <span class="h3 mb-0">{{ $user_nonaktif ?? 0 }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <!-- end widgets -->
            </div>
        </div>
        {{-- End Section Widgets --}}

        <!-- New Chart Section -->
        <div class="card shadow my-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="pl-3">
                            <h2 class="h3 mb-3">Statistik Pengguna</h2>
                            <div class="mb-4">
                                <h2 class="mb-1">{{ $total_user ?? 0 }}</h2>
                                <p class="text-muted mb-0">Total Pengguna Terdaftar</p>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary rounded-circle p-2 mr-3">
                                    <i class="fe fe-briefcase text-white"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted">Karyawan</p>
                                    <h4 class="mb-0">+{{ $karyawan_hari_ini ?? 0 }} / Hari ini</h4>
                                    <small class="{{ $karyawan_perubahan >= 0 ? 'text-success' : 'text-danger' }}">
                                        <i class="fe fe-arrow-{{ $karyawan_perubahan >= 0 ? 'up' : 'down' }}"></i>
                                        {{ abs($karyawan_perubahan) }}%
                                    </small>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success rounded-circle p-2 mr-3">
                                    <i class="fe fe-shopping-bag text-white"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted">Pelanggan</p>
                                    <h4 class="mb-0">+{{ $pelanggan_hari_ini ?? 0 }} / Hari ini</h4>
                                    <small class="{{ $pelanggan_perubahan >= 0 ? 'text-success' : 'text-danger' }}">
                                        <i class="fe fe-arrow-{{ $pelanggan_perubahan >= 0 ? 'up' : 'down' }}"></i>
                                        {{ abs($pelanggan_perubahan) }}%
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="newChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Small table -->
            <div class="card shadow">
                <div class="card-body">
                    <!-- Header dengan tombol Tambah dan Search -->
                    <h2 class="h3 mb-3">Daftar Pengguna</h2>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <button class="btn btn-primary" onclick="showAddUserModal()">
                            <i class="fe fe-plus mr-1"></i> Tambah
                        </button>
                        <form class="form">
                            <div class="form-group mb-0">
                                <label for="search1" class="sr-only">Search</label>
                                <input type="text" class="form-control" id="search1" placeholder="Search">
                            </div>
                        </form>
                    </div>

                    <form method="GET" action="{{ route('admin.index') }}">
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
                                <select name="level" class="form-control form-control-sm mr-3 rounded" onchange="this.form.submit()">
                                    <option value="" {{ request('level') == '' ? 'selected' : '' }}>Semua Level</option>
                                    <option value="admin" {{ request('level') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="pemilik" {{ request('level') == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                                    <option value="bendahara" {{ request('level') == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                    <option value="pelanggan" {{ request('level') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                                </select>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th>Status Aktif</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($users->count() > 0)
                            @foreach($users as $index => $user)
                            <tr>
                                <td><p class="mb-0">{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</p></td>
                                <td><p class="mb-0">{{ $user->email }}</p></td>
                                <td><p class="mb-0">{{ $user->level }}</p></td>
                                <td>
                                    @if ($user->aktif)
                                        <span class="text-success">Aktif</span>
                                    @else
                                        <span class="text-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text sr-only">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item text-info" href="{{ route('admin.show', $user->id) }}"><i class="fe fe-info mr-1"></i>Detail</a>
                                        <a class="dropdown-item text-warning" href="{{ route('admin.edit', $user->id) }}"><i class="fe fe-edit mr-1"></i>Edit</a>
                                        <a class="dropdown-item text-danger" href="{{ route('admin.destroy', $user->id) }}" type="button" onclick="hapus(event, this)">
                                            <i class="fe fe-trash mr-1"></i>Delete
                                        </a>
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
                            @if ($users->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">Previous</a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                @if ($page == $users->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($users->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Modal Tambah Pengguna -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow-lg rounded-4">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title fw-bold text-white" id="addUserModalLabel">
                                <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                        </div>
                        <div class="modal-body text-center">
                            <p class="fs-5">Silakan pilih jenis pengguna yang ingin ditambahkan:</p>
                            <div class="d-flex justify-content-center gap-3">
                                <button type="button" class="btn btn-lg btn-outline-info d-flex align-items-center gap-2 mr-2" id="btnAddKaryawan">
                                    <i class="bi bi-briefcase-fill"></i> Tambah Karyawan
                                </button>
                                <button type="button" class="btn btn-lg btn-outline-success d-flex align-items-center gap-2" id="btnAddPelanggan">
                                    <i class="bi bi-people-fill"></i> Tambah Pelanggan
                                </button>
                            </div>
                        </div>
                    </div>
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

    // function showAddUserModal() {
    //     Swal.fire({
    //         title: "Tambah Pengguna",
    //         text: "Silakan pilih jenis pengguna yang ingin ditambahkan:",
    //         icon: "info",
    //         showCancelButton: true,
    //         showDenyButton: true,
    //         confirmButtonText: "Tambah Pelanggan",
    //         denyButtonText: "Tambah Karyawan",
    //         cancelButtonText: "Batal",
    //         confirmButtonColor: "#28a745",
    //         denyButtonColor: "#17a2b8",
    //         cancelButtonColor: "#6c757d",
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             window.location.href = "/kelola_data_pelanggan/create";
    //         } else if (result.isDenied) {
    //             window.location.href = "/kelola_data_karyawan/create";
    //         }
    //     });
    // }

    function hapus(event, el){
        event.preventDefault()
        swal({
        title: "Anda Yakin?",
        text: "Anda Akan Menghapus Data User Ini Secara Permanen!",
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

    function showAddUserModal() {
        var modal = new bootstrap.Modal(document.getElementById('addUserModal'));
        modal.show();

        // Event ketika tombol ditekan
        document.getElementById('btnAddPelanggan').onclick = function () {
            window.location.href = "/kelola_data_pelanggan/create";
        };
        document.getElementById('btnAddKaryawan').onclick = function () {
            window.location.href = "/kelola_data_karyawan/create";
        };
    }


    body.onload = function(){
        tampil_pesan()
    }

</script>
<!-- main -->

<!-- Chart Script -->
<!-- Gunakan CDN Chart.js jika belum -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('newChart').getContext('2d');

    // Data dari controller
    const labels = @json($chart_labels);
    const karyawanData = @json($karyawan_data).map(value => Math.round(value));
    const pelangganData = @json($pelanggan_data).map(value => Math.round(value));

    // Cari nilai maksimum dari data untuk skala Y
    const maxDataValue = Math.max(
        Math.max(...karyawanData),
        Math.max(...pelangganData)
    );
    const yMax = maxDataValue < 5 ? 5 : Math.ceil(maxDataValue + 1);

    const config = {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Karyawan',
                data: karyawanData,
                borderColor: 'rgba(94, 114, 228, 1)',
                backgroundColor: 'rgba(94, 114, 228, 0.3)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 6
            }, {
                label: 'Pelanggan',
                data: pelangganData,
                borderColor: 'rgba(45, 206, 137, 1)',
                backgroundColor: 'rgba(45, 206, 137, 0.3)',
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
                    text: 'Statistik Pengguna Harian'
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
