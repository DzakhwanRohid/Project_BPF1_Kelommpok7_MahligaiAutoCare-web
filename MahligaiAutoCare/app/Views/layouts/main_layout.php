<?php
// app/Views/layouts/main_layout.php
// Layout utama untuk semua halaman publik.

use App\Core\Application;

// Menginclude header (berisi <head>, <body> pembuka, topbar, navbar)
include_once __DIR__ . '/header.php';

// Kondisi untuk menampilkan page_header.php
// Hanya tampilkan jika bukan halaman beranda (index) dan bukan halaman admin
// (halaman login/register sudah menggunakan auth_layout, jadi tidak perlu dicek di sini)
$current_path = Application::$app->getRequest()->path;
$is_home_page = ($current_path === '/');
$is_admin_page = (strpos($current_path, '/admin') === 0);

if (!$is_home_page && !$is_admin_page) {
    // Pastikan $page_title dan $breadcrumb_items sudah ada di scope karena extract($params) di Controller
    // Controller yang merender view harus menyediakan variabel ini.
    if (isset($page_title) && isset($breadcrumb_items)) {
        include_once __DIR__ . '/page_header.php';
    }
}
?>

<main>
    <?php
    // Ini adalah tempat konten view (home/index.php, home/about.php, dll.) akan di-inject
    // $content sudah disediakan oleh Controller::render
    echo $content;
    ?>
</main>

<?php
// Menginclude footer (berisi footer HTML dan penutup </body> </html>)
include_once __DIR__ . '/footer.php';
?>