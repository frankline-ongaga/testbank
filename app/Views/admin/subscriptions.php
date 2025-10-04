    
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title">Active Subscriptions</div>
                        <div class="h3 mb-0"><?= esc($active_count ?? 0) ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title">Expired Subscriptions</div>
                        <div class="h3 mb-0"><?= esc($expired_count ?? 0) ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title">Total Revenue (USD)</div>
                        <div class="h3 mb-0">$<?= number_format((float)($total_revenue ?? 0), 2) ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title">Recent Payments</div>
                        <div class="h3 mb-0"><?= esc(count($recent_payments ?? [])) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Recent Payments</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Subscription</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Currency</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($recent_payments ?? []) as $p): ?>
                        <tr>
                            <td><?= esc($p['id']) ?></td>
                            <td><?= esc($p['user_id']) ?></td>
                            <td><?= esc($p['subscription_id']) ?></td>
                            <td><?= esc($p['status']) ?></td>
                            <td>$<?= number_format((float)($p['amount'] ?? 0), 2) ?></td>
                            <td><?= esc($p['currency'] ?? 'USD') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Recent Subscriptions</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Start</th>
                            <th>End</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($recent_subscriptions ?? []) as $s): ?>
                        <tr>
                            <td><?= esc($s['id']) ?></td>
                            <td><?= esc($s['user_id']) ?></td>
                            <td><?= esc($s['plan']) ?></td>
                            <td><?= esc($s['status']) ?></td>
                            <td><?= esc($s['start_at']) ?></td>
                            <td><?= esc($s['end_at']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>




