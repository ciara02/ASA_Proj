<!-- Display Modal -->
<form id="" method="POST" action="{{ route('tab-quick-activity.store') }}" enctype="multipart/form-data">
    @csrf
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModal2">Activity Report</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-header">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-6 col-md-4 mb-3 mt-3">
                            <div class="dropdown">
                                <label for="reportDropdown2">Report:</label>
                                <select class="form-control act_dropdrown" id="reportDropdown2"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" required
                                    name="report_Dropdown_Input" >
                                    <option class="" value="" selected>--Select Report--</option>
                                    <option value="1" >Support Request</option>
                                    <option value="2" >iSupport Services</option>
                                    <option value="3">Client Calls</option>
                                    <option value="4" >Internal Enablement</option>
                                    <option value="5">Partner Enablement/Recruitment</option>
                                    <option value="6" >Supporting Activity</option>
                                    <option value="7">Skills Development</option>
                                    <option value="8">Others</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 col-md-4 mb-3 mt-3">
                            <div class="dropdown proj_type_dropdown">
                                <label for="projectTypeDropdown">Project Type:</label>
                                <select class="form-control" id="projtype_button2" data-bs-toggle="dropdown" 
                                    aria-haspopup="true" aria-expanded="false" disabled name="projectType_Dropdown_Input">
                                    <option value="" selected>--Select Project Type--</option>
                                    <option value="1" class="Implementation">Implementation</option>
                                    <option value="2" class="Maintenance Agreement">Maintenance Agreement</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="row justify-content-center">
                        <div class="col-6 col-md-4 mb-3">
                            <div class="dropdown">
                                <label for="statusDropdown">Status:</label> 
                                <select class="form-control act_dropdrown" id="statusDropdown2" required
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    name="status_Dropdown_Input"   >
                                    <option value="" selected>--Select Status--</option>
                                    <option value="1" class="pending">Pending</option>
                                    <option value="2" class="cancelled">Cancelled</option>
                                    <option value="3" class="creating">Activity Report being created</option>
                                    <option value="4" class="completed">Completed</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-6 col-md-4 mb-3">
                            <div class="dropdown">
                                <label for="projectNameDropdown">Project Name:</label>
                                <select class="form-control custom-drop-down" id="proj_name2" disabled
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <option value="" selected>--Select Project Name--</option>
                                </select>
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div>

            <div class="Reports">
                <p class="reference_no1" id="reference_no1">Reference No: <b><span class="reference_no1"
                        ></b></span></p>
            <input type="hidden" name="quick_ref_input" id="hidden_reference_no1">

            </div>
     
            <div class="modal-body">
                <div class="card " id="quick_addActivity2">
                    <div class="card-header">
                        Activity
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 align-items-center mb-2" class="activityForm" style="">
                                <label for="activity_details2" class="form-label ">Activity:</label>
                                <input type="text" class="form-control" class="activity_details2"
                                    id="activity_details2" value="" name="quick_activityForm_input" >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3" id="activity_details3" style="">
                    <div class="card-header">
                        Activity Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 d-flex align-items-center gap-2">
                                <label for="act_details_requester" class="form-label">Requester:</label>
                                <input type="text" class="form-control" id="act_details_requester" value="{{ Auth::user()->name }}"
                                    name ="quick_requester_Input"  readonly>
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2">
                                <label for="engineers_modal1" class="form-label">Product Engineers Only:</label>
                                <select class="form-control" id="engineers_modal1" name="quick_productEng_input[]"
                                    multiple="multiple" ></select>
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2">
                                <label for="Date_Filed" class="form-label">Date Filed:</label>
                                <input type="text" class="form-control" id="Date_Filed" value="{{ now()->format('Y-m-d') }}"  name="quick_dateFiled_input"
                                    readonly>
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2 mt-2">
                                <label for="act_details_activity" class="form-label">Activity:</label>
                                <input type="text" class="form-control" id="act_details_activity" placeholder="" name="quick_activity_input"
                                    value="" >
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2">
                                <label for="send_copy_to1" class="form-label">Copy To:</label>
                                <input type="text" class="form-control" id="send_copy_to1" placeholder="" name="quick_copytoInput"
                                    value="" >
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2 mt-2">
                                <label for="Date_Needed" class="form-label">Date Needed:</label>
                                <input type="date" class="form-control" id="Date_Needed" placeholder="" name="quick_date_needed_Input"
                                    value="" >
                            </div>

                            <div class="col-md-8 d-flex align-items-center gap-2 mt-2">
                                <label for="special_instruction" class="form-label">Special Instruction:</label>
                                <textarea class="form-control" id="special_instruction" rows="3" name="quick_special_instruct_Input"></textarea>
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2 mt-2">
                                <label for="Ref_No1" class="form-label">Reference Number:</label>
                                <input type="text" class="form-control" id="Ref_No1" placeholder="" 
                                    value=""  readonly>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="card mt-3" id="Contract_Details2">
                    <div class="card-header">
                        Contract Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 d-flex align-items-center gap-2">
                                <label for="Reseller" class="form-label">Resellers:</label>
                                <input type="text" class="form-control" id="Reseller" value=""  name="quick_reseller_input">
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2">
                                <label for="reseller_contact_info" class="form-label">Resellers Contact #:</label>
                                <input type="text" class="form-control" id="reseller_contact_info" value="" name="quick_resellers_contact_Input"
                                    >
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2">
                                <label for="reseller_phone_email" class="form-label">Resellers Phone/Email:</label>
                                <input type="text" class="form-control" id="reseller_phone_email" value="" name="quick_resellers_email_Input"
                                    >
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2 mt-2">
                                <label for="end_user_name" class="form-label">End User:</label>
                                <input type="text" class="form-control" id="end_user_name" placeholder="" name="quick_enduser_Input"
                                    value="" >
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2 mt-2">
                                <label for="end_user_contact" class="form-label">End User Contact #:</label>
                                <input type="text" class="form-control" id="end_user_contact" placeholder="" name="quick_enduser_contact_Input"
                                    value="" >
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2 mt-2">
                                <label for="end_user_email" class="form-label">End User Email:</label>
                                <input type="text" class="form-control" id="end_user_email" placeholder="" name="quick_enduser_email_Input"
                                    value="" >
                            </div>

                            <div class="col-md-12 d-flex align-items-center gap-2 mt-2">
                                <label for="end_user_loc" class="form-label">End User Location:</label>
                                <input type="text" class="form-control" id="end_user_loc" placeholder="" name="quick_enduser_loc_Input"
                                    value="" >
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card mt-3" id="Act_summary_report2">
                    <div class="card-header">
                        Activity Summary Report
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 d-flex align-items-center gap-2">
                                <label for="act_date" class="form-label">Activity Date:</label>
                                <input type="date" class="form-control" id="act_date" value=""
                                    name="quick_act_date_Input"  >
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2 mt-2">
                                <label for="Activity_Type1" class="form-label">Activity Type:</label>
                                <select class="form-control" id="Activity_Type1" value=""  name="quick_act_type_Input"> </select>
                                <!-- Options will be dynamically populated -->
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2 mt-2">
                                <label for="program1" class="form-label">Program:</label>
                                <select class="form-control" id="program1"  name="quick_program_Input">
                                    <!-- Options will be dynamically populated -->
                                </select>
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2 mt-2">
                                <label for="product_line1" class="form-label">Product Line:</label>
                                <select class="form-control" id="product_line_select"  name="quick_productLines[]"> </select>
                                <!-- Options will be dynamically populated -->
                            </div>

                            <input type="hidden" id="prod_code_input"  name="quick_productCodes[]">

                            <div class="col-md-4 d-flex align-items-center gap-2 mt-2">
                                <label for="time_expected" class="form-label">Time Expected From Client:</label>
                                <select class="form-control get_time_expected" id="time_expected" 
                                    name="quick_time_expected" > </select>
                                </select>
                                <!-- Options will be dynamically populated -->
                            </div>
                            <input type="hidden" name="time_expected_id" id="quick_time_expected_id">


                            <div class="col-md-4 d-flex align-items-center gap-2  mt-2">
                                <label for="time_reported" class="form-label">Time Reported to Client:</label>
                                <select class="form-select get_time" id="time_reported" name="quick_time_reported_Input"
                                    aria-describedby="time_reported" ></select>
                            </div>
                            <input type="hidden" name="time_reported_id" id="time_reported_id">


                            <div class="col-md-4 d-flex align-items-center gap-2  mt-2">
                                <label for="time_exited" class="form-label">Time Exited From Client:</label>
                                <select class="form-select get_time" id="time_exited" aria-describedby="time_exited" name="quick_time_exited_Input"
                                    >

                                </select>
                            </div>
                            <input type="hidden" name="time_exited_id" id="time_exited_id">

                            <div class="col-md-4 d-flex align-items-center gap-2  mt-2">
                                <label for="engineers_modal_two1" class="form-label">Engineer:</label>
                                <select class="form-control" id="engineers_modal_two1" name="quick_engineer_Input[]"
                                    multiple="multiple" ></select>
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2  mt-2">
                                <label for="venue" class="form-label">Venue:</label>
                                <textarea class="form-control" id="venue" rows="3" name="quick_venue_Input"></textarea>
                            </div>

                            <div class="col-md-12 d-flex align-items-center gap-2 mt-2">
                                <label for="exampleFormControlTextarea1"> Send Copy To:</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="quick_send_copy_toInput"
                                    placeholder="Enter email addresses separated by comma, for internal and external contacts" rows="3"></textarea>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------------------------------------------------ --}}

                <div class="card mt-3" id="Participant_Position2">
                    <div class="card-header">
                        Participants and Positions
                    </div>

                     <div class="card-body">
                    <div class="row  cloned-fields">
                        <div class="col-md-5">
                            <div class="participant-container mb-3">
                                <label for="validationServer12" class="form-label">Participant:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control email-input" id="participant" name="quick_participant_Input[]"
                                        placeholder="Enter Participant" value="" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="position-container mb-3">
                                <label for="validationServer12" class="form-label">Position:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control email-input" placeholder="Enter Position" id="position" name="quick_position_Input[]"
                                        value="" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 d-flex justify-content-center gap-2">
                            <button class="btn btn-success add-field" type="button">Add</button>
                            <button class="btn btn-danger remove-field" type="button">Remove</button>
                        </div>
                    </div>
                </div>
                </div>
                
                <div class="card mt-3" id="customer_requirements2">
                    <div class="card-header">
                        I. Customer Requirements
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <label for="customerReq"> Enter Customer Requirements:</label>
                                <textarea class="form-control" id="customerReqfield" rows="3" name="quick_cust_requirements_Input"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3" id="Activity_Done2">
                    <div class="card-header">
                        II. Activity Done
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <label for="activity_done"> Enter Activity:</label>
                                <textarea class="form-control" id="activity_donefield" name="quick_activity_done_Input" rows="6"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3" id="Agreements2">
                    <div class="card-header">
                        III. Agreements
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <label for="Agreements"> Enter Agreements:</label>
                                <textarea class="form-control" id="Agreementsfield" rows="3" name="quick_agreements_Input"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="card mt-3" id="action_plan_recommendation2"> --}}
                
            <div class="card" id="action_plan_recommendation2">
                <div class="card-header">
                    IV. Action Plan / Recommendation
                </div>

                <div class="card-body">
                    <div class="row  cloned-action-plan-recommendation">
                        <div class="col-md-3">
                            <div class="participant-container mb-3">
                                <label for="validationServer12" class="form-label">Starting Date:</label>
                                <div class="input-group">
                                    <input type="date" class="form-control email-input"
                                        placeholder="Enter Starting Date" name="quick_starting_date[]" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="position-container mb-3">
                                <label for="validationServer12" class="form-label">Details:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control email-input" placeholder="Enter Details" name="quick_details_input[]"
                                        value="" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="position-container mb-3">
                                <label for="validationServer12" class="form-label">Owner:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control email-input" placeholder="Enter Owner" name="quick_owner_input[]"
                                        value="" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 d-flex justify-content-center gap-2">
                            <button class="btn btn-success add-field" type="button">Add</button>
                            <button class="btn btn-danger remove-field" type="button">Remove</button>
                        </div>
                    </div>
                </div>
            </div>

                <div class=" mt-3 mb-3 row input-note  align-items-center" id="Attachment1">

                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="file" class="form-control" id="act_reportFile" name="quick_attachment"
                                aria-describedby="inputGroupFileAddon04"  onchange="Filevalidation()">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <small class="text" style="color: red;">Note: The file should be less than 10MB.</small>
                    </div>
                    <div class="mb-3" style="color:rgb(128, 128, 128);">
                        <p id="size"></p>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-2 custom-position">
                    <button type="button" id="cancelButton" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveButton" class="btn btn-success">Save</button>
                </div>

            </div>
        </div>
    </div>
 </div>
</form>


