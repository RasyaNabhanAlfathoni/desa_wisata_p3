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
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

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
        return redirect()->route('verification.notice')->with('pesan', 'Akun berhasil dibuat. Silakan cek email Anda untuk verifikasi (termasuk folder spam).');
    }

    // Menampilkan halaman notice verifikasi email
    public function verificationNotice() {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->level === 'pelanggan') {
                return redirect()->route('pelanggan.index');
            } elseif ($user->level === 'admin') {
                return redirect()->route('admin.index');
            } elseif ($user->level === 'pemilik') {
                return redirect()->route('pemilik.index');
            } elseif ($user->level === 'bendahara') {
                return redirect()->route('bendahara.index');
            }
        }

        // Tampilkan halaman verifikasi
        return view('auth.verify', [
            'title' => 'Verifikasi Email',
            'email' => session('registered_email') // optional: kirim email yang baru register
        ]);
    }

    // Menangani verifikasi email
    public function verificationVerify(Request $request, $id, $hash) {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Validasi hash
        if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            return redirect()->route('login')->with('error', 'Link verifikasi tidak valid!');
        }

        // Cek apakah sudah terverifikasi
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('pesan', 'Email sudah diverifikasi sebelumnya.');
        }

        // Tandai email sebagai terverifikasi
        $user->markEmailAsVerified();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('pesan', 'Email berhasil diverifikasi! Silakan login.');
    }

    // Mengirim ulang link verifikasi
    public function verificationResend(Request $request) {
        // Cek apakah user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('login')->with('pesan', 'Email sudah diverifikasi.');
        }

        ($request->user()->sendEmailVerificationNotification());
        return back()->with('pesan', 'Kami telah mengirim ulang link verifikasi ke email Anda. Silakan cek email Anda (termasuk folder spam).');
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
                Auth::logout();
                // $request->user()->sendEmailVerificationNotification();
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

    // Menampilkan form lupa password
    public function showForgotPasswordForm() {
        return view('auth.forgot-password', [
            'title' => 'Lupa Password'
        ]);
    }

    // Mengirim link reset password
    public function sendResetLinkEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan!');
        }

        // Cek jika user bukan pelanggan
        if ($user->level !== 'pelanggan') {
            return back()->with('error', 'Fitur lupa password hanya untuk pelanggan!');
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('pesan', 'Link reset password telah dikirim ke email Anda. Silakan cek email Anda (termasuk folder spam)!')
            : back()->with('error', 'Gagal mengirim link reset password!');
    }

    // Menampilkan form reset password
    public function showResetPasswordForm(Request $request, $token) {
        return view('auth.reset-password', [
            'title' => 'Reset Password',
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Proses reset password
    public function resetPassword(Request $request) {
        $user = User::where('email', $request->email)->first();

        // Validasi tambahan untuk pelanggan
        if (!$user || $user->level !== 'pelanggan') {
            return back()->with('error', 'Reset password hanya untuk pelanggan!');
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                // Optional: Hapus token yang sudah digunakan
                DB::table('password_reset_tokens')
                    ->where('email', $user->email)
                    ->delete();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('pesan', 'Password berhasil direset! Silakan login.');
        } else {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
        }
    }

    // Menangani proses logout
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('pesan', 'Anda telah berhasil logout!');
    }
}
