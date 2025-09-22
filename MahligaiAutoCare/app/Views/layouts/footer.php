<?php
// app/Views/layouts/footer.php
// Footer umum untuk semua halaman publik.

use App\Core\Application;
$base_url = Application::$app->getConfig('base_url');
?>
<!-- Footer Start -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item">
                    <h4 class="text-white mb-4"><i class="fas fa-car-wash me-2"></i>Mahligai AutoCare</h4>
                    <p class="mb-3">
                        Kami adalah penyedia layanan cuci mobil profesional yang berkomitmen untuk memberikan hasil terbaik dan kepuasan pelanggan.
                    </p>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        <p class="text-white mb-0">Jl. Tiram, Lb. Lizza, Kecamatan Bukit Raya, Kota Pekanbaru, Riau.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        <p class="text-white mb-0">mahligaiautocare@gmail.com</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-phone text-primary me-2"></i>
                        <p class="text-white mb-0">081213141516</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item">
                    <h4 class="text-white mb-4">Layanan Kami</h4>
                    <a href="<?= htmlspecialchars($base_url) ?>/services" class="btn-link"><i class="fas fa-angle-right me-2"></i> Cuci Mobil Kecil</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/services" class="btn-link"><i class="fas fa-angle-right me-2"></i> Cuci Mobil Besar</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/services" class="btn-link"><i class="fas fa-angle-right me-2"></i> Cuci Motor</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/services" class="btn-link"><i class="fas fa-angle-right me-2"></i> Cuci Karpet</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/services" class="btn-link"><i class="fas fa-angle-right me-2"></i> Cuci Standar</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/services" class="btn-link"><i class="fas fa-angle-right me-2"></i> Cuci Lengkap</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/services" class="btn-link"><i class="fas fa-angle-right me-2"></i> Cuci Kilat</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/services" class="btn-link"><i class="fas fa-angle-right me-2"></i> Detailing Premium Mobil</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item">
                    <h4 class="text-white mb-4">Link Cepat</h4>
                    <a href="<?= htmlspecialchars($base_url) ?>/about" class="btn-link"><i class="fas fa-angle-right me-2"></i> Tentang </a>
                    <a href="<?= htmlspecialchars($base_url) ?>/contact" class="btn-link"><i class="fas fa-angle-right me-2"></i> Kontak </a>
                    <a href="<?= htmlspecialchars($base_url) ?>/feature" class="btn-link"><i class="fas fa-angle-right me-2"></i> Fitur</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/team" class="btn-link"><i class="fas fa-angle-right me-2"></i> Tim Kami</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/testimonial" class="btn-link"><i class="fas fa-angle-right me-2"></i> Testimonial</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/blog" class="btn-link"><i class="fas fa-angle-right me-2"></i> Blog</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item">
                    <h4 class="text-white mb-4">Berita Terbaru</h4>
                    <p class="mb-3">
                        Dapatkan berita dan penawaran terbaru langsung.
                    </p>
                    <div class="position-relative mx-auto">
                         <a href="<?= htmlspecialchars($base_url) ?>/blog" class="btn-link"><button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Lihat</button></i> Blog</a>
   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright py-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-6 text-center text-md-start mb-md-0">
                <span class="text-white"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Mahligai AutoCare</a>, Semua hak dilindungi undang-undang.</span>
            </div>
            <div class="col-md-6 text-center text-md-end text-white">
                Dirancang Oleh <a class="border-bottom" href="https://htmlcodex.com">Dzakhwan_Rohid</a> Didistribusikan Oleh <a class="border-bottom" href="https://themewagon.com">Politeknik Caltex Riau</a>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= htmlspecialchars($base_url) ?>/lib/wow/wow.min.js"></script>
<script src="<?= htmlspecialchars($base_url) ?>/lib/easing/easing.min.js"></script>
<script src="<?= htmlspecialchars($base_url) ?>/lib/waypoints/waypoints.min.js"></script>
<script src="<?= htmlspecialchars($base_url) ?>/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="<?= htmlspecialchars($base_url) ?>/lib/lightbox/js/lightbox.min.js"></script>

<!-- Template Javascript -->
<script src="<?= htmlspecialchars($base_url) ?>/js/main.js"></script>

<script>
    (function ($) {
        "use strict";

        // Initiate the wowjs
        new WOW().init();

        // Back to top button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('.back-to-top').fadeIn('slow');
            } else {
                $('.back-to-top').fadeOut('slow');
            }
        });
        $('.back-to-top').click(function () {
            $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
            return false;
        });

        // Testimonial carousel
        $(".testimonial-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1500,
            center: false,
            dots: true,
            loop: true,
            margin: 25,
            nav : true,
            navText : [
                '<i class="bi bi-arrow-left"></i>',
                '<i class="bi bi-arrow-right"></i>'
            ],
            responsiveClass: true,
            responsive: {
                0:{
                    items:1
                },
                576: {
                    items:1
                },
                768: {
                    items:2
                },
                992: {
                    items:2
                },
                1200: {
                    items:2
                }
            }
        });
    })(jQuery);
</script>
</body>
</html>
