<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Reservasi;
use App\Models\Pelanggan;
use App\Models\PaketWisata;

class ReservasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil pelanggan dengan ID 1
        $pelanggan = Pelanggan::find(1);

        // Ambil paket wisata dengan ID 2
        $paket = PaketWisata::find(2);

        $jumlahPeserta = rand(1, $paket->kuota_peserta);
        $hargaPerPack = $paket->harga_per_pack;
        $totalHarga = $hargaPerPack * $jumlahPeserta;

        // Gunakan diskon hanya jika jumlah peserta memenuhi syarat
        $isEligibleForDiscount = $jumlahPeserta >= $paket->peserta_diskon;
        $diskonPersen = $isEligibleForDiscount ? $paket->nilai_diskon : 0;
        $nilaiDiskon = ($totalHarga * $diskonPersen) / 100;
        $totalBayar = $totalHarga - $nilaiDiskon;

        Reservasi::create([
            'id_pelanggan' => $pelanggan->id,
            'id_paket' => $paket->id,
            'tgl_reservasi_mulai' => Carbon::now()->addDays(rand(3, 10)),
            'tgl_reservasi_akhir' => Carbon::now()->addDays(rand(11, 15)),
            'harga' => $hargaPerPack,
            'jumlah_peserta' => $jumlahPeserta,
            'diskon' => $nilaiDiskon, // nominal diskon (Rp)
            'nilai_diskon' => $diskonPersen, // persentase diskon
            'total_bayar' => $totalBayar,
            'file_bukti_tf' => 'bukti_' . Str::random(10) . '.jpg',
            'status_reservasi_wisata' => ['pesan', 'dibayar', 'selesai', 'dibatalkan'][rand(0, 3)],
        ]);
    }
}
