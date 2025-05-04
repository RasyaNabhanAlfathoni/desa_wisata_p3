<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered; // Import Event
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    // Menampilkan halaman register
    public function showRegistrationForm() {
        return view('auth.register', [
            'title' => 'Register'
        ]);
    }

    // Menangani proses register
    public function register(Request $request) {

        // Buat entri di tabel users
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 'pelanggan', // Set level secara otomatis sebagai pelanggan
            'akif' => 1, // Set status aktif
            'remember_token' => Str::random(60), // Generate remember token
        ]);

        // Buat entri di tabel pelanggan
        $pelanggan = Pelanggan::create([
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'id_user' => $user->id, // Hubungkan dengan user yang baru dibuat
        ]);

        // Auth::login($user);

        // Kirim email verifikasi
        event(new Registered($user));

        // return redirect()->route('login')->with('pesan', 'Silakan cek email Anda untuk verifikasi akun.');
        return redirect()->route('verification.notice')->with('pesan', 'Akun berhasil dibuat. Silakan cek email Anda untuk verifikasi.');
    }

    // Menampilkan halaman notice verifikasi email
    public function verificationNotice() {
        return view('auth.verify', [
            'title' => 'Verifikasi Email'
        ]);
    }

    // Menangani verifikasi email
    public function verificationVerify(EmailVerificationRequest $request) {
        // Jika user belum login, coba login dulu
        if (!Auth::check()) {
            $user = User::find($request->route('id'));
            if ($user) {
                Auth::login($user);
            }
        }
        $request->fulfill();
        // Logout user jika kebetulan sudah login
        Auth::logout();
        return redirect()->route('login')->with('pesan', 'Email berhasil diverifikasi. Silakan login.');
    }

    // Mengirim ulang link verifikasi
    public function verificationResend(Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('login')->with('pesan', 'Email sudah diverifikasi.');
        }

        $request->user()->sendEmailVerificationNotification();
        return back()->with('pesan', 'Link verifikasi telah dikirim ulang ke email Anda.');
    }

    // Menampilkan halaman login
    public function showLoginForm() {
        return view('auth.login', [
            'title' => 'Login'
        ]);
    }

    // Menangani proses login
    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email atau Password salah!');
        }

        if ($user->aktif != 1) {
            return back()->with('error', 'Akun dengan level ' . $user->level . ' ini sedang nonaktif!');
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Cek apakah remember me dicentang

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Cek apakah user adalah pelanggan dan perlu verifikasi email
            if ($user->level === 'pelanggan' && !$request->user()->hasVerifiedEmail()) {
                // Pastikan $user tidak null sebelum mengirim notifikasi
                // if ($user) {
                //     $request->user()->sendEmailVerificationNotification();
                // }
                // Auth::logout();
                $request->user()->sendEmailVerificationNotification();
                return back()->with('error', 'Akun belum diverifikasi! Kami telah mengirim ulang link verifikasi ke email Anda. Silakan cek email Anda (termasuk folder spam).')
                            ->with('resend_verification', true)
                            ->with('email', $user->email);
            }

            if ($user->level === 'admin') {
                return redirect()->route('admin.index')->with('pesan', 'Selamat datang, Admin ' . $user->karyawan->nama_karyawan . '!');
            } elseif ($user->level === 'pemilik') {
                return redirect()->route('pemilik.index')->with('pesan', 'Selamat datang, Pemilik ' . $user->karyawan->nama_karyawan . '!');
            } elseif ($user->level === 'bendahara') {
                return redirect()->route('bendahara.index')->with('pesan', 'Selamat datang, Bendahara ' . $user->karyawan->nama_karyawan . '!');
            } elseif ($user->level === 'pelanggan') {
                return redirect()->route('pelanggan.index')->with('pesan', 'Selamat datang, Pelanggan ' . $user->pelanggan->nama_lengkap . '!');
            }

            // Redirect berdasarkan level pengguna
            switch ($user->level) {
                case 'admin':
                    return redirect('/admin')->with('error', 'Anda tidak memiliki akses ke halaman itu.');
                case 'pemilik':
                    return redirect('/pemilik')->with('error', 'Anda tidak memiliki akses ke halaman itu.');
                case 'bendahara':
                    return redirect('/bendahara')->with('error', 'Anda tidak memiliki akses ke halaman itu.');
                case 'pelanggan':
                    return redirect('/pelanggan')->with('error', 'Anda tidak memiliki akses ke halaman itu.');
            }
        }

        return back()->with('error', 'Email atau Password salah!');
    }

    // Menangani proses logout
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('pesan', 'Anda telah berhasil logout!');
    }
}
