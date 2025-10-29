<div class="admin-content">
    <style>
        .test-grid { align-items: stretch; }
        .test-card { border: 2px solid #e5e7eb; border-radius: 16px; transition: all .25s ease; overflow: hidden; }
        .test-card:hover { transform: translateY(-6px); box-shadow: 0 18px 36px rgba(0,0,0,.12); border-color: #6366f1; }
        .test-accent { height: 6px; background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 50%, #06b6d4 100%); }
        .test-card .card-body { padding-top: 1rem; }
        .test-title { font-weight: 700; color: #111827; }
        .test-meta .badge { font-weight: 600; }
        .btn-start { font-weight: 700; letter-spacing: .2px; }
        .empty-card { background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%); border: 0; }
    </style>
    <div class="mb-4">
        <p class="text-muted">Choose a test to practice or evaluate your knowledge</p>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (!empty($freeTests)): ?>
    <h4 class="mb-2">Free Tests</h4>
    <div class="row g-4 test-grid mb-4">
        <?php foreach (($freeTests ?? []) as $test): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 test-card">
                    <div class="test-accent"></div>
                    <div class="card-body">
                        <h5 class="card-title test-title mb-2"><i class="far fa-file-lines me-1 text-primary"></i>&nbsp;&nbsp;<?= esc($test['title']) ?></h5>
                        <div class="mb-3 test-meta">
                            <span class="badge bg-<?= $test['mode'] === 'practice' ? 'info' : 'warning' ?> me-2">
                                <?= ucfirst(esc($test['mode'])) ?>
                            </span>
                            <?php if ($test['time_limit_minutes']): ?>
                                <span class="badge bg-secondary">
                                    <i class="far fa-clock me-1"></i>
                                    <?= $test['time_limit_minutes'] ?> mins
                                </span>
                            <?php endif; ?>
                        </div>
                        <p class="card-text text-muted small">
                            <?= ($test['question_count'] ?? 0) ?> questions
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="<?= base_url('client/tests/start-free/' . $test['id']) ?>" class="btn btn-success w-100 btn-start">
                            <i class="fas fa-play me-1"></i> Start Free Test
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <h4 class="mb-2">Paid Tests</h4>
    <div class="row g-4 test-grid">
        <?php foreach (($paidTests ?? []) as $test): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 test-card">
                    <div class="test-accent"></div>
                    <div class="card-body">
                        <h5 class="card-title test-title mb-2"><i class="far fa-file-lines me-1 text-primary"></i>&nbsp;&nbsp;<?= esc($test['title']) ?></h5>
                        <div class="mb-3 test-meta">
                            <span class="badge bg-<?= $test['mode'] === 'practice' ? 'info' : 'warning' ?> me-2">
                                <?= ucfirst(esc($test['mode'])) ?>
                            </span>
                            <?php if ($test['time_limit_minutes']): ?>
                                <span class="badge bg-secondary">
                                    <i class="far fa-clock me-1"></i>
                                    <?= $test['time_limit_minutes'] ?> mins
                                </span>
                            <?php endif; ?>
                        </div>
                        <p class="card-text text-muted small">
                            <?= ($test['question_count'] ?? 0) ?> questions
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <?php if (!empty($hasSubscription)): ?>
                        <a href="<?= base_url('client/tests/start/' . $test['id']) ?>" class="btn btn-primary w-100 btn-start">
                            <i class="fas fa-play me-1"></i> Start Test
                        </a>
                        <?php else: ?>
                        <a href="<?= base_url('client/subscription') ?>" class="btn btn-outline-primary w-100 btn-start">
                            <i class="fas fa-lock me-1"></i> Subscribe to Access
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($paidTests)): ?>
            <div class="col-12">
                <div class="card empty-card">
                    <div class="card-body text-center py-5">
                        <div class="h5 mb-2">No paid tests available</div>
                        <div class="text-muted">Please check back later</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
