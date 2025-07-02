<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Sign-Off View</title>

    <link href="{{ asset('assets/tab-isupport-service/implementation-maintenance.css') }}" rel="stylesheet">

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>


    <div id="loading-overlay" style="display:none;">
        <div class="spinner"></div>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="mt-2 ps-2">
                    <p class="reportstatus" id="completionstatus" style="display: flex; align-items: center;">
                        Status: <span class="status" id="projstatus" name="status">{{ $Getprojects[0]->status }}</span>
                    </p>
                </div>

                <!-- Project Sign-off Card -->
                <div class="card mb-4">
                    <div class="card-header text-center" style="background-color: #0056b3; color: white;">
                        <h8><b>Project Sign-off</b></h5>
                    </div>
                    <div class="card-body">
                        <input type="hidden" autocomplete="off" class="form-control" name="txtProjectId" disabled
                            value="" />
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Created
                                                By:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="createdby_approval" name="txtCreatedBy"
                                        value="{{ $Getprojects[0]->created_by }}" disabled />
                                    <input type="hidden" name="projectlist_id" id="projectlist_id"
                                        value="{{ $Getprojects[0]->id }}">
                                    <input type="hidden" id="CreatedDate" name="CreatedDate">
                                    <input type="hidden" id="time" name="time">
                                </div>

                            </div>
                            <div class="col-md-6 mb-3">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Date
                                                Created:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="createddate_approval" name="txtDateCreated"
                                        value="{{ $Getprojects[0]->created_date }}" disabled />
                                </div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 mb-3">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Project Title
                                                :</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="projtitle_approval" name="txtProjectTitle" disabled
                                        value="{{ $Getprojects[0]->proj_name }}" />
                                </div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Reseller
                                                :</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control" id="reseller_approval"
                                        name="txtReseller" value="{{ $Getprojects[0]->reseller }}" disabled />
                                </div>

                            </div>
                            <div class="col-md-6 mb-3">

                                <div class="input-group">
                                    <span class="input-group-text"style="font-size: 14px;"><b><i>End
                                                User:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id = "enduser_approval" name="txtEndUser" disabled
                                        value="{{ $Getprojects[0]->endUser }}" />
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Project Sign-off Card -->

                <!-- Deliverables Card -->
                <div class="card mb-4">
                    <div class="card-header text-center" style="background-color: #0056b3; color: white;">
                        <h8><b>Deliverables</b></h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">

                            <div class="col-12 border p-3">
                                <textarea class="form-control" id="txtDeliverables" name="txtDeliverables" rows="5"
                                    required autocomplete="off" disabled>{{ $Getprojects[0]->deliverables }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Deliverables Card -->

                <!-- Attachments Card -->
                <div class="card mb-4">
                    <div class="card-header text-left" style="background-color: #0056b3; color: white;">
                        <h5><b>Attachments:</b></h5>
                    </div>
                    <div class="card-body">
                        <div id="attachments-container">
                            <!-- Content for attachments will be dynamically inserted here -->
                        </div>
                    </div>
                </div>

                <!-- End Attachments Card -->

                <!-- Approvers Card -->
                <div class="card mb-4">
                    <div class="card-header text-center" style="background-color: #0056b3; color: white;">
                        <h8><b>Approvers</b></h5>
                    </div>
                    <div class="card-body" >
                        <div id="divApprovers" class="row mb-4">
                            <div class="divApprovers" id="divApprovers">
                                @foreach ($Getprojects as $index => $project)
                                    <div class="cloned-fields d-flex align-items-center mb-2">
                                        <input type="text" class="form-control me-2" name="txtCompany[]" id="company"
                                            placeholder="Company" value="{{ $project->company }}" required
                                            disabled  style="width: 150px;"  />
                                        <input type="text" class="form-control me-2" name="txtApprover[]" id="name"
                                            placeholder="Name" value="{{ $project->name }}" required disabled />
                                        <input type="text" class="form-control me-2" name="txtPositions[]" id="position"
                                            placeholder="Position" value="{{ $project->position }}" required
                                            disabled   style="width: 150px;" />
                                        <input type="email" class="form-control me-2" name="txtEmail[]" id="email"
                                            placeholder="Email Address" value="{{ $project->email_address }}"
                                            required disabled />
                                        <p class="approvers" style="margin: 0;">
                                            <span class="approverstatus"
                                                name="approverstatus" style="font-size: 12px;" >{{ $project->ApproverStatus }}</span>
                                        </p>
                                        <button type="button" class="btn btn-sm btn-danger ms-2 me-2 remove-field"
                                            disabled>Delete</button>
                                        <button type="button" class="btn btn-sm btn-success ms-2 add-field"
                                            disabled>Add</button>
                                    </div>
                                @endforeach
                            </div>
                        <div id="divApproversError" class="text-danger"></div>
                        </div>
                    </div>
                </div>

                <!-- End Approvers Card -->

                <!-- Buttons -->
                <div class="row mb-4">
                    <div class="col text-center">
                        <button type="button" class="btn btn-danger me-1" id="cancelBtn">Cancel</button>
                        <a href="javascript:void(0);" class="btn btn-danger me-1" id="backBtn">Back</a>
                        <button type="button" class="btn btn-warning me-1" id="editBtn">Edit</button>
                        <button type="button" class="btn btn-success me-1" id="saveEditBtn">Save</button>
                        <button type="button" class="btn btn-info me-1" id="confirmBtn">For Approval</button>
                    </div>
                </div>
                <!-- End Buttons -->
            </div>
        </div>
    </div>

    <!-- Include jQuery before other scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <script src="{{ asset('assets/Modal/implementation-modal.js') }}"></script>
    <script src="{{ asset('assets/tab-isupport-service/signoff.js') }}"></script>

    <!-- Include Bootstrap Bundle JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
