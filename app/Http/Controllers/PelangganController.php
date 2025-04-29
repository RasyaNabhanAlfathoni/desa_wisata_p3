<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ObyekWisata;
use App\Models\PaketWisata;
use App\Models\Penginapan;
use App\Models\Berita;
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
            $query->where('jumlah_peserta', '<=', $request->jumlah_peserta);
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

            $query->whereDoesntHave('reservasiWisata', function($q) use ($dateFrom, $dateTo) {
                $q->where(function($q) use ($dateFrom, $dateTo) {
                    $q->whereBetween('tgl_reservasi_mulai', [$dateFrom, $dateTo])
                    ->orWhereBetween('tgl_reservasi_akhir', [$dateFrom, $dateTo]);
                })
                ->whereNotIn('status_reservasi_wisata', ['selesai', 'dibatalkan']);
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
            ->where('status_reservasi_wisata', '!=', 'dibatalkan')
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
            return redirect()->route('pelanggan.paket-wisata')
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
                $reservasi->status_reservasi_wisata = 'dibayar';
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

    public function obyekWisata()
    {
        $obyekWisatas = ObyekWisata::latest()->get();
        $paketWisatas = PaketWisata::latest()->get();
        $penginapans = Penginapan::latest()->get();
        $beritas = Berita::latest()->get();
        $pelanggans = Pelanggan::latest()->get();

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.obyek_wisata', [
            'title' => 'Pelanggan',
            'title2' => 'Obyek Wisata',
            'menu' => 'Obyek_wisata',
            'obyekWisatas' => $obyekWisatas,
            'penginapans' => $penginapans,
            'paketWisatas' => $paketWisatas,
            'beritas' => $beritas,
            'pelanggans' => $pelanggans,
            'pelanggan' => $pelanggan,
            'user' => $user,
        ]);
    }

    public function penginapan()
    {
        $obyekWisatas = ObyekWisata::latest()->get();
        $paketWisatas = PaketWisata::latest()->get();
        $penginapans = Penginapan::latest()->get();
        $beritas = Berita::latest()->get();
        $pelanggans = Pelanggan::latest()->get();

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.penginapan', [
            'title' => 'Pelanggan',
            'title2' => 'Penginapan',
            'menu' => 'Penginapan',
            'obyekWisatas' => $obyekWisatas,
            'penginapans' => $penginapans,
            'paketWisatas' => $paketWisatas,
            'beritas' => $beritas,
            'pelanggans' => $pelanggans,
            'pelanggan' => $pelanggan,
            'user' => $user,
        ]);
    }

    public function berita()
    {
        $obyekWisatas = ObyekWisata::latest()->get();
        $paketWisatas = PaketWisata::latest()->get();
        $penginapans = Penginapan::latest()->get();
        $beritas = Berita::latest()->get();
        $pelanggans = Pelanggan::latest()->get();

        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('pelanggan.berita', [
            'title' => 'Pelanggan',
            'title2' => 'Berita',
            'menu' => 'Berita',
            'obyekWisatas' => $obyekWisatas,
            'penginapans' => $penginapans,
            'paketWisatas' => $paketWisatas,
            'beritas' => $beritas,
            'pelanggans' => $pelanggans,
            'pelanggan' => $pelanggan,
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
