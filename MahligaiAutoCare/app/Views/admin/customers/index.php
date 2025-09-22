<h1 class="h2 mb-4">Manajemen Pelanggan</h1>

<?php if (!empty($message)): ?>
    <div class="alert alert-<?= htmlspecialchars($message_type) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 fw-bold text-primary" id="form-title">Tambah Pelanggan Baru</h6></div>
    <div class="card-body">
        <form id="customerForm" action="<?= htmlspecialchars($base_url) ?>/admin/customers/create" method="POST">
            <input type="hidden" name="customer_id" id="customer_id">
            <div class="row">
                <div class="col-md-3 mb-3"><input type="text" name="first_name" id="first_name" class="form-control" placeholder="Nama Depan" required></div>
                <div class="col-md-3 mb-3"><input type="text" name="last_name" id="last_name" class="form-control" placeholder="Nama Belakang"></div>
                <div class="col-md-3 mb-3"><input type="tel" name="phone_number" id="phone_number" class="form-control" placeholder="No. Telepon" required></div>
                <div class="col-md-3 mb-3"><input type="email" name="email" id="email" class="form-control" placeholder="Email" required></div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
        </form>
    </div>
</div>

<div class="card shadow">
    <div class="card-header py-3"><h6 class="m-0 fw-bold text-primary">Daftar Pelanggan</h6></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lengkap</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= $customer['customer_id'] ?></td>
                        <td><?= htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']) ?></td>
                        <td><?= htmlspecialchars($customer['phone_number']) ?></td>
                        <td><?= htmlspecialchars($customer['email']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-action edit-btn" data-customer='<?= htmlspecialchars(json_encode($customer), ENT_QUOTES, 'UTF-8') ?>'> <i class="fas fa-edit"></i> Edit</button>
                            <form action="<?= $base_url ?>/admin/customers/delete" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus pelanggan ini dan semua data terkaitnya?');">
                                <input type="hidden" name="customer_id" value="<?= $customer['customer_id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function resetForm() {
    const form = document.getElementById('customerForm');
    form.reset();
    form.action = '<?= $base_url ?>/admin/customers/create';
    document.getElementById('customer_id').value = '';
    document.getElementById('form-title').innerText = 'Tambah Pelanggan Baru';
}

document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const customer = JSON.parse(this.getAttribute('data-customer'));
        const form = document.getElementById('customerForm');
        form.action = '<?= $base_url ?>/admin/customers/update';
        document.getElementById('form-title').innerText = 'Edit Pelanggan #' + customer.customer_id;
        document.getElementById('customer_id').value = customer.customer_id;
        document.getElementById('first_name').value = customer.first_name;
        document.getElementById('last_name').value = customer.last_name;
        document.getElementById('phone_number').value = customer.phone_number;
        document.getElementById('email').value = customer.email;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
document.addEventListener('DOMContentLoaded', function () { $('#dataTable').DataTable(); });
</script>