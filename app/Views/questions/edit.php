<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Edit Question</h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/questions/update/' . (int)$question['id']) ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="form-label">Question Type</label>
                <select name="type" class="form-control">
                    <option value="mcq" <?= $question['type'] === 'mcq' ? 'selected' : '' ?>>Multiple Choice</option>
                    <option value="sata" <?= $question['type'] === 'sata' ? 'selected' : '' ?>>Select All That Apply</option>
                </select>
                <div class="form-text">Choose the type of question</div>
            </div>

            <div class="mb-4">
                <label class="form-label">Question Text</label>
                <textarea name="stem" class="form-control" rows="5" required><?= esc($question['stem']) ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Question Image</label>
                <?php if (!empty($question['media_path'])): ?>
                    <div class="mb-2">
                        <img id="question_image_current" src="<?= base_url('admin/questions/media/' . (int)$question['id']) ?>" alt="Question image" class="img-fluid border rounded" style="max-height: 320px;">
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image">
                        <label class="form-check-label" for="remove_image">Remove current image</label>
                    </div>
                <?php endif; ?>
                <div class="<?= !empty($question['media_path']) ? 'mt-2' : '' ?>">
                    <input id="question_image" type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="form-text">Allowed: JPG, PNG, GIF, WEBP. Max 5MB.</div>
                <div id="question_image_preview_wrap" class="mt-2 d-none">
                    <img id="question_image_preview" src="" alt="Selected question image" class="img-fluid border rounded" style="max-height: 320px;">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Rationale</label>
                <textarea name="rationale" class="form-control" rows="4"><?= esc($question['rationale'] ?? '') ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Answer Choices</label>
                <div id="choices" class="mb-3">
                    <?php foreach ($choices as $i => $c): ?>
                        <div class="card border mb-2">
                            <div class="card-body p-3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <input type="text" name="labels[]" value="<?= esc($c['label']) ?>" class="form-control text-center" style="width:60px" />
                                    </div>
                                    <div class="col">
                                        <input type="text" name="contents[]" value="<?= esc($c['content']) ?>" class="form-control" />
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="correct[<?= $i ?>]" <?= (int)$c['is_correct'] === 1 ? 'checked' : '' ?> />
                                            <label class="form-check-label">Correct</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeChoice(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addChoice()">
                    <i class="fas fa-plus me-2"></i>Add Choice
                </button>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
                <a href="<?= base_url('admin/questions') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function addChoice() {
    const idx = document.querySelectorAll('#choices > .card').length;
    const label = String.fromCharCode(65 + idx);
    const tpl = `
        <div class="card border mb-2">
            <div class="card-body p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <input type="text" name="labels[]" value="${label}" class="form-control text-center" style="width:60px" />
                    </div>
                    <div class="col">
                        <input type="text" name="contents[]" class="form-control" placeholder="Enter choice text..." />
                    </div>
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="correct[${idx}]" />
                            <label class="form-check-label">Correct</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeChoice(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
    document.getElementById('choices').insertAdjacentHTML('beforeend', tpl);
}

function removeChoice(btn) {
    const card = btn.closest('.card');
    if (card) card.remove();
}
</script>

<script>
(() => {
    const input = document.getElementById('question_image');
    const wrap = document.getElementById('question_image_preview_wrap');
    const img = document.getElementById('question_image_preview');
    const removeToggle = document.getElementById('remove_image');
    if (!input || !wrap || !img) return;

    input.addEventListener('change', () => {
        const file = input.files && input.files[0];
        if (!file || !file.type || !file.type.startsWith('image/')) {
            wrap.classList.add('d-none');
            img.src = '';
            return;
        }
        img.src = URL.createObjectURL(file);
        wrap.classList.remove('d-none');
        if (removeToggle) removeToggle.checked = false;
    });
})();
</script>


