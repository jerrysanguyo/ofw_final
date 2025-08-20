@if (session('success'))
<div class="alert alert-success alert-dismissible fade show position-fixed shadow text-center" role="alert"
    style="z-index: 1055; top: 1rem; left: 50%; transform: translateX(-50%); width: 100%; max-width: 400px;">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="close d-flex align-items-center justify-content-center" data-dismiss="alert"
        aria-label="Close" style="position: absolute; top: 0.25rem; right: 0.75rem; font-size: 1.25rem;">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('failed'))
<div class="alert alert-danger alert-dismissible fade show position-fixed shadow text-center" role="alert"
    style="z-index: 1055; top: 1rem; left: 50%; transform: translateX(-50%); width: 100%; max-width: 400px;">
    <strong>{{ session('failed') }}</strong>
    <button type="button" class="close d-flex align-items-center justify-content-center" data-dismiss="alert"
        aria-label="Close" style="position: absolute; top: 0.25rem; right: 0.75rem; font-size: 1.25rem;">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@foreach ($errors->all() as $index => $error)
<div class="alert alert-danger alert-dismissible fade show position-fixed shadow text-center" role="alert"
    style="z-index: 1055; top: calc(1rem + {{ $index * 4 }}rem); left: 50%; transform: translateX(-50%); width: 100%; max-width: 400px;">
    <strong>{{ $error }}</strong>
    <button type="button" class="close d-flex align-items-center justify-content-center" data-dismiss="alert"
        aria-label="Close" style="position: absolute; top: 0.25rem; right: 0.75rem; font-size: 1.25rem;">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert.classList.contains('show')) {
                $(alert).alert('close');
            }
        });
    }, 3000);
});
</script>