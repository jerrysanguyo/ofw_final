@extends('layouts.dashboard')

@section('content')
@include('components.alert')
<section class="section">
    <div class="section-body">
        <div class="card shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    Application form
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route(Auth::user()->getRoleNames()->first() . '.dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fas fa-file-alt"></i> Application form
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="callout callout-info">
                    <div class="callout-header">
                        <i class="fas fa-info-circle text-danger"></i> Please Note
                    </div>
                    <p class="mb-0">
                        For any field that does not apply, simply input <strong>N/A</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="section-body">
        <div class="card shadow-lg card-primary">
            <div class="card-body">
                <form action="" method="post">
                    @include('form.partial.personal')
                    @include('form.partial.abroad')
                    @include('form.partial.family')
                    @include('form.partial.need')
                </form>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script src="{{ asset('assets/js/form/age.js') }}"></script>
<script src="{{ asset('assets/js/form/job.js') }}"></script>
<script src="{{ asset('assets/js/form/country.js') }}"></script>
<script src="{{ asset('assets/js/form/family.js') }}"></script>
<script src="{{ asset('assets/js/form/need.js') }}"></script>
@endpush
@endsection