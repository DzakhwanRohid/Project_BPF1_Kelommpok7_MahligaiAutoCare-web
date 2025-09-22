<?php
// app/Views/bookings/user_bookings.php

// Pastikan variabel-variabel yang dibutuhkan tersedia di sini
// Misal: $bookings, $success_message, $base_url
// Helper function untuk kelas status, bisa juga dipindah ke file helper global jika ada
if (!function_exists('getStatusClass')) {
    function getStatusClass($status) {
        return match (strtolower($status)) {
            'completed' => 'success',
            'confirmed' => 'primary',
            'pending', 'awaiting confirmation' => 'warning',
            'cancelled', 'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
?>
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h1 class="display-3 mb-5">Riwayat Pemesanan Anda</h1>
        </div>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success_message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID Booking</th>
                        <th>Tanggal Pesan</th>
                        <th>Layanan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Catatan</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bookings)): ?>
                        <tr>
                            <td colspan="9" class="text-center">Anda belum memiliki riwayat pemesanan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td>#<?= htmlspecialchars($booking['booking_id']) ?></td>
                                <td><?= htmlspecialchars((new DateTime($booking['booking_date']))->format('d M Y, H:i')) ?></td>
                                <td><?= htmlspecialchars($booking['service_names'] ?? 'N/A') ?></td>
                                <td>Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge bg-<?= getStatusClass($booking['status']) ?>">
                                        <?= htmlspecialchars($booking['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= getStatusClass($booking['payment_status']) ?>">
                                        <?= htmlspecialchars($booking['payment_status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= htmlspecialchars($booking['notes'] ?? 'Tidak ada catatan') ?>
                                </td>
                                <td>
                                    <?php if (!empty($booking['cancellation_reason'])): ?>
                                        <small class="text-danger fst-italic">
                                            <i class="fas fa-info-circle me-1" title="Alasan"></i>
                                            <?= htmlspecialchars($booking['cancellation_reason']) ?>
                                        </small>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                    </td>
                                <td>
                                    <?php if (in_array($booking['status'], ['Pending', 'Confirmed'])): ?>
                                        <form action="<?= htmlspecialchars($base_url) ?>/booking/cancel" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?');">
                                            <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['booking_id']) ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Batalkan</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>Tidak Ada Aksi</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-center">
            <a href="<?= htmlspecialchars($base_url) ?>/book" class="btn btn-primary">Buat Pemesanan Baru</a>
        </div>
    </div>
</div>