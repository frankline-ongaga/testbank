<!-- Page Title Banner Start -->
<section class="page_title_banner">
    <div class="container">
        <div class="content">
            <div class="title">
                <h1>Pricing</h1>
                <img src="<?= base_url('assets/media/shapes/tag-2.png'); ?>" alt="" class="tag">
            </div>
            <div class="educate-tilt"
                data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 2, "speed": 700, "scale": 1 }'>
                <img src="<?= base_url('assets/media/resources/page_title.png'); ?>" alt="" class="main_img">
            </div>
            <img src="<?= base_url('assets/media/shapes/circle-lines-2.png'); ?>" alt="" class="circle_vector">
        </div>
    </div>
</section>
<!-- Page Title Banner End -->

<section class="py-60 exam-pricing-section">
    <div class="container">
        <style>
            .exam-pricing-section { background: #f6f8fa; }
            .exam-pricing-section * { letter-spacing: 0; }
            .pricing-intro { max-width: 700px; margin: 0 auto 32px; text-align: center; }
            .pricing-intro h2 { font-size: 30px; line-height: 1.3; margin-bottom: 10px; }
            .pricing-intro p { color: #667085; font-size: 16px; line-height: 1.6; margin: 0; }
            .exam-pricing-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px; }
            .exam-pricing-card { display: flex; flex-direction: column; min-width: 0; background: #fff; border: 1px solid #dce3e9; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 16px rgba(16, 24, 40, .04); }
            .exam-pricing-head { padding: 24px 22px 20px; border-top: 3px solid #0aa6d7; }
            .exam-pricing-head h3 { margin: 0 0 8px; color: #17212f; font-size: 24px; line-height: 1.3; font-weight: 800; }
            .exam-pricing-head p { margin: 0; color: #667085; font-size: 14px; line-height: 1.6; min-height: 68px; }
            .pricing-plans { margin: 0; padding: 0; }
            .pricing-plan { display: grid; grid-template-columns: minmax(0, 1fr) auto; align-items: center; gap: 14px; min-height: 88px; padding: 18px 22px; border-top: 1px solid #edf0f3; }
            .pricing-plan dt { min-width: 0; margin: 0; }
            .price-label { display: block; font-size: 16px; line-height: 1.4; font-weight: 700; color: #17212f; }
            .price-note { display: block; margin-top: 4px; font-size: 13px; line-height: 1.5; font-weight: 400; color: #667085; }
            .pricing-plan dd { margin: 0; text-align: right; white-space: nowrap; }
            .price-value { display: block; font-size: 28px; font-weight: 800; color: #17212f; line-height: 1.2; }
            .price-currency { display: block; margin-top: 3px; font-size: 11px; line-height: 1.4; color: #667085; }
            .pricing-plan.is-annual { background: #fff7e8; border-top-color: #f7dfb7; }
            .pricing-plan.is-annual .price-value { color: #a34e00; }
            .price-best { display: inline-block; margin: 6px 0 0; padding: 3px 7px; border-radius: 4px; background: #ffdb58; color: #63430c; font-size: 11px; font-weight: 700; line-height: 1.4; }
            .pricing-features { display: grid; gap: 10px; list-style: none; padding: 22px; margin: auto 0 0; border-top: 1px solid #edf0f3; }
            .pricing-feature { display: flex; gap: 10px; align-items: flex-start; color: #526071; font-size: 13px; line-height: 1.5; }
            .pricing-feature i { flex-shrink: 0; color: #0aa6d7; margin-top: 3px; }
            .pricing-cta { padding: 0 22px 24px; }
            .pricing-cta .pricing-access-button { display: flex; align-items: center; justify-content: center; width: 100%; min-height: 46px; padding: 12px 16px; border: 1px solid #0aa6d7; border-radius: 6px; background: #0aa6d7; color: #fff; font-size: 14px; line-height: 1.4; font-weight: 700; text-align: center; white-space: normal; transition: background .2s ease; }
            .pricing-cta .pricing-access-button:hover { background: #0783ab; border-color: #0783ab; }
            .pricing-cta .pricing-access-button:focus-visible { outline: 3px solid #ffdb58; outline-offset: 3px; }
            @media (max-width: 991px) {
                .exam-pricing-grid { grid-template-columns: 1fr; max-width: 560px; margin: 0 auto; gap: 20px; }
                .exam-pricing-head p { min-height: 0; }
                .pricing-features { margin-top: 0; }
            }
            @media (max-width: 480px) {
                .pricing-intro h2 { font-size: 25px; }
                .pricing-intro p { font-size: 14px; }
                .exam-pricing-head { padding: 20px 18px 18px; }
                .pricing-plan { padding: 16px 18px; }
                .pricing-features { padding: 20px 18px; }
                .pricing-cta { padding: 0 18px 20px; }
            }
        </style>

        <div class="pricing-intro">
            <h2>Choose your exam access</h2>
            <p>Prepare for NCLEX, ATI TEAS 7, or HESI at your own pace. All packages are a one-time payment in USD.</p>
        </div>

        <div class="exam-pricing-grid">
            <?php foreach (($products ?? []) as $product): ?>
                <?php $registerUrl = base_url('register') . '?product=' . rawurlencode((string) $product['slug']); ?>
                <div class="exam-pricing-card">
                    <div class="exam-pricing-head">
                        <h3><?= esc($product['name']) ?></h3>
                        <p><?= esc($product['description'] ?? 'Focused practice tests, review questions, and clear rationales for your exam.') ?></p>
                    </div>
                    <dl class="pricing-plans">
                        <?php foreach (\App\Models\ExamProductModel::accessPlans($product) as $planKey => $plan): ?>
                            <div class="pricing-plan <?= $planKey === 'annual' ? 'is-annual' : '' ?>">
                                <dt>
                                    <span class="price-label"><?= esc($plan['label']) ?></span>
                                    <span class="price-note"><?= esc(match ($planKey) {
                                        'annual' => 'A full year of access',
                                        'quarterly' => '90 days of access',
                                        default => '30 days of access',
                                    }) ?></span>
                                    <?php if ($planKey === 'annual'): ?>
                                        <span class="price-best">Best value</span>
                                    <?php endif; ?>
                                </dt>
                                <dd>
                                    <span class="price-value">$<?= esc(number_format($plan['amount'], 0)) ?></span>
                                    <span class="price-currency">USD</span>
                                </dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                    <ul class="pricing-features">
                        <li class="pricing-feature"><i class="fas fa-check" aria-hidden="true"></i><span>Product-specific practice tests</span></li>
                        <li class="pricing-feature"><i class="fas fa-check" aria-hidden="true"></i><span>Detailed answer rationales</span></li>
                        <li class="pricing-feature"><i class="fas fa-check" aria-hidden="true"></i><span>Access on desktop and mobile</span></li>
                    </ul>
                    <div class="pricing-cta">
                        <a href="<?= esc($registerUrl); ?>" class="pricing-access-button">
                            Get <?= esc($product['short_name'] ?: $product['name']) ?> Access
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
