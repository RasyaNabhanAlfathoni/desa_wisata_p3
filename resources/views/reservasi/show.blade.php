@extends('be.master')

@section('navbar')
    @include('be.navbar')
@endsection

@section('sidebar')
    @include('be.sidebar')
@endsection

@section('content')

<main role="main" class="main-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center rounded-top">
                        <h4 class="mb-0 text-white"><i class="fe fe-file-text text-white"></i> Detail Reservasi (ID: {{ $reservasi->id }})</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Informasi Pelanggan -->
                                <div class="mb-3">
                                    <label class="text-muted"><i class="fe fe-user"></i> Nama Pelanggan</label>
                                    <div class="h6 fw-bold">{{ $reservasi->pelanggan->nama_lengkap }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted"><i class="fe fe-map"></i> Paket Wisata</label>
                                    <div class="h6">{{ $reservasi->paket->nama_paket }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted"><i class="fe fe-calendar"></i> Tanggal Reservasi Mulai</label>
                                    <div class="h6">{{ \Carbon\Carbon::parse($reservasi->tgl_reservasi_mulai)->format('d-m-Y') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted"><i class="fe fe-calendar"></i> Tanggal Reservasi Akhir</label>
                                    <div class="h6">{{ \Carbon\Carbon::parse($reservasi->tgl_reservasi_akhir)->format('d-m-Y') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted"><i class="fe fe-users"></i> Jumlah Peserta</label>
                                    <div class="h6">{{ $reservasi->jumlah_peserta }} orang</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted"><i class="fe fe-info"></i> Status Reservasi</label>
                                    <div class="h4">
                                        @if($reservasi->status_reservasi_wisata == 'pesan')
                                            <span class="badge bg-warning text-white">Pesan</span>
                                        @elseif($reservasi->status_reservasi_wisata == 'dibayar')
                                            <span class="badge bg-primary text-white">Dibayar</span>
                                        @elseif($reservasi->status_reservasi_wisata == 'selesai')
                                            <span class="badge bg-success text-white">Selesai</span>
                                        @elseif ($reservasi->status_reservasi_wisata === 'dibatalkan')
                                            <span class="badge badge-danger text-white">Dibatalkan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Harga & Bukti Pembayaran -->
                                <div class="mb-3">
                                    <label class="text-muted"><i class="fe fe-tag"></i> Harga Paket</label>
                                    <div class="h6">Rp {{ number_format($reservasi->harga, 0, ',', '.') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted"><i class="fe fe-percent"></i> Diskon</label>
                                    <div class="h6 text-danger">-Rp {{ number_format($reservasi->diskon, 0, ',', '.') }} ({{ $reservasi->nilai_diskon }}%)</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted"><i class="fe fe-credit-card"></i> Total Bayar</label>
                                    <div class="h5 fw-bold text-success">Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted"><i class="fe fe-upload"></i> Bukti Pembayaran</label>
                                    @if($reservasi->file_bukti_tf)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $reservasi->file_bukti_tf) }}"
                                                 class="img-thumbnail rounded shadow-sm"
                                                 width="250" style="cursor: pointer;"
                                                 onclick="showModal(this)">
                                        </div>
                                    @elseif($reservasi->status_reservasi_wisata == 'pesan')
                                        <form action="{{ route('kelola_reservasi.upload', $reservasi->id) }}" id="frmUpload" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" id="bukti" name="file_bukti_tf" class="form-control mt-2">
                                            <button type="button" id="save" class="btn btn-primary btn-sm mt-2">
                                                <i class="fe fe-cloud-upload"></i> Upload Bukti Bayar
                                            </button>
                                        </form>
                                    @else
                                        <div class="text-muted">Bukti pembayaran tidak tersedia.</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Modal untuk Bukti TF -->
                            <div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel">Foto Bukti TF</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img id="fotoPreview" src="" alt="Foto Bukti" class="img-fluid rounded shadow">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('kelola_reservasi.index') }}" class="btn btn-secondary">
                                <i class="fe fe-arrow-left"></i> Kembali
                            </a>

                            <div>
                                @if($reservasi->status_reservasi_wisata == 'pesan')
                                    <form action="{{ route('kelola_reservasi.konfirmasi', $reservasi->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success text-white me-2">
                                            <i class="fe fe-check-circle"></i> Konfirmasi
                                        </button>
                                    </form>
                                @endif

                                @if(in_array($reservasi->status_reservasi_wisata, ['pesan', 'dibayar']))
                                    <form action="{{ route('kelola_reservasi.batal', $reservasi->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fe fe-x-circle"></i> Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
{{-- <div class="invisible" id="status">@isset($status) {{$status}} @endisset</div> --}}
<div class="invisible" id="pesan">@isset($pesan) {{$pesan}} @endisset</div>

<script>
    const body = document.getElementById('body');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const frm = document.getElementById('frmUpload');
    const btnSimpan = document.getElementById('save');
    const bukti = document.getElementById('bukti');

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

    function simpan(event) {
         // Cek apakah ada field yang kosong dan tampilkan pesan error sesuai
         if (bukti.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi terlebih dahulu file bukti TF!", "error");
        } else {
            // Menampilkan pesan sukses saat frm valid dan berhasil disubmit
            frm.submit();
        }
    }

    // function hapus(event, el){
    //     event.preventDefault()
    //     swal({
    //     title: "Are you sure?",
    //     text: "Your will delete the Clothes data permanently!",
    //     type: "warning",
    //     showCancelButton: true,
    //     confirmButtonClass: "btn-danger",
    //     confirmButtonText: "Yes, delete it!",
    //     closeOnConfirm: false
    //     },
    //     function(){

    //         frm.setAttribute('action', el.getAttribute('href'))
    //         frm.submit()
    //     });
    // }

    body.onload = function(){
        tampil_pesan()
    }

    btnSimpan.onclick = function(event) {
        simpan(event); // Kirim event ke fungsi simpan
    }

</script>

<script>
    function showModal(imgElement) {
        const modalImage = document.getElementById("fotoPreview");
        modalImage.src = imgElement.src;
        const modal = new bootstrap.Modal(document.getElementById("modalFoto"));
        modal.show();
    }
</script>
@endsection
