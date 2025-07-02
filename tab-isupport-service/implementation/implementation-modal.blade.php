<!-- Modal -->
<div class="modal fade" id="implementation-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form id="implement_maintain" action="" method="POST">
            @csrf
            <div class="modal-content ">
                <div class="modal-header align-items-start justify-content-between">
                    <div>
                        <img src="{{ asset('assets/img/official-logo.png') }}" class="vst-logo">
                    </div>
                    <div class="card card-custom">
                        <div class = "row ">
                            <div class=" d-flex align-items-center mb-2 mt-2 gap-2">
                                <label for="reportDropdown" class="mb-4"><strong>Report: </strong><span
                                        id="report_text">Project</span></label>
                            </div>

                            <div class=" d-flex align-items-center gap-2">
                                <label for="projectTypesDropdown" class="mb-4"><strong>Project Type: </strong><span
                                        id="project_type"></span></label>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header" style="background-color: #0056b3; color:white">
                            <b> <i class="bi bi-file-text"></i> Activity Details</b>
                        </div>
                        <div class="card-body">
                            <div class="row"
                                style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc">
                                <div class="col-md-4 d-flex align-items-center gap-2 ">
                                    <label for="projectCode" class="form-label">Project Code:</label>
                                    <select class="form-select" name="projectCode" id="projectCode" class="form-control"
                                        required>
                                        <option disabled selected value="">--Select Project Code--</option>
                                    </select>
                                    <input type="hidden" name="projectsignoff_id" id="projectsignoff_id">
                                </div>

                                <div class="col-md-4 d-flex flex-column gap-2 mb-2">
                                    <label for="projectPeriodFrom" class="form-label">Project Period:</label>
                                    <div class="d-flex align-items-center mb-3">
                                        <label for="projectPeriodFrom" class="form-label col-md-2">From:</label>
                                        <input type="date" name="projectPeriodFrom" id="projectPeriodFrom" min="2023-01-01" placeholder="mm/dd/yyyy"
                                            class="form-control projectPeriodFrom">
                                    </div>
                                    <div class="d-flex align-items-center ">
                                        <label for="projectPeriodTo" class="form-label col-md-2">To:</label>
                                        <input type="date" name="projectPeriodTo" id="projectPeriodTo" min="2023-01-01" placeholder="mm/dd/yyyy"
                                            class="form-control projectPeriodTo">
                                    </div>
                                </div>
                                <input type="hidden" id="created_date" name="created_date" >

                                <div class="col-md-4 d-flex align-items-center">
                                    <label for="createdBy" class="form-label col-md-3">Created By:</label>
                                    <input type="text" name="createdBy_Input" id="createdBy" class="form-control"
                                        readonly>
                                </div>

                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="productTypes" class="form-label">Project Name:</label>
                                    <input type="text" name="projectName" id="projectName" class="form-control"
                                        aria-describedby="projectName" value="" required>
                                </div>

                                <div class="col-md-4 d-flex align-items-center gap-1">
                                    <label for="serviceCategory" class="form-label col-md-2">Service Category:</label>
                                    <select class="form-select" name="serviceCategory" id="serviceCategory"
                                        aria-describedby="serviceCategory" value="" required>
                                        <option disabled selected value="">--Select Service Category--</option>
                                        <option value="Bundled">Bundled</option>
                                        <option value="Direct to iSupport">Direct to iSupport</option>
                                    </select>
                                </div>

                                <div class="col-md-4 d-flex flex-column ">
                                    <div class="col d-flex align-items-center mb-4">
                                        <label for="projectManager" class="form-label col-md-3 ">Project
                                            Manager:</label>
                                        <select type="text" name="projectManager" id="projectManager"
                                            class="form-control" required>
                                            <option disabled selected value="">--Select Project Manager--</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="pm_email" name="pm_email" value="">

                                    <div class="col d-flex align-items-center ">
                                        <label for="addMember" class="form-label col-md-3">Team Member/s: <small
                                                style="color:rgb(142, 142, 142);"><i>(Select
                                                    Engineers)</i></small></label>
                                        <select class="form-control" id="engineers" name="engineers[]"
                                            multiple="multiple">
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="projectType" class="form-label">Project Types:</label>
                                    <select class="form-select" name="projectType" id="projectType"
                                        aria-describedby="projectType">
                                        <option disabled selected value="">--Select Project Type--</option>
                                        <option value="1">Implementation</option>
                                        <option value="2">Maintenance Agreement</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row"
                                style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc">
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="businessUnit" class="form-label">Business Unit:</label>
                                    <select name="businessUnit" id="businessUnit" class="form-select">
                                        <option disabled selected value="">--Select Business Unit Category--
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="or" class="form-label">OR:</label>
                                    <input type="text" name="or" id="or" class="form-control"
                                        placeholder="Input OR">
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="inv" class="form-label">INV:</label>
                                    <input type="text" name="inv" id="inv" class="form-control"
                                        placeholder="Input INV">
                                </div>

                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="productLine" class="form-label">Product Line:</label>
                                    <select name="productLine" id="productLine" class="form-select">
                                        <option disabled selected>--Select Product Line Category--</option>
                                    </select>
                                </div>
                                <input type="hidden" id="iSupport_product" name="iSupport_product_input">

                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="mbs" class="form-label">MBS:</label>
                                    <input type="text" name="mbs" id="mbs" class="form-control"
                                        placeholder="Input MBS">
                                </div>
                            </div>

                            <div class="row"
                                style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc">
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="projectMandays" class="form-label">Project Manday/s:</label>
                                    <input type="text" name="projectMandays" id="projectMandays"
                                        class="form-control" placeholder="How many manday/s?" disabled>
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="projectAmountGross" class="form-label">Project Amount (Gross):</label>
                                    <input type="text" name="projectAmountGross" id="projectAmountGross"
                                        class="form-control" placeholder="iSupport Revenue only." value=""
                                        required>
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="poNumber" class="form-label">PO #:</label>
                                    <input type="text" name="poNumber" id="poNumber" class="form-control"
                                        value="" placeholder="Input PO number" required>
                                </div>

                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="perMondayCost" class="form-label">Per Manday's Cost:</label>
                                    <input type="text" name="perMondayCost" id="perMondayCost" value="0"
                                        class="form-control" disabled>
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="projectAmountNet" class="form-label">Project Amount (Net):</label>
                                    <input type="text" name="projectAmountNet" id="projectAmountNet"
                                        value="0" class="form-control" disabled>
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="soNumber" class="form-label">SO #:</label>
                                    <input type="text" name="soNumber" id="soNumber" class="form-control"
                                        value="" placeholder="Input SO number" required>
                                </div>

                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="mondayUsed" class="form-label">Manday/s Used:</label>
                                    <input type="text" name="mondayUsed" id="mondayUsed" class="form-control"
                                        placeholder="Total manday used" disabled>
                                    <input type="hidden" name="projectId" id="projectID">
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="cashAdvance" class="form-label">Cash Advance:</label>
                                    <input type="number" name="cashAdvance" id="cashAdvance" value="0"
                                        class="form-control col">
                                        <button type="button" id="cashAdvanceReqBtn" class="btn btn-warning" disabled>
                                            <i class="bi bi-file-earmark-text"></i> Request 
                                          </button>
                                          
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="ftNumber" class="form-label">FT #:</label>
                                    <input type="text" name="ftNumber" id="ftNumber" class="form-control"
                                        placeholder="input FT number">
                                </div>
                            </div>

                            <div id="mandayrefCard">
                                <div class="row"
                                    style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc; text-align: center;">
                                    <div class="col-md-2 align-items-center gap-2">
                                        <label for="CashReqContainer" class="form-label">Cash Request/s Ref:</label>
                                        <div id="CashReqContainer" class="row"></div>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-stretch" style="width: 1px; padding: 0;">
                                        <div style="border-left: 1px solid #ccc; height: 100%;"></div>
                                    </div>

                                     <div class="col-md-2 align-items-center gap-2">
                                        <label for="businessUnit" class="form-label">Manday/s Ref:</label>
                                        <div id="mandayRefContainer" class="row"></div>
                                    </div>
                                    <div class="col align-items-center gap-2" style="text-align: center;">
                                        <label for="doer" class="form-label">Doer:</label>
                                        <div id="doerContainer" class="row"></div>
                                    </div>

                                    <div class="col align-items-center gap-2">
                                        <div class=" d-flex align-items-center gap-4">
                                            <label for="payment_stat" class="form-label col-md-5">Payment
                                                Status:</label>
                                            <label for="ref_date" class="form-label">Reference date:</label>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <select name="payment_stat" id="payment_stat" class="form-select"
                                                placeholder="">
                                                <option disabled selected>Select Option</option>
                                                <option>Billing Created-For Collection</option>
                                                <option>Bundled with Sales SO</option>
                                                <option>Full Payment Received</option>
                                                <option>For Fund Transfer</option>
                                                <option>FR/FT-SMM Approved</option>
                                                <option>FR/FT-In-Process</option>
                                                <option>FR/FT-System Posted</option>
                                                <option>Expense Paid</option>
                                                <option>Cancelled</option>
                                                <option>Problematic</option>
                                                <option>Down Payment Received</option>
                                            </select>
                                            <input type="date" name="ref_date" id="ref_date"
                                                class="form-control" placeholder="">
                                            {{-- <button type="button" id="payment" class="btn btn-success"><i
                                                    class="bi bi-floppy"></i></button> --}}
                                        </div>
                                        <p class="mt-2">Payment Status
                                            History</p>

                                        <div id="paymentStatusContainer" class="row"></div>
                                    </div>

                                </div>
                            </div>

                            <div class="mb-3"
                                style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc">
                                <div class="form-group">
                                    <label for="specialInstruction">Special Instruction:</label>
                                    <textarea class="form-control" name="specialInstruction" id="specialInstruction" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="row"
                                style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc">
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="resellers" class="form-label">Resellers:</label>
                                    <input type="text" name="resellers" id="resellers" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="resellers Contact" class="form-label">Resellers Contact:</label>
                                    <input type="text" name="resellers_Contact" id="resellers_Contact"
                                        class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="resellerPhoneEmail" class="form-label">Phone/Email:</label>
                                    <input type="text" name="resellerPhoneEmail" id="resellerPhoneEmail"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="endUser" class="form-label">End User:</label>
                                    <input type="text" name="endUser" id="endUser" class="form-control"
                                        placeholder="MSI if Internal Project">
                                </div>
                                <div class="col-md-4 d-flex flex-column gap-2">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <label for="endUserContactNumber" class="form-label">End User Contact
                                            #:</label>
                                        <input type="text" name="endUserContactNumber" id="endUserContactNumber"
                                            class="form-control">
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <label for="endUserContactNumber" class="form-label">End User Location:</label>
                                        <input type="text" name="endUserContactNumber" id="endUserLocation"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="endUserPhoneEmail" class="form-label">Phone/Email:</label>
                                    <input type="text" name="endUserPhoneEmail" id="endUserPhoneEmail"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" style="margin-left:5%;">
                        <div class="col-md-5">
                            <label for="implementationSupportingDocument" class="form-label"><strong>Supporting
                                    Documents: </strong></label>
                            <div id="implementAttachment"></div>
                        </div>

                         <div class="col-md-1 d-flex justify-content-center">
                            <div style="border-left: 1px solid #ccc; height: 100%;"></div>
                        </div>

                        <div class="col-md-5">
                            <label for="cashRequestUploadDocument" class="form-label"><strong>Cash Advance Request Attachment:</strong></label>
                            <div id="cashRequestUploadDocument"></div>
                        </div>
                    </div>
                    <div class="row" style="margin-left:5%;" id="signOffdocupload">
                        <div class="col-md-4 mt-3">
                            <label for="signOffSupportingDocument" class="form-label"><strong>Sign-off Attachment:</strong></label>
                            <div id="signOffSupportingDocument"></div>
                        </div>
                    </div>
            
                    <div class="row mt-3 justify-content-center mb-4">
                        <div class="col-md-6 text-center">
                            <label for="implementationSupportingDocument" class="form-label">
                            <strong>Attach Supporting Documents Here:</strong>
                            </label>

                            <div class="d-flex align-items-center justify-content-center">
                            <!-- File Input -->
                            <input class="form-control me-2" type="file" name="implementationSupportingDocument" id="implementationSupportingDocument" multiple>

                            <!-- Import Dropdown Button -->
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="importDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Import Type
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="importDropdown">
                                <li><a class="dropdown-item" href="#" id="UploadFileIsupport">Supporting Document</a></li>
                                <li><a class="dropdown-item" href="#" id="CashAdvanceAttachment">Cash Advance Request</a></li>
                                </ul>
                            </div>

                            <!-- Spinner -->
                            <span id="spinner" class="spinner-border spinner-border-sm text-dark ms-2" style="display:none;"></span>
                            </div>
                        </div>
                    </div>
                    

                </div>
                <div class="d-flex justify-content-center gap-2 mb-4">
                    <button type="button" class="btn btn-primary" id="edit_button">Edit</button>

                    <button type="button" id="proj_completedBtn" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#completeOption">Project Completed</button>

                    <button type="button" class="btn btn-warning" id="proj_signOffBtn">View Project Signoff</button>
                    <button type="button" class="btn btn-secondary"id="backBtn"
                        data-bs-dismiss="modal">Back</button>
                    <button type="button" class="btn btn-success" id="saveBtn">Save</button>
                </div>
                <div class="modal-footer justify-content-center">
                    <p class="text-center">
                        © 2024 Copyright VST ECS Phils., Inc. All rights reserved.
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Second Modal -->
<div class="modal fade" id="completeOption" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Project Completed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-6">
                            <div class="project-completion-option" id="uploadSignoffBtn">
                                <img class="mb-2" src="{{ asset('assets/img/upload.svg') }}" height="50" />
                                <div class="mb-2">Upload Project Signoff Document</div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="upload_button"  
                                data-bs-target="#uploadSignOffFile">Upload</button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="project-completion-option" id="createSignoffBtn"></div>
                            <img class="mb-2" src="{{ asset('assets/img/create.svg') }}" height="50" />
                            <div class="mb-2">Create Project Signoff Document</div>

                            <button type="button" id="create_button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#signoffForm">Create</button>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Create Signoff Document Modal -->
