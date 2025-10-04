<div class="admin-page-header">
    <div class="admin-page-title">
        <h1><?= esc($title ?? 'Access Plans') ?></h1>
    </div>
</div>

<div class="admin-content" style="max-width: 1100px; margin: 0 auto;">
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <style>
        .pricing-hero {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 10px 20px rgba(99,102,241,.25);
        }
        .plan-card {
            border: 1px solid rgba(0,0,0,.06);
            border-radius: 14px;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .plan-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,.08); }
        .plan-price { font-size: 2.25rem; font-weight: 800; }
        .plan-badge { position: absolute; top: 10px; right: 12px; }
        .feature-item { display:flex; align-items:center; gap:.5rem; color:#374151; }
        .feature-item i { color:#10b981; }
    </style>

    <div class="pricing-hero text-center">
        <h4 class="mb-1">Unlock Your Full NCLEX Prep</h4>
        <p class="mb-0" style="opacity:.95">One-time payment • No auto-renewals • Instant access</p>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="plan-card h-100 position-relative">
                <div class="card-body p-4 text-center">
                    <div class="h6 text-muted mb-1">1-Month Access</div>
                    <div class="plan-price mb-1">$49</div>
                    <div class="text-muted mb-3">30 days of full access</div>
                    <div class="text-start small d-grid gap-2">
                        <div class="feature-item"><i class="fa-solid fa-check"></i><span>Unlimited practice tests</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check"></i><span>4,000+ NCLEX-style questions</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check"></i><span>Detailed rationales</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check"></i><span>Performance tracking</span></div>
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center p-3">
                    <div id="paypal-monthly"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-5">
            <div class="plan-card h-100 position-relative border-primary">
                <span class="badge bg-warning text-dark plan-badge">Best Value</span>
                <div class="card-body p-4 text-center">
                    <div class="h6 text-muted mb-1">3-Month Access</div>
                    <div class="plan-price mb-1">$99</div>
                    <div class="text-muted mb-3">90 days of full access</div>
                    <div class="text-start small d-grid gap-2">
                        <div class="feature-item"><i class="fa-solid fa-check"></i><span>Everything in 1-Month Access</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check"></i><span>Save $48 vs monthly plan</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check"></i><span>Extended study time</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check"></i><span>Progress analytics</span></div>
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center p-3">
                    <div id="paypal-quarterly"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body text-center">
            <div class="d-inline-flex align-items-center gap-2 text-muted">
                <i class="fa-solid fa-shield-halved text-primary"></i>
                <span>No subscriptions • Secure payments by PayPal • Instant activation</span>
            </div>
        </div>
    </div>

    <script src="https://www.paypal.com/sdk/js?client-id=<?= esc(getenv('PAYPAL_SANDBOX_CLIENT_ID')) ?>&currency=USD&intent=capture"></script>
    <script>
        function renderButton(containerId, plan, amount) {
            paypal.Buttons({
                style: { layout: 'vertical', color: 'blue', shape: 'pill', label: 'pay' },
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            description: plan === 'monthly' ? '1-Month NCLEX Test Bank Access' : '3-Month NCLEX Test Bank Access',
                            amount: { value: amount.toString(), currency_code: 'USD' }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        window.location = '<?= base_url('subscriptions/success') ?>?orderID=' + encodeURIComponent(data.orderID) + '&plan=' + encodeURIComponent(plan);
                    });
                }
            }).render(containerId);
        }
        renderButton('#paypal-monthly', 'monthly', 49);
        renderButton('#paypal-quarterly', 'quarterly', 99);
    </script>
</div>

