<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Mock Test Categories</h5>
        <div class="small text-muted">Choose a category, then manage mock tests inside each subcategory.</div>
    </div>
    <div class="card-body">
        <?php if (empty($categories)): ?>
            <div class="text-muted">No study categories found yet.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($categories as $category): ?>
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <h6 class="mb-1"><?= esc($category['name']) ?></h6>
                            <div class="text-muted small mb-3"><?= esc($category['description'] ?? '') ?></div>
                            <a href="<?= base_url('admin/study/' . (int) $category['id'] . '/subcategories') ?>" class="btn btn-outline-secondary btn-sm">Manage Subcategories</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