<div class="modal fade" id="signoffForm" tabindex="-1" aria-labelledby="signoffFormLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70vw;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signoffFormLabel">Create Project Signoff Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                <div class="row">
                    <input type="hidden" name="txtProjectId" value="" />
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><b>Project</b></span>
                            <input class="form-control" type="text" name="txtProject" id="completion_proj"
                                placeholder="Required." disabled value="" />
                            <input type="hidden" id="Projectlist_id" name="Projectlist_id">
                            <input type="hidden" id="CreatedDate" name="CreatedDate">
                            <input type="hidden" id="time" name="time">
                            <input type="hidden" id="completionApprovalRoute"
                                value="{{ route('completion.acceptance.approval') }}">

                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><b>Reseller:</b></span>
                            <input class="form-control" type="text" name="txtReseller" id="completion_reseller"
                                placeholder="Reseller" disabled value="" />
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><b>End User</b></span>
                            <input class="form-control" type="text" name="txtEndUser" id="completion_enduser"
                                placeholder="End User" disabled value="" />
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="txtDeliverables">Deliverables</label>
                            <textarea class="form-control" id="txtDeliverables" name="txtDeliverables" rows="10"></textarea>
                        </div>
                        {{-- <div id="txtDeliverablesError" class="text-danger"></div> --}}
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="attachments">Attachments</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="file" name="attachments[]" class="form-control" id="attachments"
                                        multiple />
                                </div>
                                <div class="col-md-6">
                                    <button type="button" id="UploadFile" class="btn btn-info">Import</button>
                                    <span id="spinner" class="spinner-border spinner-border-sm text-dark"
                                        style="display:none;"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Approvers -->
                    <div class="col-md-12 mb-3">
                        <label>Approvers</label>
                        <div class="divApprovers" id="divApprovers">
                            <div class="cloned-fields d-flex align-items-center mb-2">
                                <input id="txtCompany" type="text" class="form-control me-2" name="txtCompany[]"
                                    placeholder="Company" />
                                <input id="txtApprover" type="text" class="form-control me-2" name="txtApprover[]"
                                    placeholder="Name" />
                                <input id="txtPositions" type="text" class="form-control me-2" name="txtPositions[]"
                                    placeholder="Position" />
                                <input id="txtEmail" type="email" class="form-control me-2" name="txtEmail[]"
                                    placeholder="Email Address" />
                                <button type="button" class="btn btn-sm btn-danger me-2 remove-field"><i
                                        class="bi bi-dash"></i></button>
                                <button type="button" class="btn btn-sm btn-success add-field"><i
                                        class="bi bi-plus"></i></button>
                            </div>
                        </div>
                        {{-- <div id="divApproversError" class="text-danger"></div> --}}
                    </div>
                    <!-- Approvers -->
                </div>
            </div>

            <div class="modal-footer">
                <div class="col text-center">
                    <button type="button" class="btn btn-danger" id="cancelProjectSignoffDocument" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="ProjectSave" class="btn btn-success">Save</button>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="uploadSignOffFile">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Project Signoff Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm">
                    <div class="mb-3">
                        <label for="signoffFile" class="form-label">Select file to upload:</label>
                        <input type="file" class="form-control" id="signoffFile" name="signoffFile" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="uploadSignOffDocButton">Upload</button>
                <span id="spinner2" class="spinner-border spinner-border-sm text-dark ms-2" style="display:none;"></span>
            </div>
        </div>
    </div>
</div>