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
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/questions/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label class="form-label">Question Type</label>
                <select name="type" class="form-control">
                    <option value="mcq">Multiple Choice</option>
                    <option value="sata">Select All That Apply</option>
                </select>
                <div class="form-text text-muted">Choose the type of question you want to create</div>
            </div>

            <div class="mb-4">
                <label class="form-label">Question Text</label>
                <textarea name="stem" class="form-control" rows="5" placeholder="Enter your question here..."><?= old('stem') ?></textarea>
                <div class="form-text text-muted">Write the main question text or stem</div>
            </div>

            <div class="mb-4">
                <label class="form-label">Question Image (optional)</label>
                <input id="question_image" type="file" name="image" class="form-control" accept="image/*">
                <div class="form-text text-muted">Allowed: JPG, PNG, GIF, WEBP. Max 5MB.</div>
                <div id="question_image_preview_wrap" class="mt-2 d-none">
                    <img id="question_image_preview" src="" alt="Selected question image" class="img-fluid border rounded" style="max-height: 320px;">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Rationale</label>
                <textarea name="rationale" class="form-control" rows="4" placeholder="Explain the correct answer..."><?= old('rationale') ?></textarea>
                <div class="form-text text-muted">Provide an explanation for the correct answer</div>
            </div>

            <div class="mb-4">
                <label class="form-label">NCLEX Category</label>
                <select class="form-control" name="term_ids[]">
                    <option value="">-- Select --</option>
                    <?php foreach (($nclex_terms ?? []) as $t): ?>
                        <option value="<?= (int)$t['id'] ?>" <?= old('term_ids') && in_array($t['id'], old('term_ids')) ? 'selected' : '' ?>>
                            <?= esc($t['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text text-muted">Optional: choose an NCLEX category</div>
            </div>

            <div class="mb-4">
                <label class="form-label">Answer Choices</label>
                <div id="choices" class="mb-3">
                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <div class="card border mb-2">
                            <div class="card-body p-3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <input type="text" name="labels[]" 
                                               value="<?= old('labels.' . $i, chr(65 + $i)) ?>" 
                                               class="form-control text-center" 
                                               style="width:60px" />
                                    </div>
                                    <div class="col">
                                        <input type="text" name="contents[]" 
                                               value="<?= old('contents.' . $i) ?>"
                                               class="form-control" 
                                               placeholder="Enter choice text..." />
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="correct[<?= $i ?>]" 
                                                   <?= old('correct.' . $i) ? 'checked' : '' ?> />
                                            <label class="form-check-label">Correct Answer</label>
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
                    <?php endfor; ?>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addChoice()">
                    <i class="fas fa-plus me-2"></i>Add Choice
                </button>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Question
                </button>
                &nbsp;  &nbsp;  &nbsp;
                <a href="<?= base_url('admin/questions') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function addChoice() {
    const choices = document.getElementById('choices');
    const index = choices.children.length;
    const label = String.fromCharCode(65 + index);
    
    const choiceHtml = `
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
                            <input class="form-check-input" type="checkbox" name="correct[${index}]" />
                            <label class="form-check-label">Correct Answer</label>
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
    `;
    
    choices.insertAdjacentHTML('beforeend', choiceHtml);
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
    });
})();
</script>
