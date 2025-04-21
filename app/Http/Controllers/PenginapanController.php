<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penginapan;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class PenginapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $penginapan = Penginapan::all();

        // Ambil jumlah data per halaman
        $perPage = $request->input('per_page', 5); // Default 5 jika tidak dipilih
        // $level = $request->input('level', ''); // Filter berdasarkan level

        // Query untuk mengambil data pengguna dengan filter level
        $query = Penginapan::query();

        // if (!empty($level)) {
        //     $query->where('level', $level);
        // }

        // Pagination dengan append untuk mempertahankan filter saat navigasi halaman
        $penginapans = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            // 'level' => $level
        ]);

        return view('penginapan.index', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'penginapan',
            'page' => 'Penginapan',
            'penginapans' => $penginapans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penginapan.create', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'penginapan',
            'page' => 'Create Penginapan',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Cek apakah paket dengan nama yang sama sudah ada
            $existingPenginapan = Penginapan::where('nama_penginapan', $request->nama_penginapan)->first();

            if ($existingPenginapan) {
                return redirect()->route('kelola_penginapan.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Penginapan ini sudah terdaftar.',
                    'nama_penginapan' => $request->nama_penginapan,
                ])->withInput();
            }

            DB::beginTransaction();

            // Menyimpan foto jika ada
            $fotoPaths = [];
            for ($i = 1; $i <= 5; $i++) {
                $fotoField = "foto$i";
                if ($request->hasFile($fotoField)) {
                    $fotoPaths[$fotoField] = $request->file($fotoField)->store('Penginapan');
                } else {
                    $fotoPaths[$fotoField] = null;
                }
            }

            // Simpan data ke database
            Penginapan::create([
                'nama_penginapan' => $request->nama_penginapan,
                'deskripsi' => $request->deskripsi,
                'fasilitas' => $request->fasilitas,
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
                return redirect()->route('kelola_penginapan.create')->with([
                    'status' => 'error',
                    'error' => implode("<br>", $errorMessages),
                ])->withInput();
            }

            return redirect()->route('kelola_penginapan.index')->with('pesan', 'Penginapan ' . $request->nama_penginapan . ' berhasil diubah.');
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_penginapan.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Penginapan ini sudah terdaftar.',
                    'nama_penginapan' => $request->nama_penginapan,
                ])->withInput();
            }

            return redirect()->route('kelola_penginapan.create')->with([
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
        $penginapan = Penginapan::findOrFail($id);

        return view('penginapan.edit', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'menu' => 'penginapan',
            'page' => 'Edit Penginapan',
            'penginapan' => $penginapan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $penginapan = Penginapan::findOrFail($id);

            // Cek apakah paket dengan nama yang sama sudah ada
            $existingPenginapan = Penginapan::where('nama_penginapan', $request->nama_penginapan)
            ->where('id', '!=', $id)
            ->first();

            if ($existingPenginapan) {
                return redirect()->route('kelola_penginapan.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Penginapan ini sudah terdaftar.',
                    'nama_penginapan' => $request->nama_penginapan,
                ])->withInput();
            }

            DB::beginTransaction();

            // Update foto jika ada yang baru diunggah
            $fotoPaths = [];
            for ($i = 1; $i <= 5; $i++) {
                $fotoField = "foto$i";
                if ($request->hasFile($fotoField)) {
                    // Hapus foto lama jika ada
                    if ($penginapan->$fotoField) {
                        Storage::delete($penginapan->$fotoField);
                    }
                    $fotoPaths[$fotoField] = $request->file($fotoField)->store('ObyekWisata');
                } else {
                    $fotoPaths[$fotoField] = $penginapan->$fotoField;
                }
            }

            // Simpan data ke database
            $penginapan->update([
                'nama_penginapan' => $request->nama_penginapan,
                'deskripsi' => $request->deskripsi,
                'fasilitas' => $request->fasilitas,
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
                return redirect()->route('kelola_penginapan.edit', $id)->with([
                    'status' => 'error',
                    'error' => implode("<br>", $errorMessages),
                ])->withInput();
            }

            return redirect()->route('kelola_penginapan.index')->with('pesan', 'Penginapan ' . $request->nama_penginapan . ' berhasil diperbarui.');
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_penginapan.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Penginapan ini sudah terdaftar.',
                    'nama_penginapan' => $request->nama_penginapan,
                ])->withInput();
            }

            return redirect()->route('kelola_penginapan.create')->with([
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
        $penginapan = Penginapan::findOrFail($id);

        // Hapus semua foto yang terkait
        for ($i = 1; $i <= 5; $i++) {
            $fotoField = "foto$i";
            if ($penginapan->$fotoField) {
                Storage::delete($penginapan->$fotoField);
            }
        }

        // Hapus paketWisata
        $penginapan->delete();

        return redirect()->route('kelola_penginapan.index')->with('pesan', 'Data Penginapan ini berhasil dihapus.');
    }
}
