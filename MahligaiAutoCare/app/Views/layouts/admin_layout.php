<?php
use App\Core\Application; 
include_once __DIR__ . '/admin_header.php';
include_once __DIR__ . '/admin_sidebar.php';
echo $content;
?>
</div> </div> <?php include_once __DIR__ . '/modal_access_denied.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script src="<?= htmlspecialchars(Application::$app->getConfig('base_url')) ?>/lib/wow/wow.min.js"></script>
<script src="<?= htmlspecialchars(Application::$app->getConfig('base_url')) ?>/lib/easing/easing.min.js"></script>
<script src="<?= htmlspecialchars(Application::$app->getConfig('base_url')) ?>/lib/waypoints/waypoints.min.js"></script>
<script src="<?= htmlspecialchars(Application::$app->getConfig('base_url')) ?>/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="<?= htmlspecialchars(Application::$app->getConfig('base_url')) ?>/lib/tempusdominus/js/moment.min.js"></script>
<script src="<?= htmlspecialchars(Application::$app->getConfig('base_url')) ?>/lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="<?= htmlspecialchars(Application::$app->getConfig('base_url')) ?>/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>


<script src="<?= htmlspecialchars(Application::$app->getConfig('base_url')) ?>/js/main.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi WOW.js untuk animasi
        new WOW().init();

        var sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function (e) {
                e.preventDefault();
                document.getElementById('wrapper').classList.toggle('toggled');
            });
        }

        // Handle flash messages using JavaScript if needed, or rely on PHP rendering
        <?php
        $flash_error_message = Application::$app->getSessionManager()->getFlash('error');
        $flash_success_message = Application::$app->getSessionManager()->getFlash('success'); // Tambahkan ini jika ada success flash
        $flash_warning_message = Application::$app->getSessionManager()->getFlash('warning'); // Tambahkan ini jika ada warning flash
        $flash_info_message = Application::$app->getSessionManager()->getFlash('info'); // Tambahkan ini jika ada info flash

        if ($flash_error_message): ?>
            // Tampilkan alert untuk flash message error
            // Periksa apakah ada elemen alert di halaman (contoh: di dashboard.php)
            // Jika tidak ada, buat secara dinamis
            var existingAlert = document.querySelector('.alert.alert-danger');
            if (!existingAlert) {
                var dynamicAlert = document.createElement('div');
                dynamicAlert.className = 'alert alert-danger alert-dismissible fade show animated fadeInDown';
                dynamicAlert.setAttribute('role', 'alert');
                dynamicAlert.innerHTML = '<?= htmlspecialchars($flash_error_message['message']) ?>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                var mainContent = document.querySelector('#page-content-wrapper .container-fluid, #page-content-wrapper');
                if (mainContent) {
                    mainContent.prepend(dynamicAlert);
                }
            }
            console.error("Flash Error: <?= htmlspecialchars($flash_error_message['message']) ?>");
        <?php endif; ?>

        <?php if ($flash_success_message): ?>
            var existingAlert = document.querySelector('.alert.alert-success');
            if (!existingAlert) {
                var dynamicAlert = document.createElement('div');
                dynamicAlert.className = 'alert alert-success alert-dismissible fade show animated fadeInDown';
                dynamicAlert.setAttribute('role', 'alert');
                dynamicAlert.innerHTML = '<?= htmlspecialchars($flash_success_message['message']) ?>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                var mainContent = document.querySelector('#page-content-wrapper .container-fluid, #page-content-wrapper');
                if (mainContent) {
                    mainContent.prepend(dynamicAlert);
                }
            }
            console.log("Flash Success: <?= htmlspecialchars($flash_success_message['message']) ?>");
        <?php endif; ?>

        <?php if ($flash_warning_message): ?>
            var existingAlert = document.querySelector('.alert.alert-warning');
            if (!existingAlert) {
                var dynamicAlert = document.createElement('div');
                dynamicAlert.className = 'alert alert-warning alert-dismissible fade show animated fadeInDown';
                dynamicAlert.setAttribute('role', 'alert');
                dynamicAlert.innerHTML = '<?= htmlspecialchars($flash_warning_message['message']) ?>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                var mainContent = document.querySelector('#page-content-wrapper .container-fluid, #page-content-wrapper');
                if (mainContent) {
                    mainContent.prepend(dynamicAlert);
                }
            }
            console.warn("Flash Warning: <?= htmlspecialchars($flash_warning_message['message']) ?>");
        <?php endif; ?>

        <?php if ($flash_info_message): ?>
            var existingAlert = document.querySelector('.alert.alert-info');
            if (!existingAlert) {
                var dynamicAlert = document.createElement('div');
                dynamicAlert.className = 'alert alert-info alert-dismissible fade show animated fadeInDown';
                dynamicAlert.setAttribute('role', 'alert');
                dynamicAlert.innerHTML = '<?= htmlspecialchars($flash_info_message['message']) ?>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                var mainContent = document.querySelector('#page-content-wrapper .container-fluid, #page-content-wrapper');
                if (mainContent) {
                    mainContent.prepend(dynamicAlert);
                }
            }
            console.info("Flash Info: <?= htmlspecialchars($flash_info_message['message']) ?>");
        <?php endif; ?>
    });

    // Spinner Hide (Dipindahkan ke sini agar lebih terintegrasi dengan DOMContentLoaded)
    window.addEventListener('load', function() {
        var spinnerElement = document.getElementById('spinner');
        if (spinnerElement) {
            spinnerElement.classList.remove('show');
        }
    });

</script>

</body>
</html>