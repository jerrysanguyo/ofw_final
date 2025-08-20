@extends('layouts.dashboard')

@section('content')
@include('components.alert')
<section class="section">
    <div class="section-body">
        <div class="card shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    {{ $page_title }} CMS
                </h2>
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
                        For any field that does not apply, simply input <strong>N/A</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="section-body">
        <div class="card shadow-lg card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="font-weight-bold mb-0">
                    List of {{ $page_title }}
                </h3>
                <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#add{{ $resource }}Modal">
                    <i class="fa fa-plus"></i> Add {{ $page_title }}
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="{{ $resource }}-table" class="table table-hover text-center">
                        <thead class="border-black table-primary border">
                            <tr>
                                @foreach ($columns as $column)
                                <th class="text-uppercase">
                                    {{ $column }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $record)
                            @php
                            $fieldMap = [
                            'role' => 'guard_name',
                            'permission' => 'guard_name',
                            'barangay' => 'district.name',
                            'goal' => 'domain.name',
                            'competency' => 'domain.name',
                            'objective' => 'goal.name',
                            ];
                            $firstCol = isset($fieldMap[$resource]) ? data_get($record, $fieldMap[$resource]) :
                            $record->remarks;
                            $secondCol = in_array($resource, ['barangay','goal','competency','objective']) ?
                            $record->remarks : null;
                            @endphp
                            <tr>
                                <td class="border border-black">{{ $record->id }}</td>
                                <td class="border border-black">{{ $record->name }}</td>
                                <td class="border border-black">{{ $firstCol }}</td>
                                @if($secondCol)
                                <td class="border border-black">{{ $secondCol }}</td>
                                @endif
                                <td class="border border-black">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#editModal-{{ $record->id }}" title="Edit {{ $page_title }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        @push('modals')
                                        @include('cms.edit')
                                        @endpush
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#deleteModal-{{ $record->id }}"
                                            title="Delete {{ $page_title }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @push('modals')
                                        @include('cms.delete')
                                        @endpush
                                    </div>
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
@include('cms.create')
@include('cms.edit')
@include('cms.delete')
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