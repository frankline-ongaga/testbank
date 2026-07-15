<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add Mock Test - <?= esc($subcategory['name']) ?></h5>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('admin/mock-questions/subcategory/' . (int) $subcategory['id'] . '/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Question</label>
                <textarea name="stem" class="form-control" rows="4" required><?= esc(old('stem')) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Question image (optional)</label>
                <input id="mock_question_image" type="file" name="image" class="form-control" accept="image/*">
                <div class="form-text text-muted">Allowed: JPG, PNG, GIF, WEBP. Max 5MB.</div>
                <div id="mock_question_image_preview_wrap" class="mt-2 d-none">
                    <img id="mock_question_image_preview" src="" alt="Selected question image" class="img-fluid border rounded" style="max-height: 320px;">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Rationale</label>
                <textarea name="rationale" class="form-control" rows="3"><?= esc(old('rationale')) ?></textarea>
            </div>

            <?= view('admin/mock_questions/partials/choices', ['choices' => []]) ?>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Save Mock Test</button>
                <a href="<?= base_url('admin/mock-questions/subcategory/' . (int) $subcategory['id'] . '/questions') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= view('admin/mock_questions/partials/image_preview_script') ?>
