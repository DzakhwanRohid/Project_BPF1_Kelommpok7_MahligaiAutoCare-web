<?php
// app/Views/home/index.php
// Konten untuk halaman beranda.
// Variabel $base_url sudah tersedia dari layout.
// Variabel $services_list (jika diteruskan dari HomeController)
// Variabel $message, $message_type (jika diteruskan dari HomeController)
?>

<div class="header-carousel owl-carousel">
    <div class="header-carousel-item">
        <img src="<?= htmlspecialchars($base_url) ?>/img/bgpesan.jpg" class="img-fluid w-100" alt="Image">
        <div class="carousel-caption">
            <div class="carousel-content d-flex flex-column align-items-center justify-content-center">
                <h4 class="text-white mb-4 animated fadeInRight">Layanan Cuci Mobil Terbaik</h4>
                <h1 class="text-white display-1 mb-md-4 animated fadeInDown">Mahligai AutoCare</h1>
                <a href="<?= htmlspecialchars($base_url) ?>/book"
                    class="btn btn-primary rounded-pill text-white py-3 px-5 animated fadeInUp">Pesan Sekarang</a>
            </div>
        </div>
    </div>
    <div class="header-carousel-item">
        <img src="<?= htmlspecialchars($base_url) ?>/img/bgtentang.jpg" class="img-fluid w-100" alt="Image">
        <div class="carousel-caption">
            <div class="carousel-content d-flex flex-column align-items-center justify-content-center">
                <h4 class="text-white mb-4 animated fadeInRight">Solusi Cuci Mobil Terpercaya Anda</h4>
                <h1 class="text-white display-1 mb-md-4 animated fadeInDown">Kualitas & Kecepatan</h1>
                <a href="<?= htmlspecialchars($base_url) ?>/services"
                    class="btn btn-primary rounded-pill text-white py-3 px-5 animated fadeInUp">Lihat Layanan Kami</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid about py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-6 col-md-12 col-sm-12 wow fadeIn" data-wow-delay="0.2s">
                <img src="<?= htmlspecialchars($base_url) ?>/img/tentang_index.png" class="img-fluid rounded shadow"
                    alt="About Image">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 wow fadeIn" data-wow-delay="0.4s">
                <h4 class="text-primary border-bottom pb-4 mb-4">Tentang Kami</h4>
                <h1 class="display-3 mb-4">Solusi Cuci Mobil Terbaik di Kota Anda!</h1>
                <p class="mb-4">
                    Mahligai AutoCare adalah pusat layanan cuci mobil terkemuka yang berdedikasi untuk memberikan
                    kebersihan dan kilau maksimal pada kendaraan Anda. Kami menggunakan teknologi terkini dan produk
                    ramah lingkungan untuk memastikan setiap detail kendaraan Anda terawat dengan baik.
                </p>
                <div class="row g-4 text-center align-items-center">
                    <div class="col-4">
                        <div class="bg-primary p-4 rounded shadow-sm">
                            <i class="fa fa-2x fa-solid fa-car text-white"></i>
                            <h2 class="text-white my-2">1500+</h2>
                            <h6 class="text-white mb-0">Mobil Dicuci</h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-primary p-4 rounded shadow-sm">
                            <i class="fa fa-2x fa-users text-white"></i>
                            <h2 class="text-white my-2">1000+</h2>
                            <h6 class="text-white mb-0">Pelanggan Puas</h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-primary p-4 rounded shadow-sm">
                            <i class="fa fa-2x fa-award text-white"></i>
                            <h2 class="text-white my-2">20+</h2>
                            <h6 class="text-white mb-0">Penghargaan</h6>
                        </div>
                    </div>
                </div>
                <p class="my-4">
                    Kami bangga dengan tim profesional kami yang terlatih dan berdedikasi untuk memberikan layanan
                    terbaik. Dari cuci eksterior hingga detailing interior, kami memastikan setiap pekerjaan dilakukan
                    dengan standar kualitas tertinggi.
                </p>
                <p class="mb-4">
                    Kunjungi kami hari ini dan rasakan pengalaman cuci mobil yang berbeda!
                </p>
                <a href="<?= htmlspecialchars($base_url) ?>/about"
                    class="btn btn-primary rounded-pill text-white py-3 px-5">Baca Selengkapnya</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid service py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary border-bottom pb-4 mb-4">Layanan Cuci Mobil Kami</h4>
            <h1 class="display-3 mb-5">Kami Menyediakan Layanan Terbaik</h1>
            <p class="mb-0">
                Mahligai AutoCare menawarkan berbagai layanan cuci mobil yang komprehensif, disesuaikan untuk setiap
                kebutuhan kendaraan Anda. Dari kebersihan eksterior hingga detailing interior, kami memastikan setiap
                sudut mobil Anda bersih dan berkilau.
            </p>
        </div>
        <div class="row g-4">
            <?php if (!empty($services_list)): ?>
                <?php
                $delay_start = 0.3;
                foreach ($services_list as $index => $service):
                    $delay = $delay_start + ($index % 3) * 0.2;
                    ?>
                    <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="<?= number_format($delay, 1) ?>s">
                        <div
                            class="service-item bg-light rounded overflow-hidden shadow-sm h-100 d-flex flex-column text-center">
                            <div class="p-4 flex-grow-1 d-flex flex-column align-items-center justify-content-center">
                                <div class="feature-icon mb-4 d-inline-flex align-items-center justify-content-center p-3 rounded-circle"
                                    style="background-color: #E6F2FF; width: 80px; height: 80px;">
                                    <i
                                        class="<?= htmlspecialchars($service['icon_class'] ?? 'fas fa-car') ?> text-primary fa-2x"></i>
                                </div>

                                <h5 class="mb-2 text-dark"><?= htmlspecialchars($service['service_name']) ?></h5>
                                <p class="mb-3 text-primary fw-bold fs-4">Rp
                                    <?= number_format($service['price'], 0, ',', '.') ?></p>
                                <p class="text-muted small mb-3 flex-grow-1">
                                    <?= htmlspecialchars($service['description']) ?>
                                </p>

                                <div class="mt-auto text-center">
                                    <a class="btn btn-primary rounded-pill px-4 py-2"
                                        href="<?= htmlspecialchars($base_url) ?>/book">
                                        Pesan Sekarang <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-muted">Tidak ada layanan yang tersedia saat ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="container-fluid feature py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary border-bottom pb-4 mb-4">Fitur Terbaik Kami</h4>
            <h1 class="display-3 mb-5">Kenapa Memilih Mahligai AutoCare?</h1>
            <p class="mb-0">
                Kami menawarkan berbagai fitur unggulan untuk memastikan pengalaman cuci mobil Anda nyaman, efisien, dan
                hasilnya memuaskan.
            </p>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-lg-4">
                <div class="row g-4">
                    <div class="col-12 wow fadeIn" data-wow-delay="0.3s">
                        <div class="feature-item bg-white rounded p-4 shadow-sm h-100 text-center"
                            style="cursor: pointer; transform: translateY(0); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;">
                            <div class="feature-icon mb-4 d-inline-flex align-items-center justify-content-center p-3 rounded-circle"
                                style="background-color: #E6F2FF; width: 80px; height: 80px;">
                                <i class="fas fa-wifi text-primary fa-2x"></i>
                            </div>
                            <h4 class="mb-2 text-dark">Free Wifi</h4>
                            <p class="text-muted mb-0">Tetap terhubung sambil menunggu mobil Anda dicuci dengan
                                fasilitas Wi-Fi gratis kami.</p>
                        </div>
                    </div>
                    <div class="col-12 wow fadeIn" data-wow-delay="0.5s">
                        <div class="feature-item bg-white rounded p-4 shadow-sm h-100 text-center"
                            style="cursor: pointer; transform: translateY(0); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;">
                            <div class="feature-icon mb-4 d-inline-flex align-items-center justify-content-center p-3 rounded-circle"
                                style="background-color: #E6F2FF; width: 80px; height: 80px;">
                                <i class="fas fa-wrench text-primary fa-2x"></i>
                            </div>
                            <h4 class="mb-2 text-dark">Hydrolic System</h4>
                            <p class="mb-0 text-muted">Peralatan hidrolik modern kami memastikan proses pencucian kolong
                                mobil yang menyeluruh dan aman.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                <div class="feature-img">
                    <img src="<?= htmlspecialchars($base_url) ?>/img/fitur_index.jpg" class="img-fluid rounded shadow"
                        alt="Features Image">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row g-4">
                    <div class="col-12 wow fadeIn" data-wow-delay="0.4s">
                        <div class="feature-item bg-white rounded p-4 shadow-sm h-100 text-center"
                            style="cursor: pointer; transform: translateY(0); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;">
                            <div class="feature-icon mb-4 d-inline-flex align-items-center justify-content-center p-3 rounded-circle"
                                style="background-color: #E6F2FF; width: 80px; height: 80px;">
                                <i class="fas fa-snowflake text-primary fa-2x"></i>
                            </div>
                            <h4 class="mb-2 text-dark">Waiting Room AC</h4>
                            <p class="text-muted mb-0">Nikmati kenyamanan ruang tunggu ber-AC kami sementara mobil Anda
                                sedang dibersihkan.</p>
                        </div>
                    </div>
                    <div class="col-12 wow fadeIn" data-wow-delay="0.6s">
                        <div class="feature-item bg-white rounded p-4 shadow-sm h-100 text-center"
                            style="cursor: pointer; transform: translateY(0); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;">
                            <div class="feature-icon mb-4 d-inline-flex align-items-center justify-content-center p-3 rounded-circle"
                                style="background-color: #E6F2FF; width: 80px; height: 80px;">
                                <i class="fas fa-soap text-primary fa-2x"></i>
                            </div>
                            <h4 class="mb-2 text-dark">Snow Wash</h4>
                            <p class="mb-0 text-muted"> Rasakan sensasi dan keefektifan metode snow wash yang
                                menghasilkan busa tebal untuk membersihkan mobil Anda secara maksimal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary border-bottom pb-4 mb-4">Testimonial Kami</h4>
            <h1 class="display-3 mb-5">Apa Kata Klien Kami</h1>
            <p class="mb-0">
                Baca ulasan dari pelanggan kami yang puas dan bagaimana Mahligai AutoCare telah melampaui harapan mereka
                dalam layanan cuci mobil.
            </p>
        </div>
        <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.3s">
            <div class="testimonial-item p-4 pb-0">
                <div class="testimonial-inner rounded p-5 text-center position-relative"
                    style="background-color: #f8f9fa; transform: translateY(0); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;">
                    <i class="fa fa-quote-left text-primary opacity-25 position-absolute top-0 start-0 translate-middle-x"
                        style="font-size: 5rem; z-index: 0;"></i>
                    <div class="testimonial-comment mb-4 position-relative" style="z-index: 1;">
                        <p class="text-dark">
                            "Layanan cuci mobil terbaik yang pernah saya coba! Mobil saya selalu bersih dan berkilau
                            seperti baru. Sangat direkomendasikan!"
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-center pt-3 mt-3">
                        <img src="<?= htmlspecialchars($base_url) ?>/img/testimoni_index.jpg"
                            class="img-fluid rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;"
                            alt="Gambar Testimonial 1">
                        <div>
                            <h5 class="mb-1 text-dark">M.Ghiffari Zarnouval</h5>
                            <p class="m-0 text-muted">Mahasiswa</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-item p-4 pb-0">
                <div class="testimonial-inner rounded p-5 text-center position-relative"
                    style="background-color: #f8f9fa; transform: translateY(0); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;">
                    <i class="fa fa-quote-left text-primary opacity-25 position-absolute top-0 start-0 translate-middle-x"
                        style="font-size: 5rem; z-index: 0;"></i>
                    <div class="testimonial-comment mb-4 position-relative" style="z-index: 1;">
                        <p class="text-dark">
                            "Tim yang sangat profesional dan efisien. Mobil saya selesai dalam waktu singkat tanpa
                            mengurangi kualitas. Terima kasih FRCaMahligai AutoCarerWash!"
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-center pt-3 mt-3">
                        <img src="<?= htmlspecialchars($base_url) ?>/img/testimoni_index2.jpg"
                            class="img-fluid rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;"
                            alt="Gambar Testimonial 2">
                        <div>
                            <h5 class="mb-1 text-dark">Fadly Nugraha</h5>
                            <p class="m-0 text-muted">Pengusaha</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-item p-4 pb-0">
                <div class="testimonial-inner rounded p-5 text-center position-relative"
                    style="background-color: #f8f9fa; transform: translateY(0); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;">
                    <i class="fa fa-quote-left text-primary opacity-25 position-absolute top-0 start-0 translate-middle-x"
                        style="font-size: 5rem; z-index: 0;"></i>
                    <div class="testimonial-comment mb-4 position-relative" style="z-index: 1;">
                        <p class="text-dark">
                            "Saya terkesan dengan perhatian terhadap detail. Interior mobil saya tidak pernah sebersih
                            ini. Pasti akan kembali lagi!"
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-center pt-3 mt-3">
                        <img src="<?= htmlspecialchars($base_url) ?>/img/testimoni_index3.webp"
                            class="img-fluid rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;"
                            alt="Gambar Testimonial 3">
                        <div>
                            <h5 class="mb-1 text-dark">Kafi Kurnia</h5>
                            <p class="m-0 text-muted">Mahasiswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid blog py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary border-bottom pb-4 mb-4">Blog Terbaru Kami</h4>
            <h1 class="display-3 mb-5">Baca Artikel & Berita Terbaru</h1>
            <p class="mb-0">
                Ikuti blog kami untuk tips perawatan mobil, berita terbaru tentang industri, dan penawaran eksklusif
                dari Mahligai AutoCare.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="0.3s">
                <div class="blog-item rounded overflow-hidden shadow-sm h-100">
                    <div class="blog-img position-relative overflow-hidden">
                        <img src="<?= htmlspecialchars($base_url) ?>/img/blog1.jpg" class="img-fluid w-100"
                            alt="Blog Image 1" style="object-fit: cover; height: 250px;">
                        <div class="blog-info position-absolute top-0 start-0 w-100 py-2 px-3 d-flex justify-content-between align-items-center text-white"
                            style="background: rgba(0,0,0,0.5);">
                            <span><i class="fa fa-calendar me-2"></i> 22 Sep 2022</span>
                        </div>
                    </div>
                    <div class="blog-content p-4">
                        <a href="https://www.hyundai.com/id/id/hyundai-story/articles/cara-merawat-cat-mobil-agar-tetap-mengkilat-0000000205"
                            class="h4 text-dark mb-3 d-block">Tips Merawat Cat Mobil Agar Aman</a>
                        <p class="mt-3 text-muted">
                            Pelajari cara menjaga cat mobil Anda tetap berkilau dan terlindungi dari kerusakan.
                        </p>
                        <a href="https://www.hyundai.com/id/id/hyundai-story/articles/cara-merawat-cat-mobil-agar-tetap-mengkilat-0000000205"
                            class="btn btn-primary rounded-pill text-white py-2 px-4">Baca Lebih Lanjut</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="0.5s">
                <div class="blog-item rounded overflow-hidden shadow-sm h-100">
                    <div class="blog-img position-relative overflow-hidden">
                        <img src="<?= htmlspecialchars($base_url) ?>/img/blog2.jpg" class="img-fluid w-100"
                            alt="Blog Image 2" style="object-fit: cover; height: 250px;">
                        <div class="blog-info position-absolute top-0 start-0 w-100 py-2 px-3 d-flex justify-content-between align-items-center text-white"
                            style="background: rgba(0,0,0,0.5);">
                            <span><i class="fa fa-calendar me-2"></i> 31 Jul 2023</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <a href="https://www.carwash.com/benefits-professional-car-detailing/"
                            class="h4 text-dark mb-3 d-block">Manfaat Detailing Interior Profesional</a>
                        <p class="mt-3 text-muted">
                            Mengapa detailing interior penting untuk kenyamanan dan nilai jual mobil Anda.
                        </p>
                        <a href="https://www.carwash.com/benefits-professional-car-detailing/"
                            class="btn btn-primary rounded-pill text-white py-2 px-4">Baca Lebih Lanjut</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="0.7s">
                <div class="blog-item rounded overflow-hidden shadow-sm h-100">
                    <div class="blog-img position-relative overflow-hidden">
                        <img src="<?= htmlspecialchars($base_url) ?>/img/blog3.jpg" class="img-fluid w-100"
                            alt="Blog Image 3" style="object-fit: cover; height: 250px;">
                        <div class="blog-info position-absolute top-0 start-0 w-100 py-2 px-3 d-flex justify-content-between align-items-center text-white"
                            style="background: rgba(0,0,0,0.5);">
                            <span><i class="fa fa-calendar me-2"></i> 28 Jul 2022</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <a href="https://moservice.id/news/manfaat-nano-ceramic-coating-dan-proses-melakukannya"
                            class="h4 text-dark mb-3 d-block">Panduan Lengkap Ceramic Coating</a>
                        <p class="mt-3 text-muted">
                            Segala yang perlu Anda ketahui tentang perlindungan cat canggih ini.
                        </p>
                        <a href="https://moservice.id/news/manfaat-nano-ceramic-coating-dan-proses-melakukannya"
                            class="btn btn-primary rounded-pill text-white py-2 px-4">Baca Lebih Lanjut</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid contact py-5" style="background-color: #f8f9fa;">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary border-bottom pb-4 mb-4">Hubungi Kami</h4>
            <h1 class="display-3 mb-5">Jangan Ragu untuk Menghubungi Kami</h1>
            <p class="mb-0">
                Kami siap membantu Anda dengan pertanyaan, saran, atau keluhan. Isi formulir di bawah atau hubungi kami
                langsung.
            </p>
        </div>
        <div class="row g-5 justify-content-center">
            <div class="col-xl-6 wow fadeIn" data-wow-delay="0.3s">
                <div class="contact-detail-map h-100 rounded shadow-lg overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.65868612161!2d101.46497787496472!3d0.522222199616856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ac1a27315575%3A0x296fdc7322314a5b!2sMahligai%20Autocare!5e0!3m2!1sen!2sid!4v1720158863266!5m2!1sen!2sid"
                        class="w-100 h-100" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="col-xl-6 wow fadeIn" data-wow-delay="0.5s">
                <div class="p-5 bg-light rounded shadow-lg h-100"> <?php if (isset($message) && !empty($message)): ?>
                        <div class="alert alert-<?= htmlspecialchars($message_type) ?> alert-dismissible fade show"
                            role="alert">
                            <?= htmlspecialchars($message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form action="<?= htmlspecialchars($base_url) ?>/contact" method="POST">
                        <div class="row g-4">
                            <div class="col-12">
                                <label for="name" class="form-label">Nama Anda</label>
                                <input type="text" id="name" class="form-control p-3 border-0 bg-white" name="name"
                                    placeholder="Nama Lengkap" value="<?= htmlspecialchars($input_name ?? '') ?>"
                                    required>
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email Anda</label>
                                <input type="email" id="email" class="form-control p-3 border-0 bg-white" name="email"
                                    placeholder="email@example.com" value="<?= htmlspecialchars($input_email ?? '') ?>"
                                    required>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subjek</label>
                                <input type="text" id="subject" class="form-control p-3 border-0 bg-white"
                                    name="subject" placeholder="Subjek Pesan" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Pesan Anda</label>
                                <textarea class="w-100 form-control p-3 border-0 bg-white" id="message" name="message"
                                    rows="6" placeholder="Tuliskan pesan Anda di sini" required></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary border-0 w-100 py-3 rounded-pill" type="submit">Kirim
                                    Pesan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>