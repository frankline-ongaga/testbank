<?php
$ext = strtolower((string)pathinfo((string)($doc['file_name'] ?? ''), PATHINFO_EXTENSION));
$isPdf = $ext === 'pdf';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0"><?= esc($doc['title']) ?></h5>
        <div class="small text-muted"><?= esc($subcategory['name']) ?> • <?= esc($category['name']) ?></div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/cheat-sheets/subcategory/' . (int)$subcategory['id'] . '/docs') ?>" class="btn btn-secondary btn-sm">Back</a>
        <a href="<?= base_url('admin/cheat-sheets/doc/' . (int)$doc['id'] . '/download') ?>" class="btn btn-outline-secondary btn-sm">Download</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($doc['description'])): ?>
            <div class="text-muted mb-3"><?= esc($doc['description']) ?></div>
        <?php endif; ?>

        <?php if ($isPdf): ?>
            <iframe src="<?= base_url('admin/cheat-sheets/doc/' . (int)$doc['id'] . '/file') ?>" style="width:100%; height:80vh;" class="border rounded"></iframe>
        <?php else: ?>
            <img src="<?= base_url('admin/cheat-sheets/doc/' . (int)$doc['id'] . '/file') ?>" alt="Cheat sheet" class="w-100 border rounded">
        <?php endif; ?>
    </div>
</div>
