<?= view('admin/partials/header', ['title' => $title]) ?>
    <div class="admin-page-header">
        <div class="admin-page-title">
            <h1><?= $title ?></h1>
            <p>Create a new test for the system</p>
        </div>
    </div>
    <div class="admin-content" style="max-width:900px;">
    <h3 class="mb-3">Create Test</h3>

    <form method="post" action="/tests">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required />
            </div>
            <div class="col-md-3">
                <label class="form-label">Mode</label>
                <select name="mode" class="form-select">
                    <option value="practice">Practice</option>
                    <option value="evaluation">Evaluation</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Time limit (min)</label>
                <input type="number" name="time_limit" class="form-control" min="0" />
            </div>
        </div>
        <div class="form-check my-3">
            <input type="checkbox" class="form-check-input" name="is_adaptive" id="is_adaptive" />
            <label class="form-check-label" for="is_adaptive">Adaptive</label>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Questions (IDs comma-separated)</label>
            <input type="text" class="form-control" name="question_ids_raw" placeholder="e.g., 1,2,3" oninput="syncIds(this.value)" />
            <div id="idsWrap"></div>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary" type="submit">Save</button>
            <a href="/tests" class="btn btn-secondary">Cancel</a>
        </div>
        <script>
            function syncIds(value){
                const wrap = document.getElementById('idsWrap');
                wrap.innerHTML = '';
                const ids = value.split(',').map(v=>parseInt(v.trim(),10)).filter(Boolean);
                ids.forEach(id=>{
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'question_ids[]';
                    input.value = id;
                    wrap.appendChild(input);
                });
            }
        </script>
    </form>
    </div>
<?= view('admin/partials/footer') ?>


