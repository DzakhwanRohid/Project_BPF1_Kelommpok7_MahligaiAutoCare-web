<!-- Gallery Start -->
<div class="container-fluid gallery py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary border-bottom pb-4 mb-4">Galeri Kami</h4>
            <h1 class="display-3 mb-5">Dokumentasi Kegiatan Kami</h1>
            <p class="mb-0">
                Lihat koleksi foto dari kegiatan, hasil kerja, dan momen-momen terbaik di Mahligai AutoCare.
            </p>
        </div>
        <div class="row g-4">
            <?php if (empty($gallery_items)): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Galeri masih kosong. Segera kembali untuk melihat foto-foto terbaru kami!</p>
                </div>
            <?php else: ?>
                <?php foreach ($gallery_items as $index => $item): 
                    $delay = 0.1 * ($index + 1);
                ?>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn mb-4" data-wow-delay="<?= $delay ?>s">
                        <div class="card h-100 shadow-sm gallery-card">
                            <a href="<?= htmlspecialchars($base_url . $item['image_path']) ?>" data-lightbox="gallery-group-1" data-title="<?= htmlspecialchars($item['caption']) ?>">
                                <img src="<?= htmlspecialchars($base_url . $item['image_path']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['caption']) ?>" style="height: 220px; object-fit: cover;">
                            </a>
                            <div class="card-body text-center">
                                <p class="card-text">
                                    <?= htmlspecialchars($item['caption'] ?: 'Tidak ada deskripsi.') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Gallery End -->

<style>
.gallery-card {
    border: none;
    border-radius: 0.5rem;
    overflow: hidden; /* Ensures the image corners are also rounded */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
.card-body {
    background-color: #f8f9fa;
}
.card-text {
    color: #555;
    font-size: 0.9rem;
    margin-bottom: 0;
}
</style>
