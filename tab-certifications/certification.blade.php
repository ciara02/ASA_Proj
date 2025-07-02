@extends('layouts.base')
@section('content')

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Include DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include your custom CSS -->
    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/tab-certifications/certification.css') }}" rel="stylesheet">
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

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible">
            {{ session()->get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <p class="title-text"><i class="bi bi-mortarboard-fill" style="color: #20c997"></i> Certifications</p>

    <div class="d-flex align-items-center" style="gap: 1rem; margin-bottom: 1rem;">
        <div class="d-flex align-items-center">
            <label class="pe-2 mb-0" style="white-space: nowrap;"><b>Rearrange table:</b></label>
            <select class="form-control form-select" id="perCertDropdown" aria-haspopup="true"
            aria-expanded="false" name="perCertDropdown">
                <option value="inc_Status" selected>Per Incentive Status</option>
                <option value="per_Engr">Per Engineer</option>
                <option value="per_Product">Per Product Line</option>
            </select>
        </div>
    </div>

    <div class="datatable_custom_style">
        <div class="datatable_custom_borderbox">
            <table id="certificationTable" class="basic-border custom-table" style="width: 150%;">
                <thead>
                    <tr>
                        <th>Release Status</th>
                        <th>Incentive Status</th>
                        <th>Date</th>
                        <th>Engineer</th>
                        <th>Type</th>
                        <th>Exam Type</th>
                        <th>Incentive Details</th>
                        <th>Amount</th>
                        <th>Product Line</th>
                        <th>Title</th>
                        <th>Exam Code</th>
                        <th>Score</th>
                        <th>Takes</th>
                        <th style="display:none"></th>

                    </tr>
                </thead>

                <tbody>
                    @if (isset($incentives))
                        @foreach ($incentives as $incentive)
                            <tr class="clickable-row" data-toggle="modal"
                                data-refNo="{{ $incentive->ar_refNo . '|' . $incentive->ProductCode . '|' . $incentive->program_name . '|' . $incentive->report_name . '|' . $incentive->status_name . '|' . $incentive->ar_activity . '|' . $incentive->ar_activityDate . '|' . $incentive->ar_venue . '|' . $incentive->ar_sendCopyTo }}  "
                                data-attachments="{{ $incentive->att_name }}"
                                data-ar-take-status="{{ $incentive->ar_takeStatus }}">
                                <td class="release-status">Unreleased</td>
                                <td class="incentive-status">{{ $incentive->incStatus_name ?? 'Undefined' }}</td>
                                <td class="date">{{ $incentive->ar_activityDate }}</td>
                                <td class="engr">{{ $incentive->engr_name }}</td>
                                <td class="type">{{ $incentive->type_name }}</td>
                                <td class="exam_type">{{ $incentive->exam_name }}</td>
                                <td class="incentive-details">
                                    {{ $incentive->incDetails_name }}</td>
                                <td class="amt">
                                    {{ empty($incentive->ar_incAmount) ? 0 : $incentive->ar_incAmount }}

                                </td>
                                <td class="prod_Line">
                                    {{ $incentive->ProductLine }}</td>
                                <td class="inc_title">
                                    {{ $incentive->ar_title }}
                                </td>
                                <td class="exam_code">{{ $incentive->ar_examName }}</td>
                                <td class="score">{{ $incentive->ar_score }}</td>
                                <td class="takes" id="takeStatus">
                                    {{ $incentive->ar_takeStatus }}
                                    {{ $incentive->ar_takeStatus == 1 ? 'take' : 'takes' }}

                                </td>
                                <td class="ar_id" style="display:none">
                                    {{ $incentive->ar_id }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>

    @include('Modal.activity-report-modal')

    @if ($errors->any())
        <script>
            window.alert("{{ $errors->first('message') }}");
        </script>
    @endif

    <!-- Include jQuery before other scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Include your script.js file -->
    <script src="{{ asset('assets/tab-certifications/cert-script.js') }}"></script>
    <script src="{{ asset('assets/Modal/modal.js') }}"></script>
    <script src="{{ asset('assets/tab-activity/act-report-form-script.js') }}"></script>
    <script src="{{ asset('assets/template/forward.js') }}"></script>

    <!-- DataTables Buttons Extension -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include DataTables ColReorder extension -->
    <script src="https://cdn.datatables.net/colreorder/1.7.0/js/dataTables.colReorder.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@endsection
