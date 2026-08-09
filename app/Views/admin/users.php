<?php
$activePaidUsers = $activePaidUsers ?? [];
$otherUsers = $otherUsers ?? [];

$formatDate = static function ($value): string {
    if (empty($value)) {
        return 'Not set';
    }

    return date('M j, Y g:i A', strtotime($value));
};

$formatMoney = static function ($amount, $currency = 'USD'): string {
    if ($amount === null || $amount === '') {
        return 'Not recorded';
    }

    return trim(($currency ?: 'USD') . ' ' . number_format((float) $amount, 2));
};

$planLabel = static function ($plan): string {
    $plan = (string) $plan;
    if ($plan === '1-month' || $plan === 'monthly') {
        return '1 Month';
    }
    if ($plan === '3-month' || $plan === 'quarterly') {
        return '3 Months';
    }

    return $plan !== '' ? ucwords(str_replace(['-', '_'], ' ', $plan)) : 'Not set';
};

$statusBadge = static function ($status): string {
    return match ($status) {
        'active' => 'success',
        'expired' => 'secondary',
        'cancelled' => 'danger',
        default => 'secondary',
    };
};

$renderSubscriptionDetails = static function (array $user, string $panelId) use ($formatDate, $formatMoney, $planLabel, $statusBadge): void {
    $subscriptions = $user['subscriptions'] ?? [];
    ?>
    <div class="collapse admin-user-subscriptions" id="<?= esc($panelId) ?>">
        <?php if (!empty($subscriptions)): ?>
            <div class="admin-subscription-grid">
                <?php foreach ($subscriptions as $subscription): ?>
                    <?php
                        $isActive = ($subscription['status'] ?? '') === 'active'
                            && !empty($subscription['start_at'])
                            && !empty($subscription['end_at'])
                            && $subscription['start_at'] <= date('Y-m-d H:i:s')
                            && $subscription['end_at'] >= date('Y-m-d H:i:s');
                    ?>
                    <article class="admin-subscription-card <?= $isActive ? 'is-active' : '' ?>">
                        <div class="admin-subscription-card-head">
                            <div>
                                <span class="admin-product-kicker"><?= esc($subscription['product_short_name'] ?: 'Product') ?></span>
                                <h6><?= esc($subscription['product_name'] ?: 'Unknown product') ?></h6>
                            </div>
                            <span class="badge bg-<?= esc($statusBadge($subscription['status'] ?? '')) ?>">
                                <?= esc(ucfirst($subscription['status'] ?? 'unknown')) ?>
                            </span>
                        </div>
                        <dl class="admin-subscription-meta">
                            <div>
                                <dt>Plan</dt>
                                <dd><?= esc($planLabel($subscription['plan'] ?? '')) ?></dd>
                            </div>
                            <div>
                                <dt>Amount</dt>
                                <dd><?= esc($formatMoney($subscription['amount'] ?? null, $subscription['currency'] ?? 'USD')) ?></dd>
                            </div>
                            <div>
                                <dt>Starts</dt>
                                <dd><?= esc($formatDate($subscription['start_at'] ?? null)) ?></dd>
                            </div>
                            <div>
                                <dt>Ends</dt>
                                <dd><?= esc($formatDate($subscription['end_at'] ?? null)) ?></dd>
                            </div>
                            <div class="admin-subscription-order">
                                <dt>Order</dt>
                                <dd><?= esc($subscription['paypal_order_id'] ?: 'Manual or not recorded') ?></dd>
                            </div>
                        </dl>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="admin-empty-subscriptions">
                <strong>No subscription records</strong>
                <span>This learner has an account but no recorded product access yet.</span>
            </div>
        <?php endif; ?>
    </div>
    <?php
};

