<!-- Page Title Banner Start -->
<section class="page_title_banner">
    <div class="container">
        <div class="content">
            <div class="title">
                <h1>How It Works</h1>
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

<style>
    .hiw-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 3rem 0;
        margin-bottom: 3rem;
    }
    .hiw-steps-wrapper {
        display: grid;
        gap: 2rem;
        margin: 3rem 0;
    }
    .hiw-step {
        background: #ffffff;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,.08);
        transition: all .3s ease;
        border: 2px solid transparent;
    }
    .hiw-step:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,.12);
        border-color: #667eea;
    }
    .hiw-step-number {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
    }
    .hiw-step-1 .hiw-step-number { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; }
    .hiw-step-2 .hiw-step-number { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; }
    .hiw-step-3 .hiw-step-number { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: #fff; }
    .hiw-step h3 { font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #1f2937; }
    .hiw-step p { color: #6b7280; font-size: 1rem; line-height: 1.6; margin-bottom: 1.5rem; }
    .hiw-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .hiw-features li {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem 0;
        color: #374151;
        font-size: 0.95rem;
    }
    .hiw-features li i {
        color: #10b981;
        font-size: 1.1rem;
        margin-top: 2px;
        min-width: 20px;
    }
    .hiw-cta-section {
        background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%);
        border-radius: 20px;
        padding: 3rem 2rem;
        text-align: center;
        margin-top: 3rem;
    }
    .hiw-cta-section h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: #1f2937;
    }
    .hiw-cta-section p {
        font-size: 1.1rem;
        color: #6b7280;
        margin-bottom: 2rem;
    }
    .hiw-benefits {
        background: #ffffff;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,.08);
        margin-top: 3rem;
    }
    .hiw-benefits h3 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #1f2937;
    }
    .hiw-benefit-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    .hiw-benefit-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }
    .hiw-benefit-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .hiw-benefit-icon.icon-1 { background: rgba(99,102,241,.12); color: #6366f1; }
    .hiw-benefit-icon.icon-2 { background: rgba(16,185,129,.12); color: #10b981; }
    .hiw-benefit-icon.icon-3 { background: rgba(59,130,246,.12); color: #3b82f6; }
    .hiw-benefit-icon.icon-4 { background: rgba(245,158,11,.12); color: #f59e0b; }
    .hiw-benefit-item h5 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #1f2937;
    }
    .hiw-benefit-item p {
        font-size: 0.9rem;
        color: #6b7280;
        margin: 0;
    }
</style>

<!-- How It Works Content Start -->
<section class="py-60">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="color-primary mb-3 text-uppercase" style="letter-spacing: 2px; font-weight: 600;">Simple 3-Step Process</h6>
            <h2 class="mb-3" style="font-size: 2.5rem; font-weight: 800;">Get Started in Minutes</h2>
            <p class="lead text-muted" style="max-width: 600px; margin: 0 auto;">Access thousands of NCLEX practice questions and study materials to ace your exam</p>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="hiw-steps-wrapper">
                    <!-- Step 1 -->
                    <div class="hiw-step hiw-step-1">
                        <div class="hiw-step-number">1</div>
                        <h3><i class="far fa-credit-card me-2"></i>Choose Your Plan</h3>
                        <p>Select a subscription that fits your study timeline. Secure checkout with PayPal—no hidden fees, no auto-renewals.</p>
                        <ul class="hiw-features">
                            <li><i class="fas fa-check-circle"></i><span>Pick 1-month ($49) or 3-month ($99) access</span></li>
                            <li><i class="fas fa-check-circle"></i><span>Instant activation after payment</span></li>
                            <li><i class="fas fa-check-circle"></i><span>100% secure PayPal checkout</span></li>
                        </ul>
                    </div>

                    <!-- Step 2 -->
                    <div class="hiw-step hiw-step-2">
                        <div class="hiw-step-number">2</div>
                        <h3><i class="fas fa-unlock-alt me-2"></i>Access Your Dashboard</h3>
                        <p>Log in to your personalized student portal and explore all available study resources at your fingertips.</p>
                        <ul class="hiw-features">
                            <li><i class="fas fa-check-circle"></i><span><strong>Test Bank:</strong> Take timed practice tests</span></li>
                            <li><i class="fas fa-check-circle"></i><span><strong>Study Library:</strong> Browse by category and subcategory</span></li>
                            <li><i class="fas fa-check-circle"></i><span><strong>Analytics:</strong> Track your progress and performance</span></li>
                            <li><i class="fas fa-check-circle"></i><span>Mobile-friendly interface for studying anywhere</span></li>
                        </ul>
                    </div>

                    <!-- Step 3 -->
                    <div class="hiw-step hiw-step-3">
                        <div class="hiw-step-number">3</div>
                        <h3><i class="fas fa-graduation-cap me-2"></i>Study & Excel</h3>
                        <p>Master NCLEX content with comprehensive questions, detailed rationales, and organized study notes.</p>
                        <ul class="hiw-features">
                            <li><i class="fas fa-check-circle"></i><span><strong>Study Questions:</strong> Answers highlighted with full explanations</span></li>
                            <li><i class="fas fa-check-circle"></i><span><strong>Practice Tests:</strong> Timed or untimed with instant feedback</span></li>
                            <li><i class="fas fa-check-circle"></i><span><strong>Study Notes:</strong> Rich content organized by subcategory</span></li>
                            <li><i class="fas fa-check-circle"></i><span>Detailed rationales for all answer choices</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hiw-benefits">
                    <h3><i class="fas fa-star me-2" style="color: #f59e0b;"></i>What You Get</h3>
                    <p class="text-muted">Everything you need to pass your NCLEX exam with confidence</p>
                    
                    <div class="hiw-benefit-grid">
                       
                        
                        <div class="hiw-benefit-item">
                            <div class="hiw-benefit-icon icon-2">
                                <i class="far fa-lightbulb" style="font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <h5>Detailed Rationales</h5>
                                <p>Understand why answers are correct or incorrect</p>
                            </div>
                        </div>
                        
                        <div class="hiw-benefit-item">
                            <div class="hiw-benefit-icon icon-3">
                                <i class="fas fa-layer-group" style="font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <h5>Organized Topics</h5>
                                <p>Navigate by category and subcategory easily</p>
                            </div>
                        </div>
                        
                        <div class="hiw-benefit-item">
                            <div class="hiw-benefit-icon icon-4">
                                <i class="fas fa-chart-line" style="font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <h5>Performance Tracking</h5>
                                <p>Monitor your progress with detailed analytics</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <ul class="hiw-features">
                            <li><i class="fas fa-check-circle"></i><span>Study at your own pace—no rush, no stress</span></li>
                            <li><i class="fas fa-check-circle"></i><span>Clean, modern interface designed for students</span></li>
                            <li><i class="fas fa-check-circle"></i><span>Access from any device: desktop, tablet, or phone</span></li>
                            <li><i class="fas fa-check-circle"></i><span>First subcategory in each topic is FREE to try</span></li>
                        </ul>
                    </div>
                </div>

                <div class="educate-tilt mt-4"
                    data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 2, "speed": 700, "scale": 1 }'>
                    <img src="<?= base_url('assets/media/resources/about-1.png'); ?>" alt="NCLEX Study Dashboard" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="hiw-cta-section">
            <h2><i class="fas fa-rocket me-2"></i>Ready to Start Your NCLEX Journey?</h2>
            <p>Join thousands of nursing students who trust us for their exam preparation</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="<?= base_url('pricing'); ?>" class="btn btn-primary btn-lg px-5 py-3" style="font-size: 1.1rem; font-weight: 600;">
                    <i class="fas fa-bolt me-2"></i>View Pricing
                </a>
                <a href="<?= base_url('register'); ?>" class="btn btn-outline-dark btn-lg px-5 py-3" style="font-size: 1.1rem; font-weight: 600;">
                    <i class="fas fa-user-plus me-2"></i>Sign Up Free
                </a>
            </div>
            <p class="mt-3 mb-0 small text-muted">Already have an account? <a href="<?= base_url('login/student'); ?>" class="text-decoration-none fw-semibold">Login here</a></p>
        </div>
    </div>
</section>
<!-- How It Works Content End -->
