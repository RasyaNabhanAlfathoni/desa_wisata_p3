<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservasi;
use App\Models\Pelanggan;
use App\Models\PaketWisata;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // First, update status for any reservations that have passed their end date
        $this->updateExpiredReservations();

        $reservasi = Reservasi::with(['pelanggan','paket'])->get();

        // Ambil jumlah data per halaman
        $perPage = $request->input('per_page', 5); // Default 5 jika tidak dipilih
        $status = $request->input('status', ''); // Filter berdasarkan level

        // Query untuk mengambil data pengguna dengan filter level
        $query = Reservasi::with(['pelanggan','paket']);

        // Jika filter status diisi, tambahkan kondisi where
        if (!empty($status)) {
            $query->where('status_reservasi_wisata', $status);
        }

        // Pagination dengan append untuk mempertahankan filter saat navigasi halaman
        $reservasis = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            'status' => $status
        ]);

        return view('reservasi.index', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'reservasi',
            'page' => 'Reservasi',
            'reservasis' => $reservasis,
        ]);
    }

    // Add this new private method to handle status updates
    private function updateExpiredReservations()
    {
        $today = Carbon::today()->toDateString();

        // Update reservations where end date has passed and status is not already 'selesai'
        Reservasi::where('tgl_reservasi_akhir', '<', $today)
             ->whereNotIn('status_reservasi_wisata', ['selesai', 'dibatalkan'])
             ->update(['status_reservasi_wisata' => 'selesai']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reservasi.create', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'reservasi',
            'page' => 'Create Reservasi',
            'pelanggans' => Pelanggan::all(),
            'pakets' => PaketWisata::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Cek apakah karyawan dengan email yang sama sudah ada
            $existingReservasi = DB::table('reservasi')
            ->where('id_pelanggan', $request->id_pelanggan)
            ->where('id_paket', $request->id_paket)
            ->where('tgl_reservasi_mulai', $request->tgl_reservasi_mulai)
            ->first();

            if ($existingReservasi) {
                return redirect()->route('kelola_reservasi.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Reservasi untuk pelanggan ini pada paket yang sama sudah terdaftar.',
                    'id_pelanggan' => $request->id_pelanggan,
                    'id_paket' => $request->id_paket,
                    'tgl_reservasi_mulai' => $request->tgl_reservasi_mulai,
                ]);
            } else {
                DB::beginTransaction(); // Mulai transaksi database

                $pelanggan = Pelanggan::with('user')->findOrFail($request->id_pelanggan);

                if ($pelanggan->user->aktif != 1) {
                    return redirect()->back()->with([
                        'status' => 'error',
                        'error' => 'Akun pelanggan ini sudah nonaktif dan tidak dapat membuat reservasi.'
                    ]);
                }

                // Upload file bukti jika ada
                $filebukti = null;
                if ($request->hasFile('file_bukti_tf')) {
                    $filebukti = $request->file('file_bukti_tf')->store('Reservasi');
                }

                Reservasi::create([
                    'id_pelanggan' => $request->id_pelanggan,
                    'id_paket' => $request->id_paket,
                    'tgl_reservasi_mulai' => $request->tgl_reservasi_mulai,
                    'tgl_reservasi_akhir' => $request->tgl_reservasi_akhir,
                    'harga' => $request->harga,
                    'jumlah_peserta' => $request->jumlah_peserta,
                    'diskon' => $request->diskon ?? 0,
                    'nilai_diskon' => $request->nilai_diskon ?? 0,
                    'total_bayar' => $request->total_bayar,
                    'file_bukti_tf' => $filebukti,
                    'status_reservasi_wisata' => $request->status_reservasi_wisata
                ]);

                $errorMessages = [];

                // Validasi ukuran file foto
                if ($request->hasFile($filebukti)) {
                    if ($request->file($filebukti)->getSize() > 3 * 1024 * 1024) { // 3MB dalam byte
                        $errorMessages[] = "Ukuran $filebukti melebihi 3MB!";
                    }
                }

                // Jika ada error, kembalikan dengan pesan
                if (!empty($errorMessages)) {
                    return redirect()->route('kelola_berita.create')->with([
                        'status' => 'error',
                        'error' => implode("<br>", $errorMessages), // Gabungkan error dalam satu pesan
                    ])->withInput();
                }

                DB::commit(); // Simpan perubahan ke database

                return redirect()->route('kelola_reservasi.index')->with('pesan', 'Reservasi berhasil ditambahkan.');
            }
        } catch (QueryException $e) {
            DB::rollBack(); // Batalkan transaksi jika ada error

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_reservasi.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Reservasi untuk pelanggan ini pada paket yang sama sudah terdaftar.',
                    'id_pelanggan' => $request->id_pelanggan,
                    'id_paket' => $request->id_paket,
                    'tgl_reservasi_mulai' => $request->tgl_reservasi_mulai,
                ])->withInput();
            }

            return redirect()->route('kelola_reservasi.create')->with([
                'status' => 'error',
                'error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservasi = Reservasi::with(['pelanggan', 'paket'])->findOrFail($id);

        return view('reservasi.show', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'reservasi',
            'page' => 'Detail Reservasi',
            'reservasi' => $reservasi,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reservasi = Reservasi::with(['pelanggan', 'paket'])->findOrFail($id);

        return view('reservasi.edit', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'reservasi',
            'page' => 'Edit Reservasi',
            'reservasi' => $reservasi,
            'pelanggans' => Pelanggan::all(),
            'pakets' => PaketWisata::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $reservasi = Reservasi::findOrFail($id);

            // Cek apakah reservasi dengan kombinasi data yang sama sudah ada (selain id saat ini)
            $existingReservasi = DB::table('reservasi')
                ->where('id_pelanggan', $request->id_pelanggan)
                ->where('id_paket', $request->id_paket)
                ->where('tgl_reservasi_mulai', $request->tgl_reservasi_mulai)
                ->where('id', '!=', $id)
                ->first();

            if ($existingReservasi) {
                return redirect()->route('kelola_reservasi.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Reservasi untuk pelanggan ini pada paket yang sama sudah terdaftar.',
                    'id_pelanggan' => $request->id_pelanggan,
                    'id_paket' => $request->id_paket,
                    'tgl_reservasi_mulai' => $request->tgl_reservasi_mulai,
                ]);
            } else {
                DB::beginTransaction(); // Mulai transaksi database

                $pelanggan = Pelanggan::with('user')->findOrFail($request->id_pelanggan);

                if ($pelanggan->user->aktif != 1) {
                    return redirect()->back()->with([
                        'status' => 'error',
                        'error' => 'Akun pelanggan ini sudah nonaktif dan tidak dapat membuat reservasi.'
                    ]);
                }

                // Persiapkan data yang akan diupdate
                $dataUpdate = [
                    'id_pelanggan' => $request->id_pelanggan,
                    'id_paket' => $request->id_paket,
                    'tgl_reservasi_mulai' => $request->tgl_reservasi_mulai,
                    'tgl_reservasi_akhir' => $request->tgl_reservasi_akhir,
                    'harga' => $request->harga,
                    'jumlah_peserta' => $request->jumlah_peserta,
                    'diskon' => $request->diskon ?? 0,
                    'nilai_diskon' => $request->nilai_diskon ?? 0,
                    'total_bayar' => $request->total_bayar,
                    'status_reservasi_wisata' => $request->status_reservasi_wisata
                ];

                // Upload file bukti jika ada
                if ($request->hasFile('file_bukti_tf')) {
                    // Hapus file lama jika ada
                    if ($reservasi->file_bukti_tf) {
                        Storage::delete($reservasi->file_bukti_tf);
                    }

                    $filebukti = $request->file('file_bukti_tf')->store('Reservasi');
                    $dataUpdate['file_bukti_tf'] = $filebukti;

                    // Validasi ukuran file
                    if ($request->file('file_bukti_tf')->getSize() > 3 * 1024 * 1024) { // 3MB dalam byte
                        return redirect()->route('kelola_reservasi.edit', $id)->with([
                            'status' => 'error',
                            'error' => 'Ukuran file bukti transfer melebihi 3MB!',
                        ])->withInput();
                    }
                }

                // Update data reservasi
                $reservasi->update($dataUpdate);

                DB::commit(); // Simpan perubahan ke database

                return redirect()->route('kelola_reservasi.index')->with('pesan', 'Reservasi berhasil diperbarui.');
            }
        } catch (QueryException $e) {
            DB::rollBack(); // Batalkan transaksi jika ada error

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_reservasi.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Reservasi untuk pelanggan ini pada paket yang sama sudah terdaftar.',
                    'id_pelanggan' => $request->id_pelanggan,
                    'id_paket' => $request->id_paket,
                    'tgl_reservasi_mulai' => $request->tgl_reservasi_mulai,
                ])->withInput();
            }

            return redirect()->route('kelola_reservasi.edit', $id)->with([
                'status' => 'error',
                'error' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $reservasi = Reservasi::findOrFail($id);

            // Hapus file bukti pembayaran jika ada
            if ($reservasi->file_bukti_tf) {
                Storage::delete($reservasi->file_bukti_tf);
            }

            // Hapus data reservasi
            $reservasi->delete();

            return redirect()->route('kelola_reservasi.index')->with('pesan', 'Reservasi ini berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('kelola_reservasi.index')->with([
                'status' => 'error',
                'error' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage(),
            ]);
        }
    }

    // Fungsi untuk mengunggah bukti pembayaran
    public function upload(Request $request, $id)
    {

        $reservasi = Reservasi::findOrFail($id);

        // Hapus bukti lama jika ada
        if ($reservasi->file_bukti_tf) {
            Storage::delete($reservasi->file_bukti_tf);
        }

        // Simpan file bukti baru
        $filebukti = $request->file('file_bukti_tf')->store('Reservasi');

        // Update reservasi dengan bukti pembayaran
        $reservasi->update([
            'file_bukti_tf' => $filebukti,
            'status_reservasi_wisata' => 'dibayar', // Ubah status setelah upload
        ]);

        return redirect()->back()->with('pesan', 'Bukti pembayaran berhasil diunggah.');
    }

    // Fungsi untuk konfirmasi pembayaran
    public function konfirmasi($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        if ($reservasi->status_reservasi_wisata !== 'pesan') {
            return redirect()->back()->with('error', 'Konfirmasi hanya bisa dilakukan saat status masih Pesan!');
        }

        if (!$reservasi->file_bukti_tf) {
            return redirect()->back()->with('error', 'Bukti pembayaran belum diunggah!');
        }

        $reservasi->update([
            'status_reservasi_wisata' => 'dibayar',
        ]);

        return redirect()->route('kelola_reservasi.index')
            ->with('pesan', 'Reservasi telah dikonfirmasi!');
    }


    // Fungsi untuk membatalkan reservasi
    public function batal($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        if (!in_array($reservasi->status_reservasi_wisata, ['pesan', 'dibayar'])) {
            return redirect()->back()->with('error', 'Pembatalan hanya bisa dilakukan saat status Pesan atau Dibayar!');
        }

        // Hapus file bukti jika ada
        if ($reservasi->file_bukti_tf) {
            Storage::delete($reservasi->file_bukti_tf);
        }

        $reservasi->update([
            'status_reservasi_wisata' => 'dibatalkan',
        ]);

        return redirect()->route('kelola_reservasi.index')->with('pesan', 'Reservasi berhasil dibatalkan!');
    }
}


