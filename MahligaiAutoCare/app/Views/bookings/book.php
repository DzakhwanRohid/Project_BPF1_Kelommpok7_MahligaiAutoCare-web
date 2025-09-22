<?php
// app/Views/bookings/book.php
?>
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h1 class="display-3 mb-5">Formulir Janji Temu</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 wow fadeIn" data-wow-delay="0.3s">
                <div class="p-5 bg-light rounded">
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-<?= htmlspecialchars($error_type) ?> alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($error_message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= htmlspecialchars($base_url) ?>/book" method="POST" enctype="multipart/form-data">
                        <div class="row g-4">
                            <h4 class="mb-3 border-bottom pb-2">1. Informasi Kontak</h4>
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="customer_name" class="form-control-plaintext" value="<?= htmlspecialchars(($customer['first_name'] ?? '') . ' ' . ($customer['last_name'] ?? '')) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="customer_phone" class="form-label">Nomor Telepon</label>
                                <input type="text" id="customer_phone" class="form-control-plaintext" value="<?= htmlspecialchars($customer['phone_number'] ?? '') ?>" readonly>
                            </div>

                            <h4 class="mt-5 mb-3 border-bottom pb-2">2. Pilih Layanan Anda</h4>
                            <div class="col-12">
                                <label class="form-label">Silakan pilih satu atau lebih layanan:</label>
                                <div class="service-selection">
                                    <?php foreach ($services as $service): ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="service_ids[]" value="<?= htmlspecialchars($service['service_id']) ?>" id="service_<?= htmlspecialchars($service['service_id']) ?>">
                                        <label class="form-check-label" for="service_<?= htmlspecialchars($service['service_id']) ?>">
                                            <?= htmlspecialchars($service['service_name']) ?> - <strong>Rp <?= number_format($service['price'], 0, ',', '.') ?></strong>
                                        </label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <h4 class="mt-5 mb-3 border-bottom pb-2">3. Jadwal & Kendaraan</h4>
                            <div class="col-md-6">
                                <label for="booking_date" class="form-label">Tanggal Cuci</label>
                                <input type="date" class="form-control" name="booking_date" id="booking_date" required min="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="booking_time" class="form-label">Jam Cuci (08:00 - 17:00)</label>
                                <input type="time" class="form-control" name="booking_time" id="booking_time" required>
                            </div>
                             <div class="col-12">
                                <label for="vehicle_type" class="form-label">Jenis Kendaraan</label>
                                <select id="vehicle_type" name="vehicle_type" class="form-select">
                                    <option value="Mobil">Mobil</option>
                                    <option value="Motor">Motor</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <h4 class="mt-5 mb-3 border-bottom pb-2">4. Metode Pembayaran</h4>
                            <div class="col-12">
                                <label for="payment_method" class="form-label">Pilih Metode Pembayaran</label>
                                <select id="payment_method" name="payment_method" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Opsi --</option>
                                    <option value="Bayar di Tempat">Bayar di Tempat</option>
                                    <option value="QRIS">QRIS</option>
                                    <option value="Transfer Bank">Transfer Bank</option>
                                </select>
                            </div>

                            <div class="col-12" id="qris_details_container" style="display: none;">
                                <label class="form-label">Detail Pembayaran QRIS</label>
                                <div class="text-center p-3 border rounded">
                                    <img src="<?= htmlspecialchars($base_url) ?>/img/qris_placeholder.png" alt="QRIS Code" class="img-fluid" style="max-width: 250px;"> 
                                    <p class="mt-2 mb-0">Scan QRIS ini untuk pembayaran.</p>
                                    <p class="mb-0 text-muted"><small>Jumlah pembayaran akan dihitung setelah pemesanan dikonfirmasi.</small></p>
                                </div>
                            </div>

                            <div class="col-12" id="transfer_details_container" style="display: none;">
                                <label class="form-label">Detail Transfer Bank</label>
                                <div class="p-3 border rounded">
                                    <p><strong>Nama Bank:</strong> Bank Central Asia (BCA)</p>
                                    <p><strong>Nomor Rekening:</strong> 1234567890</p>
                                    <p><strong>Atas Nama:</strong> FRCarWash (PT. Cuci Bersih)</p>
                                    <p class="mb-0 text-muted"><small>Mohon transfer sesuai total harga setelah pemesanan dikonfirmasi.</small></p>
                                </div>
                            </div>

                            <div class="col-12" id="payment_proof_container" style="display: none;">
                                <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
                                <input class="form-control" type="file" id="payment_proof" name="payment_proof" accept="image/png, image/jpeg, image/jpg">
                                <div class="form-text">Wajib diisi jika memilih QRIS atau Transfer Bank.</div>
                            </div>

                            <h4 class="mt-5 mb-3 border-bottom pb-2">5. Catatan Tambahan (Opsional)</h4>
                             <div class="col-12">
                                <textarea class="form-control" name="notes" placeholder="Contoh: Fokus pada bagian interior mobil." rows="4"></textarea>
                            </div>

                            <div class="col-12 mt-5">
                                <button class="btn btn-primary w-100 py-3" type="submit">Kirim Pemesanan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentMethodSelect = document.getElementById('payment_method');
    const paymentProofContainer = document.getElementById('payment_proof_container');
    const qrisDetailsContainer = document.getElementById('qris_details_container'); // Ambil elemen baru
    const transferDetailsContainer = document.getElementById('transfer_details_container'); // Ambil elemen baru

    paymentMethodSelect.addEventListener('change', function () {
        // Sembunyikan semua kontainer detail terlebih dahulu
        paymentProofContainer.style.display = 'none';
        qrisDetailsContainer.style.display = 'none';
        transferDetailsContainer.style.display = 'none';

        if (this.value === 'QRIS') {
            qrisDetailsContainer.style.display = 'block';
            paymentProofContainer.style.display = 'block'; // Bukti pembayaran tetap diperlukan untuk QRIS
        } else if (this.value === 'Transfer Bank') {
            transferDetailsContainer.style.display = 'block';
            paymentProofContainer.style.display = 'block'; // Bukti pembayaran tetap diperlukan untuk Transfer Bank
        }
        // Jika 'Bayar di Tempat', semua kontainer detail akan tetap tersembunyi
    });
});
</script>