<?php
    $questions = $questions ?? [];
    $choicesByQuestion = $choicesByQuestion ?? [];
    $questionPayload = [];

    foreach ($questions as $question) {
        $choices = $choicesByQuestion[(int) $question['id']] ?? [];
        $choicePayload = [];
        $correctLabels = [];
        $choiceExplanations = [];

        foreach ($choices as $choice) {
            $label = trim((string) ($choice['label'] ?? ''));
            $isCorrect = !empty($choice['is_correct']);
            if ($isCorrect && $label !== '') {
                $correctLabels[] = $label;
            }
            if (!empty($choice['explanation'])) {
                $choiceExplanations[] = $label . ': ' . trim((string) $choice['explanation']);
            }
            $choicePayload[] = [
                'label' => $label,
                'content' => (string) ($choice['content'] ?? ''),
                'isCorrect' => $isCorrect,
                'explanation' => (string) ($choice['explanation'] ?? ''),
            ];
        }

        $questionPayload[] = [
            'id' => (int) $question['id'],
            'stem' => (string) ($question['stem'] ?? ''),
            'imageUrl' => !empty($question['image_path']) ? base_url('client/mock-questions/image/' . (int) $question['id']) : '',
            'choices' => $choicePayload,
            'correctLabels' => $correctLabels,
            'rationale' => trim((string) ($question['rationale'] ?? '')),
            'choiceExplanations' => $choiceExplanations,
        ];
    }
?>

