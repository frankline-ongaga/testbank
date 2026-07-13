
    <!-- Hero Banner Start -->
    <section class="hero-banner-1">
      <div class="container">
        <img width="44%" src="<?= base_url('assets/media/acenclex.png'); ?>" alt="" class="main-img">
        <div class="icons">
        
          <img src="<?= base_url('assets/media/shapes/light.png'); ?>" alt="nclex test bank help" class="light wow zoomIn" data-wow-delay="600ms">
        
        </div>
        <div class="content">
          <div class="text_block wow fadeInUp" data-wow-delay="800ms">
            <div class="row">
              <div class="col-xl-8 col-lg-10">
                <img src="<?= base_url('assets/media/shapes/tag.png'); ?>" alt="" class="mb-24 tag wow slideInDown" data-wow-delay="550ms">
                <h1 class="mb-16 title">Master your NCLEX-RN/PN prep with nclexprepcourse practice <span class="fm-sec">  tests and exams. <img
                      src="<?= base_url('assets/media/shapes/rocket.png'); ?>" alt="" class="rocket wow zoomIn"
                      data-wow-delay="700ms"></span></h1>
                <br> <br>

               <h4>Comprehensive practice tests, NCLEX-style questions, free study notes and test banks to help you ace your NCLEX exam</h4>

               <br>



                 

                <div class="btn_block">
                  <a href="<?php echo base_url('register'); ?>" class="educate-btn educate-btn--accent"><span class="educate-btn__curve"></span>Get Started</a>&nbsp; &nbsp;  

                  <img src="<?= base_url('assets/media/shapes/arrow.png'); ?>" alt="" class="arrow">
                </div>
                
              </div>
            </div>
          </div>
        </div>
      
      </div>
    </section>
    <!-- Hero Banner End -->

    <!-- Features Area Start -->
    
    <!-- Features Area End -->



        <!-- Course Detail Area Start -->
    <style>
      .course_testbank #testbankTabs {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 0 !important;
        border-bottom: 0;
      }

      .course_testbank .testbank-category-area {
        position: relative;
        padding: 18px;
        border: 1px solid #bfdbfe;
        border-bottom: 0;
        border-radius: 8px 8px 0 0;
        background:
          linear-gradient(135deg, rgba(10, 166, 215, .08), rgba(10, 166, 215, .04)),
          #ffffff;
        box-shadow: none;
      }

      .course_testbank #testbankTabs .nav-item {
        width: 100%;
      }

      .course_testbank #testbankTabs .nav-link {
        width: 100%;
        min-height: 64px;
        padding: 13px 14px 13px 18px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background:
          linear-gradient(90deg, #0aa6d7 0, #0aa6d7 5px, #ffffff 5px, #ffffff 100%);
        color: #111827;
        box-shadow: 0 8px 18px rgba(15, 23, 42, .06);
        font-size: 15px;
        font-weight: 800;
        line-height: 1.25;
        text-align: left;
        white-space: normal;
        transition: background .2s ease, border-color .2s ease, box-shadow .2s ease, transform .2s ease;
      }

      .course_testbank #testbankTabs .nav-link:hover,
      .course_testbank #testbankTabs .nav-link.active {
        border: 1px solid #f59e0b !important;
        border-color: #f59e0b !important;
        background: #fff7ed !important;
        color: #f59e0b !important;
        box-shadow: 0 14px 28px rgba(245, 158, 11, .18);
        transform: translateY(-2px);
      }

      .course_testbank .testbank-content-panel {
        position: relative;
        margin-top: 0;
        padding: 28px;
        border: 1px solid #bfdbfe;
        border-top: 0;
        border-radius: 0 0 8px 8px;
        background:
          linear-gradient(180deg, #f8fafc 0%, #eef6ff 100%);
        box-shadow: 0 16px 36px rgba(15, 23, 42, .08);
      }

      .course_testbank #testbankTabContent .row {
        row-gap: 10px;
      }

      .course_testbank #testbankTabContent .row > [class*="col-"] {
        margin-bottom: 10px;
      }

      .course_testbank #testbankTabContent .card {
        position: relative;
        height: 100%;
        margin-bottom: 0 !important;
        overflow: hidden;
        border: 1px solid #dbeafe;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 10px 26px rgba(15, 23, 42, .07) !important;
        transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
      }

      .course_testbank #testbankTabContent .card:before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 6px;
        background: #f59e0b;
      }

      .course_testbank #testbankTabContent .card:hover {
        border-color: #f59e0b;
        box-shadow: 0 18px 38px rgba(15, 23, 42, .12) !important;
        transform: translateY(-3px);
      }

      .course_testbank #testbankTabContent .card-body {
        display: flex;
        flex-direction: column;
        align-items: flex-start !important;
        justify-content: flex-start !important;
        min-height: 126px;
        gap: 16px;
        padding: 22px 18px 22px 24px;
      }

      .course_testbank #testbankTabContent .card-title {
        color: #1f2937;
        font-size: 18px !important;
        line-height: 1.35;
      }

      .course_testbank #testbankTabContent .btn {
        flex: 0 0 auto;
        border-radius: 8px;
        font-weight: 800;
      }

      .course_testbank .subcategory-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        align-self: flex-end;
        margin-top: auto;
        padding: 10px 13px;
        border: 1px solid #0aa6d7;
        background: #0aa6d7;
        color: #ffffff;
      }

      .course_testbank .subcategory-action:hover,
      .course_testbank .subcategory-action:focus {
        border-color: #088fb8;
        background: #088fb8;
        color: #ffffff;
      }

      @media (max-width: 1199.98px) {
        .course_testbank #testbankTabs {
          grid-template-columns: repeat(4, minmax(0, 1fr));
        }
      }

      @media (max-width: 991.98px) {
        .course_testbank #testbankTabs {
          grid-template-columns: repeat(3, minmax(0, 1fr));
        }
      }

      @media (max-width: 767.98px) {
        .course_testbank #testbankTabs {
          grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .course_testbank .testbank-content-panel {
          padding: 18px;
        }

        .course_testbank .subcategory-action {
          width: 100%;
          justify-content: center;
          align-self: stretch;
        }
      }

      @media (max-width: 479.98px) {
        .course_testbank #testbankTabs {
          grid-template-columns: 1fr;
        }
      }
    </style>
    <section class="course_testbank pt-60 pb-60" style="min-height:450px;">
      <div class="container">
        <?php if (!empty($studyCategories)) : ?>
          <div class="testbank-category-area">
            <ul class="nav nav-tabs mb-4" id="testbankTabs" role="tablist">
              <?php $isFirst = true; foreach ($studyCategories as $cat) : $tabId = !empty($cat['slug']) ? $cat['slug'] : ('cat' . $cat['id']); ?>
                <li class="nav-item" role="presentation">
                  <button class="nav-link <?= ($isFirst ? 'active' : '') ?>" data-bs-toggle="tab" data-bs-target="#<?= esc($tabId) ?>" type="button" role="tab"><?= esc($cat['name']) ?></button>
                </li>
              <?php $isFirst = false; endforeach; ?>
            </ul>
          </div>

          <div class="tab-content testbank-content-panel" id="testbankTabContent">
            <?php $isFirstPane = true; foreach ($studyCategories as $cat) : $tabId = !empty($cat['slug']) ? $cat['slug'] : ('cat' . $cat['id']); $subs = $studySubcategoriesByCategoryId[$cat['id']] ?? []; ?>
              <div class="tab-pane fade <?= ($isFirstPane ? 'show active' : '') ?>" id="<?= esc($tabId) ?>" role="tabpanel">
                <div class="row g-4">
                  <?php if (!empty($subs)) : foreach ($subs as $sub) : ?>
                    <div class="col-md-4">
                      <div class="card shadow-sm h-100">
                        <div class="card-body">
                          <h5 class="card-title mb-0"><?= esc($sub['name']) ?></h5>
                          <a href="<?= base_url('client/study/' . $cat['id'] . '/subcategories') ?>" class="btn btn-sm subcategory-action">View <i class="fas fa-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; else : ?>
                    <div class="col-12"><p class="text-muted mb-0">No subcategories available.</p></div>
                  <?php endif; ?>
                </div>
              </div>
            <?php $isFirstPane = false; endforeach; ?>
          </div>
        <?php else : ?>
          <div class="text-center text-muted">No categories found yet.</div>
        <?php endif; ?>
      </div>
    </section>
        <!-- Course Detail Area End -->

        <section class="free-practice-section py-60">
            <style>
                .free-practice-section {background: linear-gradient(180deg, #ffffff 0%, #f3fbfe 100%); border-top: 1px solid #e0f2fe; border-bottom: 1px solid #e0f2fe;}
                .free-practice-shell {display: grid; gap: 24px;}
                .free-practice-head {display: grid; grid-template-columns: minmax(0, 1fr) minmax(280px, 420px); gap: 24px; align-items: end;}
                .free-section-kicker {display: inline-flex; align-items: center; gap: 8px; margin-bottom: 12px; color: #f59e0b; font-size: .8rem; font-weight: 900; text-transform: uppercase;}
                .free-section-title {max-width: 760px; font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; line-height: 1.08; color: #0f172a; margin-bottom: .85rem;}
                .free-section-subtitle {max-width: 690px; font-size: 1.05rem; color: #64748b; line-height: 1.65; margin-bottom: 0;}
                .free-benefit-list {display: grid; gap: 10px;}
                .free-benefit-item {display: flex; align-items: center; gap: 10px; padding: 11px 12px; background: #ffffff; border: 1px solid #d7edf6; border-radius: 8px; box-shadow: 0 8px 22px rgba(15, 23, 42, .04);}
                .free-benefit-icon {width: 34px; height: 34px; background: #0aa6d7; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: .9rem; flex-shrink: 0;}
                .free-benefit-text h6 {font-size: .95rem; font-weight: 900; margin-bottom: 0; color: #1e293b;}
                .free-benefit-text p {display: none;}
                .free-test-list {display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px;}
                .free-test-card {position: relative; display: flex; flex-direction: column; min-height: 330px; background: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 16px 36px rgba(15, 23, 42, .08); transition: all .25s ease; overflow: hidden; border: 1px solid #d7edf6;}
                .free-test-card:before {content: ""; position: absolute; top: 0; left: 0; right: 0; height: 5px; background: #0aa6d7;}
                .free-test-card:hover {transform: translateY(-4px); box-shadow: 0 24px 48px rgba(15, 23, 42, .13); border-color: #f59e0b;}
                .free-test-card-header {display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 1.1rem;}
                .free-test-number {display: inline-flex; align-items: center; justify-content: center; min-width: 38px; height: 32px; padding: 0 10px; border-radius: 999px; background: #fff7ed; color: #f59e0b; border: 1px solid #fed7aa; font-size: .82rem; font-weight: 900;}
                .free-test-badge {display: inline-flex; align-items: center; gap: 6px; padding: .42rem .68rem; background: #0aa6d7; color: #fff; border-radius: 999px; font-weight: 900; font-size: .74rem; text-transform: uppercase; white-space: nowrap;}
                .free-test-title {font-size: 1.14rem; font-weight: 900; color: #1e293b; margin-bottom: 1rem; line-height: 1.32;}
                .free-test-meta {display: grid; grid-template-columns: 1fr; gap: .55rem; margin-bottom: 1rem;}
                .free-meta-item {display: flex; align-items: center; gap: .55rem; padding: .55rem .7rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; font-size: .88rem; color: #475569; font-weight: 800;}
                .free-meta-item i {color: #0aa6d7;}
                .free-test-desc {color: #64748b; font-size: .9rem; line-height: 1.5; margin-bottom: 1.1rem;}
                .free-test-cta {display: inline-flex; align-items: center; justify-content: center; gap: .5rem; width: 100%; margin-top: auto; padding: .85rem 1rem; background: #0aa6d7; color: #fff; border: none; border-radius: 8px; font-weight: 900; font-size: .95rem; text-align: center; text-decoration: none; transition: all .22s ease; box-shadow: 0 10px 22px rgba(10, 166, 215, .24);}
                .free-test-cta:hover {background: #088fb8; transform: translateY(-2px); box-shadow: 0 14px 28px rgba(10, 166, 215, .32); color: #fff;}
                .no-test-message {text-align: center; padding: 3rem; background: #ffffff; border-radius: 8px; border: 2px dashed #bae6fd; box-shadow: 0 16px 38px rgba(15, 23, 42, .06);}
                .no-test-message i {font-size: 3rem; color: #94a3b8; margin-bottom: 1rem;}
                .no-test-message h5 {color: #475569; font-weight: 700;}
                .no-test-message p {color: #64748b; margin: 0;}
                @media (max-width: 1199.98px) {.free-test-list {grid-template-columns: repeat(2, minmax(0, 1fr));}}
                @media (max-width: 991.98px) {.free-practice-head {grid-template-columns: 1fr;} .free-benefit-list {grid-template-columns: repeat(3, minmax(0, 1fr));} .free-test-list {grid-template-columns: repeat(2, minmax(0, 1fr));}}
                @media (max-width: 575.98px) {.free-benefit-list {grid-template-columns: 1fr;}}
                @media (max-width: 767.98px) {.free-practice-intro, .free-test-card {padding: 20px;} .free-test-list {grid-template-columns: 1fr;}}
            </style>
            <div class="container">
                <div class="free-practice-shell">
                    <div class="free-practice-head">
                        <div>
                            <span class="free-section-kicker"><i class="fas fa-bolt"></i>Free starter practice</span>
                            <h3 class="free-section-title">Take Our Free NCLEX Practice Test</h3>
                            <p class="free-section-subtitle">Pick a free test and start practicing with timed questions, adaptive flow, and detailed rationales.</p>
                        </div>
                        <div class="free-benefit-list">
                            <div class="free-benefit-item">
                                <div class="free-benefit-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="free-benefit-text">
                                    <h6>NCLEX-Aligned Questions</h6>
                                    <p>Practice with nursing-focused questions built for exam readiness.</p>
                                </div>
                            </div>
                            <div class="free-benefit-item">
                                <div class="free-benefit-icon">
                                    <i class="fas fa-sliders-h"></i>
                                </div>
                                <div class="free-benefit-text">
                                    <h6>Adaptive Testing</h6>
                                    <p>Question flow responds to your performance as you work.</p>
                                </div>
                            </div>
                            <div class="free-benefit-item">
                                <div class="free-benefit-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div class="free-benefit-text">
                                    <h6>Detailed Explanations</h6>
                                    <p>Review rationales after answering so every miss becomes useful.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="free-practice-grid-wrap">
                        <?php if (!empty($freeTests)) : ?>
                            <div class="free-test-list">
                                <?php foreach ($freeTests as $index => $ft): ?>
                                    <div class="free-test-card">
                                        <div class="free-test-card-header">
                                            <span class="free-test-number"><?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                                            <span class="free-test-badge"><i class="fas fa-gift"></i>100% Free</span>
                                        </div>
                                        <h4 class="free-test-title"><?= esc($ft['title']) ?></h4>
                                        <div class="free-test-meta">
                                            <div class="free-meta-item">
                                                <i class="fas fa-tasks"></i>
                                                <span><?= (int)($ft['question_count'] ?? 0) ?> Questions</span>
                                            </div>
                                            <div class="free-meta-item">
                                                <i class="far fa-clock"></i>
                                                <span><?= (int)($ft['time_limit_minutes'] ?? 0) ?> Minutes</span>
                                            </div>
                                            <div class="free-meta-item">
                                                <i class="fas fa-brain"></i>
                                                <span>Adaptive</span>
                                            </div>
                                        </div>
                                        <p class="free-test-desc">
                                            Get instant feedback and rationales while you measure exam readiness.
                                        </p>
                                        <a href="<?= base_url('free/test/' . $ft['id']) ?>" class="free-test-cta">
                                            <i class="fas fa-rocket"></i>Start Free Test
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="no-test-message">
                                <i class="far fa-calendar-times"></i>
                                <h5>No Free Tests Available</h5>
                                <p>Check back soon for new practice tests!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tutoring Section Start -->
        <section class="tutoring-showcase py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <div class="pe-lg-4">
                            <span class="badge bg-primary mb-3" style="font-size: 0.85rem; padding: 0.5rem 1rem;">PERSONALIZED SUPPORT</span>
                            <h2 class="mb-3" style="font-size: 2.25rem; font-weight: 700; color: #1e293b;">Need Extra Help? Get One-on-One NCLEX Tutoring</h2>
                            <p class="mb-4" style="font-size: 1.1rem; color: #64748b; line-height: 1.7;">
                                Work directly with experienced nursing educators who understand your unique learning needs. Our personalized tutoring sessions are designed to boost your confidence and help you master the NCLEX exam.
                            </p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-3 mt-1" style="color: #667eea; font-size: 1.2rem;"></i>
                                    <span style="color: #475569;"><strong>Customized study plans</strong> tailored to your strengths and weaknesses</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-3 mt-1" style="color: #667eea; font-size: 1.2rem;"></i>
                                    <span style="color: #475569;"><strong>Flexible scheduling</strong> that fits your busy lifestyle</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-3 mt-1" style="color: #667eea; font-size: 1.2rem;"></i>
                                    <span style="color: #475569;"><strong>Expert guidance</strong> from experienced NCLEX educators</span>
                                </li>
                            </ul>
                            <div class="d-flex gap-3 flex-wrap">
                                <a href="<?= base_url('tutoring') ?>" class="btn btn-primary btn-md" style="padding: 0.875rem 2rem; font-weight: 600; border-radius: 8px;">
                                    Learn More About Tutoring
                                </a>
                                &nbsp;
                                <a href="https://wa.me/12063504565?text=Hi!%20I'm%20interested%20in%20NCLEX%20tutoring%20services." 
                                   target="_blank"
                                   class="btn btn-success btn-md" style="padding: 0.875rem 2rem; font-weight: 600; border-radius: 8px; background: #25D366; border-color: #25D366;">
                                    <i class="fab fa-whatsapp me-2"></i> Get A Tutor
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="position-relative">
                            <div class="card border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                                <div class="card-body p-4">

                                      <img src="<?= base_url('assets/images/nclexnursingtutoring.webp'); ?>" alt="nursing tutoring help">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Tutoring Section End -->

          <section class="pt-0 pb-60 pt-60" style="padding-top:100px !important; background: white;">
            <div class="container">
                <div class="row">
                     <div class="col-lg-12">
                         <img src="<?= base_url('assets/media/nclexhelp.png'); ?>" alt="nursing nclex study help, revision materials and study banks">
                     </div>
                </div>
             </div>
          </section>

       
 <!-- Course Detail Area Start -->
        <section class="course_detail pt-0 pb-60 pt-60" style="padding-top:100px !important;">
            <div class="container">
                <div class="row">
                     <div class="col-lg-6">
                        <div class="heading mb-16">
                            <h3><span>NCLEX-RN (Registered Nurse Licensure Exam)</span></h3>
                        </div>

                        <div class="tab-content">
                            <div id="overview" class="overview tab-pane active">
                                <p class="mb-24">The NCLEX-RN is a rigorous test that evaluates critical thinking, nursing judgment, and clinical decision-making.
NCLEXPrepCourse prepares you for success through:
                                </p>
 <p class="mb-24">
Realistic NCLEX-RN Simulations: Our practice tests replicate the computer-adaptive testing (CAT) format used in the real NCLEX. Questions adjust to your performance, helping you build confidence and endurance. </p>
                             
                            </div>
                           
                            
                            
                        </div>
                         <div class="categories-section">
  <div class="category-pills">
    <a href="<?= base_url('hesi'); ?>" class="btn btn-primary">Read More</a>
  </div>
</div><br>
                       
                    </div>
                    <div class="col-lg-6">
                        <div class="educate-tilt"
                            data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 2, "speed": 700, "scale": 1 }'>
                            <img style="width: 70%" src="<?= base_url('assets/media/nclexrn.webp'); ?>" alt="Registered Nurse Licensure Exam" class="br-20 mb-24">
                        </div>
                    </div>
                </div>
                
                
            </div>
        </section><br><br>
        <!-- Course Detail Area End -->



         <!-- Course Detail Area Start -->
        <section class="course_detail py-60">
            <div class="container">
                <div class="row">

                   <div class="col-lg-6">
                        <div class="educate-tilt"
                            data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 2, "speed": 700, "scale": 1 }'>
                            <img src="<?= base_url('assets/media/vocationalnurse.webp'); ?>" alt="vocational nurse"  class="br-20 mb-24">

                        </div>
                    </div>
                     <div class="col-lg-6">
                        <div class="heading mb-16">
                            <h3><span>NCLEX-PN (Practical/Vocational Nurse Licensure Exam)</span></h3>
                        </div>

                        <div class="tab-content">
                            <div id="overview" class="overview tab-pane active">
                                <p class="mb-24">
The NCLEX-PN focuses on safe and effective care at the practical nursing level.
NCLEXPrepCourse helps LPN and LVN candidates excel through: </p>
<p class="mb-24">
Tailored PN Practice Tests: Content is customized to the PN scope of practice—delegation, safety, and patient care.</p>
                              
                            </div>
                           
                            
                            
                        </div>
                         <div class="categories-section">
  <div class="category-pills">
    <a href="<?= base_url('hesi'); ?>" class="btn btn-primary">Read More</a>
  </div>
</div><br>
                      
                    </div>
                   
                </div>
                
                
            </div>
        </section>
        <!-- Course Detail Area End -->



         <section class="course_detail py-60">
            <div class="container">
                <div class="row">
                     <div class="col-lg-6">
                        <div class="heading mb-16">
                            <h3><span>Nursing Exit Exams</span></h3>
                        </div>

                        <div class="tab-content">
                            <div id="overview" class="overview tab-pane active">
                                <p class="mb-24">Nursing school exit exams are designed to determine readiness for the NCLEX.
NCLEXPrepCourse helps students prepare effectively by providing:
 </p>
<p class="mb-24">
Comprehensive Review Tests: Simulated exit exams that assess knowledge across all nursing content areas. </p>
                            
                            </div>
                           
                            
                            
                        </div>
                         <div class="categories-section">
  <div class="category-pills">
    <a href="<?= base_url('hesi'); ?>" class="btn btn-primary">Read More</a>
  </div>
</div><br>
                      
                    </div>
                    <div class="col-lg-6">
                        <div class="educate-tilt"
                            data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 2, "speed": 700, "scale": 1 }'>
                            <img src="<?= base_url('assets/media/nursingexitexams.webp'); ?>" alt="nursing exit exams help" class="br-20 mb-24">
                        </div>
                    </div>
                </div>
                
                
            </div>
        </section><br><br>







 <section class="course_detail py-60">
            <div class="container">
                <div class="row">

                   <div class="col-lg-6">
                        <div class="educate-tilt"
                            data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 2, "speed": 700, "scale": 1 }'>
                            <img src="<?= base_url('assets/media/nursingentranceexams.webp'); ?>" alt="nursing entrance exams help"  class="br-20 mb-24">

                        </div>
                    </div>
                     <div class="col-lg-6">
                        <div class="heading mb-16">
                            <h3><span>Nursing Entrance Exams (HESI A2, TEAS, etc.)</span></h3>
                        </div>

                        <div class="tab-content">
                            <div id="overview" class="overview tab-pane active">
                                <p class="mb-24">For aspiring nurses entering school, NCLEXPrepCourse provides tools to excel on entrance exams like HESI A2 or ATI TEAS through:
                                </p>
<p class="mb-24">
Subject-Focused Review: Covers core subjects such as reading comprehension, grammar, vocabulary, math, anatomy, and science. </p>
                              
                            </div>
                           
                            
                            
                        </div>
                         <div class="categories-section">
  <div class="category-pills">
    <a href="<?= base_url('hesi'); ?>" class="btn btn-primary">Read More</a>
  </div>
</div><br>
                    
                    </div>
                   
                </div>
                
                
            </div>
        </section>











         <section class="course_detail py-60">
            <div class="container">
                <div class="row">
                     <div class="col-lg-6">
                        <div class="heading mb-16">
                            <h3><span>HESI & ATI Exam Preparation</span></h3>
                        </div>

                        <div class="tab-content">
                            <div id="overview" class="overview tab-pane active">
                                <p class="mb-24">HESI and ATI exams are key indicators of nursing knowledge and predictors of NCLEX readiness.
                                </p>
<p class="mb-24">                          
  NCLEXPrepCourse supports students preparing for these with:
</p>
                             
                            </div>
                           
                            
                            
                        </div>
                         <div class="categories-section">
  <div class="category-pills">
    <a href="<?= base_url('ati-teas-7'); ?>" class="btn btn-primary">Read More</a>
  </div>
</div><br>
                       
                    </div>
                    <div class="col-lg-6">
                        <div class="educate-tilt"
                            data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 2, "speed": 700, "scale": 1 }'>
                            <img src="<?= base_url('assets/media/hesi.webp'); ?>" alt="hesi exam help" class="br-20 mb-24">
                        </div>
                    </div>
                </div>
                
                
            </div>
        </section>

  <section class="py-60">
      <div class="container">
        <h2>Why NCLEX Prep Course</h2>
        <div class="row row-gap-4">
          <div class="col-xl-3 col-sm-6 wow fadeInUp" data-wow-delay="200ms">
            <div class="feature__card mb-24 mb-xl-0">
              <div class="feature__icon">
                <img width="50px" src="<?= base_url('assets/media/icons/adaptive.png'); ?>" alt="adaptive nclex prep materials">
              </div>
              <div class="feature__content">
                <h5 class="mb-8">Adaptive Learning System</h5>
                <p class="left">Personalized question delivery ensures that your study time targets areas of weakness.</p>
                <img src="<?= base_url('assets/media/shapes/feture-bg-shape.png'); ?>" alt="" class="feature-bg-shape">
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 wow fadeInUp" data-wow-delay="400ms">
            <div class="feature__card mb-24 mb-xl-0">
              <div class="feature__icon">
                <img width="50px" src="<?= base_url('assets/media/icons/qa.png'); ?>" alt="latest updated nclex test banks.">
              </div>
              <div class="feature__content">
                <h5 class="mb-8">Updated Question Banks</h5>
                <p class="left">Content is regularly reviewed and aligned with the latest NCLEX, HESI, and ATI guidelines.</p>
                <img src="<?= base_url('assets/media/shapes/feture-bg-shape.png'); ?>" alt="" class="feature-bg-shape">
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 wow fadeInUp" data-wow-delay="600ms">
            <div class="feature__card mb-24 mb-sm-0">
              <div class="feature__icon">
                <img  width="50px" src="<?= base_url('assets/media/icons/chat.png'); ?>"  alt="user and mobile friendly dashboard for nclex">
              </div>
              <div class="feature__content">
                <h5 class="mb-8">User & Mobile Friendly Dashboard</h5>
                <p class="left">Easy navigation for students to take quizzes, track progress, and review past performances across devices. </p>
                <img src="<?= base_url('assets/media/shapes/feture-bg-shape.png'); ?>" alt="" class="feature-bg-shape">
              </div>
            </div>
          </div>
      
            <div class="col-xl-3 col-sm-6 wow fadeInUp" data-wow-delay="800ms">
            <div class="feature__card">
              <div class="feature__icon">
                <img width="50px" src="<?= base_url('assets/media/icons/supportivelearning.png'); ?>"  alt="NCLEX supportive learning">
              </div>
              <div class="feature__content">
                <h5 class="mb-8">Supportive Learning Environment</h5>
                <p class="left">Offers explanations that teach core concepts, not just test answers.</p>
                <img src="<?= base_url('assets/media/shapes/feture-bg-shape.png'); ?>" alt="" class="feature-bg-shape">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    

 

    
    <!-- Courses Area Start -->
  <section class="testimonials py-60">
      <div class="container">
        <div class="row">
          <div class="col-xl-5">
            <div class="testimonials_text_block">
              <img src="<?= base_url('assets/media/shapes/quote3d.png'); ?>" alt="" class="quote_icon">
              <h6 class="color-primary mb-8">–––– Testimonials</h6>
              <h2 class="mb-16">See Why 12,000+ Nursing Students Trust Our Test Bank and Study Notes</span>
              </h2>
            
              <img src="<?= base_url('assets/media/shapes/vector-2.png'); ?>" alt="nclex test bank reviews" class="vector_hol">
              <img src="<?= base_url('assets/media/shapes/dots-1.png'); ?>" alt="nclex test bank reviews" class="dots_group">
            </div>
          </div>
          <div class="col-xl-7 col-lg-10 offset-xl-0 offset-lg-1">
            <div class="testimonials_slider_1_block">
              <img src="<?= base_url('assets/media/shapes/bg-elements-1.png'); ?>" alt="" class="bg_elements">
              <div class="testimonials_slider">
                <div class="card-block">
                  <div class="testimonial_card">
                    <div class="testimonial_card_img_block">
                      <img src="<?= base_url('assets/media/users/Image.png'); ?>" alt="" class="user_img">
                      <div class="quote_block"></div>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 78 64" fill="none" class="quote_mark">
                        <path
                          d="M55.8684 63.0894C52.6269 63.0894 49.6698 62.606 46.997 61.6392C44.3242 60.6156 42.0495 59.2224 40.1729 57.4595C38.2963 55.6397 36.8177 53.4503 35.7372 50.8913C34.7136 48.3322 34.2018 45.4888 34.2018 42.3611C34.2018 39.1197 34.7705 35.736 35.9078 32.2102C37.1021 28.6845 38.8081 25.1302 41.0259 21.5476C43.2438 17.9649 45.9165 14.4391 49.0443 10.9702C52.2288 7.44441 55.8399 4.06079 59.8775 0.819336L69.6872 8.49646C67.8106 10.43 66.1045 12.2782 64.5691 14.0411C63.0905 15.8039 61.7257 17.5668 60.4746 19.3297C59.2236 21.0926 58.0578 22.9124 56.9773 24.789C55.9537 26.6657 55.0154 28.656 54.1623 30.7601L77.3643 42.3611C77.3643 45.432 76.7672 48.2469 75.573 50.806C74.4356 53.365 72.9002 55.5544 70.9667 57.3742C69.0332 59.1939 66.7585 60.6156 64.1426 61.6392C61.5267 62.606 58.7686 63.0894 55.8684 63.0894ZM22.1666 63.0894C18.9251 63.0894 15.968 62.606 13.2952 61.6392C10.6224 60.6156 8.34773 59.2224 6.4711 57.4595C4.59447 55.6397 3.11591 53.4503 2.03543 50.8913C1.01181 48.3322 0.5 45.4888 0.5 42.3611C0.5 39.1197 1.06868 35.736 2.20603 32.2102C3.40025 28.6845 5.10628 25.1302 7.32411 21.5476C9.54195 17.9649 12.2147 14.4391 15.3424 10.9702C18.527 7.44441 22.1381 4.06079 26.1757 0.819336L35.9854 8.49646C34.1088 10.43 32.4027 12.2782 30.8673 14.0411C29.3887 15.8039 28.0239 17.5668 26.7728 19.3297C25.5217 21.0926 24.356 22.9124 23.2755 24.789C22.2519 26.6657 21.3135 28.656 20.4605 30.7601L43.6625 42.3611C43.6625 45.432 43.0654 48.2469 41.8712 50.806C40.7338 53.365 39.1984 55.5544 37.2649 57.3742C35.3314 59.1939 33.0567 60.6156 30.4408 61.6392C27.8249 62.606 25.0668 63.0894 22.1666 63.0894Z" />
                      </svg>
                    </div>
                    <div class="testimonial_card_content_block">
                      <div class="testimonial">
                        <h4 class="mb-16">Sarah M., NCLEX-RN Graduate</h4>
                        <span class="mb-16"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                        <p class="review_text">NCLEXPrepCourse.org was my ultimate study partner. The realistic NCLEX practice questions and in-depth rationales helped me understand concepts I had struggled with in nursing school. I passed the NCLEX on my first try!</p>
                      </div>
                      <img src="<?= base_url('assets/media/shapes/bg-elements-2.png'); ?>" alt="" class="bottom_shape">
                    </div>
                  </div>
                </div>
                <div class="card-block">
                  <div class="testimonial_card">
                    <div class="testimonial_card_img_block">
                      <img src="<?= base_url('assets/media/users/Image-1.png'); ?>" alt="" class="user_img">
                      <div class="quote_block"></div>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 78 64" fill="none" class="quote_mark">
                        <path
                          d="M55.8684 63.0894C52.6269 63.0894 49.6698 62.606 46.997 61.6392C44.3242 60.6156 42.0495 59.2224 40.1729 57.4595C38.2963 55.6397 36.8177 53.4503 35.7372 50.8913C34.7136 48.3322 34.2018 45.4888 34.2018 42.3611C34.2018 39.1197 34.7705 35.736 35.9078 32.2102C37.1021 28.6845 38.8081 25.1302 41.0259 21.5476C43.2438 17.9649 45.9165 14.4391 49.0443 10.9702C52.2288 7.44441 55.8399 4.06079 59.8775 0.819336L69.6872 8.49646C67.8106 10.43 66.1045 12.2782 64.5691 14.0411C63.0905 15.8039 61.7257 17.5668 60.4746 19.3297C59.2236 21.0926 58.0578 22.9124 56.9773 24.789C55.9537 26.6657 55.0154 28.656 54.1623 30.7601L77.3643 42.3611C77.3643 45.432 76.7672 48.2469 75.573 50.806C74.4356 53.365 72.9002 55.5544 70.9667 57.3742C69.0332 59.1939 66.7585 60.6156 64.1426 61.6392C61.5267 62.606 58.7686 63.0894 55.8684 63.0894ZM22.1666 63.0894C18.9251 63.0894 15.968 62.606 13.2952 61.6392C10.6224 60.6156 8.34773 59.2224 6.4711 57.4595C4.59447 55.6397 3.11591 53.4503 2.03543 50.8913C1.01181 48.3322 0.5 45.4888 0.5 42.3611C0.5 39.1197 1.06868 35.736 2.20603 32.2102C3.40025 28.6845 5.10628 25.1302 7.32411 21.5476C9.54195 17.9649 12.2147 14.4391 15.3424 10.9702C18.527 7.44441 22.1381 4.06079 26.1757 0.819336L35.9854 8.49646C34.1088 10.43 32.4027 12.2782 30.8673 14.0411C29.3887 15.8039 28.0239 17.5668 26.7728 19.3297C25.5217 21.0926 24.356 22.9124 23.2755 24.789C22.2519 26.6657 21.3135 28.656 20.4605 30.7601L43.6625 42.3611C43.6625 45.432 43.0654 48.2469 41.8712 50.806C40.7338 53.365 39.1984 55.5544 37.2649 57.3742C35.3314 59.1939 33.0567 60.6156 30.4408 61.6392C27.8249 62.606 25.0668 63.0894 22.1666 63.0894Z" />
                      </svg>
                    </div>
                    <div class="testimonial_card_content_block">
                      <div class="testimonial">
                        <h4 class="mb-16">James K., NCLEX-PN Student</h4>
                        <span class="mb-16"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                        <p class="review_text">The adaptive learning system targeted my weak areas. With consistent practice and tutor guidance, I felt confident on exam day and passed my PN exam with ease.</p>
                      </div>
                      <img src="<?= base_url('assets/media/shapes/bg-elements-2.png'); ?>" alt="" class="bottom_shape">

                    </div>
                  </div>
                </div>
                <div class="card-block">
                  <div class="testimonial_card">
                    <div class="testimonial_card_img_block">
                      <img src="<?= base_url('assets/media/users/Image.png'); ?>" alt="" class="user_img">
                      <div class="quote_block"></div>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 78 64" fill="none" class="quote_mark">
                        <path
                          d="M55.8684 63.0894C52.6269 63.0894 49.6698 62.606 46.997 61.6392C44.3242 60.6156 42.0495 59.2224 40.1729 57.4595C38.2963 55.6397 36.8177 53.4503 35.7372 50.8913C34.7136 48.3322 34.2018 45.4888 34.2018 42.3611C34.2018 39.1197 34.7705 35.736 35.9078 32.2102C37.1021 28.6845 38.8081 25.1302 41.0259 21.5476C43.2438 17.9649 45.9165 14.4391 49.0443 10.9702C52.2288 7.44441 55.8399 4.06079 59.8775 0.819336L69.6872 8.49646C67.8106 10.43 66.1045 12.2782 64.5691 14.0411C63.0905 15.8039 61.7257 17.5668 60.4746 19.3297C59.2236 21.0926 58.0578 22.9124 56.9773 24.789C55.9537 26.6657 55.0154 28.656 54.1623 30.7601L77.3643 42.3611C77.3643 45.432 76.7672 48.2469 75.573 50.806C74.4356 53.365 72.9002 55.5544 70.9667 57.3742C69.0332 59.1939 66.7585 60.6156 64.1426 61.6392C61.5267 62.606 58.7686 63.0894 55.8684 63.0894ZM22.1666 63.0894C18.9251 63.0894 15.968 62.606 13.2952 61.6392C10.6224 60.6156 8.34773 59.2224 6.4711 57.4595C4.59447 55.6397 3.11591 53.4503 2.03543 50.8913C1.01181 48.3322 0.5 45.4888 0.5 42.3611C0.5 39.1197 1.06868 35.736 2.20603 32.2102C3.40025 28.6845 5.10628 25.1302 7.32411 21.5476C9.54195 17.9649 12.2147 14.4391 15.3424 10.9702C18.527 7.44441 22.1381 4.06079 26.1757 0.819336L35.9854 8.49646C34.1088 10.43 32.4027 12.2782 30.8673 14.0411C29.3887 15.8039 28.0239 17.5668 26.7728 19.3297C25.5217 21.0926 24.356 22.9124 23.2755 24.789C22.2519 26.6657 21.3135 28.656 20.4605 30.7601L43.6625 42.3611C43.6625 45.432 43.0654 48.2469 41.8712 50.806C40.7338 53.365 39.1984 55.5544 37.2649 57.3742C35.3314 59.1939 33.0567 60.6156 30.4408 61.6392C27.8249 62.606 25.0668 63.0894 22.1666 63.0894Z" />
                      </svg>
                    </div>
                    <div class="testimonial_card_content_block">
                      <div class="testimonial">
                        <h4 class="mb-16">Maria L., Nursing Exit Exam</h4>
                        <span class="mb-16"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                        <p class="review_text">The platform’s simulated exit exams mirrored my school’s assessment style. I could track my progress and focus on my weak topics. Thanks to NCLEXPrepCourse.org, I passed my exit exam without stress.</p>
                      </div>
                      <img src="<?= base_url('assets/media/shapes/bg-elements-2.png'); ?>" alt="" class="bottom_shape">

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Courses Area End -->

    <!-- Discount Banner Area Start -->
   
    <!-- Discount Banner Area End -->

   
    <!-- Contact Banner Area Start -->
    <section class="py-60 ">
      <div class="container">
        <div class="contact_banner">
          <h2 class="mb-8 color-white">Talk to a <br><span class="fm-sec">tutor</span></h2>
          <p class="mb-16 color-white">Get NCLEX expert help</p>
          <div class="mx-auto">
            <a href="https://wa.me/12063504565" class="h5 phone_number"> +1 (206) 350-4565</a>
          </div>
          <div class="icons">
            <img src="<?= base_url('assets/media/shapes/dots-1.png'); ?>" alt="ati" class="element-1">
            <img src="<?= base_url('assets/media/shapes/vector-3.png'); ?>" alt="teas" class="element-2">
            <img src="<?= base_url('assets/media/shapes/paint.png'); ?>" alt="nclex" class="element-3">
            <img src="<?= base_url('assets/media/shapes/vector-4.png'); ?>" alt="test banks" class="element-5">
            <img src="<?= base_url('assets/media/shapes/dots-1.png'); ?>" alt="nursing" class="element-4">
            <img src="<?= base_url('assets/media/shapes/tag.png'); ?>" alt="dnp" class="element-6">
            <img src="<?= base_url('assets/media/shapes/errow.png'); ?>" alt="bsn" class="element-7">
            <img src="<?= base_url('assets/media/shapes/circle-lines.png'); ?>" alt="entrance exams" class="element-8">
            <img src="<?= base_url('assets/media/shapes/mic-speaker.png'); ?>" alt="exit exams" class="element-9">
          </div>
        </div>
      </div>
    </section>
    <!-- Contact Banner Area End -->
