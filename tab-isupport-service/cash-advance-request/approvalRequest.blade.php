<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('assets/img/official-logo-cropped.png') }}" type="image/png">
    <title>Approval Request</title>
    <style>
        .title {
            margin-top: 2rem;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            text-transform: uppercase;
        }
        .swal2-small-popup {
        width: 400px !important;
        padding: 1.25em !important;
        font-size: 0.8rem !important;
        }
        .swal2-small-title {
            font-size: 1.1rem !important;
        }
        .swal2-small-content {
            font-size: 0.9rem !important;
        }
        .swal2-small-confirm-button,
        .swal2-small-cancel-button {
            font-size: 0.8rem !important;
            padding: 0.3em 1em !important;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
</head>
<body>
    <div class="row">
        <center>
            <p class="title mt-4 mb-4">{{ $record->project_type}} Budget Request</p>
            <p class="mt-4 mb-4" style="text-align: left; margin-left: 5%;">
                Status: <span id="statusText" class="alert px-2 py-1 m-0">{{ $record->status }}</span>
            </p>
            

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
                            <td style="padding: 8px; border: 1px solid #000000; width: 37.07%;">
                                <div class="input-prepend input-group">
                                    <span>{{ $record->enduser_contact }}</span>
                                </div>
                            </td>
                            <td style="padding: 8px; border: 1px solid #000000;  width: 9.39%;">
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
                                <td style="padding: 8px; border: 1px solid #000000; width: 37.07%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->enduser_email }}</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 9.39%;">
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
                                <td style="padding: 8px; border: 1px solid #000000; width: 37.07%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->enduser_location }}</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 9.39%;">
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
                            <td style="padding: 8px; border: 1px solid #000000; width: 13.55%;">
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
                            <td style="padding: 8px; border: 1px solid #000000; width: 9.39%;">
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
                                <td style="padding: 8px; border: 1px solid #000000; width: 37.07%;">
                                    <div class="input-prepend input-group">
                                        <span>{{ $record->payment_status }}</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 9.39%; background-color: #eeeeee;">
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
                                    <div class="input-prepend input-group" style="margin-top: 10px; ">
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
                                    <div class="input-prepend input-group" style="margin-top: 10px; ">
                                        <span style="margin-right: 50px; " >Product Line: </span>
                                        <span><u>{{ $record->division2 }} | {{ $record->prod_line }}</u></span>
                                    </div>
                                    <div class="input-prepend input-group" style="margin-top: 10px; ">
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

                <div style="text-align: center; margin-top: 20px; padding-bottom: 2rem">
                    @if($record->status === 'Approved')
                    <button id="printButton"
                        style="background-color: #0056b3; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 4px; margin-right: 10px;">
                        Print
                    </button>  
                    @else     
                    <button id="printButton"
                        class="{{ $record->status !== 'Approved' ? 'd-none' : '' }}"
                        style="background-color: #0056b3; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 4px; margin-right: 10px;">
                        Print
                    </button> 
                    @endif
                 @if($record->status === 'For Approval')
                    <a href="#"
                    onclick="handleAction('{{ $approveUrl }}', 'Are you sure you want to approve this?', 'Approved successfully!')"
                    style="background-color: #2b6b2d; color: white; padding: 10px 20px; border: none; cursor: pointer; margin-right: 10px; text-decoration: none">
                    Approve
                    </a>

                    <a href="#"
                    onclick="handleAction('{{ $disapproveUrl }}', 'Are you sure you want to disapprove this?', 'Disapproved successfully!')"
                    style="background-color: #b84d4d; color: white; padding: 10px 20px; border: none; cursor: pointer; margin-right: 10px; text-decoration: none">
                    Disapprove
                    </a>
                @endif
                   
                </div>       
                <footer>
                    <div style="margin-top: 20px; text-align: center;">
                        <p>© 2025 Copyright VST ECS Phils., Inc. All rights reserved..</p>
                    </div>
                </footer>         
        <center>
    </div>

    <script src="{{ asset('assets/tab-isupport-service/approval-request.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>


   <script>
    document.getElementById('printButton').addEventListener('click', function () {
        fetch('{{ route('cash-advance.request.print', ['hash' => $record->hash]) }}')
            .then(response => response.text())
            .then(html => {
                const printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write(html);
                printWindow.document.close();
                printWindow.focus();

                // Store the print window object for later reference
                window.printWindowObj = printWindow;
            });
    });

    function handleAction(url, confirmText, successMessage) {
        Swal.fire({
            title: 'Confirm',
            text: confirmText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed',
            customClass: {
                popup: 'swal2-small-popup',
                title: 'swal2-small-title',
                content: 'swal2-small-content',
                confirmButton: 'swal2-small-confirm-button',
                cancelButton: 'swal2-small-cancel-button',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                sessionStorage.setItem('successMessage', successMessage);
                setTimeout(() => {
                    window.location.href = url;
                }, 100); 
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const message = sessionStorage.getItem('successMessage');
        if (message) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: message,
                timer: 2000,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal2-small-popup',
                    title: 'swal2-small-title',
                    content: 'swal2-small-content',
                }
            });
            sessionStorage.removeItem('successMessage');
        }
    });

</script>

    
        
</body>

</html>
