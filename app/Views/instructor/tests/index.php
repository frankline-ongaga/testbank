<div class="admin-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>My Tests</h3>
            <p class="text-muted mb-0">Manage your created tests</p>
        </div>
        <a href="<?= base_url('instructor/tests/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create Test
        </a>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Mode</th>
                            <th>Questions</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($tests ?? []) as $test): ?>
                            <tr>
                                <td><?= esc($test['title']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $test['mode'] === 'practice' ? 'info' : 'warning' ?>">
                                        <?= ucfirst(esc($test['mode'])) ?>
                                    </span>
                                </td>
                                <td><?= $test['question_count'] ?? '0' ?></td>
                                <td>
                                    <span class="badge bg-<?= $test['status'] === 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst(esc($test['status'])) ?>
                                    </span>
                                </td>
                                <td><?= date('M j, Y', strtotime($test['created_at'])) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= base_url('instructor/tests/' . $test['id'] . '/questions') ?>" class="btn btn-sm btn-outline-secondary" title="Manage Questions">
                                            <i class="fas fa-list-ul"></i>
                                        </a>
                                        <a href="<?= base_url('instructor/tests/edit/' . $test['id']) ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-info disabled">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($test['status'] !== 'active'): ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="if(confirm('Delete this test?')) window.location.href='/tests/delete/<?= $test['id'] ?>'">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($tests)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">No tests found</div>
                                    <a href="/tests/create" class="btn btn-primary mt-3">Create Your First Test</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


