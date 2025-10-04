<div class="admin-page-header">
    <div class="admin-page-title">
        <h1><?= esc($title ?? 'Instructor Dashboard') ?></h1>
        <p>Quick overview of your authored content</p>
    </div>
</div>
<div class="admin-content">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="admin-card">
                <div class="admin-card-title">Create Question</div>
                <a href="/questions/create" class="btn btn-primary mt-2">Add New</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-card">
                <div class="admin-card-title">My Questions</div>
                <a href="/questions" class="btn btn-outline-primary mt-2">View</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-card">
                <div class="admin-card-title">Build Test</div>
                <a href="/tests/create" class="btn btn-outline-primary mt-2">Start</a>
            </div>
        </div>
    </div>
</div>