<div class="admin-content mock-question-page">
    <style>
        .mock-question-page {
            display: grid;
            gap: 18px;
        }

        .mock-question-toolbar {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: space-between;
        }

        .mock-question-copy {
            color: #64748b;
            margin: 0;
        }

        .mock-back {
            align-items: center;
            background: #fff;
            border: 1px solid rgba(8, 126, 163, .14);
            border-radius: 14px;
            color: #087ea3 !important;
            display: inline-flex;
            gap: 9px;
            min-height: 44px;
            padding: 0 14px;
            font-weight: 900;
        }

        .mock-question-list {
            display: grid;
            gap: 16px;
        }

        .mock-question-card {
            background: rgba(255, 255, 255, .96);
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
            padding: 20px;
        }

        .mock-question-stem {
            color: #142033;
            font-size: 1.05rem;
            font-weight: 850;
            line-height: 1.55;
            margin-bottom: 16px;
        }

        .mock-choice-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        }

        .mock-choice {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
        }

        .mock-choice.correct {
            background: #dcfce7;
            border-color: #86efac;
        }

        .mock-explanation {
            color: #64748b;
            font-size: 13px;
            margin-top: 7px;
        }

        .mock-rationale {
            background: #f8fbff;
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 14px;
            margin-top: 16px;
            padding: 14px;
        }

        .mock-empty {
            background: #fff;
            border: 1px dashed #bae6fd;
            border-radius: 18px;
            padding: 32px;
            text-align: center;
        }

        @media (max-width: 767.98px) {
            .mock-choice-grid {
                grid-template-columns: 1fr;
            }

            .mock-back {
                justify-content: center;
                width: 100%;
            }
        }
    </style>

    <div class="mock-question-toolbar">
        <div>
            <p class="mock-question-copy mb-1"><?= esc($category['name'] ?? 'Mock Questions') ?></p>
            <h2 class="mb-0"><?= esc($subcategory['name'] ?? 'Mock Questions') ?></h2>
        </div>
        <a class="mock-back" href="<?= base_url('client/mock-questions/' . (int) ($category['id'] ?? 0) . '/subcategories') ?>">
            <i class="fas fa-arrow-left"></i>
            Back to Subcategories
        </a>
    </div>

    <?php if (!empty($questions)): ?>
        <div class="mock-question-list">
            <?php foreach ($questions as $index => $question): ?>
                <?php $choices = $choicesByQuestion[(int) $question['id']] ?? []; ?>
                <article class="mock-question-card">
                    <div class="mock-question-stem">
                        <span class="text-muted">Question <?= esc((string) ($index + 1)) ?>.</span>
                        <?= $question['stem'] ?>
                    </div>
                    <?php if (!empty($question['image_path'])): ?>
                        <div class="mb-3">
                            <img src="<?= base_url('client/mock-questions/image/' . (int) $question['id']) ?>" alt="Mock question image" class="img-fluid border rounded" style="max-height: 420px;">
                        </div>
                    <?php endif; ?>
                    <div class="mock-choice-grid">
                        <?php foreach ($choices as $choice): ?>
                            <div class="mock-choice <?= !empty($choice['is_correct']) ? 'correct' : '' ?>">
                                <strong>(<?= esc($choice['label']) ?>)</strong>
                                <?= esc($choice['content']) ?>
                                <?php if (!empty($choice['explanation'])): ?>
                                    <div class="mock-explanation">
                                        <strong><?= !empty($choice['is_correct']) ? 'Correct' : 'Review' ?>:</strong>
                                        <?= esc($choice['explanation']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (!empty($question['rationale'])): ?>
                        <div class="mock-rationale">
                            <strong>Rationale</strong>
                            <div><?= nl2br(esc($question['rationale'])) ?></div>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="mock-empty">
            <h3>No mock questions yet.</h3>
            <p class="text-muted mb-0">This subcategory is ready for mock questions once they are added from the admin panel.</p>
        </div>
    <?php endif; ?>
</div>