<div class="admin-content mock-test-runner">
    <style>
        .mock-test-runner {
            display: grid;
            gap: 22px;
        }

        .mock-test-hero {
            align-items: end;
            background:
                linear-gradient(135deg, rgba(10, 166, 215, .14), rgba(255, 255, 255, .94)),
                #fff;
            border: 1px solid rgba(10, 166, 215, .16);
            border-radius: 20px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
            display: grid;
            gap: 18px;
            grid-template-columns: minmax(0, 1fr) auto;
            padding: 24px;
        }

        .mock-test-eyebrow {
            color: #087ea3;
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .mock-test-hero h1 {
            color: #142033;
            font-size: clamp(1.7rem, 2.4vw, 2.45rem);
            font-weight: 950;
            line-height: 1.1;
            margin: 0;
        }

        .mock-test-copy {
            color: #516074;
            line-height: 1.65;
            margin: 10px 0 0;
            max-width: 760px;
        }

        .mock-back {
            align-items: center;
            background: #fff;
            border: 1px solid rgba(8, 126, 163, .14);
            border-radius: 999px;
            color: #087ea3 !important;
            display: inline-flex;
            gap: 9px;
            min-height: 44px;
            padding: 0 16px;
            font-weight: 900;
            white-space: nowrap;
        }

        .mock-room {
            display: grid;
            gap: 20px;
            grid-template-columns: 300px minmax(0, 1fr);
        }

        .mock-sidebar,
        .mock-question-card,
        .mock-results,
        .mock-empty {
            background: rgba(255, 255, 255, .96);
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
        }

        .mock-sidebar {
            align-self: start;
            padding: 18px;
            position: sticky;
            top: 18px;
        }

        .mock-meter span,
        .mock-note strong {
            color: #142033;
            display: block;
            font-weight: 900;
        }

        .mock-meter-bar {
            background: #edf2f7;
            border-radius: 999px;
            height: 10px;
            margin-top: 10px;
            overflow: hidden;
        }

        .mock-meter-bar i {
            background: #0aa6d7;
            border-radius: inherit;
            display: block;
            height: 100%;
            transition: width .25s ease;
            width: 0;
        }

        .mock-question-nav {
            display: grid;
            gap: 9px;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            margin-top: 22px;
        }

        .mock-nav-button {
            background: #fff;
            border: 1px solid #dfe7ef;
            border-radius: 10px;
            color: #273044;
            font-weight: 900;
            min-height: 42px;
        }

        .mock-nav-button.active {
            background: #142033;
            border-color: #142033;
            color: #fff;
        }

        .mock-nav-button.answered {
            border-color: rgba(10, 166, 215, .45);
            box-shadow: inset 0 -4px 0 rgba(10, 166, 215, .55);
        }

        .mock-nav-button.checked {
            background: rgba(10, 166, 215, .1);
            border-color: rgba(10, 166, 215, .55);
            color: #087ea3;
        }

        .mock-nav-button.marked {
            border-color: rgba(245, 158, 11, .48);
            box-shadow: inset 0 -4px 0 rgba(245, 158, 11, .68);
        }

        .mock-note {
            background: #f8fbff;
            border-radius: 14px;
            margin-top: 22px;
            padding: 16px;
        }

        .mock-note span {
            color: #64748b;
            display: block;
            font-size: 13px;
            line-height: 1.55;
            margin-top: 8px;
        }

        .mock-stage {
            display: grid;
            gap: 18px;
            min-width: 0;
        }

        .mock-question-card {
            min-height: 500px;
            padding: 30px;
        }

        .mock-question-meta {
            align-items: center;
            display: flex;
            gap: 10px;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .mock-question-meta span,
        .mock-question-meta small {
            border-radius: 999px;
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            line-height: 1;
            min-height: 30px;
            padding: 8px 12px;
            text-transform: uppercase;
        }

        .mock-question-meta span {
            background: rgba(10, 166, 215, .11);
            color: #087ea3;
        }

        .mock-question-meta small {
            background: rgba(245, 158, 11, .14);
            color: #b45309;
        }

        .mock-question-text {
            color: #142033;
            font-size: clamp(1.2rem, 1.9vw, 1.65rem);
            font-weight: 850;
            line-height: 1.45;
            margin-bottom: 20px;
            overflow-wrap: anywhere;
        }

        .mock-question-text p:last-child {
            margin-bottom: 0;
        }

        .mock-question-image {
            margin-bottom: 20px;
        }

        .mock-question-image img {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            max-height: 420px;
            max-width: 100%;
        }

        .mock-choice-list {
            display: grid;
            gap: 12px;
        }

        .mock-choice {
            align-items: center;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            color: #273044;
            display: grid;
            gap: 14px;
            grid-template-columns: 44px 1fr;
            padding: 16px;
            text-align: left;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
            width: 100%;
        }

        .mock-choice:hover {
            border-color: rgba(10, 166, 215, .46);
            box-shadow: 0 12px 28px rgba(15, 23, 42, .06);
            transform: translateY(-1px);
        }

        .mock-choice.selected {
            border-color: rgba(10, 166, 215, .72);
            border-width: 3px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, .08);
        }

        .mock-choice strong {
            align-items: center;
            background: #0aa6d7;
            border-radius: 50%;
            color: #fff;
            display: inline-flex;
            height: 40px;
            justify-content: center;
            width: 40px;
        }

        .mock-choice span {
            color: #334155;
            font-size: 15px;
            font-weight: 750;
            line-height: 1.5;
        }

        .mock-choice.correct {
            background: rgba(10, 166, 215, .08);
            border-color: rgba(10, 166, 215, .68);
        }

        .mock-choice.incorrect {
            background: rgba(245, 158, 11, .1);
            border-color: rgba(245, 158, 11, .62);
        }

        .mock-choice.incorrect strong {
            background: #f59e0b;
        }

        .mock-feedback {
            background: #f8fbff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            margin-top: 20px;
            padding: 18px;
        }

        .mock-feedback:empty {
            display: none;
        }

        .mock-feedback.is-correct {
            background: rgba(10, 166, 215, .09);
            border-color: rgba(10, 166, 215, .38);
        }

        .mock-feedback.is-incorrect {
            background: rgba(245, 158, 11, .1);
            border-color: rgba(245, 158, 11, .36);
        }

        .mock-feedback strong {
            color: #142033;
            display: block;
            font-size: 18px;
        }

        .mock-feedback small {
            color: #64748b;
            display: block;
            font-weight: 900;
            margin-top: 6px;
        }

        .mock-feedback p {
            color: #475569;
            line-height: 1.65;
            margin: 12px 0 0;
        }

        .mock-feedback p strong {
            color: #142033;
            display: block;
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .mock-feedback p.mock-feedback-incorrect {
            background: rgba(255, 255, 255, .52);
            border-left: 4px solid #f59e0b;
            border-radius: 10px;
            padding: 10px 12px;
        }

        .mock-actions {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(5, minmax(0, 1fr));
        }

        .mock-actions .btn {
            align-items: center;
            border-radius: 999px;
            display: inline-flex;
            font-weight: 900;
            justify-content: center;
            min-height: 46px;
        }

        .mock-check-btn {
            background: #142033 !important;
            border-color: #142033 !important;
            color: #fff !important;
        }

        .mock-submit-btn {
            background: #f59e0b !important;
            border-color: #f59e0b !important;
            color: #142033 !important;
        }

        .mock-results {
            padding: 24px;
        }

        .mock-score {
            background: #142033;
            border-radius: 16px;
            color: #fff;
            padding: 24px;
        }

        .mock-score span {
            color: rgba(255, 255, 255, .76);
            display: block;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .mock-score strong {
            color: #fff;
            display: block;
            font-size: 48px;
            line-height: 1;
            margin-top: 8px;
        }

        .mock-score p {
            color: rgba(255, 255, 255, .82);
            margin: 12px 0 0;
        }

        .mock-review-list {
            display: grid;
            gap: 14px;
            margin-top: 18px;
        }

        .mock-review-item {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 16px;
        }

        .mock-review-item.is-correct {
            border-left: 5px solid #0aa6d7;
        }

        .mock-review-item.is-incorrect {
            border-left: 5px solid #f59e0b;
        }

        .mock-review-item span {
            color: #087ea3;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .mock-review-item h3 {
            color: #142033;
            font-size: 1rem;
            line-height: 1.45;
            margin: 8px 0;
        }

        .mock-review-item p {
            color: #64748b;
            margin: 6px 0 0;
        }

        .mock-empty {
            padding: 34px 24px;
            text-align: center;
        }

        .mock-empty h3 {
            color: #142033;
            font-weight: 900;
            margin: 0 0 8px;
        }

        @media (max-width: 991.98px) {
            .mock-test-hero,
            .mock-room {
                grid-template-columns: 1fr;
            }

            .mock-sidebar {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .mock-actions {
                grid-template-columns: 1fr;
            }

            .mock-question-card {
                padding: 20px;
            }

            .mock-choice {
                grid-template-columns: 38px 1fr;
            }

            .mock-choice strong {
                height: 36px;
                width: 36px;
            }

            .mock-back {
                justify-content: center;
                width: 100%;
            }
        }
    </style>

    <section class="mock-test-hero">
        <div>
            <span class="mock-test-eyebrow"><?= esc($category['name'] ?? 'Mock Tests') ?></span>
            <h1><?= esc($subcategory['name'] ?? 'Mock Tests') ?></h1>
            <p class="mock-test-copy">Work through this mock test one question at a time. Select an answer, check it immediately, then use the rationale before moving forward.</p>
        </div>
        <a class="mock-back" href="<?= base_url('client/mock-questions/' . (int) ($category['id'] ?? 0) . '/subcategories') ?>">
            <i class="fas fa-arrow-left"></i>
            Back to Subcategories
        </a>
    </section>

    <?php if (!empty($questionPayload)): ?>
        <section class="mock-room">
            <aside class="mock-sidebar">
                <div class="mock-meter">
                    <span id="mockProgressText">Question 1 of <?= esc((string) count($questionPayload)) ?></span>
                    <div class="mock-meter-bar"><i id="mockProgressBar"></i></div>
                </div>
                <div class="mock-question-nav" id="mockQuestionNav" aria-label="Mock question navigation"></div>
                <div class="mock-note">
                    <strong>Answer rhythm</strong>
                    <span>Choose your answer, check it, review the explanation, then continue to the next question.</span>
                </div>
            </aside>

            <div class="mock-stage">
                <article class="mock-question-card">
                    <div class="mock-question-meta">
                        <span id="mockQuestionNumber"></span>
                        <small id="mockQuestionType"></small>
                    </div>
                    <div class="mock-question-text" id="mockQuestionText"></div>
                    <div class="mock-question-image" id="mockQuestionImageWrap" hidden>
                        <img id="mockQuestionImage" src="" alt="Mock question image">
                    </div>
                    <div class="mock-choice-list" id="mockChoiceList"></div>
                    <div class="mock-feedback" id="mockFeedback"></div>
                </article>

                <div class="mock-actions">
                    <button type="button" class="btn btn-outline-secondary" id="mockPrev">Previous</button>
                    <button type="button" class="btn btn-outline-secondary" id="mockMark">Mark</button>
                    <button type="button" class="btn mock-check-btn" id="mockCheck">Check Answer</button>
                    <button type="button" class="btn btn-primary" id="mockNext">Next Question</button>
                    <button type="button" class="btn mock-submit-btn" id="mockSubmit">Submit Test</button>
                </div>

                <section class="mock-results" id="mockResults" hidden>
                    <div class="mock-score">
                        <span>Your Score</span>
                        <strong id="mockScoreText">0%</strong>
                        <p id="mockScoreSummary"></p>
                    </div>
                    <div class="mock-review-list" id="mockReviewList"></div>
                </section>
            </div>
        </section>
    <?php else: ?>
        <div class="mock-empty">
            <h3>No mock tests yet.</h3>
            <p class="text-muted mb-0">This subcategory is ready for mock tests once they are added from the admin panel.</p>
        </div>
    <?php endif; ?>
</div>

<?php if (!empty($questionPayload)): ?>
    <script>
        window.NclexMockQuestions = <?= json_encode($questionPayload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    </script>
    <script>
        (function () {
            const questions = Array.isArray(window.NclexMockQuestions) ? window.NclexMockQuestions : [];
            if (!questions.length) {
                return;
            }

            const state = {
                current: 0,
                answers: {},
                checked: new Set(),
                marked: new Set(),
                submitted: false
            };

            const progressText = document.getElementById('mockProgressText');
            const progressBar = document.getElementById('mockProgressBar');
            const nav = document.getElementById('mockQuestionNav');
            const numberEl = document.getElementById('mockQuestionNumber');
            const typeEl = document.getElementById('mockQuestionType');
            const questionText = document.getElementById('mockQuestionText');
            const imageWrap = document.getElementById('mockQuestionImageWrap');
            const image = document.getElementById('mockQuestionImage');
            const choiceList = document.getElementById('mockChoiceList');
            const feedback = document.getElementById('mockFeedback');
            const prev = document.getElementById('mockPrev');
            const next = document.getElementById('mockNext');
            const mark = document.getElementById('mockMark');
            const check = document.getElementById('mockCheck');
            const submit = document.getElementById('mockSubmit');
            const results = document.getElementById('mockResults');
            const scoreText = document.getElementById('mockScoreText');
            const scoreSummary = document.getElementById('mockScoreSummary');
            const reviewList = document.getElementById('mockReviewList');

            function selectedLabels(index) {
                return Array.isArray(state.answers[index]) ? state.answers[index] : [];
            }

            function correctLabels(question) {
                return Array.isArray(question.correctLabels) ? question.correctLabels : [];
            }

            function normalizeLabels(labels) {
                return labels.map(String).sort().join('|');
            }

            function isCorrectAnswer(question, labels) {
                return labels.length > 0 && normalizeLabels(labels) === normalizeLabels(correctLabels(question));
            }

            function explanationText(question) {
                return feedbackSegments(question).map(function(segment) {
                    return segment.label + ': ' + segment.text;
                }).join('\n\n');
            }

            function feedbackSegments(question) {
                const segments = [];
                const parsedIncorrectLabels = new Set();
                const markerPattern = /(Answer:|Rationale:|[A-Z]:\s*Why incorrect:)/g;
                const rationale = String(question.rationale || '').trim();
                const matches = [];
                let match;

                while ((match = markerPattern.exec(rationale)) !== null) {
                    matches.push({ marker: match[0], index: match.index });
                }

                if (matches.length) {
                    matches.forEach(function(item, index) {
                        const start = item.index + item.marker.length;
                        const end = matches[index + 1] ? matches[index + 1].index : rationale.length;
                        const text = rationale.slice(start, end).trim();
                        if (!text) {
                            return;
                        }

                        const marker = item.marker.replace(/\s+/g, ' ').trim();
                        if (marker === 'Answer:') {
                            return;
                        }

                        if (/^[A-Z]: Why incorrect:$/.test(marker)) {
                            const label = marker.charAt(0);
                            parsedIncorrectLabels.add(label);
                            segments.push({
                                label: label + ': Why incorrect',
                                text: text,
                                incorrect: true
                            });
                            return;
                        }

                        segments.push({
                            label: 'Rationale',
                            text: text,
                            incorrect: false
                        });
                    });
                } else if (rationale) {
                    segments.push({
                        label: 'Rationale',
                        text: rationale,
                        incorrect: false
                    });
                }

                (question.choices || []).forEach(function(choice) {
                    const label = String(choice.label || '');
                    const explanation = String(choice.explanation || '').trim();
                    if (!choice.isCorrect && explanation && !parsedIncorrectLabels.has(label)) {
                        segments.push({
                            label: label + ': Why incorrect',
                            text: explanation,
                            incorrect: true
                        });
                    }
                });

                return segments;
            }

            function appendFeedbackParagraph(label, text, isIncorrect) {
                const paragraph = document.createElement('p');
                if (isIncorrect) {
                    paragraph.classList.add('mock-feedback-incorrect');
                }

                const heading = document.createElement('strong');
                heading.textContent = label;
                const copy = document.createElement('span');
                copy.textContent = text;

                paragraph.appendChild(heading);
                paragraph.appendChild(copy);
                feedback.appendChild(paragraph);
            }

            function renderNav() {
                nav.innerHTML = '';
                questions.forEach(function (_, index) {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.textContent = String(index + 1);
                    button.className = 'mock-nav-button';
                    if (index === state.current) button.classList.add('active');
                    if (selectedLabels(index).length) button.classList.add('answered');
                    if (state.checked.has(index)) button.classList.add('checked');
                    if (state.marked.has(index)) button.classList.add('marked');
                    button.addEventListener('click', function () {
                        state.current = index;
                        renderQuestion();
                    });
                    nav.appendChild(button);
                });
            }

            function renderFeedback(question, labels) {
                feedback.innerHTML = '';
                feedback.className = 'mock-feedback';
                if (!state.submitted && !state.checked.has(state.current)) {
                    return;
                }

                const isCorrect = isCorrectAnswer(question, labels);
                feedback.classList.add(isCorrect ? 'is-correct' : 'is-incorrect');

                const title = document.createElement('strong');
                title.textContent = isCorrect ? 'Correct answer' : 'Not quite yet';

                feedback.appendChild(title);
                const correctChoices = (question.choices || []).filter(function(choice) {
                    return choice.isCorrect;
                });
                const answerText = correctChoices.length
                    ? correctChoices.map(function(choice) {
                        return choice.label + '. ' + choice.content;
                    }).join(' ')
                    : correctLabels(question).join(', ');

                appendFeedbackParagraph('Answer', answerText, false);

                const segments = feedbackSegments(question);
                if (segments.length) {
                    segments.forEach(function(segment) {
                        appendFeedbackParagraph(segment.label, segment.text, segment.incorrect);
                    });
                } else {
                    appendFeedbackParagraph('Rationale', 'Review the correct answer before moving to the next question.', false);
                }
            }

            function renderQuestion() {
                const question = questions[state.current];
                const labels = selectedLabels(state.current);
                const checked = state.checked.has(state.current) || state.submitted;
                const multiple = correctLabels(question).length > 1;

                numberEl.textContent = 'Question ' + (state.current + 1);
                typeEl.textContent = multiple ? 'Select all that apply' : 'Single best answer';
                questionText.innerHTML = question.stem || '';

                if (question.imageUrl) {
                    image.src = question.imageUrl;
                    imageWrap.hidden = false;
                } else {
                    image.removeAttribute('src');
                    imageWrap.hidden = true;
                }

                choiceList.innerHTML = '';
                (question.choices || []).forEach(function (choice) {
                    const label = String(choice.label || '');
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'mock-choice';
                    button.dataset.choice = label;

                    const key = document.createElement('strong');
                    key.textContent = label;
                    const text = document.createElement('span');
                    text.textContent = choice.content || '';

                    button.appendChild(key);
                    button.appendChild(text);

                    if (labels.includes(label)) button.classList.add('selected');
                    if (checked && correctLabels(question).includes(label)) button.classList.add('correct');
                    if (checked && labels.includes(label) && !correctLabels(question).includes(label)) button.classList.add('incorrect');

                    button.addEventListener('click', function () {
                        if (state.submitted) return;

                        if (multiple) {
                            const nextLabels = selectedLabels(state.current).slice();
                            const position = nextLabels.indexOf(label);
                            if (position >= 0) {
                                nextLabels.splice(position, 1);
                            } else {
                                nextLabels.push(label);
                            }
                            state.answers[state.current] = nextLabels;
                        } else {
                            state.answers[state.current] = [label];
                        }

                        state.checked.delete(state.current);
                        renderQuestion();
                    });

                    choiceList.appendChild(button);
                });

                renderFeedback(question, labels);

                progressText.textContent = 'Question ' + (state.current + 1) + ' of ' + questions.length;
                progressBar.style.width = (((state.current + 1) / questions.length) * 100) + '%';
                prev.disabled = state.current === 0;
                next.textContent = state.current === questions.length - 1 ? 'Review Answers' : 'Next Question';
                mark.textContent = state.marked.has(state.current) ? 'Marked' : 'Mark';
                check.disabled = state.submitted || !labels.length;
                check.textContent = state.checked.has(state.current) ? 'Checked' : 'Check Answer';
                renderNav();
            }

            function finishTest() {
                state.submitted = true;
                let correct = 0;
                reviewList.innerHTML = '';

                questions.forEach(function (question, index) {
                    const labels = selectedLabels(index);
                    const isCorrect = isCorrectAnswer(question, labels);
                    if (isCorrect) correct += 1;

                    const item = document.createElement('article');
                    item.className = 'mock-review-item ' + (isCorrect ? 'is-correct' : 'is-incorrect');
                    const label = document.createElement('span');
                    label.textContent = 'Question ' + (index + 1);
                    const title = document.createElement('h3');
                    title.innerHTML = question.stem || '';
                    const answerLine = document.createElement('p');
                    answerLine.textContent = 'Your answer: ' + (labels.length ? labels.join(', ') : 'No answer') + ' | Correct answer: ' + correctLabels(question).join(', ');
                    const explanation = document.createElement('p');
                    explanation.textContent = explanationText(question);

                    item.appendChild(label);
                    item.appendChild(title);
                    item.appendChild(answerLine);
                    if (explanation.textContent) {
                        item.appendChild(explanation);
                    }
                    reviewList.appendChild(item);
                });

                const percent = Math.round((correct / questions.length) * 100);
                scoreText.textContent = percent + '%';
                scoreSummary.textContent = correct + ' of ' + questions.length + ' correct. Review the answers, then retake another topic from the mock test library.';
                results.hidden = false;
                submit.disabled = true;
                renderQuestion();
                results.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            prev.addEventListener('click', function () {
                state.current = Math.max(0, state.current - 1);
                renderQuestion();
            });

            next.addEventListener('click', function () {
                if (state.current === questions.length - 1) {
                    document.querySelector('.mock-sidebar').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    return;
                }
                state.current = Math.min(questions.length - 1, state.current + 1);
                renderQuestion();
            });

            mark.addEventListener('click', function () {
                if (state.marked.has(state.current)) {
                    state.marked.delete(state.current);
                } else {
                    state.marked.add(state.current);
                }
                renderQuestion();
            });

            check.addEventListener('click', function () {
                if (!selectedLabels(state.current).length || state.submitted) {
                    return;
                }
                state.checked.add(state.current);
                renderQuestion();
            });

            submit.addEventListener('click', finishTest);

            renderQuestion();
        })();
    </script>
<?php endif; ?>
