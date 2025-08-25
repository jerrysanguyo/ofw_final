@extends('layouts.dashboard')

@section('content')
@include('components.alert')

<section class="section">
    <div class="section-body">
        <div class="card shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">{{ $page_title }}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route(Auth::user()->getRoleNames()->first() . '.dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fas fa-file-alt"></i> {{ $page_title }}
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
                        This table lists all recent activity from Spatie Activity Log. Click the <strong>expand</strong>
                        button to view full properties/changes.
                    </p>
                </div>
            </div>
        </div>

        <div class="card shadow-lg card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="font-weight-bold mb-0">List of {{ $page_title }}</h3>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="{{ $resource }}-table" class="table table-hover text-center">
                        <thead class="border-black table-primary border">
                            <tr>
                                @foreach ($columns as $column)
                                <th class="text-uppercase">{{ $column }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $record)
                            <tr>
                                <td class="border border-black">
                                    {{ $record->created_at }}
                                </td>
                                <td class="border border-black">
                                    @php
                                    $causer = $record->causer;
                                    $name = $causer
                                    ? trim(collect([$causer->first_name ?? null, $causer->middle_name ?? null,
                                    $causer->last_name ?? null])->filter()->join(' '))
                                    : 'System';
                                    @endphp
                                    {{ $name ?: 'System' }}
                                </td>
                                <td class="border border-black">
                                    {{ \Illuminate\Support\Str::limit($record->description, 100) }}
                                </td>
                                <td class="border border-black">
                                    {{ class_basename($record->subject_type) }}
                                </td>
                                <td class="border border-black">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#showLogModal-{{ $record->id }}" title="Show details">
                                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                                        </button>
                                    </div>
                                    
                                    @push('modals')
                                    @include('log.show', [
                                    'record' => $record,
                                    'modalId' => 'showLogModal-'.$record->id
                                    ])
                                    @endpush
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@push('modals')
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#{{ $resource }}-table').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 10,
        order: [
            [0, 'desc']
        ],
        dom: '<"d-flex justify-content-between align-items-center mb-3"' +
            '<"dataTables_length"l><"dataTables_filter"f>' +
            '>rt' +
            '<"d-flex justify-content-between align-items-center mt-3"' +
            '<"dataTables_info"i><"dataTables_paginate"p>' +
            '>',

        initComplete() {
            $('div.dataTables_length select')
                .removeClass()
                .addClass('form-select form-select-sm border-bottom');
            $('div.dataTables_filter input')
                .removeClass()
                .addClass('form-control form-control-sm')
                .attr('placeholder', 'Search...');
        },
    });
});
</script>
@endpush
@endsection