<?php if (session()->getFlashdata('message')): ?>
<div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="card">
	<div class="card-header">
		<div class="row g-3 align-items-center">
			<div class="col">
				<h5 class="card-title mb-0">All Users</h5>
			</div>
			<div class="col-auto">
				<a href="<?= base_url('admin/users/create'); ?>" class="btn btn-primary">
					<i class="fas fa-user-plus me-2"></i>Add User
				</a>
			</div>
		</div>
	</div>
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table table-hover align-middle mb-0">
				<thead class="bg-light">
					<tr>
						<th style="width: 60px;">ID</th>
						<th>User</th>
						<th>Email</th>
						<th style="width: 120px;">Status</th>
						<th style="width: 140px;">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach (($users ?? []) as $u): ?>
						<tr>
							<td><?= esc($u['id']) ?></td>
							<td>
								<div class="d-flex align-items-center">
								
									<div>
										<div class="fw-medium"><?= esc($u['username'] ?? '') ?></div>
										<div class="text-muted small">Joined <?= esc(date('M j, Y', strtotime($u['created_at'] ?? date('Y-m-d')))) ?></div>
									</div>
								</div>
							</td>
							<td><?= esc($u['email']) ?></td>
							<td>
								<span class="badge bg-<?= ($u['status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?>">
									<?= ucfirst(esc($u['status'] ?? 'active')) ?>
								</span>
							</td>
							<td>
								<div class="btn-group">
									<a href="<?= base_url('admin/users/edit/' . (int)$u['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
										<i class="fas fa-edit"></i>
									</a>
									&nbsp; &nbsp; &nbsp;
									<a href="<?= base_url('admin/users/delete/' . (int)$u['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete user?')">
										<i class="fas fa-trash"></i>
									</a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
					<?php if (empty($users)): ?>
						<tr>
							<td colspan="5" class="text-center py-4">
								<div class="text-muted">No users found</div>
							</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>