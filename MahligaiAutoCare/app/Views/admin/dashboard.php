<?php
use App\Core\Application;
$user_role = Application::$app->getSessionManager()->getUserRole();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Admin</h1>
</div>

<?php if (isset($message) && $message): ?>
    <div class="alert alert-<?= htmlspecialchars($message_type) ?> alert-dismissible fade show animated fadeInDown" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row animated fadeInUp">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 dashboard-card" data-card-type="total-bookings">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-label text-white mb-1">Total Pemesanan</div>
                        <div class="h5 mb-0 text-value text-white"><?= htmlspecialchars($total_bookings ?? 0) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-white card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 dashboard-card" data-card-type="completed-bookings">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-label text-white mb-1">Pemesanan Selesai</div>
                        <div class="h5 mb-0 text-value text-white"><?= htmlspecialchars($completed_bookings ?? 0) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-double fa-2x text-white card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 dashboard-card" data-card-type="total-customers">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-label text-white mb-1">Total Pelanggan</div>
                        <div class="h5 mb-0 text-value text-white"><?= htmlspecialchars($total_customers ?? 0) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-friends fa-2x text-white card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if ($user_role == 'admin1'): ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 dashboard-card" data-card-type="total-users">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-label text-white mb-1">Total Pengguna</div>
                        <div class="h5 mb-0 text-value text-white"><?= htmlspecialchars($total_users ?? 0) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-white card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="row animated fadeInUp">
    <div class="col-lg-8 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary"><i class="fas fa-history me-2"></i>Aktivitas Pemesanan Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_bookings)): ?>
                                <?php foreach ($recent_bookings as $booking): ?>
                                    <tr>
                                        <td>#<?= htmlspecialchars($booking['booking_id']) ?></td>
                                        <td><?= htmlspecialchars($booking['customer_name']) ?></td>
                                        <td><?= htmlspecialchars($booking['service_names']) ?></td>
                                        <td><?= (new DateTime($booking['booking_date']))->format('d M Y') ?></td>
                                        <td><span class="badge status-<?= strtolower(htmlspecialchars($booking['status'])) ?>"><?= htmlspecialchars($booking['status']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada aktivitas pemesanan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                 <h6 class="m-0 fw-bold text-primary"><i class="fas fa-info-circle me-2"></i>Info Layanan</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Total Jenis Layanan</span>
                    <span class="badge bg-success p-2"><?= htmlspecialchars($total_services ?? 0) ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Rata-rata Harga</span>
                    <span class="badge bg-success p-2">Rp <?= htmlspecialchars(number_format($avg_service_price ?? 0, 0, ',', '.')) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>