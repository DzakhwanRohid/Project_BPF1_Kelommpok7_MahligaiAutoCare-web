<?php
use App\Core\Application;
// Fungsi getStatusClass() diasumsikan sudah ada dari app/Helpers/ViewHelpers.php
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Pemesanan</h1>
</div>

<?php if (isset($message) && $message): ?>
    <div class="alert alert-<?= htmlspecialchars($message_type ?? 'info') ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 id="form-title" class="m-0 fw-bold text-primary">
            <i class="fas fa-plus me-1"></i> Tambah Pemesanan Baru
        </h6>
    </div>
    <div class="card-body">
        <form id="bookingForm" action="<?= htmlspecialchars($base_url) ?>/admin/bookings/manage" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="booking_id" id="booking_id">
            <input type="hidden" name="action" id="action" value="add">
            
            <div class="row">
                <div class="col-md-6 mb-3"><label for="customer_id" class="form-label fw-bold">Pelanggan</label><select name="customer_id" id="customer_id" class="form-select" required><option value="">-- Pilih --</option><?php foreach ($customers as $customer): ?><option value="<?= htmlspecialchars($customer['customer_id']) ?>"><?= htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']) ?></option><?php endforeach; ?></select></div>
                <div class="col-md-6 mb-3"><label for="vehicle_type" class="form-label fw-bold">Tipe Kendaraan</label><input type="text" name="vehicle_type" id="vehicle_type" class="form-control" required></div>
            </div>
            <div class="row">
                 <div class="col-md-3 mb-3"><label for="booking_date" class="form-label fw-bold">Tanggal</label><input type="date" name="booking_date" id="booking_date" class="form-control" required></div>
                <div class="col-md-3 mb-3"><label for="booking_time" class="form-label fw-bold">Waktu</label><input type="time" name="booking_time" id="booking_time" class="form-control" required></div>
                <div class="col-md-3 mb-3"><label for="status" class="form-label fw-bold">Status Pesanan</label><select name="status" id="status" class="form-select"><option value="Pending">Pending</option><option value="Confirmed">Confirmed</option><option value="Completed">Completed</option><option value="Cancelled">Cancelled</option></select></div>
                 <div class="col-md-3 mb-3"><label for="payment_status" class="form-label fw-bold">Status Bayar</label><select name="payment_status" id="payment_status" class="form-select"><option value="Pending">Pending</option><option value="Awaiting Confirmation">Menunggu Konfirmasi</option><option value="Confirmed">Terkonfirmasi</option><option value="Rejected">Ditolak</option></select></div>
            </div>
            <div class="mb-3"><label class="form-label fw-bold">Layanan</label><div class="p-2 border rounded" style="max-height: 150px; overflow-y: auto;"><?php foreach ($services as $service): ?><div class="form-check form-check-inline"><input class="form-check-input service-checkbox" type="checkbox" name="service_ids[]" value="<?= htmlspecialchars($service['service_id']) ?>" id="service_<?= htmlspecialchars($service['service_id']) ?>"><label class="form-check-label" for="service_<?= htmlspecialchars($service['service_id']) ?>"><?= htmlspecialchars($service['service_name']) ?></label></div><?php endforeach; ?></div></div>
            <div class="row">
                <div class="col-md-6 mb-3"><label for="notes" class="form-label">Catatan</label><textarea name="notes" id="notes" class="form-control" rows="2"></textarea></div>
                <div class="col-md-6 mb-3"><label for="payment_proof" class="form-label">Upload Foto (Opsional)</label><input type="file" name="payment_proof" id="payment_proof" class="form-control"><div id="proof_preview" class="mt-2"></div></div>
            </div>
            <button type="submit" class="btn btn-primary" id="submit_button"><i class="fas fa-plus me-2"></i>Tambah</button>
            <button type="button" class="btn btn-secondary" onclick="resetBookingForm()"><i class="fas fa-times me-2"></i>Batal</button>
        </form>
    </div>
</div>

