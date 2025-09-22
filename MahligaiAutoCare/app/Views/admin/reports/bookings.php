<h1 class="h2 mb-4">Laporan Semua Pemesanan</h1>

<?php if (!empty($message)): ?>
    <div class="alert alert-<?= htmlspecialchars($message_type) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow">
    <div class="card-header py-3"><h6 class="m-0 fw-bold text-primary">Detail Laporan</h6></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Jadwal</th>
                        <th>Layanan Dipesan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Status Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookings_report)): ?>
                        <?php foreach ($bookings_report as $booking): ?>
                            <tr>
                                <td>#<?= $booking['booking_id'] ?></td>
                                <td><?= htmlspecialchars($booking['customer_name']) ?></td>
                                <td><?= (new DateTime($booking['booking_date']))->format('d M Y, H:i') ?></td>
                                <td><?= htmlspecialchars($booking['service_names']) ?></td>
                                <td>Rp <?= number_format($booking['calculated_price'], 0, ',', '.') ?></td>
                                <td><span class="badge bg-<?= getStatusClass($booking['status']) ?>"><?= $booking['status'] ?></span></td>
                                <td><span class="badge bg-<?= getStatusClass($booking['payment_status']) ?>"><?= $booking['payment_status'] ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () { $('#dataTable').DataTable(); });
</script>