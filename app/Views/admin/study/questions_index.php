<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Study Questions - <?= esc($subcategory['name']) ?></h5>
            <div class="small text-muted">Category: <?= esc($category['name']) ?></div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/questions/template') ?>" class="btn btn-outline-secondary btn-sm">Download Template</a>
            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#importForm" aria-expanded="false" aria-controls="importForm">Import CSV</button>
            <a href="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/question/create') ?>" class="btn btn-primary btn-sm">Add Question</a>
        </div>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="collapse mb-3" id="importForm">
            <div class="card card-body border border-2 border-dashed">
                <form action="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/questions/import') ?>" method="post" enctype="multipart/form-data" class="row g-2 align-items-center">
                    <?= csrf_field() ?>
                    <div class="col-12">
                        <p class="mb-1 small text-muted">Upload CSV saved from Excel. Required columns: stem, choice_a, choice_b. Optional: rationale, topic, choice_*_correct (1/yes), choice_*_explanation.</p>
                    </div>
                    <div class="col-md-6">
                        <input type="file" name="questions_file" accept=".csv" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-6 d-flex gap-2">
                        <button class="btn btn-primary btn-sm" type="submit">Import</button>
                        <a href="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/questions/template') ?>" class="btn btn-outline-secondary btn-sm">Download Template</a>
                    </div>
                </form>
            </div>
        </div>

        <?php if (empty($questions)): ?>
            <div class="text-muted">No questions yet.</div>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($questions as $q): ?>
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="me-3">
                            <?= esc(mb_strimwidth(strip_tags($q['stem']), 0, 140, '...')) ?>
                            <?php if (!empty($q['image_path'])): ?>
                                <span class="badge text-bg-secondary ms-2">Image</span>
                            <?php endif; ?>
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
