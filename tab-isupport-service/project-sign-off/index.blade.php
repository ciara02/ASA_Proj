@extends('layouts.base')
@section('content')
<!-- Include the modal content -->
@include('tab-isupport-service.project-sign-off.project-signoff-modal')
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Include DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

      <!-- Include DataTables Buttons CSS -->
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- Include your custom CSS -->
    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/tab-isupport-service/projec-signoff-modal.css') }}" rel="stylesheet">

    <p class="title-text"><i class="bi bi-inboxes-fill" style="color: #dc3545"></i> Project Sign-off</p>

    <div class="">
        <form id="searchMethod" method="get" enctype="multipart/form-data" action="{{ route('tab-isupport-service.project-sign-off.search') }}">
            @csrf
            <p>Filter by Date & Engineers:</p>
            <div class="d-flex align-items-center" style="gap: 1rem; margin-bottom: 1rem;">
                <div class="d-flex align-items-center">
                    <label class="pe-2"><b>From:</b></label>
                    <input type="date" class="form-control startDate" name="dateFrom" id="dateFrom" placeholder="mm/dd/yyyy"
                        value="{{ request('dateFrom') }}" />
                </div>

                <div class="d-flex align-items-center">
                    <label class="pe-2"><b>To:</b></label>
                    <input type="date" class="form-control endDate" name="dateTo" id="dateTo" placeholder="mm/dd/yyyy"
                        value="{{ request('dateTo') }}" />
                </div>

                <div class="d-flex align-items-center engineer-input-container">
                    <label class="pe-2"><b>Engineer(s):</b></label>
                    <select class="form-control" id="engineer" name="engineer[]"></select>
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
        </form>
        
        <div class="datatable_custom_style">
            <div class="datatable_custom_borderbox">
                <div class="table-responsive">
                    <table id="implementation-datatable" class="basic-border" >
                        <thead>
                            <tr>
                                <th>Date Created</th>
                                <th>Project Name</th>
                                <th>Business Unit</th>
                                <th>Product Line</th>
                                <th>Service Category</th>
                                <th>OR</th>
                                <th>INV</th>
                                <th>MBS</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Reseller</th>
                                <th>End User</th>
                                <th>Project Manager</th>
                                <th>Project Member</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- table rows loops here --}}
                            @if (isset($projects))
                                @foreach ($projects as $project)
                                <tr data-toggle="modal" data-target="#porjectSignOffModal" data-project-id="{{ $project->id }}" data-created="{{ $project->created_by }}" data-deliverables="{{$project->deliverables}}" data-attachment="{{$project->attachment}}">
                                        <td>{{ \Carbon\Carbon::parse($project->date_created)->format('Y-m-d') }}</td>
                                        <td class="truncate">{{ $project->proj_name }}</td>
                                        <td>{{ $project->business_unit }}</td>
                                        <td>{{ $project->product_line }}</td>
                                        <td>{{ $project->service_category }}</td>
                                        <td>{{ $project->original_receipt }}</td>
                                        <td>{{ $project->inv }}</td>
                                        <td>{{ $project->mbs }}</td>
                                        <td>{{ $project->proj_startDate }}</td>
                                        <td>{{ $project->proj_endDate }}</td>
                                        <td>{{ $project->reseller }}</td>
                                        <td>{{ $project->endUser }}</td>
                                        <td>{{ $project->PM }}</td>
                                        <td>{{ $project->ProjectMember }}</td>
                                        <td>
                                            @switch($project->status)
                                                @case(1)
                                                    Draft
                                                @break
        
                                                @case(2)
                                                    For Approval
                                                @break
        
                                                @case(3)
                                                    Approved
                                                @break
        
                                                @case(4)
                                                    Disapproved
                                                @break
        
                                                @default
                                                    Unknown Status
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <!-- Include jQuery before other scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    {{-- Include Select2 script cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Include your script.js file -->
    <script src="{{ asset('assets/tab-isupport-service/script.js') }}"></script>
    <script src="{{ asset('assets/Modal/isupport-modal.js') }}"></script>

     <!-- Include DataTables Buttons Extension JavaScript -->
     <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>


@endsection
