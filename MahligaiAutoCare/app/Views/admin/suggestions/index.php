<?php
// app/Views/admin/suggestions/index.php
// Konten untuk halaman manajemen saran & keluhan di admin.
// Variabel $suggestions, $message, $message_type sudah tersedia dari controller.
// Variabel $base_url sudah tersedia dari layout.
?>

<h1 class="mt-4 mb-4">Manajemen Saran & Keluhan</h1>

<?php if (isset($message) && $message): ?>
    <div class="alert alert-<?= htmlspecialchars($message_type) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card mb-4 shadow-sm">
    <div class="card-header py-3 text-primary">
        <i class="fas fa-table me-1 text-primary"></i>
        Daftar Saran & Keluhan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="suggestionsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pengirim</th>
                        <th>Email</th>
                        <th>Subjek</th>
                        <th>Pesan</th>
                        <th>Tanggal Kirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($suggestions)): ?>
                        <?php foreach ($suggestions as $suggestion): ?>
                            <tr>
                                <td><?= htmlspecialchars($suggestion['suggestion_id']) ?></td>
                                <td><?= htmlspecialchars($suggestion['name']) ?></td>
                                <td><?= htmlspecialchars($suggestion['email']) ?></td>
                                <td><?= htmlspecialchars($suggestion['subject']) ?></td>
                                <td><?= htmlspecialchars(substr($suggestion['message'], 0, 100)) ?><?= (strlen($suggestion['message']) > 100) ? '...' : '' ?></td>
                                <td><?= htmlspecialchars(date('d M Y H:i', strtotime($suggestion['created_at']))) ?></td>
                                <td>
                                    <form action="<?= htmlspecialchars($base_url) ?>/admin/suggestions/delete" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus saran/keluhan ini?');">
                                        <input type="hidden" name="suggestion_id" value="<?= htmlspecialchars($suggestion['suggestion_id']) ?>">
                                        <button type="submit" class="btn btn-sm btn-danger btn-action"><i class="fas fa-trash-alt"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada saran atau keluhan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Optional: Initialize DataTables
        <?php if (!empty($suggestions)): ?>
        $('#suggestionsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true
        });
        <?php endif; ?>
    });
</script>