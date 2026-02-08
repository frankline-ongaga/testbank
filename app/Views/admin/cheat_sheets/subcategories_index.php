<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0"><?= esc($category['name']) ?> - Subcategories</h5>
        <div class="small text-muted">Manage cheat sheets by subcategory</div>
    </div>
    <a href="<?= base_url('admin/cheat-sheets') ?>" class="btn btn-secondary btn-sm">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($subcategories)): ?>
            <div class="text-muted">No subcategories found.</div>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($subcategories as $sub): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold"><?= esc($sub['name']) ?></div>
                            <?php if (!empty($sub['description'])): ?>
                                <div class="small text-muted"><?= esc($sub['description']) ?></div>
                            <?php endif; ?>
                        </div>
                        <a href="<?= base_url('admin/cheat-sheets/subcategory/' . (int)$sub['id'] . '/docs') ?>" class="btn btn-outline-secondary btn-sm">Manage</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

