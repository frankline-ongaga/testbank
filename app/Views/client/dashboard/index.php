<div class="admin-content">
    <h1 class="h3 mb-4">My Dashboard</h1>

    <!-- Progress Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Tests Taken</h5>
                    <div class="display-6 mb-2">12</div>
                    <div class="small">Last test: 2 days ago</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Average Score</h5>
                    <div class="display-6 mb-2">78%</div>
                    <div class="small">+5% improvement</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Study Time</h5>
                    <div class="display-6 mb-2">24h</div>
                    <div class="small">This month</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Subscription</h5>
                    <div class="display-6 mb-2">28</div>
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
                            <i class="fa-solid fa-play me-2"></i>Take a Test
                        </a>
                        <!-- Removed practice quick action to keep menu consistent -->
                        <a href="<?= base_url('client/analytics') ?>" class="btn btn-outline-primary">
                            <i class="fa-solid fa-chart-line me-2"></i>View Analytics
                        </a>
                    </div>
                </div>
            </div>

            <!-- Study Progress -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Category Progress</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Medical-Surgical</span>
                            <span>85%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Pediatric Nursing</span>
                            <span>70%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: 70%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Mental Health</span>
                            <span>60%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 60%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Pharmacology</span>
                            <span>75%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width: 75%"></div>
                        </div>
                    </div>
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
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Test Scores',
                data: [65, 72, 78, 75],
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
