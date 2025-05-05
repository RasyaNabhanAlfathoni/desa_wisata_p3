<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DataKaryawanController;
use App\Http\Controllers\DataPelangganController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PaketWisataController;
use App\Http\Controllers\KategoriWisataController;
use App\Http\Controllers\PenginapanController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\ObyekWisataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ProfilePelangganController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KaryawanWithUserExport;
use App\Exports\PelangganWithUserExport;
use App\Exports\PaketWisataExport;
use App\Exports\ReservasiExport;
use App\Exports\LaporanKeuanganExport;
use Carbon\Carbon;

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/paket-wisata', [HomeController::class, 'paketWisata'])->name('paket_wisata');
Route::get('/paket-wisata/{id}', [HomeController::class, 'paketWisataDetail'])->name('paket-wisata.detail');
Route::get('/paket-wisata/{id}/reservasi', [HomeController::class, 'showReservasiForm'])->name('paket-wisata.reservasi');
Route::post('/paket-wisata/{id}/reservasi', [HomeController::class, 'processReservasi'])->name('paket-wisata.reservasi.submit');
Route::get('/obyek-wisata', [HomeController::class, 'obyekWisata'])->name('obyek_wisata');
Route::get('/obyek-wisata/{id}', [HomeController::class, 'obyekWisatadetail'])->name('obyek-wisata.detail');
Route::get('/penginapan', [HomeController::class, 'penginapan'])->name('penginapan');
Route::get('/penginapan/{id}', [HomeController::class, 'detailPenginapan'])->name('penginapan.detail');
Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/berita/{id}', [HomeController::class, 'beritaDetail'])->name('berita.detail');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');


// Authentication Routes (Gunakan middleware 'guest' untuk mencegah akses jika sudah login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// Email Verification Routes
Route::get('/email/verify', function () {
    return app()->make(AuthController::class)->verificationNotice();
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    return app()->make(AuthController::class)->verificationVerify($request);
})->middleware(['signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    return app()->make(AuthController::class)->verificationResend($request);
})->middleware(['throttle:6,1'])->name('verification.send');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ✅ Dashboard untuk masing-masing level
Route::middleware(['auth', 'level:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('/admin', AdminController::class);
    Route::resource('/kelola_data_karyawan', DataKaryawanController::class);

    // For Export users data to excel
    Route::get('/download-excel-karyawan', function () {
        $filename = 'data_karyawan_' . Carbon::now()->format('Y-m-d_H-i') . '.xlsx';
        return Excel::download(new KaryawanWithUserExport, $filename);
    })->name('download.excel-karyawan');

    Route::resource('/kelola_data_pelanggan', DataPelangganController::class);

    // For Export users data to excel
    Route::get('/download-excel-pelanggan', function () {
        $filename = 'data_pelanggan_' . Carbon::now()->format('Y-m-d_H-i') . '.xlsx';
        return Excel::download(new PelangganWithUserExport, $filename);
    })->name('download.excel-pelanggan');

    // Route::resource('/keuangan', KeuanganController::class);
    // Route::resource('/obyek_wisata', ObyekWisataController::class);
    // Route::resource('/kategori_wisata', KategoriWisataController::class);
    // Route::resource('/paket_wisata', PaketWisataController::class);
    // Route::resource('/penginapan', PenginapanController::class);
    // Route::resource('/berita', BeritaController::class);
    // Route::resource('/kategori_berita', KategoriBeritaController::class);
    // Route::resource('/reservasi', ReservasiController::class);
});

// ✅ Admin juga bisa CRUD semua yang ada di Pemilik
Route::middleware(['auth', 'level:pemilik'])->group(function () {
    Route::get('/pemilik', [PemilikController::class, 'index'])->name('pemilik.index');
    // Route::resource('/obyek_wisata', ObyekWisataController::class);
    // Route::resource('/kategori_wisata', KategoriWisataController::class);
    // Route::resource('/paket_wisata', PaketWisataController::class);
    // Route::resource('/penginapan', PenginapanController::class);
    // Route::resource('/berita', BeritaController::class);
    // Route::resource('/kategori_berita', KategoriBeritaController::class);
    // Route::resource('/keuangan', KeuanganController::class);
    // Route::resource('/reservasi', ReservasiController::class);
});

// ✅ Bendahara hanya bisa mengelola keuangan
Route::middleware(['auth', 'level:bendahara'])->group(function () {
    Route::get('/bendahara', [BendaharaController::class, 'index'])->name('bendahara.index');
});

// CRUD DATA ADMIN & PEMILIK
Route::middleware(['auth', 'level:admin,pemilik'])->group(function () {
    Route::resource('/kelola_obyek_wisata', ObyekWisataController::class);
    Route::resource('/kelola_kategori_wisata', KategoriWisataController::class);
    Route::resource('/kelola_paket_wisata', PaketWisataController::class);

    // For Export paket wisata data to excel
    Route::get('/download-excel-paket-wisata', function () {
        $filename = 'data_paket_wisata_' . Carbon::now()->format('Y-m-d_H-i') . '.xlsx';
        return Excel::download(new PaketWisataExport, $filename);
    })->name('download.excel-paket-wisata');

    Route::resource('/kelola_penginapan', PenginapanController::class);
    Route::resource('/kelola_berita', BeritaController::class);
    Route::resource('/kelola_kategori_berita', KategoriBeritaController::class);

});

