<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class DataPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pelanggan = Pelanggan::with('user')->get();

        // Ambil jumlah data per halaman
        $perPage = $request->input('per_page', 5); // Default 5 jika tidak dipilih
        // $level = $request->input('level', ''); // Filter berdasarkan level

        // Query untuk mengambil data pengguna dengan filter level
        $query = Pelanggan::with('user');

        // if (!empty($level)) {
        //     $query->where('level', $level);
        // }

        // Pagination dengan append untuk mempertahankan filter saat navigasi halaman
        $pelanggans = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            // 'level' => $level
        ]);

        return view('data-pelanggan.index', [
            'title' => ucfirst(Auth::user()->level),
            'menu' => 'data_pelanggan',
            'page' => 'Data Pelanggan',
            'pelanggans' => $pelanggans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
        public function create()
        {
            return view('data-pelanggan.create', [
                'title' => ucfirst(Auth::user()->level),
                'menu' => 'data_pelanggan',
                'page' => 'Create Data Pelanggan',
            ]);
        }

        public function store(Request $request)
        {
            try {
                $existingPelanggan = DB::table('pelanggan')
                    ->join('users', 'users.id', '=', 'pelanggan.id_user')
                    ->where('pelanggan.nama_lengkap', $request->nama_lengkap)
                    ->where('users.email', $request->email)
                    ->where('pelanggan.no_hp', $request->no_hp)
                    ->first();

                if ($existingPelanggan) {
                    return redirect()->route('kelola_data_pelanggan.create')->with([
                        'status' => 'Duplicate!',
                        'pesan' => 'Pelanggan dengan email ini sudah terdaftar.',
                        'nama_lengkap' => $request->nama_lengkap,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp,
                    ])->withInput();
                } else {
                    DB::beginTransaction();

                    // Upload foto jika ada
                    $fotoPath = null;
                    if ($request->hasFile('foto')) {
                        $fotoPath = $request->file('foto')->store('Pelanggan');
                    }

                    $user = User::create([
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'level' => 'pelanggan',
                        'aktif' => 1,
                    ]);

                    Pelanggan::create([
                        'nama_lengkap' => $request->nama_lengkap,
                        'alamat' => $request->alamat,
                        'no_hp' => $request->no_hp,
                        'foto' => $fotoPath, // Menyimpan path foto ke database
                        'id_user' => $user->id,
                    ]);

                    $errorMessages = [];

                    // Validasi ukuran file foto
                    if ($request->hasFile($fotoPath)) {
                        if ($request->file($fotoPath)->getSize() > 3 * 1024 * 1024) { // 3MB dalam byte
                            $errorMessages[] = "Ukuran $fotoPath melebihi 3MB!";
                        }
                    }

                    // Jika ada error, kembalikan dengan pesan
                    if (!empty($errorMessages)) {
                        return redirect()->route('kelola_berita.create')->with([
                            'status' => 'error',
                            'error' => implode("<br>", $errorMessages), // Gabungkan error dalam satu pesan
                        ])->withInput();
                    }

                    DB::commit();

                    return redirect()->route('kelola_data_pelanggan.index')->with('pesan', 'Pelanggan ' . $request->nama_lengkap . ' berhasil ditambahkan.');
                }
            } catch (QueryException $e) {
                DB::rollBack();

                if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                     return redirect()->route('kelola_data_pelanggan.create')->with([
                        'status' => 'Duplicate!',
                        'pesan' => 'Pelanggan dengan email ini sudah terdaftar.',
                        'nama_lengkap' => $request->nama_lengkap,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp,
                    ])->withInput();
                }

                return redirect()->route('kelola_data_pelanggan.create')->with([
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
        $pelanggan = Pelanggan::with('user')->findOrFail($id);
        $jumlahReservasi = $pelanggan->reservasi->count();

        return view('data-pelanggan.show', [
            'title' => ucfirst(Auth::user()->level),
            'menu' => 'data_pelanggan',
            'page' => 'Detail Pelanggan',
            'pelanggan' => $pelanggan,
            'jumlahReservasi' => $jumlahReservasi,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pelanggan = Pelanggan::with('user')->findOrFail($id);

        return view('data-pelanggan.edit', [
            'title' => ucfirst(Auth::user()->level),
            'menu' => 'data_pelanggan',
            'page' => 'Edit Data Pelanggan',
            'pelanggan' => $pelanggan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cek apakah ada pelanggan lain dengan data yang sama
            $existingPelanggan = DB::table('pelanggan')
                ->join('users', 'users.id', '=', 'pelanggan.id_user')
                // ->where('pelanggan.nama_lengkap', $request->nama_lengkap)
                ->where('users.email', $request->email)
                // ->where('pelanggan.no_hp', $request->no_hp)
                ->where('pelanggan.id', '!=', $id) // Pastikan bukan dirinya sendiri
                ->first();

            if ($existingPelanggan) {
                return redirect()->route('kelola_data_pelanggan.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Pelanggan dengan email dan nomor HP ini sudah terdaftar.',
                    'nama_lengkap' => $request->nama_lengkap,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                ])->withInput();
            } else {

            DB::beginTransaction();

            $pelanggan = Pelanggan::findOrFail($id);
            $user = User::findOrFail($pelanggan->id_user);

            // Update data user
            $user->update([
                'email' => $request->email,
                'aktif' => $request->aktif,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            // Update data pelanggan
            $pelanggan->update([
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);

            // Update foto jika ada perubahan
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($pelanggan->foto) {
                    Storage::delete($pelanggan->foto);
                }

                // Simpan foto baru
                $fotoPath = $request->file('foto')->store('Pelanggan');
                $pelanggan->update(['foto' => $fotoPath]);
            }

            $errorMessages = [];

            // Cek apakah request memiliki file foto
            if ($request->hasFile('foto')) {
                if ($request->file('foto')->getSize() > 3 * 1024 * 1024) { // 3MB dalam byte
                    $errorMessages[] = "Ukuran foto melebihi 3MB!";
                }
            }

            // Jika ada error, kembalikan dengan pesan
            if (!empty($errorMessages)) {
                return redirect()->route('kelola_data_pelanggan.edit', $pelanggan->id)->with([
                    'status' => 'error',
                    'error' => implode("<br>", $errorMessages), // Gabungkan error dalam satu pesan
                ])->withInput();
            }

            DB::commit();

            return redirect()->route('kelola_data_pelanggan.index')->with('pesan', 'Pelanggan ' . $request->nama_lengkap . ' berhasil diperbarui.');
         }
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_data_pelanggan.edit', $id)->with([
                   'status' => 'Duplicate!',
                   'pesan' => 'Pelanggan dengan email dan nomor HP ini sudah terdaftar.',
                   'nama_lengkap' => $request->nama_lengkap,
                   'email' => $request->email,
                   'no_hp' => $request->no_hp,
               ])->withInput();
           }

            return redirect()->route('kelola_data_pelanggan.edit', $id)->with([
                'status' => 'error',
                'error' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Hapus foto jika ada
        if ($pelanggan->foto) {
            Storage::delete($pelanggan->foto);
        }

        // Hapus user terkait
        User::findOrFail($pelanggan->id_user)->delete();

        // Hapus pelanggan
        $pelanggan->delete();

        return redirect()->route('kelola_data_pelanggan.index')->with('pesan', 'Pelanggan berhasil dihapus.');
    }

}
