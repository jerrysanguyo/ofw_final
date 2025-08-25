<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="{{ $modalId }}Label">
                    <i class="fas fa-clipboard-list mr-2 mb-3"></i> {{ $page_title }} Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card border">
                            <div class="card-header py-2"><strong>Meta</strong></div>
                            <div class="card-body p-3">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><strong>Created at:</strong> {{ $record->created_at }}</li>
                                    <li class="mb-2"><strong>Updated at:</strong> {{ $record->updated_at }}</li>
                                    <li class="mb-2"><strong>Model:</strong> {{ class_basename($record->subject_type) }}
                                    </li>
                                    <li class="mb-0">
                                        <strong>User:</strong>
                                        @php
                                        $causer = $record->causer;
                                        $name = $causer
                                        ? trim(collect([$causer->first_name ?? null, $causer->middle_name ?? null,
                                        $causer->last_name ?? null])->filter()->join(' '))
                                        : 'System';
                                        @endphp
                                        {{ $name ?: 'System' }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card border">
                            <div class="card-header py-2"><strong>Description</strong></div>
                            <div class="card-body p-3">
                                <p class="mb-0">{{ $record->description }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @php
                    $properties = $record->properties ?? collect();
                    $attrs = data_get($properties, 'attributes', []);
                    $old = data_get($properties, 'old', []);
                    @endphp

                    <div class="col-md-6 mb-3">
                        <div class="card border">
                            <div class="card-header py-2 d-flex justify-content-between align-items-center">
                                <strong>Attributes</strong>
                                @if(!empty($attrs))
                                <span class="badge badge-primary">{{ count($attrs) }}</span>
                                @endif
                            </div>
                            <div class="card-body p-3">
                                @if(empty($attrs))
                                <span class="text-muted">No attributes recorded.</span>
                                @else
                                <pre class="mb-0"
                                    style="white-space: pre-wrap; word-break: break-word;">{{ json_encode($attrs, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="card border">
                            <div class="card-header py-2 d-flex justify-content-between align-items-center">
                                <strong>Old</strong>
                                @if(!empty($old))
                                <span class="badge badge-secondary">{{ count($old) }}</span>
                                @endif
                            </div>
                            <div class="card-body p-3">
                                @if(empty($old))
                                <span class="text-muted">No previous values recorded.</span>
                                @else
                                <pre class="mb-0"
                                    style="white-space: pre-wrap; word-break: break-word;">{{ json_encode($old, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>