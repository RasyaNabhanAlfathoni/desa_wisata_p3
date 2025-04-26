@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('content')
<!-- Hero Banner with Reservation Form Title -->
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('storage/' . $paket->foto1) }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
                    <span class="mr-2"><a href="{{route('pelanggan.index')}}">Home</a></span> |
                    <span class="mr-2"><a href="{{route('pelanggan.paket-wisata.detail', $paket->id)}}">Detail Paket</a></span> |
                    <span>Form Reservasi</span>
                </p>
                <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Form Reservasi {{ $paket->nama_paket }}</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center my-4 text-white"><i class="icon-credit-card mr-2"></i> Formulir Reservasi</h3>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="icon-info-circle mr-2"></i> Harap periksa data reservasi Anda dengan teliti sebelum melanjutkan.
                        </div>

                        <form id="reservationForm" action="{{ route('pelanggan.paket-wisata.reservasi.submit', $paket->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Package Summary -->
                            <div class="mb-4 p-3 border rounded bg-light">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <img src="{{ asset('storage/' . $paket->foto1) }}" alt="{{ $paket->nama_paket }}" class="img-fluid rounded" style="max-height: 120px;">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="font-weight-bold">{{ $paket->nama_paket }}</h5>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="icon-calendar mr-2"></i> Durasi: {{ $paket->durasi_hari }} Hari</p>
                                                <p class="mb-1"><i class="icon-users mr-2"></i> Kuota: {{ $paket->kuota_peserta }} Orang</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="icon-tag mr-2"></i> Harga:</p>
                                                <h5 class="text-success font-weight-bold">Rp{{ number_format($paket->harga_per_pack, 0, ',', '.') }}/orang</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Information Section -->
                            <h5 class="mt-4 mb-3 border-bottom pb-2"><i class="icon-user mr-2"></i> Data Pribadi</h5>

                            <div class="form-row">
                                <!-- Nama Lengkap -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1">Nama Lengkap</label>
                                        <input class="form-control-plaintext bg-light p-2 rounded"
                                               value="{{ Auth::user()->pelanggan->nama_lengkap }}"
                                               readonly />
                                    </div>
                                </div>

                                <!-- Nomor HP -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1">Nomor Handphone</label>
                                        <input class="form-control-plaintext bg-light p-2 rounded"
                                               value="{{ Auth::user()->pelanggan->no_hp }}"
                                               readonly />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <!-- Alamat -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1">Alamat</label>
                                        <input class="form-control-plaintext bg-light p-2 rounded"
                                               value="{{ Auth::user()->pelanggan->alamat }}"
                                               readonly />
                                    </div>
                                </div>
                            </div>

                            <!-- Reservation Details Section -->
                            <h5 class="mt-4 mb-3 border-bottom pb-2"><i class="icon-calendar mr-2"></i> Detail Reservasi</h5>

                            <div class="form-row">
                                <!-- Tanggal Mulai -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="tgl_reservasi_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                        <input class="form-control datepicker" id="tgl_reservasi_mulai" name="tgl_reservasi_mulai"
                                               type="date" min="{{ date('Y-m-d') }}"
                                               value="{{ old('tgl_reservasi_mulai') }}"  required />
                                        @error('tgl_reservasi_mulai')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tanggal Akhir (auto calculated) -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1">Tanggal Berakhir</label>
                                        <input class="form-control bg-light p-2 rounded"
                                               id="tgl_reservasi_akhir"
                                               readonly />
                                        <input type="hidden" name="tgl_reservasi_akhir" id="tgl_reservasi_akhir_hidden">
                                    </div>
                                </div>

                                <!-- Jumlah Peserta -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="jumlah_peserta">Jumlah Peserta <span class="text-danger">*</span></label>
                                        <input class="form-control" id="jumlah_peserta" name="jumlah_peserta"
                                               type="number" min="1" max="{{ $paket->kuota_peserta }}"
                                               value="{{ old('jumlah_peserta', 1) }}"
                                               required />
                                        <small class="text-muted">Maksimal: {{ $paket->kuota_peserta }} peserta</small>
                                        @error('jumlah_peserta')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Discount Information (dynamic based on jumlah_peserta) -->
                            <div id="discountInfo" class="alert d-none">
                                <i id="discountIcon" class="icon-gift mr-2"></i>
                                <span id="discountText">Anda mendapatkan diskon {{ $paket->nilai_diskon }}% karena memesan minimal {{ $paket->peserta_diskon }} peserta.</span>
                            </div>

                            <!-- Payment Summary (dynamic) -->
                            <div class="card border-0 shadow-sm mt-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Ringkasan Pembayaran</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Harga per orang:</span>
                                        <span>Rp<span id="pricePerPerson">{{ number_format($paket->harga_per_pack, 0, ',', '.') }}</span></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Jumlah peserta:</span>
                                        <span id="participantCount">1</span>
                                    </div>
                                    <div id="discountRow" class="d-flex justify-content-between mb-2 text-success d-none">
                                        <span>Diskon ({{ $paket->nilai_diskon }}%):</span>
                                        <span>-Rp<span id="discountAmount">0</span></span>
                                        <input type="hidden" name="diskon" id="diskon_input" value="0">
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Durasi:</span>
                                        <span id="durationDisplay">{{ $paket->durasi_hari }} Hari (<span id="dateRangeDisplay"></span>)</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between font-weight-bold">
                                        <span>Total Pembayaran:</span>
                                        <span class="h5 text-success">Rp<span id="totalPayment">{{ number_format($paket->harga_per_pack, 0, ',', '.') }}</span></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-group mt-4">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="termsCheck" name="terms" type="checkbox" required />
                                    <label class="custom-control-label" for="termsCheck">
                                        Saya menyetujui <a href="#" data-toggle="modal" data-target="#termsModal">Syarat dan Ketentuan</a> yang berlaku
                                    </label>
                                    @error('terms')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="form-group mt-4 d-flex justify-content-between">
                                <a href="{{ route('pelanggan.paket-wisata.detail', $paket->id) }}" class="btn btn-secondary">
                                    <i class="icon-arrow-left mr-2"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Lanjutkan Pembayaran <i class="icon-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="termsModalLabel">Syarat dan Ketentuan Reservasi</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>1. Pembayaran</h6>
                <p>Pembayaran harus dilakukan dalam waktu 24 jam setelah reservasi dibuat. Jika tidak, reservasi akan dibatalkan secara otomatis.</p>

                <h6>2. Pembatalan</h6>
                <p>Pembatalan yang dilakukan lebih dari 7 hari sebelum tanggal keberangkatan akan dikenakan biaya administrasi 10% dari total pembayaran. Pembatalan dalam waktu kurang dari 7 hari tidak dapat dilakukan refund.</p>

                <h6>3. Perubahan Jadwal</h6>
                <p>Perubahan jadwal dapat dilakukan maksimal 3 hari sebelum tanggal keberangkatan dengan syarat ketersediaan kuota.</p>

                <h6>4. Ketentuan Diskon</h6>
                <p>Diskon hanya berlaku untuk pembayaran penuh dan tidak dapat digabungkan dengan promo lainnya.</p>

                <h6>5. Dokumen Perjalanan</h6>
                <p>Peserta wajib membawa dokumen identitas asli selama perjalanan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

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

