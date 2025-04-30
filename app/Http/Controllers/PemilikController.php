<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use Carbon\Carbon;

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Ambil jumlah data per halaman
    $perPage = $request->input('per_page', 5);
    $status = $request->input('status', '');

    // Query untuk mengambil data pengguna dengan filter level
    $query = Reservasi::with(['pelanggan', 'paket']);

    // Jika filter status diisi, tambahkan kondisi where
    if (!empty($status)) {
        $query->where('status_reservasi_wisata', $status);
    }

    // Pagination dengan append untuk mempertahankan filter saat navigasi halaman
    $reservasis = $query->paginate($perPage)->appends([
        'per_page' => $perPage,
        'status' => $status
    ]);

    // **Perhitungan untuk widget dashboard**
    $totalPendapatan = Reservasi::whereIn('status_reservasi_wisata', ['dibayar', 'selesai'])->sum('total_bayar');

    $totalPendapatanPerBulan = Reservasi::whereIn('status_reservasi_wisata', ['dibayar', 'selesai'])
        ->whereMonth('tgl_reservasi_mulai', date('m'))
        ->whereYear('tgl_reservasi_mulai', date('Y'))
        ->sum('total_bayar');

    $totalPembayaranTertunda = Reservasi::where('status_reservasi_wisata', 'pesan')->sum('total_bayar');

    $totalReservasi = Reservasi::count();

    // Hitung reservasi hari ini
    $today = Carbon::today();
    $reservasiHariIni = Reservasi::whereDate('created_at', $today)->count();
    $reservasiKemarin = Reservasi::whereDate('created_at', $today->subDay())->count();
    $reservasiPerubahan = $reservasiKemarin != 0 ?
        round(($reservasiHariIni - $reservasiKemarin) / $reservasiKemarin * 100, 2) : 0;

    // Data untuk chart (7 hari terakhir)
    $chart_labels = [];
    $reservasi_data = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::today()->subDays($i);
        $chart_labels[] = $date->format('d M');
        $reservasi_data[] = Reservasi::whereDate('created_at', $date)->count();
    }

    return view('pemilik.index', [
        'title' => 'Pemilik',
        'menu' => 'Pemilik',
        'page' => 'Dashboard',
        'reservasis' => $reservasis,
        'totalPendapatan' => $totalPendapatan,
        'totalPendapatanPerBulan' => $totalPendapatanPerBulan,
        'totalPembayaranTertunda' => $totalPembayaranTertunda,
        'totalReservasi' => $totalReservasi,
        'reservasiHariIni' => $reservasiHariIni,
        'reservasiPerubahan' => $reservasiPerubahan,
        'chart_labels' => $chart_labels,
        'reservasi_data' => $reservasi_data,
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
