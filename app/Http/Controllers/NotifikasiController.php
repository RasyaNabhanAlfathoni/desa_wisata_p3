<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Karyawan;
use App\Models\Berita;
use App\Models\PaketWisata;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotifikasiController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $level = $user->level;
        $filter = $request->input('filter'); // filter waktu

        // Fungsi filter waktu
        $applyTimeFilter = function ($query) use ($filter) {
            if ($filter === 'today') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($filter === 'week') {
                $query->where('created_at', '>=', Carbon::now()->subWeek());
            } elseif ($filter === 'month') {
                $query->where('created_at', '>=', Carbon::now()->subMonth());
            } elseif ($filter === 'year') {
                $query->where('created_at', '>=', Carbon::now()->subYear());
            }
            return $query;
        };

        // Inisialisasi collection kosong
        $notif_user_baru = collect();
        $notif_karyawan_baru = collect();
        $notif_pelanggan_baru = collect();
        $notif_reservasi_baru = collect();
        $notif_reservasi_diterima = collect();
        $notif_berita_baru = collect();
        $notif_paket_wisata = collect();

        if ($level == 'admin') {
            $notif_user_baru = $applyTimeFilter(User::query())->latest()->take(5)->get();
            $notif_karyawan_baru = $applyTimeFilter(Karyawan::query())->latest()->take(5)->get();
            $notif_pelanggan_baru = $applyTimeFilter(Pelanggan::query())->latest()->take(5)->get();
        }

        if ($level == 'admin' || $level == 'pemilik'){
            $notif_berita_baru = $applyTimeFilter(Berita::query())->latest()->take(5)->get();
            $notif_paket_wisata = $applyTimeFilter(PaketWisata::query())->latest()->take(5)->get();
        }

        if ($level == 'admin' || $level == 'pemilik' || $level == 'bendahara') {
            // $notif_reservasi_baru = $applyTimeFilter(
            //     Reservasi::where('status_reservasi_wisata', 'pesan')
            // )->latest()->get();
            $notif_reservasi_baru = $applyTimeFilter(Reservasi::query())->latest()->take(5)->get();
        }

        if ($level == 'pelanggan') {
            $pelanggan = Pelanggan::where('id_user', $user->id)->first();

            if ($pelanggan) {
                $notif_reservasi_diterima = $applyTimeFilter(
                    Reservasi::where('id_pelanggan', $pelanggan->id)
                            ->whereIn('status_reservasi_wisata', ['dibayar', 'selesai'])
                )->latest()->get();
            }

            $notif_berita_baru = $applyTimeFilter(Berita::query())->latest()->take(5)->get();
        }

        return view('notifikasi.index', [
            'title' => ucfirst($level),
            'menu' => 'Notifikasi',
            'page' => 'Notifikasi',
            'filter' => $filter,
            'notif_user_baru' => $notif_user_baru,
            'notif_karyawan_baru' => $notif_karyawan_baru,
            'notif_pelanggan_baru' => $notif_pelanggan_baru,
            'notif_reservasi_baru' => $notif_reservasi_baru,
            'notif_reservasi_diterima' => $notif_reservasi_diterima,
            'notif_berita_baru' => $notif_berita_baru,
            'notif_paket_wisata_baru' => $notif_paket_wisata,
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
