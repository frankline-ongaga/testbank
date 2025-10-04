<div class="container py-5" style="max-width:640px;">
    <h2 class="mb-4">Reset Password</h2>
    <form method="post" action="/reset/<?= esc($token) ?>">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <div class="d-flex gap-2 align-items-center">
            <button type="submit" class="btn btn-primary">Reset Password</button>
            <a href="/login" class="btn btn-link">Back to login</a>
        </div>
    </form>
</div>


