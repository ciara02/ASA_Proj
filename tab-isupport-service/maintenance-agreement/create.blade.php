@extends('layouts.base')
@section('content')
    <link href="{{ asset('assets/tab-activity/newproj.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container">
        <p class="title mt-4 mb-4">Create New Project/Opportunity</p>

        <form id="projectCreate" method="POST" action="{{ route('tab-isupport-service.implementation.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header" style="background-color: #0056b3; color:white">
                    Add Project/Opportunity
                </div>

                <input type="hidden" id="status" name="status" value="On Going">
                <input type="hidden" id="email" name="email" value="{{ $ldapEngineer && $ldapEngineer->email ? $ldapEngineer->email : '' }}">
                <input type="hidden" id="created_date" name="created_date" value="{{ now()->format('Y-m-d') }}">

                <div class="card-body">
                    <div class="row" style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc">
                        <div class="col-md-4 d-flex flex-column gap-2 mb-2">
                            <label for="projectCode" class="form-label">Project Code:</label>
                            <div>
                                <select class="form-select" name="projectCode" id="projectCode" required>
                                    <option disabled selected value="">--Select Project Code--</option>
                                </select>
                                <div id="projectCodeError" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex flex-column gap-2 mb-2">
                            <label for="projectPeriodFrom" class="form-label">Project Period:</label>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <label for="projectPeriodFrom" class="form-label">From:</label>
                                <input type="date" name="projectPeriodFrom" id="projectPeriodFrom" class="form-control projectPeriodFrom" placeholder="mm/dd/yyyy">
                            </div>
                            <div class="d-flex align-items-center gap-4 ">
                                <label for="projectPeriodTo" class="form-label ">To:</label>
                                <input type="date" name="projectPeriodTo" id="projectPeriodTo" class="form-control projectPeriodTo" placeholder="mm/dd/yyyy">
                            </div>
                        </div>

                        <div class="col-md-4 d-flex flex-column gap-2 mb-2">
                            <label for="createdBy" class="form-label">Created By:</label>
                            <input type="text" name="createdBy_Input" id="createdBy" class="form-control" value="{{ $ldapEngineer && $ldapEngineer->fullName ? $ldapEngineer->fullName : '' }}" readonly>
                        </div>

                        <div class="col-md-4 d-flex flex-column gap-2 mb-2">
                            <label for="projectName" class="form-label">Project Name:</label>
                            <input type="text" name="projectName" id="projectName" class="form-control" aria-describedby="projectName" value="" required>
                            <div id="projectNameError" class="text-danger"></div>
                        </div>

                        <div class="col-md-4 d-flex flex-column gap-2 mb-2">
                            <label for="serviceCategory" class="form-label">Service Category:</label>
                            <div>
                                <select class="form-select" name="serviceCategory" id="serviceCategory" aria-describedby="serviceCategory" required>
                                    <option disabled selected value="">--Select Service Category--</option>
                                    <option value="Bundled">Bundled</option>
                                    <option value="Direct to iSupport">Direct to iSupport</option>
                                </select>
                                <div id="serviceCategoryError" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex flex-column gap-2 mb-2">
                            <label for="projectManager" class="form-label">Project Manager:</label>
                            <div>
                                <select name="projectManager" id="projectManager" class="form-control">
                                    <option disabled selected value="">--Select Project Manager--</option>
                                </select>
                                <div id="projectManagerError" class="text-danger"></div>
                            </div>
                        <input type="hidden" id="pm_email" name="pm_email" value="">
                        </div>

                        <div class="col-md-4 d-flex flex-column gap-2 mb-2">
                            <label for="addMember" class="form-label col-md-5">Team Member/s: <small style="color:rgb(142, 142, 142);"></small></label>
                            <select class="form-control" id="engineers" name="engineers[]" multiple="multiple" required>
                            </select>
                        </div>
                        <input type="hidden" id="tm_email" name="tm_email[]" value="">
                        <input type="hidden" id="created_dateTM" name="created_dateTM[]" value="{{ now()->format('Y-m-d') }}">



                        <div class="col-md-4 d-flex flex-column gap-2 mb-2">
                            <label for="projectType" class="form-label">Project Types:</label>
                            <div>
                                <select class="form-select" name="projectType" id="projectType" aria-describedby="projectType" required>
                                    <option disabled selected value="">--Select Project Type--</option>
                                    <option value="1">Implementation</option>
                                    <option value="2">Maintenance Agreement</option>
                                </select>
                                <div id="projectTypeError" class="text-danger"></div>
                            </div>
                        </div>

                    </div>

                    <div class="row" style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc">
                        <div class="col-md-4  align-items-center gap-2">
                            <label for="businessUnit" class="form-label">Business Unit:</label>
                            <select name="businessUnit" id="businessUnit" class="form-select">
                                <option disabled selected value="">--Select Business Unit Category--</option>
                            </select>
                        </div>
                        <div class="col-md-4  align-items-center gap-2">
                            <label for="or" class="form-label">OR:</label>
                            <input type="text" name="or" id="or" class="form-control" placeholder="Input OR">
                        </div>
                        <div class="col-md-4  align-items-center gap-2">
                            <label for="inv" class="form-label">INV:</label>
                            <input type="text" name="inv" id="inv" class="form-control" placeholder="Input INV">
                        </div>

                        <div class="col-md-4  align-items-center gap-2">
                            <label for="productLine" class="form-label">Product Line:</label>
                            <select name="productLine" id="productLine" class="form-select">
                                <option disabled selected>--Select Product Line Category--</option>
                            </select>
                        </div>
                        <input type="hidden" id="iSupport_product" name="iSupport_product_input" >

                        <div class="col-md-4  align-items-center gap-2">
                            <label for="mbs" class="form-label">MBS:</label>
                            <input type="text" name="mbs" id="mbs" class="form-control" placeholder="Input MBS">
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc">
                        <div class="col-md-4  align-items-center gap-2">
                            <label for="projectMandays" class="form-label">Project Manday/s:</label>
                            <input type="number" name="projectMandays" id="projectMandays" class="form-control" placeholder="How many manday/s?" required>
                        </div>
                        <div class="col-md-4  align-items-center gap-2">
                            <label for="projectAmountGross" class="form-label">Project Amount (Gross):</label>
                            <input type="number" name="projectAmountGross" id="projectAmountGross" class="form-control" placeholder="iSupport Revenue only." value="" required>
                        </div>
                        <div class="col-md-4 align-items-center gap-2">
                            <label for="poNumber" class="form-label">PO #:</label>
                            <input type="text" name="poNumber" id="poNumber" class="form-control" value="" placeholder="Input PO number" required>
                        </div>

                        <div class="col-md-4  align-items-center gap-2">
                            <label for="perMondayCost" class="form-label">Per Manday's Cost:</label>
                            <input type="number" name="perMondayCost" id="perMondayCost" class="form-control" readonly>
                        </div>
                        <div class="col-md-4  align-items-center gap-2">
                            <label for="projectAmountNet" class="form-label">Project Amount (Net):</label>
                            <input type="number" name="projectAmountNet" id="projectAmountNet" class="form-control" readonly>
                        </div>
                        <div class="col-md-4  align-items-center gap-2">
                            <label for="soNumber" class="form-label">SO #:</label>
                            <input type="text" name="soNumber" id="soNumber" class="form-control" value="" placeholder="Input SO number" required>
                        </div>

                        <div class="col-md-4 align-items-center gap-2">
                            <label for="mondayUsed" class="form-label">Manday/s Used:</label>
                            <input type="text" name="mondayUsed" id="mondayUsed" class="form-control" disabled placeholder="Total Manday used">
                        </div>
                        <div class="col-md-4 align-items-center gap-2">
                            <label for="cashAdvance" class="form-label">Cash Advance:</label>
                            <input type="number" name="cashAdvance" id="cashAdvance" placeholder="0" class="form-control" ddata-toggle="tooltip" data-placement="top" title="Please enter a whole number (no decimal values allowed).">
                        </div>
                        <div class="col-md-4 align-items-center gap-2">
                            <label for="ftNumber" class="form-label">FT #:</label>
                            <input type="text" name="ftNumber" id="ftNumber" class="form-control" placeholder="Input FT number">
                        </div>
                    </div>

                    <div class="mb-3" style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc">
                        <div class="form-group">
                            <label for="specialInstruction">Special Instruction:</label>
                            <textarea class="form-control" name="specialInstruction" id="specialInstruction" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc">
                        <div class="col-md-4  align-items-center gap-2">
                            <label for="resellers" class="form-label">Resellers:</label>
                            <input type="text" name="resellers" id="resellers" class="form-control">
                        </div>
                        <div class="col-md-4  align-items-center gap-2">
                            <label for="resellers Contact" class="form-label">Resellers Contact:</label>
                            <input type="text" name="resellers_Contact" id="resellers Contact" class="form-control">
                        </div>
                        <div class="col-md-4  align-items-center gap-2">
                            <label for="resellerPhoneEmail" class="form-label">Phone/Email:</label>
                            <input type="text" name="resellerPhoneEmail" id="resellerPhoneEmail" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 align-items-center gap-2">
                            <label for="endUser" class="form-label">End User:</label>
                            <input type="text" name="endUser" id="endUser" class="form-control" placeholder="MSI if Internal Project">
                        </div>
                        <div class="col-md-4 d-flex flex-column gap-2">
                            <div class=" align-items-center gap-2 mb-3">
                            <label for="endUserContactNumber" class="form-label">End User Contact #:</label>
                            <input type="text" name="endUserContactNumber" id="endUserContactNumber" class="form-control">
                            </div>
                            <div class=" align-items-center gap-2 mb-3">
                            <label for="endUserLocation" class="form-label">End User Location:</label>
                            <input type="text" name="endUserLocation" id="endUserLocation" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4  align-items-center gap-2">
                            <label for="endUserPhoneEmail" class="form-label">Phone/Email:</label>
                            <input type="text" name="endUserPhoneEmail" id="endUserPhoneEmail" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="implementationSupportingDocument" class="form-label">Attach Supporting Documents Here:</label>
                    <input class="form-control" type="file" name="implementationSupportingDocument[]" id="implementationSupportingDocument" multiple>
                </div>
            </div>

            <div class="row mt-3 cancel justify-content-center d-flex gap-2">
                <a class="btn btn-danger" style="width: fit-content" type="button" href="{{route('tab-isupport-service.maintenance-agreement.index')}}">Cancel</a>
                <button class="btn btn-primary" style="width: fit-content" id="save" type="submit">Submit form</button>
            </div>
        </form>
    </div>

    <!-- Include jQuery before other scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Include DataTables Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets/tab-isupport-service/script.js') }}"></script>
@endsection
