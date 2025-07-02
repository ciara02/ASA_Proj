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
                <tbody>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058; width: 33%;">
                            <div class="input-prepend input-group">
                                <b>Activity Date:</b>
                                <span>{{ $data['Act_date'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058; width: 33%;">

                        </td>
                        <td style="padding: 8px; border: 1px solid #010058; width: 33%;">

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
                        <td style="padding: 8px; border: 1px solid #010058;" colspan="2">
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
                                @if ($data['Activity_type'] === 'Technical Certification' || $data['Activity_type'] === 'Sales Certification')
                                    <div id="type1">
                                        <div class="input-prepend input-group">
                                            <b>Title:</b>
                                            <span>{{ $data['tech_Title'] }}</span>
                                        </div>
                                        <div class="input-prepend input-group">
                                            <b>Exam Name:</b>
                                            <span>{{ $data['tech_examCode'] }}</span>
                                        </div>
                                        <div class="input-prepend input-group">
                                            <b>Take Status:</b>
                                            <span>
                                                @if ($data['tech_status'] == 1)
                                                    Take 1
                                                @elseif ($data['tech_status'] == 2)
                                                    Take 2
                                                @else
                                                    Nth Take
                                                @endif
                                            </span>
                                        </div>

                                        <div class="input-prepend input-group">
                                            <b>Score:</b>
                                            <span>{{ $data['tech_ScoreDropdown'] }}</span>
                                        </div>
                                        <div class="input-prepend input-group">
                                            <b>Exam Type:</b>
                                            <span>
                                                @if ($data['tech_examType'] == 1)
                                                    Prometric Technical Exam
                                                @elseif ($data['tech_examType'] == 2)
                                                    Prometric Sales Exam
                                                @elseif ($data['tech_examType'] == 3)
                                                    Online Technical Exam
                                                @elseif ($data['tech_examType'] == 4)
                                                    Online Sales Exam
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                        <div class="input-prepend input-group">
                                            <b>Incentive Details:</b>
                                            <span>{{ $data['tect_incDetails'] }}</span>
                                            <span>
                                                @if ($data['tect_incDetails'] == 1)
                                                    Preferred - Complex (1 exam track) => P5000
                                                @elseif ($data['tect_incDetails'] == 2)
                                                    Preferred - Complex (2 or more exams track) => P10000
                                                @elseif ($data['tect_incDetails'] == 3)
                                                    Preferred - Simple (1 exam track) => P3000
                                                @elseif ($data['tect_incDetails'] == 4)
                                                    Preferred - Simple (2 or more exams track) => P5000
                                                @elseif ($data['tect_incDetails'] == 5)
                                                    Supplemental - Complex (1 exam track) => P2000
                                                @elseif ($data['tect_incDetails'] == 6)
                                                    Supplemental - Complex (2 or more exams track) => P3000
                                                @elseif ($data['tect_incDetails'] == 7)
                                                    Supplemental - Simple (1 exam track) => P500
                                                @elseif ($data['tect_incDetails'] == 8)
                                                    Supplemental - Simple (2 or more exams track) => P1000
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                        <div class="input-prepend input-group">
                                            <b>Incentive Amount:</b>
                                            <span>{{ $data['tech_examAmount'] }}</span>
                                        </div>
                                        <div class="input-prepend input-group">
                                            <b>Incentive Status:</b>
                                            <span>
                                                @if ($data['tech_incStatus'] == 1)
                                                    For HR Request
                                                @elseif ($data['tech_incStatus'] == 2)
                                                    Collected
                                                @elseif ($data['tech_incStatus'] == 3)
                                                    No Incentive
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @elseif ($data['Activity_type'] === 'Technology or Product Skills Devt')
                                    <div id="type2">
                                        <b>Technology/ Product Learned:</b>
                                        <span>{{ $data['Tech_ProdLearned'] }}</span>
                                    </div>
                                @elseif (
                                    $data['Activity_type'] === 'Vendor Training' ||
                                        $data['Activity_type'] === 'Bootcamp Attended' ||
                                        $data['Activity_type'] === 'TCT (Technology Cross Training) - Attended' ||
                                        $data['Activity_type'] === 'TPS Led Softskills Training' ||
                                        $data['Activity_type'] === 'HR-Led Training')
                                    <div id="type3">
                                        <div class="form-group input-prepend input-group">
                                            <b>Training Name:</b>
                                            <span>{{ $data['skills_trainingName'] }}</span>

                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Location:</b>
                                            <span>{{ $data['skills_location'] }}</span>

                                        </div>
                                        <div class="form-group input-prepend input-group">
                                            <b>Speaker/s:</b>
                                            <span>{{ $data['skills_speaker'] }}</span>

                                        </div>
                                        <div class="input-prepend input-group">
                                            <b>Attendees:</b> &nbsp;
                                            <input type="checkbox" name="chbBPs" value="1"
                                                @if ($data['skill_bpcheckBox'] == 1) checked @endif
                                                onclick="return false;" onkeydown="return false;"> BPs
                                            <input type="checkbox" name="chbEUs" value="1"
                                                @if ($data['skills_eucheckbox'] == 1) checked @endif
                                                onclick="return false;" onkeydown="return false;"> EUs
                                            <input type="checkbox" name="chbMSI" value="1"
                                                @if ($data['skill_msicheckbox'] == 1) checked @endif
                                                onclick="return false;" onkeydown="return false;"> MSI
                                        </div>

                                    </div>
                                @else
                                @endif
                            </div>
                        </td>
                    </tr>
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
