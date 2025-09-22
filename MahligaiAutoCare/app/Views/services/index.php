<div class="container-fluid service py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary border-bottom pb-4 mb-4">Layanan Cuci Mobil Kami</h4>
            <h1 class="display-3 mb-5">Kami Menyediakan Layanan Terbaik</h1>
            <p class="mb-0">
                Mahligai AutoCare menawarkan berbagai layanan cuci mobil yang komprehensif, disesuaikan untuk setiap kebutuhan kendaraan Anda. Dari kebersihan eksterior hingga detailing interior, kami memastikan setiap sudut mobil Anda bersih dan berkilau.
            </p>
        </div>
        <div class="row g-4">
            <?php if (!empty($services_list)): ?>
                <?php
                $delay_start = 0.3;
                foreach ($services_list as $index => $service):
                    $delay = $delay_start + ($index % 3) * 0.2;
                ?>
                    <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="<?= number_format($delay, 1) ?>s">
                        <div class="service-item bg-light rounded overflow-hidden shadow-sm h-100 d-flex flex-column text-center">
                            <div class="p-4 flex-grow-1 d-flex flex-column align-items-center justify-content-center">
                                <div class="feature-icon mb-4 d-inline-flex align-items-center justify-content-center p-3 rounded-circle" 
                                     style="background-color: #E6F2FF; width: 80px; height: 80px;">
                                    <i class="<?= htmlspecialchars($service['icon_class'] ?? 'fas fa-car') ?> text-primary fa-2x"></i> </div>
                                
                                <h5 class="mb-2 text-dark"><?= htmlspecialchars($service['service_name']) ?></h5>
                                <p class="mb-3 text-primary fw-bold fs-4">Rp <?= number_format($service['price'], 0, ',', '.') ?></p>
                                <p class="text-muted small mb-3 flex-grow-1">
                                    <?= htmlspecialchars($service['description']) ?>
                                </p>
                                
                                <div class="mt-auto text-center">
                                    <a class="btn btn-primary rounded-pill px-4 py-2" href="<?= htmlspecialchars($base_url) ?>/book">
                                        Pesan Sekarang <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-muted">Tidak ada layanan yang tersedia saat ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>