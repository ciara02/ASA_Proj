<html>

<head>
    <style>
        .w-100 {
            width: 100%;
        }

        .w-50 {
            width: 50%;
        }

        .h-100 {
            height: 100%;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-center {
            justify-content: center;
        }

        .align-items-center {
            align-items: center;
        }


        .container {
            width: 80%;
            background-color: #EEEEEE;
            margin: 0 10%;
            padding-bottom: 1rem
        }

        .header {
            background-color: #0F7699;
            height: 80px;
        }

        .main {
            margin: 15px;
            background-color: #fff;
            border-radius: 5px;
            padding: 15px;
        }

        .message {
            text-align: left;
        }

        .message .body {
            text-indent: 50px;
        }

        .details table {
            border: 1px solid #ccc;
            width: 100%;
            border-collapse: collapse;
        }

        .details table td {
            border: 1px solid #ccc;
            padding: 5px;
        }

        .details table td .tlabel {
            width: 30%;
            display: inline-block;
        }

        .details table td .tdata {
            width: 65%;
            display: inline-block;
        }

        .footer {
            height: 50px;
            width: 100%;
            background-color: #2F2F2F;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="row" style="margin: 2% 0% 2% 3%;"></div>
<center>
    <div class="container">
        <div class="header d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/official-logo.png') }}" class="img-responsive" style="height: 75px;">
        </div>

        <div class="main">
            <div class="message">
                <p>Hi <b><i>{{ $Act_CompletionData['ApproverName'] }}</i></b>,</p>
                <p class="body">Good day. Requesting for your approval on activity
                    <b><i>{{ $Act_CompletionData['Activity_Details'] }}</i></b>
                    delivered on {{ $Act_CompletionData['ActivityDate'] }} by
                    <b><i>{{ $Act_CompletionData['EngineerName'] }}</i></b>.
                    Kindly review activity details below. Thank you.</p>
            </div>

            <div class="details">
                <table>
                    <tr>
                        <td class="w-50">
                            <span class="tlabel">Project :</span>
                            <span class="tdata"> {{ $Act_CompletionData['Project_Name'] }} </span>
                        </td>
                        <td class="w-50"></td>
                    </tr>

                    <tr>
                        <td class="w-50">
                            <span class="tlabel">Reseller :</span>
                            <span class="tdata"> {{ $Act_CompletionData['Reseller'] }} </span>
                        </td>
                        <td class="w-50">
                            <span class="tlabel">End User :</span>
                            <span class="tdata"> {{ $Act_CompletionData['EndUser'] }} </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="w-50">
                            <span class="tlabel">Reseller Contact :</span>
                            <span class="tdata"> {{ $Act_CompletionData['Reseller_Contact'] }}</span>
                        </td>
                        <td class="w-50">
                            <span class="tlabel">End User Contact :</span>
                            <span class="tdata"> {{ $Act_CompletionData['EndUser_Contact'] }} </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="w-50">
                            <span class="tlabel">Activity Date :</span>
                            <span class="tdata"> {{ $Act_CompletionData['ActivityDate'] }} </span>
                        </td>
                        <td class="w-50">
                            <span class="tlabel">Engineers :</span>
                            <span class="tdata"> {{ $Act_CompletionData['EngineerName'] }} </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-100" colspan="2">
                            <div>Activity Done :</div>
                            <div> {{ $Act_CompletionData['ActivityDone'] }} </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <a href="{{ route('disapprove', ['hash' => $randomHash]) }}" style="background-color: #ec0c00; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-right:1rem; text-decoration: none; display: inline-block;">Comment</a>
            <a href="{{ route('approve', ['hash' => $randomHash, 'type' => 'ACTIVITY', 'action' => 'APPROVE']) }}" style="background-color: #38a041; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-right:1rem; text-decoration: none; display: inline-block;">Approve</a>
        </div>
    </div>
</center>
</body>
<html>
