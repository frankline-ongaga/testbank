<!-- Stats Grid -->
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-value"><?= esc(number_format($total_users ?? 0)) ?></div>
        <div class="admin-stat-label">Total Users</div>
        <div class="admin-stat-change positive">&nbsp;</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-value"><?= esc(number_format($active_tests ?? 0)) ?></div>
        <div class="admin-stat-label">Active Tests</div>
        <div class="admin-stat-change positive">&nbsp;</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-value"><?= esc(number_format($questions_count ?? 0)) ?></div>
        <div class="admin-stat-label">Questions</div>
        <div class="admin-stat-change positive">&nbsp;</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-value">$<?= esc(number_format($total_revenue ?? 0, 2)) ?></div>
        <div class="admin-stat-label">Revenue</div>
        <div class="admin-stat-change positive">&nbsp;</div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="row g-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Product Overview</div>
                <div class="card-subtitle">Tests, active learners, and revenue by product</div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php foreach (($product_stats ?? []) as $product): ?>
                        <div class="col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h5 class="mb-0"><?= esc($product['name']) ?></h5>
                                    <span class="badge bg-info text-dark">$<?= esc(number_format((float)$product['monthly_price'], 0)) ?> / $<?= esc(number_format((float)$product['quarterly_price'], 0)) ?></span>
                                </div>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="fw-bold"><?= esc(number_format($product['tests_count'] ?? 0)) ?></div>
                                        <div class="small text-muted">Tests</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="fw-bold"><?= esc(number_format($product['active_clients'] ?? 0)) ?></div>
                                        <div class="small text-muted">Active</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="fw-bold">$<?= esc(number_format((float)($product['revenue'] ?? 0), 0)) ?></div>
                                        <div class="small text-muted">Revenue</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Latest Transactions</div>
                <div class="card-subtitle">Most recent 10 payments</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Plan</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Order ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($latest_payments)): ?>
                                <?php foreach ($latest_payments as $p): ?>
                                    <tr>
                                        <td><?= esc(date('Y-m-d H:i', strtotime($p['created_at'] ?? 'now'))) ?></td>
                                        <td><?= esc($p['user_first_name'] ?: $p['user_email'] ?: ('#'.$p['user_id'])) ?></td>
                                        <td><?= esc($p['product_name'] ?? '-') ?></td>
                                        <td><?= esc(ucfirst($p['subscription_plan'] ?? '-')) ?></td>
                                        <td><span class="badge bg-<?= ($p['status'] ?? '') === 'COMPLETED' ? 'success' : 'secondary' ?>"><?= esc($p['status'] ?? '-') ?></span></td>
                                        <td>$<?= esc(number_format((float)($p['amount'] ?? 0), 2)) ?> <?= esc($p['currency'] ?? 'USD') ?></td>
                                        <td class="text-truncate" style="max-width: 180px;" title="<?= esc($p['paypal_order_id'] ?? '-') ?>"><?= esc($p['paypal_order_id'] ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="text-muted">No transactions yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
