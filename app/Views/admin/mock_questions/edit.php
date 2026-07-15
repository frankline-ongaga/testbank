<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Mock Test - <?= esc($subcategory['name'] ?? 'Mock Tests') ?></h5>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('admin/mock-questions/' . (int) $question['id'] . '/update') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Question</label>
                <textarea name="stem" class="form-control" rows="4" required><?= esc(old('stem', $question['stem'] ?? '')) ?></textarea>
            </div>

            <?php if (!empty($question['image_path'])): ?>
                <div class="mb-3">
                    <label class="form-label">Current image</label>
                    <div>
                        <img src="<?= base_url('admin/mock-questions/image/' . (int) $question['id']) ?>" alt="Current mock test image" class="img-fluid border rounded" style="max-height: 320px;">
                    </div>
                    <label class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remove_image" value="1">
                        <span class="form-check-label">Remove current image</span>
                    </label>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Replace image (optional)</label>
                <input id="mock_question_image" type="file" name="image" class="form-control" accept="image/*">
                <div class="form-text text-muted">Allowed: JPG, PNG, GIF, WEBP. Max 5MB.</div>
                <div id="mock_question_image_preview_wrap" class="mt-2 d-none">
                    <img id="mock_question_image_preview" src="" alt="Selected question image" class="img-fluid border rounded" style="max-height: 320px;">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Rationale</label>
                <textarea name="rationale" class="form-control" rows="3"><?= esc(old('rationale', $question['rationale'] ?? '')) ?></textarea>
            </div>

            <?= view('admin/mock_questions/partials/choices', ['choices' => $choices ?? []]) ?>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Update Mock Test</button>
                <a href="<?= base_url('admin/mock-questions/subcategory/' . (int) ($subcategory['id'] ?? $question['subcategory_id']) . '/questions') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= view('admin/mock_questions/partials/image_preview_script') ?>
