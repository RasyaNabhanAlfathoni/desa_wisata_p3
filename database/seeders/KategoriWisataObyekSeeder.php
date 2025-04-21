<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriWisata;
use App\Models\ObyekWisata;

class KategoriWisataObyekSeeder extends Seeder
{
    /**
     * Jalankan database seeder.
     */
    public function run(): void
    {
        // Insert kategori_wisata
        $kategoriBudaya = KategoriWisata::create(['kategori_wisata' => 'Wisata Budaya']);
        $kategoriAlam = KategoriWisata::create(['kategori_wisata' => 'Wisata Alam']);
        $kategoriKuliner = KategoriWisata::create(['kategori_wisata' => 'Wisata Kuliner']);
        $kategoriEdukasi = KategoriWisata::create(['kategori_wisata' => 'Wisata Edukasi']);
        $kategoriReligi = KategoriWisata::create(['kategori_wisata' => 'Wisata Religi']);

        // Buat beberapa obyek wisata yang terkait dengan kategori di atas
        ObyekWisata::create([
            'nama_wisata' => 'Rumah Adat Tradisional Penglipuran',
            'deskripsi_wisata' => 'Rumah tradisional dengan arsitektur khas Bali yang telah bertahan selama berabad-abad. Seluruh rumah dibangun dengan susunan yang sama dan menghadap ke arah utara-selatan. Rumah-rumah ini memiliki struktur tiga bagian: sanggah (tempat suci), bale (tempat tinggal), dan teba (halaman belakang).',
            'id_kategori_wisata' => $kategoriBudaya->id,
            'fasilitas' => 'Area parkir, toilet umum, pemandu wisata, tempat istirahat',
            'foto1' => 'default.jpg',
            'foto2' => 'default.jpg',
            'foto3' => 'default.jpg',
            'foto4' => 'default.jpg',
            'foto5' => 'default.jpg',
        ]);

        ObyekWisata::create([
            'nama_wisata' => 'Jalan Utama Desa Penglipuran',
            'deskripsi_wisata' => 'Jalan utama Desa Penglipuran yang bersih dan rapi dengan lebar sekitar 3 meter, diapit oleh pagar bambu dan berbagai tanaman hias. Jalan ini membentang dari gerbang masuk desa hingga ke ujung pemukiman dan menjadi salah satu ikon Desa Penglipuran yang paling terkenal.',
            'id_kategori_wisata' => $kategoriBudaya->id,
            'fasilitas' => 'Bangku-bangku untuk beristirahat, toko souvenir, warung makanan dan minuman',
            'foto1' => 'default.jpg',
            'foto2' => 'default.jpg',
            'foto3' => 'default.jpg',
            'foto4' => 'default.jpg',
            'foto5' => 'default.jpg',
        ]);

        ObyekWisata::create([
            'nama_wisata' => 'Hutan Bambu Penglipuran',
            'deskripsi_wisata' => 'Hutan bambu yang luas terletak di belakang desa. Hutan ini menjadi sumber bahan baku untuk kerajinan dan bangunan di desa. Udara segar dan pemandangan yang hijau menjadikan hutan bambu ini tempat yang cocok untuk relaksasi dan fotografi.',
            'id_kategori_wisata' => $kategoriAlam->id,
            'fasilitas' => 'Jalur trekking, area fotografi, gazebo',
            'foto1' => 'default.jpg',
            'foto2' => 'default.jpg',
            'foto3' => 'default.jpg',
            'foto4' => 'default.jpg',
            'foto5' => 'default.jpg',
        ]);

        ObyekWisata::create([
            'nama_wisata' => 'Warung Kopi Tradisional Penglipuran',
            'deskripsi_wisata' => 'Warung kopi dengan konsep tradisional yang menyajikan kopi khas Bali serta berbagai jajanan tradisional. Pengunjung dapat menikmati kopi sambil melihat pemandangan desa.',
            'id_kategori_wisata' => $kategoriKuliner->id,
            'fasilitas' => 'Area duduk indoor dan outdoor, wifi gratis, toilet',
            'foto1' => 'default.jpg',
            'foto2' => 'default.jpg',
            'foto3' => 'default.jpg',
            'foto4' => 'default.jpg',
            'foto5' => 'default.jpg',
        ]);

        ObyekWisata::create([
            'nama_wisata' => 'Pusat Kerajinan Bambu Penglipuran',
            'deskripsi_wisata' => 'Pusat kerajinan yang menampilkan proses pembuatan berbagai kerajinan dari bambu oleh penduduk lokal. Pengunjung dapat melihat langsung proses pembuatan dan membeli produk langsung dari pengrajinnya.',
            'id_kategori_wisata' => $kategoriEdukasi->id,
            'fasilitas' => 'Workshop interaktif, toko souvenir, area demonstrasi',
            'foto1' => 'default.jpg',
            'foto2' => 'default.jpg',
            'foto3' => 'default.jpg',
            'foto4' => 'default.jpg',
            'foto5' => 'default.jpg',
        ]);

        ObyekWisata::create([
            'nama_wisata' => 'Angkul-Angkul Tradisional',
            'deskripsi_wisata' => 'Gerbang tradisional khas Bali di setiap rumah penduduk Desa Penglipuran. Memiliki desain seragam yang menjadi ciri khas arsitektur desa ini. Angkul-angkul ini terbuat dari batu bata merah dan memiliki atap dari ijuk.',
            'id_kategori_wisata' => $kategoriBudaya->id,
            'fasilitas' => 'Area foto, informasi sejarah dan filosofi',
            'foto1' => 'default.jpg',
            'foto2' => 'default.jpg',
            'foto3' => 'default.jpg',
            'foto4' => 'default.jpg',
            'foto5' => 'default.jpg',
        ]);

        ObyekWisata::create([
            'nama_wisata' => 'Kuliner Tradisional Penglipuran',
            'deskripsi_wisata' => 'Area kuliner yang menyajikan berbagai makanan tradisional Bali seperti lawar, babi guling, sate lilit, dan berbagai jajanan tradisional. Makanan disajikan dengan bahan-bahan segar dari desa.',
            'id_kategori_wisata' => $kategoriKuliner->id,
            'fasilitas' => 'Area makan bersama, dapur terbuka, kelas memasak singkat',
            'foto1' => 'default.jpg',
            'foto2' => 'default.jpg',
            'foto3' => 'default.jpg',
            'foto4' => 'default.jpg',
            'foto5' => 'default.jpg',
        ]);

        ObyekWisata::create([
            'nama_wisata' => 'Pura Penataran Penglipuran',
            'deskripsi_wisata' => 'Pura utama desa Penglipuran yang terletak di ujung utara jalan utama. Pura ini memiliki arsitektur khas Bali dan menjadi pusat kegiatan upacara keagamaan masyarakat desa. Area kuil dibagi menjadi tiga zona sesuai konsep Tri Mandala.',
            'id_kategori_wisata' => $kategoriReligi->id,
            'fasilitas' => 'Area parkir, tempat persembahyangan, pemandu untuk wisatawan',
            'foto1' => 'default.jpg',
            'foto2' => 'default.jpg',
            'foto3' => 'default.jpg',
            'foto4' => 'default.jpg',
            'foto5' => 'default.jpg',
        ]);
    }
}
