<?php $u = $user ?? []; ?>
<div class="container py-4">
	<div class="row g-4">
		<div class="col-lg-4">
			<div class="card shadow-sm h-100">
				<div class="card-body d-flex align-items-center gap-3">
					<img src="https://ui-avatars.com/api/?name=<?= urlencode($u['first_name'] ?? 'Student') ?>&background=6366f1&color=fff" alt="Avatar" class="rounded-circle" style="width:72px;height:72px;">
					<div>
						<h5 class="mb-1"><?= esc($u['first_name'] ?? 'Student') ?></h5>
						<div class="text-muted small">Member since <?= isset($u['created_at']) ? date('M Y', strtotime($u['created_at'])) : '-' ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<?php if (session()->getFlashdata('message')): ?>
				<div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
			<?php endif; ?>
			<?php if (session()->getFlashdata('error')): ?>
				<div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
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

			<div class="card shadow-sm mb-4">
				<div class="card-header">
					<h6 class="mb-0">Profile Information</h6>
				</div>
				<div class="card-body">
					<form method="post" action="<?= base_url('client/profile') ?>">
						<?= csrf_field() ?>
						<div class="row g-3">
							<div class="col-md-6">
								<label class="form-label">First Name</label>
								<input type="text" name="first_name" class="form-control" value="<?= esc(set_value('first_name', $u['first_name'] ?? '')) ?>" required>
							</div>
							<div class="col-md-6">
								<label class="form-label">Email</label>
								<input type="email" name="email" class="form-control" value="<?= esc(set_value('email', $u['email'] ?? '')) ?>" required>
							</div>
						</div>
						<div class="mt-3">
							<button type="submit" class="btn btn-primary">Save Changes</button>
						</div>
					</form>
				</div>
			</div>

			<div class="card shadow-sm">
				<div class="card-header">
					<h6 class="mb-0">Change Password</h6>
				</div>
				<div class="card-body">
					<form method="post" action="<?= base_url('client/profile/password') ?>">
						<?= csrf_field() ?>
						<div class="row g-3">
							<div class="col-md-4">
								<label class="form-label">Current Password</label>
								<input type="password" name="current_password" class="form-control" required>
							</div>
							<div class="col-md-4">
								<label class="form-label">New Password</label>
								<input type="password" name="new_password" class="form-control" minlength="6" required>
							</div>
							<div class="col-md-4">
								<label class="form-label">Confirm Password</label>
								<input type="password" name="confirm_password" class="form-control" minlength="6" required>
							</div>
						</div>
						<div class="mt-3">
							<button type="submit" class="btn btn-outline-primary">Update Password</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


