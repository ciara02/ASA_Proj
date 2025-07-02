<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="{{ asset('assets/img/official-logo-cropped.png') }}" type="image/png">
    <title>Cash Advance Request</title>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="{{ asset('assets/tab-isupport-service/cash-advance-request.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    
</head>
<body class="">

    <div id="loading-spinner" style="display: none;">
        <div class="loading-overlay"></div>
        <div class="loading-content">
            <div class="progress" style="width: 500px; height: 10px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" 
                     role="progressbar" style="width: 100%"></div>
            </div>
            <p class="text-light mt-2">Sending your request...</p>
        </div>
    </div>   
    
    <div class=" mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <p class="title mt-4 mb-4">{{ $projectInfo->project_type->name}} Budget Request</p>
                <div class="mt-2 ps-2">
                    <p class="reportstatus" id="completionstatus" style="display: flex; align-items: center;">
                        Status: <span class="status" id="projstatus" name="status"></span>
                        <input type="hidden" id="projectID" name="projectID" value="{{ $projectInfo->id }}">
                        <input type="hidden" id="projectTypeName" name="projectTypeName" value="{{ $projectInfo->project_type->name ?? ''  }}">
                        <input type="hidden" id="requestedByEmail" name="requestedByEmail" value="{{ Auth::user()->email }}">
                        <input type="hidden" id="cashRequestIDValue" name="cashRequestID" value="">
                    </p>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-6">

                                <div class="input-group mb-3">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Requested By:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="requestedby_approval" name="txtrequestedBy"
                                        value="{{ $ldapEngineer && $ldapEngineer->fullName ? $ldapEngineer->fullName : '' }}" readonly />
                                </div>

                            </div>
                            <div class="col-md-6 mb-3">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Date Filed:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="fileddate_approval" name="txtDateFiled"
                                        value="{{ now()->format('Y-m-d') }}"  readonly/>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Person(s) Implementing
                                                :</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="PersonImplement_approval" name="txtPersonImplement" 
                                        value="{{ $ldapEngineer && $ldapEngineer->fullName ? $ldapEngineer->fullName : '' }}" />
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center" style="background-color: #0059b9; color: white;">
                        <h8><b>Project Details:</b></h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Reseller:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Reseller_approval" name="txtReseller"
                                        value="{{ $projectInfo->reseller }}"  />
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Project:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Project_approval" name="txtProject"
                                        value="{{ $projectInfo->proj_name }}"  />
                                </div>

                            </div>
                        </div>
                        <div class="row  mb-2">
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Contact Person:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Contact_approval" name="txtContact "
                                        value="{{ $projectInfo->rs_contact }}"  />
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Location:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Location_approval" name="txtLocation"
                                        value=""  />
                                </div>

                            </div>
                        </div>
                        <div class="row  mb-2">
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Email Address:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Emailaddress_approval" name="txtEmailaddress "
                                        value="{{ $projectInfo->rs_email }}"  />
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Date Start:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Datestart_approval" name="txtDatestart"
                                        value="{{ \Carbon\Carbon::parse($projectInfo->proj_startDate)->format('F d, Y') }}" />
                                </div>

                            </div>
                        </div>
                        <div class="row  mb-2">
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>End User:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Enduser_approval" name="txtEnduser "
                                        value="{{ $projectInfo->endUser }}"  />
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Date End:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Dateend_approval" name="txtDateend"
                                        value="{{ \Carbon\Carbon::parse($projectInfo->proj_endDate)->format('F d, Y') }}"  />
                                </div>                                

                            </div>
                        </div>
                        <div class="row  mb-2">
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Contact Person:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="ContactPerson_approval" name="txtContactPerson "
                                        value="{{ $projectInfo->eu_contact }}"  />
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Man-days:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Mandays_approval" name="txtMandays"
                                        value="{{ $projectInfo->manday }} "  />
                                     <input type="text" autocomplete="off" class="form-control"
                                        id="" value="Day/s"  readonly/>
                                </div>

                            </div>
                        </div>
                        <div class="row  mb-2">
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Email Address:</i></b></span>
                                    <input type="email" autocomplete="off" class="form-control"
                                        id="Emailaddress2_approval" name="txtEmailaddress2"
                                        value="{{ $projectInfo->eu_email }}"  />
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Cost/Manday:</i></b></span>
                                    <span class="input-group-text">PHP</span>
                                    <input type="number" autocomplete="off" class="form-control"
                                        id="Costmanday_approval" name="txtCostmanday"
                                        value="{{ $projectInfo->manday_cost }}"  />
                                </div>

                            </div>
                        </div>
                        <div class="row  mb-2">
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Address:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Address_approval" name="txtAddress "
                                        value="{{ $projectInfo->eu_location }}"  />
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Project Cost(Vatex):</i></b></span>
                                    <span class="input-group-text">PHP</span>
                                    <input type="number" autocomplete="off" class="form-control"
                                        id="ProjectCost_approval" name="txtProjectCost"
                                        value="{{ $projectInfo->proj_amount }}"  />
                                </div>

                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>PO Number:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="PONumber_approval" name="txtPONumber "
                                        value="{{ $projectInfo->ft_number }}"  />
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>SO Number:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="SONumber_approval" name="txtSONumber "
                                        value="{{ $projectInfo->so_number }}"  />
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Expenses:</i></b></span>
                                    <span class="input-group-text">PHP</span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Expenses_approval" name="txtExpenses" placeholder="0.00"
                                        value=""  />
                                </div>

                            </div>
                        </div>
                        <div class="row  mb-2">
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Payment Status:</i></b></span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="PaymentStatus_approval" name="txtPaymentStatus "
                                        value="{{ $projectInfo->financial_status->payment_status ?? '' }}"  />
                                </div>

                            </div>
                    
                            <div class="col-md-6">

                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;"><b><i>Margin:</i></b></span>
                                    <span class="input-group-text">PHP</span>
                                    <input type="text" autocomplete="off" class="form-control"
                                        id="Margin_approval" name="txtMargin" readonly placeholder="0.00"
                                        value=""  />
                                </div>

                            </div>

                           
                        </div>
                    </div>
                    <div class="card-header text-center " style="background-color: #0059b9; color: white;">
                        <h8><b>Charged To:</b></h8>
                    </div>
                    <div class="card-body">
                        <h9><u>Expenses should be charged under the following:</u></h9>
                        <div class="row mb-2 mt-2">
                            <div class="col-12">
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <span style="font-size: 14px;"><b><i>Charged To:</i></b></span>
                        
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="margin" id="margin1" value="margin">
                                        <label class="form-check-label" for="margin1">Margin</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="parkedFunds" id="parkedFunds" value="parkedFunds">
                                        <label class="form-check-label" for="margin2">Parked Funds</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="others" id="others" value="Others2">
                                        <label class="form-check-label" for="margin3">Others</label>
                                    </div>
                        
                                    <input type="text" autocomplete="off" class="form-control ms-2" id="charged_others" name="txtSONumber" value=""  style="max-width: 500px;" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="input-group mb-2">
                            <span class="input-group-text " style="font-size: 14px;"><b><i>Divison:</i></b></span>
                            <select class="form-control" id="division1" name="division1">
                                <option value="TPSA" >TPS A (Technology & Product Solutions Group A) </option>
                                <option value="TPSB">TPS B (Technology & Product Solutions Group B) </option>
                            </select>
                           
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="font-size: 14px;"><b><i>Product Line:</i></b></span>
                            <select class="form-control" id="division2" name="division2" disabled>
                                <option value="TPS A" >TPS A</option>
                                <option value="TPS B">TPS B</option>
                            </select>
                            <input type="text" autocomplete="off" class="form-control"
                                id="prodLine_approval" name="txtprodLine " style="width: 1000px;"
                                value="{{ $projectInfo->product_line ?? '' }}"  />
                        </div>
                        <div class="row mb-3 mt-2">
                            <h6><u>Expenses should be posted as:</u></h6>
                            <div class="col">
                                <div class="d-flex align-items-center" style="gap: 10px; border: none;">
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="DigiOne" id="DigiOne" value="DigiOne">
                                        <label class="form-check-label" for="DigiOne">DigiOne</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="MarketingEvent" id="MarketingEvent" value="MarketingEvent">
                                        <label class="form-check-label" for="MarketingEvent">Marketing Event</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="Travel" id="Travel" value="Travel">
                                        <label class="form-check-label" for="Travel">Travel</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="Training" id="Training" value="Training">
                                        <label class="form-check-label" for="Training">Training</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="Promos" id="Promos" value="Promos">
                                        <label class="form-check-label" for="Promos">Promos</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="Advertising" id="Advertising" value="Advertising">
                                        <label class="form-check-label" for="Advertising">Advertising</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="Freight" id="Freight" value="Freight">
                                        <label class="form-check-label" for="Freight">Freight</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="Representation" id="Representation" value="Representation">
                                        <label class="form-check-label" for="Representation">Representation</label>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-2 " style="gap: 10px; border: none;">
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="Others" id="expenses_Others" value="expenses_Others">
                                        <label class="form-check-label" for="Others">Others</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" autocomplete="off" class="form-control"
                                        id="expenses_others_input" name="expenses_others_input "
                                        value=""  />     
                                    </div>  
                                </div>
                                </div>
                        
                                <!-- Duplicate block (you might want to remove one) -->
                                <div class="d-flex align-items-center mt-2" style="gap: 10px; border: none;">
                                    
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-header text-center " style="background-color: #0059b9; color: white;">
                        <h8><b>Budget Breakdown:</b></h8>
                    </div>
                    <div class="card-body">
                          <h5><u>Per Diem</u></h5>
                          
                          <table class="table table-bordered" id="inputTable">
                            <thead class="table-light">
                              <tr>
                                <th>Currency</th>
                                <th>Rate</th>
                                <th>No. of Days</th>
                                <th>No. of Pax</th>
                                <th>Total</th>
                              </tr>
                            </thead>
                            <tbody id="perDiemBody">
                            </tbody>
                          </table>
                      
                          <div class="text-end mt-2">
                            <button type="button" id="addPerDiemRow" class="btn btn-primary">Add Row</button>
                            <button type="button" id="removePerDiemRow" class="btn btn-danger">Remove Row</button>

                          </div>
                      </div>
                      
                    <div class="card-body">
                            <h5><u>Transportation</u></h5>
                            <table class="table table-bordered" id="transpoTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Item Description</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="transpoBody">

                                </tbody>
                            </table>
                            <div class="text-end mt-2">
                                <button type="button" id="addTranspoRow" class="btn btn-primary">Add Row</button>
                                <button type="button" id="removeTranspoRow" class="btn btn-danger">Remove Row</button>
                            </div>

                    </div>
                    <div class="card-body">
                            <h5><u>Accommodation</u></h5>
                            <table class="table table-bordered" id="accTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Hotel</th>
                                        <th>Daily Rate</th>
                                        <th>No. of Room/s</th>
                                        <th>No. of Nights</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="accBody">
 
                                </tbody>
                            </table>
                            <div class="text-end mt-2">
                                <button type="button" id="addAccRow" class="btn btn-primary">Add Row</button>
                                <button type="button" id="removeAccRow" class="btn btn-danger">Remove Row</button>
                            </div>
                    </div>
                    <div class="card-body">
                          <h5><u>Miscellaneous Fees</u></h5>
                          <table class="table table-bordered" id="inputTable">
                            <thead class="table-light">
                              <tr>
                                <th>Particulars</th>
                                <th>No. of Pax</th>
                                <th>Amount</th>
                                <th>Total</th>
                              </tr>
                            </thead>
                            <tbody id="miscBody">

                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="3" class="text-end"><b>Grand Total:</b></td>
                                <td><input type="text" class="form-control no-border" id="grandTotal" readonly></td>
                              </tr>
                            </tfoot>
                          </table>
                    </div>
                    
                        
                </div>


                <!-- End Approvers Card -->

                <!-- Buttons -->
                <div class="row mb-4">
                    <div class="col text-center">
                        <button type="button" class="btn btn-danger me-1" id="back">Back</button>
                        <button type="button" class="btn btn-warning me-1" id="saveRequest">Submit for Approval</button>
                    </div>
                </div>
                <!-- End Buttons -->
            </div>
        </div>
    </div>
    <footer>
        <div style="margin-top: 20px; text-align: center;">
            <p>© 2025 Copyright VST ECS Phils., Inc. All rights reserved..</p>
        </div>
    </footer>
    <!-- Your form or other content will go here -->
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- (Optional) Bootstrap JS if needed -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.7/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('assets/tab-isupport-service/cash-advance-request.js') }}"></script>
</body>
</html>
