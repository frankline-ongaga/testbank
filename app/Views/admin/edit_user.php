<div class="card" style="max-width:720px;">
    <div class="card-header">
        <h5 class="mb-0">Edit User</h5>
    </div>
    <div class="card-body">
    <form method="post" action="/admin/updateUser">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int)$user['id'] ?>" />
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= esc($user['username'] ?? '') ?>" />
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= esc($user['email']) ?>" required />
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" type="submit">Update</button>
             &nbsp; &nbsp; &nbsp;
            <a href="/admin/viewUsers" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    </div>
</div>