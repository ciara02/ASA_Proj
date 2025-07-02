<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Approval Request</title>
    <style>
        .title {
            margin-top: 2rem;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            text-transform: uppercase;
        }
        .alert-warning{
            background-color: yellow;   /* Custom yellow background */
            color: black;                /* Text color */
            font-weight: bold;           /* Bold text */
            padding: 5px 10px;           /* Padding */
            border-radius: 5px;          /* Rounded corners */
            margin-top: 11px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <p>Hi MSI TPS Heads,</p>
    <p>Good day!</p>
    <p>This is to inform you that a cash advance request for <b>{{ $record->proj_name }}</b> has been created by <b>{{ $record->requested_by }}</b> and is now pending your approval. The project reference number is <b>{{ $record->proj_ref_id }}</b>.
    <p>Kindly review and validate the details before proceeding with the approval.</p>
    <p><a href="{{ $viewUrl }}" class="button">Click here to open the request.</a></p>  
    <br>
    <p> Thank you.</p>
    <div class="row">
        <center>
            <p class="title mt-4 mb-4">{{ $record->project_type}} Budget Request</p>
            <p class="mt-4 mb-4" style="text-align: left; margin-left: 5%;">
                Status: <span id="statusText" class="alert alert-warning px-2 py-1 m-0">{{ $record->status }}</span>
            </p>
              <table cellpadding="0" cellspacing="0" border="1" width="90%" style="border-collapse: collapse; border: 1px solid #000; margin: 0 auto;">
                <!-- Row 1: Requested By & Date Filed -->
                <tr>
                    <td style="padding: 8px; border: 1px solid #000; background-color: #f8f8f8;"><strong>Requested By</strong></td>
                    <td style="padding: 8px; border: 1px solid #000; width: 37%;">{{ $record->requested_by }}</td>
                    <td style="padding: 8px; border: 1px solid #000; background-color: #f8f8f8;"><strong>Date Filed</strong></td>
                    <td style="padding: 8px; border: 1px solid #000; width: 40%;">{{ $record->date_filed }}</td>
                </tr>

                <!-- Row 2: Person(s) Implementing -->
                <tr>
                    <td style="padding: 8px; border: 1px solid #000; background-color: #f8f8f8;"><strong>Person(s) Implementing</strong></td>
                    <td colspan="3" style="padding: 8px; border: 1px solid #000;">{{ $record->person_implementing }}</td>
                </tr>

                <!-- Row 3: Project Details Header -->
                <tr>
                    <td colspan="4" style="padding: 8px; border: 2px solid #000; background-color: #eeeeee; text-align: center; font-weight: bold;">
                        Project Details
                    </td>
                </tr>

                <!-- Row 4: Reseller & Project -->
                <tr>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Reseller</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->reseller_name }}</td>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Project</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->proj_name }}</td>
                </tr>

                <!-- Row 5: Contact Person & Location -->
                <tr>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Contact Person</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->reseller_contact }}</td>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Location</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->reseller_location }}</td>
                </tr>

                <!-- Row 6: Email & Date Start -->
                <tr>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Email Address</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->reseller_email }}</td>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Date Start</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->date_start }}</td>
                </tr>

                <!-- Row 7: End User & Date End -->
                <tr>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>End User</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->enduser_name }}</td>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Date End</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->date_end }}</td>
                </tr>
                <!-- Row 8: Contact Person & Mandays -->

                 <tr>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Contact Person</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->enduser_contact }}</td>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Man-days</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->mandays }} Days</td>
                </tr>
                
                <!-- Row 9: Email Address & Cost/Manday -->
                 <tr>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Email Address</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->enduser_email }}</td>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Cost/Manday</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">
                        <div style="display: flex; justify-content: space-between;">
                            <span>PHP</span>
                            <span>{{ $record->cost_manday }}</span>
                        </div>
                    </td>
                </tr>

                <!-- Row 10: Address & Project Cost -->
                <tr>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Address</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->enduser_location }}</td>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Project Cost (Vatex)</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">
                        <div style="display: flex; justify-content: space-between;">
                            <span>PHP</span>
                            <span>{{ $record->proj_cost }}</span>
                        </div>
                    </td>
                </tr>
                 <!-- ✅ Row 11: PO Number, SO Number, Expenses -->
                <tr>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>PO Number</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->po_number }}</td>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Expenses</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">
                        <div style="display: flex; justify-content: space-between;">
                            <span>PHP</span>
                            <span>{{ $record->expenses }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>SO Number</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;">{{ $record->so_number }}</td>
                     <td style="background-color: #eeeeee; padding: 8px; border: 1px solid #000;"><strong>Margin</strong></td>
                    <td style="background-color: #eeeeee; padding: 8px; border: 1px solid #000;">
                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <span>PHP</span>
                            <span>{{ $record->margin }}</span>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Payment Status</strong></td>
                    <td colspan="3" style="padding: 8px; border: 1px solid #000;">{{ $record->payment_status }}</td>
                </tr>

            </table>
                <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                    <thead cellpadding="0" cellspacing="0" border="0">
                        <tr cellpadding="0" cellspacing="0" border="0">
                            <th colspan="3"
                                style="color: rgb(0, 0, 0); padding: 8px; border: 2px solid #000000; text-align: center; background-color: #eeeeee;">
                                Charged To
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
                                        <label style="margin-right: 20px; "><input type="checkbox" {{ $record->charged_to_margin == 1 ? 'checked' : '' }} disabled> Margin</label>
                                        <label style="margin-right: 20px; "><input type="checkbox" {{ $record->charged_to_parked_funds == 1 ? 'checked' : '' }} disabled> Parked Funds</label>
                                        <label style="margin-right: 20px; "><input type="checkbox" {{ $record->charged_to_others == 1 ? 'checked' : '' }} disabled> Others</label>
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
                                    </div>
                                    <div class="input-prepend input-group" style="display: flex; align-items: center; gap: 20px; margin-top: 10px;">
                                        <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_promos == 1 ? 'checked' : '' }} disabled> Promos</label>
                                        <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_advertising == 1 ? 'checked' : '' }} disabled> Advertising</label>
                                        <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_freight == 1 ? 'checked' : '' }} disabled> Freight</label>
                                        <label style="margin-right: 20px; "><input type="checkbox" {{ $record->expense_representation == 1 ? 'checked' : '' }} disabled> Representation</label>
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
                                        <span>No. of Room/s</span>
                                    </div>
                                </td>
                                <td style="padding: 8px; border: 1px solid #000000; width: 15%; text-align: center;" >
                                    <div class="input-prepend input-group">
                                        <span>No. of Nights</span>
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
                    <div style="margin-top: 20px; text-align: center;">
                        <p>© 2025 Copyright VST ECS Phils., Inc. All rights reserved..</p>
                    </div>
                </footer>
        <center>
    </div>
</body>
</html>
