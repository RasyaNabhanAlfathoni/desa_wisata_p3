<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ObyekWisata;
use App\Models\PaketWisata;
use App\Models\Penginapan;
use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\Pelanggan;
use App\Models\KategoriWisata; // Add this for categories
use Carbon\Carbon;
use App\Models\Reservasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obyekWisatas = ObyekWisata::latest()->get();
        $paketWisatas = PaketWisata::latest()->get();
        $penginapans = Penginapan::latest()->get();
        $beritas = Berita::latest()->get();
        $pelanggans = Pelanggan::latest()->get();

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.index', [
            'title' => 'Pelanggan',
            'title2' => 'Dashboard',
            'menu' => 'Pelanggan',
            'obyekWisatas' => $obyekWisatas,
            'penginapans' => $penginapans,
            'paketWisatas' => $paketWisatas,
            'beritas' => $beritas,
            'pelanggans' => $pelanggans,
            'pelanggan' => $pelanggan,
            'user' => $user,
        ]);
    }

    public function about()
    {
        $obyekWisatas = ObyekWisata::latest()->get();
        $paketWisatas = PaketWisata::latest()->get();
        $penginapans = Penginapan::latest()->get();
        $beritas = Berita::latest()->get();
        $pelanggans = Pelanggan::latest()->get();

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.about', [
            'title' => 'Pelanggan',
            'title2' => 'About',
            'menu' => 'About',
            'obyekWisatas' => $obyekWisatas,
            'penginapans' => $penginapans,
            'paketWisatas' => $paketWisatas,
            'beritas' => $beritas,
            'pelanggans' => $pelanggans,
            'pelanggan' => $pelanggan,
            'user' => $user,
        ]);
    }

    public function paketWisata(Request $request)
    {
        $query = PaketWisata::query();

        // Filter berdasarkan nama paket
        if ($request->has('paket_id') && $request->paket_id != '') {
            $query->where('id', $request->paket_id);
        }

        // Filter berdasarkan jumlah peserta (minimal kapasitas)
        if ($request->has('jumlah_peserta') && $request->jumlah_peserta != '') {
            $query->where('jumlah_peserta', '>=', $request->jumlah_peserta);
        }

        // Filter berdasarkan rentang harga
        if ($request->has('harga_min') && $request->harga_min != '') {
            $query->where('harga_per_pack', '>=', $request->harga_min);
        }

        if ($request->has('harga_max') && $request->harga_max != '') {
            $query->where('harga_per_pack', '<=', $request->harga_max);
        }

        // Filter berdasarkan tanggal ketersediaan
        if ($request->has('date_from') && $request->date_from != '' &&
            $request->has('date_to') && $request->date_to != '') {

            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;

            $query->whereDoesntHave('reservasi', function($q) use ($dateFrom, $dateTo) {
                $q->where(function($q) use ($dateFrom, $dateTo) {
                    $q->whereBetween('tgl_reservasi_mulai', [$dateFrom, $dateTo])
                    ->orWhereBetween('tgl_reservasi_akhir', [$dateFrom, $dateTo])
                    ->orWhere(function($q) use ($dateFrom, $dateTo) {
                        $q->where('tgl_reservasi_mulai', '<=', $dateFrom)
                            ->where('tgl_reservasi_akhir', '>=', $dateTo);
                    });
                })
                ->whereIn('status_reservasi_wisata', ['pesan', 'dibayar']);
            });
        }

        // Ambil hasil akhir dengan pagination
        $paketWisatas = $query->latest()->paginate(6)->appends($request->query());

        // Ambil data tambahan untuk tampilan
        $paketWisatasAll = PaketWisata::all();
        $obyekWisatas = ObyekWisata::latest()->take(5)->get();
        $penginapans = Penginapan::latest()->take(5)->get();
        $beritas = Berita::latest()->take(3)->get();
        $pelanggans = Pelanggan::latest()->take(5)->get();

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.paket_wisata', [
            'title' => 'Pelanggan',
            'title2' => 'Paket Wisata',
            'menu' => 'Paket_wisata',
            'paketWisatas' => $paketWisatas,
            'paketWisatasAll' => $paketWisatasAll,
            'obyekWisatas' => $obyekWisatas,
            'penginapans' => $penginapans,
            'beritas' => $beritas,
            'pelanggans' => $pelanggans,
            'pelanggan' => $pelanggan,
            'user' => $user,
        ]);
    }

    public function PaketWisataDetail($id)
    {
        // Ambil data tambahan untuk tampilan
        $paketWisata = PaketWisata::findOrFail($id);
        $paketWisatas = PaketWisata::latest()->take(5)->get();

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.detail_paket_wisata', [
            'title' => 'Pelanggan',
            'title2' => 'Detail Paket Wisata',
            'menu' => 'Paket_wisata',
            'paket' => $paketWisata,
            'paketWisatas' => $paketWisatas,
            'pelanggan' => $pelanggan,
            'user' => $user,
        ]);
    }

    // Di dalam controller Anda
    public function reservasiSaya()
    {
        $user = auth()->user();
        $pelanggan = $user->pelanggan;

        // Ambil reservasi milik pelanggan yang login
        $reservasis = Reservasi::with('paket')
            ->where('id_pelanggan', $pelanggan->id)
            ->latest()
            ->paginate(10);

        return view('pelanggan.reservasiku', [
            'title' => 'Pelanggan',
            'title2' => 'Daftar Reservasi Saya',
            'menu' => 'Reservasiku',
            'reservasis' => $reservasis,
            'pelanggan' => $pelanggan,
            'user' => $user,
        ]);
    }

    public function detailReservasi($id)
    {
        $reservasi = Reservasi::with('paket')->findOrFail($id);
        $pelanggan = Pelanggan::where('id_user', auth()->id())->firstOrFail();

        // Pastikan reservasi milik pelanggan yang login
        if ($reservasi->id_pelanggan != $pelanggan->id) {
            return redirect()->route('pelanggan.reservasiku')
                ->with('error', 'Anda tidak memiliki akses ke reservasi ini.');
        }

        return view('pelanggan.detail_reservasi', [
            'title' => 'Pelanggan',
            'title2' => 'Detail Reservasi Paket Wisata',
            'menu' => 'Reservasiku',
            'reservasi' => $reservasi,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function batalkanReservasi($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $pelanggan = Pelanggan::where('id_user', auth()->id())->firstOrFail();

        // Pastikan reservasi milik pelanggan yang login
        if ($reservasi->id_pelanggan != $pelanggan->id) {
            return redirect()->route('pelanggan.reservasiku')
                ->with('error', 'Anda tidak memiliki akses ke reservasi ini.');
        }

        // Hanya bisa dibatalkan jika status masih 'pesan' atau 'dibayar'
        if (!in_array($reservasi->status_reservasi_wisata, ['pesan', 'dibayar'])) {
            return redirect()->route('pelanggan.reservasiku')
                ->with('error', 'Reservasi tidak dapat dibatalkan karena status sudah ' . $reservasi->status_reservasi_wisata);
        }

        try {
            $reservasi->status_reservasi_wisata = 'dibatalkan';
            $reservasi->save();

            return redirect()->route('pelanggan.reservasiku')
                ->with('pesan', 'Reservasi berhasil dibatalkan');
        } catch (\Exception $e) {
            return redirect()->route('pelanggan.reservasiku')
                ->with('error', 'Gagal membatalkan reservasi: ' . $e->getMessage());
        }
    }


    // Proses Reservasi
    public function showReservasiForm($id)
    {
        $paket = PaketWisata::findOrFail($id);
        $pelanggan = Pelanggan::where('id_user', auth()->id())->firstOrFail();

        // Cek ketersediaan paket
        $available = $this->checkAvailability($paket);

        return view('pelanggan.reservasi_paket_wisata', [
            'title' => 'Pelanggan',
            'title2' => 'Reservasi Paket Wisata',
            'menu' => 'Paket_wisata',
            'paket' => $paket,
            'pelanggan' => $pelanggan,
            'available' => $available,

        ]);
    }

    public function processReservasi(Request $request, $id)
    {
        $paket = PaketWisata::findOrFail($id);
        $pelanggan = Pelanggan::where('id_user', auth()->id())->firstOrFail();

        try {
            DB::beginTransaction();
            // Cek ketersediaan lagi sebelum menyimpan
            if (!$this->checkAvailability($paket, $request->tgl_reservasi_mulai, $request->tgl_reservasi_akhir)) {
                return back()->with('error', 'Maaf, paket wisata tidak tersedia pada tanggal yang dipilih.');
            }

            // Hitung total bayar
            $subtotal = $paket->harga_per_pack * $request->jumlah_peserta;
            $diskon = 0;

            // Jika ada diskon
            if ($paket->peserta_diskon && $request->jumlah_peserta >= $paket->peserta_diskon) {
                $diskon = $subtotal * ($paket->nilai_diskon / 100);
            }

            $total_bayar = $subtotal - $diskon;

            // Create reservation
            $reservasi = new Reservasi();
            $reservasi->id_pelanggan = $pelanggan->id;
            $reservasi->id_paket = $paket->id;
            $reservasi->tgl_reservasi_mulai = $request->tgl_reservasi_mulai;
            $reservasi->tgl_reservasi_akhir = $request->tgl_reservasi_akhir;
            $reservasi->harga = $paket->harga_per_pack;
            $reservasi->jumlah_peserta = $request->jumlah_peserta;
            $reservasi->nilai_diskon = $paket->nilai_diskon;
            $reservasi->diskon = $request->diskon;
            $reservasi->total_bayar = $total_bayar;
            $reservasi->status_reservasi_wisata = 'pesan'; // Default status is 'pesan'
            $reservasi->save();

            DB::commit();

            return redirect()->route('pelanggan.paket-wisata.pembayaran', ['id' => $reservasi->id])->with('pesan', 'Reservasi berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan reservasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function checkAvailability($paket, $tanggal_mulai = null, $tanggal_akhir = null)
    {
        // Jika tidak ada tanggal yang diberikan, return true untuk form awal
        if (!$tanggal_mulai || !$tanggal_akhir) {
            return true;
        }

        // Cek apakah ada reservasi yang overlapping
        $overlapping = Reservasi::where('id_paket', $paket->id)
            ->whereNotIn('status_reservasi_wisata', ['dibatalkan', 'selesai'])
            ->where(function($query) use ($tanggal_mulai, $tanggal_akhir) {
                $query->whereBetween('tgl_reservasi_mulai', [$tanggal_mulai, $tanggal_akhir])
                    ->orWhereBetween('tgl_reservasi_akhir', [$tanggal_mulai, $tanggal_akhir])
                    ->orWhere(function($q) use ($tanggal_mulai, $tanggal_akhir) {
                        $q->where('tgl_reservasi_mulai', '<=', $tanggal_mulai)
                            ->where('tgl_reservasi_akhir', '>=', $tanggal_akhir);
                    });
            })
            ->exists();

        return !$overlapping;
    }


    /**
     * Show the payment form for a reservation.
     */
    public function showPembayaranForm($id)
    {
        $reservasi = Reservasi::with('paket')->findOrFail($id);
        $pelanggan = Pelanggan::where('id_user', auth()->id())->firstOrFail();

        // Ensure the reservation belongs to the logged-in user
        if ($reservasi->pelanggan->id_user != Auth::id()) {
            return redirect()->route('pelanggan.paket-wisata')
                ->with('error', 'Anda tidak memiliki akses ke reservasi ini.');
        }

        return view('pelanggan.form_pembayaran', [
            'title' => 'Pembayaran Reservasi',
            'title2' => 'Pembayaran Reservasi Paket Wisata',
            'reservasi' => $reservasi,
            'pelanggan' => $pelanggan,
        ]);
    }

    /**
     * Process the payment submission.
     */
    public function submitPembayaran(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Ensure the reservation belongs to the logged-in user
        if ($reservasi->pelanggan->id_user != Auth::id()) {
            return redirect()->route('pelanggan.paket_wisata')
                ->with('error', 'Anda tidak memiliki akses ke reservasi ini.');
        }

        $request->validate([
            'file_bukti_tf' => 'required|file|mimes:jpeg,png,jpg,pdf|max:3072',
        ]);

        try {
            // Process file upload
            if ($request->hasFile('file_bukti_tf')) {
                $file = $request->file('file_bukti_tf');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('Reservasi', $fileName, 'public');

                // Update reservation status
                $reservasi->file_bukti_tf = $filePath;
                // $reservasi->status_reservasi_wisata = 'dibayar';
                $reservasi->updated_at = Carbon::now();
                $reservasi->save();

                return redirect()->route('pelanggan.paket-wisata')
                    ->with('pesan', 'Pembayaran berhasil dikonfirmasi. Reservasi Anda sedang diproses.');
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengunggah bukti pembayaran.')
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan reservasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function obyekWisata(Request $request)
    {
        $query = ObyekWisata::query()->with('kategori');

        // Filter berdasarkan kategori wisata
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('id_kategori_wisata', $request->kategori_id);
        }

        // Filter berdasarkan nama wisata
        if ($request->has('nama_wisata') && $request->nama_wisata != '') {
            $query->where('nama_wisata', 'like', '%'.$request->nama_wisata.'%');
        }

        // Ambil hasil akhir dengan pagination
        $obyekWisatas = $query->latest()->paginate(6)->appends($request->query());

        // Ambil data tambahan untuk tampilan
        $kategoriWisatas = KategoriWisata::all();
        $allObyekWisatas = ObyekWisata::latest()->take(5)->get();

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.obyek_wisata', [
            'title' => 'Pelanggan',
            'title2' => 'Obyek Wisata',
            'menu' => 'Obyek_wisata',
            'obyekWisatas' => $obyekWisatas,
            'kategoriWisatas' => $kategoriWisatas,
            'allObyekWisatas' => $allObyekWisatas,
            'user' => $user,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function obyekWisatadetail($id)
    {
        $obyekWisata = ObyekWisata::with('kategori')->findOrFail($id);
        $relatedObyekWisatas = ObyekWisata::where('id_kategori_wisata', $obyekWisata->id_kategori_wisata)
            ->where('id', '!=', $id)
            ->latest()
            // ->take(3)
            ->get();

            $user = auth()->user();

            // Mengambil data pelanggan terkait
            $pelanggan = $user->pelanggan;

        return view('pelanggan.detail_obyek_wisata', [
            'title' => 'Pelanggan',
            'title2' => 'Detail Obyek Wisata',
            'menu' => 'Obyek_wisata',
            'obyek' => $obyekWisata,
            'relatedObyekWisatas' => $relatedObyekWisatas,
            'user' => $user,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function penginapan(Request $request)
    {
        $query = Penginapan::query();

        // Filter berdasarkan nama penginapan
        if ($request->has('nama_penginapan') && $request->nama_penginapan != '') {
            $query->where('nama_penginapan', 'like', '%'.$request->nama_penginapan.'%');
        }

        // Ambil hasil akhir dengan pagination
        $penginapans = $query->latest()->paginate(6)->appends($request->query());

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.penginapan', [
            'title' => 'Pelanggan',
            'title2' => 'Penginapan',
            'menu' => 'Penginapan',
            'penginapans' => $penginapans,
            'user' => $user,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function detailPenginapan($id)
    {
        $penginapan = Penginapan::findOrFail($id);
        $relatedPenginapans = Penginapan::where('id', '!=', $id)
            ->latest()
            ->get();

            $user = auth()->user();

            // Mengambil data pelanggan terkait
            $pelanggan = $user->pelanggan;

        return view('pelanggan.detail_penginapan', [
            'title' => 'Pelanggan',
            'title2' => 'Detail Penginapan',
            'menu' => 'Penginapan',
            'penginapan' => $penginapan,
            'relatedPenginapans' => $relatedPenginapans,
            'user' => $user,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function berita(Request $request)
    {
        $query = Berita::query()->with('kategori');

        // Filter berdasarkan kategori berita
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('id_kategori_berita', $request->kategori_id);
        }

        // Filter berdasarkan judul berita
        if ($request->has('judul') && $request->judul != '') {
            $query->where('judul', 'like', '%'.$request->judul.'%');
        }

        // Ambil hasil akhir dengan pagination
        $beritas = $query->latest('tgl_post')->paginate(6)->appends($request->query());

        // Ambil data tambahan untuk tampilan
        $kategoriBeritas = KategoriBerita::all();
        $recentBeritas = Berita::latest('tgl_post')->take(3)->get();

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.berita', [
            'title' => 'Pelanggan',
            'title2' => 'Berita',
            'menu' => 'Berita',
            'beritas' => $beritas,
            'kategoriBeritas' => $kategoriBeritas,
            'recentBeritas' => $recentBeritas,
            'user' => $user,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function beritaDetail($id)
    {
        $berita = Berita::with('kategori')->findOrFail($id);
        $relatedBeritas = Berita::where('id_kategori_berita', $berita->id_kategori_berita)
            ->where('id', '!=', $id)
            ->latest('tgl_post')
            ->take(3)
            ->get();

        $recentBeritas = Berita::latest('tgl_post')
            ->where('id', '!=', $id)
            ->take(3)
            ->get();

        // Ambil data tambahan untuk tampilan
        $kategoriBeritas = KategoriBerita::all();

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.detail_berita', [
            'title' => 'Pelanggan',
            'title2' => 'Detail Berita',
            'menu' => 'Berita',
            'berita' => $berita,
            'relatedBeritas' => $relatedBeritas,
            'recentBeritas' => $recentBeritas,
            'kategoriBeritas' => $kategoriBeritas,
            'user' => $user,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function notifikasi()
    {
        $user = auth()->user();

        if (!$user || $user->level != 'pelanggan') {
            return redirect()->route('home');
        }

        // Filter untuk notifikasi dari 30 hari terakhir (lebih lama dari tampilan navbar)
        $timeFilter = Carbon::now()->subDays(30);

        // Berita baru
        $notif_berita = Berita::where('created_at', '>=', $timeFilter)
            ->latest()
            ->paginate(5, ['*'], 'berita');

        // Paket wisata baru
        $notif_paket_wisata = PaketWisata::where('created_at', '>=', $timeFilter)
            ->latest()
            ->paginate(5, ['*'], 'paket');

        // Reservasi-reservasi pelanggan
        // $notif_reservasi = Reservasi::where('id_pelanggan', $user->id_pelanggan)
        //     ->whereIn('status_reservasi_wisata', ['pesan', 'dibayar', 'dibatalkan'])
        //     ->where('created_at', '>=', $timeFilter)
        //     ->latest()
        //     ->paginate(10, ['*'], 'reservasi');

         // Reservasi-reservasi pelanggan (menambahkan eager loading untuk relasi dengan paket)
        $notif_reservasi = Reservasi::where('id_pelanggan', $user->pelanggan->id)
        ->where('created_at', '>=', $timeFilter)
        ->with('paket')  // Eager loading untuk relasi paket
        ->latest()
        ->paginate(10, ['*'], 'reservasi');

        return view('pelanggan.notifikasi', [
            'title' => 'Pelanggan',
            'title2' => 'Notifikasi',
            'menu' => 'Notifikasi',
            'pelanggan' => $user->pelanggan,
            'notif_berita' => $notif_berita,
            'notif_paket_wisata' => $notif_paket_wisata,
            'notif_reservasi' => $notif_reservasi,
            'user' => $user,
        ]);
    }

    public function contact()
    {
        $obyekWisatas = ObyekWisata::latest()->get();
        $paketWisatas = PaketWisata::latest()->get();
        $penginapans = Penginapan::latest()->get();
        $beritas = Berita::latest()->get();
        $pelanggans = Pelanggan::latest()->get();

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.contact', [
            'title' => 'Pelanggan',
            'title2' => 'Contact',
            'menu' => 'Contact',
            'obyekWisatas' => $obyekWisatas,
            'penginapans' => $penginapans,
            'paketWisatas' => $paketWisatas,
            'beritas' => $beritas,
            'pelanggans' => $pelanggans,
            'pelanggan' => $pelanggan,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
