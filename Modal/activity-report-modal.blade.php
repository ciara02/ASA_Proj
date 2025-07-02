<!-- Display Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header align-items-start justify-content-between">
                <div><img src="{{ asset('assets/img/official-logo.png') }}" class="vst-logo ">
                </div>
              
             <input type="hidden" id="ar_id" name="ar_id_hidden">

             <div class="container" style="margin-left: 20%;">
                <div class="row" >
                    <div class="col-md-5 mb-3 mt-3">
                        <div class="dropdown">
                            <label for="reportDropdown1">Report:</label>
                            <select class="form-control act_dropdrown" id="reportDropdown1"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                name="report_Dropdown_Input" disabled required>
                                <option class="" value="" selected>--Select Report--</option>
                                <option value="Support Request" class="SupportRequest">Support Request</option>
                                <option value="iSupport Services" class="iSupportServices">iSupport Services
                                </option>
                                <option value="Client Calls" class="Client Calls">Client Calls</option>
                                <option value="Internal Enablement" class="InternalEnablement">Internal Enablement
                                </option>
                                <option value="Partner Enablement/Recruitment"
                                    class="PartnerEnablement/Recruitment">Partner Enablement/Recruitment</option>
                                <option value="Supporting Activity" class="SupportingActivity">Supporting Activity
                                </option>
                                <option value="Skills Development" class="SkillsDevelopment">Skills Development
                                </option>
                                <option value="Others" class="Others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div id="projecttype" class="col-md-6 mb-3 mt-3 " style="display: none">
                        <div class="dropdown proj_type_dropdown">
                            <label for="projectTypeDropdown">Project Type:</label>
                            <select class="form-control" id="projtype_button1" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" name="projectType_Dropdown_Input">
                                <option value="" selected>--Select Project Type--</option>
                                <option value="Implementation" class="Implementation">Implementation</option>
                                <option value="Maintenance Agreement" class="Maintenance Agreement">Maintenance
                                    Agreement</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <div class="dropdown">
                            <label for="statusDropdown">Status:</label>
                            <select class="form-control act_dropdrown" id="statusDropdown1"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                name="status_Dropdown_Input" disabled required>
                                <option value="" selected>--Select Status--</option>
                                <option value="Pending" class="pending">Pending</option>

                                <option value="Cancelled" class="cancelled">Cancelled</option>

                                <option value="For Follow up" class="followUp">For Follow Up</option>

                                <option value="Activity Report being created" class="creating">Activity Report being
                                    created</option>
                                <option value="Completed" class="completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    <div id="projectname" class="col-md-6 mb-3" style="display: none">
                        <div class="dropdown">
                            <label for="projectNameDropdown">Project Name:</label>
                            <select class="form-control custom-drop-down" id="myDropdown1" 
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <option value="" selected>--Select Project Name--</option>

                            </select>
                        </div>
                        <input type="hidden" id="selectedProjectId" name="selected_project_id" value="">
                    </div>


                </div>
             </div>
             <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="Reports">
                <p class="report hidden" id="report_category"><b>Original Report Details</b></span></p>
                <p class="report hidden" id="report_category">Report: <span class="report" name = "report"></span></p>
                <p class="status hidden" id="report_status">Status: <span class="status" name = "status"></span></p>
                <p class="proj_name hidden" id="project">Project Name: <span class="proj_name"
                        name = "project_name"></span>
                </p>
                <p class="proj_type hidden" id="project_type">Project Type: <span class="proj_type"
                        name = "project_type"></span></p>

            </div>

            <div class="Reports">
                <p class="reference_no" id="reference_no">Reference No: <span class="reference_no"
                        name = "reference_number" style="font-weight: bold;"></span></p>
            </div>

            <div class="modal-body">
                    <div class="card " id="quick_addActivity1">
                        <div class="card-header custom-header-bg" >
                            <i class="bi bi-file-earmark-text"></i> Activity
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 align-items-center mb-2" class="activityForm" style="">
                                    <label for="Activity_details" class="form-label ">Activity:</label>
                                    <input type="text" class="form-control" class="Activity_details"
                                        id="Activity_details" value="" name="activity" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3" id="activity_details" style="">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-info-circle mt-2"></i> Activity Details 
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4  align-items-center gap-2">
                                    <label for="act_details_requester" class="form-label">Requester:</label>
                                    <input type="text" class="form-control" id="act_details_requester" value=""
                                        name = "requester" disabled>
                                </div>

                                <div class="col-md-4  align-items-center gap-2">
                                    <label for="engineers_modal" class="form-label">Product Engineers Only:</label>
                                    <select class="form-control" id="engineers_modal" name="engineers_modal[]"
                                        multiple="multiple" required></select>
                                </div>

                                <div class="col-md-4 align-items-center gap-2">
                                    <label for="Date_Filed" class="form-label">Date Filed:</label>
                                    <input type="date" class="form-control" id="Date_Filed" value="" required readonly>
                                </div>

                                <div class="col-md-4 align-items-center gap-2 mt-2">
                                    <label for="act_details_activity" class="form-label">Activity:</label>
                                    <input type="text" class="form-control" id="act_details_activity" placeholder=""
                                        value="" required>
                                </div>

                                <div class="col-md-4 align-items-center gap-2  mt-2">
                                    <label for="Copy_to" class="form-label">Copy To:</label>
                                    <select class="form-control" id="Copy_to" name="Copy_to" multiple="multiple"
                                        required></select>
                                </div>

                                <div class="col-md-4 align-items-center gap-2 mt-2">
                                    <label for="Date_Needed" class="form-label">Date Needed:</label>
                                    <input type="date" class="form-control" id="Date_Needed" placeholder="mm/dd/yyyy"
                                        value="" required>
                                </div>

                                <div class="col-md-8 align-items-center gap-2 mt-2">
                                    <label for="special_instruction" class="form-label">Special Instruction:</label>
                                    <textarea class="form-control" id="special_instruction" rows="3"></textarea>
                                </div>

                                <div class="col-md-4 align-items-center gap-2 mt-2">
                                    <label for="Ref_No" class="form-label">Reference Number:</label>
                                    <input type="text" class="form-control" id="Ref_No" placeholder=""
                                        value="" required readonly>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="card mt-3" id="Contract_Details">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-person-lines-fill"></i> Contract Details 
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 align-items-center gap-2">
                                    <div class="col align-items-center gap-2  mt-2">
                                        <label for="Reseller" class="form-label">Resellers:</label>
                                        <input type="text" class="form-control" id="Reseller" value="" required>
                                    </div>
                                </div>

                                <div class="col-md-4 align-items-center gap-2">
                                <div class="col align-items-center gap-2  mt-2">
                                    <label for="reseller_contact_info" class="form-label">Reseller's Contact #:</label>
                                    <input type="text" class="form-control" id="reseller_contact_info" value=""
                                        required>
                                </div>
                                </div>

                                <div class="col-md-4 align-items-center gap-2">
                                    <div class="col align-items-center gap-2  mt-2">
                                        <label for="reseller_phone_email" class="form-label">Reseller's Email:</label>
                                        <input type="email" class="form-control" id="reseller_phone_email" value=""
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-4 align-items-center gap-2 mt-2">
                                    <div class="col align-items-center gap-2  mt-2">
                                        <label for="end_user_name" class="form-label">End User:</label>
                                        <input type="text" class="form-control" id="end_user_name" placeholder=""
                                            value="" required>
                                    </div>
                                </div>

                                <div class="col-md-4 align-items-center gap-2 mt-2">
                                    <div class="col align-items-center gap-2  mt-2">
                                        <label for="end_user_contact" class="form-label">End User Contact #:</label>
                                        <input type="text" class="form-control" id="end_user_contact" placeholder=""
                                            value="" required>
                                    </div>
                                </div>

                                <div class="col-md-4 align-items-center gap-2 mt-2">
                                    <div class="col align-items-center gap-2  mt-2">
                                        <label for="end_user_email" class="form-label">End User Email:</label>
                                        <input type="email" class="form-control" id="end_user_email" placeholder=""
                                            value="" required>
                                    </div>
                                </div>

                                <div class="col-md-12 align-items-center gap-2 mt-2">
                                <div class="col align-items-center gap-2  mt-2">
                                    <label for="end_user_loc" class="form-label">End User Location:</label>
                                    <input type="text" class="form-control" id="end_user_loc" placeholder=""
                                        value="" required>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card mt-3" id="Act_summary_report">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-clipboard-data"></i> Activity Summary Report 
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 align-items-center gap-2 mt-2">
                                    <label for="act_date" class="form-label">Activity Date:</label>
                                    <input type="date" class="form-control" id="act_date" value=""
                                        name="activity_date" required>
                                </div>

                                <div class="col-md-4 align-items-center gap-2 mt-3"  id="time_Reported_modal" >
                                    <div>
                                        <label for="time_reported1" class="form-label">Time Reported to Client:</label>
                                        <select class="form-select get_time" id="time_reported1" disabled
                                            aria-describedby="time_reported1" required>
                                        </select>
                                    </div> 
                                </div>
                                <input type="hidden" name="time_reported_id1" id="time_reported_id1">

                                <div class="col-md-4 align-items-center gap-2  mt-3"  id="time_Exited_modal">
                                    <div>
                                        <label for="time_exited" class="form-label">Time Exited From Client:</label>
                                        <select class="form-select get_time" id="time_exited1" disabled
                                            aria-describedby="time_exited1" required>
                                        </select>
                                    </div>                    
                                </div>
                                <input type="hidden" name="time_exited_id1" id="time_exited_id1">

                                <div class="col-md-4 align-items-center gap-2 mt-3">
                                    <div>
                                        <label for="product_line" class="form-label">Product Line:</label>
                                        <select class="form-control" id="product_line" multiple required> </select>
                                    </div>
                                    <input type="hidden" id="product_line_input" name="productLines">
                                    <div>
                                        <label for="product_code" class="form-label">Product Code:</label>
                                        <input type="text" class="form-control" id="product_code" required> <!-- Product code input field -->
                                    </div>
                                    <!-- Options will be dynamically populated -->
                                </div>             

                                <div class="col-md-4 align-items-center gap-2  mt-2">
                                    <div class="col align-items-center gap-2  mt-2">
                                        <label for="engineers_modal_two" class="form-label">Engineer:</label>
                                    <select class="form-control" id="engineers_modal_two" name="engineers_modal_two"
                                        multiple="multiple" required></select>
                                    </div>

                                    <div class="col align-items-center gap-2  mt-2">
                                        <label for="sendcopyto" class="form-label"> Send Copy To:</label>
                                        <textarea class="form-control" id="sendcopyto"
                                        placeholder="Enter email addresses separated by comma, for internal and external contacts" rows="3"></textarea>
                            
                                    </div>   
                                </div>

                                <div class="col-md-4 align-items-center gap-2 mt-3" id="time_Expected_modal">
                                    <div>
                                        <label for="time_expected1" class="form-label">Time Expected From Client:</label>
                                        <select class="form-control get_time" id="time_expected1" name="time_expected1" disabled
                                            required>
    
                                        </select>
    
                                        <!-- Options will be dynamically populated -->
                                    </div>

                                </div>
                                <input type="hidden" name="time_expected_id1" id="time_expected_id1">

                                <div class="col-md-4 align-items-center gap-2 mt-2">
                                    <label for="Activity_Type" class="form-label">Activity Type:</label>
                                    <select class="form-control" id="Activity_Type" value="" required> </select>
                                    <!-- Options will be dynamically populated -->
                                </div>

                                <div class="col-md-4 align-items-center gap-2 mt-2">
                                    <label for="program" class="form-label">Program:</label>
                                    <select class="form-control" id="program" required>
                                        <!-- Options will be dynamically populated -->
                                    </select>
                                </div>
                                   
                                <div class="col-md-4 align-items-center gap-2  mt-2" id="modal_venueHidden">
                                    <div>
                                        <label for="venue" class="form-label">Venue:</label>
                                        <textarea class="form-control" id="venue" rows="3"></textarea>
                                    </div>     
                                </div>

                               

                            </div>
                        </div>
                    </div>

                {{-- ------------------------------------------------------------------------------------------ --}}

                    <div class="card mt-3" id="Participant_Position">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-people"></i> Participants and Positions 
                        </div>

                        <div class="card-body mt-3">
                            <div id="participantAndPositionContainer">
                                <!-- Dynamic participant and position fields will be appended here -->
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3" id="customer_requirements">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-exclamation-circle"></i> I. Customer Requirements 
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    <label for="customerReq"> Enter Customer Requirements:</label>
                                    <textarea class="form-control" id="customerReqfield" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3" id="Activity_Done">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-check-circle"></i> II. Activity Done 
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    <label for="activity_done"> Enter Activity:</label>
                                    <textarea class="form-control" id="activity_donefield" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3" id="Agreements">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-key"></i> III. Agreements 
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    <label for="Agreements"> Enter Agreements:</label>
                                    <textarea class="form-control" id="Agreementsfield" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3" id="action_plan_recommendation">
                        <div class="card-header custom-header-bg"><i class="bi bi-hand-thumbs-up"> IV. Action Plan / Recommendation </i></div>
                        <div class="card-body">
                            {{-- <div class="row cloned-action-plan-recommendation-modal" id="ActionPlan_Recommendation"> --}}
                            <div id="ActionPlan_Recommendation">
                                <!-- Dynamic Action Plan and Recommendation fields will be appended here -->
                            </div>
                        </div>
                    </div>

                <!--------------------------------------------------------- Start Partner Enablement/Recruitment Form Fields sTracert -------------------------------------------- -->

                    <div class="card mt-3" id="sTracert" style="display: none">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-patch-exclamation"></i> STRACERT
                        </div>
                        <div class="card-body">

                            <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Topic:</div>
                                    </div>
                                    <input type="text" class="form-control" id="stra_topicName" name="topicName">
                                </div>
                            </div>


                            <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Date Start:</div>
                                    </div>
                                    <input type="date" class="form-control" id="stra_dateStart" name="dateStart" placeholder="mm/dd/yyyy">
                                </div>
                            </div>

                            <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Date End:</div>
                                    </div>
                                    <input type="date" class="form-control" id="stra_dateEnd" name="dateEnd" placeholder="mm/dd/yyyy">
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--------------------------------------------------------- End Partner Enablement/Recruitment Form Fields sTracert  -------------------------------------------- -->

                    <!--------------------------------------------------------- Start of Client Calls Form Fields -------------------------------------------- -->
                    <div class="card mt-3" id="POC" style="display: none">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-boxes"></i> POC (Proof of Concept) 
                        </div>
                        <div class="card-body">

                            <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Product Model:</div>
                                    </div>
                                <input type="text" class="form-control" id="modal_prodModel" name="prod_model">
                                </div>
                            </div>
                            <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Asset or Code:</div>
                                    </div>
                                <input type="text" class="form-control" id="modal_assetCode" name="asset_code">
                                </div>
                            </div>

                                <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Date Start:</div>
                                        </div>

                                        <input type="date" class="form-control" id="modal_poc_dateStart" name="poc_dateStart" placeholder="mm/dd/yyyy">
                                    </div>
                                </div>

                                <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Date End:</div>
                                        </div>


                                        <input type="date" class="form-control" id="modal_poc_dateEnd" name="poc_dateEnd" placeholder="mm/dd/yyyy">

                                    </div>
                                </div>

                        </div>
                    </div>

                    <!--------------------------------------------------------- End of Client Calls Form Fields -------------------------------------------- -->

                    <!--------------------------------------------------------- Start of Skills Development Form Fields -------------------------------------------- -->

                    <div class="card mt-3" id="skillsTech" style="display: none">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-vector-pen"></i> Technical Certification
                        </div>
                        <div class="card-body row">
                            <div class="col  align-items-center gap-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Title:</div>
                                    </div>
                                <input type="text" class="form-control" id="modal_title" name="exam_title">
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-md-4 align-items-center gap-2 mt-4" >
                              <label for="examCode" class="form-label">Exam Code/Name:</label>
                                <input type="text" class="form-control" id="modal_examCode" name="exam_code">
                               
                            </div>


                            <div class="col-md-4 align-items-center gap-4 mt-4">
                                <label for="takeStatusDropdown" class="form-label">Take Status:</label>
                            <select class="form-select" id="modal_takeStatusDropdown" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" 
                                    name="takeStatusDropdown" data-ar-take-status="">
                                    <option value="1">Take 1 </option>
                                    <option value="2">Take 2 </option>
                                    <option value="nth">Nth Take</option>
                                </select>
                            </div>

                            <div class="col-md-4 align-items-center gap-2 mt-4">
                                <label for="scoreDropdown" class="form-label" >Score:</label>
                            <select class="form-select " id="modal_scoreDropdown" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" 
                                    name="score_type">
                                    <option value="Passed">Passed</option>
                                    <option value="Failed">Failed</option>
                                </select>

                            </div>

                            <div class="col-md-4 align-items-center gap-3 mt-4">
                                <label for="examTypeDropdown" class="form-label">Exam Type:</label>
                            <select class="form-select " id="modal_examTypeDropdown" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" 
                                    name="examTypeDropdown">
                                    <option value="1">Prometric Technical Exam</option>
                                    <option value="2">Prometric Sales Exam</option>
                                    <option value="3">Online Technical Exam</option>
                                    <option value="4">Online Sales Exam</option>
                                </select>

                            </div>

                            <div class="col-md-4 align-items-center mt-4">
                                <label for="incentiveStatusDropdown" class="form-label" >Incentive
                                    Status:</label>
                                 <select class="form-select " id="modal_incentiveStatusDropdown" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" 
                                    name="incentiveStatusDropdown">
                                    <option value="1">For HR Request</option>
                                    <option value="2">Collected</option>
                                    <option value="3">No Incentive</option>
                                </select>

                            </div>

                            <div class="col-md-4  align-items-center gap-2 mt-4">
                                <label for="incentiveStatusDropdown" class="form-label">Incentive
                                    Amount:</label>
                                <input type="text" class="form-control" id="modal_amount" name="incentive_amt">
                            </div>

                            <div class="col-md-8 align-items-center mt-4">
                                <label for="incentiveDetailsDropdown" class="form-label">Incentive Details:</label>
                            <select class="form-select" id="modal_incentiveDetailsDropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" required name="incentiveDetailsDropdown">
                                    <option value="1">Preferred - Complex (1 exam track) => P5000
                                    </option>
                                    <option value="2">Preferred - Complex (2 or more exams track) =>
                                        P10000
                                    </option>
                                    <option value="3">Preferred - Simple (1 exam track) => P3000
                                    </option>
                                    <option value="4">Preferred - Simple (2 or more exams track) =>
                                        P5000
                                    </option>
                                    <option value="5">Supplemental - Complex (1 exam track) =>
                                        P2000
                                    </option>
                                    <option value="6">Supplemental - Complex (2 or more exams
                                        track) => P3000
                                    </option>
                                    <option value="7">Supplemental - Simple (1 exam track) =>
                                        P500
                                    </option>
                                    <option value="8">Supplemental - Simple (2 or more exams
                                        track)
                                        =>
                                        P1000
                                    </option>
                                </select>

                            </div>
                        </div>
                    </div>


                    <div class="card mt-3" id="TechAndSkillsDevt" style="display: none">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-gear"></i> Technology or Product Skills Development 
                        </div>
                        <div class="card-body">
                            <div class="form-group col align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Technology/ Product Learned:</div>
                                    </div>
                                <input type="text" class="form-control" id="modal_techprodLearned"
                                        name="techProdLearnedInput">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card mt-3" id="SkillsDevOthers" style="display: none">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-lightbulb"></i> Skills Development
                        </div>
                        <div class="card-body" row>
                            <div class="form-group col align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Training Name:</div>
                                    </div>
                                <input type="text" class="form-control" id="modal_trainingName"
                                        name="training_Name_Input">
                                </div>
                            </div>
                            <div class="form-group col align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Location:</div>
                                    </div>
                                <input type="text" class="form-control" id="modal_location"
                                    name="training_location">
                                </div>
                            </div>
                            <div class="form-group col align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Speaker/s:</div>
                                    </div>
                                <input type="text" class="form-control" id="modal_speaker"
                                    name="training_speaker">
                                </div>
                            </div>
                            <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Attendees:</div>
                                    </div>
                                    <div style="margin-left: 2%" class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="BPsInput"
                                                id="bpCheckbox" value="1">
                                            <label class="form-check-label" for="bpCheckbox">BPs</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="EUsInput"
                                                id="euCheckbox" value="1">
                                            <label class="form-check-label" for="euCheckbox">EUs</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="MSIInput"
                                                id="MSICheckbox" value="1">
                                            <label class="form-check-label" for="MSICheckbox">MSI</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>






                    <!--------------------------------------------------------- End of Skills Development Form Fields -------------------------------------------- -->

                    <!--------------------------------------------------------- Others Form Fields -------------------------------------------- -->
                    <div class="card mt-3" id="othersDigiKnow" style="display: none">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-globe"></i> DigiKnow 
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    <label for="digiknowFlyersattachment" class="mt-2 me-2">Attach DIGIKnow
                                        Flyer:</label>

                                        <input type="file" class="form-control" id="modal_digiknowFlyersattachment" multiple name="modal_digiknowFlyersattachment[]" aria-describedby="digiknowFlyersattachment">
                                </div>
                                     <p class="text" style="color: rgb(0, 0, 0);">Attachments:</p>
                                      <div id="digiknowfileDisplay" class="mt-3" name="digiknowfileDisplay"> </div>
                           
                                <div class="form-group">
                                    <div class="align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                        <div class="mt-3 d-flex justify-content-left align-items-center">
                                            <div class="input-group" style="width:fit-content;margin-right:10px;">
                                                <div class="input-group-text">Recipients:</div>
                                            </div>
                                            <div style="margin-left: 2%" class="mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                    name="BPsInputDigiknow" id="modal_bpDigiCheckbox" value="1">
                                                    <label class="form-check-label" for="bpCheckbox">BPs</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                    name="EUsInputDigiknow" id="modal_euDigiCheckbox" value="1">
                                                    <label class="form-check-label" for="euCheckbox">EUs</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3" id="otherInternalProject" style="display: none">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-journals"></i> Internal Project 
                        </div>
                        <div class="card-body">
                            <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">MSI Project Name:</div>
                                    </div>


                                    <input type="text" class="form-control" id="modal_MSIProjName" name="modal_MSIProjName">

                                </div>
                            </div>

                            <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Compliance Percentage:</div>
                                    </div>
                                <input type="text" class="form-control" id="modal_CompliancePercentage"
                                    name="modal_CompliancePercentage">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3" id="otherAttendance" style="display: none">
                        <div class="card-header custom-header-bg">
                            <i class="bi bi-journal-check"></i> Perfect Attendance 
                        </div>

                        <div class="card-body">
                                <div class="form-group col align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Perfect Attendance:</div>
                                        </div>
                                        <input type="month" class="form-control" id="modalperfectAttendance"
                                            name="modalperfectAttendance" value="">
                                    </div>
                                </div>
                        </div>
                    </div>


                    <div class="card mt-3" id="otherMemo" style="display: none">

                        <div class="card-header custom-header-bg">
                            <i class="bi bi-pencil"></i> Memo

                        </div>

                        <div class="card-body">


                                <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">


                                    <div class="input-group mb-2">


                                        <div class="input-group-prepend">


                                            <div class="input-group-text">Memo Issued:</div>


                                        </div>



                                        <input type="date" class="form-control" id="modal_memoIssued" name="modal_memoIssued">

                                    </div>


                                </div>


                            <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">


                                <div class="input-group mb-2">


                                    <div class="input-group-prepend">


                                        <div class="input-group-text">Memo Details:</div>


                                    </div>



                                    <input type="text" class="form-control" id="modal_memoDetails" name="modal_memoDetails">


                                </div>


                            </div>


                        </div>


                    </div>


                    <div class="card mt-3" id="otherFeedback" style="display: none">


                            <div class="card-header custom-header-bg">
                                <i class="bi bi-chat-left-text"></i> Feedback On Engineer 


                            </div>


                            <div class="card-body">


                                  <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                        <div class="input-group mb-2">


                                                <div class="input-group-prepend">


                                                    <div class="input-group-text">Feedback On Engineer:</div>


                                                </div>

                                                    <input type="text" class="form-control" id="modal_engrFeedbackInput"
                                                        name="modal_engrFeedbackInput">

                                        </div>
                                  </div>
                                  <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">


                                        <div class="input-group mb-2">
        
        
                                            <div class="input-group-prepend">
        
        
                                                <div class="input-group-text">Rating:</div>
        
        
                                            </div>
        
                                            <select class="form-control" id="modal_other_rating" 
                                                        style="width: 200px;" name="modal_other_rating">
        
                                                <option value="" hidden> <--- Select Rating ---> </option>
        
        
                                                <option value="1">1 Very Satifactory</option>
        
        
                                                <option value="2">2 Satisfactory</option>
        
        
                                                <option value="3">3 Just Right</option>
        
        
                                                <option value="4">4 Unsatisfactory</option>
        
        
                                                <option value="5">5 Very Unsatifactory</option>
        
        
                                            </select>
        
        
                                        </div>
    
    
                                  </div>       

                            </div>

                    </div>



                    <div class="card mt-3" id="otherTrainToRetain" style="">


                        <div class="card-header custom-header-bg">
                            <i class="bi bi-ui-checks"></i> Train to Retain (T2R) 


                        </div>


                          <div class="card-body">


                                    <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">


                                        <div class="input-group mb-2">


                                            <div class="input-group-prepend">


                                                <div class="input-group-text">Topic:</div>



                                            </div>


                                            <input type="text" class="form-control" id="modal_topicName" name="modal_topicName">


                                        </div>

                                    </div>

                                    <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Date Start:</div>
                                            </div>
            
            
                                            <input type="date" class="form-control" id="modal_dateStart" name="modal_dateStart" placeholder="mm/dd/yyyy">
            
                                        </div>
                                    </div>
            
                                    <div class="form-group col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Date End:</div>
                                            </div>
                                            <input type="date" class="form-control" id="modal_dateEnd" name="modal_dateEnd" placeholder="mm/dd/yyyy">
                                        </div>
                                    </div>

                           
                          </div>

                        

                       


                    </div>



                    <!--------------------------------------------------------- End of Others Form Fields -------------------------------------------- -->

                    <div class=" mt-3 mb-3 row input-note  align-items-center" id="Attachment">

                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="file" class="form-control" id="upload_file" multiple name="upload_file[]">
                            </div>
                        </div>

                        <div class="col-md-5">
                            <small class="text" style="color: red;">Note: The file should be less than 10MB.</small>
                        </div>

                         {{-- /////////////////////// File Viewing /////////////////////////// --}}
                        <p class="text" style="color: rgb(0, 0, 0);"><i class="bi bi-paperclip"></i>Attachments:</p>
                        <div id="fileDisplay" class="mt-3"></div>
                    </div>

                    <div class="d-flex justify-content-center gap-2 custom-position mt-3">
                        <button type="button" id="editbutton" class="btn btn-primary custom-button">Edit</button>

                        <button type="button" id="cloneButton" class="btn btn-info custom-button ">Clone</button>

                        <button type="button" id="saveCloneButton" class="btn btn-success custom-button">Save Clone</button>
                        
                        <button type="button" id="forwardButton2" class="btn btn-warning custom-button" data-bs-toggle="modal"
                            data-bs-target="#forwardmodal">Forward</button>


                        <button type="button" id="completion_acceptance" class="btn btn-success custom-button" data-bs-toggle="modal"
                            data-bs-target="#CompletionAcceptanceModal" style="display: none">Completion
                            Acceptance</button>

                        <button type="button" id="saveButton" class="btn btn-success custom-button">Save</button>
                        <button type="button" id="cancelButton" class="btn btn-danger custom-button">Cancel</button>

                        {{-- <button type="button" id="closeButton" class="btn btn-secondary custom-button"
                            data-bs-dismiss="modal">Close</button> --}}

                    </div>


                </div>

                <div class="modal-footer justify-content-center">
                    <p class="text-center">
                        © 2024 Copyright VST ECS Phils., Inc. All rights reserved.
                    </p>
                </div>


            </div>     

        </div>

    </div>
</div>


<!-- Second Modal -->
<div class="modal fade" id="forwardmodal" tabindex="-1" aria-labelledby="forwardmodalLabel"aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-m">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forwardmodalLabel">Forward Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 0 30px; text-align: justify; height: 480px; overflow-y: auto;">
                <div class="mb-3">
                    <label for="txtTo" class="form-label"><b>To:</b></label>
                    <input type="email" class="form-control" id="txtTo" name="txtTo"
                        placeholder="Enter Email Address" title="Indicate Email address separated by comma(,)."
                        required multiple />
                    <!-- Error -->
                    <div class="error-message" id="error-txtTo"></div>
                    <!-- Error -->
                </div>
                <div class="mb-3">
                    <label for="txtCC" class="form-label"><b>CC:</b></label>
                    <input type="email" class="form-control" id="txtCC" name="txtCC"
                        placeholder="Optional Field" title="Indicate Email address separated by comma(,)." multiple />
                    <!-- Error -->
                    <div class="error-message" id="error-txtCC"></div>
                    <!-- Error -->
                </div>
                <div class="mb-3">
                    <label for="txtBCC" class="form-label"><b>BCC:</b></label>
                    <input type="email" class="form-control" id="txtBCC" name="txtBCC"
                        placeholder="Optional Field" />
                    <!-- Error -->
                    <div class="error-message" id="error-txtBCC"></div>
                    <!-- Error -->
                </div>
                <div class="mb-3">
                    <label for="txtSubject" class="form-label"><b>Subject:</b></label>
                    <input type="text" class="form-control" id="txtSubject" name="txtSubject"
                        placeholder="Enter Subject" required />
                    <!-- Error -->
                    <div class="error-message" id="error-txtSubject"></div>
                    <!-- Error -->
                </div>
                <div class="mb-3">
                    <label for="txtMessage" class="form-label"><b>Message:</b></label>
                    <textarea id="txtMessage" name="txtMessage" class="form-control" placeholder="Enter Message Here"
                        style="height: 200px; resize: vertical;"></textarea>
                    <!-- Error -->
                    <div class="error-message" id="error-txtMessage"></div>
                    <!-- Error -->
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center gap-2 custom-position">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                <button type="button" id="Back" class="btn btn-warning" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Cancel</button>
                <button type="button" id="sendactivity" class="btn btn-info">Send </button>
            </div>
        </div>
    </div>
</div>

</div>

</div>


<!-- 3rd Modal -->
<div class="modal fade" id="CompletionAcceptanceModal" tabindex="-1"
    aria-labelledby="CompletionAcceptanceModal"aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CompletionAcceptanceModal">ACTIVITY COMPLETION ACCEPTANCE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="p-4">
                <div class="mt-2 ps-2">
                    <p class="reportstatus" id="completionstatus">Status: <span class="status" name="status"></span>
                    </p>
                </div>
                <div class="act_completion">
                    <div class="card" id="Activity Completion">
                        <div class="card-header">
                            Activity Summary Report Completion Acceptance
                        </div>
    
                        <div class="card-body">
                            <div class="row">
    
                                <div class="col-md-4 mb-3">
                                    <label for="refno" class="form-label">Reference No:</label>
                                    <input type="text" class="form-control" id="refno" required>
                                    <input type="hidden" id="ArId" name="ArId">
                                </div>
    
                                <div class="col-md-4 mb-3">
                                    <label for="date" class="form-label">Date Created:</label>
                                    <input type="date" class="form-control" id="date" required placeholder="mm/dd/yyyy">
                                    <input type="hidden" id="time" name="time">
                                </div>
    
                                <div class="col-md-4 mb-3">
                                    <label for="created_by" class="form-label">Created By:</label>
                                    <input type="text" class="form-control" id="created_by" placeholder=""
                                        value="" required>
                                </div>
    
                                <div class="col-md-4 mb-3">
                                    <label for="Proj_Name" class="form-label">Project Name:</label>
                                    <input type="text" class="form-control" id="Proj_Name_input" placeholder=""
                                        value="" required>
                                </div>
    
                                <div class="col-md-4 mb-3">
                                    <label for="reseller" class="form-label">Reseller:</label>
                                    <input type="text" class="form-control" id="reseller_input" placeholder=""
                                        value="" required>
                                </div>
    
                                <div class="col-md-4 mb-3">
                                    <label for="reseller_contact" class="form-label">Reseller Contact:</label>
                                    <input type="text" class="form-control" id="reseller_contact" placeholder=""
                                        value="" required>
                                </div>
    
                                <div class="col-md-4 mb-3">
                                    <label for="activity_date" class="form-label">Activity Date:</label>
                                    <input type="date" class="form-control" id="activity_date" placeholder="mm/dd/yyyy"
                                        value="" required>
                                </div>
    
                                <div class="col-md-4 mb-3">
                                    <label for="end_user" class="form-label">End User:</label>
                                    <input type="text" class="form-control" id="end_user_input" placeholder=""
                                        value="" required>
                                </div>
    
                                <div class="col-md-4 mb-3">
                                    <label for="EU_Contact" class="form-label">End User Contact</label>
                                    <input type="text" class="form-control" id="EU_Contact" placeholder=""
                                        value="" required>
                                </div>
    
                                <div class="col-md-4 mb-3">
                                    <label for="Act_Completion_Engineer" class="form-label">Engineers:</label>
                                    <select class="form-control" id="Act_Completion_Engineer"
                                        name="Act_Completion_Engineer[]" multiple="multiple" required></select>
                                </div>
    
    
    
                                <div class="col-md-8 mb-">
                                    <label for="activity_details"> Activity:</label>
                                    <textarea class="form-control" id="actcompletion_activity" rows="3"></textarea>
                                </div>
    
    
                                <div class="col-md-12 mb-3">
                                    <label for="activity_details"> Activity Done:</label>
                                    <textarea class="form-control" id="activity_done" rows="3"></textarea>
                                </div>
    
                            </div>
                        </div>
    
    
                    </div>
    
    
                </div>
    
                <div class="card mt-4" id="MultiParticipant1">
                    <div class="card-header">
                        Approvers
                    </div>
                    <div class="card-body" id="approvers-container1">
                        <!-- This is where the approvers will be dynamically inserted -->
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" id="add-approver1">Add</button>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-center gap-2 custom-position">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" id="Back" class="btn btn-warning" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Cancel</button> --}}
                <button type="button" id ="SaveChanges" class="btn btn-success">Save</button>
                <button type="button" id="SentToClient" class="btn btn-success" disabled>Send To Client</button>
            </div>
        </div>
    </div>
</div>
