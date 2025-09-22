<h1 class="h2 mb-4">Manajemen Galeri</h1>

<?php if (!empty($message)): ?>
    <div class="alert alert-<?= htmlspecialchars($message_type) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Tambah Gambar Baru</h6>
    </div>
    <div class="card-body">
        <form action="<?= htmlspecialchars($base_url) ?>/admin/gallery/create" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="gallery_image" class="form-label">Pilih Gambar</label>
                <input type="file" name="gallery_image" id="gallery_image" class="form-control" required accept="image/*">
            </div>
            <div class="mb-3">
                <label for="caption" class="form-label">Keterangan (Opsional)</label>
                <input type="text" name="caption" id="caption" class="form-control" placeholder="Tulis keterangan singkat...">
            </div>
            <button type="submit" class="btn btn-primary">Unggah ke Galeri</button>
        </form>
    </div>
</div>

<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Daftar Gambar di Galeri</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if (empty($galleries)): ?>
                <p class="text-center text-muted">Belum ada gambar di galeri.</p>
            <?php else: ?>
                <?php foreach ($galleries as $item): ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($base_url . $item['image_path']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['caption']) ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text"><?= htmlspecialchars($item['caption'] ?: 'Tanpa keterangan') ?></p>
                            </div>
                            <!-- [PERUBAHAN] Tombol Edit dan Hapus -->
                            <div class="card-footer d-flex justify-content-between p-2">
                                <a href="<?= htmlspecialchars($base_url) ?>/admin/gallery/edit?id=<?= $item['gallery_id'] ?>" class="btn btn-sm btn-warning w-48">Edit</a>
                                <form action="<?= htmlspecialchars($base_url) ?>/admin/gallery/delete" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini?');" class="w-48 d-inline mb-0">
                                    <input type="hidden" name="gallery_id" value="<?= $item['gallery_id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger w-100">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Style untuk menata tombol -->
<style>
    .w-48 { width: 48%; }
    .d-flex .mb-0 { margin-bottom: 0 !important; }
</style>
