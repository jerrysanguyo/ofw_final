<div class="modal fade" id="editModal-{{ $record->id ?? '' }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel-{{ $record->id ?? '' }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel-{{ $record->id ?? '' }}">Edit {{ $page_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route(Auth::user()->getRoleNames()->first() .'.'.$resource.'.update', $record->id) }}"
                method="POST" novalidate>
                @csrf
                @method('put')
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $record->id }}">
                    <div class="alert alert-primary small mb-4">
                        <i class="fas fa-info-circle text-success"></i>
                        Update the teacher’s information. Leave password fields blank to keep the current password.
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="first_name-{{ $record->id }}">First Name</label>
                            <input id="first_name-{{ $record->id }}" type="text"
                                class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                value="{{ old('first_name', $record->first_name) }}" required>
                            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="middle_name-{{ $record->id }}">Middle Name</label>
                            <input id="middle_name-{{ $record->id }}" type="text"
                                class="form-control @error('middle_name') is-invalid @enderror" name="middle_name"
                                value="{{ old('middle_name', $record->middle_name) }}">
                            @error('middle_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="last_name-{{ $record->id }}">Last Name</label>
                            <input id="last_name-{{ $record->id }}" type="text"
                                class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                value="{{ old('last_name', $record->last_name) }}" required>
                            @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email-{{ $record->id }}">Email</label>
                            <input id="email-{{ $record->id }}" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email', $record->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contact_number-{{ $record->id }}">Contact Number</label>
                            <input id="contact_number-{{ $record->id }}" type="text"
                                class="form-control @error('contact_number') is-invalid @enderror" name="contact_number"
                                value="{{ old('contact_number', $record->contact_number) }}" required>
                            @error('contact_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="password-{{ $record->id }}" class="d-block">
                                Password <small class="text-muted">(leave blank to keep)</small>
                            </label>
                            <input id="password-{{ $record->id }}" type="password"
                                class="form-control pwstrength @error('password') is-invalid @enderror"
                                data-indicator="pwindicator-{{ $record->id }}" name="password"
                                autocomplete="new-password">
                            <div id="pwindicator-{{ $record->id }}" class="pwindicator mt-2">
                                <div class="bar"></div>
                                <div class="label small"></div>
                            </div>
                            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password_confirmation-{{ $record->id }}" class="d-block">Password
                                Confirmation</label>
                            <input id="password_confirmation-{{ $record->id }}" type="password" class="form-control"
                                name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role-{{ $record->id }}">Role</label>
                        <select id="role-{{ $record->id }}" name="role"
                            class="form-control @error('role') is-invalid @enderror" required>
                            <option value="" disabled>-- Select Role --</option>
                            @foreach($subData as $role)
                            <option value="{{ $role->name }}"
                                {{ old('role', $record->getRoleNames()->first() ) === $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                            @endforeach
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>