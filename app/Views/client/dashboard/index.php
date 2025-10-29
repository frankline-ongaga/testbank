<div class="admin-content">

    <!-- Progress Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Tests Taken</h5>
                    <div class="display-6 mb-2"><?= (int)($metrics['testsTaken'] ?? 0) ?></div>
                    <div class="small">Last test: <?= !empty($metrics['lastTestAt']) ? esc(date('M j, Y', strtotime($metrics['lastTestAt']))) : '—' ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Average Score</h5>
                    <div class="display-6 mb-2"><?= isset($metrics['averageScore']) ? round($metrics['averageScore']) . '%' : '—' ?></div>
                    <div class="small">Last 8 attempts</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Study Time</h5>
                    <div class="display-6 mb-2"><?= esc($metrics['studyHours'] ?? 0) ?>h</div>
                    <div class="small">Last 30 days</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Subscription</h5>
                    <div class="display-6 mb-2"><?= isset($metrics['daysRemaining']) ? (int)$metrics['daysRemaining'] : 0 ?></div>
                    <div class="small">Days remaining</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Performance -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Performance Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="performanceChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('client/tests') ?>" class="btn btn-primary">
                            <i class="fas fa-play me-2"></i>Take a Test
                        </a>
                        <!-- Removed practice quick action to keep menu consistent -->
                        <a href="<?= base_url('client/analytics') ?>" class="btn btn-outline-primary">
                            <i class="fas fa-chart-line me-2"></i>View Analytics
                        </a>
                    </div>
                </div>
            </div>

            <!-- Study Progress -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Attempts</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentAttempts)): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($recentAttempts as $ra): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?= esc(date('M j, Y H:i', strtotime($ra['completed_at'] ?? $ra['started_at'] ?? 'now'))) ?></span>
                                    <span class="badge bg-<?= isset($ra['score']) ? 'success' : 'secondary' ?>">
                                        <?= isset($ra['score']) ? (int)round($ra['score']) . '%' : 'In progress' ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-muted">No attempts yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($trend['labels'] ?? []) ?>,
            datasets: [{
                label: 'Test Scores',
                data: <?= json_encode($trend['scores'] ?? []) ?>,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
});
</script>
