<h1 class="h2 mb-4">Edit Item Galeri</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Formulir Edit</h6>
    </div>
    <div class="card-body">
        <form action="<?= htmlspecialchars($base_url) ?>/admin/gallery/update" method="POST" enctype="multipart/form-data">
            <!-- Hidden fields untuk mengirim ID dan path gambar lama -->
            <input type="hidden" name="gallery_id" value="<?= htmlspecialchars($item['gallery_id']) ?>">
            <input type="hidden" name="old_image_path" value="<?= htmlspecialchars($item['image_path']) ?>">

            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini:</label><br>
                <img src="<?= htmlspecialchars($base_url . $item['image_path']) ?>" alt="Gambar saat ini" style="max-width: 250px; height: auto; border-radius: 8px;">
            </div>

            <div class="mb-3">
                <label for="gallery_image" class="form-label">Ganti Gambar (Opsional)</label>
                <input type="file" name="gallery_image" id="gallery_image" class="form-control" accept="image/*">
                <small class="form-text text-muted">Kosongkan jika Anda tidak ingin mengganti gambar.</small>
            </div>
            
            <div class="mb-3">
                <label for="caption" class="form-label">Keterangan (Deskripsi)</label>
                <input type="text" name="caption" id="caption" class="form-control" placeholder="Tulis keterangan singkat..." value="<?= htmlspecialchars($item['caption']) ?>">
            </div>

            <a href="<?= htmlspecialchars($base_url) ?>/admin/gallery" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
