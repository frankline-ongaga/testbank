<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0">Upload Cheat Sheet</h5>
        <div class="small text-muted"><?= esc($category['name']) ?></div>
    </div>
    <a href="<?= base_url('admin/cheat-sheets/category/' . (int)$category['id'] . '/docs') ?>" class="btn btn-secondary btn-sm">Back</a>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('admin/cheat-sheets/category/' . (int)$category['id'] . '/upload') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">File</label>
                <input type="file" name="cheat_file" class="form-control" accept=".pdf,image/*" required>
                <div class="form-text text-muted">Allowed: PDF or images (JPG, PNG, GIF, WEBP).</div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Upload</button>
                <a href="<?= base_url('admin/cheat-sheets/category/' . (int)$category['id'] . '/docs') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

