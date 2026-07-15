<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Mock Tests - <?= esc($subcategory['name']) ?></h5>
            <div class="small text-muted">Category: <?= esc($category['name'] ?? 'Study Library') ?></div>
        </div>
        <a href="<?= base_url('admin/mock-questions/subcategory/' . (int) $subcategory['id'] . '/create') ?>" class="btn btn-primary btn-sm">Add Mock Test</a>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <?php if (empty($questions)): ?>
            <div class="text-muted">No mock tests have been added for this subcategory yet.</div>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($questions as $question): ?>
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <?= esc(mb_strimwidth(strip_tags((string) $question['stem']), 0, 150, '...')) ?>
                                <?php if (!empty($question['image_path'])): ?>
                                    <span class="badge text-bg-secondary ms-2">Image</span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex gap-2">
                                <a class="btn btn-outline-primary btn-sm" href="<?= base_url('admin/mock-questions/' . (int) $question['id'] . '/edit') ?>">Edit</a>
                                <a class="btn btn-outline-danger btn-sm" href="<?= base_url('admin/mock-questions/' . (int) $question['id'] . '/delete') ?>" onclick="return confirm('Delete this mock test?');">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