<div class="card shadow">
    <div class="card-header py-3"><h6 class="m-0 fw-bold text-primary">Daftar Pemesanan</h6></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="bookingsTable" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Jadwal</th>
                        <th>Kendaraan</th>
                        <th>Layanan</th>
                        <th>Total</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookings)): foreach ($bookings as $booking): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($booking['booking_id']) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($booking['customer_name']) ?></strong><br>
                                <small><?= htmlspecialchars($booking['payment_method'] ?? 'N/A') ?></small>
                            </td>
                            <td><?= htmlspecialchars((new DateTime($booking['booking_date']))->format('d M Y, H:i')) ?></td>
                            <td><?= htmlspecialchars($booking['vehicle_type']) ?></td>
                            <td><small><?= htmlspecialchars($booking['service_names'] ?? 'N/A') ?></small></td>
                            <td><strong>Rp<?= number_format($booking['total_price'] ?? 0, 0, ',', '.') ?></strong></td>
                            <td><small><?= htmlspecialchars($booking['notes'] ?? '-') ?></small></td>
                            <td>
                                <span class="badge bg-<?= getStatusClass($booking['status']) ?>"><?= htmlspecialchars($booking['status']) ?></span><br>
                                <span class="badge bg-<?= getStatusClass($booking['payment_status']) ?> mt-1"><?= htmlspecialchars($booking['payment_status']) ?></span>
                                <?php if ($booking['payment_status'] === 'Rejected' && !empty($booking['cancellation_reason'])): ?>
                                    <small class="text-danger d-block mt-1 fst-italic" title="Alasan Penolakan">
                                        <i class="fas fa-info-circle me-1"></i><?= htmlspecialchars($booking['cancellation_reason']) ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($booking['payment_proof'])): ?>
                                    <a href="<?= htmlspecialchars($base_url . $booking['payment_proof']) ?>" data-lightbox="proof-<?= $booking['booking_id'] ?>" data-title="Bukti Bayar #<?= $booking['booking_id'] ?>">Lihat</a>
                                <?php else: echo '-'; endif; ?>
                            </td>
                            <td>
                                <?php if ($booking['payment_status'] === 'Awaiting Confirmation' || $booking['payment_status'] === 'Waiting Confirmation'): ?>
                                    <div class="btn-group mb-1" role="group">
                                        <form action="<?= htmlspecialchars($base_url) ?>/admin/bookings/confirm-payment" method="POST" class="d-inline">
                                            <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-success" title="Terima Pembayaran"><i class="fas fa-check"></i></button>
                                        </form>
                                        <a href="<?= htmlspecialchars($base_url) ?>/admin/bookings/reject?id=<?= $booking['booking_id'] ?>" class="btn btn-sm btn-danger" title="Tolak Pembayaran">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($booking['status'] === 'Confirmed' && $booking['payment_status'] === 'Confirmed'): ?>
                                <form action="<?= htmlspecialchars($base_url) ?>/admin/bookings/complete" method="POST" class="d-inline">
                                    <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-info" title="Selesaikan Pesanan"><i class="fas fa-flag-checkered"></i></button>
                                </form>
                                <?php endif; ?>

                                <button type="button" class="btn btn-sm btn-warning btn-action" 
                                        onclick='editBooking(<?= htmlspecialchars(json_encode($booking), ENT_QUOTES, 'UTF-8') ?>)'>
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="<?= htmlspecialchars($base_url) ?>/admin/bookings/delete" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?');">
                                    <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['booking_id']) ?>">
                                    <button type="submit" class="btn btn-sm btn-secondary" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Fungsi editBooking dan resetBookingForm tetap sama
function editBooking(booking) {
    const form = document.getElementById('bookingForm');
    
    document.getElementById('form-title').innerHTML = '<i class="fas fa-edit me-1"></i> Edit Pemesanan #' + booking.booking_id;
    document.getElementById('submit_button').innerHTML = '<i class="fas fa-save me-2"></i>Simpan Perubahan';
    document.getElementById('action').value = 'edit';

    document.getElementById('booking_id').value = booking.booking_id;
    document.getElementById('customer_id').value = booking.customer_id;
    document.getElementById('vehicle_type').value = booking.vehicle_type;
    document.getElementById('notes').value = booking.notes || '';
    document.getElementById('status').value = booking.status;
    document.getElementById('payment_status').value = booking.payment_status;

    if (booking.booking_date) {
        const dt = new Date(booking.booking_date.replace(' ', 'T'));
        if (!isNaN(dt)) {
            document.getElementById('booking_date').value = dt.toISOString().split('T')[0];
            document.getElementById('booking_time').value = dt.toTimeString().split(' ')[0].substring(0, 5);
        }
    }

    document.querySelectorAll('.service-checkbox').forEach(cb => cb.checked = false);
    if (booking.service_ids) {
        const serviceIds = String(booking.service_ids).split(',');
        serviceIds.forEach(id => {
            const checkbox = document.getElementById(`service_${id}`);
            if (checkbox) checkbox.checked = true;
        });
    }

    const previewContainer = document.getElementById('proof_preview');
    previewContainer.innerHTML = '';
    if (booking.payment_proof) {
        const link = '<?= htmlspecialchars($base_url) ?>' + booking.payment_proof;
        previewContainer.innerHTML = `<small>File saat ini: <a href="${link}" target="_blank">Lihat Bukti</a>.</small>`;
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetBookingForm() {
    const form = document.getElementById('bookingForm');
    form.reset();
    
    document.getElementById('form-title').innerHTML = '<i class="fas fa-plus me-1"></i> Tambah Pemesanan Baru';
    document.getElementById('submit_button').innerHTML = '<i class="fas fa-plus me-2"></i>Tambah';
    
    document.getElementById('action').value = 'add';
    document.getElementById('booking_id').value = '';
    document.getElementById('proof_preview').innerHTML = '';
}

// PERUBAHAN DI SINI: Kode JavaScript untuk modal telah dihapus.
$(document).ready(function() {
    // Inisialisasi DataTable
    $('#bookingsTable').DataTable();
});
</script>