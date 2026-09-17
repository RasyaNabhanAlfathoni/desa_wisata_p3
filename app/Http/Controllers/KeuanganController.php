<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaketWisata;
use App\Models\Reservasi;
use App\Models\Pelanggan;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paketWisata = PaketWisata::all();
        $statusReservasi = ['pesan', 'dibayar', 'selesai', 'dibatalkan'];
        $pelanggan = Pelanggan::select('id', 'nama_lengkap')->get();

        $reservasi = []; // Default kosong jika belum difilter

        // Cek apakah tombol "Tampilkan" ditekan (filter dikirimkan)
        if ($request->has('filter')) {
            $query = Reservasi::with('pelanggan', 'paket')
            ->select([
                'id',
                'id_pelanggan',
                'id_paket',
                'tgl_reservasi_mulai',
                'tgl_reservasi_akhir',
                'harga',
                'jumlah_peserta',
                'diskon',
                'nilai_diskon',
                'total_bayar',
                'file_bukti_tf',
                'status_reservasi_wisata'
            ]);

            // Filter Nama Pelanggan
            if ($request->filled('nama_lengkap')) {
                $query->where('id_pelanggan', $request->nama_lengkap);
            }

            // Filter Paket Wisata
            if ($request->filled('paket_wisata') && $request->paket_wisata != 'all') {
                $query->where('id_paket', $request->paket_wisata);
            }

            // Filter Status Reservasi
            if ($request->filled('status') && $request->status != 'all') {
                $query->where('status_reservasi_wisata', $request->status);
            }

            // Filter Rentang Tanggal Reservasi
            if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
                $query->whereBetween('tgl_reservasi_mulai', [$request->tanggal_awal, $request->tanggal_akhir]);
            }

            $reservasi = $query->get(); // Ambil hasil filter
        }

        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        if ($tanggalAwal && $tanggalAkhir) {
            $periode = \Carbon\Carbon::parse($tanggalAwal)->format('d M Y') . ' - ' .
                    \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y');
        } elseif ($tanggalAwal) {
            $periode = 'Dari ' . \Carbon\Carbon::parse($tanggalAwal)->format('d M Y');
        } elseif ($tanggalAkhir) {
            $periode = 'Sampai ' . \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y');
        } else {
            $periode = 'Semua Data';
        }

        return view('keuangan.index', [
            'title' => ucfirst(Auth::user()->level),
            'menu' => 'keuangan',
            'page' => 'Keuangan',
            'reservasi' => $reservasi,
            'paketWisata' => $paketWisata,
            'statusReservasi' => $statusReservasi,
            'pelanggan' => $pelanggan,
            'periode' => $periode
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
