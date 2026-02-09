<?php
$ext = strtolower((string)pathinfo((string)($doc['file_name'] ?? ''), PATHINFO_EXTENSION));
$isPdf = $ext === 'pdf';
?>

<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('client/cheat-sheets') ?>">Cheat Sheets</a></li>
            <?php if (!empty($category)): ?>
                <li class="breadcrumb-item"><a href="<?= base_url('client/cheat-sheets/' . (int)$category['id'] . '/subcategories') ?>"><?= esc($category['name']) ?></a></li>
            <?php endif; ?>
            <?php if (!empty($subcategory)): ?>
                <li class="breadcrumb-item"><a href="<?= base_url('client/cheat-sheets/subcategory/' . (int)$subcategory['id'] . '/docs') ?>"><?= esc($subcategory['name']) ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($doc['title']) ?></li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-1"><?= esc($doc['title']) ?></h3>
            <?php if (!empty($doc['description'])): ?>
                <div class="text-muted"><?= esc($doc['description']) ?></div>
            <?php endif; ?>
        </div>
        <div class="d-flex gap-2">
            <?php if (!empty($subcategory)): ?>
                <a href="<?= base_url('client/cheat-sheets/subcategory/' . (int)$subcategory['id'] . '/docs') ?>" class="btn btn-outline-secondary">Back</a>
            <?php else: ?>
                <a href="<?= base_url('client/cheat-sheets') ?>" class="btn btn-outline-secondary">Back</a>
            <?php endif; ?>
            <a href="<?= base_url('client/cheat-sheets/doc/' . (int)$doc['id'] . '/download') ?>" class="btn btn-primary">
                <i class="fas fa-download"></i> Download
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if ($isPdf): ?>
                <iframe src="<?= base_url('client/cheat-sheets/doc/' . (int)$doc['id'] . '/file') ?>" style="width:100%; height:80vh;" class="border rounded"></iframe>
            <?php else: ?>
                <div class="text-center">
                    <img src="<?= base_url('client/cheat-sheets/doc/' . (int)$doc['id'] . '/file') ?>" alt="Cheat sheet" class="img-fluid border rounded">
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

