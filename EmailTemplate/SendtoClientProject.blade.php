<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <div class="message">

        <p>Hi Sir/Ma'am <b><i>{{ $Approvers['name'] }}</i></b>,</p>

        {{-- <p>With Id:<b><i>{{ $Act_CompletionData['id'] }}</i></b>,</p> --}}

        <p class="body">Good day! We are glad to inform you that our project
            <b><i>{{ $Act_CompletionData['ProjectTitle'] }}</i></b> is ready for closing.
            All deliverables were delivered and there's no pending action item. We would like to seek your approval on
            the project closing.
            Kindly review the project sign-off details below for your reference. Thank you.
        </p>
    </div>

    <!-- Project info Card -->

    <div style="margin-bottom: 16px; border: 1px solid #dee2e6;">
        <div style="text-align: left; background-color: #0056b3; color: white; padding: 16px;">
            <h5 style="margin: 0; font-size: 16px; font-weight: bold;">Project Information</h5>
        </div>
        <div style="padding: 16px;">
            <div style="display: flex; flex-direction: column;">

                <div style="margin-bottom: 16px; width: 100%;">
                    <div style="display: flex; align-items: center;">
                        <span
                            style="font-size: 14px; padding: 8px; border: 1px solid #ced4da; background-color: #e9ecef; font-weight: bold; font-style: italic;">Project
                            Title :</span>
                        <input type="text" autocomplete="off"
                            style="flex: 1; border: 1px solid #ced4da; padding: 8px;" id="projtitle_approval"
                            name="txtProjectTitle" disabled
                            value="{{ $Act_CompletionData['ProjectTitle'] ?? 'No Project Title' }}" />
                    </div>
                </div>

                <div style="display:flex; justify-content: space-between; margin-bottom: 16px;">
                    <div style="flex: 1; margin-right: 15px;">
                        <div style="display: flex; align-items: center;">
                            <span
                                style="font-size: 14px; padding: 8px; border: 1px solid #ced4da; background-color: #e9ecef; font-weight: bold; font-style: italic;">Reseller
                                :</span>
                            <input type="text" autocomplete="off"
                                style="flex: 1; border: 1px solid #ced4da; padding: 8px;" id="reseller_approval"
                                name="txtReseller" value="{{ $Act_CompletionData['Reseller'] }}" disabled />
                        </div>
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center;">
                            <span
                                style="font-size: 14px; padding: 8px; border: 1px solid #ced4da; background-color: #e9ecef; font-weight: bold; font-style: italic;">End
                                User:</span>
                            <input type="text" autocomplete="off"
                                style="flex: 1; border: 1px solid #ced4da; padding: 8px;" id="enduser_approval"
                                name="txtEndUser" disabled value="{{ $Act_CompletionData['EndUser'] }}" />
                        </div>
                    </div>
                </div>

                <div style="display:flex; justify-content: space-between;">
                    <div style="flex: 1; margin-right: 15px;">
                        <div style="display: flex; align-items: center;">
                            <span
                                style="font-size: 14px; padding: 8px; border: 1px solid #ced4da; background-color: #e9ecef; font-weight: bold; font-style: italic;">Reseller
                                Contact :</span>
                            <input type="text" autocomplete="off"
                                style="flex: 1; border: 1px solid #ced4da; padding: 8px;" id="reseller_approval"
                                name="txtReseller" value="" disabled />
                        </div>
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center;">
                            <span
                                style="font-size: 14px; padding: 8px; border: 1px solid #ced4da; background-color: #e9ecef; font-weight: bold; font-style: italic;">End
                                User Contact:</span>
                            <input type="text" autocomplete="off"
                                style="flex: 1; border: 1px solid #ced4da; padding: 8px;" id="enduser_approval"
                                name="txtEndUser" disabled value="" />
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Project info Card -->

    <!-- Deliverables Card -->
    <div style="margin-bottom: 16px; border: 1px solid #dee2e6;">
        <div style="text-align: center; background-color:#0056b3; color: white; padding: 16px;">
            <h5 style="margin: 0; font-size: 16px; font-weight: bold;">Deliverables</h5>
        </div>
        <div style="padding: 16px;">
            <div style="margin: 0;">
                <textarea style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ced4da; margin-top: 8px;"
                    id="txtNewCard" name="txtNewCard" autocomplete="off" rows="5" disabled required>{{ $Act_CompletionData['Deliverables'] }}</textarea>
            </div>
        </div>
    </div>

  <!-- Start Attachments Card -->
    <div style="margin-bottom: 16px; border: 1px solid #dee2e6;">
        <div style="text-align: left; background-color: #0056b3; color: white; padding: 16px;">
            <h5 style="margin: 0; font-size: 16px; font-weight: bold;">Attachments:</h5>
        </div>
        <div style="padding: 16px;">
            <div style="display: inline-block; text-align: center;">
                @foreach($Act_CompletionData['attachmentsArray'] as $attachment)
                    <p>
                        <a href="{{ url($attachment['path']) }}" target="_blank">{{ $attachment['filename'] }}</a>
                    </p>
                @endforeach
            </div>
        </div>
    </div>

    <!-- End Attachments Card -->

    <!-- End Deliverables Card -->

    <div style="text-align: center; margin-top: 20px; padding-bottom: 2rem">
        <a href="{{ route('projectapprove', ['hash' => $randomHash, 'type' => 'PROJECT', 'action' => 'APPROVE']) }}"
            style="background-color: #2b6b2d; color: white; padding: 10px 20px; border: none; cursor: pointer; margin-right: 10px;">Approve</a>
        <a href="{{ route('projectdisapprovedpage', ['hash' => $randomHash]) }}"
            style="background-color: #b84d4d; color: white; padding: 10px 20px; border: none; cursor: pointer; margin-right: 10px;">Comment</a>
    </div>

</body>

</html>
