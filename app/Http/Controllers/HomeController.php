<?php

namespace App\Http\Controllers;

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

class HomeController extends Controller
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
        $pelanggan = Pelanggan::latest()->get();

        return view('home.index', [
            'title' => 'Home',
            'title2' => 'Dashboard',
            'menu' => 'Home',
            'obyekWisatas' => $obyekWisatas,
            'penginapans' => $penginapans,
            'paketWisatas' => $paketWisatas,
            'beritas' => $beritas,
            'pelanggans' => $pelanggan,
        ]);
    }

    public function about()
    {
        $obyekWisatas = ObyekWisata::latest()->get();
        $paketWisatas = PaketWisata::latest()->get();
        $penginapans = Penginapan::latest()->get();
        $beritas = Berita::latest()->get();
        $pelanggan = Pelanggan::latest()->get();

        return view('home.about', [
            'title' => 'Home',
            'title2' => 'About',
            'menu' => 'About',
            'obyekWisatas' => $obyekWisatas,
            'penginapans' => $penginapans,
            'paketWisatas' => $paketWisatas,
            'beritas' => $beritas,
            'pelanggans' => $pelanggan,
        ]);
    }

    public function paketWisata(Request $request)
    {
        $query = PaketWisata::query();

        // Validasi tanggal dari form
        $start = $request->date_from ? Carbon::parse($request->date_from) : null;
        $end = $request->date_to ? Carbon::parse($request->date_to) : null;

        if ($start && $end) {
            $query->whereDoesntHave('reservasi', function ($q) use ($start, $end) {
                $q->whereIn('status_reservasi_wisata', ['pesan', 'dibayar'])
                  ->where(function ($subQuery) use ($start, $end) {
                      $subQuery
                          ->whereBetween('tgl_reservasi_mulai', [$start, $end])
                          ->orWhereBetween('tgl_reservasi_akhir', [$start, $end])
                          ->orWhere(function ($q2) use ($start, $end) {
                              $q2->where('tgl_reservasi_mulai', '<=', $start)
                                 ->where('tgl_reservasi_akhir', '>=', $end);
                          });
                  });
            });
        }

        // Filter berdasarkan paket_id
        if ($request->filled('paket_id')) {
            $query->where('id', $request->paket_id);
        }

        // Filter berdasarkan jumlah peserta
        if ($request->filled('jumlah_peserta')) {
            $query->where('jumlah_peserta', '<=', $request->jumlah_peserta);
        }

        // Filter berdasarkan harga
        if ($request->filled('harga_min')) {
            $query->where('harga_per_pack', '>=', $request->harga_min);
        }

        if ($request->filled('harga_max')) {
            $query->where('harga_per_pack', '<=', $request->harga_max);
        }

        // Ambil hasil akhir dengan pagination
        $paketWisatas = $query->latest()->paginate(6)->appends($request->query());

        // Ambil data tambahan untuk tampilan
        $paketWisatasAll = PaketWisata::all();
        $obyekWisatas = ObyekWisata::latest()->take(5)->get();
        $penginapans = Penginapan::latest()->take(5)->get();
        $beritas = Berita::latest()->take(3)->get();
        $pelanggans = Pelanggan::latest()->take(5)->get();

        return view('home.paket_wisata', [
            'title' => 'Home',
            'title2' => 'Paket Wisata',
            'menu' => 'Paket_wisata',
            'paketWisatas' => $paketWisatas,
            'paketWisatasAll' => $paketWisatasAll,
            'obyekWisatas' => $obyekWisatas,
            'penginapans' => $penginapans,
            'beritas' => $beritas,
            'pelanggans' => $pelanggans,
        ]);
    }

    public function PaketWisataDetail($id)
    {
        // Ambil data tambahan untuk tampilan
        $paketWisata = PaketWisata::findOrFail($id);
        $paketWisatas = PaketWisata::latest()->take(5)->get();

        return view('home.detail_paket_wisata', [
            'title' => 'Home',
            'title2' => 'Detail Paket Wisata',
            'menu' => 'Paket_wisata',
            'paket' => $paketWisata,
            'paketWisatas' => $paketWisatas,
        ]);
    }

    public function showReservasiForm($id)
    {
        $paket = PaketWisata::findOrFail($id);
        $pelanggan = Pelanggan::where('id_user', auth()->id())->firstOrFail();

        // Cek ketersediaan paket
        $available = $this->checkAvailability($paket);

        return view('home.reservasi_paket_wisata', [
            'title' => 'Home',
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

        // Cek ketersediaan lagi sebelum menyimpan
        if (!$this->checkAvailability($paket, $request->tanggal_mulai, $request->tanggal_akhir)) {
            return back()->with('error', 'Maaf, paket wisata tidak tersedia pada tanggal yang dipilih.');
        }

        // Hitung total bayar
        $total_bayar = $paket->harga_per_pack * $request->jumlah_peserta;

        // Jika ada diskon
        if ($paket->peserta_diskon && $request->jumlah_peserta >= $paket->peserta_diskon) {
            $diskon = $total_bayar * ($paket->nilai_diskon / 100);
            $total_bayar -= $diskon;
        }

        // Simpan reservasi
        $reservasi = new Reservasi();
        $reservasi->id_pelanggan = $pelanggan->id;
        $reservasi->id_paket = $paket->id;
        $reservasi->tanggal_mulai = $request->tanggal_mulai;
        $reservasi->tanggal_akhir = $request->tanggal_akhir;
        $reservasi->harga = $paket->harga_per_pack;
        $reservasi->jumlah_peserta = $request->jumlah_peserta;
        $reservasi->total_bayar = $total_bayar;
        $reservasi->status_reservasi_wisata = 'pesan';
        $reservasi->save();

        return redirect()->route('payment', ['id' => $reservasi->id])->with('success', 'Reservasi berhasil dibuat!');
    }

    private function checkAvailability($paket, $tanggal_mulai = null, $tanggal_akhir = null)
    {
        // Jika tidak ada tanggal yang diberikan, return true untuk form awal
        if (!$tanggal_mulai || !$tanggal_akhir) {
            return true;
        }

        // Cek apakah ada reservasi yang overlapping
        $overlapping = Reservasi::where('id_paket', $paket->id)
            ->where('status_reservasi_wisata', '!=', 'dibatalkan')
            ->where(function($query) use ($tanggal_mulai, $tanggal_akhir) {
                $query->whereBetween('tanggal_mulai', [$tanggal_mulai, $tanggal_akhir])
                    ->orWhereBetween('tanggal_akhir', [$tanggal_mulai, $tanggal_akhir])
                    ->orWhere(function($q) use ($tanggal_mulai, $tanggal_akhir) {
                        $q->where('tanggal_mulai', '<=', $tanggal_mulai)
                            ->where('tanggal_akhir', '>=', $tanggal_akhir);
                    });
            })
            ->exists();

        return !$overlapping;
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

        return view('home.obyek_wisata', [
            'title' => 'Home',
            'title2' => 'Obyek Wisata',
            'menu' => 'Obyek_wisata',
            'obyekWisatas' => $obyekWisatas,
            'kategoriWisatas' => $kategoriWisatas,
            'allObyekWisatas' => $allObyekWisatas,
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

        return view('home.detail_obyek_wisata', [
            'title' => 'Home',
            'title2' => 'Detail Obyek Wisata',
            'menu' => 'Obyek_wisata',
            'obyek' => $obyekWisata,
            'relatedObyekWisatas' => $relatedObyekWisatas,
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

        return view('home.penginapan', [
            'title' => 'Home',
            'title2' => 'Penginapan',
            'menu' => 'Penginapan',
            'penginapans' => $penginapans,
        ]);
    }

    public function detailPenginapan($id)
    {
        $penginapan = Penginapan::findOrFail($id);
        $relatedPenginapans = Penginapan::where('id', '!=', $id)
            ->latest()
            ->get();

        return view('home.detail_penginapan', [
            'title' => 'Home',
            'title2' => 'Detail Penginapan',
            'menu' => 'Penginapan',
            'penginapan' => $penginapan,
            'relatedPenginapans' => $relatedPenginapans,
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

        return view('home.berita', [
            'title' => 'Home',
            'title2' => 'Berita',
            'menu' => 'Berita',
            'beritas' => $beritas,
            'kategoriBeritas' => $kategoriBeritas,
            'recentBeritas' => $recentBeritas,
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

        return view('home.detail_berita', [
            'title' => 'Home',
            'title2' => 'Detail Berita',
            'menu' => 'Berita',
            'berita' => $berita,
            'relatedBeritas' => $relatedBeritas,
            'recentBeritas' => $recentBeritas,
            'kategoriBeritas' => $kategoriBeritas,
        ]);
    }

    public function contact()
    {
        $obyekWisatas = ObyekWisata::latest()->get();
        $paketWisatas = PaketWisata::latest()->get();
        $penginapans = Penginapan::latest()->get();
        $beritas = Berita::latest()->get();
        $pelanggan = Pelanggan::latest()->get();

        return view('home.contact', [
            'title' => 'Home',
            'title2' => 'Contact',
            'menu' => 'Contact',
            'obyekWisatas' => $obyekWisatas,
            'penginapans' => $penginapans,
            'paketWisatas' => $paketWisatas,
            'beritas' => $beritas,
            'pelanggans' => $pelanggan,
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
