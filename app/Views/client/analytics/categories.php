<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Category Analytics</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($categories)): ?>
            <div class="row g-3">
                <?php foreach ($categories as $cat): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0"><?= esc($cat['name']) ?></h6>
                                    <span class="badge bg-secondary"><?= esc($cat['questions']) ?> Qs</span>
                                </div>
                                <div class="text-muted small mb-1">Average Score</div>
                                <div class="h5"><?= esc($cat['avg_score']) ?>%</div>
                                <div class="text-muted small mb-1">Usage</div>
                                <div class="h5"><?= esc($cat['usage']) ?>%</div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-muted">No category analytics to display.</div>
        <?php endif; ?>
    </div>
</div>


