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
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

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
                                <b>Time Expected by Client:</b>  <span>{{ $data['Time_expected1'] }}</span>
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
                                @if ($data['Program'] === 'PKOC / MSLC')
                                <div id="newTypes" >
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
        </center>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

</html>
