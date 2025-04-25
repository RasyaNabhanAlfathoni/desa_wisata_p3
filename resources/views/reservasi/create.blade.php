{{-- Kelola Reservasi / create.blade.php --}}

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
                </div>

                <!-- Small table -->
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('kelola_reservasi.store') }}" id="frmReservasi" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Pilih Pelanggan --}}
                            <div class="form-group">
                                <label for="id_pelanggan" class="form-label">Pelanggan</label>
                                <select name="id_pelanggan" id="id_pelanggan" class="form-control">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach($pelanggans as $p)
                                        <option value="{{ $p->id }}" {{ old('id_pelanggan') == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_pelanggan') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            {{-- Pilih Paket Wisata --}}
                            <div class="form-group">
                                <label for="id_paket" class="form-label">Paket Wisata</label>
                                <select name="id_paket" id="id_paket" class="form-control" required>
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach($pakets as $p)
                                        <option value="{{ $p->id }}" {{ old('id_paket') == $p->id ? 'selected' : '' }} data-durasi="{{ $p->durasi_hari }}" data-kuota="{{ $p->kuota_peserta }}" data-harga="{{ $p->harga_per_pack }}" data-peserta-diskon="{{ $p->peserta_diskon }}" data-nilai-diskon="{{ $p->nilai_diskon }}">
                                            {{ $p->nama_paket }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_paket') <div class="text-danger">{{ $message }}</div> @enderror
                                <small id="kuota-info" class="form-text text-warning"></small>
                            </div>

                            {{-- Tanggal Mulai Reservasi --}}
                            <div class="form-group">
                                <label for="tgl_reservasi_mulai" class="form-label">Tanggal Mulai Reservasi</label>
                                <input type="date" name="tgl_reservasi_mulai" id="tgl_reservasi_mulai" class="form-control" value="{{ old('tgl_reservasi_mulai', now()->format('Y-m-d')) }}" required>
                                @error('tgl_reservasi_mulai') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tanggal Akhir Reservasi --}}
                            <div class="form-group">
                                <label for="tgl_reservasi_akhir" class="form-label">Tanggal Akhir Reservasi</label>
                                <input type="date" name="tgl_reservasi_akhir" id="tgl_reservasi_akhir" class="form-control" value="{{ old('tgl_reservasi_akhir') }}" readonly required>
                                @error('tgl_reservasi_akhir') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            {{-- Harga --}}
                            <div class="form-group">
                                <label for="harga" class="form-label">Harga per Paket (Rp)</label>
                                <input type="number" name="harga" id="harga" class="form-control" value="{{ old('harga') }}" readonly>
                                @error('harga') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            {{-- Jumlah Peserta --}}
                            <div class="form-group">
                                <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                                <input type="number" name="jumlah_peserta" id="jumlah_peserta" class="form-control" value="{{ old('jumlah_peserta', 1) }}" min="1" required>
                                @error('jumlah_peserta') <div class="text-danger">{{ $message }}</div> @enderror
                                <p id="peserta-error" class="form-text text-danger d-none">Jumlah peserta melebihi kuota!</p>
                            </div>

                            {{-- Nilai Diskon (%) --}}
                            <div class="form-group">
                                <label for="nilai_diskon" class="form-label">Nilai Diskon (%)</label>
                                <input type="number" name="nilai_diskon" id="nilai_diskon" class="form-control" value="{{ old('nilai_diskon', 0) }}" readonly>
                                @error('nilai_diskon') <div class="text-danger">{{ $message }}</div> @enderror
                                <small id="diskon-info" class="form-text text-success d-none">Diskon berlaku untuk jumlah peserta ini!</small>
                            </div>

                            {{-- Diskon (Rp) --}}
                            <div class="form-group">
                                <label for="diskon" class="form-label">Diskon (Rp)</label>
                                <input type="number" name="diskon" id="diskon" class="form-control" value="{{ old('diskon', 0) }}" readonly>
                                @error('diskon') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            {{-- Total Bayar --}}
                            <div class="form-group">
                                <label for="total_bayar" class="form-label">Total Bayar (Rp)</label>
                                <input type="number" name="total_bayar" id="total_bayar" class="form-control" value="{{ old('total_bayar') }}" readonly>
                                @error('total_bayar') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            {{-- Upload Bukti Pembayaran --}}
                            <div class="form-group">
                                <label for="file_bukti_tf" class="form-label">Bukti Pembayaran</label>
                                <input type="file" name="file_bukti_tf" id="file_bukti_tf" class="form-control">
                                @error('file_bukti_tf') <div class="text-danger">{{ $message }}</div> @enderror
                                <div id="file_bukti_tf" class="form-text text-warning">Unggah File Bukti TF Reservasi! ( Maks 3MB )</div>
                            </div>

                            {{-- Status Reservasi --}}
                            <div class="form-group">
                                <label for="status_reservasi_wisata" class="form-label">Status Reservasi</label>
                                <select name="status_reservasi_wisata" id="status_reservasi_wisata" class="form-control">
                                    <option value="pesan" {{ old('status_reservasi_wisata') == 'pesan' ? 'selected' : '' }}>Pesan</option>
                                    <option value="dibayar" {{ old('status_reservasi_wisata') == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                                    <option value="selesai" {{ old('status_reservasi_wisata') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ old('status_reservasi_wisata') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status_reservasi_wisata') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <button type="button" class="btn btn-primary" id="save"><i class="fe fe-save mr-1"></i>Simpan</button>
                            <a href="{{ route('kelola_reservasi.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@if(isset($status) && $status == 'Duplicate!')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 ">
            <div class="bg-light rounded h-100 p-4">
                <div class="form-text text-danger fs-5" id="pesan"> {{$pesan}} </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const paketSelect = document.getElementById("id_paket");
        const tglMulaiInput = document.getElementById("tgl_reservasi_mulai");
        const tglAkhirInput = document.getElementById("tgl_reservasi_akhir");
        const hargaInput = document.getElementById("harga");
        const pesertaInput = document.getElementById("jumlah_peserta");
        const nilaiDiskonInput = document.getElementById("nilai_diskon");
        const diskonInput = document.getElementById("diskon");
        const totalBayarInput = document.getElementById("total_bayar");
        const kuotaInfo = document.getElementById("kuota-info");
        const pesertaError = document.getElementById("peserta-error");
        const diskonInfo = document.getElementById("diskon-info");
        const form = document.getElementById("frmReservasi");
        const btnSimpan = document.getElementById('save');

        // Fungsi untuk menghitung tanggal akhir
        function hitungTanggalAkhir() {
            const paketId = paketSelect.value;
            const selectedOption = paketSelect.options[paketSelect.selectedIndex];
            const durasiHari = selectedOption ? parseInt(selectedOption.getAttribute('data-durasi')) || 1 : 1;

            if (tglMulaiInput.value) {
                const tglMulai = new Date(tglMulaiInput.value);
                const tglAkhir = new Date(tglMulai);

                // Kurangi 1 hari dari durasiHari untuk mendapatkan tanggal akhir yang benar
                tglAkhir.setDate(tglMulai.getDate() + durasiHari - 1);

                // Format tanggal ke YYYY-MM-DD
                const year = tglAkhir.getFullYear();
                const month = String(tglAkhir.getMonth() + 1).padStart(2, '0');
                const day = String(tglAkhir.getDate()).padStart(2, '0');

                tglAkhirInput.value = `${year}-${month}-${day}`;
            }
        }

        // Fungsi untuk update informasi paket
        function updatePaketInfo() {
            const selectedOption = paketSelect.options[paketSelect.selectedIndex];

            if (selectedOption && selectedOption.value) {
                const harga = selectedOption.getAttribute('data-harga');
                const kuota = selectedOption.getAttribute('data-kuota');
                const pesertaDiskon = selectedOption.getAttribute('data-peserta-diskon');
                const nilaiDiskon = selectedOption.getAttribute('data-nilai-diskon');

                hargaInput.value = harga || 0;
                nilaiDiskonInput.value = nilaiDiskon || 0;
                kuotaInfo.textContent = `Kuota tersedia: ${kuota} peserta`;

                // Validasi jumlah peserta
                validasiJumlahPeserta();

                // Hitung ulang total bayar
                hitungTotalBayar();

                // Hitung tanggal akhir
                hitungTanggalAkhir();
            } else {
                hargaInput.value = 0;
                nilaiDiskonInput.value = 0;
                diskonInput.value = 0;
                totalBayarInput.value = 0;
                kuotaInfo.textContent = '';
            }
        }

        // Fungsi untuk validasi jumlah peserta
        function validasiJumlahPeserta() {
            const selectedOption = paketSelect.options[paketSelect.selectedIndex];
            if (!selectedOption || !selectedOption.value) return;

            const kuota = parseInt(selectedOption.getAttribute('data-kuota')) || 0;
            const jumlahPeserta = parseInt(pesertaInput.value) || 0;

            if (jumlahPeserta > kuota) {
                pesertaError.classList.remove('d-none');
                pesertaInput.setCustomValidity('Jumlah peserta melebihi kuota');
                btnSimpan.disabled = true;
            } else {
                pesertaError.classList.add('d-none');
                pesertaInput.setCustomValidity('');
                btnSimpan.disabled = false;
            }
        }

        // Fungsi untuk menghitung total bayar
        function hitungTotalBayar() {
            const selectedOption = paketSelect.options[paketSelect.selectedIndex];
            if (!selectedOption || !selectedOption.value) {
                totalBayarInput.value = 0;
                diskonInput.value = 0;
                nilaiDiskonInput.value = 0;
                return;
            }

            const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            const pesertaDiskon = parseInt(selectedOption.getAttribute('data-peserta-diskon')) || 0;
            const nilaiDiskonPersen = parseFloat(selectedOption.getAttribute('data-nilai-diskon')) || 0;
            const jumlahPeserta = parseInt(pesertaInput.value) || 1;

            const totalHarga = harga * jumlahPeserta;
            let diskon = 0;

            // Cek apakah jumlah peserta memenuhi syarat untuk diskon
            if (jumlahPeserta >= pesertaDiskon && pesertaDiskon > 0) {
                // Hitung diskon sebagai nilai tetap berdasarkan 1x harga * nilaiDiskonPersen
                diskon = harga * (nilaiDiskonPersen / 100);
                diskonInput.value = Math.round(diskon); // bentuk rupiah
                nilaiDiskonInput.value = nilaiDiskonPersen; // bentuk persen
                diskonInfo.classList.remove('d-none');
            } else {
                diskon = 0;
                diskonInput.value = 0;
                nilaiDiskonInput.value = 0;
                diskonInfo.classList.add('d-none');
            }

            // Total bayar = total harga - diskon (flat)
            totalBayarInput.value = Math.round(totalHarga - diskon);
        }


        // Event listeners
        paketSelect.addEventListener('change', updatePaketInfo);
        tglMulaiInput.addEventListener('change', hitungTanggalAkhir);
        pesertaInput.addEventListener('input', function() {
            validasiJumlahPeserta();
            hitungTotalBayar();
        });

        // Validasi form sebelum submit
        form.addEventListener('submit', function(e) {
            // Pastikan semua perhitungan sudah benar sebelum submit
            hitungTotalBayar();
            validasiJumlahPeserta();

            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
        });

        // Inisialisasi awal
        updatePaketInfo();
    });
    </script>

<script>
    const btnSimpan = document.getElementById('save');
    const frm = document.getElementById('frmReservasi');
    const status = document.getElementById('status');
    const pesan = document.getElementById('pesan');
    const body = document.getElementById('body');

    // Mengambil nilai dari semua input
    const id_pelanggan = document.getElementById('id_pelanggan');
    const id_paket = document.getElementById('id_paket');
    const tgl_reservasi_mulai = document.getElementById('tgl_reservasi_mulai');
    const tgl_reservasi_akhir = document.getElementById('tgl_reservasi_akhir');
    const harga = document.getElementById('harga');
    const jumlah_peserta = document.getElementById('jumlah_peserta');
    const diskon = document.getElementById('diskon');
    const nilai_diskon = document.getElementById('nilai_diskon');
    const total_bayar = document.getElementById('total_bayar');
    const file_bukti_tf = document.getElementById('file_bukti_tf');
    const status_reservasi_wisata = document.getElementById('status_reservasi_wisata');

    function tampil_pesan(){
        let pesan = "{{ session('pesan') }}";
        let error = "{{ session('error') }}";

        if (pesan.trim() !== '') {
            swal('Duplicate!', pesan.trim(), 'error');
        }

        if (error.trim() !== '') {
            swal('Error', error.trim(), 'error');
        }

        if(pesan.innerHTML.trim() !== ''){
            swal('Duplicate Data!', pesan.innerHTML, 'error')
        }
    }

    function simpan(event) {
         // Cek apakah ada field yang kosong dan tampilkan pesan error sesuai
         if (id_pelanggan.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nama Pelanggan.", "error");
        } else if (id_paket.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Nama Paket.", "error");
        } else if (tgl_reservasi_mulai.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Tanggal Reservasi mulai.", "error");
        } else if (tgl_reservasi_akhir.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Tanggal Reservasi akhir.", "error");
        } else if (harga.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Harga.", "error");
        } else if (jumlah_peserta.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Jumlah Peserta.", "error");
        // } else if (diskon.value === '') {
        //     event.preventDefault();
        //     swal("Invalid Data!", "Mohon isi bagian kolom Diskon.", "error");
        // } else if (nilai_diskon.value === '') {
        //     event.preventDefault();
        //     swal("Invalid Data!", "Mohon isi bagian kolom Nilai Diskon.", "error");
        } else if (total_bayar.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Total Bayar.", "error");
        } else if (file_bukti_tf.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom File Bukti TF.", "error");
        } else if (status_reservasi_wisata.value === '') {
            event.preventDefault();
            swal("Invalid Data!", "Mohon isi bagian kolom Status Reservasi.", "error");
        } else {
            // Menampilkan pesan sukses saat frm valid dan berhasil disubmit
            frm.submit();
        }
    }

    body.onload = function(){
        tampil_pesan()
    }

    btnSimpan.onclick = function(event) {
        simpan(event); // Kirim event ke fungsi simpan
    }
</script>

@endsection
