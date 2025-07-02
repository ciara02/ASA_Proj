<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forward Template</title>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

</head>

<body>

    <p>{!! nl2br(e($data['sendMessage'])) !!}</p>

    <div class="row">
        <center>
            <table style="width: 90%; max-width: 90%;" id="ReportDetails">
                <thead>
                    <tr style="padding: 8px">
                        <td style="width: 33%;">
                            <img src="{{ asset('assets/img/official-logo.png') }}" width="200" height="auto">
                            <h5>ASA Ref. No. :<span>{{ $data['reference_num'] }}</h5>
                            <input type="hidden" name="quick_ref_input" id="hidden_reference_no1">
                        </td>
                        <td style="width: 33%;">

                        </td>
                        <td style="width: 30%; ">
                            <b>Report:</b> <span name="report_name" id="report_name">{{ $data['report'] }}</span>
                            <br>
                            <b>Status:</b> <span name="status_name" id="status_name">{{ $data['status'] }}</span><br>
                            <b>Project:</b> <span name="proj_type_name">{{ $data['projname'] }}</span>
                        </td>
                    </tr>
                </thead>
            </table>
        </center>
    </div>
    <div class="row">
        <center>
            <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058; width: 33%;">
                            <div class="input-prepend input-group">
                                <b>Activity:</b>
                                <span>{{ $data['act_details'] }}</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                <thead cellpadding="0" cellspacing="0" border="0">
                    <tr cellpadding="0" cellspacing="0" border="0">
                        <th colspan="3"
                            style="color: yellow; padding: 8px; border: 2px solid #010058; text-align: center; background-color: #0400ff;">
                            Contract Details
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="input-prepend input-group">
                                <b>Resellers:</b>
                                <span>{{ $data['reseller'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="input-prepend input-group">
                                <b>Resellers Contact:</b>
                                <span>{{ $data['reseller_contact'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="input-prepend input-group">
                                <b>Phone/Email:</b>
                                <span>{{ $data['reseller_phone_email'] }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058;"><b> (MSI if internal enablement)</b>
                            <div class="input-prepend input-group">
                                <b>EndUser:</b>
                                <span>{{ $data['enduser_name'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="form-group input-prepend input-group">
                                <b>EndUser Contact:</b>
                                <span>{{ $data['enduser_contact'] }}</span>
                            </div>
                            <div class="input-prepend input-group">
                                <b>EndUser Location:</b>
                                <span>{{ $data['enduser_location'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="input-prepend input-group">
                                <b>Phone/Email:</b>
                                <span>{{ $data['enduser_email'] }}</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                <thead cellpadding="0" cellspacing="0" border="0">
                    <tr cellpadding="0" cellspacing="0" border="0">
                        <th colspan="3"
                            style="color: yellow; padding: 8px; border: 2px solid #010058; text-align: center; background-color: #0400ff;">
                            Activity Summary Report
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058; width: 33%;">
                            <div class="input-prepend input-group">
                                <b>Activity Date:</b>
                                <span>{{ $data['Act_date'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058; width: 33%;">
                            <div class="input-prepend input-group">
                                <b>Time Reported To Client:</b>
                                <span>{{ $data['Time_reported1'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058; width: 33%;">
                            <div class="input-prepend input-group">
                                <b>Time Exited To Client:</b>
                                <span>{{ $data['Time_exited1'] }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="form-group input-prepend input-group">
                                <b>Product Line:</b>
                                <span>{{ $data['Product_line'] }}</span>
                            </div>
                            <div class="input-prepend input-group">
                                <b>Product Code:</b>
                                <span>{{ $data['Product_Code'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="form-group input-prepend input-group">
                                <b>Time Expected by Client:</b> <span>{{ $data['Time_expected1'] }}</span>
                            </div>
                            <div class="input-prepend input-group">
                                <b>Venue:</b>
                                <span>{{ $data['Venue'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="input-prepend input-group">
                                <b>Engineer:</b>
                                <span>{{ $data['engineer_name'] }}</span>
                            </div>
                        </td>

                    </tr>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div id="divActivityType">
                                <div class="form-group input-prepend input-group">
                                    <b>Activity Type:</b>
                                    <span>{{ $data['Activity_type'] }}</span>
                                </div>
                            </div>
                            <div class="input-prepend input-group">
                                <b>Program:</b>
                                <span>{{ $data['Program'] }}</span>
                            </div>
                        </td>
                        <td colspan="2" style="padding: 8px; border: 1px solid #010058;">
                            <div id="vacant">
                                @if ($data['Program'] === 'sTraCert')
                                    <div id="newTypes">
                                        <div class="form-group input-prepend input-group">
                                            <b>Topic:</b>
                                            <span>{{ $data['straCert_TopicName'] }}</span>
                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Date Start:</b>
                                            <span>{{ $data['straCert_DateStart'] }}</span>
                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Date End:</b>
                                            <span>{{ $data['straCert_DateEnd'] }}</span>
                                        </div>
                                    </div>
                                @elseif ($data['Activity_type'] === 'POC (Proof of Concept)')
                                    <div id="clientCallTypePOC">
                                        <div class="form-group input-prepend input-group">
                                            <b>Product Model:</b>
                                            <span>{{ $data['productModel'] }}</span>

                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Asset or Code:</b>
                                            <span>{{ $data['assetCode'] }}</span>

                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Date Start:</b>
                                            <span>{{ $data['poc_dateStart'] }}</span>

                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Date End:</b>
                                            <span>{{ $data['poc_dateEnd'] }}</span>

                                        </div>
                                    </div>
                                @else
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td colspan="4" style="padding: 8px; border: 1px solid #010058; width: 33%;">
                            <div class="input-prepend input-group">
                                <b>Send Copy To:</b>
                                <span>{{ $data['Send_copy_to'] }}</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                <thead cellpadding="0" cellspacing="0" border="0">
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <th
                            style="color: yellow; padding: 8px; border: 2px solid #010058; text-align: center; background-color: #0400ff;">
                            Participants & Positions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058; text-align: center;">
                            @if (isset($data['formData']) && is_array($data['formData']))
                                {{-- Sort formData by participant in ascending order --}}
                                @php
                                    $sortedData = collect($data['formData'])->sortBy('participant');
                                    $counter = 1;
                                @endphp
                                @foreach ($sortedData as $participantData)
                                    <span> {{ $counter++ }}. {{ $participantData['participant'] }} -
                                        {{ $participantData['position'] }} </span><br>
                                @endforeach
                            @else
                                No data available.
                            @endif
                        </td>
                    </tr>
                </tbody>

            </table>
            <br>
            <table style="width: 90%; max-width: 90%; table-layout: fixed;" cellpadding="0" cellspacing="0"
                id="">
                <thead cellpadding="0" cellspacing="0" border="0">
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <th
                            style="color: yellow; padding: 8px; border: 2px solid #010058; text-align: left; background-color: #0400ff; width:50%;">
                            I. Customer Requirements
                        </th>
                        <th
                            style="color: yellow; padding: 8px; border: 2px solid #010058; text-align: left; background-color: #0400ff; width:50%;">
                            II. Activity Done
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <pre style="font-family: 'Segoe UI', sans-serif; font-size: 15px;">{{ $data['customer_req'] }}</pre>
                        </td>
                        <td rowspan="3" style="padding: 8px; border: 1px solid #010058;">
                            <pre style="font-family: 'Segoe UI', sans-serif; font-size: 15px;">{{ $data['Activity_Done'] }}</pre>
                        </td>

                    </tr>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <th
                            style="color: yellow; padding: 8px; border: 2px solid #010058; text-align: left; background-color: #0400ff;">
                            III. Agreements
                        </th>
                    </tr>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <pre style="font-family: 'Segoe UI', sans-serif; font-size: 15px;">{{ $data['Agreements'] }}</pre>
                        </td>
                    </tr>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <th colspan="2"
                            style="color: yellow; padding: 8px; border: 2px solid #010058; text-align: left; background-color: #0400ff;">
                            IV. Action Plan/ Recommendation
                        </th>
                    </tr>

                </tbody>
            </table>
            <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0" id="">
                <thead>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <th style="padding: 8px; border: 1px solid #010058; text-align: center; width: 150px;">
                            Target Date
                        </th>
                        <th style="padding: 8px; border: 1px solid #010058; text-align: center;">
                            Details
                        </th>
                        <th style="padding: 8px; border: 1px solid #010058; text-align: center; width: 150px;">
                            Owner
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($data['ActionPlanRecommendation']) && is_array($data['ActionPlanRecommendation']))
                        @foreach ($data['ActionPlanRecommendation'] as $ActionPlan)
                            <tr style="padding: 8px; border: 1px solid #010058;">
                                <td style="padding: 8px; border: 1px solid #010058; width: 33%;">
                                    <span>{{ $ActionPlan['plantarget'] }}</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #010058; width: 33%;">
                                    <pre style="font-family: 'Segoe UI', sans-serif; font-size: 15px;">{{ $ActionPlan['details'] }}</pre>
                                </td>
                                <td style="padding: 8px; border: 1px solid #010058; width: 33%;">
                                    <span>{{ $ActionPlan['planowner'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr style="padding: 8px; border: 1px solid #010058;">
                            <td colspan="3" style="padding: 8px; border: 1px solid #010058; text-align: center;">
                                No data available.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <br>
            <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="3"
                            style="color: yellow; padding: 8px; border: 2px solid #010058; text-align: center; background-color: #0400ff;">
                            Attachments
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td colspan="3" style="padding: 8px; border: 1px solid #010058;">
                            @if (isset($data['attachments']) && is_array($data['attachments']))
                                @foreach ($data['attachments'] as $attachment)
                                    <div id="fileDisplay" class="mt-3">
                                        <a href="{{ url($attachment) }}"
                                            target="_blank">{{ basename($attachment) }}</a>
                                    </div>
                                @endforeach
                            @else
                                <p>No file found.</p>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
    </div>

</body>

<!-- Include DataTables Buttons Extension JavaScript -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

</html>
