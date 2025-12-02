<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Subcategories - <?= esc($category['name']) ?></h5>
        <a href="<?= base_url('admin/study-bank-pdfs') ?>" class="btn btn-secondary btn-sm">Back to Categories</a>
    </div>
    <div class="card-body">
        <div class="row">
            <?php foreach (($subcategories ?? []) as $sub): ?>
                <div class="col-md-12 mb-3">
                    <div class="border rounded p-3 h-100">
                        <h6 class="mb-1"><?= esc($sub['name']) ?></h6>
                        <div class="text-muted small mb-2"><?= esc($sub['description'] ?? '') ?></div>
                        <a href="<?= base_url('admin/study-bank-pdfs/subcategory/'.$sub['id'].'/pdfs') ?>" class="btn btn-outline-secondary btn-sm">Manage Docs</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (empty($subcategories)): ?>
            <div class="text-center text-muted py-4">
                <p>No subcategories available. Please create subcategories first.</p>
                <a href="<?= base_url('admin/study/'.$category['id'].'/subcategories') ?>" class="btn btn-sm btn-primary">Manage Subcategories</a>
            </div>
        <?php endif; ?>
    </div>
</div>