// CRUD DATA ADMIN, PEMILIK & BENDAHARA
Route::middleware(['auth', 'level:admin,pemilik,bendahara'])->group(function () {
    Route::resource('/kelola_keuangan', KeuanganController::class);
    Route::resource('/kelola_notifikasi', NotifikasiController::class);

    // For Export keuangan data to excel
    Route::get('/download-excel-keuangan', function (Request $request) {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Format tanggal atau fallback ke 'all'
        $start = $tanggalAwal ? Carbon::parse($tanggalAwal)->format('Ymd') : 'all';
        $end = $tanggalAkhir ? Carbon::parse($tanggalAkhir)->format('Ymd') : 'all';

        $filename = "laporan_keuangan_{$start}_to_{$end}.xlsx";

        return Excel::download(new LaporanKeuanganExport($request), $filename);
    })->name('download.excel-keuangan');

    // For Export keuangan data to pdf
    Route::get('/download-pdf-keuangan', function (Request $request) {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Format nama file
        $start = $tanggalAwal ? Carbon::parse($tanggalAwal)->format('Ymd') : 'all';
        $end = $tanggalAkhir ? Carbon::parse($tanggalAkhir)->format('Ymd') : 'all';
        $filename = "laporan_keuangan_{$start}_to_{$end}.pdf";

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('keuangan.pdf-keuangan', [ // Untuk Render Si PDF.blade.php nya
            'reservasi' => (new LaporanKeuanganExport($request))->collection()
        ]);

        return $pdf->download($filename);
    })->name('download.pdf-keuangan');


    Route::resource('/kelola_reservasi', ReservasiController::class);
    Route::post('/reservasi/{id}/upload', [ReservasiController::class, 'upload'])->name('kelola_reservasi.upload');
    Route::post('/reservasi/{id}/konfirmasi', [ReservasiController::class, 'konfirmasi'])->name('kelola_reservasi.konfirmasi');
    Route::delete('/reservasi/{id}/batal', [ReservasiController::class, 'batal'])->name('kelola_reservasi.batal');

    // For Export reservasi data to excel
    Route::get('/download-excel-reservasi', function () {
        $filename = 'data_reservasi_' . Carbon::now()->format('Y-m-d_H-i') . '.xlsx';
        return Excel::download(new ReservasiExport, $filename);
    })->name('download.excel-reservasi');

    Route::resource('/profile', ProfileController::class);
});

// ✅ Pelanggan hanya bisa melakukan reservasi
Route::middleware(['auth', 'verified', 'level:pelanggan'])->group(function () {
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    // Route::get('/pelanggan/about', [PelangganController::class, 'about'])->name('pelanggan.about');
    Route::get('/pelanggan/paket-wisata', [PelangganController::class, 'paketWisata'])->name('pelanggan.paket_wisata');
    Route::get('/pelanggan/paket-wisata/{id}', [PelangganController::class, 'paketWisataDetail'])->name('pelanggan.paket-wisata.detail');
    Route::get('/pelanggan/paket-wisata/{id}/reservasi', [PelangganController::class, 'showReservasiForm'])->name('pelanggan.paket-wisata.reservasi');
    Route::post('/pelanggan/paket-wisata/{id}/reservasi', [PelangganController::class, 'processReservasi'])->name('pelanggan.paket-wisata.reservasi.submit');
    Route::get('/pelanggan/paket-wisata/{id}/reservasi/pembayaran', [PelangganController::class, 'showPembayaranForm'])->name('pelanggan.paket-wisata.pembayaran');
    Route::post('/pelanggan/paket-wisata/{id}/reservasi/pembayaran', [PelangganController::class, 'submitPembayaran'])->name('pelanggan.paket-wisata.pembayaran.submit');
    Route::get('/pelanggan/obyek-wisata', [PelangganController::class, 'obyekWisata'])->name('pelanggan.obyek_wisata');
    Route::get('/pelanggan/obyek-wisata/{id}', [PelangganController::class, 'obyekWisatadetail'])->name('pelanggan.obyek-wisata.detail');
    Route::get('/pelanggan/penginapan', [PelangganController::class, 'penginapan'])->name('pelanggan.penginapan');
    Route::get('/pelanggan/penginapan/{id}', [PelangganController::class, 'detailPenginapan'])->name('pelanggan.penginapan.detail');
    Route::get('/pelanggan/berita', [PelangganController::class, 'berita'])->name('pelanggan.berita');
    Route::get('/pelanggan/berita/{id}', [PelangganController::class, 'beritaDetail'])->name('pelanggan.berita.detail');

    Route::get('/pelanggan/reservasiku', [PelangganController::class, 'reservasiSaya'])->name('pelanggan.reservasiku');
    Route::get('/pelanggan/reservasiku/detail/{id}', [PelangganController::class, 'detailReservasi'])->name('pelanggan.paket-wisata.reservasi.detail');
    Route::delete('/pelanggan/reservasiku/batal/{id}', [PelangganController::class, 'batalkanReservasi'])->name('pelanggan.paket-wisata.reservasi.batal');
    Route::post('/pelanggan/reservasiku/update-bukti/{id}', [PelangganController::class, 'updateBuktiTransfer'])->name('pelanggan.paket-wisata.update-bukti');

    Route::get('/pelanggan/notifikasi', [PelangganController::class, 'notifikasi'])->name('pelanggan.notifikasi');


    // Profile Pelanggan
    Route::get('/pelanggan/profile', [ProfilePelangganController::class, 'index'])->name('profile-pelanggan.index');
    Route::get('/pelanggan/profile/edit/{id}', [ProfilePelangganController::class, 'edit'])->name('profile-pelanggan.edit');
    Route::put('/pelanggan/profile/update/{id}', [ProfilePelangganController::class, 'update'])->name('profile-pelanggan.update');
});
