<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Cheat Sheets</h5>
        <div class="small text-muted">Upload and manage cheat sheets (PDFs or images) by study category.</div>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <?php if (empty($categories)): ?>
            <div class="text-muted">No categories found.</div>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($categories as $cat): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold"><?= esc($cat['name']) ?></div>
                            <?php if (!empty($cat['description'])): ?>
                                <div class="small text-muted"><?= esc($cat['description']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('admin/cheat-sheets/category/' . (int)$cat['id'] . '/docs') ?>" class="btn btn-outline-secondary btn-sm">Manage</a>
                            <a href="<?= base_url('admin/cheat-sheets/category/' . (int)$cat['id'] . '/upload') ?>" class="btn btn-primary btn-sm">Upload</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

