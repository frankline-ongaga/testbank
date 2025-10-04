<div class="admin-content">
    <div class="mb-4">
        <h3>Available Tests</h3>
        <p class="text-muted">Choose a test to practice or evaluate your knowledge</p>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <?php foreach (($tests ?? []) as $test): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($test['title']) ?></h5>
                        <div class="mb-3">
                            <span class="badge bg-<?= $test['mode'] === 'practice' ? 'info' : 'warning' ?> me-2">
                                <?= ucfirst(esc($test['mode'])) ?>
                            </span>
                            <?php if ($test['time_limit_minutes']): ?>
                                <span class="badge bg-secondary">
                                    <i class="fa-regular fa-clock me-1"></i>
                                    <?= $test['time_limit_minutes'] ?> mins
                                </span>
                            <?php endif; ?>
                        </div>
                        <p class="card-text text-muted small">
                            <?= ($test['question_count'] ?? 0) ?> questions
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="<?= base_url('client/tests/start/' . $test['id']) ?>" class="btn btn-primary w-100">
                            Start Test
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($tests)): ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="text-muted">No tests available at the moment</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
