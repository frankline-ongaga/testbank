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
        <h5 class="card-title mb-0">Create New Question</h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/questions/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label class="form-label">Question Type</label>
                <select name="type" class="form-control">
                    <option value="mcq">Multiple Choice</option>
                    <option value="sata">Select All That Apply</option>
                </select>
                <div class="form-text">Choose the type of question you want to create</div>
            </div>

            <div class="mb-4">
                <label class="form-label">Question Text</label>
                <textarea name="stem" class="form-control" rows="5" placeholder="Enter your question here..."><?= old('stem') ?></textarea>
                <div class="form-text">Write the main question text or stem</div>
            </div>

            <div class="mb-4">
                <label class="form-label">Rationale</label>
                <textarea name="rationale" class="form-control" rows="4" placeholder="Explain the correct answer..."><?= old('rationale') ?></textarea>
                <div class="form-text">Provide an explanation for the correct answer</div>
            </div>

            <div class="mb-4">
                <label class="form-label">Categories & Tags</label>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">NCLEX Category</label>
                        <select class="form-control" name="term_ids[]">
                            <option value="">-- Select --</option>
                            <?php foreach (($nclex_terms ?? []) as $t): ?>
                                <option value="<?= (int)$t['id'] ?>" <?= old('term_ids') && in_array($t['id'], old('term_ids')) ? 'selected' : '' ?>>
                                    <?= esc($t['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Difficulty Level</label>
                        <select class="form-control" name="term_ids[]">
                            <option value="">-- Select --</option>
                            <?php foreach (($difficulty_terms ?? []) as $t): ?>
                                <option value="<?= (int)$t['id'] ?>" <?= old('term_ids') && in_array($t['id'], old('term_ids')) ? 'selected' : '' ?>>
                                    <?= esc($t['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Bloom's Level</label>
                        <select class="form-control" name="term_ids[]">
                            <option value="">-- Select --</option>
                            <?php foreach (($bloom_terms ?? []) as $t): ?>
                                <option value="<?= (int)$t['id'] ?>" <?= old('term_ids') && in_array($t['id'], old('term_ids')) ? 'selected' : '' ?>>
                                    <?= esc($t['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
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
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addChoice()">
                    <i class="fa-solid fa-plus me-2"></i>Add Choice
                </button>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save me-2"></i>Save Question
                </button>
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
                </div>
            </div>
        </div>
    `;
    
    choices.insertAdjacentHTML('beforeend', choiceHtml);
}
</script>