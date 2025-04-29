{{-- home / About.blade.php --}}

@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection
@section('content')

<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('front-end/images/lsp/wisata/jalanan utama/00.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
        <div class="col-md-9 text-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
          <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="{{route('pelanggan.index')}}">{{$title}}</a></span>| <span>{{$title2}}</span></p>
          <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Tentang Kami</h1>
        </div>
      </div>
    </div>
  </div>

<section class="ftco-section">
    <div class="container">
        <div class="row d-md-flex">
            <div class="col-md-6 ftco-animate img about-image" style="background-image: url({{asset('front-end/images/about.jpg')}});">
            </div>
            <div class="col-md-6 ftco-animate p-md-5">
                <div class="row">
              <div class="col-md-12 nav-link-wrap mb-5">
                <div class="nav ftco-animate nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="v-pills-whatwedo-tab" data-toggle="pill" href="#v-pills-whatwedo" role="tab" aria-controls="v-pills-whatwedo" aria-selected="true">Apa yang Kami Lakukan</a>

                  <a class="nav-link" id="v-pills-mission-tab" data-toggle="pill" href="#v-pills-mission" role="tab" aria-controls="v-pills-mission" aria-selected="false">Misi</a>

                  <a class="nav-link" id="v-pills-goal-tab" data-toggle="pill" href="#v-pills-goal" role="tab" aria-controls="v-pills-goal" aria-selected="false">Tujuan</a>
                </div>
              </div>
              <div class="col-md-12 d-flex align-items-center">

                <div class="tab-content ftco-animate" id="v-pills-tabContent">

                  <div class="tab-pane fade show active" id="v-pills-whatwedo" role="tabpanel" aria-labelledby="v-pills-whatwedo-tab">
                      <div>
                        <h2 class="mb-4">Mempromosikan Desa Penglipuran</h2>
                          <p>PesonaDesa hadir untuk memperkenalkan keindahan Desa Penglipuran kepada dunia. Melalui platform kami, wisatawan dapat dengan mudah menemukan, menjelajahi, dan memesan berbagai pengalaman wisata yang ditawarkan oleh desa wisata ini.</p>
                        <p>Kami menghubungkan wisatawan dengan penginapan lokal, pemandu wisata berpengalaman, dan berbagai paket wisata yang dirancang untuk memberikan pengalaman otentik di Desa Penglipuran.</p>
                        </div>
                  </div>

                  <div class="tab-pane fade" id="v-pills-mission" role="tabpanel" aria-labelledby="v-pills-mission-tab">
                    <div>
                        <h2 class="mb-4">Pemberdayaan Masyarakat Lokal</h2>
                          <p>Misi kami adalah mempromosikan pariwisata berkelanjutan yang memberdayakan masyarakat lokal dan melestarikan budaya tradisional Desa Penglipuran. Kami berkomitmen untuk memastikan bahwa manfaat ekonomi dari pariwisata dapat dirasakan langsung oleh penduduk desa.</p>
                        <p>Melalui platform kami, kami mendukung usaha lokal seperti penginapan, kuliner, dan kerajinan tangan, sambil memberikan pengalaman wisata yang otentik dan berkesan bagi pengunjung.</p>
                        </div>
                  </div>

                  <div class="tab-pane fade" id="v-pills-goal" role="tabpanel" aria-labelledby="v-pills-goal-tab">
                    <div>
                        <h2 class="mb-4">Pelestarian Budaya dan Alam</h2>
                          <p>Tujuan utama kami adalah mempromosikan pariwisata yang bertanggung jawab dan berkelanjutan di Desa Penglipuran. Kami ingin memastikan bahwa warisan budaya dan keindahan alam desa tetap terjaga sambil memberikan manfaat ekonomi bagi masyarakat lokal.</p>
                        <p>Kami berkomitmen untuk mengedukasi wisatawan tentang pentingnya menjaga kelestarian lingkungan dan menghormati budaya lokal saat mereka mengeksplorasi keindahan Desa Penglipuran.</p>
                        </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-start mb-5 pb-3">
      <div class="col-md-7 heading-section ftco-animate">
          <span class="subheading">FAQ</span>
        <h2 class="mb-4"><strong>Pertanyaan</strong> yang Sering Diajukan</h2>
      </div>
    </div>
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div id="accordion">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                            <div class="card-header">
                                      <a class="card-link" data-toggle="collapse"  href="#menuone" aria-expanded="true" aria-controls="menuone">Bagaimana cara memesan paket wisata di PesonaDesa? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
                            </div>
                            <div id="menuone" class="collapse show">
                              <div class="card-body">
                                            <p>Untuk memesan paket wisata di PesonaDesa, cukup kunjungi halaman "Paket Wisata" di website kami, pilih paket yang sesuai dengan keinginan Anda, lalu klik tombol "Pesan". Isi formulir pemesanan dengan informasi yang diperlukan, dan konfirmasi pembayaran Anda. Setelah pembayaran dikonfirmasi, tim kami akan menghubungi Anda untuk memberikan detail lebih lanjut tentang perjalanan Anda.</p>
                              </div>
                            </div>
                          </div>

                          <div class="card">
                            <div class="card-header">
                                      <a class="card-link" data-toggle="collapse"  href="#menutwo" aria-expanded="false" aria-controls="menutwo">Apa saja yang termasuk dalam paket wisata? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
                            </div>
                            <div id="menutwo" class="collapse">
                              <div class="card-body">
                                            <p>Setiap paket wisata yang kami tawarkan mencakup transportasi lokal, pemandu wisata berpengalaman, tiket masuk ke objek wisata, dan beberapa paket termasuk makan sesuai dengan detail yang tercantum. Beberapa paket juga menyertakan penginapan dan pengalaman khusus seperti workshop kerajinan tradisional atau pertunjukan budaya. Detail lengkap setiap paket dapat dilihat pada halaman deskripsi paket.</p>
                              </div>
                            </div>
                          </div>

                          <div class="card">
                            <div class="card-header">
                                      <a class="card-link" data-toggle="collapse"  href="#menu3" aria-expanded="false" aria-controls="menu3">Kapan waktu terbaik untuk mengunjungi Desa Penglipuran? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
                            </div>
                            <div id="menu3" class="collapse">
                              <div class="card-body">
                                            <p>Desa Penglipuran dapat dikunjungi sepanjang tahun, namun waktu terbaik adalah pada musim kemarau (April hingga Oktober) karena cuaca yang lebih cerah dan kering. Jika Anda ingin menyaksikan festival budaya dan upacara adat, ada beberapa perayaan khusus sepanjang tahun yang bisa Anda tanyakan kepada tim kami untuk mendapatkan informasi lebih lanjut tentang jadwal acara-acara tersebut.</p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                            <div class="card-header">
                                      <a class="card-link" data-toggle="collapse"  href="#menu4" aria-expanded="false" aria-controls="menu4">Apakah ada pemandu wisata lokal yang tersedia? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
                            </div>
                            <div id="menu4" class="collapse">
                              <div class="card-body">
                                            <p>Ya, kami menyediakan pemandu wisata lokal yang merupakan penduduk asli Desa Penglipuran. Mereka memiliki pengetahuan mendalam tentang sejarah, budaya, dan tradisi desa, serta dapat berbagi cerita dan pengalaman unik yang tidak akan Anda dapatkan dari buku panduan wisata biasa. Pemandu kami juga fasih dalam beberapa bahasa untuk memudahkan komunikasi dengan wisatawan internasional.</p>
                              </div>
                            </div>
                          </div>

                          <div class="card">
                            <div class="card-header">
                                      <a class="card-link" data-toggle="collapse"  href="#menu5" aria-expanded="false" aria-controls="menu5">Bagaimana kebijakan pembatalan reservasi? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
                            </div>
                            <div id="menu5" class="collapse">
                              <div class="card-body">
                                            <p>Untuk pembatalan yang dilakukan minimal 7 hari sebelum tanggal kedatangan, kami memberikan pengembalian dana sebesar 80%. Pembatalan 3-6 hari sebelum kedatangan akan mendapatkan pengembalian dana sebesar 50%. Sedangkan pembatalan kurang dari 3 hari sebelum kedatangan, tidak mendapatkan pengembalian dana. Untuk kasus khusus seperti sakit atau keadaan darurat, silakan hubungi tim kami untuk penanganan lebih lanjut.</p>
                              </div>
                            </div>
                          </div>

                          <div class="card">
                            <div class="card-header">
                                      <a class="card-link" data-toggle="collapse"  href="#menu6" aria-expanded="false" aria-controls="menu6">Apa saja keunikan Desa Penglipuran yang tidak boleh dilewatkan? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
                            </div>
                            <div id="menu6" class="collapse">
                              <div class="card-body">
                                            <p>Desa Penglipuran terkenal dengan arsitektur tradisional yang seragam, kebersihan lingkungan, dan tatanan desa yang rapi. Jangan lewatkan untuk mengunjungi gerbang angkul-angkul yang menjadi ciri khas rumah tradisional, menjelajahi hutan bambu di ujung desa, mencicipi kuliner tradisional seperti lawar dan babi guling, serta berinteraksi langsung dengan penduduk lokal untuk mempelajari kehidupan sehari-hari mereka dan kearifan lokal yang masih terjaga hingga saat ini.</p>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
