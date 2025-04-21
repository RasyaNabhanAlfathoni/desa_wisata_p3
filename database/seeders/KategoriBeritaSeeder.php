<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBerita;
use App\Models\Berita;
use Carbon\Carbon;

class KategoriBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriBerita::create([
            'kategori_berita' => 'Acara Tradisional',
        ]);

        KategoriBerita::create([
            'kategori_berita' => 'Pengembangan Desa',
        ]);

        KategoriBerita::create([
            'kategori_berita' => 'Prestasi',
        ]);

        KategoriBerita::create([
            'kategori_berita' => 'Promosi Wisata',
        ]);

        KategoriBerita::create([
            'kategori_berita' => 'Edukasi',
        ]);

        Berita::create([
            'judul' => 'Festival Budaya Tahunan Desa Penglipuran Akan Digelar Bulan Depan',
            'berita' => '<p>Desa Wisata Penglipuran akan menggelar Festival Budaya Tahunan pada tanggal 15-17 Mei 2025. Festival ini akan menampilkan berbagai pertunjukan seni tradisional, upacara adat, pameran kerajinan bambu, dan kuliner khas Bali.</p>
            <p>Festival yang sudah memasuki tahun ke-12 ini diharapkan dapat menarik lebih banyak wisatawan domestik dan internasional untuk mengunjungi Desa Penglipuran. Tahun lalu, acara serupa berhasil mendatangkan sekitar 5000 pengunjung selama tiga hari pelaksanaan.</p>
            <p>Kepala Desa Penglipuran, I Wayan Supat, mengatakan bahwa festival ini menjadi salah satu cara untuk melestarikan budaya Bali dan sekaligus meningkatkan perekonomian warga desa. "Kami ingin memperkenalkan keunikan budaya kami kepada dunia sekaligus memberdayakan masyarakat lokal," ujarnya.</p>
            <p>Festival akan dibuka dengan upacara adat yang dipimpin oleh tetua desa dan diikuti dengan parade budaya sepanjang jalan utama desa. Pengunjung juga berkesempatan untuk mengikuti berbagai workshop seperti pembuatan kerajinan bambu, memasak makanan tradisional, dan belajar tarian Bali.</p>',
            'tgl_post' => Carbon::create(2025, 4, 10, 9, 30, 0),
            'id_kategori_berita' => 1,
            'foto' => 'festival_budaya.jpg',
        ]);

        Berita::create([
            'judul' => 'Desa Penglipuran Resmikan Pusat Informasi Wisata Digital',
            'berita' => '<p>Desa Wisata Penglipuran baru saja meresmikan Pusat Informasi Wisata Digital yang berlokasi di pintu masuk desa. Fasilitas modern ini dilengkapi dengan layar sentuh interaktif, koneksi internet gratis, dan aplikasi pemandu wisata digital untuk memudahkan pengunjung menjelajahi desa.</p>
            <p>Pembangunan pusat informasi ini merupakan bagian dari program digitalisasi desa wisata yang didukung oleh Kementerian Pariwisata dan Ekonomi Kreatif. Dengan adanya fasilitas ini, diharapkan pengalaman wisatawan saat berkunjung ke Desa Penglipuran akan semakin meningkat.</p>
            <p>"Pusat informasi ini akan membantu wisatawan untuk mendapatkan informasi lengkap tentang sejarah desa, objek wisata, paket wisata, dan berbagai fasilitas yang tersedia di Desa Penglipuran. Mereka juga bisa memesan paket wisata atau pemandu langsung melalui aplikasi yang tersedia," jelas I Made Arta, Ketua Kelompok Sadar Wisata Desa Penglipuran.</p>
            <p>Selain pusat informasi, Desa Penglipuran juga telah memasang QR code di beberapa titik objek wisata yang dapat dipindai oleh pengunjung untuk mendapatkan informasi lebih detail tentang objek tersebut dalam berbagai bahasa.</p>',
            'tgl_post' => Carbon::create(2025, 3, 25, 14, 15, 0),
            'id_kategori_berita' => 2,
            'foto' => 'pusat_informasi_digital.jpg',
        ]);

        Berita::create([
            'judul' => 'Desa Penglipuran Raih Penghargaan Desa Wisata Terbaik Tingkat Nasional',
            'berita' => '<p>Desa Wisata Penglipuran kembali mengukir prestasi membanggakan dengan meraih penghargaan sebagai Desa Wisata Terbaik Tingkat Nasional dalam ajang Indonesia Tourism Awards 2024. Penghargaan ini diterima langsung oleh perwakilan desa dalam acara yang digelar di Jakarta pada tanggal 5 Maret 2025.</p>
            <p>Penghargaan ini diberikan atas keberhasilan Desa Penglipuran dalam mengembangkan pariwisata berkelanjutan yang melibatkan partisipasi aktif masyarakat lokal. Desa Penglipuran dinilai berhasil memadukan pelestarian budaya tradisional dengan inovasi dalam pengelolaan pariwisata.</p>
            <p>"Ini adalah bukti kerja keras seluruh masyarakat Desa Penglipuran dalam menjaga dan mengembangkan potensi wisata kami. Kami berkomitmen untuk terus meningkatkan kualitas pelayanan dan melestarikan warisan budaya untuk generasi mendatang," ujar I Wayan Supat saat menerima penghargaan.</p>
            <p>Menteri Pariwisata dan Ekonomi Kreatif dalam sambutannya menyampaikan harapan agar keberhasilan Desa Penglipuran dapat menjadi inspirasi bagi desa wisata lainnya di Indonesia untuk mengembangkan pariwisata berbasis masyarakat yang berkelanjutan.</p>',
            'tgl_post' => Carbon::create(2025, 3, 8, 10, 45, 0),
            'id_kategori_berita' => 3,
            'foto' => 'penghargaan_desa_wisata.jpg',
        ]);

        Berita::create([
            'judul' => 'Diskon Khusus Paket Wisata Penglipuran untuk Pelajar dan Mahasiswa',
            'berita' => '<p>Pengelola Desa Wisata Penglipuran menawarkan diskon khusus sebesar 25% untuk paket wisata edukasi bagi pelajar dan mahasiswa yang berkunjung pada periode April hingga Juni 2025. Program ini merupakan bagian dari upaya promosi wisata edukasi di Desa Penglipuran.</p>
            <p>Diskon berlaku untuk Paket Edukasi Penglipuran yang mencakup kunjungan ke seluruh objek wisata di desa, workshop kerajinan bambu, belajar memasak makanan tradisional, dan menginap di rumah penduduk. Paket ini dirancang khusus untuk memberikan pengalaman belajar tentang budaya Bali dan pelestarian lingkungan.</p>
            <p>"Kami ingin mendorong lebih banyak pelajar dan mahasiswa untuk berkunjung dan belajar tentang kearifan lokal di Desa Penglipuran. Mereka adalah generasi penerus yang akan menjaga dan melestarikan warisan budaya kita," kata I Nyoman Arta, Koordinator Wisata Edukasi Desa Penglipuran.</p>
            <p>Untuk memanfaatkan diskon ini, pelajar dan mahasiswa cukup menunjukkan kartu identitas yang masih berlaku saat melakukan pemesanan paket wisata. Reservasi dapat dilakukan melalui website resmi Desa Wisata Penglipuran atau menghubungi kontak yang tersedia.</p>',
            'tgl_post' => Carbon::create(2025, 4, 2, 11, 0, 0),
            'id_kategori_berita' => 4,
            'foto' => 'diskon_paket_wisata.jpg',
        ]);

        Berita::create([
            'judul' => 'Workshop Kerajinan Bambu Khas Penglipuran Dibuka untuk Umum',
            'berita' => '<p>Mulai bulan Mei 2025, Desa Wisata Penglipuran akan membuka workshop kerajinan bambu untuk umum setiap hari Sabtu dan Minggu. Workshop ini akan diadakan di Pusat Kerajinan Bambu Penglipuran dan dipandu langsung oleh pengrajin lokal yang sudah berpengalaman.</p>
            <p>Workshop ini bertujuan untuk memperkenalkan dan melestarikan seni kerajinan bambu yang menjadi salah satu keunikan Desa Penglipuran. Peserta akan belajar tentang jenis-jenis bambu, teknik pengolahan, dan cara membuat berbagai kerajinan seperti anyaman, hiasan dinding, hingga alat musik tradisional.</p>
            <p>"Kerajinan bambu adalah bagian penting dari kehidupan masyarakat Penglipuran. Melalui workshop ini, kami ingin berbagi pengetahuan dan keterampilan dengan masyarakat luas, sekaligus menjaga agar tradisi ini tidak punah," kata I Wayan Sudiarta, koordinator workshop.</p>
            <p>Selain belajar membuat kerajinan, peserta juga akan diajak berkeliling hutan bambu untuk mengenal berbagai jenis bambu dan cara pelestariannya. Di akhir workshop, peserta akan membawa pulang hasil karya mereka sendiri sebagai kenang-kenangan.</p>',
            'tgl_post' => Carbon::create(2025, 4, 12, 8, 30, 0),
            'id_kategori_berita' => 5,
            'foto' => 'workshop_bambu.jpg',
        ]);

        Berita::create([
            'judul' => 'Upacara Metatah di Desa Penglipuran Menjadi Daya Tarik Wisatawan',
            'berita' => '<p>Upacara Metatah atau potong gigi yang baru saja digelar di Desa Penglipuran pada tanggal 5 April 2025 menjadi daya tarik tersendiri bagi wisatawan yang berkunjung. Puluhan wisatawan domestik dan mancanegara berkesempatan menyaksikan langsung upacara sakral ini.</p>
            <p>Metatah merupakan salah satu upacara penting dalam tradisi Hindu Bali yang dilakukan saat anak memasuki usia remaja. Upacara ini bertujuan untuk menghilangkan enam sifat buruk dalam diri manusia yang disimbolkan dengan mengikir enam gigi bagian atas.</p>
            <p>"Kami membuka kesempatan bagi wisatawan untuk menyaksikan upacara ini sebagai bagian dari edukasi budaya. Tentu saja dengan tetap menjaga kesakralan dan menghormati jalannya upacara," jelas I Made Astika, pemangku adat Desa Penglipuran.</p>
            <p>Sebelum upacara dimulai, wisatawan diberikan penjelasan tentang makna dan tata cara upacara oleh pemandu lokal. Mereka juga diminta untuk mengenakan pakaian adat Bali sederhana sebagai bentuk penghormatan terhadap upacara tersebut.</p>',
            'tgl_post' => Carbon::create(2025, 4, 7, 15, 20, 0),
            'id_kategori_berita' => 1,
            'foto' => 'upacara_metatah.jpg',
        ]);

        Berita::create([
            'judul' => 'Desa Penglipuran Implementasikan Sistem Pengelolaan Sampah Terpadu',
            'berita' => '<p>Desa Wisata Penglipuran terus berkomitmen menjaga lingkungan dengan mengimplementasikan Sistem Pengelolaan Sampah Terpadu (SPST) yang diresmikan bulan lalu. Sistem ini merupakan pengembangan dari program pengelolaan sampah yang sudah ada sebelumnya.</p>
            <p>SPST mencakup pemilahan sampah dari sumbernya, pengolahan sampah organik menjadi kompos, daur ulang sampah anorganik, dan edukasi tentang pengurangan sampah plastik. Desa Penglipuran juga telah memasang tempat sampah terpilah di beberapa titik strategis untuk memudahkan wisatawan membuang sampah sesuai jenisnya.</p>
            <p>"Sebagai desa wisata yang mendapatkan penghargaan desa terbersih, kami memiliki tanggung jawab untuk terus menjaga kebersihan dan kelestarian lingkungan. Sistem ini juga menjadi model pembelajaran bagi wisatawan yang berkunjung," ujar I Wayan Supat, Kepala Desa Penglipuran.</p>
            <p>Selain itu, Desa Penglipuran juga menggalakkan kampanye "Zero Waste Tourism" dengan mengajak wisatawan untuk membawa botol minum sendiri dan mengurangi penggunaan plastik sekali pakai selama berwisata di desa.</p>',
            'tgl_post' => Carbon::create(2025, 3, 18, 13, 10, 0),
            'id_kategori_berita' => 2,
            'foto' => 'pengelolaan_sampah.jpg',
        ]);

        Berita::create([
            'judul' => 'Kuliner Tradisional Penglipuran Masuk dalam 10 Kuliner Terbaik Bali versi Majalah Travel',
            'berita' => '<p>Kuliner tradisional Desa Penglipuran mendapat pengakuan internasional setelah masuk dalam daftar "10 Kuliner Terbaik Bali" versi majalah Travel International dalam edisi Maret 2025. Beberapa hidangan yang mendapat sorotan khusus adalah Lawar Penglipuran, Sate Lilit, dan minuman tradisional Loloh Cemcem.</p>
            <p>Dalam ulasannya, majalah tersebut memuji keotentikan rasa dan penggunaan bahan-bahan lokal yang segar dalam setiap hidangan. Lawar Penglipuran disebut memiliki cita rasa yang unik karena menggunakan rempah khas yang hanya tumbuh di sekitar desa.</p>
            <p>"Pengakuan ini adalah hadiah bagi para juru masak tradisional kami yang telah melestarikan resep turun-temurun selama bertahun-tahun. Ini juga menjadi motivasi bagi kami untuk terus mempromosikan kuliner tradisional sebagai bagian dari daya tarik wisata," kata Ni Wayan Sarni, Koordinator Kuliner Desa Penglipuran.</p>
            <p>Untuk merayakan prestasi ini, Desa Penglipuran berencana menggelar Festival Kuliner Tradisional pada bulan Juni mendatang, yang akan menampilkan demonstrasi memasak dan mencicipi berbagai hidangan khas desa.</p>',
            'tgl_post' => Carbon::create(2025, 3, 30, 9, 15, 0),
            'id_kategori_berita' => 3,
            'foto' => 'kuliner_tradisional.jpg',
        ]);
    }
}
