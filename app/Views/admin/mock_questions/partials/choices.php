<div class="mb-3">
    <label class="form-label">Choices</label>
    <div id="choices">
        <?php $choices = !empty($choices) ? $choices : array_fill(0, 4, null); ?>
        <?php foreach ($choices as $idx => $choice): ?>
            <?php
                $label = is_array($choice) ? ($choice['label'] ?? chr(65 + $idx)) : chr(65 + $idx);
                $content = is_array($choice) ? ($choice['content'] ?? '') : '';
                $isCorrect = is_array($choice) && !empty($choice['is_correct']);
                $explanation = is_array($choice) ? ($choice['explanation'] ?? '') : '';
            ?>
            <div class="border rounded p-3 mb-2">
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <input type="text" name="labels[]" value="<?= esc($label) ?>" class="form-control text-center" style="width:60px">
                    </div>
                    <div class="col">
                        <input type="text" name="contents[]" value="<?= esc($content) ?>" class="form-control" placeholder="Answer text">
                    </div>
                    <div class="col-auto">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="correct[<?= (int) $idx ?>]" <?= $isCorrect ? 'checked' : '' ?>>
                            <span class="form-check-label">Correct</span>
                        </label>
                    </div>
                    <div class="col-12 mt-2">
                        <input type="text" name="explanations[]" value="<?= esc($explanation) ?>" class="form-control" placeholder="Explanation for this choice">
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" onclick="addChoice()" class="btn btn-outline-secondary btn-sm">Add Choice</button>
</div>

<script>
function addChoice() {
    const idx = document.querySelectorAll('#choices > .border').length;
    const label = String.fromCharCode(65 + idx);
    const tpl = `
        <div class="border rounded p-3 mb-2">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <input type="text" name="labels[]" value="${label}" class="form-control text-center" style="width:60px">
                </div>
                <div class="col">
                    <input type="text" name="contents[]" class="form-control" placeholder="Answer text">
                </div>
                <div class="col-auto">
                    <label class="form-check">
                        <input class="form-check-input" type="checkbox" name="correct[${idx}]">
                        <span class="form-check-label">Correct</span>
                    </label>
                </div>
                <div class="col-12 mt-2">
                    <input type="text" name="explanations[]" class="form-control" placeholder="Explanation for this choice">
                </div>
            </div>
        </div>`;
    document.getElementById('choices').insertAdjacentHTML('beforeend', tpl);
}
</script>
