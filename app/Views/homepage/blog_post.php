<style>
    .page_title_banner .content { flex-wrap: wrap; }
    .page_title_banner .content .title { max-width: 1000px; flex: 1 1 auto; }
    .page_title_banner .title h1 {
        white-space: normal !important;
        overflow-wrap: anywhere;
        word-break: break-word;
        hyphens: auto;
        margin-bottom: 0;
        padding-top: 150px !important;
    }
    .blog-content {
        font-size: 16px;
        line-height: 1.8;
        color: #333;
    }
    .blog-content p {
        margin-bottom: 1.5rem;
    }
    .blog-content h1, .blog-content h2, .blog-content h3, .blog-content h4 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
    .blog-content a {
        color: #3b82f6;
        text-decoration: none;
    }
    .blog-content a:hover {
        text-decoration: underline;
    }
    .blog-meta {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
</style>

<!-- Page Title Banner Start -->
<section class="page_title_banner">
    <div class="container">
        <div class="content">
            <div class="title">
                <h1><?= esc($post['post_title'] ?? 'Blog') ?></h1>
            </div>
          
        </div>
    </div>
</section>
<!-- Page Title Banner End -->

<!-- Blog Content Area Start -->
<section class="py-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="blog-content">
                    <?= $post['post_content'] ?? '' ?>
                </div>
            </div>
        </div>
    </div>
    <?php include 'cta.php'; ?>
</section>
<!-- Blog Content Area End -->
