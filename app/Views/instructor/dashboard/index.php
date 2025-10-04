<div class="admin-content">
    <h1 class="h3 mb-4">Instructor Dashboard</h1>

    <!-- Stats Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">My Questions</h5>
                    <div class="display-6 mb-2">45</div>
                    <div class="small">8 pending approval</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Active Tests</h5>
                    <div class="display-6 mb-2">12</div>
                    <div class="small">3 new this month</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Student Attempts</h5>
                    <div class="display-6 mb-2">234</div>
                    <div class="small">Last 30 days</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Avg. Score</h5>
                    <div class="display-6 mb-2">76%</div>
                    <div class="small">+3% from last month</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Performance Chart -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Student Performance</h5>
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
                        <a href="<?= base_url('instructor/questions/create') ?>" class="btn btn-primary">
                            <i class="fa-solid fa-plus-circle me-2"></i>Add Question
                        </a>
                        <a href="<?= base_url('instructor/tests/create') ?>" class="btn btn-primary">
                            <i class="fa-solid fa-file-circle-plus me-2"></i>Create Test
                        </a>
                        <a href="<?= base_url('instructor/analytics') ?>" class="btn btn-outline-primary">
                            <i class="fa-solid fa-chart-line me-2"></i>View Analytics
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">New Question Approved</h6>
                                <small class="text-muted">3h ago</small>
                            </div>
                            <p class="mb-1 text-muted small">Your question about "Cardiac Assessment" was approved</p>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Test Completed</h6>
                                <small class="text-muted">5h ago</small>
                            </div>
                            <p class="mb-1 text-muted small">15 students completed "Pediatric Nursing Basics"</p>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">New Test Created</h6>
                                <small class="text-muted">1d ago</small>
                            </div>
                            <p class="mb-1 text-muted small">You created "Mental Health Assessment"</p>
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
                label: 'Average Score',
                data: [72, 75, 73, 76],
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


