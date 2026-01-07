<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add Study Question - <?= esc($subcategory['name']) ?></h5>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <form method="post" action="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/question/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0">Topic</label>
                    <a class="btn btn-outline-secondary btn-sm" href="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/qcategories') ?>" target="_blank">Manage Topics</a>
                </div>
                <select class="form-control mt-2" name="study_question_category_id">
                    <option value="">-- None --</option>
                    <?php foreach (($question_categories ?? []) as $qc): ?>
                        <option value="<?= (int)$qc['id'] ?>"><?= esc($qc['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text text-muted">Optional: group questions under a custom topic for this subcategory.</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Question</label>
                <textarea name="stem" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Question image (optional)</label>
                <input id="question_image" type="file" name="image" class="form-control" accept="image/*">
                <div class="form-text text-muted">Allowed: JPG, PNG, GIF, WEBP. Max 5MB.</div>
                <div id="question_image_preview_wrap" class="mt-2 d-none">
                    <img id="question_image_preview" src="" alt="Selected question image" class="img-fluid border rounded" style="max-height: 320px;">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Rationale (general)</label>
                <textarea name="rationale" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Choices</label>
                <div id="choices">
                    <?php for ($i=0; $i<4; $i++): ?>
                    <div class="border rounded p-3 mb-2">
                        <div class="row g-2 align-items-center">
                            <div class="col-auto">
                                <input type="text" name="labels[]" value="<?= chr(65+$i) ?>" class="form-control text-center" style="width:60px" />
                            </div>
                            <div class="col">
                                <input type="text" name="contents[]" class="form-control" placeholder="Answer text" />
                            </div>
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="correct[<?= $i ?>]" />
                                    <label class="form-check-label">Correct</label>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <input type="text" name="explanations[]" class="form-control" placeholder="Explanation for this choice (why correct/incorrect)" />
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                <button type="button" onclick="addChoice()" class="btn btn-outline-secondary btn-sm">Add Choice</button>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Save</button>
                <a href="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/questions') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function addChoice() {
    const idx = document.querySelectorAll('#choices > .border').length;
    const label = String.fromCharCode(65 + idx);
    const tpl = `
        <div class="border rounded p-3 mb-2">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <input type="text" name="labels[]" value="${label}" class="form-control text-center" style="width:60px" />
                </div>
                <div class="col">
                    <input type="text" name="contents[]" class="form-control" placeholder="Answer text" />
                </div>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="correct[${idx}]" />
                        <label class="form-check-label">Correct</label>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <input type="text" name="explanations[]" class="form-control" placeholder="Explanation for this choice (why correct/incorrect)" />
                </div>
            </div>
        </div>`;
    document.getElementById('choices').insertAdjacentHTML('beforeend', tpl);
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
        if (!file) {
            wrap.classList.add('d-none');
            img.src = '';
            return;
        }
        if (!file.type || !file.type.startsWith('image/')) {
            wrap.classList.add('d-none');
            img.src = '';
            return;
        }
        img.src = URL.createObjectURL(file);
        wrap.classList.remove('d-none');
    });
})();
</script>
