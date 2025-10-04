    <div class="admin-page-header">
        <div class="admin-page-title">
            <h1><?= esc($title ?? 'My Profile') ?></h1>
            <p>Manage your account details</p>
        </div>
    </div>
    <div class="admin-content" style="max-width:720px;">
        <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $e): ?>
                    <li><?= esc($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <form method="post" action="/client/updateProfile">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= esc($user['username'] ?? '') ?>" />
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= esc($user['email'] ?? '') ?>" />
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="/client" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>


