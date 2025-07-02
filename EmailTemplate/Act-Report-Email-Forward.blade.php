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
                            <b>Project:</b> <span name="proj_type_name">{{ $data['projtype'] }}</span>
                        </td>
                    </tr>
                </thead>
            </table>
        </center>
    </div>
    <div class="row">
        <center>
            <table style="width: 90%; max-width: 90%;" cellpadding="0" cellspacing="0">
                <thead cellpadding="0" cellspacing="0" border="0">
                    <tr cellpadding="0" cellspacing="0" border="0">
                        <th colspan="3"
                            style="color: yellow; padding: 8px; border: 2px solid #010058; text-align: center; background-color: #0400ff;">
                            Activity Details
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058; width: 33%;">
                            <div class="input-prepend input-group">
                                <b>Requester:</b>
                                <span>{{ $data['act_details_req'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058; width: 33%;">
                            <div class="input-prepend input-group">
                                <b>Product Engineer Only:</b>
                                <span>{{ $data['product_engr'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058; width: 33%;">
                            <div class="input-prepend input-group">
                                <b>Date Filed:</b>
                                <span>{{ $data['date_filed'] }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058;"></td>
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="input-prepend input-group">
                                <b>Copy to:</b>
                                <span>{{ $data['copy_to'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="input-prepend input-group">
                                <b>Date Needed:</b>
                                <span>{{ $data['date_needed'] }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr style="padding: 8px; border: 1px solid #010058;">
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="input-prepend input-group">
                                <b>Activity:</b>
                                <span>{{ $data['act_details_activity'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="input-prepend input-group">
                                <b>Special Instruction:</b>
                                <span>{{ $data['special_instr'] }}</span>
                            </div>
                        </td>
                        <td style="padding: 8px; border: 1px solid #010058;">
                            <div class="input-prepend input-group">
                                <b>Reference Number:</b>
                                <span>{{ $data['reference_num'] }}</span>
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
            <center>
    </div>
    </div>
</body>

<!-- Include DataTables Buttons Extension JavaScript -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('assets/template/dynamicfields.js') }}"></script>  --}}


</html>
