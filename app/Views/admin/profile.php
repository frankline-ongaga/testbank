<div class="card" style="max-width:720px;">
    <div class="card-header">
        <h5 class="mb-0">My Profile</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" value="<?= esc($user['username'] ?? '') ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="<?= esc($user['email'] ?? '') ?>" disabled>
        </div>
        <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger">Logout</a>
    </div>
</div>



