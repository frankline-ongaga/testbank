<!-- Tabs -->
<ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#clientsTab" type="button" role="tab">Clients & Payments</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#testsTab" type="button" role="tab">Tests & Performance</button>
    </li>
</ul>

<div class="tab-content">
<div class="tab-pane fade show active" id="clientsTab" role="tabpanel">
    <!-- Clients & Payments KPIs -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Clients</h5>
                    <div class="display-6 mb-2"><?= number_format($total_clients ?? 0) ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Subscribed Clients</h5>
                    <div class="display-6 mb-2"><?= number_format($subscribed_clients ?? 0) ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Unsubscribed</h5>
                    <div class="display-6 mb-2"><?= number_format($unsubscribed_clients ?? 0) ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Revenue (30d)</h5>
                    <div class="display-6 mb-2">$<?= number_format($revenue_30d ?? 0, 2) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Latest Payments</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Order ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($latest_payments)): foreach ($latest_payments as $p): ?>
                                    <tr>
                                        <td><?= esc(date('Y-m-d H:i', strtotime($p['created_at'] ?? 'now'))) ?></td>
                                        <td><?= esc($p['user_first_name'] ?: $p['user_email'] ?: ('#'.$p['user_id'])) ?></td>
                                        <td><?= esc(ucfirst($p['subscription_plan'] ?? '-')) ?></td>
                                        <td><span class="badge bg-<?= ($p['status'] ?? '') === 'COMPLETED' ? 'success' : 'secondary' ?>"><?= esc($p['status'] ?? '-') ?></span></td>
                                        <td>$<?= esc(number_format((float)($p['amount'] ?? 0), 2)) ?> <?= esc($p['currency'] ?? 'USD') ?></td>
                                        <td class="text-truncate" style="max-width: 180px;" title="<?= esc($p['paypal_order_id'] ?? '-') ?>"><?= esc($p['paypal_order_id'] ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="6" class="text-muted">No payments yet.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header"><h5 class="card-title mb-0">Order Metrics (30d)</h5></div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">Average Order: $<?= number_format($avg_order_30d ?? 0, 2) ?></li>
                        <li class="mb-2">Failed Payments: <?= number_format($failed_payments_30d ?? 0) ?></li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Package Performance</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Active Clients</th>
                                    <th>Total Subs</th>
                                    <th>Payments (30d)</th>
                                    <th>Revenue (30d)</th>
                                    <th>Avg Order (30d)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($package_performance)): foreach ($package_performance as $plan => $row): ?>
                                    <tr>
                                        <td><?= esc(ucfirst($plan)) ?></td>
                                        <td><?= number_format($row['active_clients'] ?? 0) ?></td>
                                        <td><?= number_format($row['total_subscriptions'] ?? 0) ?></td>
                                        <td><?= number_format($row['payments_30d'] ?? 0) ?></td>
                                        <td>$<?= number_format($row['revenue_30d'] ?? 0, 2) ?></td>
                                        <td>$<?= number_format($row['avg_order_30d'] ?? 0, 2) ?></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="6" class="text-muted">No data yet.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="tab-pane fade" id="testsTab" role="tabpanel">
<!-- Stats Overview -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Tests Taken</h5>
                <div class="display-6 mb-2"><?= number_format($total_attempts) ?></div>
                <div class="small">+12% from last month</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Average Score</h5>
                <div class="display-6 mb-2"><?= number_format($avg_score, 1) ?>%</div>
                <div class="small">+3% improvement</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Active Users (30d)</h5>
                <div class="display-6 mb-2"><?= number_format($active_users ?? 0) ?></div>
                <div class="small">Distinct users with attempts</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Questions Used</h5>
                <div class="display-6 mb-2"><?= number_format($questions_used_pct ?? 0, 1) ?>%</div>
                <div class="small">Of total questions</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Performance Trends -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Performance Trends</h5>
            </div>
            <div class="card-body">
                <canvas id="trendsChart" height="300"></canvas>
            </div>
        </div>

        <!-- Category Performance -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Category Performance</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Questions</th>
                                <th>Avg. Score</th>
                                <th>Usage</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= esc($category['name']) ?></td>
                                    <td><?= number_format($category['questions']) ?></td>
                                    <td><?= number_format($category['avg_score']) ?>%</td>
                                    <td>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" style="width: <?= $category['usage'] ?>%"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-<?= $category['trend'] >= 0 ? 'success' : 'danger' ?>">
                                            <?= $category['trend'] >= 0 ? '↑' : '↓' ?> <?= abs($category['trend']) ?>%
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Question Stats -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Question Statistics</h5>
            </div>
            <div class="card-body">
                <canvas id="questionStats" height="200"></canvas>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Activity</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php foreach ($recent_activities as $activity): ?>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?= esc($activity['title']) ?></h6>
                                <small class="text-muted"><?= esc($activity['time']) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Trends Chart
    new Chart(document.getElementById('trendsChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: <?= json_encode($monthly_stats['labels']) ?>,
            datasets: [{
                label: 'Average Score',
                data: <?= json_encode($monthly_stats['scores']) ?>,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }, {
                label: 'Test Attempts',
                data: <?= json_encode($monthly_stats['attempts']) ?>,
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Question Stats Chart
    new Chart(document.getElementById('questionStats').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Easy', 'Medium', 'Hard'],
            datasets: [{
                data: [
                    <?= $question_stats['easy'] ?>,
                    <?= $question_stats['medium'] ?>,
                    <?= $question_stats['hard'] ?>
                ],
                backgroundColor: [
                    'rgb(75, 192, 192)',
                    'rgb(255, 205, 86)',
                    'rgb(255, 99, 132)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});</script>