<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $id = $user->id;

                $hasNew = false;

                // Cek tiap data (ambil id terbaru)
                $latestUser = DB::table('users')->latest()->first();
                $latestKaryawan = DB::table('karyawan')->latest()->first();
                $latestPelanggan = DB::table('pelanggan')->latest()->first();
                $latestReservasi = DB::table('reservasi')->latest()->first();
                $latestBerita = DB::table('berita')->latest()->first();
                $latestPaket = DB::table('paket_wisata')->latest()->first();

                // Bandingkan ID terakhir dengan session
                if ($user->level === 'admin') {
                    $hasNew = ($latestUser && $latestUser->id != session('last_seen_user_' . $id)) ||
                            ($latestKaryawan && $latestKaryawan->id != session('last_seen_karyawan_' . $id)) ||
                            ($latestPelanggan && $latestPelanggan->id != session('last_seen_pelanggan_' . $id)) ||
                            ($latestReservasi && $latestReservasi->id != session('last_seen_reservasi_' . $id)) ||
                            ($latestBerita && $latestBerita->id != session('last_seen_berita_' . $id)) ||
                            ($latestPaket && $latestPaket->id != session('last_seen_paket_' . $id));
                }

                if ($user->level === 'pemilik') {
                    $hasNew = ($latestBerita && $latestBerita->id != session('last_seen_berita_' . $id)) ||
                            ($latestPaket && $latestPaket->id != session('last_seen_paket_' . $id)) ||
                            ($latestReservasi && $latestReservasi->id != session('last_seen_reservasi_' . $id));
                }

                if ($user->level === 'bendahara') {
                    $hasNew = ($latestReservasi && $latestReservasi->id != session('last_seen_reservasi_' . $id));
                }

                if ($user->level === 'pelanggan') {
                    $hasNew = ($latestBerita && $latestBerita->id != session('last_seen_berita_' . $id));
                }

                $view->with('notifBaru', $hasNew);
            }
        });
    }
}
