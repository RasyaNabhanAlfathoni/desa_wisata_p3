<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil jumlah data per halaman
        $perPage = $request->input('per_page', 5); // Default 5 jika tidak dipilih
        $status = $request->input('status', ''); // Filter berdasarkan level

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

        return view('pemilik.index', [
            'title' => 'Pemilik',
            'menu' => 'Pemilik',
            'page' => 'Dashboard',
            'reservasis' => $reservasis,
            'totalPendapatan' => $totalPendapatan,
            'totalPendapatanPerBulan' => $totalPendapatanPerBulan,
            'totalPembayaranTertunda' => $totalPembayaranTertunda,
            'totalReservasi' => $totalReservasi
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
