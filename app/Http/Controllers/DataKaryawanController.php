<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KaryawanWithUserExport;
use Carbon\Carbon;

class DataKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $karyawan = Karyawan::with('user')->get();

        // Ambil jumlah data per halaman
        $perPage = $request->input('per_page', 5); // Default 5 jika tidak dipilih
        $level = $request->input('level', ''); // Filter berdasarkan level

        // Query untuk mengambil data pengguna dengan filter level
        $query = Karyawan::with('user');

        if (!empty($level)) {
            $query->whereHas('user', function ($q) use ($level) {
                $q->where('level', $level);
            });
        }

        // Pagination dengan append untuk mempertahankan filter saat navigasi halaman
        $karyawans = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            'level' => $level
        ]);

        return view('data-karyawan.index', [
            'title' => 'Admin',
            'menu' => 'Data_karyawan',
            'page' => 'Data Karyawan',
            'karyawans' => $karyawans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data-karyawan.create', [
            'title' => 'Admin',
            'menu' => 'Data_karyawan',
            'page' => 'Create Data Karyawan',
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Cek apakah karyawan dengan email yang sama sudah ada
            $existingKaryawan = DB::table('karyawan')
            ->join('users', 'users.id', '=', 'karyawan.id_user')
            ->where('karyawan.nama_karyawan', $request->nama_karyawan)
            ->where('users.email', $request->email)
            ->where('karyawan.no_hp', $request->no_hp)
            ->first();

            if ($existingKaryawan) {
                return redirect()->route('kelola_data_karyawan.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Karyawan dengan email dan jabatan ini sudah terdaftar.',
                    'nama_karyawan' => $request->nama_karyawan,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                ]);
            } else {
                DB::beginTransaction(); // Mulai transaksi database

                // Mapping dari jabatan ke level
                $levelMapping = [
                    'administrasi' => 'admin',
                    'pemilik' => 'pemilik',
                    'bendahara' => 'bendahara'
                ];

                // Tentukan level berdasarkan jabatan
                $level = $levelMapping[$request->jabatan] ?? 'pelanggan';

                // Simpan user
                $user = User::create([
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'level' => $level, // Gunakan hasil mapping level
                    'aktif' => 1, // Set default aktif
                ]);

                // Simpan data karyawan
                $karyawan = Karyawan::create([
                    'nama_karyawan' => $request->nama_karyawan,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'jabatan' => $request->jabatan,
                    'id_user' => $user->id, // Hubungkan dengan tabel users
                ]);

                DB::commit(); // Simpan perubahan ke database

                return redirect()->route('kelola_data_karyawan.index')->with('pesan', 'Karyawan ' . $request->nama_karyawan . ' berhasil ditambahkan.');
            }
        } catch (QueryException $e) {
            DB::rollBack(); // Batalkan transaksi jika ada error

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_data_karyawan.create')->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Karyawan dengan email dan jabatan ini sudah terdaftar.',
                    'nama_karyawan' => $request->nama_karyawan,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                ])->withInput();
            }

            return redirect()->route('kelola_data_karyawan.create')->with([
                'status' => 'error',
                'error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);

        return view('data-karyawan.show', [
            'title' => 'Admin',
            'menu' => 'Admin',
            'page' => 'Detail Karyawan',
            'karyawan' => $karyawan,
        ]);
    }

        /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);

        return view('data-karyawan.edit', [
            'title' => 'Admin',
            'menu' => 'Data_karyawan',
            'page' => 'Edit Data Karyawan',
            'karyawan' => $karyawan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cek apakah ada data karyawan dengan email dan nomor HP yang sama selain data yang sedang diupdate
            $existingKaryawan = DB::table('karyawan')
                ->join('users', 'users.id', '=', 'karyawan.id_user')
                ->where('karyawan.nama_karyawan', $request->nama_karyawan)
                ->where('users.email', $request->email)
                ->where('karyawan.no_hp', $request->no_hp)
                ->where('karyawan.id', '!=', $id) // Pastikan tidak mengecek dirinya sendiri
                ->first();

            if ($existingKaryawan) {
                return redirect()->route('kelola_data_karyawan.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Karyawan dengan email dan jabatan ini sudah terdaftar.',
                    'nama_karyawan' => $request->nama_karyawan,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                ])->withInput();
            } else{

            DB::beginTransaction();

            $karyawan = Karyawan::findOrFail($id);
            $user = User::findOrFail($karyawan->id_user);

            // Update data user
            $user->update([
                'email' => $request->email,
                'aktif' => $request->aktif,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            // Update data karyawan
            $karyawan->update([
                'nama_karyawan' => $request->nama_karyawan,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'jabatan' => $request->jabatan,
            ]);

            DB::commit();

            return redirect()->route('kelola_data_karyawan.index')->with('pesan', 'Karyawan ' . $request->nama_karyawan . ' berhasil diperbarui.');
         }
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { // Kode error untuk Unique Constraint Violation
                return redirect()->route('kelola_data_karyawan.edit', $id)->with([
                    'status' => 'Duplicate!',
                    'pesan' => 'Karyawan dengan email dan jabatan ini sudah terdaftar.',
                    'nama_karyawan' => $request->nama_karyawan,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                ])->withInput();
            }

            return redirect()->route('kelola_data_karyawan.edit', $id)->with([
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
        $karyawan = Karyawan::findOrFail($id);
        $user = User::findOrFail($karyawan->id_user);

        $karyawan->delete();
        $user->delete();

        return redirect()->route('kelola_data_karyawan.index')->with('pesan', 'Karyawan berhasil dihapus.');
    }


}
