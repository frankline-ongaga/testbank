<div style="max-width:720px;">
    <h3 class="mb-3">Add User</h3>
    <form method="post" action="/admin/saveUser">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" />
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" type="submit">Save</button>
            <a href="/admin/viewUsers" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>