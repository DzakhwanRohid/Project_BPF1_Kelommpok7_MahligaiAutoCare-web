<?php
// app/Views/admin/services/index.php
// Kode ini telah diperbaiki untuk memastikan fungsi Tambah dan Edit berjalan dengan benar.
?>

<h1 class="mt-4 mb-4">Manajemen Layanan</h1>

<?php if (isset($message) && $message): ?>
    <div class="alert alert-<?= htmlspecialchars($message_type ?? 'info') ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card mb-4 shadow-sm">
    <div class="card-header py-3 text-primary">
        <h6 id="form-title" class="m-0 fw-bold text-primary">
            <i class="fas fa-plus me-1"></i> Tambah Layanan Baru
        </h6>
    </div>
    <div class="card-body">
        <form id="serviceForm" action="<?= htmlspecialchars($base_url) ?>/admin/services/create" method="POST">
            <input type="hidden" name="service_id" id="service_id">

            <div class="mb-3">
                <label for="service_name" class="form-label">Nama Layanan:</label>
                <input type="text" class="form-control" id="service_name" name="service_name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi:</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga:</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required min="0">
            </div>
            <button type="submit" class="btn btn-primary" id="submit_button">
                <i class="fas fa-plus me-2"></i>Tambah Layanan
            </button>
            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                <i class="fas fa-times me-2"></i>Batal
            </button>
        </form>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header py-3 text-primary">
        <i class="fas fa-table me-1 text-primary"></i>
        Daftar Layanan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="servicesTable" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Layanan</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($services)): foreach ($services as $service): ?>
                        <tr>
                            <td><?= htmlspecialchars($service['service_id']) ?></td>
                            <td><?= htmlspecialchars($service['service_name']) ?></td>
                            <td><small><?= htmlspecialchars($service['description']) ?></small></td>
                            <td>Rp <?= number_format($service['price'], 0, ',', '.') ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning btn-action edit-btn" 
                                        onclick='editService(<?= htmlspecialchars(json_encode($service), ENT_QUOTES, 'UTF-8') ?>)'>
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="<?= htmlspecialchars($base_url) ?>/admin/services/delete" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus layanan ini?');">
                                    <input type="hidden" name="service_id" value="<?= htmlspecialchars($service['service_id']) ?>">
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="5" class="text-center">Tidak ada layanan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// [FINAL & VERIFIED SCRIPT]
function editService(service) {
    const form = document.getElementById('serviceForm');
    
    // 1. Mengubah action form untuk proses UPDATE
    form.action = '<?= htmlspecialchars($base_url) ?>/admin/services/update';
    
    // 2. Mengubah judul dan tombol
    document.getElementById('form-title').innerHTML = '<i class="fas fa-edit me-1"></i> Edit Layanan: ' + service.service_name;
    document.getElementById('submit_button').innerHTML = '<i class="fas fa-save me-2"></i>Simpan Perubahan';

    // 3. Mengisi semua field form dengan data
    document.getElementById('service_id').value = service.service_id;
    document.getElementById('service_name').value = service.service_name;
    document.getElementById('description').value = service.description;
    document.getElementById('price').value = parseFloat(service.price);
    
    // 4. Gulir ke atas agar form terlihat
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
    const form = document.getElementById('serviceForm');
    form.reset(); 
    
    // 1. Mengembalikan action form ke proses CREATE
    form.action = '<?= htmlspecialchars($base_url) ?>/admin/services/create';
    
    // 2. Mengembalikan judul dan tombol
    document.getElementById('form-title').innerHTML = '<i class="fas fa-plus me-1"></i> Tambah Layanan Baru';
    document.getElementById('submit_button').innerHTML = '<i class="fas fa-plus me-2"></i>Tambah Layanan';

    // 3. Mengosongkan service_id
    document.getElementById('service_id').value = '';
}

document.addEventListener('DOMContentLoaded', function() {
    $('#servicesTable').DataTable();
});
</script>