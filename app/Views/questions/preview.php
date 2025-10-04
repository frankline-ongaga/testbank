<div class="card" style="max-width:900px;">
    <div class="card-header">
        <h5 class="mb-0">Preview Question</h5>
    </div>
    <div class="card-body">
        <div class="mb-2">Type: <span class="badge bg-info"><?= strtoupper(esc($question['type'])) ?></span></div>
        <div class="mb-3">
            <?= $question['stem'] ?>
        </div>
        <div>
            <?php foreach ($choices as $c): ?>
                <div class="p-2 border rounded mb-2 <?= (int)$c['is_correct'] === 1 ? 'bg-success-subtle border-success' : '' ?>">
                    <strong>(<?= esc($c['label']) ?>)</strong> <?= esc($c['content']) ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (!empty($question['rationale'])): ?>
            <div class="mt-3 p-2 bg-light border small">Rationale: <?= esc($question['rationale']) ?></div>
        <?php endif; ?>
    </div>
</div>



