<!DOCTYPE html>
<html>
<head>
    <title>Print Cash Advance Request</title>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 1cm;
            }
    
            html, body {
                font-family: Arial, sans-serif;
                color: #000;
                margin: 0;
                padding: 0;
                zoom: 85%;
            }
    
            .no-print {
                display: none;
            }
    
            .print-container {
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
                font-size: 11px;
            }
    
            .title {
                font-size: 14px;
                font-weight: bold;
                margin: 10px 0;
            }
    
            table {
                border-collapse: collapse;
                width: 100%;
            }
    
            table td, table th {
                padding: 6px;
                vertical-align: top;
            }
    
            .input-prepend {
                display: inline-block;
            }
    
            p {
                margin: 4px 0;
            }
        }
    
        /* Optional: on-screen styles */
        .print-container {
            width: 100%;
            max-width: 100%;
            margin: auto;
        }
    
        .no-print {
            margin-top: 20px;
        }
    </style>
    
</head>
<body>
    <div class="print-container">
        <div class="row">
            <center>
               <div style="width: 90%; max-width: 90%; position: relative; text-align: center; margin-top: 3em; margin-bottom: 3em;">
                    <img src="{{ asset('assets/img/official-logo.png') }}" 
                        alt="Logo" 
                        style="height: 6em; position: absolute; left: 0; top: 50%; transform: translateY(-50%);">
                    
                    <p class="title" style="margin: 0;">{{ $record->project_type }} Budget Request</p>
                </div>
            </center>

            <center>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <td style="padding: 8px; border: 1px solid #000000;">
                                    <div class="input-prepend input-group">
                                        <span>Requested by</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 37%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->requested_by }}</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 9.5%;">
                                    <div class="input-prepend input-group">
                                        <span>Date Filed</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 40%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->date_filed }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
    
                    <!-- Second row: Person(s) Implementing (independent width) -->
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <td style="padding: 8px; border: 1px solid #000000;">
                                    <div class="input-prepend input-group">
                                        <span>Person(s) Implementing</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 86.5%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->person_implementing }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
    
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <thead cellpadding="0" cellspacing="0" border="0">
                            <tr cellpadding="0" cellspacing="0" border="0">
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000; text-align: center; background-color: #eeeeee;">
                                    Project Details
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <td style="padding: 8px; border: 1px solid #000000;">
                                    <div class="input-prepend input-group">
                                        <span>Reseller</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 37%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->reseller_name }}</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000;">
                                    <div class="input-prepend input-group">
                                        <span>Project</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 40%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->proj_name }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <td style="padding: 8px; border: 1px solid #000000;">
                                    <div class="input-prepend input-group">
                                        <span>Contact person</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 37%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->reseller_contact }}</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000;">
                                    <div class="input-prepend input-group">
                                        <span>Location</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 40%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->reseller_location }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <td style="padding: 8px; border: 1px solid #000000;">
                                    <div class="input-prepend input-group">
                                        <span>Email address</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 37%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->reseller_email }}</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000;">
                                    <div class="input-prepend input-group">
                                        <span>Date start</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 40%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->date_start }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <td style="padding: 8px; border: 1px solid #000000;">
                                    <div class="input-prepend input-group">
                                        <span>Enduser</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 37.1%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->enduser_name }}</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000;">
                                    <div class="input-prepend input-group">
                                        <span>Date end</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 40%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->date_end }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <td style="padding: 8px; border: 1px solid #000000;">
                                    <div class="input-prepend input-group">
                                        <span>Contact Person</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 37%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->enduser_contact }}</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000;  width:9.5%;">
                                    <div class="input-prepend input-group">
                                        <span>Man-days</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 20%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->mandays }}</span>  <!-- Adjust as needed -->
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 20%;">
                                    <div class="input-prepend input-group">
                                        <span>Days</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <tr style="padding: 8px; border: 1px solid #000000;">
                                    <td style="padding: 8px; border: 1px solid #000000;">
                                        <div class="input-prepend input-group">
                                            <span>Email address</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 37%;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $record->enduser_email }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 9.5%;">
                                        <div class="input-prepend input-group">
                                            <span>Cost/manday</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 40%;">
                                        <div style="display: flex; justify-content: space-between; width: 100%;">
                                            <span>PHP</span>
                                            <span>{{ $record->cost_manday }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </tr>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <tr style="padding: 8px; border: 1px solid #000000;">
                                    <td style="padding: 8px; border: 1px solid #000000;">
                                        <div class="input-prepend input-group">
                                            <span>Address</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 37%;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $record->enduser_location }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 9.5%;">
                                        <div class="input-prepend input-group">
                                            <span>Project Cost(Vatex)</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 40%;">
                                        <div style="display: flex; justify-content: space-between; width: 100%;">
                                            <span>PHP</span>
                                            <span>{{ $record->proj_cost }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <td style="padding: 8px; border: 1px solid #000000; width: 13.5%;">
                                    <div class="input-prepend input-group">
                                        <span>PO Number</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 17%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->po_number }}</span> 
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; ">
                                    <div class="input-prepend input-group">
                                        <span>SO Number</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 14%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->so_number }}</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 9.5%;">
                                    <div class="input-prepend input-group">
                                        <span>Expenses</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 40%;">
                                    <div style="display: flex; justify-content: space-between; width: 100%;">
                                        <span>PHP</span>
                                        <span>{{ $record->expenses }}</span>
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <tr style="padding: 8px; border: 1px solid #000000;">
                                    <td style="padding: 8px; border: 1px solid #000000;">
                                        <div class="input-prepend input-group">
                                            <span>Payment Status</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 37.09%;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $record->payment_status }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 9.5%; background-color: #eeeeee;">
                                        <div class="input-prepend input-group">
                                            <b>Margin</b>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 40%; background-color: #eeeeee;">
                                        <div style="display: flex; justify-content: space-between; width: 100%; ">
                                            <span>PHP</span>
                                            <span>{{ $record->margin }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <thead cellpadding="0" cellspacing="0" border="0">
                            <tr cellpadding="0" cellspacing="0" border="0">
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000; text-align: center; background-color: #eeeeee;">
                                    Charge to
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <tr style="padding: 8px; border: 1px solid #000000;">
                                    <td style="padding: 8px; border: 1px solid #000000;">
                                        <div class="input-prepend input-group">
                                            <span><u>Expenses should be charged under the following:</u></span>
                                        </div>
                                        <div class="input-prepend input-group" style="display: flex; align-items: center; gap: 20px; margin-top: 10px;">
                                            <span  style="margin-right: 20px; ">Charged to:</span>
                                            <label style="margin-right: 20px; "><input type="checkbox" {{ $record->charged_to_margin == 1 ? 'checked' : '' }} disabled> margin</label>
                                            <label style="margin-right: 20px; "><input type="checkbox" {{ $record->charged_to_parked_funds == 1 ? 'checked' : '' }} disabled> parked funds</label>
                                            <label style="margin-right: 20px; "><input type="checkbox" {{ $record->charged_to_others == 1 ? 'checked' : '' }} disabled> others</label>
                                            <span  style="margin-right: 20px; "><u>{{ $record->charged_others_input }}</u></span>
    
                                        </div>
                                        <div class="input-prepend input-group" style="display: flex; align-items: center; gap: 20px;  margin-top: 10px; ">
                                            <span  style="margin-right: 80px; " >Division: </span>
                                            <span> <u>
                                                @if($record->division == 'TPSA')
                                                    TPS A (Technology & Product Solutions Group A)
                                                @elseif($record->division == 'TPSB')
                                                    TPS B (Technology & Product Solutions Group B)
                                                @else
                                                    {{ $record->division }}
                                                @endif
                                            </u></span>
                                        </div>
                                        <div class="input-prepend input-group" style="display: flex; align-items: center; gap: 20px;  margin-top: 10px; ">
                                            <span style="margin-right: 50px; " >Product Line: </span>
                                            <span><u>{{ $record->division2 }} | {{ $record->prod_line }}</u></span>
                                        </div>
                                        <div class="input-prepend input-group" style="display: flex; align-items: center; gap: 20px;  margin-top: 10px; ">
                                            <span>Expenses should be posted as: </span>
                                        </div>
                                        <div class="input-prepend input-group" style="display: flex; align-items: center; gap: 20px; margin-top: 10px;">
                                            <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_DigiOne == 1 ? 'checked' : '' }} disabled> DigiOne</label>
                                            <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_marketingEvent == 1 ? 'checked' : '' }} disabled> Marketing Event</label>
                                            <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_travel == 1 ? 'checked' : '' }} disabled> Travel</label>
                                            <label style="margin-right: 20px; "><input type="checkbox"{{ $record->expense_training == 1 ? 'checked' : '' }} disabled> Training</label>
                                            <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_promos == 1 ? 'checked' : '' }} disabled> Promos</label>
                                            <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_advertising == 1 ? 'checked' : '' }} disabled> Advertising</label>
                                            <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_freight == 1 ? 'checked' : '' }} disabled> Freight</label>
                                            <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_representation == 1 ? 'checked' : '' }} disabled> Representation</label>
                                        </div>
                                        <div class="input-prepend input-group" style="display: flex; align-items: center; gap: 20px; margin-top: 10px;">
                                            <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_others == 1 ? 'checked' : '' }} disabled> Others</label>
                                            <span  style="margin-right: 20px; "><u>{{ $record->expense_others_input }}</u></span>
                                        </div>
                                    </td>
                                </tr>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <thead cellpadding="0" cellspacing="0" border="0">
                            <tr cellpadding="0" cellspacing="0" border="0">
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000; text-align: center; background-color: #eeeeee;">
                                    Budget Breakdown
                                </th>
                            </tr>
                        </thead>
                        <thead cellpadding="0" cellspacing="0" border="0">
                            <tr cellpadding="0" cellspacing="0" border="0">
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000; text-align: center; background-color: #ffffff;">
                                    Per Diem
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <tr style="padding: 8px; border: 1px solid #000000;">
                                    <td style="padding: 8px; border: 1px solid #000000; width: 20%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>Currency</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>Rate</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 20%; text-align: center;" >
                                        <div class="input-prepend input-group">
                                            <span>No. of Days</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 20%; text-align: center;" >
                                        <div class="input-prepend input-group">
                                            <span>No. of Pax</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 20%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>Total</span>
                                        </div>
                                    </td>
                                </tr>
                            </tr>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                @foreach ($record->per_diem as $perDiem)
                                <tr style="padding: 8px; border: 1px solid #000000;">
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $perDiem->perDiem_currency }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $perDiem->perDiem_rate }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $perDiem->perDiem_days }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $perDiem->perDiem_pax }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $perDiem->perDiem_total }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tr>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <thead cellpadding="0" cellspacing="0" border="0">
                            <tr cellpadding="0" cellspacing="0" border="0">
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000; text-align: center; background-color: #ffffff;">
                                </th>
                            </tr>
                        </thead>
                        <thead cellpadding="0" cellspacing="0" border="0">
                            <tr cellpadding="0" cellspacing="0" border="0">
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000; text-align: center; background-color: #ffffff;">
                                    Transportation
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <tr style="padding: 8px; border: 1px solid #000000;">
                                    <td style="padding: 8px; border: 1px solid #000000; width: 20%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>Date</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 15%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>Item Description</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 15%; text-align: center;" >
                                        <div class="input-prepend input-group">
                                            <span>From</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 15%; text-align: center;" >
                                        <div class="input-prepend input-group">
                                            <span>To</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 15%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>Amount</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 20%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>Total</span>
                                        </div>
                                    </td>
                                </tr>
                            </tr>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                @foreach ($record->transportation as $transportation)
                                <tr style="padding: 8px; border: 1px solid #000000;">
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $transportation->transpo_date }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $transportation->transpo_description }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $transportation->transpo_from }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $transportation->transpo_to }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $transportation->transpo_amount }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $transportation->transpo_total }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tr>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <thead cellpadding="0" cellspacing="0" border="0">
                            <tr cellpadding="0" cellspacing="0" border="0">
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000; text-align: center; background-color: #ffffff;">
                                </th>
                            </tr>
                        </thead>
                        <thead cellpadding="0" cellspacing="0" border="0">
                            <tr cellpadding="0" cellspacing="0" border="0">
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000;  background-color: #eeeeee;">
                                    Accommodation
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <tr style="padding: 8px; border: 1px solid #000000;">
                                    <td style="padding: 8px; border: 1px solid #000000; width: 20%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>Hotel</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 15%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>Daily Rate</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 15%; text-align: center;" >
                                        <div class="input-prepend input-group">
                                            <span>No of Room/s</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 15%; text-align: center;" >
                                        <div class="input-prepend input-group">
                                            <span>No of Nights</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 15%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>Amount</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 20%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span></span>
                                        </div>
                                    </td>
                                </tr>
                            </tr>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                @foreach ($record->accommodation as $accommodation)
                                <tr style="padding: 8px; border: 1px solid #000000;">
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $accommodation->accom_hotel }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $accommodation->accom_rate }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $accommodation->accom_rooms }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $accommodation->accom_nights }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $accommodation->accom_amount }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span>{{ $accommodation->accom_total }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tr>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <thead cellpadding="0" cellspacing="0" border="0">
                            <tr cellpadding="0" cellspacing="0" border="0">
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000; text-align: center; background-color: #ffffff;">
                                </th>
                            </tr>
                        </thead>
                        <thead cellpadding="0" cellspacing="0" border="0">
                            <tr cellpadding="0" cellspacing="0" border="0">
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000;  background-color: #eeeeee;">
                                    Miscellaneous Fees
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <tbody>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                <tr style="padding: 8px; border: 1px solid #000000;">
                                    <td style="padding: 8px; border: 1px solid #000000; width: 15%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span><b>Particulars</b></span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 22.5%;text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span><b>No. of Pax</b></span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 22.5%; text-align: center;" >
                                        <div class="input-prepend input-group">
                                            <span><b>Amount</b></span>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #000000; width: 15%; text-align: center;">
                                        <div class="input-prepend input-group">
                                            <span></span>
                                        </div>
                                    </td>
                                </tr>
                            </tr>
                            <tr style="padding: 8px; border: 1px solid #000000;">
                                @foreach ($record->miscFee as $miscellaneous)
                                    <tr style="padding: 8px; border: 1px solid #000000;">
                                        <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                            <div class="input-prepend input-group">
                                                <span>{{$miscellaneous->misc_particulars }}</span>
                                            </div>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                            <div class="input-prepend input-group">
                                                <span>{{$miscellaneous->misc_pax }}</span>
                                            </div>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                            <div class="input-prepend input-group">
                                                <span>{{$miscellaneous->misc_amount }}</span>
                                            </div>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #000000; text-align: center;">
                                            <div class="input-prepend input-group">
                                                <span>{{$miscellaneous->misc_total }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tr>
                    </table>
                    <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                        <thead cellpadding="0" cellspacing="0" border="0">
                            <tr cellpadding="0" cellspacing="0" border="0">
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000; text-align: right; background-color: #ffffff;">
                                    GRAND TOTAL 
                                </th>
                                <th colspan="3"
                                    style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000; text-align: right; background-color: #ffffff; width: 20%;">
                                    <span>{{$record->grand_total }}</span>
                                </th>
                            </tr>
                        </thead>
                    </table>
    
                    <footer>
                        <div style="margin-top: 40px; text-align: center;">
                            <table style="width: 100%; border: none; font-size: 12px; margin-bottom: 20px;">
                                <tr>
                                    <td style="width: 33%; text-align: center; border: none;">
                                        Requested By:<br><br>
                                        __________________________<br>
                                        <span style="font-size: 11px;">{{$record->requested_by }}</span><br>
                                        <span style="font-size: 11px;">Signature</span>
                                    </td>
                                   <td style="width: 33%; text-align: center; border: none;">
                                        Noted By:<br><br>
                                        __________________________<br>
                                        @if($record->division == 'TPSA')
                                            <span style="font-size: 11px;">Maybel Estipular</span><br>
                                            <span style="font-size: 11px;">Manager - TPS-A</span>
                                        @elseif($record->division == 'TPSB')
                                            <span style="font-size: 11px;">Justin Rivera</span><br>
                                            <span style="font-size: 11px;">Manager - TPS-B</span>
                                        @else
                                            <span style="font-size: 11px;">[Default Name]</span><br>
                                            <span style="font-size: 11px;">[Default Position]</span>
                                        @endif
                                    </td>
                                    <td style="width: 33%; text-align: center; border: none;">
                                        Approved By:<br><br>
                                        __________________________<br>
                                        <span style="font-size: 11px;">JIMMY D. GO</span><br>
                                        <span style="font-size: 11px;">President & CEO</span>
                                    </td>
                                </tr>
                            </table>
                    
                            <p style="font-size: 11px;">© 2025 Copyright VST ECS Phils., Inc. All rights reserved.</p>
                        </div>
                    </footer>
                       
            <center>
        </div>
    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
