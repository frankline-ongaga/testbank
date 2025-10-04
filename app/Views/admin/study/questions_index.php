<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Study Questions - <?= esc($subcategory['name']) ?></h5>
            <div class="small text-muted">Category: <?= esc($category['name']) ?></div>
        </div>
        <a href="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/question/create') ?>" class="btn btn-primary btn-sm">Add Question</a>
    </div>
    <div class="card-body">
        <?php if (empty($questions)): ?>
            <div class="text-muted">No questions yet.</div>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($questions as $q): ?>
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="me-3">
                            <?= esc(mb_strimwidth(strip_tags($q['stem']), 0, 140, '...')) ?>
                        </div>
                        <div class="d-flex gap-2">
                            <a class="btn btn-outline-primary btn-sm" href="<?= base_url('admin/study/question/'.$q['id'].'/edit') ?>">Edit</a>
                            <a class="btn btn-outline-danger btn-sm" href="<?= base_url('admin/study/question/'.$q['id'].'/delete') ?>" onclick="return confirm('Delete this question?');">Delete</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>


