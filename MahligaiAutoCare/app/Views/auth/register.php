<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Mahligai AutoCare</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= htmlspecialchars($base_url) ?>/css/register.css">
</head>

<body class="auth-page">
    
    <div id="animated-bg"></div>
    <div id="particles-js"></div>

    <div class="auth-page-wrapper">
        <div class="register-form-container">
            <h2 class="mb-4"><i class="fas fa-user-plus me-2"></i>Daftar Akun Mahligai AutoCare</h2>
            
            <?php if (isset($message) && !empty($message)): ?>
                <div class="alert alert-<?= htmlspecialchars($message_type ?? 'info') ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= htmlspecialchars($base_url) ?>/register" method="POST">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="first_name" class="form-label">Nama Depan</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="last_name" class="form-label">Nama Belakang</label>
                        <input type="text" class="form-control" id="last_name" name="last_name">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone_number" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Daftar</button>
                <p class="text-center small mt-4 mb-2">Sudah punya akun? <a href="<?= htmlspecialchars($base_url) ?>/login">Login di sini</a></p>
                <a href="<?= htmlspecialchars($base_url) ?>/" class="btn btn-secondary-custom btn-block w-100">Kembali ke Beranda</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="<?= htmlspecialchars($base_url) ?>/js/register.js"></script>

</body>
</html>