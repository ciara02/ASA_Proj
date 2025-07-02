<!-- Display Modal -->
<form id="projectSignoffUpdate" action="{{route('tab-isupport-service.update')}}"  method="POST">
    @method('PUT')
    @csrf
    <input type="hidden" id="project-id" name="project_id">
 <div class="modal fade" id="projectSignOffModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="porjectSignOffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header align-items-start justify-content-between">
            <div>
                <img src="{{ asset('assets/img/official-logo.png') }}" class="vst-logo">
                <p class="status" id="statusVal" style="margin-left: 10px; margin-top: 10px;">Status: <span id="statusText"></span></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>      
        <div class="modal-body">
            <div class="card custom-position">
                <div class="card-header custom-bg">
                    Project Sign-Off
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col align-items-center mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-3" id="created_byContainer">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Created By:
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="created_by" name="created_by_input" >
                            </div>

                            <div class="input-group mb-3" >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Project Title:</div>
                                </div>
                                <input type="text" class="form-control" id="project_title" name="project_titleInput" 
                                    value="">
                            </div>
                            
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Reseller:</div>
                                </div>
                                <input type="text" class="form-control" id="reseller" name="reseller_input" placeholder="Required" required
                                    value="">
                            </div>
                                        
                        </div>

                        <div class="col align-items-center mb-2" style="margin-top: 15px;">

                            <div class="input-group mb-3" id="date_container">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Date Created: </div>
                                </div>
                                <input type="date" class="form-control" id="date_Created" name="date_Created"  placeholder="Required" >
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">End User:</div>
                                </div>
                                <input type="text" class="form-control" id="endUser_input" name="endUser_input" placeholder="Required" required
                                    value="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card custom-position" style="margin-top: 15px;">
                <div class="card-header custom-bg">
                    Deliverables
                </div>
                        <div class="col align-items-center mb-2" style="margin-top: 15px;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group">
                                        <textarea class="form-control" id="DeliverablesTextarea" rows="3" name="Deliverables_Input" placeholder="Required" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>

            <div class="row input-note  align-items-center" id="attachment" style="margin-top: 15px;">

                <div class="col-md-5">
                    <label for="projectSignoffAttachment" class="form-label">Attachments:</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="projectSignoffAttachment" name="image"
                            aria-describedby="projectSignoffAttachment" aria-label="Upload">
                    </div>
                </div>

            </div>
            
            <div class="card" style="margin-top: 15px;">
                <div class="card-header">
                    Approvers
                </div>
                <div class="card-body">
                    <div id="approverContainer" class="row">
                        <!-- Dynamic participant name fields will be appended here -->
                    </div>
                </div>
            </div>
            
        </div>
         <div class="d-flex justify-content-center gap-2 mb-4">
          <button id="bckBtn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
          <button id="editBtn" type="button" class="btn btn-primary">Edit</button>
          <button id="submitBtn" type="submit" class="btn btn-primary">Save</button>
          <button id="approvalBtn" type="button" class="btn btn-info text-white">For Approval</button>
       </div>
        <div class="modal-footer justify-content-center">
          <p class="text-center">
            © 2024 Copyright VST ECS Phils., Inc. All rights reserved.
          </p>
        </div>
      </div>
    </div>
  </div>
</form>