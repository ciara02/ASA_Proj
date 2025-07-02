@extends('layouts.base')
@section('content')
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Include DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include your custom CSS -->
    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/tab-point-system/point_system.css') }}" rel="stylesheet">

    <div id="alerts-container">
        @if (session()->has('status'))
            <div class="alert alert-success alert-dismissible">
                {{ session()->get('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="pscontainer ">
        <p class="title-text"><i class="bi bi-star-fill" style="color: #ffc107"></i> Merit/Demerit View - All</p>
        
        <p>Filter by Type & Status:</p>
        <div class="d-flex align-items-center" style="gap: 1rem; margin-bottom: 1rem;">
            <div class="d-flex align-items-center">
                <label class="pe-2"><b>Type:</b></label>
                <select class="form-control form-select" id="meritdemeritDropdown" aria-haspopup="true" aria-expanded="false" name="meritdemeritDropdown">
                    <option value="" selected disabled>TYPE</option>
                    <option value="1">MERIT</option>
                    <option value="0">DEMERIT</option>
                </select>
            </div>

            <div class="d-flex align-items-center">
                <label class="pe-2"><b>Status:</b></label>
                <select class="form-control form-select" id="approvalDropdown" aria-haspopup="true" aria-expanded="false" name="approvalDropdown">
                    <option value="" selected disabled>STATUS</option>
                    <option value="For Approval">FOR APPROVAL</option>
                    <option value="Approved">APPROVED</option>
                    <option value="Disapproved">DISAPPROVED</option>
                </select>
            </div>

            <div class="d-flex align-items-center">
                <div id="filterContainer" class="margin-top: 1rem">
                    <a href="{{ route('tab-point-system.index') }}" type="button" id="removeButton" value="Remove" name="searchSystem" class="find-btn d-flex align-items-center" style="gap: 0.5rem">
                        <i class="bi bi-arrow-clockwise"></i>
                        <span>Clear</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="datatable_custom_style">
            <div class="datatable_custom_borderbox">
                <div class="merit-demerit-table-btn">
                    {{-- <a id="printButton" class="btn btn-success custom-button" href="#" role="button" target="_blank"><i class="bi bi-printer"></i> Print</a> --}}
                    <div id="printButtonContainer"></div> <!-- Placeholder for the print button -->
                    <a class="main-btn" href="{{ route('tab-point-system.create-merit-demerit') }}"
                        role="button"><i class="bi bi-plus"></i> New
                        Merit/Demerit Form</a>
        
                </div>
        
                <div class="table-responsive">
                    <table id="meritdemeritTable" class="basic-border" style="width:100%">
                        <thead>
                            <tr>
                                <th>Engineer</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Points</th>
                                <th>Details</th>
                                <th>Author</th>
                                <th>Counter Explanation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($records))
                                @foreach ($records as $record)
                                    <tr class="clickable-row"
                                        data-href="{{ route('tab-point-system.edit') }}?id={{ $record->id }}">
                                        <td>{{ $record->engineer }}</td>
                                        <td>{{ $record->created_date }}</td>
                                        <td>{{ $record->status }}</td>
                                        <td>
                                            {{ $record->type == 1 ? 'Merit' : ($record->type == 0 ? 'Demerit' : 'Unknown Type') }}
                                        </td>
                                        <td>{{ $record->points }}</td>
                                        <td class="truncate">{{strip_tags($record->details) }}</td>
                                        <td>{{ $record->author }}</td>
                                        <td class="truncate">{{ $record->defense }}</td>
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Include your script.js file -->
    <script src="{{ asset('assets/tab-point-system/point_system_script.js') }}"></script>

    <!-- DataTables Buttons Extension -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
