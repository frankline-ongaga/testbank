<div class="nursing-resource-reader">
    <style>
        .nursing-resource-reader {
            display: grid;
            gap: 18px;
        }

        .reader-header,
        .reader-content {
            background: rgba(255, 255, 255, .96);
            border: 1px solid rgba(10, 166, 215, .14);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
        }

        .reader-header {
            display: grid;
            gap: 16px;
            grid-template-columns: minmax(0, 1fr) auto;
            padding: 24px;
        }

        .reader-kicker {
            color: #087ea3;
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .reader-title {
            color: #142033;
            font-size: clamp(1.45rem, 2.3vw, 2.15rem);
            font-weight: 950;
            line-height: 1.18;
            margin: 0;
            overflow-wrap: anywhere;
        }

        .reader-back {
            align-items: center;
            border: 1px solid rgba(10, 166, 215, .24);
            border-radius: 999px;
            color: #087ea3 !important;
            display: inline-flex;
            font-weight: 900;
            gap: 8px;
            justify-content: center;
            min-height: 44px;
            padding: 0 16px;
            text-decoration: none;
            white-space: nowrap;
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

        @media (max-width: 767.98px) {
            .reader-header {
                grid-template-columns: 1fr;
            }

            .reader-back {
                width: 100%;
            }
        }
    </style>

    <section class="reader-header">
        <div>
            <span class="reader-kicker"><?= esc($resource['title']) ?></span>
            <h1 class="reader-title"><?= esc($post['post_title']) ?></h1>
        </div>
        <a class="reader-back" href="<?= base_url('client/' . $resource['path']) ?>">
            <i class="fas fa-arrow-left"></i>
            Back
        </a>
    </section>

    <article class="reader-content">
        <?= $post['content'] ?>
    </article>
</div>
