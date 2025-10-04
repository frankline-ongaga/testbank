<div class="admin-content" style="max-width:720px;">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $e): ?>
                    <li><?= esc($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Test</h5>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('admin/tests/update/' . $test['id']) ?>">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= esc($test['title']) ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Mode</label>
                    <select name="mode" class="form-control" required>
                        <option value="practice" <?= $test['mode']==='practice'?'selected':'' ?>>Practice</option>
                        <option value="evaluation" <?= $test['mode']==='evaluation'?'selected':'' ?>>Evaluation</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Time Limit (minutes)</label>
                    <input type="number" name="time_limit_minutes" class="form-control" value="<?= (int)($test['time_limit_minutes'] ?? 0) ?>" />
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_adaptive" value="1" <?= !empty($test['is_adaptive']) ? 'checked' : '' ?> />
                    <label class="form-check-label">Adaptive</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="draft" <?= $test['status']==='draft'?'selected':'' ?>>Draft</option>
                        <option value="pending" <?= $test['status']==='pending'?'selected':'' ?>>Pending</option>
                        <option value="active" <?= $test['status']==='active'?'selected':'' ?>>Active</option>
                        <option value="inactive" <?= $test['status']==='inactive'?'selected':'' ?>>Inactive</option>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Save Changes</button> &nbsp; &nbsp;
                    <a href="<?= base_url('admin/tests') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


