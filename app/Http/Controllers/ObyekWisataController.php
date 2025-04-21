<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ObyekWisata;
use App\Models\KategoriWisata;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
class ObyekWisataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        // Hanya admin dan pemilik yang bisa mengakses controller ini
        $this->middleware('level:admin,pemilik');
    }

    /**
     * Tampilkan daftar obyek wisata.
     */
    public function index(Request $request)
    {
        // $obyekWisata = ObyekWisata::all();
        $obyek_wisata = ObyekWisata::with('kategori')->get();

        // Ambil jumlah data per halaman
        $perPage = $request->input('per_page', 5); // Default 5 jika tidak dipilih
        $kategori = $request->input('kategori', ''); // Filter berdasarkan kategori

        // Query untuk mengambil data pengguna dengan filter level
        $query = ObyekWisata::with('kategori');

        if (!empty($kategori)) {
            $query->where('id_kategori_wisata', $kategori);
        }

        // Pagination dengan append untuk mempertahankan filter saat navigasi halaman
        $obyek_wisatas = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            'kategori' => $kategori
        ]);

        // Ambil semua kategori wisata untuk dropdown filter
        $kategori_wisatas = KategoriWisata::all();

        return view('obyek_wisata.index', [
            'title' => ucfirst(Auth::user()->level),
            'menu' => 'obyek_wisata',
            'obyek_wisatas' => $obyek_wisatas,
            'kategori_wisatas' => $kategori_wisatas, // Kirim daftar kategori ke view
            'selected_kategori' => $kategori, // Kirim kategori yang sedang dipilih
            'page' => 'Obyek Wisata',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua kategori wisata untuk dropdown filter
        $kategori_wisatas = KategoriWisata::all();

        return view('obyek_wisata.create', [
            'title' => ucfirst(Auth::user()->level),
            'menu' => 'obyek_wisata',
            'page' => 'Create Obyek Wisata',
            'kategori_wisatas' => $kategori_wisatas, // Kirim daftar kategori ke view
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
        {
            try {
                // Cek apakah wisata dengan nama yang sama sudah ada
                $existingWisata = ObyekWisata::where('nama_wisata', $request->nama_wisata)
                ->where('id_kategori_wisata', $request->id_kategori_wisata)
                ->first();

                if ($existingWisata) {
                    return redirect()->route('kelola_obyek_wisata.create')->with([
                        'status' => 'Duplicate!',
                        'pesan' => 'Obyek wisata ini sudah terdaftar.',
                        'nama_wisata' => $request->nama_wisata,
                    ])->withInput();

                } else {
                    DB::beginTransaction();

                    // Menyimpan foto jika ada
                    $fotoPaths = [];
                    for ($i = 1; $i <= 5; $i++) {
                        $fotoField = "foto$i";
                        if ($request->hasFile($fotoField)) {
                            $fotoPaths[$fotoField] = $request->file($fotoField)->store('ObyekWisata');
                        } else {
                            $fotoPaths[$fotoField] = null;
                        }
                    }

                    // Simpan data wisata ke database
                    ObyekWisata::create([
                        'nama_wisata' => $request->nama_wisata,
                        'deskripsi_wisata' => $request->deskripsi_wisata,
                        'id_kategori_wisata' => $request->id_kategori_wisata,
                        'fasilitas' => $request->fasilitas,
                        'foto1' => $fotoPaths['foto1'],
                        'foto2' => $fotoPaths['foto2'],
                        'foto3' => $fotoPaths['foto3'],
                        'foto4' => $fotoPaths['foto4'],
                        'foto5' => $fotoPaths['foto5'],
                    ]);

                    $errorMessages = [];

                    // Validasi ukuran file foto
                    for ($i = 1; $i <= 5; $i++) {
                        $fotoField = "foto$i";
                        if ($request->hasFile($fotoField)) {
                            if ($request->file($fotoField)->getSize() > 3 * 1024 * 1024) { // 5MB dalam byte
                                $errorMessages[] = "Ukuran $fotoField melebihi 3MB!";
                            }
                        }
                    }

                    DB::commit();

                    // Jika ada error, kembalikan dengan pesan
                    if (!empty($errorMessages)) {
                        return redirect()->route('kelola_obyek_wisata.create')->with([
                            'status' => 'error',
                            'error' => implode("<br>", $errorMessages), // Gabungkan error dalam satu pesan
                        ])->withInput();
                    }

                    return redirect()->route('kelola_obyek_wisata.index')->with('pesan', 'Obyek Wisata ' . $request->nama_wisata . ' berhasil ditambahkan.');
                }
            } catch (QueryException $e) {
                DB::rollBack();

                if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                    return redirect()->route('kelola_obyek_wisata.create')->with([
                        'status' => 'Duplicate!',
                        'pesan' => 'Obyek wisata ini sudah terdaftar.',
                        'nama_wisata' => $request->nama_wisata,
                    ])->withInput();
               }

                return redirect()->route('kelola_obyek_wisata.create')->with([
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
        $obyek_wisata = ObyekWisata::findOrFail($id);
        $kategori_wisatas = KategoriWisata::all();

        return view('obyek_wisata.edit', [
            'title' => ucfirst(Auth::user()->level),
            'menu' => 'obyek_wisata',
            'page' => 'Edit Obyek Wisata',
            'obyek_wisata' => $obyek_wisata,
            'kategori_wisatas' => $kategori_wisatas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $obyek_wisata = ObyekWisata::findOrFail($id);

            // Cek apakah wisata dengan nama yang sama sudah ada (kecuali dirinya sendiri)
            $existingWisata = ObyekWisata::where('nama_wisata', $request->nama_wisata)
                ->where('id_kategori_wisata', $request->id_kategori_wisata)
                ->where('id', '!=', $id)
                ->first();

            if ($existingWisata) {
                return redirect()->route('kelola_obyek_wisata.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Obyek wisata ini sudah terdaftar.',
                    'nama_wisata' => $request->nama_wisata,
                ])->withInput();
            } else {

            DB::beginTransaction();

            // Update foto jika ada yang baru diunggah
            $fotoPaths = [];
            for ($i = 1; $i <= 5; $i++) {
                $fotoField = "foto$i";
                if ($request->hasFile($fotoField)) {
                    // Hapus foto lama jika ada
                    if ($obyek_wisata->$fotoField) {
                        Storage::delete($obyek_wisata->$fotoField);
                    }
                    $fotoPaths[$fotoField] = $request->file($fotoField)->store('ObyekWisata');
                } else {
                    $fotoPaths[$fotoField] = $obyek_wisata->$fotoField;
                }
            }

            // Update data wisata ke database
            $obyek_wisata->update([
                'nama_wisata' => $request->nama_wisata,
                'deskripsi_wisata' => $request->deskripsi_wisata,
                'id_kategori_wisata' => $request->id_kategori_wisata,
                'fasilitas' => $request->fasilitas,
                'foto1' => $fotoPaths['foto1'],
                'foto2' => $fotoPaths['foto2'],
                'foto3' => $fotoPaths['foto3'],
                'foto4' => $fotoPaths['foto4'],
                'foto5' => $fotoPaths['foto5'],
            ]);

            $errorMessages = [];

            // Validasi ukuran file foto
            for ($i = 1; $i <= 5; $i++) {
                $fotoField = "foto$i";
                if ($request->hasFile($fotoField)) {
                    if ($request->file($fotoField)->getSize() > 3 * 1024 * 1024) { // 5MB dalam byte
                        $errorMessages[] = "Ukuran $fotoField melebihi 3MB!";
                    }
                }
            }

            DB::commit();

            // Jika ada error, kembalikan dengan pesan
            if (!empty($errorMessages)) {
                return redirect()->route('kelola_obyek_wisata.edit', $id)->with([
                       'status' => 'error',
                      'error' => implode("<br>", $errorMessages), // Gabungkan error dalam satu pesan
                ])->withInput();
             }

            return redirect()->route('kelola_obyek_wisata.index')->with('pesan', 'Obyek Wisata ' . $request->nama_wisata . ' berhasil diperbarui.');
            }
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_obyek_wisata.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Obyek wisata ini sudah terdaftar.',
                    'nama_wisata' => $request->nama_wisata,
                ])->withInput();
           }

            return redirect()->route('kelola_obyek_wisata.edit', $id)->with([
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
        $obyek_wisata = ObyekWisata::findOrFail($id);

        // Hapus semua foto yang terkait
        for ($i = 1; $i <= 5; $i++) {
            $fotoField = "foto$i";
            if ($obyek_wisata->$fotoField) {
                Storage::delete($obyek_wisata->$fotoField);
            }
        }

        // Hapus ObyekWisata
        $obyek_wisata->delete();

        return redirect()->route('kelola_obyek_wisata.index')->with('pesan', 'Obyek Wisata Ini berhasil dihapus.');
    }
}
