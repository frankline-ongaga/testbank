<?php
    $activeByProduct = [];
    foreach (($current_subscriptions ?? []) as $subscription) {
        if (!empty($subscription['product_id'])) {
            $activeByProduct[(int) $subscription['product_id']] = $subscription;
        }
    }

    $selectedProductSlug = (string) ($selectedProductSlug ?? '');
    $planPayload = [];
    foreach (($products ?? []) as $product) {
        $productId = (int) $product['id'];
        $shortName = trim((string) ($product['short_name'] ?: $product['name']));
        $planPayload[] = [
            'id' => $productId,
            'slug' => (string) $product['slug'],
            'name' => (string) $product['name'],
            'shortName' => $shortName,
            'description' => (string) ($product['description'] ?? 'Focused exam preparation with practice tests and rationales.'),
            'monthly' => (float) $product['monthly_price'],
            'quarterly' => (float) $product['quarterly_price'],
        ];
    }
?>

<div class="admin-content access-page">
    <style>
        .access-page {
            max-width: 1180px;
            margin: 0 auto;
            padding: 1.5rem 1rem 2rem;
        }

        .access-toolbar {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1rem;
        }

        .access-title {
            margin: 0;
            color: #0f172a;
            font-size: 1.55rem;
            line-height: 1.2;
            font-weight: 850;
        }

        .access-subtitle {
            margin: .3rem 0 0;
            color: #64748b;
            line-height: 1.55;
        }

        .access-status-strip {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            justify-content: flex-end;
        }

        .access-pill {
            display: inline-flex;
            align-items: center;
            gap: .42rem;
            min-height: 34px;
            padding: .45rem .72rem;
            border: 1px solid #bae6fd;
            border-radius: 999px;
            background: #eff6ff;
            color: #075985;
            font-size: .8rem;
            font-weight: 750;
            white-space: nowrap;
        }

        .access-pill-muted {
            border-color: #e2e8f0;
            background: #f8fafc;
            color: #64748b;
        }

        .access-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 340px;
            gap: 1rem;
            align-items: start;
        }

        .access-products {
            display: grid;
            gap: .85rem;
        }

        .access-product {
            border: 1px solid #dbeafe;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .06);
            overflow: hidden;
        }

        .access-product-head {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 1rem;
            align-items: start;
            padding: 1.05rem 1.1rem;
            border-bottom: 1px solid #edf2f7;
            background: linear-gradient(90deg, rgba(10, 166, 215, .08), rgba(255, 255, 255, 0));
        }

        .access-product-name {
            margin: 0;
            color: #0f172a;
            font-size: 1.15rem;
            line-height: 1.25;
            font-weight: 850;
        }

        .access-product-copy {
            margin: .32rem 0 0;
            color: #64748b;
            line-height: 1.55;
        }

        .access-active {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .4rem .62rem;
            border: 1px solid #bbf7d0;
            border-radius: 999px;
            background: #dcfce7;
            color: #166534;
            font-size: .78rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .access-plan-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .75rem;
            padding: .9rem;
        }

        .access-plan {
            display: grid;
            gap: .7rem;
            min-height: 156px;
            padding: .95rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fff;
            text-align: left;
        }

        .access-plan.is-selected {
            border-color: #0aa6d7;
            box-shadow: 0 0 0 3px rgba(10, 166, 215, .12);
        }

        .access-plan-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .7rem;
        }

        .access-plan-label {
            color: #0f172a;
            font-size: .98rem;
            font-weight: 850;
        }

        .access-plan-badge {
            display: inline-flex;
            align-items: center;
            min-height: 24px;
            padding: .22rem .48rem;
            border-radius: 999px;
            background: rgba(245, 158, 11, .14);
            color: #b45309;
            font-size: .68rem;
            font-weight: 850;
            text-transform: uppercase;
        }

        .access-plan-price {
            color: #0aa6d7;
            font-size: 2rem;
            line-height: 1;
            font-weight: 900;
        }

        .access-plan-note {
            color: #64748b;
            line-height: 1.45;
            font-size: .9rem;
        }

        .access-select {
            align-self: end;
            width: 100%;
            min-height: 42px;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            background: #f8fbff;
            color: #0369a1;
            font-weight: 850;
            transition: .18s ease;
        }

        .access-select:hover,
        .access-select:focus {
            background: #e0f2fe;
            border-color: #7dd3fc;
        }

        .access-plan.is-selected .access-select {
            background: #0aa6d7;
            border-color: #0aa6d7;
            color: #fff;
        }

        .checkout-panel {
            position: sticky;
            top: 1rem;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 16px 34px rgba(15, 23, 42, .08);
            overflow: hidden;
        }

        .checkout-head {
            padding: 1rem;
            background: #f8fbff;
            border-bottom: 1px solid #e5edf7;
        }

        .checkout-eyebrow {
            display: block;
            color: #64748b;
            font-size: .76rem;
            font-weight: 850;
            text-transform: uppercase;
        }

        .checkout-title {
            margin: .35rem 0 0;
            color: #0f172a;
            font-size: 1.15rem;
            font-weight: 900;
        }

        .checkout-body {
            padding: 1rem;
        }

        .checkout-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: .72rem 0;
            border-bottom: 1px solid #eef2f7;
            color: #64748b;
        }

        .checkout-row strong {
            color: #0f172a;
            font-weight: 850;
            text-align: right;
        }

        .checkout-total {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 1rem;
            margin: 1rem 0;
            color: #0f172a;
            font-weight: 850;
        }

        .checkout-total strong {
            color: #0aa6d7;
            font-size: 2rem;
            line-height: 1;
            font-weight: 950;
        }

        .paypal-box {
            min-height: 48px;
        }

        .checkout-note {
            display: flex;
            gap: .55rem;
            margin-top: .75rem;
            color: #64748b;
            font-size: .86rem;
            line-height: 1.45;
        }

        .theme-dark .access-title,
        .theme-dark .access-product-name,
        .theme-dark .access-plan-label,
        .theme-dark .checkout-title,
        .theme-dark .checkout-row strong,
        .theme-dark .checkout-total {
            color: #f8fafc;
        }

        .theme-dark .access-subtitle,
        .theme-dark .access-product-copy,
        .theme-dark .access-plan-note,
        .theme-dark .checkout-row,
        .theme-dark .checkout-note {
            color: #cbd5e1;
        }

        .theme-dark .access-product,
        .theme-dark .access-plan,
        .theme-dark .checkout-panel {
            background: #111827;
            border-color: #374151;
        }

        .theme-dark .access-product-head,
        .theme-dark .checkout-head {
            background: #172033;
            border-color: #374151;
        }

        @media (max-width: 1120px) {
            .access-layout {
                grid-template-columns: 1fr;
            }

            .checkout-panel {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .access-toolbar,
            .access-product-head,
            .access-plan-grid {
                grid-template-columns: 1fr;
            }

            .access-status-strip {
                justify-content: flex-start;
            }

            .access-plan {
                min-height: auto;
            }
        }
    </style>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger shadow-sm"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success shadow-sm"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <div class="access-toolbar">
        <div>
            <h1 class="access-title">Choose Your Exam Access</h1>
            <p class="access-subtitle">Pick a product, choose a duration, then complete checkout from the summary panel.</p>
        </div>
        <div class="access-status-strip">
            <?php if (!empty($activeByProduct)): ?>
                <?php foreach ($activeByProduct as $subscription): ?>
                    <span class="access-pill">
                        <i class="fas fa-circle-check"></i>
                        <?= esc($subscription['product_name'] ?? 'Product') ?> until <?= esc(date('M j, Y', strtotime($subscription['end_at'] ?? 'now'))) ?>
                    </span>
                <?php endforeach; ?>
            <?php else: ?>
                <span class="access-pill access-pill-muted">
                    <i class="fas fa-circle-info"></i>
                    No active access
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="access-layout">
        <div class="access-products">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <?php
                        $productId = (int) $product['id'];
                        $slug = (string) $product['slug'];
                        $active = $activeByProduct[$productId] ?? null;
                        $shortName = trim((string) ($product['short_name'] ?: $product['name']));
                    ?>
                    <article class="access-product" data-product-card="<?= esc($slug) ?>">
                        <div class="access-product-head">
                            <div>
                                <h2 class="access-product-name"><?= esc($product['name']) ?></h2>
                                <p class="access-product-copy"><?= esc($product['description'] ?? 'Focused exam preparation with practice tests and rationales.') ?></p>
                            </div>
                            <?php if ($active): ?>
                                <span class="access-active">
                                    <i class="fas fa-circle-check"></i>
                                    Active until <?= esc(date('M j, Y', strtotime($active['end_at'] ?? 'now'))) ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="access-plan-grid">
                            <div class="access-plan" data-plan-card="<?= esc($slug) ?>-monthly">
                                <div class="access-plan-top">
                                    <span class="access-plan-label">1 Month</span>
                                </div>
                                <div class="access-plan-price">$<?= esc(number_format((float) $product['monthly_price'], 0)) ?></div>
                                <div class="access-plan-note">30 days of <?= esc($shortName) ?> practice tests and review content.</div>
                                <button class="access-select" type="button" data-select-plan data-product="<?= esc($slug) ?>" data-plan="monthly">Select 1 Month</button>
                            </div>

                            <div class="access-plan" data-plan-card="<?= esc($slug) ?>-quarterly">
                                <div class="access-plan-top">
                                    <span class="access-plan-label">3 Months</span>
                                    <span class="access-plan-badge">Best value</span>
                                </div>
                                <div class="access-plan-price">$<?= esc(number_format((float) $product['quarterly_price'], 0)) ?></div>
                                <div class="access-plan-note">90 days for deeper review, repeat attempts, and steadier prep.</div>
                                <button class="access-select" type="button" data-select-plan data-product="<?= esc($slug) ?>" data-plan="quarterly">Select 3 Months</button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning mb-0">No active exam products are available right now.</div>
            <?php endif; ?>
        </div>

        <aside class="checkout-panel" aria-live="polite">
            <div class="checkout-head">
                <span class="checkout-eyebrow">Checkout</span>
                <h2 class="checkout-title" id="checkout-product">Select a product</h2>
            </div>
            <div class="checkout-body">
                <div class="checkout-row">
                    <span>Duration</span>
                    <strong id="checkout-duration">-</strong>
                </div>
                <div class="checkout-row">
                    <span>Access</span>
                    <strong id="checkout-access">-</strong>
                </div>
                <div class="checkout-total">
                    <span>Total</span>
                    <strong id="checkout-total">$0</strong>
                </div>
                <div class="paypal-box" id="paypal-checkout"></div>
                <div class="checkout-note">
                    <i class="fa-brands fa-paypal"></i>
                    <span>Payment is processed securely with PayPal. Your access activates after checkout.</span>
                </div>
            </div>
        </aside>
    </div>

    <?php
        $paypalClientId = env('PAYPAL_CLIENT_ID') ?? env('PAYPAL_LIVE_CLIENT_ID') ?? env('PAYPAL_SANDBOX_CLIENT_ID');
        $paypalCurrency = env('PAYPAL_CURRENCY') ?? 'USD';
        $paypalIntent = env('PAYPAL_INTENT') ?? 'capture';
    ?>

    <?php if (!empty($paypalClientId) && !empty($planPayload)): ?>
        <script src="https://www.paypal.com/sdk/js?client-id=<?= esc($paypalClientId) ?>&currency=<?= esc($paypalCurrency) ?>&intent=<?= esc($paypalIntent) ?>&enable-funding=card"></script>
        <script>
            const productPlans = <?= json_encode($planPayload) ?>;
            const selectedProductSlug = <?= json_encode($selectedProductSlug) ?>;
            const checkout = {
                product: document.getElementById('checkout-product'),
                duration: document.getElementById('checkout-duration'),
                access: document.getElementById('checkout-access'),
                total: document.getElementById('checkout-total'),
                paypal: document.getElementById('paypal-checkout')
            };

            let selectedProduct = productPlans.find(function(product) {
                return product.slug === selectedProductSlug;
            }) || productPlans[0] || null;
            let selectedPlan = 'monthly';

            function planAmount(product, plan) {
                return plan === 'quarterly' ? Number(product.quarterly) : Number(product.monthly);
            }

            function planLabel(plan) {
                return plan === 'quarterly' ? '3 Months' : '1 Month';
            }

            function planDays(plan) {
                return plan === 'quarterly' ? '90 days' : '30 days';
            }

            function updateSelectedCards() {
                document.querySelectorAll('[data-plan-card]').forEach(function(card) {
                    card.classList.remove('is-selected');
                });

                if (selectedProduct) {
                    const selectedCard = document.querySelector('[data-plan-card="' + selectedProduct.slug + '-' + selectedPlan + '"]');
                    if (selectedCard) {
                        selectedCard.classList.add('is-selected');
                    }
                }
            }

            function renderCheckout() {
                if (!selectedProduct || !checkout.paypal) {
                    return;
                }

                const amount = planAmount(selectedProduct, selectedPlan);
                checkout.product.textContent = selectedProduct.name;
                checkout.duration.textContent = planLabel(selectedPlan);
                checkout.access.textContent = planDays(selectedPlan) + ' of ' + selectedProduct.shortName;
                checkout.total.textContent = '$' + amount.toFixed(0);
                checkout.paypal.innerHTML = '';
                updateSelectedCards();

                paypal.Buttons({
                    style: {
                        layout: 'vertical',
                        color: 'blue',
                        shape: 'rect',
                        label: 'paypal',
                        height: 44
                    },
                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                description: selectedProduct.name + ' ' + planLabel(selectedPlan) + ' Access',
                                amount: { value: amount.toFixed(2), currency_code: 'USD' }
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function() {
                            window.location = '<?= base_url('subscriptions/success') ?>?orderID=' + encodeURIComponent(data.orderID) + '&plan=' + encodeURIComponent(selectedPlan) + '&product=' + encodeURIComponent(selectedProduct.slug);
                        });
                    }
                }).render('#paypal-checkout');
            }

            document.querySelectorAll('[data-select-plan]').forEach(function(button) {
                button.addEventListener('click', function() {
                    const product = productPlans.find(function(item) {
                        return item.slug === button.dataset.product;
                    });

                    if (!product) {
                        return;
                    }

                    selectedProduct = product;
                    selectedPlan = button.dataset.plan === 'quarterly' ? 'quarterly' : 'monthly';
                    renderCheckout();
                });
            });

            renderCheckout();
        </script>
    <?php elseif (empty($paypalClientId)): ?>
        <div class="alert alert-warning mt-3">PayPal is not configured yet. Add a PayPal client ID to enable checkout.</div>
    <?php endif; ?>
</div>
