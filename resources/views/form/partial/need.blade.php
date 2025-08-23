<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h6 class="text-muted mb-0">Mga Kailangan ng Pamilya</h6>
        <div>
            <button type="button" id="add-need-row" class="btn btn-success btn-sm mr-2">+</button>
            <button type="button" id="remove-need-row" class="btn btn-danger btn-sm">−</button>
        </div>
    </div>
    <hr class="my-2">
    @php
        if ($userNeeds instanceof \Illuminate\Support\Collection) {
            $needsArr = $userNeeds->pluck('need_id')->map(fn ($id) => (string) $id)->values()->all();
        } elseif (is_array($userNeeds)) {
            $needsArr = array_map('strval', $userNeeds);
        } else {
            $needsArr = [];
        }

        $oldNeeds = array_map('strval', old('needs.need_id', []));
        $rowCount = max(count($oldNeeds), count($needsArr), 1);
    @endphp

    <div id="needs-container">
        @for ($i = 0; $i < $rowCount; $i++)
            @php
                $selectedNeed = $oldNeeds[$i] ?? ($needsArr[$i] ?? '');
            @endphp

            <div class="form-row mb-2 need-row">
                <div class="form-group col-md-12">
                    <label for="need_id_{{ $i }}">Need</label>
                    <select id="need_id_{{ $i }}" name="needs[need_id][]" class="form-control need-select">
                        <option value="" disabled hidden {{ $selectedNeed === '' ? 'selected' : '' }}>Choose...</option>
                        @foreach($needs as $need)
                            <option value="{{ $need->id }}" {{ $selectedNeed === (string) $need->id ? 'selected' : '' }}>
                                {{ $need->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endfor
    </div>
</div>
