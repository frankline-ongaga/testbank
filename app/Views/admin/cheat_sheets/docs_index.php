<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0"><?= esc($subcategory['name']) ?> - Cheat Sheets</h5>
        <div class="small text-muted">Category: <?= esc($category['name']) ?></div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/cheat-sheets/' . (int)$category['id'] . '/subcategories') ?>" class="btn btn-secondary btn-sm">Back</a>
        <a href="<?= base_url('admin/cheat-sheets/subcategory/' . (int)$subcategory['id'] . '/upload') ?>" class="btn btn-primary btn-sm">Upload</a>
    </div>
</div>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<?php if (!empty($cheatSheets)): ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>File</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cheatSheets as $doc): ?>
                    <tr>
                        <td class="fw-semibold"><?= esc($doc['title']) ?></td>
                        <td class="text-muted small"><?= esc($doc['file_name']) ?></td>
                        <td class="text-end">
                            <a href="<?= base_url('admin/cheat-sheets/doc/' . (int)$doc['id'] . '/view') ?>" class="btn btn-outline-primary btn-sm">View</a>
                            <a href="<?= base_url('admin/cheat-sheets/doc/' . (int)$doc['id'] . '/edit') ?>" class="btn btn-outline-secondary btn-sm">Edit</a>
                            <a href="<?= base_url('admin/cheat-sheets/doc/' . (int)$doc['id'] . '/delete') ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this cheat sheet?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-file-image fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No Cheat Sheets</h5>
            <p class="text-muted mb-3">Upload the first cheat sheet for this subcategory.</p>
            <a href="<?= base_url('admin/cheat-sheets/subcategory/' . (int)$subcategory['id'] . '/upload') ?>" class="btn btn-primary">Upload</a>
        </div>
    </div>
<?php endif; ?>

