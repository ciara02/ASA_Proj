@extends('layouts.base')
@section('content')
@include('tab-isupport-service.implementation.implementation-modal')
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
    <link href="{{ asset('assets/tab-isupport-service/implementation-maintenance.css') }}" rel="stylesheet">

    <div class="">

        <div class="mx-auto" style="width:100%">
            @if (session()->has('success'))
                <div class="custom-alert">
                    <span class="closebtnnotif" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong>Success!</strong> New Project created successfully
                </div>
            @endif
        </div>

        <div id="loadingOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); text-align:center;">
                <div class="spinner-border2" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
        

        <div id="loading-overlay" style="display:none;">
            <div class="spinner"></div>
        </div>

        <p class="title-text"><i class="bi bi-inboxes-fill" style="color: #dc3545"></i> Maintenance Agreement</p>

        <p>Filter by Type & Status:</p>
        <div class="d-flex align-items-center" style="gap: 1rem; margin-bottom: 1rem;">
            <div class="d-flex align-items-center">
                <label class="pe-2 mb-0" style="white-space: nowrap;"><b>Select Status</b></label>
                <select class="form-control form-select" name="Status" id="status">
                    <option value="All">All</option>
                    <option value="Completed">Completed</option>
                    <option value="On Going">On Going</option>
                </select>
            </div>
        </div>

        <div class="datatable_custom_style">
            <div class="datatable_custom_borderbox">
                <div class="table-btn-container d-flex justify-content-start gap-2">
                    <div id="printButtonContainer" class="dt-buttons"></div>
                    {{-- <a class="btn btn-success" href="{{ route('tab-isupport-service.maintenance-agreement.print') }}" role="button" target="_blank">Print</a> --}}
                    <a class="main-btn" href="{{ route('tab-isupport-service.maintenance-agreement.create') }}" role="button"><i class="bi bi-plus-lg"></i> New
                        Project/Opportunity</a>

                    @if(Route::currentRouteName() === 'tab-isupport-service.maintenance-agreement.index' && $isAllowedToEdit)     
                    <div class="vr"></div>

                    <button type="button" class="btn btn-danger softdelete-button" disabled><i
                        class="bi bi-trash"></i> Remove</button>
                    @endif
                </div>
                    <table id="implementation-datatable" class="basic-border" >
                        <thead>
                            <tr>
                                @if(Route::currentRouteName() === 'tab-isupport-service.maintenance-agreement.index' && $isAllowedToEdit)
                               <th style="text-align: center; vertical-align: middle;">
                                <input type="checkbox" id="selectAll"></th>
                                @endif
                                <th>Project Code</th>
                                <th>Project Name</th>
                                <th>Date Filed</th>
                                <th>Business Unit</th>
                                <th>Product Line</th>
                                <th>Service Category</th>
                                <th>OR</th>
                                <th>INV</th>
                                <th>MBS</th>
                                <th>PO</th>
                                <th>SO</th>
                                <th>FT</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Project Amount</th>
                                <th>Completed</th>
                                <th>Reseller</th>
                                <th>End User</th>
                                <th>Project Manday</th>
                                <th>Finance Status</th>
                                <th>Manday Used</th>
                                <th>Doer & Engineers</th>
                                <th>Sign-off Status</th>
                                <th>Special Instruction</th>
                                <th class="d-none">Id</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- table rows loops here --}}
                            @if (isset($implementationProjects))
                                @foreach ($implementationProjects as $project)
                                    <tr data-cashreqstatus="{{ optional($project->latest_cash_request_status)->status }}" data-createdby="{{$project->created_by}}" data-proj="{{$project->proj_code}}" data-id="@foreach($project->getTeamMember as $teamMemberID){{ $teamMemberID->project_id }}, @endforeach" data-type="{{optional($project->project_type)->name}}" data-manager="{{$project->PM}}" data-members="@foreach($project->getTeamMember as $teamMember){{ $teamMember->eng_name }}, @endforeach" data-value="{{optional($project->cashAdvance)->cash_advance .'|'. $project->rs_contact . '|' . $project->rs_email . '|' . $project->endUser . '|' . $project->eu_contact . '|' . $project->eu_email . '|' . $project->project_net . '|' . $project->manday_cost}}" data-euloc="{{$project->eu_location}}" data-attachments="@foreach($project->proj_attachments as $projAttachments){{ $projAttachments->attachment }}, @endforeach" data-signoffattachments="@foreach ($project->signOff_attachments as $signOffAttachments){{ $signOffAttachments->attachment }}, @endforeach"  data-cashadvanceattachments="@foreach ($project->cashAdvance_attachments as $cashAttachments){{ $cashAttachments->attachment_file }}, @endforeach">
                                        @if(Route::currentRouteName() === 'tab-isupport-service.maintenance-agreement.index' && $isAllowedToEdit)
                                       <td style="text-align: center; vertical-align: middle;"><input type="checkbox" class="row-checkbox" data-id="{{ $project->id }}"></td>
                                        @endif
                                        <td class="proj_code">{{ $project->proj_code }}</td>
                                        <td class="proj_name truncate">{{ $project->proj_name }}</td>
                                        <td class="created_date">{{ $project->created_date }}</td>
                                        <td class="business_unit">{{ $project->business_unit}}</td>
                                        <td class="prod_Line">{{ $project->product_line }}</td>
                                        <td class="service_category">{{ $project->service_category }}</td>
                                        <td class="or">{{ $project->original_receipt }}</td>
                                        <td class="inv">{{ $project->inv }}</td>
                                        <td class="mbs">{{ $project->mbs }}</td>
                                        <td class="po_number">{{ $project->po_number }}</td>
                                        <td class="so_number">{{ $project->so_number }}</td>
                                        <td class="ft_number">{{ $project->ft_number }}</td>
                                        <td class="proj_startDate">{{ $project->proj_startDate }}</td>
                                        <td class="proj_EndDate">{{ $project->proj_endDate }}</td>
                                        <td class="proj_amount">{{ number_format($project->proj_amount, 2) }}</td>
                                        <td class="status">{{ $project->status }}</td>
                                        <td class="reseller">{{ $project->reseller }}</td>
                                        <td class="end_user">{{ $project->endUser }}</td>
                                        <td class="manday">{{ $project->manday }}</td>
                                        <td class="financial_stat">{{ optional($project->financial_status)->payment_status }}</td>
                                        <td class="totalManday">
                                            @if ($project->doer_engineers && $project->doer_engineers->isNotEmpty())
                                            <div class="totalMandayUsed">
                                                <span class="totalmanday-count badge " style="color: black;">Loading..</span>
                                            </div>
                                            @else
                                                <span class="no-engineers">0</span>
                                            @endif
                                        </td>
                                        <td class="doer_eng truncate" data-project-id="{{ $project->id }}" 
                                            data-engineers="{{ $project->doer_engineers && $project->doer_engineers->isNotEmpty() 
                                            ? $project->doer_engineers->unique('eng_name')
                                                ->pluck('eng_name')
                                                ->filter(fn($name) => !empty($name)) 
                                                ->implode(',') 
                                            : '' }}">
                                            @if ($project->doer_engineers && $project->doer_engineers->isNotEmpty())
                                                <div class="engineer-list">
                                                    @foreach ($project->doer_engineers->unique('eng_name') as $engineer)
                                                        @if (!empty($engineer->eng_name)) 
                                                            <div class="eng-item">
                                                                <strong>{{ $engineer->eng_name }}</strong> - 
                                                                <span class="manday-count badge">Loading..</span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div> 
                                            @else
                                                <span class="no-engineers">No Doers/Engineers</span>
                                            @endif
                                        </td>
                                        <td class="signoff-status">{{ $project->signoff }}</td>
                                        <td class="special_ins truncate">
                                            {{-- Remove <br /> tags and replace them with a comma --}}
                                            {{ str_replace(['<br>', '<br/>', '<br />'], ', ', $project->special_instruction) }}
                                        </td> 
                                        <td class="d-none proj_id">{{ $project->id }}</td>
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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Include DataTables Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- Include your script.js file -->
    <script src="{{ asset('assets/tab-isupport-service/script.js') }}"></script>
    <script src="{{ asset('assets/Modal/implementation-modal.js') }}"></script>   
    <script src="{{ asset('assets/tab-isupport-service/act-report-form-script.js') }}"></script>
    <script src="{{ asset('assets/tab-isupport-service/act-report-modal.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

     <!-- Include DataTables Buttons Extension JavaScript -->
     <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>

@endsection
