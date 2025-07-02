@extends('layouts.base')
@section('content')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Include DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include your custom CSS -->
    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/tab-report/report.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/Modal/modal.css') }}" rel="stylesheet">

    <div id="loading-overlay" style="display:none;">
        <div class="spinner"></div>
    </div>

    <p class="title-text"><i class="bi bi-bar-chart-line-fill" style="color: #e83e8c"></i> Report Analysis</p>
    
    <p>Filter by Date, Project Category & Engineers:</p>
    <div class="d-flex align-items-center" style="gap: 1rem; margin-bottom: 1rem;">
        <div class="d-flex align-items-center">
            <label class="pe-2"><b>From:</b></label>
            <input type="date" class="form-control startDate" name="StartDate" id="startDate" required />
        </div>

        <div class="d-flex align-items-center">
            <label class="pe-2"><b>To:</b></label>
            <input type="date" class="form-control endDate" name="EndDate" id="endDate" required />
        </div>

        <div class="d-flex align-items-center" id="projectcatDropdownContainer">
            <label class="pe-2"><b>Project Category:</b></label>
            <select class="form-control form-select projcategory" id="projectcategorydropdown" required>
                <option value="" disabled>--Select Option--</option>
                <option value="DigiKnow">DigiKnow</option>
                <option value="DigiKnow Per Engineer">DigiKnow Per Engineer</option>
                <option value="DigiKnow Per Product Line">DigiKnow Per Product Line</option>
                {{-- <option value="Maintain Projects">Maintain Projects</option> --}}
                {{-- <option value="Ongoing Projects">Ongoing Projects</option> --}}
                <option value="Project Progress Report">Project Progress Report</option>
                <option value="Solution Center">Solution Center</option>
                <option value="Solution Center per Product Line">Solution Center per Product Line</option>
                <option value="sTraCert">sTraCert</option>
                <option value="Compiled Reports">Compiled Reports</option>
            </select>
        </div>


        <div class="d-flex align-items-center engineer-input-container" id="engineerDropdownContainer">
            <label class="pe-2"><b>Engineer(s):</b></label>
            <select class="form-control" id="engineername" name="engineers[]"></select>
        </div>

        <div class="d-flex align-items-center" id="filterContainer">
            <button type="submit" name="search" class="find-btn d-flex align-items-center" id="filterButton"
                style="gap: 0.5rem">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter</span>
            </button>

            <div id="loading" style="display: none;">
                <div class="spinner-border text-dark" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>


    <!-- Click DataTable Row Modal -->
    <div class="modal fade" id="edit_datatable_row" tabindex="-1" aria-labelledby="edit_datatable_row" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="edit_datatable_row"><i class="bi bi-plus"></i> Project/Opportunity
                        Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card" id="">
                        <div class="card-header">
                            Edit Project
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 align-items-center gap-2 mb-2">
                                    <label for="project_code" class="form-label">Project Code</label>
                                    <input type="text" class="form-control" id="project_code" value="" required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="project_name" class="form-label">Project Name:</label>
                                    <input type="text" class="form-control" id="project_name" value="" required
                                        readonly>
                                </div>
                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="validationServer10" class="form-label">Date Filed:</label>
                                    <input type="date" class="form-control" id="date_filed" value="" required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="business_unit" class="form-label">Business Unit:</label>
                                    <input type="text" class="form-control" id="business_unit" value=""
                                        required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="product_line" class="form-label">Product Line:</label>
                                    <input type="text" class="form-control" id="product_line" value=""
                                        required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="serv_category" class="form-label">Service Category:</label>
                                    <input type="text" class="form-control" id="serv_category" value=""
                                        required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="orig_receipt" class="form-label">OR:</label>
                                    <input type="text" class="form-control" id="orig_receipt" value=""
                                        required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="inv" class="form-label">INV:</label>
                                    <input type="text" class="form-control" id="inv" value="" required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="mbs" class="form-label">MBS:</label>
                                    <input type="text" class="form-control" id="mbs" value="" required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="po" class="form-label">PO:</label>
                                    <input type="text" class="form-control" id="po" value="" required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="so" class="form-label">SO:</label>
                                    <input type="text" class="form-control" id="so" value="" required>
                                </div>


                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="ft" class="form-label">FT:</label>
                                    <input type="text" class="form-control" id="ft" value="" required>
                                </div>


                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="start_date" class="form-label">Start Date:</label>
                                    <input type="date" class="form-control" id="start_date" value="" required>
                                </div>



                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="end_date" class="form-label">End Date:</label>
                                    <input type="date" class="form-control" id="end_date" value="" required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="proj_amount" class="form-label">Project Amount:</label>
                                    <input type="text" class="form-control" id="proj_amount" value="" required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="completed" class="form-label">Completed:</label>
                                    <input type="text" class="form-control" id="completed" value="" required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="reseller" class="form-label">Reseller:</label>
                                    <input type="text" class="form-control" id="reseller" value="" required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="end_user" class="form-label">End User:</label>
                                    <input type="text" class="form-control" id="end_user" value="" required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="proj_manday" class="form-label">Project Manday:</label>
                                    <input type="text" class="form-control" id="proj_manday" value="" required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="financial_status" class="form-label">Financial Status:</label>
                                    <input type="text" class="form-control" id="financial_status" value=""
                                        required>
                                </div>

                                <div class="col-md-4  align-items-center gap-2 mb-2">
                                    <label for="sign-off_status" class="form-label">Sign-off Status:</label>
                                    <input type="text" class="form-control" id="sign-off_status" value=""
                                        required>
                                </div>

                                <div class="col-md-12  align-items-center gap-2 mb-2">
                                    <label for="special_instruction" class="form-label">Special Instruction:</label>
                                    <textarea class="form-control" id="special_instruction" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2" id="EngrMandayForm">
                        <div class="card-header">
                            Engineer
                        </div>
                        <div class="card-body">
                            <div id="engineerInputsContainer" class="row">
                                <!-- Dynamic engineer name fields will be appended here -->
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Edit</button>
                        <button type="button" class="btn btn-success">Save changes</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="datatable_custom_style">
        <div class="datatable_custom_borderbox">
           
            {{-- <div class="row mt-4  cancel justify-content-start d-flex gap-2 mb-3">
                <a class="btn btn-primary" href="#" id="newproj_opportunity" style="width: fit-content"
                    role="button">New Project/Opportunity</a>
            </div> --}}

            <div class="table-responsive">
                <table id="project-table" class="basic-border" style="width:100%">

                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Project Name</th>
                            <th>Reference #</th>
                            <th>Engineer</th>
                            <th>Time Expected</th>
                            <th>From</th>
                            <th>To</th>

                            <th>Category</th>
                            <th>Activity Details</th>
                            <th>Program</th>
                            <th>Product Line</th>
                            <th>Product Code</th>
                            <th>Reseller</th>
                            <th>Reseller Contact</th>

                            <th>Reseller Email/Phone</th>
                            <th>EndUser</th>
                            <th>EndUser Contact</th>
                            <th>EndUser Location</th>
                            <th>EndUser Email/Phone</th>
                            <th>Customer Requirements</th>
                            <th>Participants & Position</th>

                            <th>Activity Done</th>
                            <th>Agreements</th>
                            <th>Target Date</th>
                            <th>Plan Details</th>
                            <th>Owner</th>
                            <th>Activity Type</th>
                            <th>Exam Title</th>

                            <th>Exam Name</th>
                            <th>Exam Take Status</th>
                            <th>Exam Score</th>
                            <th>Exam Type</th>
                            <th>Incentive Details</th>
                            <th>Incentive Amount</th>
                            <th>Incentive Status</th>

                            <th>Technology/Product Learned</th>
                            <th>Training Name</th> <!-- ar_trainingName -->
                            <th>Location</th> <!-- ar_location -->
                            <th>Speaker</th> <!-- ar_speakers -->
                            <th>MSI Project Name</th> <!-- ar_projName -->
                            <th>Compliance Percentage</th> <!-- ar_compPercent -->
                            <th>Perfect Attendance</th> <!-- ar_perfectAtt -->

                            <th>Memo Details</th> <!-- ar_memoDetails -->
                            <th>Memo Issued Date</th> <!-- ar_memoIssued -->
                            <th>Feedback on Engineer</th> <!-- ar_feedbackEngr -->
                            <th>Feedback Rating</th> <!-- ar_rating -->
                            <th>Product Model (POC)</th> <!-- ar_POCproductModel -->
                            <th>Asset/Code (POC)</th> <!-- ar_POCassetOrCode -->
                            <th>Start Date (POC)</th> <!-- ar_POCdateStart -->

                            <th>End Date (POC)</th> <!-- ar_POCdateEnd -->
                            <th>Topic (sTraCert)</th> <!-- ar_topic -->
                            <th>Start Date (sTraCert)</th> <!-- ar_dateStart -->
                            <th>End Date (sTraCert)</th> <!-- ar_dateEnd -->
                            <th>Venue</th> <!-- ar_venue -->
                            <th>Creator</th> <!--ar_requester -->
                            <th>Project Code</th> <!-- ar_project -->

                            <th>Status</th> <!-- status -->
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('Modal.activity-report-modal')


    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Include DataTables Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- DataTables Buttons Extension -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <!-- Include your script.js file -->

    <script src="{{ asset('assets/tab-report/reportscript.js') }}"></script>

    <script src="{{ asset('assets/tab-report/compiledreport.js') }}"></script>
    <script src="{{ asset('assets/Modal/modal.js') }}"></script>
    <script src="{{ asset('assets/tab-activity/act-report-form-script.js') }}"></script>
    <script src="{{ asset('assets/template/forward.js') }}"></script>
@endsection
