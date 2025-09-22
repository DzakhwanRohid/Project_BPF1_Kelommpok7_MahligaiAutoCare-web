<?php
use App\Core\Application;
$base_url = Application::$app->getConfig('base_url');
if (!isset($currentPath)) {
    $currentPath = Application::$app->getRequest()->getPath();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Mahligai AutoCare - Layanan Cuci Mobil Profesional</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="cuci mobil, detailing mobil, pencucian mobil, pembersihan kendaraan, cuci eksterior, pembersihan interior, ceramic coating, wax dan poles" name="keywords">
    <meta content="Mahligai AutoCare menyediakan layanan cuci mobil profesional dengan hasil bersih maksimal." name="description">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="<?= htmlspecialchars($base_url) ?>/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?= htmlspecialchars($base_url) ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?= htmlspecialchars($base_url) ?>/lib/lightbox/css/lightbox.min.css" rel="stylesheet">


    <link href="<?= htmlspecialchars($base_url) ?>/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?= htmlspecialchars($base_url) ?>/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid bg-dark px-5 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-twitter fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-facebook-f fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-linkedin-in fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-instagram fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-youtube fw-normal"></i></a>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <?php if (Application::$app->getSessionManager()->isLoggedIn()): ?>
                        <?php if (Application::$app->getSessionManager()->isAdmin('admin1') || Application::$app->getSessionManager()->isAdmin('admin2')): ?>
                            <a href="<?= htmlspecialchars($base_url) ?>/admin/dashboard" class="me-3 text-light <?= ($currentPath === '/admin/dashboard') ? 'active' : '' ?>">Dashboard Admin</a>
                        <?php else: ?>
                            <a href="<?= htmlspecialchars($base_url) ?>/user_bookings" class="me-3 text-light <?= ($currentPath === '/user_bookings') ? 'active' : '' ?>">Pemesanan Saya</a>
                        <?php endif; ?>
                        <a href="<?= htmlspecialchars($base_url) ?>/logout" class="me-3 text-light">Logout (<?= htmlspecialchars(Application::$app->getSessionManager()->get('username')) ?>)</a>
                    <?php else: ?>
                        <a href="<?= htmlspecialchars($base_url) ?>/login" class="me-3 text-light <?= ($currentPath === '/login') ? 'active' : '' ?>">Login</a>
                        <a href="<?= htmlspecialchars($base_url) ?>/register" class="me-3 text-light <?= ($currentPath === '/register') ? 'active' : '' ?>">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
            <a href="<?= htmlspecialchars($base_url) ?>/" class="navbar-brand p-0">
                <h1 class="text-primary m-0"><i class="fas fa-car-wash me-2"></i>Mahligai AutoCare</h1>
                </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="<?= htmlspecialchars($base_url) ?>/" class="nav-item nav-link <?= ($currentPath === '/') ? 'active' : '' ?>">Beranda</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/about" class="nav-item nav-link <?= ($currentPath === '/about') ? 'active' : '' ?>">Tentang</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/services" class="nav-item nav-link <?= ($currentPath === '/services') ? 'active' : '' ?>">Layanan</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/feature" class="nav-item nav-link <?= ($currentPath === '/feature') ? 'active' : '' ?>">Fitur</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/team" class="nav-item nav-link <?= ($currentPath === '/team') ? 'active' : '' ?>">Galeri Foto</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/testimonial" class="nav-item nav-link <?= ($currentPath === '/testimonial') ? 'active' : '' ?>">Testimonial</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/blog" class="nav-item nav-link <?= ($currentPath === '/blog') ? 'active' : '' ?>">Blog</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/contact" class="nav-item nav-link <?= ($currentPath === '/contact') ? 'active' : '' ?>">Kontak</a>
                </div>
                <a href="<?= htmlspecialchars($base_url) ?>/book" class="btn btn-primary rounded-pill text-white py-2 px-4 flex-wrap flex-sm-shrink-0">Pesan Sekarang</a>
            </div>
        </nav>
    </div>
    ```