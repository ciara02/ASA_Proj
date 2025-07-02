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
                            @if ($data['report'] === 'Skills Development')
                            @else
                                {{-- Venue is visible for other report values --}}
                                <div class="input-prepend input-group">
                                    <b>Venue:</b>
                                    <span>{{ $data['Venue'] }}</span>
                                </div>
                            @endif
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
                                @if ($data['Activity_type'] === 'DIGIKnow')
                                    <div id="otherType1">
                                        <div class="form-group input-prepend input-group">
                                            <b>Attach DIGIKnow Flyer:</b> &emsp;
                                            @if (isset($data['Digi_flyers']) && is_array($data['Digi_flyers']))
                                                @foreach ($data['Digi_flyers'] as $Digi_flyersattachment)
                                                    <div id="digiknowfileDisplay" class="mt-3">
                                                        <a href="{{ url($Digi_flyersattachment) }}"
                                                            target="_blank">{{ basename($Digi_flyersattachment) }}</a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>No file found.</p>
                                            @endif
                                        </div>
                                        <div class="input-prepend input-group">
                                            <b>Recipients:</b> &nbsp;
                                            <input type="checkbox" name="other_chbBPs" value="1"
                                                {{ $data['bp_digiCheckbox'] ? 'checked' : '' }}> BPs
                                            <input type="checkbox" name="other_chbEUs" value="1"
                                                {{ $data['eu_digiCheckbox'] ? 'checked' : '' }}> EUs
                                        </div>
                                    </div>
                                @elseif ($data['Activity_type'] === 'Internal Project')
                                    <div id="otherType2">
                                        <div class="form-group input-prepend input-group">
                                            <b>MSI Project Name:</b>
                                            <span>{{ $data['internal_Msi'] }}</span>
                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Compliance Percentage:</b>
                                            <span>{{ $data['internal_Percent'] }}</span>
                                        </div>
                                    </div>
                                @elseif ($data['Activity_type'] === 'Perfect Attendance under Merit')
                                    <div id="otherType5">
                                        <div class="form-group input-prepend input-group">
                                            <b>Perfect Attendance:</b>
                                            <span>{{ $data['internal_Attendance'] }}</span>
                                        </div>
                                    </div>
                                @elseif ($data['Activity_type'] === 'Memo from HR under Demerit')
                                    <div id="otherType6">
                                        <div class="form-group input-prepend input-group">
                                            <b>Memo Issued:</b>
                                            <span>{{ $data['memo_Issued'] }}</span>
                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Memo Details:</b>
                                            <span>{{ $data['memo_Details'] }}</span>
                                        </div>
                                    </div>
                                @elseif ($data['Activity_type'] === 'Feedback On Engineer')
                                    <div id="otherType11">
                                        <div class="form-group input-prepend input-group">
                                            <b>Feedback On Engineer:</b>
                                            <span>{{ $data['engr_feedback'] }}</span>
                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Rating:</b>
                                            <span>
                                                @switch($data['engr_rating'])
                                                    @case(1)
                                                        Very Satisfactory
                                                    @break

                                                    @case(2)
                                                        Satisfactory
                                                    @break

                                                    @case(3)
                                                        Just Right
                                                    @break

                                                    @case(4)
                                                        Unsatisfactory
                                                    @break

                                                    @case(5)
                                                        Very Unsatisfactory
                                                    @break

                                                    @default
                                                        No Rating
                                                @endswitch
                                            </span>
                                        </div>
                                    </div>
                                @elseif ($data['Activity_type'] === 'Train To Retain (T2R)')
                                    <div id="newTypes">
                                        <div class="form-group input-prepend input-group">
                                            <b>Topic:</b>
                                            <span>{{ $data['T2R_topic'] }}</span>

                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Date Start:</b>
                                            <span>{{ $data['T2R_datestart'] }}</span>

                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Date End:</b>
                                            <span>{{ $data['T2R_dateEnd'] }}</span>

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
