<!DOCTYPE html>
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
            text-align: center;
        }
        .message .body {
            text-indent: 50px;
        }
        .footer {
            height: 50px;
            width: 100%;
            background-color: #2F2F2F;
            margin-top: 5px;
        }
        .flex-column {
            flex-direction: column;
        }
    </style>
</head>
<body>
    <center>
        <div class="container d-flex justify-content-center align-items-center">
            <div style="width:800px; border: 1px solid #ccc;background-color: #fff;">
                <div class="header d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/official-logo.png') }}" class="img-responsive" style="height: 75px;">
                </div>

                <div class="main">
                    <img src="{{ asset('assets/img/check.svg') }}" class="img-responsive" style="height: 75px;" />
                    <div class="message">
                        @if($action == "APPROVE")
                            @if($type == "ACTIVITY")
                                <p>This will serve as the final confirmation that you <b>APPROVED</b> the activity summary report and the activity is completed.</p>
                            @endif
                            @if($type == "PROJECT")
                                <p>This will serve as the final confirmation that you <b>APPROVED</b> the project and the project is completed.</p>
                            @endif
                            <p>Thank you for availing VSTECS iSupport services.</p>
                        @endif
                    </div>
                </div>
                <div class="footer">
                </div>
            </div>
        </div>
    </center>
</body>
</html>
