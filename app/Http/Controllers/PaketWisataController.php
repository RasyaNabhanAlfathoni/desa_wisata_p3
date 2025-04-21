<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaketWisata;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class PaketWisataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paketWisata = PaketWisata::all();

        // Ambil jumlah data per halaman
        $perPage = $request->input('per_page', 5); // Default 5 jika tidak dipilih
        // $level = $request->input('level', ''); // Filter berdasarkan level

        // Query untuk mengambil data pengguna dengan filter level
        $query = PaketWisata::query();

        // if (!empty($level)) {
        //     $query->where('level', $level);
        // }

        // Pagination dengan append untuk mempertahankan filter saat navigasi halaman
        $paket_wisatas = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            // 'level' => $level
        ]);

        return view('paket_wisata.index', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'paket_wisata',
            'page' => 'Paket Wisata',
            'paket_wisatas' => $paket_wisatas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('paket_wisata.create', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'paket_wisata',
            'page' => 'Create Paket Wisata',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        try {
            // Cek apakah paket dengan nama yang sama sudah ada
            $existingPaket = PaketWisata::where('nama_paket', $request->nama_paket)->first();

            if ($existingPaket) {
                return redirect()->route('kelola_paket_wisata.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Paket wisata ini sudah terdaftar.',
                    'nama_paket' => $request->nama_paket,
                ])->withInput();
            }

            DB::beginTransaction();

            // Menyimpan foto jika ada
            $fotoPaths = [];
            for ($i = 1; $i <= 5; $i++) {
                $fotoField = "foto$i";
                if ($request->hasFile($fotoField)) {
                    $fotoPaths[$fotoField] = $request->file($fotoField)->store('PaketWisata');
                } else {
                    $fotoPaths[$fotoField] = null;
                }
            }

            // Simpan data ke database
            PaketWisata::create([
                'nama_paket' => $request->nama_paket,
                'deskripsi' => $request->deskripsi,
                'fasilitas' => $request->fasilitas,
                'harga_per_pack' => $request->harga_per_pack,
                'durasi_hari' => $request->durasi_hari,
                'kuota_peserta' => $request->kuota_peserta,
                'nilai_diskon' => $request->nilai_diskon,
                'peserta_diskon' => $request->peserta_diskon,
                'foto1' => $fotoPaths['foto1'],
                'foto2' => $fotoPaths['foto2'],
                'foto3' => $fotoPaths['foto3'],
                'foto4' => $fotoPaths['foto4'],
                'foto5' => $fotoPaths['foto5'],
            ]);

            $errorMessages = [];

            // Validasi ukuran file foto (maksimum 3MB)
            for ($i = 1; $i <= 5; $i++) {
                $fotoField = "foto$i";
                if ($request->hasFile($fotoField)) {
                    if ($request->file($fotoField)->getSize() > 3 * 1024 * 1024) { // 5MB dalam byte
                        $errorMessages[] = "Ukuran $fotoField melebihi 3MB!";
                    }
                }
            }

            DB::commit();

            // Jika ada error pada foto, kembalikan pesan error
            if (!empty($errorMessages)) {
                return redirect()->route('kelola_paket_wisata.create')->with([
                    'status' => 'error',
                    'error' => implode("<br>", $errorMessages),
                ])->withInput();
            }

            return redirect()->route('kelola_paket_wisata.index')->with('pesan', 'Paket Wisata ' . $request->nama_paket . ' berhasil ditambahkan.');
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_paket_wisata.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Paket wisata ini sudah terdaftar.',
                    'nama_paket' => $request->nama_paket,
                ])->withInput();
            }

            return redirect()->route('kelola_paket_wisata.create')->with([
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
        $paket_wisata = PaketWisata::findOrFail($id);

        return view('paket_wisata.edit', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'paket_wisata',
            'page' => 'Edit Paket Wisata',
            'paket_wisata' => $paket_wisata,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $paket_wisata = PaketWisata::findOrFail($id);

            // Cek apakah paket dengan nama yang sama sudah ada
            $existingPaket = PaketWisata::where('nama_paket', $request->nama_paket)
            ->where('id', '!=', $id)
            ->first();

            if ($existingPaket) {
                return redirect()->route('kelola_paket_wisata.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Paket wisata ini sudah terdaftar.',
                    'nama_paket' => $request->nama_paket,
                ])->withInput();
            }

            DB::beginTransaction();

            // Update foto jika ada yang baru diunggah
            $fotoPaths = [];
            for ($i = 1; $i <= 5; $i++) {
                $fotoField = "foto$i";
                if ($request->hasFile($fotoField)) {
                    // Hapus foto lama jika ada
                    if ($paket_wisata->$fotoField) {
                        Storage::delete($paket_wisata->$fotoField);
                    }
                    $fotoPaths[$fotoField] = $request->file($fotoField)->store('ObyekWisata');
                } else {
                    $fotoPaths[$fotoField] = $paket_wisata->$fotoField;
                }
            }

            // Simpan data ke database
            $paket_wisata->update([
                'nama_paket' => $request->nama_paket,
                'deskripsi' => $request->deskripsi,
                'fasilitas' => $request->fasilitas,
                'harga_per_pack' => $request->harga_per_pack,
                'durasi_hari' => $request->durasi_hari,
                'kuota_peserta' => $request->kuota_peserta,
                'nilai_diskon' => $request->nilai_diskon,
                'peserta_diskon' => $request->peserta_diskon,
                'foto1' => $fotoPaths['foto1'],
                'foto2' => $fotoPaths['foto2'],
                'foto3' => $fotoPaths['foto3'],
                'foto4' => $fotoPaths['foto4'],
                'foto5' => $fotoPaths['foto5'],
            ]);

            $errorMessages = [];

            // Validasi ukuran file foto (maksimum 3MB)
            for ($i = 1; $i <= 5; $i++) {
                $fotoField = "foto$i";
                if ($request->hasFile($fotoField)) {
                    if ($request->file($fotoField)->getSize() > 3 * 1024 * 1024) { // 5MB dalam byte
                        $errorMessages[] = "Ukuran $fotoField melebihi 3MB!";
                    }
                }
            }

            DB::commit();

            // Jika ada error pada foto, kembalikan pesan error
            if (!empty($errorMessages)) {
                return redirect()->route('kelola_paket_wisata.edit', $id)->with([
                    'status' => 'error',
                    'error' => implode("<br>", $errorMessages),
                ])->withInput();
            }

            return redirect()->route('kelola_paket_wisata.index')->with('pesan', 'Paket Wisata ' . $request->nama_paket . ' berhasil diperbarui.');
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_paket_wisata.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Paket wisata ini sudah terdaftar.',
                    'nama_paket' => $request->nama_paket,
                ])->withInput();
            }

            return redirect()->route('kelola_paket_wisata.edit', $id)->with([
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
        $paket_wisata = PaketWisata::findOrFail($id);

        // Hapus semua foto yang terkait
        for ($i = 1; $i <= 5; $i++) {
            $fotoField = "foto$i";
            if ($paket_wisata->$fotoField) {
                Storage::delete($paket_wisata->$fotoField);
            }
        }

        // Hapus paketWisata
        $paket_wisata->delete();

        return redirect()->route('kelola_paket_wisata.index')->with('pesan', 'Paket Wisata Ini berhasil dihapus.');
    }
}
