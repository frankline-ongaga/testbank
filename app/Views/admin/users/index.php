<div class="admin-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Manage Users</h1>
        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
            <i class="fa-solid fa-user-plus me-2"></i>Add User
        </a>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">All Users</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search users...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($users ?? []) as $user): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['username']) ?>&background=random" 
                                             class="rounded-circle me-2" width="32" height="32">
                                        <div>
                                            <div class="fw-medium"><?= esc($user['username']) ?></div>
                                            <div class="text-muted small"><?= esc($user['email']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php foreach (($user['roles'] ?? []) as $role): ?>
                                        <span class="badge bg-primary"><?= ucfirst(esc($role)) ?></span>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $user['status'] === 'active' ? 'success' : 'danger' ?>">
                                        <?= ucfirst(esc($user['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="text-muted">
                                        <?= $user['last_login'] ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'Never' ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <?php if ($user['id'] !== session()->get('user_id')): ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete(<?= $user['id'] ?>)">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">No users found</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        window.location.href = `<?= base_url('admin/users/delete/') ?>${userId}`;
    }
}
</script>

