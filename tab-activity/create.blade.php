@extends('layouts.base')
@section('content')
    <link href="{{ asset('assets/tab-activity/newproj.css') }}" rel="stylesheet">
  <div class="mx-auto mt-3" style="width:90%">   
    </div>
    

<!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<form id="updateForm" method="POST" action="{{ route('tab-activity.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="logo-mb5 d-flex">
        <div class="logo_ref">
            <img src="{{ asset('assets/img/official-logo.png') }}" class="vst-logo mb-2">
            <p style="margin-left:5%;" class="w-100">ASA Reference Number: <span class="refno" >{{ $asaNumber }}</span></p>
        </div>
        <div class=" mb-5 w-100" style="position:relative;" >
            <div class="row justify-content-center">
                <div class="col-5 col-md-5 mb-3 mt-3">
                    <div class="dropdown">
                        <label for="reportDropdown">Report:</label>
                        <select class="form-control act_dropdrown" id="reportDropdown"
                            aria-haspopup="true" aria-expanded="false" name="report_Dropdown_Input" >
                            <option class="" value="" selected>--Select Report--</option>
                            <option value="1" class="SupportRequest">Support Request</option>
                            <option value="2" class="iSupportServices">iSupport Services</option>
                            <option value="3" class="ClientCalls">Client Calls</option>
                            <option value="4" class="InternalEnablement">Internal Enablement</option>
                            <option value="5" class="PartnerEnablement/Recruitment">Partner Enablement/Recruitment</option>
                            <option value="6" class="SupportingActivity">Supporting Activity</option>
                            <option value="7" class="SkillsDevelopment">Skills Development</option>
                            <option value="8" class="Others">Others</option>
                        </select>
                    </div>
                </div>

                <div class="col-5 col-md-5 mb-3 mt-3">
                    <div class="dropdown proj_type_dropdown" id="new_Activity_ProjTypeDropdown"> 
                        <label for="projectTypeDropdown">Project Type:</label>
                        <select class="form-control" id="projtype_button"
                            aria-haspopup="true" aria-expanded="false" name="projectType_Dropdown_Input">
                            <option value="" selected>--Select Project Type--</option>
                            <option value="1" class="Implementation">Implementation</option>
                            <option value="2" class="MaintenanceAgreement">Maintenance Agreement</option>
                        </select>
                    </div>
                    <div id="projtype_buttonError" class="text-danger"></div>
                </div>


            </div>
            <div class="row justify-content-center">
                <div class="col-5 col-md-5 mb-3">
                    <div class="dropdown">
                        <label for="statusDropdown">Status:</label>
                        <select class="form-control act_dropdrown" id="statusDropdown"
                            aria-haspopup="true" aria-expanded="false" name="status_Dropdown_Input" >
                            <option value="" disabled selected>--Select Status--</option>
                            <option value="1" class="pending">Pending</option>
                            <option value="2" class="cancelled">Cancelled</option>
                            <option value="3" class="followUp">For Follow Up</option>
                            <option value="4" class="creating">Activity Report Being Created</option>
                            <option value="5" class="completed">Completed</option>
                        </select>
                    </div>
                </div>


                <div class="col-5 col-md-5 mb-3">
                    <div class="dropdown" id="new_Activity_ProjNameDropdown">
                        <label for="projectNameDropdown">Project Name:</label>
                        <select class="form-control custom-drop-down" id="myDropdown" disabled name="projNameDropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <option value="" disabled selected>--Select Project Name--</option>

                        </select>
                    </div>
                    <input type="hidden" id="selectedProjectId" name="selected_project_id" value="">

                    <div id="myDropdownError" class="text-danger"></div>
                </div>
            </div>
        </div>
    </div>


    {{-- ------------------------------------------------------------------------------------------ --}}
    <div class="container " >
        <form class="row g-3 mt-3">

            
            <input type="hidden" name="reference_No" value="{{ $asaNumber }}">

            <div id="act_form">
                <div class="col-md-12 d-flex align-items-center gap-3" id="activityForm" style="display: none;">
                    <label for="validationServer10" class="form-label ">Activity:</label>
                    <input type="text" class="form-control" id="activityinput" value="" name="activityForm_Input" >
                </div>
                <div id="activityError1" class="text-danger" style="margin-left: 6%"></div>
            </div>

            {{-- ------------------------------------------------------------------------------------------ --}}
            <div class="card" id="act_details" style="display: none">
                <div class="card-header custom-header-bg">
                    <i class="bi bi-info-circle"></i> Activity Details 
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 align-items-center gap-2">
                            <label for="validationServer10" class="form-label">Requester:</label>
                            <input type="text" class="form-control" id="validationServer10" name="requester_Input"
                                value="{{ $ldapEngineer && $ldapEngineer->fullName ? $ldapEngineer->fullName : '' }}" readonly>
                        </div>
                        


                        <div class="col-md-4 align-items-center gap-2">
                            <div class="col align-items-center gap-2">
                                <label for="engineers" class="form-label">Product Engineers Only:</label>
                                <select class="form-control" id="prod_engineers" multiple="multiple" name="prod_engineers_Input[]"
                                    ></select>
                            </div>
                            <div id="prodengrError" class="text-danger"></div>
                        </div>

                        <div class="col-md-4 align-items-center gap-2">
                            <label for="validationServer12" class="form-label">Date Filed:</label>
                            <input type="date" class="form-control" id="dateFiled" name="date_filed_Input"
                                value="{{ now()->format('Y-m-d') }}"  readonly>
                        </div>

                        <div class="col-md-4 align-items-center gap-2 mt-2">
                            <div class="col align-items-center gap-2 mt-2">
                                <label for="validationServer12" class="form-label">Activity:</label>
                                <input type="text" class="form-control" id="activitybodyInput" name="activity_Input"
                                    placeholder="" value="" > 
                            </div>
                            <div id="activityError" class="text-danger"></div>
                        </div>

                        <div class="col-md-4 align-items-center gap-2 mt-2">
                            <div class="col align-items-center gap-2 mt-2">
                            <label for="send_copy_to" class="form-label">Copy to:</label> 
                            <select class="form-control send_copy_to" id="send_copy_to" name="send_copy_toInput[]" multiple="multiple" 
                                ></select>
                            <input type="hidden" name="copyToManagerEmail[]" id="copyToManagerEmail">
                            </div>
                            <div id="copyToError" class="text-danger"></div>
                        </div>

                        <div class="col-md-4 align-items-center gap-2 mt-2">
                            <label for="validationServer12" class="form-label">Date Needed:</label> 
                            <input type="date" class="form-control datepicker" id="dateNeeded" placeholder="" name="date_needed_Input"
                               value="{{ now()->format('Y-m-d') }}" min="2023-01-01">
                        </div>

                        <div class="col-md-8 align-items-center gap-2 mt-2">
                            <label for="specialInstruction" class="form-label">Special Instruction:</label>
                            <input type="text" class="form-control" id="specialInstruction" placeholder="Add special instructions" name="special_instruct_Input"
                                value="" >
                        </div>

                        <div class="col-md-4 align-items-center gap-2 mt-2">
                            <label for="validationServer12" class="form-label">Reference Number:</label>

                            <input type="text" class="form-control" id="validationServer12" placeholder="" name="ref_Input"
                                value="{{ $asaNumber }}"  readonly>
                        </div>

                    </div>
                </div>
            </div>


        </form>

        <div class="mb-4"></div>

            {{-- ------------------------------------------------------------------------------------------ --}}
            <div class="card" id="contract_details">
                <div class="card-header custom-header-bg">
                    <i class="bi bi-person-lines-fill"></i> Contract Details 
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 align-items-center gap-2">
                        <div class="col align-items-center gap-2">
                            <label for="Resellers" class="form-label">Resellers:</label>
                            <input type="text" class="form-control" id="resellers" value="" name="resellers_Input">
                        </div>
                            <div id="resellersError" class="text-danger"></div>
                        </div>

                        <div class="col-md-4 align-items-center gap-2">
                            <div class="col align-items-center gap-2">
                                <label for="validationServer11" class="form-label">Resellers Contact #:</label>
                                <input type="text" class="form-control" id="resellersContact" value="" name="resellers_contact_Input" data-toggle="tooltip" data-placement="right">
                            </div>
                            <div id="resellersContactError" class="text-danger"></div>
                        </div>

                        <div class="col-md-4 align-items-center gap-2">
                            <div class="col align-items-center gap-2">
                                <label for="validationServer12" class="form-label">Resellers Email:</label>
                                <input type="text" class="form-control" id="resellersEmail" value="" name="resellers_email_Input"  data-toggle="tooltip" data-placement="right" >
                            </div>
                            <div id="resellersEmailError" class="text-danger"></div>
                        </div>

                        <div class="col-md-4 align-items-center gap-2 mt-2">
                            <label for="validationServer12" class="form-label">End User:</label>
                            <input type="text" class="form-control" id="validationServer12"
                                placeholder="Enter MSI if Internal Enablement" value="" name="enduser_Input" >
                        </div>

                        <div class="col-md-4 align-items-center gap-2 mt-2">
                            <label for="validationServer12" class="form-label">End User Contact #:</label>
                            <input type="text" class="form-control" id="endUserContact" placeholder="" name="enduser_contact_Input"  data-toggle="tooltip" data-placement="right"
                                value="" >
                        </div>

                        <div class="col-md-4 align-items-center gap-2 mt-2">
                            <label for="validationServer12" class="form-label">End User Email:</label>
                            <input type="text" class="form-control" id="validationServer12" placeholder="" name="enduser_email_Input"
                                value="" >
                        </div>

                        <div class="col-md-12 align-items-center gap-2 mt-2">
                            <label for="validationServer12" class="form-label">End User Location:</label>
                            <input type="text" class="form-control" id="validationServer12" placeholder="" name="enduser_loc_Input"
                                value="" >
                        </div>

                    </div>
                </div>
            </div>

            <div class="mb-4"></div>
            {{-- ------------------------------------------------------------------------------------------ --}}
            <div class="card" id="act_summary_report">
                <div class="card-header custom-header-bg">
                    <i class="bi bi-clipboard-data"></i> Activity Summary Report
                </div>
             <div class="card-body">
                <div class="row">
                        <div class="col-md-4 align-items-center gap-2">
                            <label for="validationServer10" class="form-label">Activity Date:</label>
                            <input type="date" class="form-control" id="validationServer10" name="act_date_Input"
                            value="{{ now()->format('Y-m-d') }}" min="2023-01-01">
                        </div>
                    

                        <div class="col-md-4 align-items-center gap-2">
                            <div class="col align-items-center gap-2">
                                <label for="Activity_Type_Create" class="form-label">Activity Type:</label>
                                <select class="form-control" id="Activity_Type_Create" value="" name="act_type_Input">
                                    <option value="" disabled selected>--Select Activity Type--</option>
                                    <!-- Options will be dynamically populated -->
                                </select>   
                            </div>     
                            <div id="actTypeError" class="text-danger"></div>
                        </div>

                        <div class="col-md-4 align-items-center gap-2">
                            <div class="col align-items-center gap-2">
                                <label for="Program_Create" class="form-label">Program</label>
                                <select class="form-control" id="Program_Create" name="program_Input">
                                    <!-- Options will be dynamically populated -->
                                </select>
                            </div>
                            <div id="programError" class="text-danger"></div>
                        </div>
                        
                    </div>
                    <div class="row mt-2" id="time_form" >
                        <div class="col-md-4 align-items-center gap-2  mt-2">
                            <div>
                                <label for="time_expected" class="form-label">Time Expected From Client:</label>
                                <select class="form-select get_time" id="time_expected" aria-describedby="time_expected" name="time_expected_Input">
                                    <option value=""  selected>--Select Time--</option>
                                </select>
                            </div>
                            <div id="time_expectedError" class="text-danger"></div>
                        </div>
                        
                        <div class="col-md-4 align-items-center gap-2  mt-2">
                            <div>
                                <label for="time_reported" class="form-label">Time Reported to Client:</label>
                                <select class="form-select get_time" id="time_reported" aria-describedby="time_reported" name="time_reported_Input" >
                                <option value=""  selected>--Select Time--</option>
                                </select>
                            </div>
                            <div id="time_reportedError" class="text-danger"></div>
                        </div>

                        <div class="col-md-4 align-items-center gap-2  mt-2">
                            <div>
                                <label for="time_exited" class="form-label">Time Exited From Client:</label>
                                <select class="form-select get_time" id="time_exited" aria-describedby="time_exited" name="time_exited_Input">
                                    <option value=""  selected>--Select Time--</option>
                                </select>
                            </div>  
                            <div id="time_exitedError" class="text-danger"></div>    
                        </div>


                    </div>

                 <div class="row mt-3 ">     
                    <div class="col-md-4 align-items-center gap-2 mt-2">
                        <div class="mb-3">
                            <div>
                                <label for="product_line_select" class="form-label">Product Line: 
                                <small style="color:rgb(156, 156, 156);"><i>(Select Product Lines)</i></small>
                              </label>
                              <select class="form-select" id="product_line_select" placeholder="" value=""></select>
                           </div>
                           <div id="productLineError" class="text-danger"></div>
                        </div>
                        
                        <div class="mb-3">
                            <div>
                                <label for="prod_code" class="form-label">Product Code:</label>
                                <input type="text" class="form-control" id="prod_code" placeholder="" value="" disabled>
                             
                            </div>
                        </div>
                    </div>
                      
                        <input type="hidden" id="product_line_input" name="productLines[]" >
                        <input type="hidden" id="prod_code_input"  name="productCodes[]">
                    
                       <div class="col align-items-center gap-2 ">
                        <div class="align-items-center mt-2">
                            <div class="align-items-center mt-2">
                                <div class="align-items-center mt-2">
                                    <div>
                                        <label for="engineer" class="form-label me-2">Engineer:</label>
                                        <select class="form-select gap-2" id="engineer" name="engineer_Input[]" multiple style="width: 100%;"></select>
                                        <div id="engineer_email_container"></div> <!-- Dynamic hidden inputs go here -->
                                    </div>
                                    
                                  
                                </div>
                            </div>
                            
                            <div id="engrError" class="text-danger"></div>
                        </div>
                        
                        
                            <div class="align-items-center mt-3">
                                <div>
                                    <label for="send_copy_To" class="form-label">Send Copy To:</label>
                                    <textarea class="form-control" id="send_copy_To" name="send_copy_To"
                                              placeholder="Enter email addresses separated by comma, for internal and external contacts"
                                              style="height: 100px;"></textarea>
                                </div>
                                <div id="emailError" style="color: #DC3545; display: none;">Please enter valid email address</div>
                            </div>
                        </div>
                    <div class="col-md-4 mt-2" id="venue_form">
                        <div class=" align-items-center">
                            <label for="venue" class="form-label me-2">Venue:</label>
                            <input type="text" class="form-control gap-2" id="venue" placeholder="" value="" name="venue_Input"> 
                        </div>
                        <div id="venueError" class="text-danger"></div>
                    </div>
                       
                 </div>
                </div>
            </div>
            <div class="mb-4"></div>
            {{-- Tech or Prod Skills--}}
            <div class="card" id="techProdCardbody">
                <div class="card-header custom-header-bg">
                    <i class="bi bi-gear"></i> Technology or Product Skills Development 
                </div>
                <div class="card-body">
                    <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Technology/ Product Learned:</div>
                            </div>
                            <input type="text" class="form-control" id="techprodLearned" name="techProdLearnedInput">
                        </div>
                        <div id="technologyError" class="text-danger"></div>
                    </div>
                </div>

            </div>
            <div class="mb-4"></div>
            {{-- Training Name --}}
            <div class="card" id="trainingCardBody">
                <div class="card-header custom-header-bg">
                    <i class="bi bi-lightbulb"></i> Skills Development 
                </div>
                <div class="card-body" row>
                    <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Training Name:</div>
                            </div>
                            <input type="text" class="form-control" id="trainingName" name="training_Name_Input">
                        </div>
                        <div id="trainingNameError" class="text-danger"></div>
                    </div>
                    <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Location:</div>
                            </div>
                            <input type="text" class="form-control" id="location" name="training_location">
                        </div>
                        <div id="locationError" class="text-danger"></div>
                    </div>
                    <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Speaker/s:</div>
                            </div>
                            <input type="text" class="form-control" id="speaker" name="training_speaker">
                        </div>
                        <div id="speakerNameError" class="text-danger"></div>
                    </div>
                    <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Attendees:</div>
                            </div>
                            <div style="margin-left: 2%" class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input chkAttendess" type="checkbox" name="BPsInput" id="bpCheckbox" value="1">
                                    <label class="form-check-label" for="bpCheckbox">BPs</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input chkAttendess" type="checkbox" name="EUsInput" id="euCheckbox" value="1">
                                    <label class="form-check-label" for="euCheckbox">EUs</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input chkAttendess" type="checkbox" name="MSIInput" id="MSICheckbox" value="1">
                                    <label class="form-check-label" for="MSICheckbox">MSI</label>
                                </div>      
                                <div id="attendeesError" class="text-danger"></div>                          
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4"></div>
            {{-- Exam Status --}}
            <div class="card" id="examStatus">
                <div class="card-header custom-header-bg">
                    <i class="bi bi-vector-pen"></i> Technical Certification
                </div>
                <div class="card-body row">
                    <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Title:</div>
                            </div>
                            <input type="text" class="form-control" id="title" name="exam_title">
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col align-items-center gap-2 mb-4" style="margin-top: 15px;">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Exam Code/Name:</div>
                            </div>
                            <input type="text" class="form-control" id="examCode" name="exam_code">
                        </div>
                        <div id="examCodeError" class="text-danger"></div>
                    </div>

                    <div class="w-100"></div>
                    <div class="col-md-4 align-items-center gap-4 mb-4">
                        <div class="col d-flex align-items-center gap-4 mb-4">
                            <label for="takeStatusDropdown" class="col-md-3">Take Status:</label>
                            <select class="form-select" id="takeStatusDropdown"
                                aria-haspopup="true" aria-expanded="false"
                                style="width: 300px;" name="takeStatusDropdown"
                                data-ar-take-status="">
                                <option value="" selected>Select Option </option>
                                <option value="1">Take 1 </option>
                                <option value="2">Take 2 </option>
                                <option value="nth">Nth Take</option>
                            </select>
                        </div>
                        <div id="TakeStatusError" class="text-danger"></div>
                    </div>

                    <div class="col-md-3 align-items-center gap-2 mb-4">
                        <div class="col d-flex align-items-center gap-2 mb-4">
                            <label for="scoreDropdown" class="me-2">Score:</label>
                            <select class="form-select " id="scoreDropdown"
                            aria-haspopup="true" aria-expanded="false"
                                style="width: 300px;" name="score_type">
                                <option value="" selected >Select Option </option>
                                <option value="Passed">Passed</option>
                                <option value="Failed">Failed</option>
                            </select>
                        </div>
                        <div id="scoreError" class="text-danger"></div>
                    </div>
                    <div class="col-md-5 d-flex align-items-center gap-3 mb-5">
                        <label for="examTypeDropdown" class="col-md-2">Exam Type:</label>
                        <select class="form-select " id="examTypeDropdown"
                            aria-haspopup="true" aria-expanded="false"
                            style="width: 300px;" name="examTypeDropdown">
                            <option value="" selected >Select Option </option>
                            <option value="1">Prometric Technical Exam</option>
                            <option value="2">Prometric Sales Exam</option>
                            <option value="3">Online Technical Exam</option>
                            <option value="4">Online Sales Exam</option>
                        </select>

                    </div>
                    <div class="col-md-5 d-flex align-items-center mb-4" >
                        <label for="incentiveStatusDropdown" class="col-md-4">Incentive
                            Status:</label>
                        <select class="form-select " id="incentiveStatusDropdown"
                            aria-haspopup="true" aria-expanded="false"
                            style="width: 300px;" name="incentiveStatusDropdown">
                            <option value="" selected>Select Option </option>
                            <option value="1">For HR Request</option>
                            <option value="2">Collected</option>
                            <option value="3">No Incentive</option>
                        </select>

                    </div>

                    <div class="col-md-7 d-flex align-items-center mb-4">
                        <label for="incentiveDetailsDropdown" class="col-md-3 ">Incentive
                            Details:</label>
                        <select class="form-select" id="incentiveDetailsDropdown"
                            aria-haspopup="true" aria-expanded="false"
                             name="incentiveDetailsDropdown">
                            <option value="" > </option>
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

                    <div class="col-md-5  align-items-center gap-2 mt-2">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Incentive Amount:</div>
                            </div>
                            <input type="text" class="form-control" id="amount" name="incentive_amt">
                        </div>
                    </div>


                </div>

            </div>
            {{-- ------------------------------------------------------------------------------------------ --}}
            <div class="mb-4"></div>

            <div class="card" id="OthersTopicCard">

                <div class="card-body">
                    <div id="topic_input">
                        <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Topic:</div>
                                </div>
                                <input type="text" class="form-control" id="modal_topicName" name="topicName">
                            </div>
                        <div id="topicError" class="text-danger"></div>
                        </div>

                        <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Date Start:</div>
                                </div>
                                <input type="date" class="form-control" id="modal_dateStart" name="dateStart">
                            </div>
                        <div id="dateStartError" class="text-danger"></div>
                        </div>
        
                        <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Date End:</div>
                                </div>
                                <input type="date" class="form-control" id="modal_dateEnd" name="dateEnd">
                            </div>
                        <div id="dateEndError" class="text-danger"></div>
                        </div>
                    </div>

                    {{-- (POC) Proof Of Concept --}}
                        <div id="pocCardBody">
                            <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Product Model:</div>
                                    </div>
                                    <input type="text" class="form-control" id="modal_prodModel" name="prod_model">
                                </div>
                             <div id="prodModError" class="text-danger"></div>
                            </div>
                            <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Asset or Code:</div>
                                    </div>
                                    <input type="text" class="form-control" id="modal_assetCode" name="asset_code">
                                </div>
                                <div id="assetError" class="text-danger"></div>
                            </div>   

                            <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Date Start:</div>
                                    </div>
                                    <input type="date" class="form-control" id="modal_poc_dateStart" name="poc_dateStart">
                                </div>
                                 <div id="pocDateStartError" class="text-danger"></div>
                            </div>
            
                            <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Date End:</div>
                                    </div>
                                    <input type="date" class="form-control" id="modal_poc_dateEnd" name="poc_dateEnd">
                                </div>
                                <div id="pocDateEndError" class="text-danger"></div>
                            </div>
                        </div>           

                    <div id="othersDigiKnow">
                        <div class="row align-items-center" id="digiknowFlyersattachment">
                            <div class="col-md-5 mt-2">
                                <div class="input-group">
                                    <label for="digiknowFlyersattValid" class="mt-2 me-2">Attach DIGIKnow Flyer:</label>
                                    <input type="file" class="form-control" id="digiknowFlyersattValid" name="digiknowFlyers"
                                        aria-describedby="digiknowFlyersattValid" onchange="DigiknowFlyerValidation()">                 
                                </div>
                                <div id="digiKnowFileError" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Recipients:</div>
                                </div>
                                <div style="margin-left: 2%" class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input recipientsChk" type="checkbox" name="BPsInputDigiknow" id="bpDigiCheckbox" value="1">
                                        <label class="form-check-label" for="bpCheckbox">BPs</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input recipientsChk" type="checkbox" name="EUsInputDigiknow" id="euDigiCheckbox" value="1">
                                        <label class="form-check-label" for="euCheckbox">EUs</label>
                                      </div>
                                <div id="recipientsError" class="text-danger"></div>
                                </div>  
                            </div>
                        </div>
                    </div>

                    <div id="otherInternalProject">
                        <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">MSI Project Name:</div>
                                </div>
                                <input type="text" class="form-control" id="modal_MSIProjName" name="MSIProjName" >
                            </div>
                            <div id="msiProjError" class="text-danger"></div>
                        </div>

                        <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Compliance Percentage:</div>
                                </div>
                                <input type="text" class="form-control" id="modal_CompliancePercentage"  name="CompliancePercentage">
                            </div>
                            <div id="comPercentError" class="text-danger"></div>
                        </div>
                    </div>

                    <div id="attendancePerfect">
                        <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Perfect Attendance:</div>
                                </div>
                                <input type="month" class="form-control" id="modalperfectAttendance"  name="perfectAttendance" value="">
                            </div>
                            <div id="perfectAttError" class="text-danger"></div>
                        </div>
                    </div>

                    <div id="othersMemo">
                        <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Memo Issued:</div>
                                </div>
                                <input type="date" class="form-control" id="modal_memoIssued"  name="memoIssued">
                            </div>
                            <div id="memoIssuedError" class="text-danger"></div>
                        </div>
                        <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Memo Details:</div>
                                </div>
                                <input type="text" class="form-control" id="memoDetails"  name="memoDetails">
                            </div>
                            <div id="memoDetailsError" class="text-danger"></div>
                        </div>
                    </div>

                    <div id="engrFeedback">
                        <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Feedback On Engineer:</div>
                                </div>
                                <input type="text" class="form-control" id="modal_engrFeedbackInput"  name="engrFeedbackInput">
                            </div>
                            <div id="engrFeedbackError" class="text-danger"></div>
                        </div>
                        <div class="col  align-items-center gap-2 mb-2" style="margin-top: 15px;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rating:</div>
                                </div>
                                <select class="form-control" id="modal_other_rating" style="width: 200px;" name="rating_input">
                                    <option value="" hidden > <--- Select Rating ---> </option>
                                    <option value="1">1 Very Satifactory</option>
                                    <option value="2">2 Satisfactory</option>
                                    <option value="3">3 Just Right</option>
                                    <option value="4">4 Unsatisfactory</option>
                                    <option value="5">5 Very Unsatifactory</option>
                                </select>
                            </div>
                            <div id="engrRatingError" class="text-danger"></div>
                        </div>
                    </div>
                    
                   
                   
    
                </div>

            </div>
            <div class="mb-4"></div>
            

            <div class="card" id="MultiParticipant">
                <div class="card-header custom-header-bg">
                    <i class="bi bi-people"></i> Participants and Positions 
                </div>

                <div class="card-body">
                    <div class="row  cloned-fields">
                        <div class="col-md-5">
                            <div class="participant-container mb-3">
                                <label for="validationServer12" class="form-label">Participant:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control email-input" id="participant" name="participant_Input[]"
                                        placeholder="Enter Participant" value="" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="position-container mb-3">
                                <label for="validationServer12" class="form-label">Position:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control email-input" placeholder="Enter Position" id="position" name="position_Input[]"
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

            <div class="mb-4"></div>

            <div class="card" id="customer_req">
                <div class="card-header custom-header-bg">
                    <i class="bi bi-exclamation-circle"></i> I. Customer Requirements 
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                            <textarea class="form-control" id="cust_requirementsTextarea" rows="3" name="cust_requirements_Input" placeholder="Customer Requirements Field"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4"></div>

            <div class="card" id="act_done">
                <div class="card-header custom-header-bg">
                    <i class="bi bi-check-circle"></i> II. Activity Done 
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                            <textarea class="form-control" id="activity_done" rows="3" name="activity_done_Input" placeholder="Activity Done Field"></textarea> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4"></div>

            <div class="card" id="agreements">
                <div class="card-header custom-header-bg">
                    <i class="bi bi-key"></i> III. Agreements 
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                            <textarea class="form-control" id="agreements_Input" rows="3" name="agreements_Input" placeholder="Agreements Field"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4"></div>
            
            <div class="card" id="act_plan_recommendation">
                <div class="card-header custom-header-bg">
                    <i class="bi bi-hand-thumbs-up"></i> IV. Action Plan / Recommendation 
                </div>

                <div class="card-body">
                    <div class="row  cloned-action-plan-recommendation">
                        <div class="col-md-3">
                            <div class="participant-container mb-3">
                                <label for="validationServer12" class="form-label">Starting Date:</label>
                                <div class="input-group">
                                    <input type="date" class="form-control email-input"
                                        placeholder="Enter Starting Date" name="starting_date[]" min="2023-01-01">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="position-container mb-3">
                                <label for="validationServer12" class="form-label">Details:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control email-input" placeholder="Enter Details" name="details_input[]"
                                        value="" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="position-container mb-3">
                                <label for="validationServer12" class="form-label">Owner:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control email-input" placeholder="Enter Owner" name="owner_input[]"
                                        value="" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 d-flex justify-content-center gap-2">
                            <button class="btn btn-success add-field1" type="button">Add</button>
                            <button class="btn btn-danger remove-field1" type="button">Remove</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row input-note  align-items-center" id="attachment">
                {{-- <div class="col-md-5" style="display: none;"> --}}
                <div class="col-md-5">
                    <div class="input-group">
                        <input type="file" class="form-control" id="act_reportFile" name="image"
                            aria-describedby="inputGroupFileAddon04"  onchange="Filevalidation()">                 
                    </div>
                </div>
               
                <div class="col-md-5">
                        <small class="text">Note: The file should be less than 10MB.</small>
                </div>

                <div class="mb-3" style="color:rgb(128, 128, 128);">
                    <p id="size"></p>
                </div>
            </div>

            <div id="newAct_Btn">
                <div class="row mt-3 cancel justify-content-center d-flex gap-2" >

                    <a href="{{ route('tab-activity.index') }}" class="btn btn-danger" style="width: fit-content"  type="button">Cancel</a>
    
                    <button class="btn btn-primary" style="width: fit-content" id="saveActBtn" type="submit">Submit form</button>
    
                </div>
            </div>
          
            <div id="loadingScreen" style="display: none;">
                <p>Please wait, your request is being processed...</p>
                <div class="progress" style="width: 80%;">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;"></div>
                </div>
              </div>


        </form>
    </div>

</form>

    <!-- Include jQuery before other scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Include DataTables Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="{{ asset('assets/tab-activity/script.js') }}"></script>
@endsection
