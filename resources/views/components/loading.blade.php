<div id="spinner-overlay" class="d-none"
    style="position: fixed; top: 0; left: 0; z-index: 1050; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.5);">
    <span class="loader" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></span>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('status-form');
    const spinner = document.getElementById('spinner-overlay');

    form.addEventListener('submit', function() {
        spinner.classList.remove('d-none');
        spinner.classList.add('d-flex');
    });
});
</script>