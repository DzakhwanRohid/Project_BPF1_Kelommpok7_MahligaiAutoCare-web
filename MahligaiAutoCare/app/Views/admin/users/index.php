<?php
// app/Views/admin/users/index.php
// Kode ini telah diperbaiki untuk memastikan fungsi Tambah dan Edit berjalan dengan benar
// pada satu form statis, tanpa menggunakan modal/pop-up.
?>

<h1 class="mt-4 mb-4">Manajemen Pengguna</h1>

<?php if (isset($message) && $message): ?>
    <div class="alert alert-<?= htmlspecialchars($message_type ?? 'info') ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card mb-4 shadow-sm">
    <div class="card-header py-3">
        <h6 id="form-title" class="m-0 fw-bold text-primary">
            <i class="fas fa-plus me-1"></i> Tambah Pengguna Baru
        </h6>
    </div>
    <div class="card-body">
        <form id="userForm" action="<?= htmlspecialchars($base_url) ?>/admin/users/create" method="POST">
            
            <input type="hidden" name="user_id" id="user_id">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Wajib diisi untuk pengguna baru" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Peran:</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="user">User</option>
                        <option value="admin1">Admin 1</option>
                        <option value="admin2">Admin 2</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="customer_id" class="form-label">Hubungkan ke Pelanggan (Opsional):</label>
                    <select class="form-select" id="customer_id" name="customer_id">
                        <option value="">-- Tidak Terhubung --</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?= htmlspecialchars($customer['customer_id']) ?>">
                                <?= htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary" id="submit_button">
                <i class="fas fa-plus me-2"></i>Tambah Pengguna
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
        Daftar Pengguna
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="usersTable" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Peran</th>
                        <th>Pelanggan Terkait</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['user_id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td>
                                <?php
                                $related_customer = 'N/A';
                                foreach ($customers as $customer) {
                                    if ($customer['customer_id'] == $user['customer_id']) {
                                        $related_customer = htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']);
                                        break;
                                    }
                                }
                                echo $related_customer;
                                ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info  " 
                                        onclick='editUser(<?= htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8') ?>)'>
                                    <i class="fas fa-edit "></i> Edit
                                </button>
                                <form action="<?= htmlspecialchars($base_url) ?>/admin/users/delete" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="5" class="text-center">Tidak ada pengguna.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// [FINAL & VERIFIED SCRIPT]
function editUser(user) {
    const form = document.getElementById('userForm');
    
    // 1. Mengubah action form untuk proses UPDATE (INI KUNCI UTAMA)
    form.action = '<?= htmlspecialchars($base_url) ?>/admin/users/update';
    
    // 2. Mengubah judul dan tombol
    document.getElementById('form-title').innerHTML = '<i class="fas fa-edit me-1"></i> Edit Pengguna: ' + user.username;
    document.getElementById('submit_button').innerHTML = '<i class="fas fa-save me-2"></i>Simpan Perubahan';

    // 3. Mengisi semua field form dengan data
    document.getElementById('user_id').value = user.user_id;
    document.getElementById('username').value = user.username;
    document.getElementById('role').value = user.role;
    document.getElementById('customer_id').value = user.customer_id || '';
    
    // 4. Mengatur password field
    const passwordField = document.getElementById('password');
    passwordField.value = ''; // Kosongkan password
    passwordField.placeholder = 'Kosongkan jika tidak ingin mengubah';
    passwordField.removeAttribute('required'); // Password tidak wajib saat edit

    // 5. Gulir ke atas agar form terlihat
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
    const form = document.getElementById('userForm');
    form.reset(); 
    
    // 1. Mengembalikan action form ke proses CREATE (INI KUNCI UTAMA)
    form.action = '<?= htmlspecialchars($base_url) ?>/admin/users/create';
    
    // 2. Mengembalikan judul dan tombol
    document.getElementById('form-title').innerHTML = '<i class="fas fa-plus me-1"></i> Tambah Pengguna Baru';
    document.getElementById('submit_button').innerHTML = '<i class="fas fa-plus me-2"></i>Tambah Pengguna';

    // 3. Mengosongkan user_id
    document.getElementById('user_id').value = '';

    // 4. Mengatur password field kembali ke kondisi awal
    const passwordField = document.getElementById('password');
    passwordField.placeholder = 'Wajib diisi untuk pengguna baru';
    passwordField.setAttribute('required', 'required');
}

document.addEventListener('DOMContentLoaded', function() {
    $('#usersTable').DataTable();
});
</script>