<script>
(() => {
    const input = document.getElementById('mock_question_image');
    const wrap = document.getElementById('mock_question_image_preview_wrap');
    const img = document.getElementById('mock_question_image_preview');
    if (!input || !wrap || !img) return;

    input.addEventListener('change', () => {
        const file = input.files && input.files[0];
        if (!file || !file.type || !file.type.startsWith('image/')) {
            wrap.classList.add('d-none');
            img.src = '';
            return;
        }

        img.src = URL.createObjectURL(file);
        wrap.classList.remove('d-none');
    });
})();
</script>
