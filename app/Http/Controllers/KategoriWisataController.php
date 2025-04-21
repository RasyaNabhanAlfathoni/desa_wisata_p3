<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KategoriWisata;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class KategoriWisataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori_wisata = KategoriWisata::all();

        // Ambil jumlah data per halaman
        $perPage = $request->input('per_page', 5); // Default 5 jika tidak dipilih
        // $level = $request->input('level', ''); // Filter berdasarkan level

        // Query untuk mengambil data pengguna dengan filter level
        $query = KategoriWisata::query();

        // if (!empty($level)) {
        //     $query->where('level', $level);
        // }

        // Pagination dengan append untuk mempertahankan filter saat navigasi halaman
        $kategori_wisatas = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            // 'level' => $level
        ]);

        return view('kategori_wisata.index', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'kategori_wisata',
            'page' => 'Kategori Wisata',
            'kategori_wisatas' => $kategori_wisatas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori_wisata.create', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'kategori_wisata',
            'page' => 'Create Kategori Wisata',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Cek apakah paket dengan nama yang sama sudah ada
            $existingPaket = KategoriWisata::where('kategori_wisata', $request->kategori_wisata)
            ->first();

            if ($existingPaket) {
                return redirect()->route('kelola_kategori_wisata.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Kategori wisata ini sudah terdaftar.',
                    'kategori_wisata' => $request->kategori_wisata,
                ])->withInput();
            }

            DB::beginTransaction();

            // Simpan data ke database
            KategoriWisata::create([
                'kategori_wisata' => $request->kategori_wisata,
            ]);

            DB::commit();

            return redirect()->route('kelola_kategori_wisata.index')->with('pesan', 'Kategori Wisata ' . $request->kategori_wisata . ' berhasil ditambahkan.');
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_kategori_wisata.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Kategori wisata ini sudah terdaftar.',
                    'kategori_wisata' => $request->kategori_wisata,
                ])->withInput();
            }

            return redirect()->route('kelola_kategori_wisata.create')->with([
                'status' => 'error',
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ])->withInput();
        }
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
        $kategori_wisata = KategoriWisata::findOrFail($id);

        return view('kategori_wisata.edit', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'kategori_wisata',
            'page' => 'Edit Kategori Wisata',
            'kategori_wisata' => $kategori_wisata,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $kategori_wisata = KategoriWisata::findOrFail($id);

            // Cek apakah paket dengan nama yang sama sudah ada
            $existingPaket = KategoriWisata::where('kategori_wisata', $request->kategori_wisata)
            ->where('id', '!=', $id)
            ->first();

            if ($existingPaket) {
                return redirect()->route('kelola_kategori_wisata.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Kategori wisata ini sudah terdaftar.',
                    'kategori_wisata' => $request->kategori_wisata,
                ])->withInput();
            }

            DB::beginTransaction();

            // Simpan data ke database
            $kategori_wisata->update([
                'kategori_wisata' => $request->kategori_wisata,
            ]);

            DB::commit();

            return redirect()->route('kelola_kategori_wisata.index')->with('pesan', 'Kategori Wisata ' . $request->kategori_wisata . ' berhasil diperbarui.');
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_kategori_wisata.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Kategori wisata ini sudah terdaftar.',
                    'kategori_wisata' => $request->kategori_wisata,
                ])->withInput();
            }

            return redirect()->route('kelola_kategori_wisata.edit', $id)->with([
                'status' => 'error',
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori_wisata = KategoriWisata::findOrFail($id);

        // Hapus paketWisata
        $kategori_wisata->delete();

        return redirect()->route('kelola_kategori_wisata.index')->with('pesan', 'Kategori Wisata Ini berhasil dihapus.');
    }
}
