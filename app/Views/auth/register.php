<div class="container py-5" style="max-width:640px;">
    <h2 class="mb-4">Create Account</h2>
    <?php if (session()->getFlashdata('errors')): ?>
    <ul class="text-danger">
        <?php foreach (session()->getFlashdata('errors') as $e): ?>
            <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form method="post" action="/register">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
            <label class="form-label">Username (optional)</label>
            <input type="text" name="username" class="form-control" />
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <div class="d-flex gap-2 align-items-center">
            <button type="submit" class="btn btn-primary">Create Account</button>
            <a href="/login" class="btn btn-link">Back to login</a>
        </div>
    </form>
</div>


