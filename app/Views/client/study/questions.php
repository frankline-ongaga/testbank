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
                            <i class="fa-solid fa-chevron-right text-muted"></i>
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
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-notes" type="button" role="tab">Study Notes</button>
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
                                        <?php if (!empty($q['rationale'])): ?>
                                            <div class="mt-2 p-2 bg-light border small">General: <?= esc($q['rationale']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-notes" role="tabpanel">
            <?php if (!empty($notes)): ?>
            <div class="row row-cols-1 row-cols-md-2 g-3">
                <?php foreach ($notes as $note): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="mb-1"><?= esc($note['title']) ?></h6>
                            <div class="text-muted small mb-2">By <?= esc($note['author_name']) ?> • <?= date('M j, Y', strtotime($note['created_at'])) ?></div>
                            <div class="text-muted small"><?= character_limiter(strip_tags($note['content']), 160) ?></div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="<?= base_url('client/notes/' . $note['id']) ?>" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <div class="text-muted">No study notes for this subcategory.</div>
            <?php endif; ?>
        </div>
    </div>
        </div>
    </div>
</div>


