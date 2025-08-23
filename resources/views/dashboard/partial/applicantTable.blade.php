<div class="row">
    <div class="col-12">
        <div class="card lift-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Recent Applicants</h4>
                <a href="#" class="btn btn-primary btn-sm">
                    View more records
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="applicant-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact number</th>
                                <th>Email</th>
                                <th>Country</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listOfApplicant as $applicant)
                            <tr>
                                <td>
                                    {{
                                        ($applicant->last_name ?? '') . ', ' .
                                        ($applicant->first_name ?? '') . ' ' .
                                        ($applicant->middle_name ?? '')
                                    }}
                                </td>
                                <td>{{ $applicant->contact_number ?? 'N/A' }}</td>
                                <td>{{ $applicant->email ?? 'N/A' }}</td>
                                <td>{{ $applicant->abroad->country->name ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <small class="text-muted d-block mt-2"><i class="far fa-info-circle mr-1"></i>Showing latest
                    entries</small>
            </div>
        </div>
    </div>
</div>