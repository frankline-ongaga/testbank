<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Study Categories</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php foreach (($categories ?? []) as $cat): ?>
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3 h-100">
                        <h6 class="mb-1"><?= esc($cat['name']) ?></h6>
                        <div class="text-muted small mb-2"><?= esc($cat['description'] ?? '') ?></div>
                        <a href="<?= base_url('admin/study-bank-pdfs/category/'.$cat['id'].'/docs') ?>" class="btn btn-outline-secondary btn-sm">Manage Documents</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (empty($categories)): ?>
            <div class="text-center text-muted py-4">
                <p>No categories available. Please create study categories first.</p>
                <a href="<?= base_url('admin/study') ?>" class="btn btn-sm btn-primary">Manage Study Categories</a>
            </div>
        <?php endif; ?>
    </div>
</div>

