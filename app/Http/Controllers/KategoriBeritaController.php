<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
class KategoriBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori_berita = KategoriBerita::all();

        // Ambil jumlah data per halaman
        $perPage = $request->input('per_page', 5); // Default 5 jika tidak dipilih
        // $level = $request->input('level', ''); // Filter berdasarkan level

        // Query untuk mengambil data pengguna dengan filter level
        $query = KategoriBerita::query();

        // if (!empty($level)) {
        //     $query->where('level', $level);
        // }

        // Pagination dengan append untuk mempertahankan filter saat navigasi halaman
        $kategori_beritas = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            // 'level' => $level
        ]);

        return view('kategori_berita.index', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'kategori_berita',
            'page' => 'Kategori Berita',
            'kategori_beritas' => $kategori_beritas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori_berita.create', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'kategori_berita',
            'page' => 'Create Kategori Berita',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Cek apakah paket dengan nama yang sama sudah ada
            $existingKategoriBerita = KategoriBerita::where('kategori_berita', $request->kategori_berita)->first();

            if ($existingKategoriBerita) {
                return redirect()->route('kelola_kategori_berita.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Kategori Berita ini sudah terdaftar.',
                    'kategori_berita' => $request->kategori_berita,
                ])->withInput();
            }

            DB::beginTransaction();

            // Simpan data ke database
            KategoriBerita::create([
                'kategori_berita' => $request->kategori_berita,
            ]);

            DB::commit();

            return redirect()->route('kelola_kategori_berita.index')->with('pesan', 'Kategori Berita ' . $request->kategori_berita . ' berhasil ditambahkan.');
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_kategori_berita.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Kategori Berita ini sudah terdaftar.',
                    'kategori_berita' => $request->kategori_berita,
                ])->withInput();
            }

            return redirect()->route('kelola_kategori_berita.create')->with([
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
        $kategori_berita = KategoriBerita::findOrFail($id);

        return view('kategori_berita.edit', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'kategori_berita',
            'page' => 'Edit Kategori Berita',
            'kategori_berita' => $kategori_berita,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $kategori_berita = KategoriBerita::findOrFail($id);

            // Cek apakah paket dengan nama yang sama sudah ada
            $existingKategoriBerita = KategoriBerita::where('kategori_berita', $request->kategori_berita)
            ->where('id', '!=', $id)
            ->first();

            if ($existingKategoriBerita) {
                return redirect()->route('kelola_kategori_berita.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Kategori Berita ini sudah terdaftar.',
                    'kategori_berita' => $request->kategori_berita,
                ])->withInput();
            }

            DB::beginTransaction();

            // Simpan data ke database
            $kategori_berita->update([
                'kategori_berita' => $request->kategori_berita,
            ]);

            DB::commit();

            return redirect()->route('kelola_kategori_berita.index')->with('pesan', 'Kategori Berita ' . $request->kategori_berita . ' berhasil diperbarui.');
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_kategori_berita.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Kategori Berita ini sudah terdaftar.',
                    'kategori_berita' => $request->kategori_berita,
                ])->withInput();
            }

            return redirect()->route('kelola_kategori_berita.edit', $id)->with([
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
        $kategori_berita = KategoriBerita::findOrFail($id);

        // Hapus paketberita
        $kategori_berita->delete();

        return redirect()->route('kelola_kategori_berita.index')->with('pesan', 'Kategori Ini Berita berhasil dihapus.');
    }
}
