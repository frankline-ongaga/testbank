<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Study Categories</h5>
        <a href="<?= base_url('admin/study/category/create') ?>" class="btn btn-primary btn-sm">Add Category</a>
    </div>
    <div class="card-body">
        <div class="row">
            <?php foreach (($categories ?? []) as $cat): ?>
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3 h-100">
                        <h6 class="mb-1"><?= esc($cat['name']) ?></h6>
                        <div class="text-muted small mb-2"><?= esc($cat['description'] ?? '') ?></div>
                        <a href="<?= base_url('admin/study/'.$cat['id'].'/subcategories') ?>" class="btn btn-outline-secondary btn-sm">Manage Subcategories</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>



