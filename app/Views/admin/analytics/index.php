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
                <h5 class="card-title">Active Users</h5>
                <div class="display-6 mb-2"><?= number_format($total_users) ?></div>
                <div class="small">Last 30 days</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Questions Used</h5>
                <div class="display-6 mb-2">85%</div>
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