<div class="container py-3">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Study Library</h6>
                </div>
                <div class="list-group list-group-flush">
                    <?php foreach (($categories ?? []) as $cat): ?>
                        <a href="<?= base_url('client/study/'.$cat['id'].'/subcategories') ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><?= esc($cat['name']) ?></span>
                            <i class="fas fa-chevron-right text-muted"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-questions" type="button" role="tab">Questions</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-mock" type="button" role="tab">Mock Questions</button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab-questions" role="tabpanel">
            <div class="row g-3">
                <?php foreach (($questions ?? []) as $q): ?>
                    <div class="col-md-12">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="mb-2"><?= $q['stem'] ?></div>
                                <?php if (!empty($q['image_path'])): ?>
                                    <div class="mb-3">
                                        <img src="<?= base_url('client/study/question-image/' . (int)$q['id']) ?>" alt="Question image" class="img-fluid border rounded" style="max-height: 420px;">
                                    </div>
                                <?php endif; ?>
                                <?php $choices = $choicesByQ[$q['id']] ?? []; ?>
                                <div class="row">
                                    <div class="col-6">
                                        <?php foreach ($choices as $c): ?>
                                        <div class="p-2 border rounded mb-2 <?= $c['is_correct'] ? 'bg-success-subtle border-success' : '' ?>">
                                            <div class="fw-semibold">(<?= esc($c['label']) ?>) <?= esc($c['content']) ?></div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-6">
                                        <div class="small fw-bold mb-2">Explanations</div>
                                        <?php foreach ($choices as $c): ?>
                                            <div class="mb-2">
                                                <div class="fw-semibold <?= $c['is_correct'] ? 'text-success' : 'text-danger' ?>">(<?= esc($c['label']) ?>) <?= $c['is_correct'] ? 'Correct' : 'Incorrect' ?></div>
                                                <div class="text-muted small"><?= esc($c['explanation'] ?? '') ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php if (!empty($q['rationale'])): ?>
                                    <div class="mt-3 p-3 bg-light border rounded" style="font-size: 1.05rem;">
                                        <div class="fw-bold mb-1">Rationale</div>
                                        <div><?= nl2br(esc($q['rationale'])) ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-mock" role="tabpanel">
            <?php if (!empty($mockQuestions)): ?>
            <div class="row g-3">
                <?php foreach ($mockQuestions as $mock): ?>
                    <?php $mockChoices = $mockChoicesByQ[(int) $mock['id']] ?? []; ?>
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-2"><?= $mock['stem'] ?></div>
                            <?php if (!empty($mock['image_path'])): ?>
                                <div class="mb-3">
                                    <img src="<?= base_url('client/mock-questions/image/' . (int)$mock['id']) ?>" alt="Mock question image" class="img-fluid border rounded" style="max-height: 420px;">
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <?php foreach ($mockChoices as $choice): ?>
                                        <div class="p-2 border rounded mb-2 <?= $choice['is_correct'] ? 'bg-success-subtle border-success' : '' ?>">
                                            <div class="fw-semibold">(<?= esc($choice['label']) ?>) <?= esc($choice['content']) ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="small fw-bold mb-2">Explanations</div>
                                    <?php foreach ($mockChoices as $choice): ?>
                                        <div class="mb-2">
                                            <div class="fw-semibold <?= $choice['is_correct'] ? 'text-success' : 'text-danger' ?>">(<?= esc($choice['label']) ?>) <?= $choice['is_correct'] ? 'Correct' : 'Incorrect' ?></div>
                                            <div class="text-muted small"><?= esc($choice['explanation'] ?? '') ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php if (!empty($mock['rationale'])): ?>
                                <div class="mt-3 p-3 bg-light border rounded" style="font-size: 1.05rem;">
                                    <div class="fw-bold mb-1">Rationale</div>
                                    <div><?= nl2br(esc($mock['rationale'])) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <div class="text-muted">No mock questions for this subcategory.</div>
            <?php endif; ?>
        </div>
    </div>
        </div>
    </div>
</div>
