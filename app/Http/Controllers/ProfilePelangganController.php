<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use Illuminate\Database\QueryException;

class ProfilePelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('profile-pelanggan.index', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'title2' => 'Profile - Pelanggan',
            'menu' => 'Profile',
            'page' => 'Profile',
            'user' => Auth::user(), // Kirim data user ke view
            'pelanggan' => $pelanggan,
            'reservasis' => $pelanggan->reservasi()->latest()->take(3)->get()
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
    public function edit()
    {
        $user = auth()->user();

        // Mengambil data pelanggan terkait
        $pelanggan = $user->pelanggan;

        return view('profile-pelanggan.edit', [
            'title' => ucfirst(Auth::user()->level), // Menyesuaikan title dengan role user
            'title2' => 'Profile - Pelanggan',
            'menu' => 'Profile',
            'page' => 'Edit Profile',
            'user' => Auth::user(), // Kirim data user ke form edit
            'pelanggan' => $pelanggan,
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

            // Pastikan user hanya bisa mengubah profil sendiri
            if ($id != Auth::id()) {
                return redirect()->back()->with('error', 'Anda hanya dapat mengubah profil sendiri!');
            }

            // Ambil data user
            $user = User::findOrFail($id);

            // Validasi email unik
            $existingUser = User::where('email', $request->email)->where('id', '!=', $id)->first();
            if ($existingUser) {
                return redirect()->back()->with('error', 'Email sudah digunakan oleh pengguna lain!')->withInput();
            }

            // Update data user (email dan password jika diisi)
            $user->email = $request->email;

            // Jika password diisi, update password
            if ($request->filled('password')) {
                // Validasi password lama
                if (!Hash::check($request->password_lama, $user->password)) {
                    return redirect()->back()->with('error', 'Password lama tidak sesuai!')->withInput();
                }

                $user->password = Hash::make($request->password);
            }

            $user->save();

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
                        'nama_lengkap' => $request->nama_lengkap,
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

            DB::commit();

            return redirect()->route('profile-pelanggan.index')->with('pesan', 'Profil berhasil diperbarui');

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

            return redirect()->route('profile-pelanggan.edit', $id)->with([
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
        //
    }
}
