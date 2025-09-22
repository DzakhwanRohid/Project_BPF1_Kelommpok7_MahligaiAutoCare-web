<?php
// app/Views/layouts/admin_sidebar.php
// Sidebar navigasi khusus untuk halaman admin.

use App\Core\Application;
$base_url = Application::$app->getConfig('base_url');

// Dapatkan peran pengguna dari sesi
$current_role = Application::$app->getSessionManager()->getUserRole();
?>
<div class="bg-dark border-right" id="sidebar-wrapper">
    <div class="sidebar-heading text-white">Mahligai AutoCare Admin</div>
    <div class="list-group list-group-flush">
        <a href="<?= htmlspecialchars($base_url) ?>/admin/dashboard" class="list-group-item list-group-item-action"><i
                class="fas fa-fw fa-tachometer-alt"></i>Dashboard</a>
        <?php if ($current_role == 'admin1'): ?>
            <a href="<?= htmlspecialchars($base_url) ?>/admin/users" class="list-group-item list-group-item-action"><i
                    class="fas fa-fw fa-users"></i>Pengguna</a>
        <?php endif; ?>
        <?php if ($current_role == 'admin1' || $current_role == 'admin2'): ?>
            <a href="<?= htmlspecialchars($base_url) ?>/admin/bookings" class="list-group-item list-group-item-action"><i
                    class="fas fa-fw fa-calendar-alt"></i>Pemesanan</a>
        <?php endif; ?>
        <a href="<?= htmlspecialchars($base_url) ?>/admin/customers" class="list-group-item list-group-item-action"><i
                class="fas fa-fw fa-handshake"></i>Pelanggan</a>
        <a href="<?= htmlspecialchars($base_url) ?>/admin/services" class="list-group-item list-group-item-action"><i
                class="fas fa-fw fa-tools"></i>Layanan</a>
        <a href="<?= htmlspecialchars($base_url) ?>/admin/gallery" class="list-group-item list-group-item-action"><i
                class="fas fa-fw fa-images"></i>Galeri</a>
        <a href="<?= htmlspecialchars($base_url) ?>/admin/suggestions" class="list-group-item list-group-item-action"><i
                class="fas fa-fw fa-comments"></i>Saran & Keluhan</a>
        <a href="#reports-submenu" data-bs-toggle="collapse" aria-expanded="false"
            class="list-group-item list-group-item-action dropdown-toggle">
            <i class="fas fa-fw fa-chart-line"></i>Laporan
        </a>
        <div class="collapse" id="reports-submenu">
            <a href="<?= htmlspecialchars($base_url) ?>/admin/reports/bookings"
                class="list-group-item list-group-item-action ps-5"><i
                    class="fas fa-fw fa-file-invoice"></i>Pemesanan</a>
            <a href="<?= htmlspecialchars($base_url) ?>/admin/reports/service_stats"
                class="list-group-item list-group-item-action ps-5"><i class="fas fa-fw fa-chart-pie"></i>Statistik
                Layanan</a>
        </div>

        <a href="<?= htmlspecialchars($base_url) ?>/logout"
            class="list-group-item list-group-item-action text-danger"><i
                class="fas fa-fw fa-sign-out-alt"></i>Logout</a>
    </div>
</div>
<div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <div class="ms-auto me-3 d-flex align-items-center">
            <span class="text-dark me-2">Selamat datang, <span
                    class="fw-bold text-primary"><?= htmlspecialchars(Application::$app->getSessionManager()->get('username')) ?></span>!</span>
            <span class="badge bg-secondary">Peran:
                <?= htmlspecialchars(ucfirst(Application::$app->getSessionManager()->get('role'))) ?></span>
        </div>
    </nav>
    <div class="container-fluid main-content">