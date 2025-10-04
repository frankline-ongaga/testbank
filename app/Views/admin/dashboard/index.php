<div class="admin-content">
    <h1 class="h3 mb-4">Dashboard Overview</h1>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <div class="display-6 mb-2">1,247</div>
                    <div class="small">+12% from last month</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Active Tests</h5>
                    <div class="display-6 mb-2">89</div>
                    <div class="small">+5% from last month</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Questions</h5>
                    <div class="display-6 mb-2">3,421</div>
                    <div class="small">+18% from last month</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Revenue</h5>
                    <div class="display-6 mb-2">$12,847</div>
                    <div class="small">+23% from last month</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Performance Chart -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Performance Overview</h5>
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
                        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
                            <i class="fa-solid fa-user-plus me-2"></i>Add User
                        </a>
                        <a href="<?= base_url('admin/questions/create') ?>" class="btn btn-primary">
                            <i class="fa-solid fa-plus-circle me-2"></i>Add Question
                        </a>
                        <a href="<?= base_url('admin/tests/create') ?>" class="btn btn-primary">
                            <i class="fa-solid fa-file-circle-plus me-2"></i>Create Test
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">System Status</h5>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Test Attempts',
                data: [65, 59, 80, 81, 56, 55],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>

