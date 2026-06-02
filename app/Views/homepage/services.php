<main class="services-page">
  <section class="service-hero">
    <div class="container">
      <nav aria-label="breadcrumb" class="service-crumb">
        <a href="<?= base_url(); ?>">Home</a>
        <span>/</span>
        <span>Services</span>
      </nav>
      <div class="service-hero__grid">
        <div>
          <p class="service-kicker">NCLEX preparation services</p>
          <h1>Study tools built for repeat practice, review, and exam confidence.</h1>
          <p>
            Choose focused practice questions, mock exams, study resources, analytics, and tutoring support
            designed for NCLEX-RN, NCLEX-PN, nursing exit exams, HESI, ATI, and TEAS preparation.
          </p>
          <div class="service-actions">
            <a href="<?= base_url('pricing'); ?>" class="service-btn service-btn--primary">View Pricing</a>
            <a href="<?= base_url('free/test'); ?>" class="service-btn service-btn--secondary">Take A Test</a>
          </div>
        </div>
        <div class="service-panel" aria-label="Service highlights">
          <div>
            <strong>Practice</strong>
            <span>NCLEX-style questions with rationales</span>
          </div>
          <div>
            <strong>Review</strong>
            <span>Notes, PDFs, cheat sheets, and guided study</span>
          </div>
          <div>
            <strong>Track</strong>
            <span>Progress insights and performance analytics</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="service-band">
    <div class="container">
      <div class="service-section-title">
        <h2>What You Can Use</h2>
        <p>Practical tools for students who need more than a pile of questions.</p>
      </div>

      <div class="service-grid">
        <article class="service-card">
          <span>01</span>
          <h3>Question Bank</h3>
          <p>Practice NCLEX-style questions organized for focused review, repetition, and exam-day readiness.</p>
        </article>
        <article class="service-card">
          <span>02</span>
          <h3>Mock Exams</h3>
          <p>Use timed practice tests to build pacing, reduce test anxiety, and identify weak content areas.</p>
        </article>
        <article class="service-card">
          <span>03</span>
          <h3>Study Notes</h3>
          <p>Review structured notes that support core nursing concepts, test strategies, and recall.</p>
        </article>
        <article class="service-card">
          <span>04</span>
          <h3>Study Bank PDFs</h3>
          <p>Access downloadable study-bank documents for offline reading and organized revision.</p>
        </article>
        <article class="service-card">
          <span>05</span>
          <h3>Cheat Sheets</h3>
          <p>Use quick-reference materials for high-yield facts, formulas, decision cues, and reminders.</p>
        </article>
        <article class="service-card">
          <span>06</span>
          <h3>Tutoring Support</h3>
          <p>Get one-on-one guidance when you need help with strategy, weak topics, or accountability.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="service-strip">
    <div class="container">
      <div class="service-strip__inner">
        <div>
          <h2>Ready to start practicing?</h2>
          <p>Begin with a free test or choose a plan that unlocks the full prep experience.</p>
        </div>
        <a href="<?= base_url('register'); ?>" class="service-btn service-btn--primary">Get Started</a>
      </div>
    </div>
  </section>
</main>

<style>
  .services-page {
    color: #0f172a;
    background: #fff;
  }

  .service-hero {
    padding: 132px 0 52px;
    background: linear-gradient(180deg, #f8fafc 0%, #eef7fb 100%);
    border-bottom: 1px solid #e5eef3;
  }

  .service-crumb {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 28px;
    color: #64748b;
    font-size: 15px;
  }

  .service-crumb a {
    color: #0f172a;
  }

  .service-hero__grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: 48px;
    align-items: center;
  }

  .service-kicker {
    margin: 0 0 12px;
    color: #1680a6;
    font-size: 14px;
    font-weight: 800;
    text-transform: uppercase;
  }

  .service-hero h1 {
    max-width: 780px;
    margin: 0 0 18px;
    color: #071327;
    font-size: clamp(34px, 3.8vw, 52px);
    line-height: 1.08;
    font-weight: 800;
  }

  .service-hero p {
    max-width: 760px;
    color: #475569;
    font-size: 18px;
    line-height: 1.7;
  }

  .service-actions,
  .service-strip__inner {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    align-items: center;
  }

  .service-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: 0 22px;
    border-radius: 6px;
    font-weight: 800;
  }

  .service-btn--primary {
    background: #1680a6;
    color: #fff;
  }

  .service-btn--secondary {
    background: #f8c33b;
    color: #071327;
  }

  .service-panel {
    display: grid;
    gap: 16px;
    padding-left: 26px;
    border-left: 4px solid #1680a6;
  }

  .service-panel div {
    padding-bottom: 16px;
    border-bottom: 1px solid #d7e7ee;
  }

  .service-panel div:last-child {
    padding-bottom: 0;
    border-bottom: 0;
  }

  .service-panel strong,
  .service-panel span {
    display: block;
  }

  .service-panel strong {
    margin-bottom: 4px;
    font-size: 22px;
  }

  .service-panel span {
    color: #64748b;
    line-height: 1.55;
  }

  .service-band {
    padding: 58px 0 68px;
  }

  .service-section-title {
    max-width: 720px;
    margin-bottom: 28px;
  }

  .service-section-title h2,
  .service-strip h2 {
    margin: 0 0 8px;
    color: #071327;
    font-size: 34px;
    line-height: 1.15;
  }

  .service-section-title p,
  .service-strip p {
    margin: 0;
    color: #64748b;
    font-size: 17px;
  }

  .service-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
  }

  .service-card {
    min-height: 210px;
    padding: 24px;
    border: 1px solid #dbe7ee;
    border-radius: 8px;
    background: #fff;
  }

  .service-card span {
    color: #1680a6;
    font-weight: 900;
  }

  .service-card h3 {
    margin: 16px 0 10px;
    color: #071327;
    font-size: 22px;
  }

  .service-card p {
    margin: 0;
    color: #64748b;
    line-height: 1.65;
  }

  .service-strip {
    padding: 0 0 70px;
  }

  .service-strip__inner {
    justify-content: space-between;
    padding: 28px 0;
    border-top: 1px solid #dbe7ee;
    border-bottom: 1px solid #dbe7ee;
  }

  @media (max-width: 991px) {
    .service-hero__grid,
    .service-grid {
      grid-template-columns: 1fr;
    }

    .service-panel {
      padding-left: 18px;
    }
  }

  @media (max-width: 575px) {
    .service-hero {
      padding-top: 96px;
    }

    .service-hero h1 {
      font-size: 34px;
    }

    .service-card {
      min-height: auto;
    }
  }
</style>
