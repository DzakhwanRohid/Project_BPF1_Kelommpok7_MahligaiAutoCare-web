<?php
// app/Views/layouts/page_header.php
// Header halaman umum untuk halaman publik tertentu.
// Variabel $page_title dan $breadcrumb_items diharapkan tersedia dari Controller.
// Variabel $base_url sudah tersedia dari Controller::renderLayout.
?>
<!-- Page Header Start -->
<div class="container-fluid page-header py-5">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4 animated slideInDown"><?= htmlspecialchars($page_title ?? 'Judul Halaman') ?></h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <?php
                // Pastikan $breadcrumb_items adalah array dan tidak kosong
                $breadcrumb_items = $breadcrumb_items ?? [];
                foreach ($breadcrumb_items as $index => $item):
                    $is_last = ($index === count($breadcrumb_items) - 1);
                ?>
                    <li class="breadcrumb-item <?= $is_last ? 'active text-white' : '' ?>">
                        <?php if ($is_last): ?>
                            <?= htmlspecialchars($item['label'] ?? '') ?>
                        <?php else: ?>
                            <a class="text-white" href="<?= htmlspecialchars($item['url'] ?? '#') ?>"><?= htmlspecialchars($item['label'] ?? '') ?></a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->
