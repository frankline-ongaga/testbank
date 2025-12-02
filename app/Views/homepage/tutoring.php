<!-- Page Title Banner Start -->
<section class="page_title_banner">
    <div class="container">
        <div class="content">
            <div class="title">
                <h1>NCLEX Tutoring Services</h1>
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
    .tutoring-section {
        padding: 4rem 0;
    }
    .section-intro {
        max-width: 800px;
        margin: 0 auto 4rem;
        text-align: center;
    }
    .section-intro h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
    }
    .section-intro p {
        font-size: 1.1rem;
        color: #64748b;
        line-height: 1.7;
    }
    .feature-box {
        margin-bottom: 2rem;
        padding: 2rem;
        background: #f8fafc;
        border-radius: 12px;
        border-left: 4px solid #667eea;
    }
    .feature-box h4 {
        color: #1e293b;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    .feature-box p {
        color: #64748b;
        margin-bottom: 0;
        line-height: 1.6;
    }
    .benefit-list {
        list-style: none;
        padding: 0;
        margin: 2rem 0;
    }
    .benefit-list li {
        padding: 0.75rem 0;
        display: flex;
        align-items: start;
        gap: 0.75rem;
    }
    .benefit-list li i {
        color: #667eea;
        font-size: 1.2rem;
        margin-top: 0.2rem;
        flex-shrink: 0;
    }
    .cta-box {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        padding: 3rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,.08);
        position: sticky;
        top: 100px;
    }
    .cta-box h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
    }
    .cta-box p {
        color: #64748b;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    .whatsapp-btn {
        display: block;
        width: 100%;
        background: #25D366;
        color: white;
        padding: 1.25rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.15rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        margin-bottom: 2rem;
    }
    .whatsapp-btn:hover {
        background: #128C7E;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
        color: white;
    }
    .whatsapp-btn i {
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }
    .contact-info {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }
    .contact-info p {
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .contact-info i {
        color: #667eea;
        width: 20px;
    }
    .services-grid {
        display: grid;
        gap: 1.5rem;
        margin: 3rem 0;
    }
    @media (max-width: 768px) {
        .cta-box {
            position: static;
            margin-top: 3rem;
        }
    }
</style>

<div class="container tutoring-section">
    <div class="row g-5">
        <!-- Left Column: Text Content -->
        <div class="col-lg-7">
            <div class="section-intro">
                <h2>Personalized NCLEX Tutoring</h2>
                <p>Get expert one-on-one guidance from experienced nursing educators who will help you master the NCLEX and achieve your dreams of becoming a licensed nurse.</p>
            </div>

            <div class="services-grid">
                <div class="feature-box">
                    <h4><i class="fas fa-user-graduate me-2" style="color: #667eea;"></i>One-on-One Sessions</h4>
                    <p>Personalized tutoring sessions tailored to your unique learning style and specific areas of need. Our experienced NCLEX educators understand the exam format and will guide you through every challenge.</p>
                </div>

                <div class="feature-box">
                    <h4><i class="fas fa-chalkboard-teacher me-2" style="color: #667eea;"></i>Expert Guidance</h4>
                    <p>Learn from experienced nursing professionals who have helped hundreds of students pass the NCLEX. Master test-taking strategies and gain deep content knowledge with proven teaching methods.</p>
                </div>

            </div>
        </div>

        <!-- Right Column: WhatsApp CTA -->
        <div class="col-lg-5">
            <div class="cta-box">
                <h3>Ready to Pass the NCLEX?</h3>
                <p>Contact us today to learn more about our tutoring packages and start your journey to becoming a licensed nurse!</p>
                
                <a href="https://wa.me/12092609257?text=Hi!%20I'm%20interested%20in%20NCLEX%20tutoring%20services." 
                   target="_blank" 
                   class="whatsapp-btn">
                    <i class="fab fa-whatsapp"></i>Get Tutoring Help
                </a>

                <div class="contact-info">
                    <p><i class="fas fa-clock"></i><span>Available 24/7 for your convenience</span></p>
                    <p><i class="fas fa-reply"></i><span>Quick response within minutes</span></p>
                    <p><i class="fas fa-shield-alt"></i><span>100% confidential consultation</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- What You'll Get Section - Full Width -->
    <div class="row mt-5">
        <div class="col-12">
            <div style="background: #f8fafc; padding: 2.5rem; border-radius: 12px;">
                <h4 class="mb-4" style="text-align: center; font-size: 1.5rem; font-weight: 700; color: #1e293b;">What You'll Get:</h4>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="benefit-list">
                            <li><i class="fas fa-check-circle"></i><span><strong>Customized Study Plans</strong> designed for your strengths and weaknesses</span></li>
                            <li><i class="fas fa-check-circle"></i><span><strong>Flexible Scheduling</strong> to fit your busy lifestyle</span></li>
                            <li><i class="fas fa-check-circle"></i><span><strong>Test-Taking Strategies</strong> proven to boost scores</span></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="benefit-list">
                            <li><i class="fas fa-check-circle"></i><span><strong>Content Review</strong> with in-depth explanations</span></li>
                            <li><i class="fas fa-check-circle"></i><span><strong>Practice Questions</strong> with detailed rationales</span></li>
                            <li><i class="fas fa-check-circle"></i><span><strong>Motivation & Accountability</strong> to keep you on track</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

