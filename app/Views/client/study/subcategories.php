<div class="container py-3">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Study Library</h6>
                </div>
                <div class="list-group list-group-flush">
                    <?php foreach (($categories ?? []) as $cat): ?>
                        <a href="<?= base_url('client/study/'.$cat['id'].'/subcategories') ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= (int)$cat['id'] === (int)$category['id'] ? 'active' : '' ?>">
                            <span><?= esc($cat['name']) ?></span>
                            <i class="fas fa-chevron-right <?= (int)$cat['id'] === (int)$category['id'] ? 'text-white' : 'text-muted' ?>"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h5 class="mb-3"><i class="far fa-folder-open me-2"></i><?= esc($category['name']) ?></h5>
            <div class="row">
                <?php foreach (($subcategories ?? []) as $sub): ?>
                <div class="col-md-6 mb-3">
                    <?php 
                        $isFree = isset($freeSubcategoryId) && (int)$freeSubcategoryId === (int)$sub['id'];
                        $href = base_url('client/study/subcategory/'.$sub['id'].'/questions');
                    ?>
                    <a class="text-decoration-none" href="<?= $href ?>">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="mb-1 d-flex align-items-center justify-content-between">
                                    <span><i class="far fa-folder me-2"></i><?= esc($sub['name']) ?></span>
                                    <?php if ($isFree): ?>
                                        <span class="badge border border-black text-black badge-free">Free</span>
                                    <?php else: ?>
                                        <span class="badge border border-success text-success">Pro</span>
                                    <?php endif; ?>
                                </h6>
                                <div class="text-muted small"><?= esc($sub['description'] ?? '') ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ensure "Free" badge text is visible in dark mode */
    .theme-dark .badge-free {
        color: #ffffff !important;
        border-color: #ffffff !important;
    }
</style>

