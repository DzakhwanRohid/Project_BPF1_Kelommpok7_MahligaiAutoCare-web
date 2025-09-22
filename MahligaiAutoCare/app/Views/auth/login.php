<?php
// app/Views/auth/login.php
// Pastikan variabel $base_url sudah tersedia.
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mahligai AutoCare</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= htmlspecialchars($base_url) ?>/css/login.css">
</head>

<body class="auth-page">
    
    <div id="animated-bg"></div>
    <div id="particles-js"></div>

    <div class="auth-page-wrapper">
        <div class="login-form-container">
            <h2><i class="fas fa-car-wash me-2"></i>Login Mahligai AutoCare</h2>
            
            <?php 
                $flash_message = $this->sessionManager->getFlash('login_status'); 
                if ($flash_message && !empty($flash_message['message'])):
            ?>
                <div class="alert alert-<?= htmlspecialchars($flash_message['type'] ?? 'info') ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($flash_message['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= htmlspecialchars($base_url) ?>/login" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username Anda" required autocomplete="username">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">Masuk</button>
            </form>
            
            <p class="mt-3 text-center small">Belum punya akun? <a href="<?= htmlspecialchars($base_url) ?>/register">Daftar Sekarang</a></p>
            <a href="<?= htmlspecialchars($base_url) ?>/" class="btn btn-secondary-custom btn-block mt-2 w-100">Kembali ke Beranda</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    
    <script src="<?= htmlspecialchars($base_url) ?>/js/login.js"></script>

</body>
</html>