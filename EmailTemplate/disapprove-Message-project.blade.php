<!DOCTYPE html>
<html>
<head>
    <style>
        .w-100 { width: 100%; }
        .d-flex { display: flex; }
        .justify-content-center { justify-content: center; }
        .align-items-center { align-items: center; }
        .header { background-color: #0F7699; height: 80px; }
        .main { margin: 15px; background-color: #fff; border-radius: 5px; padding: 15px; }
        .message { text-align: center; }
        .footer { height: 50px; width: 100%; background-color: #2F2F2F; margin-top: 5px; }
    </style>
</head>
<body>
    <center>
        <div class="container d-flex justify-content-center align-items-center">
            <div style="width: 750px; border: 1px solid #ccc; background-color: #fff;">
                <div class="header d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/official-logo.png') }}" class="img-responsive" style="height: 75px;">
                </div>
                <div class="main">
                    <div class="message">
                        <h3>PROJECT ACTIVITY COMMENT</h3>
                        @if(isset($hash))
                            <form action="{{ route('save-comment-project') }}" method="POST">
                                @csrf
                                <input type="hidden" name="hash" value="{{ $hash }}">
                                <textarea
                                    required
                                    style="width: 90%; resize: none; padding: 15px;"
                                    rows="10"
                                    placeholder="Enter reasons here..."
                                    name="txtDisapproveReason"
                                ></textarea>
                                <div class="w-100 d-flex justify-content-center" style="padding-top: 10px;">
                                    <button
                                        type="submit"
                                        style="border: 1px solid #ccc; padding: 5px; width: 100px; color: white; background-color: #28A745;"
                                    >
                                        SUBMIT
                                    </button>
                                </div>
                            </form>
                        @else
                            <p>Error: Hash value not set.</p>
                        @endif
                    </div>
                </div>
                <div class="footer"></div>
            </div>
        </div>
    </center>
</body>
</html>