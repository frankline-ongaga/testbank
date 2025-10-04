<div class="row g-3">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Total Tests</div>
                <div class="h3 mb-0"><?= esc($total_tests ?? 0) ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Total Attempts</div>
                <div class="h3 mb-0"><?= esc($total_attempts ?? 0) ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Average Score</div>
                <div class="h3 mb-0"><?= number_format((float)($avg_score ?? 0), 1) ?>%</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Users</div>
                <div class="h3 mb-0"><?= esc($total_users ?? 0) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Attempts</h5>
        <a href="<?= base_url('client/analytics/categories') ?>" class="btn btn-sm btn-outline-primary">Category Insights</a>
    </div>
    <div class="card-body">
        <?php if (!empty($recent_attempts)): ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Attempt #</th>
                            <th>Score</th>
                            <th>Date</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_attempts as $a): ?>
                            <tr>
                                <td>#<?= esc($a['id']) ?></td>
                                <td><?= esc($a['score'] ?? 0) ?>%</td>
                                <td><?= date('M j, Y H:i', strtotime($a['created_at'] ?? 'now')) ?></td>
                                <td>
                                    <a class="btn btn-sm btn-outline-primary" href="<?= base_url('client/tests/results/' . $a['id']) ?>">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-muted">No recent attempts yet.</div>
        <?php endif; ?>
    </div>
</div>

