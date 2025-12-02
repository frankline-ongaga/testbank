
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
                  <a href="<?php echo base_url('free/test/5'); ?>" class="educate-btn sec"><span class="educate-btn__curve"></span>Free Questions Today </a>&nbsp; &nbsp;  

                  <a href="<?php echo base_url('register'); ?>" class="btn btn-primary"><span class="educate-btn__curve"></span>Get Started</a>

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
    <section class="course_testbank pt-60 pb-60" style="min-height:450px;">
  <div class="container">
    <?php if (!empty($studyCategories)) : ?>
    <ul class="nav nav-tabs justify-content-center mb-4" id="testbankTabs" role="tablist">
      <?php $isFirst = true; foreach ($studyCategories as $cat) : $tabId = !empty($cat['slug']) ? $cat['slug'] : ('cat' . $cat['id']); ?>
      <li class="nav-item" role="presentation">
        <button class="nav-link <?= ($isFirst ? 'active' : '') ?>" data-bs-toggle="tab" data-bs-target="#<?= esc($tabId) ?>" type="button" role="tab"><?= esc($cat['name']) ?></button>
      </li>
      <?php $isFirst = false; endforeach; ?>
    </ul>

    <div class="tab-content" id="testbankTabContent">
      <?php $isFirstPane = true; foreach ($studyCategories as $cat) : $tabId = !empty($cat['slug']) ? $cat['slug'] : ('cat' . $cat['id']); $subs = $studySubcategoriesByCategoryId[$cat['id']] ?? []; ?>
      <div class="tab-pane fade <?= ($isFirstPane ? 'show active' : '') ?>" id="<?= esc($tabId) ?>" role="tabpanel">
        <div class="row g-4">
          <?php if (!empty($subs)) : foreach ($subs as $sub) : ?>
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
              <div class="card-body d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><?= esc($sub['name']) ?></h5>
                <a href="<?= base_url('client/study/' . $cat['id'] . '/subcategories') ?>" class="btn btn-sm btn-primary">View</a>
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
    <?php endif; ?>

    <?php if (empty($studyCategories)) : ?>
      <div class="text-center text-muted">No categories found yet.</div>
    <?php endif; ?>

          <!-- Add more cards -->
        </div>
      </div>








    </div>
  </div>
