@extends('layouts.base')
@section('content')
    {{--  --}}
    
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Include DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- Include DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Include your custom CSS -->
    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/tab-activity/newproj.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/Modal/modal.css') }}" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">

    <div class="mx-auto" style="width:90%">
        @if (session()->has('success'))
            <div
                style="background-color: rgb(119, 205, 119); color: rgb(0, 0, 0); padding: 15px; border-radius: 5px; position: relative;">
                {!! session()->get('success') !!}
                <button
                    style="background: none; border: none; color: rgb(63, 56, 56); font-size: 20px; position: absolute; top: 10px; right: 10px; cursor: pointer;"
                    onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif
    </div>

    <p class="title-text"><i class="bi bi-house-door-fill" style="color: #6f42c1"></i> Activity Reports</p>

    <div id="loading-overlay" style="display:none;">
        <div class="spinner"></div>
    </div>

    <div id="loading-progress" class="progress-overlay">
        <div class="spinner-container">
            <div class="spinner-modal" id="spinner"></div>
            <div class="spinner-text" id="spinner-text">0%</div>
        </div>
    </div>

    <p>Filter by Date & Engineers:</p>
    <div class="d-flex align-items-center" style="gap: 1rem; margin-bottom: 1rem;">
        <div class="d-flex align-items-center">
            <label class="pe-2"><b>From:</b></label>
            <input type="date" class="form-control startDate" name="StartDate" id="startDate" placeholder="mm/dd/yyyy" />
        </div>

        <div class="d-flex align-items-center">
            <label class="pe-2"><b>To:</b></label>
            <input type="date" class="form-control endDate" name="EndDate" id="endDate" placeholder="mm/dd/yyyy" />
        </div>

        <div class="d-flex align-items-center engineer-input-container">
            <label class="pe-2"><b>Engineer(s):</b></label>
            <select class="form-control" id="engineername" name="engineers[]"></select>
        </div>

        <div class="d-flex align-items-center">
            <div id="filterContainer" class="margin-top: 1rem">
                <button type="submit" name="search" class="find-btn d-flex align-items-center" style="gap: 0.5rem">
                    <i class="bi bi-funnel-fill"></i>
                    <span>Filter</span>
                </button>
            </div>

            <div id="loading" style="display: none;">
                <div class="spinner-border text-dark" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <div class="datatable_custom_style">
        <div class="datatable_custom_borderbox">
            <!-- Button trigger modal -->
            <div class="table-btn-container">
                <div id="printButtonContainer"></div> <!-- Placeholder for the print button -->
                <a class="main-btn" href="{{ route('tab-activity.create') }}" role="button"><i class="bi bi-plus-lg"></i> New Activity</a>
            </div>

            <table id="datatable1" class="basic-border" style="width:100%; overflow-x: auto;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Reference #</th>
                        <th>Engineer</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Category</th>
                        <th>Activity Type</th>
                        <th>Product Line</th>
                        <th>Activity Details</th>
                        <th>Reseller</th>
                        <th>Venue</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td>{{ $result->ar_activityDate }}</td>
                            <td>{{ $result->ar_refNo }}</td>
                            <td class='truncate'>{{ $result->EngrNames }}</td>
                            <td>{{ $result->time_reported }}</td>
                            <td>{{ $result->time_exited }}</td>
                            <td>{{ $result->report_name }}</td>
                            <td>{{ $result->type_name }}</td>
                            <td class='truncate'>{{ $result->ProductLine }}</td>
                            <td>{{ $result->ar_activity }}</td>
                            <td>{{ $result->ar_resellers }}</td>
                            <td>{{ $result->ar_venue }}</td>
                            <td>{{ $result->status_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @include('Modal.activity-report-modal')
    @include('Modal.quick-add-activity-modal')

    @if ($errors->any())
        <script>
            window.alert("{{ $errors->first('message') }}");
        </script>
    @endif
    <!-- Include jQuery before other scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    <!-- Include your script.js file -->

    <script src="{{ asset('assets/tab-activity/act-report-engr-script.js') }}"></script>
    <script src="{{ asset('assets/tab-activity/script.js') }}"></script>

    <script src="{{ asset('assets/tab-activity/date-filter-script.js') }}"></script>

    <script src="{{ asset('assets/tab-activity/act-report-form-script.js') }}"></script>
    <script src="{{ asset('assets/Modal/modal.js') }}"></script>

    <script src="{{ asset('assets/tab-activity/act-report-quickadd.js') }}"></script>
    <script src="{{ asset('assets/Modal/modal2.js') }}"></script>


    <!-- Send Form -->
    <script src="{{ asset('assets/template/forward.js') }}"></script>

    <!-- Include DataTables Buttons Extension JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
@endsection
