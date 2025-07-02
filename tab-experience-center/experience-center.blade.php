@extends('layouts.base')
@section('content')

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Include DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    @if (session()->has('status'))
        <div class="alert alert-success alert-dismissible">
            {{ session()->get('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Include your custom CSS -->
    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/tab-exp-center/exp-center.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/tab-activity/newproj.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/Modal/modal.css') }}" rel="stylesheet">

    <div id="loading-overlay" style="display:none;">
        <div class="spinner"></div>
    </div>

    <div id="loading-progress" class="progress-overlay">
        <div class="spinner-container">
            <div class="spinner-modal" id="spinner"></div>
            <div class="spinner-text" id="spinner-text">0%</div>
        </div>
    </div>

        
    <p class="title-text"><i class="bi bi-briefcase-fill" style="color: #28a745"></i> Experience Center</p>

    <div class="datatable_custom_style">
        <div class="datatable_custom_borderbox">
            <div class="table-responsive">
                <table id="expCenterTable" class="basic-border">
                    <thead>
                        <tr>
                            <th style="width:10%">Program</th>
                            <th style="width:10%">Date</th>
                            <th style="width:10%">Reference #</th>
                            <th style="width:10%">Engineer</th>
                            <th style="width:10%">Product Line</th>
                            <th style="width:10%">Reseller</th>
                            <th style="width:10%">Activity Details</th>
                            <th style="width:10%">Status</th>

                            
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($experience))
                            @foreach ($experience as $exp)
                                <tr class="clickable-row" data-toggle="modal" data-target="#experienceModal"
                                     data-id="{{ $exp->ar_id }}"
                                    data-refNo="{{ $exp->ar_resellers_contact . '|' . $exp->ar_endUser_contact . '|' . $exp->ar_endUser_loc . '|' . $exp->ar_resellers_phoneEmail . '|' . $exp->ar_endUser_phoneEmail . '|' . $exp->ar_endUser . '|' . optional($exp->activity_report_ExpCenter)->type_name . '|' . optional($exp->timeReported_ExpCenter)->key_time . '|' . optional($exp->timeExited_ExpCenter)->key_time . '|' . optional($exp->timeExpected_ExpCenter)->key_time . '|' . $exp->ar_venue . '|' . implode(', ', $exp->productCodes) . '|' . $exp->ar_custRequirements . '|' . $exp->ar_activityDone . '|' . $exp->ar_agreements . '|' . optional($exp->actionPlan_ExpCenter)->PlanTargetDate . '|' . $exp->ar_report . '|' . $exp->ar_status . '|' . optional($exp->actionPlan_ExpCenter)->PlanDetails . '|' . optional($exp->actionPlan_ExpCenter)->PlanOwner . '|' . $exp->ar_requester . '|' . $exp->ar_instruction . '|' . $exp->ar_sendCopyTo . '|' . $exp->ar_date_filed . '|' . $exp->ar_date_needed 
                                     . '|' . $exp->ar_takeStatus . '|' . $exp->ar_activityType . '|' . $exp->ar_POCproductModel . '|' . $exp->ar_POCassetOrCode . '|' . $exp->ar_POCdateStart . '|' . $exp->ar_POCdateEnd . '|' . $exp->ar_title . '|' . $exp->ar_examName . '|' . $exp->ar_score . '|' . $exp->ar_examType . '|' . $exp->ar_incStatus . '|' . $exp->ar_incDetails . '|' . $exp->ar_incAmount . '|' . $exp->ar_prodLearned . '|' . $exp->ar_trainingName . '|' . $exp->ar_location . '|' . $exp->ar_speakers . '|' . $exp->ar_attendeesBPs. '|' . $exp->ar_attendeesEUs. '|' . $exp->ar_attendeesMSI  . '|' . optional($exp->attachment_ExpCenter)->att_name}} " >
                                    <td class="program_ExpCenter">
                                        {{ optional($exp->program_ExpCenter)->program_name }}</td>
                                    <td class="ar_activityDate">{{ $exp->ar_activityDate }}</td>
                                    <td class="ar_refNo">{{ $exp->ar_refNo }}</td>
                                    <td class="engr_ExpCenter" style="width:10%">
                                        {{ implode(',', $exp->engineers) }}</td>
                                    <td class="productLine_ExpCenter" style="width:10%">
                                        {{ implode(',', $exp->productLines) }}
                                    </td>
                                    <td class="ar_resellers">{{ $exp->ar_resellers }}</td>
                                    <td class="ar_activity" style="width:10%">
                                        {{ $exp->ar_activity }}</td>
                                    <td class="status_ExpCenter">{{ optional($exp->status_ExpCenter)->status_name }}</td>  
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('Modal.activity-report-modal')
    <!-- Include jQuery before other scripts -->

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

      <!-- Include DataTables Buttons Extension JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/exceljs@latest/dist/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>


    {{-- tooltip --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>


    <!-- Include your script.js file -->
    <script src="{{ asset('assets/tab-exp-center/exp-centerScript.js') }}"></script>

   
    <script src="{{ asset('assets/tab-activity/act-report-engr-script.js') }}"></script>
    <script src="{{ asset('assets/tab-activity/script.js') }}"></script>

    <script src="{{ asset('assets/tab-activity/act-report-form-script.js') }}"></script>
    <script src="{{ asset('assets/Modal/modal.js') }}"></script>

        <!-- Send Form -->
    <script src="{{ asset('assets/template/forward.js') }}"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
