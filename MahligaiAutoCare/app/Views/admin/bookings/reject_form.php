<div class="container-fluid py-4">
    <h1 class="h2 mb-4">Tolak Pembayaran untuk Pesanan #<?= htmlspecialchars($booking['booking_id'] ?? 'N/A') ?></h1>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-primary">Konfirmasi Alasan Penolakan</h6>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h5>Detail Pesanan:</h5>
                
                <p><strong>Pelanggan:</strong> <?= htmlspecialchars($booking['customer_name'] ?? 'Tidak ada data') ?></p>
                
                <?php if (!empty($booking['booking_date'])): ?>
                    <p><strong>Tanggal:</strong> <?= htmlspecialchars((new DateTime($booking['booking_date']))->format('d M Y, H:i')) ?></p>
                <?php endif; ?>

                <p><strong>Total:</strong> Rp<?= number_format($booking['total_price'] ?? 0, 0, ',', '.') ?></p>
                
                <?php if (!empty($booking['payment_proof'])): ?>
                    <p><strong>Bukti Bayar:</strong> <a href="<?= htmlspecialchars($base_url . $booking['payment_proof']) ?>" target="_blank">Lihat Bukti</a></p>
                <?php else: ?>
                    <p><strong>Bukti Bayar:</strong> -</p>
                <?php endif; ?>
            </div>

            <form action="<?= htmlspecialchars($base_url) ?>/admin/bookings/reject-payment" method="POST">
                <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['booking_id'] ?? '') ?>">
                
                <div class="mb-3">
                    <label for="rejection_reason" class="form-label fw-bold">Alasan Penolakan (Wajib diisi)</label>
                    <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" placeholder="Contoh: Bukti pembayaran tidak valid atau tidak sesuai." required></textarea>
                </div>
                
                <a href="<?= htmlspecialchars($base_url) ?>/admin/bookings" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times me-2"></i>Tolak Pembayaran
                </button>
            </form>
        </div>
    </div>
</div>