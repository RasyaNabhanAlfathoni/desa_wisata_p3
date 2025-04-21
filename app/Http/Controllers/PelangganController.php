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
            'menu' => 'Home',
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