<!-- JavaScript for Dynamic Calculation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pricePerPerson = {{ $paket->harga_per_pack }};
    const discountThreshold = {{ $paket->peserta_diskon }};
    const discountPercentage = {{ $paket->nilai_diskon }};
    const durationDays = {{ $paket->durasi_hari }};

    const jumlahPesertaInput = document.getElementById('jumlah_peserta');
    const tglMulaiInput = document.getElementById('tgl_reservasi_mulai');
    const tglAkhirDisplay = document.getElementById('tgl_reservasi_akhir');
    const tglAkhirHidden = document.getElementById('tgl_reservasi_akhir_hidden');
    const participantCount = document.getElementById('participantCount');
    const discountInfo = document.getElementById('discountInfo');
    const discountText = document.getElementById('discountText');
    const discountRow = document.getElementById('discountRow');
    const discountAmount = document.getElementById('discountAmount');
    const totalPayment = document.getElementById('totalPayment');
    const dateRangeDisplay = document.getElementById('dateRangeDisplay');

    // Format number with thousand separators
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Format date to DD/MM/YYYY
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }

    // Calculate end date based on start date and duration
    function calculateEndDate(startDate) {
        if (!startDate) return null;

        const date = new Date(startDate);
        date.setDate(date.getDate() + (durationDays - 1)); // Subtract 1 from duration
        return date.toISOString().split('T')[0]; // Return in YYYY-MM-DD format
    }

    // Update date display
    function updateDateDisplay(startDate) {
        if (!startDate) {
            tglAkhirDisplay.value = '';
            tglAkhirHidden.value = '';
            dateRangeDisplay.textContent = '';
            return;
        }

        const endDate = calculateEndDate(startDate);
        // tglAkhirDisplay.value = endDate;
        tglAkhirDisplay.value = formatDate(endDate);
        tglAkhirHidden.value = endDate;
        dateRangeDisplay.textContent = `${formatDate(startDate)} - ${formatDate(endDate)}`;
    }

    // Calculate total payment
    function calculateTotal() {
        const jumlahPeserta = parseInt(jumlahPesertaInput.value) || 0;
        participantCount.textContent = jumlahPeserta;

        let subtotal = pricePerPerson * jumlahPeserta;
        let discount = 0;

        // Check if eligible for discount
        if (discountPercentage > 0 && jumlahPeserta >= discountThreshold) {
            // Eligible for discount
            discount = subtotal * (discountPercentage / 100);
            discountInfo.classList.remove('d-none');
            discountRow.classList.remove('d-none');

            // Update to success style
            discountInfo.classList.add('alert-success');
            discountInfo.classList.remove('alert-warning');
            discountIcon.classList.remove('icon-info-circle');
            discountIcon.classList.add('icon-gift');

            discountText.textContent = `Anda mendapatkan diskon ${discountPercentage}% karena memesan minimal ${discountThreshold} peserta.`;
        } else {
            // Not eligible for discount
            discountInfo.classList.remove('d-none');
            discountRow.classList.remove('d-none');

            // Update to warning style
            discountInfo.classList.add('alert-warning');
            discountInfo.classList.remove('alert-success');
            discountIcon.classList.remove('icon-gift');
            discountIcon.classList.add('icon-info-circle');

            discountText.textContent = `Anda akan mendapatkan diskon ${discountPercentage}% jika memesan minimal ${discountThreshold} peserta.`;
        }

        const total = subtotal - discount;

        // Update display
        discountAmount.textContent = formatNumber(Math.round(discount));

        // Set hidden input value (raw number, tanpa format titik)
        document.getElementById('diskon_input').value = Math.round(discount);

        totalPayment.textContent = formatNumber(Math.round(total));
    }

    // Initialize calculation
    calculateTotal();
    updateDateDisplay(tglMulaiInput.value);

    // Add event listeners
    jumlahPesertaInput.addEventListener('input', calculateTotal);
    jumlahPesertaInput.addEventListener('change', function() {
        const maxPeserta = {{ $paket->kuota_peserta }};
        if (this.value > maxPeserta) {
            this.value = maxPeserta;
            calculateTotal();
        }
    });

    tglMulaiInput.addEventListener('change', function() {
        updateDateDisplay(this.value);
    });
});
</script>

<style>
    .datepicker {
        z-index: 9999 !important;
    }
    .bg-dark-transparent {
        background-color: rgba(0, 0, 0, 0.3);
    }
    .hero-wrap .overlay {
        background-color: rgba(0, 0, 0, 0.5);
    }
    .invalid-feedback {
        display: block;
        color: #dc3545;
    }
    .form-control-plaintext.bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endsection
