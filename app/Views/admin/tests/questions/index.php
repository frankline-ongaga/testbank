<div class="admin-content">
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-end align-items-center mb-3">
        <div class="text-end">
            <a href="<?= base_url('admin/tests') ?>" class="btn btn-secondary me-2"><i class="fas fa-arrow-left me-1"></i>Back to Tests</a>
            <a href="<?= base_url('admin/tests/' . $test['id'] . '/questions/import') ?>" class="btn btn-outline-secondary me-2">
                <i class="fas fa-file-upload me-1"></i>Import Questions
            </a>
            <a href="<?= base_url('admin/tests/' . $test['id'] . '/questions/link') ?>" class="btn btn-outline-primary me-2">
                <i class="fas fa-link me-1"></i>Link Existing
            </a>
            <a href="<?= base_url('admin/tests/' . $test['id'] . '/questions/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Add Question
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width:80px;">Order</th>
                            <th style="width:90px;">ID</th>
                            <th>Stem</th>
                            <th style="width:120px;">Type</th>
                            <th style="width:200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($questions ?? []) as $q): ?>
                            <tr>
                                <td><?= (int)($q['sort_order'] ?? 0) ?></td>
                                <td>#<?= (int)$q['id'] ?></td>
                                <td><?= esc(mb_strimwidth($q['stem'] ?? '', 0, 140, '…')) ?></td>
                                <td><span class="badge bg-info"><?= strtoupper(esc($q['type'] ?? '')) ?></span></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= base_url('admin/questions/edit/' . $q['id']) ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="if(confirm('Remove this question from the test?')) window.location.href='<?= base_url('admin/tests/' . $test['id'] . '/questions/' . $q['id'] . '/unlink') ?>'">
                                            <i class="fas fa-unlink"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($questions)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No questions linked yet. Use “Add Question” or “Link Existing”.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


