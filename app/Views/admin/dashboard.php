<!-- Stats Grid -->
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-value">1,247</div>
        <div class="admin-stat-label">Total Users</div>
        <div class="admin-stat-change positive">+12% from last month</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-value">89</div>
        <div class="admin-stat-label">Active Tests</div>
        <div class="admin-stat-change positive">+5% from last month</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-value">3,421</div>
        <div class="admin-stat-label">Questions</div>
        <div class="admin-stat-change positive">+18% from last month</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-value">$12,847</div>
        <div class="admin-stat-label">Revenue</div>
        <div class="admin-stat-change positive">+23% from last month</div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Performance Overview</div>
                <div class="card-subtitle">Student test scores over the last 30 days</div>
            </div>
            <div class="card-body">
                <canvas id="performanceChart" height="120"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <div class="card-title">Quick Actions</div>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= base_url('admin/viewUsers'); ?>" class="btn btn-outline-primary">
                        <i class="fa-solid fa-users me-2"></i>
                        Manage Users
                    </a>
                    <a href="<?= base_url('admin/questions/pending'); ?>" class="btn btn-outline-primary">
                        <i class="fa-solid fa-circle-question me-2"></i>
                        Review Questions
                    </a>
                    <a href="<?= base_url('admin/questions/create'); ?>" class="btn btn-outline-success">
                        <i class="fa-solid fa-plus me-2"></i>
                        Add Question
                    </a>
                    <a href="<?= base_url('admin/tests/create'); ?>" class="btn btn-outline-success">
                        <i class="fa-solid fa-file-plus me-2"></i>
                        Create Test
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="card-title">System Status</div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i class="fa-solid fa-circle text-success"></i>
                    </div>
                    <div>
                        <div class="fw-medium">Database</div>
                        <div class="text-muted small">Connected</div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i class="fa-solid fa-circle text-success"></i>
                    </div>
                    <div>
                        <div class="fw-medium">PayPal API</div>
                        <div class="text-muted small">Active</div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa-solid fa-circle text-warning"></i>
                    </div>
                    <div>
                        <div class="fw-medium">Email Service</div>
                        <div class="text-muted small">Limited</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart');
    if (!ctx) return;
    
    const data = {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        datasets: [
            {
                label: 'Average Score',
                data: [72, 75, 78, 81],
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Pass Rate',
                data: [68, 71, 74, 77],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }
        ]
    };
    
    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: 60,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    };
    
    new Chart(ctx, config);
});</script>