</section>

        <!-- Course Detail Area End -->

        <section class="py-60" style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">
            <style>
                .free-section-title {font-size: 2.75rem; font-weight: 900; line-height: 1.2; background: linear-gradient(135deg, #1e40af 0%, #6366f1 50%, #8b5cf6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 1rem;}
                .free-section-subtitle {font-size: 1.15rem; color: #64748b; line-height: 1.6; margin-bottom: 2rem;}
                .free-benefit-item {display: flex; align-items: flex-start; margin-bottom: 1rem; padding: 1rem; background: #ffffff; border-radius: 12px; border-left: 4px solid #2563eb; box-shadow: 0 2px 8px rgba(0,0,0,.04); transition: all .25s ease;}
                .free-benefit-item:hover {box-shadow: 0 4px 16px rgba(0,0,0,.08); transform: translateX(4px);}
                .free-benefit-icon {width: 48px; height: 48px; background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.25rem; flex-shrink: 0; margin-right: 1rem; box-shadow: 0 4px 12px rgba(37,99,235,.3);}
                .free-benefit-text {flex: 1;}
                .free-benefit-text h6 {font-weight: 700; margin-bottom: .25rem; color: #1e293b;}
                .free-benefit-text p {margin: 0; font-size: .9rem; color: #64748b;}
                .free-test-card {position: relative; background: #ffffff; border-radius: 20px; padding: 2rem; box-shadow: 0 10px 40px rgba(0,0,0,.08); transition: all .3s ease; overflow: hidden; border: 2px solid transparent;}
                .free-test-card:before {content: ""; position: absolute; top: 0; left: 0; right: 0; height: 6px; background: linear-gradient(90deg, #2563eb 0%, #3b82f6 50%, #60a5fa 100%);}
                .free-test-card:hover {transform: translateY(-8px); box-shadow: 0 20px 60px rgba(0,0,0,.12); border-color: #2563eb;}
                .free-test-card-header {display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;}
                .free-test-badge {display: inline-block; padding: .5rem 1rem; background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); color: #fff; border-radius: 50px; font-weight: 700; font-size: .85rem; text-transform: uppercase; letter-spacing: .5px; box-shadow: 0 4px 12px rgba(37,99,235,.3);}
                .free-test-title {font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 1rem; line-height: 1.3;}
                .free-test-meta {display: flex; gap: .75rem; flex-wrap: wrap; margin-bottom: 1.5rem;}
                .free-meta-item {display: flex; align-items: center; padding: .5rem 1rem; background: #f1f5f9; border-radius: 12px; font-size: .9rem; color: #475569; font-weight: 600;}
                .free-meta-item i {margin-right: .5rem; color: #6366f1;}
                .free-test-desc {color: #64748b; font-size: .95rem; line-height: 1.6; margin-bottom: 1.5rem;}
                .free-test-cta {display: block; width: 100%; padding: 1rem 2rem; background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); color: #fff; border: none; border-radius: 12px; font-weight: 800; font-size: 1.1rem; text-align: center; text-decoration: none; transition: all .3s ease; box-shadow: 0 6px 20px rgba(37,99,235,.3);}
                .free-test-cta:hover {background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(37,99,235,.4); color: #fff;}
                .free-test-cta i {margin-right: .5rem; animation: pulse 2s ease-in-out infinite;}
                @keyframes pulse { 0%, 100% {transform: scale(1);} 50% {transform: scale(1.1);}}
                .no-test-message {text-align: center; padding: 3rem; background: #f8fafc; border-radius: 16px; border: 2px dashed #cbd5e1;}
                .no-test-message i {font-size: 3rem; color: #94a3b8; margin-bottom: 1rem;}
                .no-test-message h5 {color: #475569; font-weight: 700;}
                .no-test-message p {color: #64748b; margin: 0;}
            </style>
            <div class="container">
                <div class="text-center mb-5">
                    <h3>Take Our Free NCLEX Practice Test</h3>
                    <p class="free-section-subtitle">Experience adaptive testing with detailed rationales — no subscription required</p>
                </div>
                
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="free-benefit-item">
                            <div class="free-benefit-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="free-benefit-text">
                                <h6>NCLEX-Aligned Questions</h6>
                                <p>Curated by nursing experts to match the latest exam standards</p>
                            </div>
                        </div>
                        <div class="free-benefit-item">
                            <div class="free-benefit-icon">
                                <i class="fas fa-sliders-h"></i>
                            </div>
                            <div class="free-benefit-text">
                                <h6>Adaptive Testing</h6>
                                <p>Questions adjust to your performance in real-time</p>
                            </div>
                        </div>
                        <div class="free-benefit-item">
                            <div class="free-benefit-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="free-benefit-text">
                                <h6>Detailed Explanations</h6>
                                <p>Learn from comprehensive rationales for every answer</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <?php if (!empty($freeTests)) : ?>
                            <div class="row g-4">
                                <?php foreach ($freeTests as $ft): ?>
                                    <div class="col-12">
                                        <div class="free-test-card">
                                            <div class="free-test-card-header">
                                                <span class="free-test-badge"><i class="fas fa-gift me-2"></i>100% Free</span>
                                            </div>
                                            <h3 class="free-test-title"><?= esc($ft['title']) ?></h3>
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
                                                Challenge yourself with adaptive questions that adjust to your skill level. Get instant feedback with detailed rationales to strengthen your understanding.
                                            </p>
                                            <a href="<?= base_url('free/test/' . $ft['id']) ?>" class="free-test-cta">
                                                <i class="fas fa-rocket"></i>Start Free Test Now
                                            </a>
                                        </div>
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
                                <a href="https://wa.me/12092609257?text=Hi!%20I'm%20interested%20in%20NCLEX%20tutoring%20services." 
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
    <a href="#" class="btn btn-primary">Read More</a>
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
    <a href="#" class="btn btn-primary">Read More</a>
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
    <a href="#" class="btn btn-primary">Read More</a>
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
    <a href="#" class="btn btn-primary">Read More</a>
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
    <a href="#" class="btn btn-primary">Read More</a>
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
            <a href="https://wa.me/12092609257" class="h5 phone_number"> +1 (209) 260-9257</a>
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
