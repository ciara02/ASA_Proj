@extends('layouts.base')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Include DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <!-- Include your custom CSS -->
    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/tab-activity/newproj.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/Modal/modal.css') }}" rel="stylesheet">

    <p class="title-text"><i class="bi bi-house-door-fill" style="color: #6f42c1"></i> Activity Completion Acceptance</p>
    {{-- <p class="title">ACTIVITY COMPLETION ACCEPTANCE</p> --}}

    <div id="loading-overlay" style="display:none;">
        <div class="spinner"></div>
    </div>

    <p>Filter by Date & Engineers:</p>
    <div class="d-flex align-items-center" style="gap: 1rem; margin-bottom: 1rem;">
        <div class="d-flex align-items-center">
            <label class="pe-2"><b>From:</b></label>
            <input type="date" class="form-control DateDisabled startDate" name="StartDate" id="dateFrom"
                placeholder="mm/dd/yyyy" />
        </div>

        <div class="d-flex align-items-center">
            <label class="pe-2"><b>To:</b></label>
            <input type="date" class="form-control DateDisabled endDate" name="EndDate" id="dateTo"
                placeholder="mm/dd/yyyy" />
        </div>

        <div class="d-flex align-items-center engineer-input-container">
            <label class="pe-2"><b>Engineer(s):</b></label>
            <select class="form-control" id="engineername" name="engineers[]"></select>
        </div>

        <div class="d-flex align-items-center">
            <div id="filterContainer" class="margin-top: 1rem">
                <button type="submit" name="search" id="filter_button" class="find-btn d-flex align-items-center"
                    style="gap: 0.5rem">
                    <i class="bi bi-funnel-fill"></i>
                    <span>Filter</span>
                </button>
            </div>

            <div id="loading2" style="display: none;">
                <div class="spinner-border text-dark" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <div class="datatable_custom_style">
        <div class="datatable_custom_borderbox">
            <div class="table-responsive">
                <table id="activity-accept-table" class="basic-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Engineer</th>
                            <th>Activity Reference #</th>
                            <th>Activity Details</th>
                            <th>Reseller</th>
                            <th>End User</th>
                            <th>Category</th>
                            <th>Activity Type</th>
                            <th>Product Line</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Project Name</th>
                            <th>Reseller Contact</th>
                            <th>End User Contact</th>
                            <th>Date Created</th>
                            <th>Activity Done</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr>
                                <td>{{ $result->ar_activityDate }}</td>
                                <td>{{ $result->engr_name }}</td>
                                <td>{{ $result->ar_refNo }}</td>
                                <td>{{ $result->ar_activity }}</td>
                                <td>{{ $result->ar_resellers }}</td>
                                <td>{{ $result->ar_endUser }}</td>
                                <td>{{ $result->report_name }}</td>
                                <td>{{ $result->type_name }}</td>
                                <td>{{ $result->ProductLine }}</td>
                                <td>{{ $result->aa_status }}</td>
                                <td>{{ $result->aa_created_by }}</td>
                                <td>{{ $result->proj_name }}</td>
                                <td>{{ $result->ar_endUser_contact }}</td>
                                <td>{{ $result->ar_endUser_contact }}</td>
                                <td>{{ Carbon::parse($result->aa_date_created)->format('Y-m-d') }}</td>
                                <td class="truncate">{{ str_replace('<br />', '', $result->ar_activityDone) }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Click DataTable Row Modal -->
    <div class="modal fade" id="edit_datatable_row" tabindex="-1" aria-labelledby="edit_datatable_row" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="edit_datatable_row"> ACTIVITY COMPLETION ACCEPTANCE </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="mt-2 ps-2">
                    <p class="reportstatus" id="completionstatus">Status: <span class="status" name="status"></span></p>
                </div>
                <div class="modal-body">
                    <div class="card" id="quick_addActivity">
                        <div class="card-header">
                            Activity Summary Report Completion Acceptance
                        </div>


                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="refno" class="form-label">Reference No:</label>
                                    <input type="text" class="form-control" id="refno" required>
                                    <input type="hidden" id="Ar_IdCompletion" name="Ar_IdCompletion">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="date" class="form-label">Date Created:</label>
                                    <input type="date" class="form-control" id="date" required>
                                    <input type="hidden" id="time_completion" name="time_completion">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="created_by" class="form-label">Created By:</label>
                                    <input type="text" class="form-control" id="created_by" placeholder=""
                                        value="" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="Proj_Name" class="form-label">Project Name:</label>
                                    <input type="text" class="form-control" id="Proj_Name" placeholder=""
                                        value="" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="reseller" class="form-label">Reseller:</label>
                                    <input type="text" class="form-control" id="reseller" placeholder=""
                                        value="" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="reseller_contact" class="form-label">Reseller Contact:</label>
                                    <input type="text" class="form-control" id="reseller_contact" placeholder=""
                                        value="" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="activity_date" class="form-label">Activity Date:</label>
                                    <input type="date" class="form-control" id="activity_date" placeholder=""
                                        value="" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="end_user" class="form-label">End User:</label>
                                    <input type="text" class="form-control" id="end_user" placeholder=""
                                        value="" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="EU_Contact" class="form-label">End User Contact:</label>
                                    <input type="text" class="form-control" id="EU_Contact" placeholder=""
                                        value="" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="engineer" class="form-label">Engineers:</label>
                                    <select class="form-control" id="engineer" name="engineer[]" multiple="multiple"
                                        required></select>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label for="activity_details" class="form-label">Activity Details:</label>
                                    <textarea class="form-control" id="activity_details" rows="3"></textarea>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="card mt-2" id="act_done">
                        <div class="card-header">
                            Activity Done
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    <textarea class="form-control" id="Act_Done"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card mt-2" id="MultiParticipant">
                        <div class="card-header">
                            Approvers
                        </div>
                        <div class="card-body" id="approvers-container">
                            <!-- This is where the approvers will be dynamically inserted -->
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" id="add-approver" disabled>Add</button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-2 mt-2 custom-position">
                        <button type="button" id="CloseButton" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id = "EditButton" class="btn btn-primary">Edit</button>
                        <button type="button" id = "SaveChanges" class="btn btn-success">Save Changes</button>
                        <button type="button" id = "SendtoClient" class="btn btn-warning" disabled>Send to
                            Client</button>
                        <button type="button" id = "Cancel" class="btn btn-danger">Cancel</button>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Include DataTables Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    {{-- Include Select2 script cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Include your script.js file -->
    <script src="{{ asset('assets/tab-activity/act-com-accept-script.js') }}"></script>
    <script src="{{ asset('assets/tab-activity/act-com-accept-modal.js') }}"></script>

    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
@endsection
