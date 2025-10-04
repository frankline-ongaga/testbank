<div class="admin-page-header">
    <div class="admin-page-title">
        <h1><?= esc($title ?? 'My Dashboard') ?></h1>
        <p>Welcome back. Access your tests, analytics, and notes.</p>
    </div>
</div>
<div class="admin-content">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="admin-card">
                <div class="admin-card-title">Take a Test</div>
                <a href="/tests" class="btn btn-primary mt-2">Take a Test</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-card">
                <div class="admin-card-title">My Analytics</div>
                <a href="/analytics" class="btn btn-outline-primary mt-2">View Performance</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-card">
                <div class="admin-card-title">Study Notes</div>
                <a href="/notes" class="btn btn-outline-primary mt-2">Browse Notes</a>
            </div>
        </div>
    </div>
</div>