<h1 class="h2 mb-4">Laporan Statistik Layanan</h1>

<?php if (!empty($message)): ?>
    <div class="alert alert-<?= htmlspecialchars($message_type) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3"><h6 class="m-0 fw-bold text-primary">Popularitas Layanan (berdasarkan jumlah pesanan)</h6></div>
            <div class="card-body ">
                <?php if (!empty($service_stats['popularity'])): ?>
                    <ul class="list-group list-group-flush ">
                    <?php foreach ($service_stats['popularity'] as $stat): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center ">
                            <?= htmlspecialchars($stat['service_name']) ?>
                            <span class="badge bg-success rounded-pill "><?= htmlspecialchars($stat['total_bookings_count']) ?></span>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-center text-muted">Tidak ada data.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3"><h6 class="m-0 fw-bold text-primary">Pendapatan per Layanan (dari pesanan selesai)</h6></div>
            <div class="card-body">
                <?php if (!empty($service_stats['revenue'])): ?>
                     <ul class="list-group list-group-flush">
                    <?php foreach ($service_stats['revenue'] as $stat): ?>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($stat['service_name']) ?>
                            <span class="badge bg-success rounded-pill">Rp <?= number_format($stat['total_revenue'], 0, ',', '.') ?></span>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-center text-muted">Tidak ada data.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
     <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3"><h6 class="m-0 fw-bold text-primary">Ringkasan Status Semua Pemesanan</h6></div>
            <div class="card-body">
                <?php if (!empty($booking_status_counts)): ?>
                    <ul class="list-group list-group-flush">
                    <?php foreach ($booking_status_counts as $status => $count): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($status) ?>
                            <span class="badge bg-<?= getStatusClass($status) ?> rounded-pill"><?= htmlspecialchars($count) ?></span>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-center text-muted">Tidak ada data.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Helper function untuk kelas status, sama seperti di view lain
if (!function_exists('getStatusClass')) {
    function getStatusClass($status) {
        return match (strtolower($status)) {
            'completed', 'confirmed' => 'success',
            'pending', 'awaiting confirmation' => 'warning',
            'cancelled', 'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
?>