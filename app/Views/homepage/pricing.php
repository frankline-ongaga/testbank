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

<section class="py-60">
    <div class="container">
        <style>
            .pricing-intro { max-width: 820px; margin: 0 auto 34px; text-align: center; }
            .pricing-intro h2 { font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 12px; }
            .pricing-intro p { color: #5f6570; font-size: 1.08rem; }
            .exam-pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr)); gap: 24px; }
            .exam-pricing-card { background: #fff; border: 1px solid #dbeafe; border-radius: 18px; overflow: hidden; box-shadow: 0 16px 36px rgba(15, 23, 42, .08); transition: transform .25s ease, box-shadow .25s ease; }
            .exam-pricing-card:hover { transform: translateY(-5px); box-shadow: 0 22px 46px rgba(15, 23, 42, .12); }
            .exam-pricing-head { padding: 28px; background: linear-gradient(135deg, rgba(10,166,215,.14), rgba(255,153,0,.12)); border-bottom: 1px solid #e7edf5; }
            .exam-pricing-head h3 { margin: 0 0 10px; color: #111827; font-weight: 800; }
            .exam-pricing-head p { margin: 0; color: #596273; min-height: 54px; }
            .price-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; padding: 22px; }
            .price-box { border: 1px solid #e5e7eb; border-radius: 14px; padding: 18px; }
            .price-box.best { border-color: #0aa6d7; box-shadow: inset 0 4px 0 #0aa6d7; }
            .price-value { font-size: 2.3rem; font-weight: 900; color: #0aa6d7; line-height: 1; margin: 8px 0; }
            .price-label { font-weight: 800; color: #111827; }
            .price-note { color: #687386; font-size: .92rem; min-height: 42px; }
            .pricing-features { padding: 0 24px 22px; }
            .pricing-feature { display: flex; gap: 12px; align-items: flex-start; padding: 7px 0; color: #4b5563; }
            .pricing-feature i { color: #0aa6d7; margin-top: 4px; }
            .pricing-cta { padding: 0 24px 26px; }
            @media (max-width: 480px) { .price-row { grid-template-columns: 1fr; } }
        </style>

        <div class="pricing-intro">
            <h2>Choose the exam you are preparing for</h2>
            <p>NCLEX, ATI TEAS 7, and HESI access are now separate products, so you only pay for the test bank you need.</p>
        </div>

        <div class="exam-pricing-grid">
            <?php foreach (($products ?? []) as $product): ?>
                <div class="exam-pricing-card">
                    <div class="exam-pricing-head">
                        <h3><?= esc($product['name']) ?></h3>
                        <p><?= esc($product['description'] ?? 'Focused practice tests, review questions, and clear rationales for your exam.') ?></p>
                    </div>
                    <div class="price-row">
                        <div class="price-box">
                            <div class="price-label">1 Month</div>
                            <div class="price-value">$<?= esc(number_format((float) $product['monthly_price'], 0)) ?></div>
                            <div class="price-note">Best for a focused final review sprint.</div>
                        </div>
                        <div class="price-box best">
                            <div class="price-label">3 Months</div>
                            <div class="price-value">$<?= esc(number_format((float) $product['quarterly_price'], 0)) ?></div>
                            <div class="price-note">More time to practice, review, and improve.</div>
                        </div>
                    </div>
                    <div class="pricing-features">
                        <div class="pricing-feature"><i class="fas fa-check-circle"></i><span>Product-specific practice tests</span></div>
                        <div class="pricing-feature"><i class="fas fa-check-circle"></i><span>Detailed rationales for stronger review</span></div>
                        <div class="pricing-feature"><i class="fas fa-check-circle"></i><span>Mobile-friendly learner dashboard</span></div>
                    </div>
                    <div class="pricing-cta">
                        <a href="<?= base_url('register'); ?>" class="btn btn-primary btn-lg w-100" style="padding: 12px; font-size: 1.05rem; font-weight: 700;">
                            Get <?= esc($product['short_name'] ?: $product['name']) ?> Access
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
