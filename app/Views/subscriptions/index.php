<?= view('admin/partials/header', ['title' => $title ?? 'Access Plans']) ?>
    <div class="admin-page-header">
        <div class="admin-page-title text-center">
            <h1 class="display-4 mb-2"><?= esc($title ?? 'Access Plans') ?></h1>
            <p class="lead text-muted">Get unlimited access to our comprehensive NCLEX test bank</p>
        </div>
    </div>
    <div class="admin-content" style="max-width:1200px; margin:0 auto;">
    <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <style>
    .pricing-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .pricing-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .pricing-header {
        background: linear-gradient(45deg, #6366f1, #818cf8);
        padding: 2rem;
        color: white;
        text-align: center;
        border-radius: 15px 15px 0 0;
    }
    .pricing-popular {
        background: linear-gradient(45deg, #4f46e5, #6366f1);
    }
    .pricing-price {
        font-size: 3rem;
        font-weight: bold;
        margin: 1rem 0;
    }
    .pricing-duration {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    .pricing-features {
        padding: 2rem;
    }
    .pricing-feature {
        padding: 0.5rem 0;
        display: flex;
        align-items: center;
        color: #4b5563;
    }
    .pricing-feature i {
        color: #10b981;
        margin-right: 1rem;
        font-size: 1.2rem;
    }
    .pricing-cta {
        padding: 0 2rem 2rem 2rem;
    }
    .pricing-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #fbbf24;
        color: #92400e;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
    }
    .pricing-guarantee {
        background: #f8fafc;
        border-radius: 12px;
        padding: 2rem;
        margin-top: 3rem;
        text-align: center;
    }
    .pricing-guarantee i {
        font-size: 2.5rem;
        color: #6366f1;
        margin-bottom: 1rem;
    }
    </style>

    <div class="row g-4 justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card pricing-card h-100">
                <div class="pricing-header">
                    <h3>1-Month Access</h3>
                    <div class="pricing-price">$49</div>
                    <div class="pricing-duration">30 days of full access</div>
                </div>
                <div class="pricing-features">
                    <div class="pricing-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Unlimited practice tests</span>
                    </div>
                    <div class="pricing-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>4,000+ NCLEX-style questions</span>
                    </div>
                    <div class="pricing-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Detailed rationales</span>
                    </div>
                    <div class="pricing-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Performance tracking</span>
                    </div>
                    <div class="pricing-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Mobile-friendly access</span>
                    </div>
                </div>
                <div class="pricing-cta">
                    <div id="paypal-monthly"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-5">
            <div class="card pricing-card h-100">
                <div class="pricing-badge">Best Value</div>
                <div class="pricing-header pricing-popular">
                    <h3>3-Month Access</h3>
                    <div class="pricing-price">$99</div>
                    <div class="pricing-duration">90 days of full access</div>
                </div>
                <div class="pricing-features">
                    <div class="pricing-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Everything in 1-Month Access</span>
                    </div>
                    <div class="pricing-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Save $48 vs monthly plan</span>
                    </div>
                    <div class="pricing-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Extended study time</span>
                    </div>
                    <div class="pricing-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Progress analytics</span>
                    </div>
                    <div class="pricing-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Priority support</span>
                    </div>
                </div>
                <div class="pricing-cta">
                    <div id="paypal-quarterly"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="pricing-guarantee">
        <i class="fas fa-shield-check mb-3"></i>
        <h4>Our Promise to You</h4>
        <p class="text-muted mb-0">
            One-time payment • No automatic renewals • Instant access<br>
            Comprehensive test prep • Regular content updates • Secure payment
        </p>
    </div>

    <?php $paypalClientId = env('PAYPAL_CLIENT_ID') ?? env('PAYPAL_LIVE_CLIENT_ID') ?? env('PAYPAL_SANDBOX_CLIENT_ID');
          $paypalCurrency = env('PAYPAL_CURRENCY') ?? 'USD';
          $paypalIntent = env('PAYPAL_INTENT') ?? 'capture';
    ?>
    <script src="https://www.paypal.com/sdk/js?client-id=<?= esc($paypalClientId) ?>&currency=<?= esc($paypalCurrency) ?>&intent=<?= esc($paypalIntent) ?>"></script>
    <script>
        function renderButton(containerId, plan, amount) {
            paypal.Buttons({
                style: {
                    layout: 'vertical',
                    color: 'blue',
                    shape: 'pill',
                    label: 'pay'
                },
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            description: plan === 'monthly' ? '1-Month NCLEX Prep Course Access' : '3-Month NCLEX Prep Course Access',
                            amount: {
                                value: amount.toString(),
                                currency_code: 'USD',
                                breakdown: {
                                    item_total: {
                                        currency_code: 'USD',
                                        value: amount.toString()
                                    }
                                }
                            },
                            items: [{
                                name: plan === 'monthly' ? '1-Month Access Pass' : '3-Month Access Pass',
                                description: plan === 'monthly' ? '30 days full access' : '90 days full access',
                                unit_amount: {
                                    currency_code: 'USD',
                                    value: amount.toString()
                                },
                                quantity: '1'
                            }]
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        window.location = '/subscriptions/success?orderID=' + encodeURIComponent(data.orderID) + '&plan=' + encodeURIComponent(plan);
                    });
                }
            }).render(containerId);
        }
        renderButton('#paypal-monthly', 'monthly', 49);
        renderButton('#paypal-quarterly', 'quarterly', 99);
    </script>
    </div>
<?= view('admin/partials/footer') ?>