$renderUserTable = static function (array $users, string $tableIdPrefix, bool $highlightPaid = false) use ($formatDate, $renderSubscriptionDetails): void {
    ?>
    <div class="table-responsive">
        <table class="table admin-users-table align-middle mb-0">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Account</th>
                    <th>Access</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <?php
                        $activeSubscriptions = $user['active_subscriptions'] ?? [];
                        $panelId = $tableIdPrefix . '-' . (int) $user['id'];
                        $productNames = array_values(array_filter(array_map(
                            static fn ($subscription) => $subscription['product_short_name'] ?: $subscription['product_name'] ?? null,
                            $activeSubscriptions
                        )));
                    ?>
                    <tr class="<?= $highlightPaid ? 'admin-paid-row' : '' ?>">
                        <td>
                            <div class="admin-user-identity">
                                <span><?= esc(strtoupper(substr((string) ($user['username'] ?: $user['email']), 0, 1))) ?></span>
                                <div>
                                    <strong><?= esc($user['username'] ?: 'Unnamed user') ?></strong>
                                    <small>Joined <?= esc($formatDate($user['created_at'] ?? null)) ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="admin-user-email"><?= esc($user['email']) ?></td>
                        <td>
                            <span class="badge bg-<?= ($user['status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?>">
                                <?= esc(ucfirst($user['status'] ?? 'active')) ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($activeSubscriptions)): ?>
                                <div class="admin-product-tags">
                                    <?php foreach ($productNames as $name): ?>
                                        <span><?= esc($name) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-muted">No active paid access</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <div class="admin-user-actions">
                                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#<?= esc($panelId) ?>" aria-expanded="false" aria-controls="<?= esc($panelId) ?>">
                                    Details
                                </button>
                                <a href="<?= base_url('admin/users/edit/' . (int) $user['id']) ?>" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('admin/users/delete/' . (int) $user['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete user?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr class="admin-user-detail-row">
                        <td colspan="5">
                            <?php $renderSubscriptionDetails($user, $panelId); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="5">
                            <div class="admin-users-empty">No users found in this group.</div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
};
?>

<style>
    .admin-users-page {
        display: grid;
        gap: 24px;
    }

    .admin-users-hero {
        background: linear-gradient(135deg, rgba(10, 166, 215, 0.14), rgba(255, 219, 88, 0.18));
        border: 1px solid rgba(10, 166, 215, 0.16);
        border-radius: 22px;
        padding: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .admin-users-hero h1 {
        color: #101828;
        font-size: clamp(2rem, 4vw, 3.5rem);
        font-weight: 900;
        margin: 0;
    }

    .admin-users-hero p {
        color: #667085;
        font-size: 1.05rem;
        margin: 8px 0 0;
        max-width: 720px;
    }

    .admin-users-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(150px, 1fr));
        gap: 14px;
        min-width: 420px;
    }

    .admin-users-stat {
        background: #fff;
        border: 1px solid rgba(10, 166, 215, 0.14);
        border-radius: 18px;
        padding: 18px;
        box-shadow: 0 16px 35px rgba(16, 24, 40, 0.08);
    }

    .admin-users-stat strong {
        color: #101828;
        display: block;
        font-size: 2rem;
        line-height: 1;
    }

    .admin-users-stat span {
        color: #667085;
        display: block;
        font-size: .8rem;
        font-weight: 800;
        letter-spacing: .08em;
        margin-top: 8px;
        text-transform: uppercase;
    }

    .admin-users-section {
        background: #fff;
        border: 1px solid rgba(10, 166, 215, 0.14);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(16, 24, 40, 0.07);
    }

    .admin-users-section-head {
        align-items: center;
        background: #f8fbfd;
        border-bottom: 1px solid rgba(10, 166, 215, 0.12);
        display: flex;
        gap: 16px;
        justify-content: space-between;
        padding: 20px 24px;
    }

    .admin-users-section-head h2 {
        color: #101828;
        font-size: 1.25rem;
        font-weight: 900;
        margin: 0;
    }

    .admin-users-section-head p {
        color: #667085;
        margin: 4px 0 0;
    }

    .admin-users-count {
        background: #0aa6d7;
        border-radius: 999px;
        color: #fff;
        font-weight: 900;
        padding: 8px 14px;
        white-space: nowrap;
    }

    .admin-users-table {
        min-width: 920px;
    }

    .admin-users-table thead th {
        background: #fff;
        border-bottom: 1px solid #edf2f7;
        color: #667085;
        font-size: .76rem;
        font-weight: 900;
        letter-spacing: .08em;
        padding: 16px 20px;
        text-transform: uppercase;
    }

    .admin-users-table tbody td {
        border-bottom: 1px solid #edf2f7;
        padding: 18px 20px;
    }

    .admin-paid-row {
        background: linear-gradient(90deg, rgba(10, 166, 215, 0.05), rgba(255, 219, 88, 0.08));
    }

    .admin-user-identity {
        align-items: center;
        display: flex;
        gap: 12px;
    }

    .admin-user-identity > span {
        align-items: center;
        background: #ffdb58;
        border-radius: 14px;
        color: #101828;
        display: inline-flex;
        font-weight: 900;
        height: 44px;
        justify-content: center;
        width: 44px;
    }

    .admin-user-identity strong {
        color: #101828;
        display: block;
        font-weight: 900;
    }

    .admin-user-identity small,
    .admin-user-email {
        color: #667085;
    }

    .admin-product-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .admin-product-tags span {
        background: rgba(10, 166, 215, 0.12);
        border: 1px solid rgba(10, 166, 215, 0.2);
        border-radius: 999px;
        color: #087fa5;
        font-size: .8rem;
        font-weight: 900;
        padding: 6px 10px;
    }

    .admin-user-actions {
        display: inline-flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .admin-user-detail-row > td {
        background: #fbfdff;
        padding: 0 20px !important;
    }

    .admin-user-subscriptions {
        padding: 0 0 18px;
    }

    .admin-subscription-grid {
        display: grid;
        gap: 14px;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        padding-top: 18px;
    }

    .admin-subscription-card {
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        padding: 16px;
    }

    .admin-subscription-card.is-active {
        border-color: rgba(10, 166, 215, .45);
        box-shadow: 0 14px 30px rgba(10, 166, 215, .1);
    }

    .admin-subscription-card-head {
        align-items: flex-start;
        display: flex;
        gap: 12px;
        justify-content: space-between;
    }

    .admin-product-kicker {
        color: #0aa6d7;
        display: block;
        font-size: .72rem;
        font-weight: 900;
        letter-spacing: .1em;
        margin-bottom: 4px;
        text-transform: uppercase;
    }

    .admin-subscription-card h6 {
        color: #101828;
        font-weight: 900;
        margin: 0;
    }

    .admin-subscription-meta {
        display: grid;
        gap: 10px;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        margin: 16px 0 0;
    }

    .admin-subscription-meta div {
        background: #f8fbfd;
        border-radius: 12px;
        padding: 10px;
    }

    .admin-subscription-meta dt {
        color: #98a2b3;
        font-size: .72rem;
        font-weight: 900;
        letter-spacing: .08em;
        margin-bottom: 3px;
        text-transform: uppercase;
    }

    .admin-subscription-meta dd {
        color: #344054;
        font-weight: 800;
        margin: 0;
        overflow-wrap: anywhere;
    }

    .admin-subscription-order {
        grid-column: 1 / -1;
    }

    .admin-empty-subscriptions,
    .admin-users-empty {
        color: #667085;
        padding: 22px;
        text-align: center;
    }

    .admin-empty-subscriptions span {
        display: block;
        margin-top: 4px;
    }

    @media (max-width: 1100px) {
        .admin-users-hero {
            align-items: stretch;
            flex-direction: column;
        }

        .admin-users-stats {
            min-width: 0;
            width: 100%;
        }
    }

    @media (max-width: 700px) {
        .admin-users-hero,
        .admin-users-section-head {
            padding: 20px;
        }

        .admin-users-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php if (session()->getFlashdata('message')): ?>
<div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="admin-users-page">
    <section class="admin-users-hero">
        <div>
            <h1>Manage Users</h1>
            <p>Review learners by paid product access first, then audit the remaining accounts and their subscription history.</p>
        </div>
        <div class="admin-users-stats">
            <div class="admin-users-stat">
                <strong><?= number_format(count($activePaidUsers)) ?></strong>
                <span>Active paid</span>
            </div>
            <div class="admin-users-stat">
                <strong><?= number_format(count($otherUsers)) ?></strong>
                <span>Other users</span>
            </div>
            <div class="admin-users-stat">
                <strong><?= number_format(count($activePaidUsers) + count($otherUsers)) ?></strong>
                <span>Total users</span>
            </div>
        </div>
    </section>

    <section class="admin-users-section">
        <div class="admin-users-section-head">
            <div>
                <h2>Active Paid Subscriptions</h2>
                <p>Users with at least one active product subscription right now.</p>
            </div>
            <span class="admin-users-count"><?= number_format(count($activePaidUsers)) ?></span>
        </div>
        <?php $renderUserTable($activePaidUsers, 'paid-user-subscriptions', true); ?>
    </section>

    <section class="admin-users-section">
        <div class="admin-users-section-head">
            <div>
                <h2>Other Users</h2>
                <p>Accounts without active paid access, including unpaid, expired, cancelled, and admin/test accounts.</p>
            </div>
            <span class="admin-users-count"><?= number_format(count($otherUsers)) ?></span>
        </div>
        <?php $renderUserTable($otherUsers, 'other-user-subscriptions'); ?>
    </section>
</div>
