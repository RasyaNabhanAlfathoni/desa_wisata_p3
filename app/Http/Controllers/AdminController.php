<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\PaketWisata;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $user = User::paginate(5);

        // Hitung total Karyawan
        $karyawan = Karyawan::count();

        // Hitung total Pelanggan
        $pelanggan = Pelanggan::count();

        // Hitung total user aktif
        $user_aktif = User::where('aktif', '1')->count();

        $user_nonaktif = User::where('aktif', '!=', 1)->count();

        // Ambil jumlah data per halaman
        $perPage = $request->input('per_page', 5); // Default 5 jika tidak dipilih
        $level = $request->input('level', ''); // Filter berdasarkan level

        // Query untuk mengambil data pengguna dengan filter level
        $query = User::query();
        if (!empty($level)) {
            $query->where('level', $level);
        }

        // Pagination dengan append untuk mempertahankan filter saat navigasi halaman
        $users = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            'level' => $level
        ]);

        return view('admin.index', [
            'title' => 'Admin',
            'menu' => 'Admin',
            'page' => 'Dashboard',
            'users' => $users,
            'karyawan' => $karyawan,
            'pelanggan' => $pelanggan,
            'user_aktif' => $user_aktif,
            'user_nonaktif' => $user_nonaktif,
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
        $user = User::findOrFail($id);

        // Cari data profile terkait berdasarkan level user
        $profileData = null;
        if (in_array($user->level, ['admin', 'pemilik', 'bendahara'])) {
            $profileData = Karyawan::where('id_user', $id)->first();
        } elseif ($user->level == 'pelanggan') {
            $profileData = Pelanggan::where('id_user', $id)->first();
        }

        return view('admin.show', [
            'title' => 'Admin',
            'menu' => 'Admin',
            'page' => 'Detail Pengguna',
            'user' => $user,
            'profileData' => $profileData
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        // Cari data profile terkait berdasarkan level user
        $profileData = null;
        if (in_array($user->level, ['admin', 'pemilik', 'bendahara'])) {
            $profileData = Karyawan::where('id_user', $id)->first();
        } elseif ($user->level == 'pelanggan') {
            $profileData = Pelanggan::where('id_user', $id)->first();
        }

        return view('admin.edit', [
            'title' => 'Admin',
            'menu' => 'Admin',
            'page' => 'Edit Pengguna',
            'user' => $user,
            'profileData' => $profileData
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Ambil data user
            $user = User::findOrFail($id);

            // Cek apakah ada user lain dengan email yang sama
            $existingUser = User::where('email', $request->email)->where('id', '!=', $id)->first();
            if ($existingUser) {
                return redirect()->back()->with('error', 'Email sudah digunakan oleh pengguna lain!')->withInput();
            }

            // Update data user
            $user->email = $request->email;
            $user->level = $request->level;
            $user->aktif = $request->aktif;

            // Jika password diisi, update password
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Update profile data berdasarkan level
            if (in_array($user->level, ['admin', 'pemilik', 'bendahara'])) {
                $existingKaryawan = Karyawan::where('id_user', $id)->first();
                if ($existingKaryawan) {
                    $existingKaryawan->update([
                        'nama_karyawan' => $request->nama,
                        'alamat' => $request->alamat,
                        'no_hp' => $request->no_hp,
                        'jabatan' => $request->jabatan
                    ]);
                } else {
                    Karyawan::create([
                        'id_user' => $id,
                        'nama_karyawan' => $request->nama,
                        'alamat' => $request->alamat,
                        'no_hp' => $request->no_hp,
                        'jabatan' => $request->jabatan
                    ]);
                }
            } elseif ($user->level == 'pelanggan') {
                $existingPelanggan = Pelanggan::where('id_user', $id)->first();
                if ($existingPelanggan) {
                    // Validasi ukuran foto (Maksimal 3MB)
                    if ($request->hasFile('foto') && $request->file('foto')->getSize() > 3 * 1024 * 1024) {
                        return redirect()->back()->with('error', 'Ukuran foto tidak boleh lebih dari 3MB!')->withInput();
                    }

                    // Jika ada foto baru, hapus foto lama dan simpan yang baru
                    if ($request->hasFile('foto')) {
                        // Hapus foto lama jika ada
                        if (!empty($existingPelanggan->foto) && Storage::exists('Storage/' . $existingPelanggan->foto)) {
                            Storage::delete('Storage/' . $existingPelanggan->foto);
                        }

                        // Simpan foto baru
                        $fotoPath = $request->file('foto')->store('Pelanggan');
                        $fotoPath = str_replace('Storage/', '', $fotoPath); // Simpan tanpa "public/" di database
                    } else {
                        $fotoPath = $existingPelanggan->foto; // Gunakan foto lama jika tidak ada upload baru
                    }

                    $existingPelanggan->update([
                        'nama_pelanggan' => $request->nama,
                        'alamat' => $request->alamat,
                        'no_hp' => $request->no_hp,
                        'foto' => $fotoPath,
                    ]);
                } else {
                    // Jika pelanggan baru, simpan foto jika ada
                    if ($request->hasFile('foto')) {
                        $fotoPath = $request->file('foto')->store('Pelanggan');
                        $fotoPath = str_replace('Storage/', '', $fotoPath);
                    } else {
                        $fotoPath = null;
                    }

                    Pelanggan::create([
                        'id_user' => $id,
                        'nama_pelanggan' => $request->nama,
                        'alamat' => $request->alamat,
                        'no_hp' => $request->no_hp,
                        'foto' => $fotoPath,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.index')->with('pesan', 'Data pengguna berhasil diperbarui');

        } catch (QueryException $e) {
            DB::rollBack();

            // Tangani Unique Constraint Violation (Kode Error 23000)
            if ($e->getCode() == "23000") {
                // Cek apakah duplikasi terjadi pada email
                $existing = User::where('email', $request->email)->first();
                if ($existing) {
                    return redirect()->back()->with('error', 'Email sudah terdaftar, silakan gunakan email lain!')->withInput();
                }

                // Cek apakah duplikasi terjadi di tabel Karyawan atau Pelanggan
                $existingKaryawan = Karyawan::where('no_hp', $request->no_hp)->first();
                $existingPelanggan = Pelanggan::where('no_hp', $request->no_hp)->first();

                if ($existingKaryawan || $existingPelanggan) {
                    return redirect()->back()->with('error', 'Nomor HP sudah digunakan, silakan gunakan nomor lain!')->withInput();
                }

                return redirect()->back()->with('error', 'Data yang Anda masukkan melanggar aturan database!')->withInput();
            }

            return redirect()->route('admin.edit', $id)->with([
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
        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Jika user adalah karyawan (admin, pemilik, bendahara), hapus dari tabel Karyawan
        if (in_array($user->level, ['admin', 'pemilik', 'bendahara'])) {
            Karyawan::where('id_user', $id)->delete();
        }
        // Jika user adalah pelanggan, hapus dari tabel Pelanggan dan hapus foto jika ada
        elseif ($user->level == 'pelanggan') {
            $pelanggan = Pelanggan::where('id_user', $id)->first();

            if ($pelanggan) {
                if (!empty($pelanggan->foto) && Storage::exists($pelanggan->foto)) {
                    Storage::delete($pelanggan->foto);
                }

                $pelanggan->delete();
            }
        }

        // Hapus user dari tabel User
        $user->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.index')->with('pesan', 'Data pengguna berhasil dihapus');
    }

}
