<div class="admin-content">
    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('admin/tests/store') ?>" method="post">
                <?= csrf_field() ?>
                <?php if (!empty($is_free)): ?>
                    <input type="hidden" name="is_free" value="1">
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="mb-4">
                    <label class="form-label">Test Title</label>
                    <input type="text" class="form-control" name="title" value="<?= old('title') ?>" required>
                    <div class="form-text text-muted">Enter a descriptive title for the test</div>
                </div>

                <input type="hidden" name="mode" value="practice">
                <?php if (empty($is_free)): ?>
                <div class="mb-4">
                    <label class="form-label">Time Limit (minutes)</label>
                    <input type="number" class="form-control" name="time_limit" value="<?= old('time_limit', '60') ?>" min="0">
                    <div class="form-text text-muted">Leave empty or 0 for no time limit</div>
                </div>
                <?php else: ?>
                    <input type="hidden" name="time_limit" value="0">
                <?php endif; ?>

                <input type="hidden" name="is_adaptive" value="1">
                <?php if (!empty($is_free)): ?>
                    <input type="hidden" name="is_free" value="1">
                <?php endif; ?>
                
                <div class="alert alert-info">
                    After creating the test, you'll be redirected to manage its questions (add, link, or remove).
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Create Test</button>&nbsp;&nbsp;&nbsp;<a href="<?= base_url('admin/tests') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
