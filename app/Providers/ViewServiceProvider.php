<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservasi;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Karyawan;
use App\Models\Berita;
use App\Models\PaketWisata;
use Carbon\Carbon;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('be.navbar', function ($view) {
            $user = Auth::user();

            if (!$user) {
                return $view->with([
                    'notif_user_baru' => collect(),
                    'notif_karyawan_baru' => collect(),
                    'notif_pelanggan_baru' => collect(),
                    'notif_reservasi_baru' => collect(),
                    'notif_reservasi_diterima' => collect(),
                    'notif_berita_baru' => collect(),
                    'notif_paket_wisata_baru' => collect()
                ]);
            }

            $level = $user->level;

            // Filter hanya notifikasi dari 7 hari terakhir
            $applyTimeFilter = function ($query) {
                return $query->where('created_at', '>=', Carbon::now()->subDays(7));
            };

            $notif_user_baru = collect();
            $notif_karyawan_baru = collect();
            $notif_pelanggan_baru = collect();
            $notif_reservasi_baru = collect();
            $notif_reservasi_diterima = collect();
            $notif_berita_baru = collect();
            $notif_paket_wisata_baru = collect();

            if ($level == 'admin') {
                $notif_user_baru = $applyTimeFilter(User::query())->latest()->take(5)->get();
                $notif_karyawan_baru = $applyTimeFilter(Karyawan::query())->latest()->take(5)->get();
                $notif_pelanggan_baru = $applyTimeFilter(Pelanggan::query())->latest()->take(5)->get();
            }

            if (in_array($level, ['admin', 'pemilik'])) {
                $notif_berita_baru = $applyTimeFilter(Berita::query())->latest()->take(5)->get();
                $notif_paket_wisata_baru = $applyTimeFilter(PaketWisata::query())->latest()->take(5)->get();
            }

            if (in_array($level, ['admin', 'pemilik', 'bendahara'])) {
                $notif_reservasi_baru = $applyTimeFilter(Reservasi::query())->latest()->take(5)->get();
            }

            if ($level == 'pelanggan') {
                $notif_reservasi_diterima = $applyTimeFilter(
                    Reservasi::query()->where('id_pelanggan', $user->id_pelanggan)->where('status', 'diterima')
                )->latest()->take(5)->get();

                $notif_berita_baru = $applyTimeFilter(Berita::query())->latest()->take(5)->get();
            }

            $view->with(compact(
                'notif_user_baru',
                'notif_karyawan_baru',
                'notif_pelanggan_baru',
                'notif_reservasi_baru',
                'notif_reservasi_diterima',
                'notif_berita_baru',
                'notif_paket_wisata_baru'
            ));
        });
    }

    public function register()
    {
        //
    }
}
