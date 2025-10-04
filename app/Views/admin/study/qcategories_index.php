<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Topics - <?= esc($subcategory['name']) ?></h5>
            <div class="small text-muted">Category: <?= esc($category['name']) ?></div>
        </div>
        <a href="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/qcategories/create') ?>" class="btn btn-primary btn-sm">Add Topic</a>
    </div>
    <div class="card-body">
        <?php if (empty($qcategories)): ?>
            <div class="text-muted">No topics yet.</div>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($qcategories as $qc): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div><?= esc($qc['name']) ?></div>
                    <div class="d-flex gap-2">
                        <a class="btn btn-outline-primary btn-sm" href="<?= base_url('admin/study/qcategories/'.$qc['id'].'/edit') ?>">Edit</a>
                        <a class="btn btn-outline-danger btn-sm" href="<?= base_url('admin/study/qcategories/'.$qc['id'].'/delete') ?>" onclick="return confirm('Delete this question category?');">Delete</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>


