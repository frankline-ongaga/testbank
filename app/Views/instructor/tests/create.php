<div class="admin-content">
    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('instructor/tests/store') ?>" method="post">
                <?= csrf_field() ?>
                
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Tests created by instructors require admin approval before becoming active.
                </div>

                <div class="mb-4">
                    <label class="form-label">Test Title</label>
                    <input type="text" class="form-control" name="title" value="<?= old('title') ?>" required>
                    <div class="form-text">Enter a descriptive title for the test</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Test Mode</label>
                        <select class="form-select" name="mode" required>
                            <option value="practice" <?= old('mode') === 'practice' ? 'selected' : '' ?>>Practice Mode</option>
                            <option value="evaluation" <?= old('mode') === 'evaluation' ? 'selected' : '' ?>>Evaluation Mode</option>
                        </select>
                        <div class="form-text">Practice mode shows answers, Evaluation mode is timed</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Time Limit (minutes)</label>
                        <input type="number" class="form-control" name="time_limit" value="<?= old('time_limit', '60') ?>" min="0">
                        <div class="form-text">Leave empty or 0 for no time limit</div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="is_adaptive" value="1" <?= old('is_adaptive') ? 'checked' : '' ?>>
                        <label class="form-check-label">Enable Adaptive Testing</label>
                        <div class="form-text">Questions will adjust based on student performance</div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" name="is_free" value="1" <?= old('is_free', ($is_free ?? false)) ? 'checked' : '' ?> id="isFree">
                        <label class="form-check-label" for="isFree">This is a Free Test (10 questions max)</label>
                    </div>
                    <div class="alert alert-info">
                        After creating the test, you'll be redirected to manage its questions (add, link, or remove).
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Submit for Approval</button>
                    <a href="<?= base_url('instructor/tests') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

 


