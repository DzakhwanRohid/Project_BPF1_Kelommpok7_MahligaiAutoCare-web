<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahligai AutoCare - <?php echo htmlspecialchars($title ?? 'Autentikasi'); ?></title>
    <!-- Bootstrap CSS -->
    <link href="<?php echo htmlspecialchars($base_url); ?>/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="<?php echo htmlspecialchars($base_url); ?>/lib/fontawesome/css/all.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link href="<?php echo htmlspecialchars($base_url); ?>/css/style.css" rel="stylesheet">
</head>
<body>
    <main>
        <?php
        // $content sudah disediakan oleh Controller::render
        echo $content;
        ?>
    </main>
    <!-- Optional: JavaScript Libraries -->
    <script src="<?php echo htmlspecialchars($base_url); ?>/lib/jquery/jquery-3.7.1.min.js"></script>
    <script src="<?php echo htmlspecialchars($base_url); ?>/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>