<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $berita = Berita::with('kategori')->get();

        // Ambil jumlah data per halaman
        $perPage = $request->input('per_page', 5); // Default 5 jika tidak dipilih
        $kategori = $request->input('kategori', ''); // Filter berdasarkan kategori

        // Query untuk mengambil data pengguna dengan filter level
        $query = Berita::with('kategori');

        if (!empty($kategori)) {
            $query->where('id_kategori_berita', $kategori);
        }

        // Pagination dengan append untuk mempertahankan filter saat navigasi halaman
        $beritas = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            'kategori' => $kategori
        ]);

        // Ambil semua kategori wisata untuk dropdown filter
        $kategori_beritas = KategoriBerita::all();

        return view('berita.index', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'berita',
            'page' => 'Berita',
            'kategori_beritas' => $kategori_beritas, // Kirim daftar kategori ke view
            'selected_kategori' => $kategori, // Kirim kategori yang sedang dipilih
            'beritas' => $beritas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // Ambil semua kategori wisata untuk dropdown filter
         $kategori_beritas = KategoriBerita::all();

         return view('berita.create', [
             'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
             'menu' => 'berita',
             'page' => 'Create Berita',
             'kategori_beritas' => $kategori_beritas, // Kirim daftar kategori ke view
         ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Cek apakah wisata dengan nama yang sama sudah ada
            $existingBerita = Berita::where('judul', $request->judul)
            ->where('id_kategori_berita', $request->id_kategori_berita)
            ->first();

            if ($existingBerita) {
                return redirect()->route('kelola_berita.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Berita ini sudah terdaftar.',
                    'judul' => $request->judul,
                ])->withInput();

            } else {
                DB::beginTransaction();

                // Upload foto jika ada
                $fotoPath = null;
                if ($request->hasFile('foto')) {
                    $fotoPath = $request->file('foto')->store('Berita');
                }

                // Simpan data berita ke database
                Berita::create([
                    'judul' => $request->judul,
                    'berita' => $request->berita,
                    'tgl_post' => $request->tgl_post,
                    'id_kategori_berita' => $request->id_kategori_berita,
                    'foto' => $fotoPath, // Menyimpan path foto ke database
                ]);

                $errorMessages = [];

                // Validasi ukuran file foto
                if ($request->hasFile($fotoPath)) {
                    if ($request->file($fotoPath)->getSize() > 3 * 1024 * 1024) { // 3MB dalam byte
                        $errorMessages[] = "Ukuran $fotoPath melebihi 3MB!";
                    }
                }

                DB::commit();

                // Jika ada error, kembalikan dengan pesan
                if (!empty($errorMessages)) {
                    return redirect()->route('kelola_berita.create')->with([
                        'status' => 'error',
                        'error' => implode("<br>", $errorMessages), // Gabungkan error dalam satu pesan
                    ])->withInput();
                }

                return redirect()->route('kelola_berita.index')->with('pesan', 'Berita ' . $request->judul . ' berhasil ditambahkan.');
            }
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_berita.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Berita ini sudah terdaftar.',
                    'judul' => $request->judul,
                ])->withInput();
           }

            return redirect()->route('kelola_berita.create')->with([
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
        // Ambil semua kategori wisata untuk dropdown filter
        $kategori_beritas = KategoriBerita::all();
        $berita = Berita::findOrFail($id);

        return view('berita.edit', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'berita',
            'page' => 'Edit Berita',
            'berita' => $berita,
            'kategori_beritas' => $kategori_beritas, // Kirim daftar kategori ke view
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $berita = Berita::findOrFail($id);

            // Cek apakah wisata dengan nama yang sama sudah ada
            $existingBerita = Berita::where('judul', $request->judul)
            ->where('id_kategori_berita', $request->id_kategori_berita)
            ->where('id', '!=', $id)
            ->first();

            if ($existingBerita) {
                return redirect()->route('kelola_berita.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Berita ini sudah terdaftar.',
                    'judul' => $request->judul,
                ])->withInput();

            } else {
                DB::beginTransaction();

                // Simpan data berita ke database
                $berita->update([
                    'judul' => $request->judul,
                    'berita' => $request->berita,
                    'tgl_post' => $request->tgl_post,
                    'id_kategori_berita' => $request->id_kategori_berita,
                ]);

                // Update foto jika ada perubahan
                if ($request->hasFile('foto')) {
                    // Hapus foto lama jika ada
                    if ($berita->foto) {
                        Storage::delete($berita->foto);
                    }

                    // Simpan foto baru
                    $fotoPath = $request->file('foto')->store('Berita');
                    $berita->update(['foto' => $fotoPath]);
                }

                $errorMessages = [];

                // Validasi ukuran file foto
                if ($request->hasFile($fotoPath)) {
                    if ($request->file($fotoPath)->getSize() > 3 * 1024 * 1024) { // 3MB dalam byte
                        $errorMessages[] = "Ukuran $fotoPath melebihi 3MB!";
                    }
                }

                // Jika ada error, kembalikan dengan pesan
                if (!empty($errorMessages)) {
                    return redirect()->route('kelola_berita.edit', $id)->with([
                        'status' => 'error',
                        'error' => implode("<br>", $errorMessages), // Gabungkan error dalam satu pesan
                    ])->withInput();
                }

                DB::commit();

                return redirect()->route('kelola_berita.index')->with('pesan', 'Berita ' . $request->judul . ' berhasil diperbarui.');
            }
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_berita.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Berita ini sudah terdaftar.',
                    'judul' => $request->judul,
                ])->withInput();
           }

            return redirect()->route('kelola_berita.edit', $id)->with([
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
        $berita = Berita::findOrFail($id);

        // Hapus foto jika ada
        if ($berita->foto) {
            Storage::delete($berita->foto);
        }

        // Hapus berita
        $berita->delete();

        return redirect()->route('kelola_berita.index')->with('pesan', 'Berita Ini berhasil dihapus.');
    }
}
