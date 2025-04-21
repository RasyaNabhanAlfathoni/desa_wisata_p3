<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaketWisata;

class PaketWisataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaketWisata::create([
            'nama_paket' => 'Paket Sehari Penglipuran',
            'deskripsi' => 'Paket wisata satu hari penuh untuk menjelajahi keindahan desa wisata Penglipuran. Termasuk tur rumah adat, jalan utama desa, hutan bambu, dan makan siang kuliner tradisional.',
            'fasilitas' => 'Pemandu wisata profesional, tiket masuk semua objek wisata, makan siang tradisional, air mineral, souvenir kecil',
            'harga_per_pack' => 350000,
            'durasi_hari' => 1,
            'kuota_peserta' => 10,
            'nilai_diskon' => 0,
            'peserta_diskon' => 5,
            'foto1' => 'paket_sehari_1.jpg',
            'foto2' => 'paket_sehari_2.jpg',
            'foto3' => 'paket_sehari_3.jpg',
            'foto4' => 'paket_sehari_4.jpg',
            'foto5' => 'paket_sehari_5.jpg',
        ]);

        PaketWisata::create([
            'nama_paket' => 'Paket Budaya Penglipuran',
            'deskripsi' => 'Paket wisata dua hari satu malam dengan fokus pada pengalaman budaya mendalam di Desa Penglipuran. Termasuk workshop kerajinan bambu, mengikuti upacara tradisional, dan menginap di rumah penduduk lokal.',
            'fasilitas' => 'Pemandu wisata, penginapan di rumah penduduk, 3x makan, tiket masuk semua objek wisata, workshop kerajinan, dokumentasi foto',
            'harga_per_pack' => 750000,
            'durasi_hari' => 2,
            'kuota_peserta' => 8,
            'nilai_diskon' => 10, // 10% diskon jika memenuhi syarat
            'peserta_diskon' => 4,
            'foto1' => 'paket_budaya_1.jpg',
            'foto2' => 'paket_budaya_2.jpg',
            'foto3' => 'paket_budaya_3.jpg',
            'foto4' => 'paket_budaya_4.jpg',
            'foto5' => 'paket_budaya_5.jpg',
        ]);

        PaketWisata::create([
            'nama_paket' => 'Paket Kuliner Penglipuran',
            'deskripsi' => 'Paket wisata kuliner selama satu hari untuk menikmati berbagai makanan tradisional Bali di Desa Penglipuran. Termasuk kelas memasak singkat dan makan di beberapa tempat kuliner terbaik di desa.',
            'fasilitas' => 'Pemandu kuliner, semua makanan dan minuman, kelas memasak, resep tradisional, souvenir kuliner',
            'harga_per_pack' => 400000,
            'durasi_hari' => 1,
            'kuota_peserta' => 8,
            'nilai_diskon' => 0,
            'peserta_diskon' => 6,
            'foto1' => 'paket_kuliner_1.jpg',
            'foto2' => 'paket_kuliner_2.jpg',
            'foto3' => 'paket_kuliner_3.jpg',
            'foto4' => 'paket_kuliner_4.jpg',
            'foto5' => 'paket_kuliner_5.jpg',
        ]);

        PaketWisata::create([
            'nama_paket' => 'Paket Keluarga Penglipuran',
            'deskripsi' => 'Paket wisata ramah keluarga selama dua hari satu malam di Desa Penglipuran. Mencakup semua atraksi utama dengan tempo yang santai dan aktivitas yang cocok untuk anak-anak.',
            'fasilitas' => 'Pemandu ramah anak, penginapan keluarga, semua makanan, tiket masuk objek wisata, aktivitas interaktif untuk anak-anak, souvenir keluarga',
            'harga_per_pack' => 1200000,
            'durasi_hari' => 2,
            'kuota_peserta' => 12,
            'nilai_diskon' => 15, // 15% diskon jika memenuhi syarat
            'peserta_diskon' => 8,
            'foto1' => 'paket_keluarga_1.jpg',
            'foto2' => 'paket_keluarga_2.jpg',
            'foto3' => 'paket_keluarga_3.jpg',
            'foto4' => 'paket_keluarga_4.jpg',
            'foto5' => 'paket_keluarga_5.jpg',
        ]);

        PaketWisata::create([
            'nama_paket' => 'Paket Edukasi Penglipuran',
            'deskripsi' => 'Paket wisata edukasi tiga hari dua malam bagi pelajar atau kelompok yang ingin mempelajari budaya dan pelestarian lingkungan di Desa Penglipuran secara mendalam.',
            'fasilitas' => 'Pemandu edukasi, penginapan, semua makanan, materi pembelajaran, sertifikat, kegiatan proyek sosial, kunjungan ke sekolah lokal',
            'harga_per_pack' => 950000,
            'durasi_hari' => 3,
            'kuota_peserta' => 20,
            'nilai_diskon' => 20, // 20% diskon jika memenuhi syarat
            'peserta_diskon' => 15,
            'foto1' => 'paket_edukasi_1.jpg',
            'foto2' => 'paket_edukasi_2.jpg',
            'foto3' => 'paket_edukasi_3.jpg',
            'foto4' => 'paket_edukasi_4.jpg',
            'foto5' => 'paket_edukasi_5.jpg',
        ]);

        PaketWisata::create([
            'nama_paket' => 'Paket Fotografi Penglipuran',
            'deskripsi' => 'Paket khusus untuk fotografer amatir dan profesional yang ingin mengabadikan keindahan Desa Penglipuran dalam berbagai waktu, termasuk golden hour pagi dan sore.',
            'fasilitas' => 'Pemandu fotografi lokal, akses khusus ke spot fotografi terbaik, makan dan minum, transport dalam desa, workshop editing foto singkat',
            'harga_per_pack' => 500000,
            'durasi_hari' => 1,
            'kuota_peserta' => 6,
            'nilai_diskon' => 0,
            'peserta_diskon' => 4,
            'foto1' => 'paket_fotografi_1.jpg',
            'foto2' => 'paket_fotografi_2.jpg',
            'foto3' => 'paket_fotografi_3.jpg',
            'foto4' => 'paket_fotografi_4.jpg',
            'foto5' => 'paket_fotografi_5.jpg',
        ]);
    }
}
