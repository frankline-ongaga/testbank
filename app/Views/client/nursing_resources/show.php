<div class="nursing-resource-reader">
    <style>
        .nursing-resource-reader {
            display: grid;
            gap: 18px;
        }

        .reader-content {
            background: rgba(255, 255, 255, .96);
            border: 1px solid rgba(10, 166, 215, .14);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
        }

        .reader-breadcrumb {
            align-items: center;
            color: #64748b;
            display: flex;
            flex-wrap: wrap;
            font-size: 13px;
            font-weight: 800;
            gap: 8px;
        }

        .reader-breadcrumb a {
            align-items: center;
            color: #087ea3 !important;
            display: inline-flex;
            gap: 6px;
            text-decoration: none;
        }

        .reader-breadcrumb span {
            color: #94a3b8;
        }

        .reader-content {
            color: #263241;
            font-size: 1rem;
            line-height: 1.75;
            padding: clamp(20px, 3vw, 34px);
        }

        .reader-content h1,
        .reader-content h2,
        .reader-content h3,
        .reader-content h4 {
            color: #142033;
            font-weight: 900;
            line-height: 1.25;
            margin: 1.35em 0 .55em;
        }

        .reader-content p,
        .reader-content ul,
        .reader-content ol {
            margin-bottom: 1rem;
        }

        .reader-content img {
            border-radius: 14px;
            height: auto;
            max-width: 100%;
        }

        .reader-content a {
            color: #087ea3;
            font-weight: 800;
        }

    </style>

    <nav class="reader-breadcrumb" aria-label="Breadcrumb">
        <a href="<?= base_url('client/' . $resource['path']) ?>">
            <i class="fas fa-arrow-left"></i>
            <?= esc($resource['title']) ?>
        </a>
        <span>/</span>
        <span><?= esc($post['post_title'] ?? 'Resource') ?></span>
    </nav>

    <article class="reader-content">
        <?= $post['content'] ?>
    </article>
</div>
