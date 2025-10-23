<?php /* Client subscriptions: show current subscription (if any) and packages */ ?>

<div class="admin-content" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
    
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-2">Choose Your Plan</h1>
        <p class="lead text-muted">Get unlimited access to our complete test bank library</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger shadow-sm mb-4">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success shadow-sm mb-4"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <?php if (!empty($current_subscription)): ?>
        <?php 
            $planName = $current_subscription['plan'] ?? '';
            $endAt = $current_subscription['end_at'] ?? null;
            $daysLeft = $endAt ? max(0, ceil((strtotime($endAt) - time())/86400)) : null;
            $status = strtolower($current_subscription['status'] ?? '');
            $statusBadge = $status === 'active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
        ?>
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body p-4 text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <i class="fa-solid fa-circle-check" style="font-size: 2rem;"></i>
                            <div>
                                <h5 class="mb-1">Current Plan: <?= esc(strtoupper($planName)) ?></h5>
                                <div class="d-flex gap-2 flex-wrap">
                                    <?= $statusBadge ?>
                                    <?php if ($endAt): ?>
                                        <span class="badge bg-white text-dark">Ends <?= esc(date('M j, Y', strtotime($endAt))) ?></span>
                                    <?php endif; ?>
                                    <?php if ($daysLeft !== null): ?>
                                        <span class="badge" style="background: rgba(255,255,255,0.3);"><?= (int)$daysLeft ?> days remaining</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="#plans" class="btn btn-light px-4">Renew or Upgrade</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body p-4 text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-exclamation-circle" style="font-size: 2rem;"></i>
                            <div>
                                <h5 class="mb-1">No Active Subscription</h5>
                                <p class="mb-0">Choose a plan below to unlock full access</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="#plans" class="btn btn-light px-4">Choose a Plan</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <style>
        .plan-card {
            border: 2px solid #e5e7eb;
            border-radius: 20px;
            transition: all .3s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
            background: #fff;
            position: relative;
        }
        .plan-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 40px rgba(0,0,0,.12);
            border-color: #667eea;
        }
        .plan-card.featured {
            border-color: #667eea;
            border-width: 3px;
            box-shadow: 0 10px 30px rgba(102,126,234,.2);
        }
        .plan-price { 
            font-size: 3.5rem; 
            font-weight: 800; 
            line-height: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .plan-badge { 
            position: absolute; 
            top: 16px; 
            right: 16px; 
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: #fff;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .feature-item { 
            display: flex; 
            align-items: center; 
            gap: 0.75rem; 
            padding: 0.75rem 0;
            color: #374151;
            font-size: 0.95rem;
        }
        .feature-item i { 
            color: #10b981; 
            font-size: 1.1rem;
            min-width: 20px;
        }
        .plan-accent {
            height: 5px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        .paypal-container {
            min-height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <div id="plans" class="row g-4 justify-content-center mb-5">
        <div class="col-md-6 col-lg-5">
            <div class="card plan-card h-100">
                <div class="plan-accent"></div>
                <div class="card-body p-4 text-center">
                    <div class="text-uppercase text-muted fw-semibold mb-2" style="font-size: 0.875rem; letter-spacing: 1px;">1-Month Access</div>
                    <div class="plan-price mb-2">$49</div>
                    <div class="text-muted mb-4">Per month</div>
                    <div class="text-start mb-4">
                        <div class="feature-item"><i class="fa-solid fa-check-circle"></i><span>Unlimited practice tests</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check-circle"></i><span>4,000+ NCLEX questions</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check-circle"></i><span>Detailed rationales</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check-circle"></i><span>Performance tracking</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check-circle"></i><span>Study notes access</span></div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <div class="text-center small text-muted mb-3">
                        <i class="fa-brands fa-cc-paypal me-1"></i>Secure checkout with PayPal
                    </div>
                    <div class="paypal-container" id="paypal-monthly"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-5">
            <div class="card plan-card featured h-100">
                <span class="plan-badge"><i class="fa-solid fa-star me-1"></i>Best Value</span>
                <div class="plan-accent"></div>
                <div class="card-body p-4 text-center">
                    <div class="text-uppercase text-muted fw-semibold mb-2" style="font-size: 0.875rem; letter-spacing: 1px;">3-Month Access</div>
                    <div class="plan-price mb-2">$99</div>
                    <div class="text-muted mb-4">For 3 months <span class="badge bg-success">Save $48</span></div>
                    <div class="text-start mb-4">
                        <div class="feature-item"><i class="fa-solid fa-check-circle"></i><span>Everything in 1-Month</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check-circle"></i><span>Extended study period</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check-circle"></i><span>Progress analytics</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check-circle"></i><span>Priority support</span></div>
                        <div class="feature-item"><i class="fa-solid fa-check-circle"></i><span>Money-back guarantee</span></div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <div class="text-center small text-muted mb-3">
                        <i class="fa-brands fa-cc-paypal me-1"></i>Secure checkout with PayPal
                    </div>
                    <div class="paypal-container" id="paypal-quarterly"></div>
                </div>
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


