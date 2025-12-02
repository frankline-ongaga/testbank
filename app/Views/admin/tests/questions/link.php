<div class="admin-content">
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0"><?= esc($title ?? 'Link Existing Questions') ?></h3>
        <a href="<?= base_url('admin/tests/' . $test['id'] . '/questions') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('admin/tests/' . $test['id'] . '/questions/link') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" id="qSearch" class="form-control" placeholder="Search questions...">
                        <button type="button" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="question-list" style="max-height:420px; overflow-y:auto;">
                    <?php foreach (($questions ?? []) as $q): ?>
                        <div class="card mb-2 question-item">
                            <div class="card-body py-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="question_ids[]" value="<?= (int)$q['id'] ?>" id="q<?= (int)$q['id'] ?>">
                                    <label class="form-check-label" for="q<?= (int)$q['id'] ?>">
                                        <div class="fw-semibold mb-1">#<?= (int)$q['id'] ?> · <span class="badge bg-info"><?= strtoupper(esc($q['type'] ?? '')) ?></span></div>
                                        <div class="text-muted small"><?= esc(mb_strimwidth($q['stem'] ?? '', 0, 180, '…')) ?></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($questions)): ?>
                        <div class="text-muted small">No available questions to link.</div>
                    <?php endif; ?>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Link Selected</button>
                    <a href="<?= base_url('admin/tests/' . $test['id'] . '/questions') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const search = document.getElementById('qSearch');
    const items = document.querySelectorAll('.question-item');
    search.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        items.forEach(el => {
            el.style.display = el.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
});
</script>




