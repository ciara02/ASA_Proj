<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSender;
use App\Mail\SendtoClient;
use App\Mail\ProjectSendtoClient;
use App\Models\tbl_activityAcceptanceApproval;
use App\Models\tbl_activityAcceptance;
use Illuminate\Support\Str;
use App\Models\tbl_activityReport;
use App\Models\tbl_projectSignoff;
use App\Models\tbl_projectSignoffApproval;
use App\Models\tbl_project_list;
use App\Models\tbl_project_signoff_attachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Mail\EmailSenderDummy;

class EmailSendingController extends Controller
{


    //////////////////////////// Activity Report Forward To Email ////////////////////////////////////////

    public function ForwardtoEmail(Request $request)
    {

        $data = json_decode($request->input('reportData'), true);


        $emailsTo = array_filter($data['sendTo'], function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });

        $cc = array_filter($data['sendCC'], function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });

        $bcc = array_filter($data['sendBCC'], function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });


        $subject = $data['sendSubject'];
        $message = $data['sendMessage'];

        try {

            // Create a new email instance
            $email = new EmailSender($data, $subject, $message);

            // Send the email to multiple recipients
            $mail = Mail::to($emailsTo);
            if (!empty($cc)) {
                $mail->cc($cc);
            }
            if (!empty($bcc)) {
                $mail->bcc($bcc);
            }
            $mail->send($email);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    //////////////////////////// Create Pending Completion Acceptance ////////////////////////////////////////

    public function SendforPendingActivityAcceptance(Request $request)
    {
        try {
            $StoreData = $request->input('StoreData');

            ////////////////// Store Data to tbl_activityAcceptance///////////////////////
            $AcceptanceCreatedBy = $StoreData['CreatedBy'];
            $AcceptanceCreatedDate = $StoreData['CreatedDateTime'];
            $AcceptanceReportId = $StoreData['Ar_id'];


            $activityAcceptance = new tbl_activityAcceptance();
            $activityAcceptance->aa_activity_report = $AcceptanceReportId;
            $activityAcceptance->aa_created_by = $AcceptanceCreatedBy;
            $activityAcceptance->aa_date_created = $AcceptanceCreatedDate;
            $activityAcceptance->aa_status = 1;
            $activityAcceptance->save();

            $aa_id = $activityAcceptance->aa_id;

            // Check if aa_id has a value
            if (!$aa_id) {
                abort(500, 'Failed to retrieve the generated ID for activity acceptance.');
            }

            ////////////////// Store Data to tbl_activityAcceptanceApproval ///////////////////////
            $Emails = $StoreData['Email'];
            $Names = $StoreData['Name'];
            $ApproverCompanyNames = $StoreData['ApproverCompanyName'];
            $ApproverPositions = $StoreData['ApproverPosition'];

            // Loop through each approver and save their data
            foreach ($Emails as $index => $Email) {
                $activityAcceptanceApproval = new tbl_activityAcceptanceApproval();
                $activityAcceptanceApproval->aaa_activityAcceptance = $aa_id;
                $activityAcceptanceApproval->aaa_email = $Email;
                $activityAcceptanceApproval->aaa_name = $Names[$index];
                $activityAcceptanceApproval->aaa_company = $ApproverCompanyNames[$index];
                $activityAcceptanceApproval->aaa_position = $ApproverPositions[$index];
                $activityAcceptanceApproval->aaa_status = "PENDING";
                $activityAcceptanceApproval->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Successfully Save the Pending Acceptance method!',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    //////////////////////////// Edit Pending Completion Acceptance ////////////////////////////////////////

    public function EditforPendingActivityAcceptance(Request $request)
    {
        try {
            // Decode the JSON data
            $StoreData = $request->input('StoreData');

            $ActivityReportId = $StoreData['Ar_id'];

            // Retrieve the aaa_activityAcceptance ID
            $getApprovalId = tbl_activityReport::leftJoin('tbl_activityAcceptance', 'tbl_activityReport.ar_id', '=', 'tbl_activityAcceptance.aa_activity_report')
                ->leftJoin('tbl_activityAcceptanceApproval', 'tbl_activityAcceptance.aa_id', '=', 'tbl_activityAcceptanceApproval.aaa_activityAcceptance')
                ->select('tbl_activityAcceptanceApproval.aaa_activityAcceptance')
                ->where('tbl_activityReport.ar_id', '=', $ActivityReportId)
                ->first();

            // Update tbl_activityAcceptance
            $newActivityAcceptance = tbl_activityAcceptance::where('aa_activity_report', $ActivityReportId)->delete();

            $AcceptanceCreatedBy = $StoreData['CreatedBy'];
            $AcceptanceCreatedDate = $StoreData['CreatedDateTime'];
            $AcceptanceReportId = $StoreData['Ar_id'];

            $newActivityAcceptance = new tbl_activityAcceptance();
            $newActivityAcceptance->aa_activity_report = $AcceptanceReportId;
            $newActivityAcceptance->aa_created_by = $AcceptanceCreatedBy;
            $newActivityAcceptance->aa_date_created = $AcceptanceCreatedDate;
            $newActivityAcceptance->aa_status = 1;
            $newActivityAcceptance->save();

            $aa_id = $newActivityAcceptance->aa_id;

            //////////////////////// Update tbl_activityAcceptanceApproval /////////////////////////////////////////

            // Assuming $StoreData has the new data
            $Emails = $StoreData['Email'];
            $Names = $StoreData['Name'];
            $ApproverCompanyNames = $StoreData['ApproverCompanyName'];
            $ApproverPositions = $StoreData['ApproverPosition'];

            // Check if we got a result
            if ($aa_id) {
                // Previous aaa_activityAcceptance id so that I can delete it in the database
                $PreviousId = $getApprovalId->aaa_activityAcceptance;
                //Current aaa_activityAcceptance id I got after saving the new Approvers
                $approvalId = $aa_id;
                // Delete existing data with matching aaa_activityAcceptance
                $activityAcceptanceApproval = tbl_activityAcceptanceApproval::where('aaa_activityAcceptance', $PreviousId)->delete();

                // Populate the table with new data
                for ($i = 0; $i < count($Emails); $i++) {
                    $activityAcceptanceApproval = new tbl_activityAcceptanceApproval();
                    $activityAcceptanceApproval->aaa_activityAcceptance = $approvalId;
                    $activityAcceptanceApproval->aaa_email = $Emails[$i];
                    $activityAcceptanceApproval->aaa_name = $Names[$i];
                    $activityAcceptanceApproval->aaa_company = $ApproverCompanyNames[$i];
                    $activityAcceptanceApproval->aaa_position = $ApproverPositions[$i];
                    $activityAcceptanceApproval->aaa_status = "PENDING";
                    $activityAcceptanceApproval->aaa_activityAcceptance = $approvalId;
                    $activityAcceptanceApproval->save();
                }
            } else {
                throw new \Exception('No matching activity acceptance ID found.');
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }



    //////////////////////////// Sending Completion Acceptance ////////////////////////////////////////

    public function SendtoClient(Request $request)
    {
        try {
            // Decode the JSON data
            $Act_CompletionData = json_decode($request->input('CompletionData'), true);

            // Ensure the data is not null and contains the expected keys
            if (is_null($Act_CompletionData) || !isset($Act_CompletionData['ApproverEmail'])) {
                throw new \Exception('Invalid completion data.');
            }

            // Validate the email addresses
            $emailsTo = array_filter((array)$Act_CompletionData['ApproverEmail'], function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            });

            // Ensure there are valid emails
            if (empty($emailsTo)) {
                throw new \Exception('No valid email addresses found.');
            }


            $ApprovalReferenceNumber = $Act_CompletionData['approval_refno'];
            $ApprovalId = $Act_CompletionData['Ar_id'];


            $getApprovalId = tbl_activityReport::leftJoin('tbl_activityAcceptance', 'tbl_activityReport.ar_id', '=', 'tbl_activityAcceptance.aa_activity_report')
                ->leftJoin('tbl_activityAcceptanceApproval', 'tbl_activityAcceptance.aa_id', '=', 'tbl_activityAcceptanceApproval.aaa_activityAcceptance')
                ->select('tbl_activityAcceptanceApproval.aaa_activityAcceptance')
                ->where('tbl_activityReport.ar_refNo', '=', $ApprovalReferenceNumber)
                ->first();


            if ($getApprovalId) {
                $aaa_activityAcceptance = $getApprovalId->aaa_activityAcceptance;
            } else {
                abort(500, 'Failed to retrieve the aa_activity_report .');
            }

            // Retrieve the instance of the model
            $activityAcceptance = tbl_activityAcceptance::where('aa_activity_report', $ApprovalId)->first();
            if ($activityAcceptance) {
                $activityAcceptance->aa_status = 2;
                $activityAcceptance->save();
            } else {
                abort(500, 'Failed to retrieve the activity acceptance record.');
            }

            foreach ($emailsTo as $index => $email) {

                $randomHash = (string) Str::random(64); // Cast as string

                // Retrieve or create a new instance for each approver
                $activityAcceptanceApproval = tbl_activityAcceptanceApproval::firstOrNew(
                    ['aaa_activityAcceptance' => $aaa_activityAcceptance, 'aaa_email' => $email]
                );
                $activityAcceptanceApproval->aaa_status = "FOR APPROVAL";
                $activityAcceptanceApproval->aaa_link_hash = $randomHash;
                $activityAcceptanceApproval->save();

                $individualData = $Act_CompletionData;
                $individualData['ApproverName'] = $Act_CompletionData['ApproverName'][$index];
                $individualData['ApproverEmail'] = $email;
                $individualData['CompanyName'] = $Act_CompletionData['CompanyName'][$index];
                $individualData['Position'] = $Act_CompletionData['Position'][$index];

                // Create a new email instance
                $emailInstance = new SendtoClient($individualData, $randomHash);

                // Send the email to the current approver
                Mail::to($email)->send($emailInstance);
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }




    //////////////////////////// Approval Completion Acceptance ////////////////////////////////////////
    public function approve(Request $request, $hash, $type, $action)
    {
        // Find the approval record based on aaa_link_hash
        $approvalRecord = tbl_activityAcceptanceApproval::where('aaa_link_hash', $hash)->first();

        // Check if a record was found
        if (!$approvalRecord) {
            return response()->json(['message' => 'Approval not found'], 404);
        }

        if ($approvalRecord->aaa_status == "APPROVED" || $approvalRecord->aaa_status == "DISAPPROVED") {
            // If already approved or disapproved
            return view('EmailTemplate.AlreadyEvaluated');
        }

        $aa_id = $approvalRecord->aaa_activityAcceptance;

        $ApproveCompletionAcceptance = tbl_activityAcceptance::where('aa_id', $aa_id)->first();
        if ($ApproveCompletionAcceptance) {
            $ApproveCompletionAcceptance->aa_status = 3;
            $ApproveCompletionAcceptance->save();
        } else {
            abort(500, 'Failed to retrieve the activity acceptance record.');
        }


        // Update the aaa_status to "APPROVED"
        $approvalRecord->aaa_status = "APPROVED";
        $approvalRecord->save();

        return view('EmailTemplate.Approve-Message', compact('type', 'action'));
    }

    public function disapprovepage($hash)
    {

        $approvalRecord = tbl_activityAcceptanceApproval::where('aaa_link_hash', $hash)->first();

        if ($approvalRecord->aaa_status == "APPROVED" || $approvalRecord->aaa_status == "DISAPPROVED") {
            // If already approved or disapproved
            return view('EmailTemplate.AlreadyEvaluated');
        }


        return view('EmailTemplate.disapprove-Message', ['hash' => $hash]);
    }

    public function saveComment(Request $request)
    {
        // Validate the request
        $request->validate([
            'txtDisapproveReason' => 'required|string',
            'hash' => 'required|string'
        ]);

        // Find the approval record based on aaa_link_hash
        $approvalRecord = tbl_activityAcceptanceApproval::where('aaa_link_hash', $request->hash)->first();

        // Check if a record was found
        if (!$approvalRecord) {
            return response()->json(['message' => 'Approval not found'], 404);
        }

        $aa_id = $approvalRecord->aaa_activityAcceptance;

        $ApproveCompletionAcceptance = tbl_activityAcceptance::where('aa_id', $aa_id)->first();
        if ($ApproveCompletionAcceptance) {
            $ApproveCompletionAcceptance->aa_status = 4;
            $ApproveCompletionAcceptance->save();
        } else {
            abort(500, 'Failed to retrieve the activity acceptance record.');
        }


        // Update the record
        $approvalRecord->aaa_disapprove_reason = $request->txtDisapproveReason;
        $approvalRecord->aaa_status = "DISAPPROVED";
        $approvalRecord->save();

        return view('EmailTemplate.disapprove-notification');
    }


    //////////////////////////// Project Completion Acceptance ////////////////////////////////////////

    public function projectsavepending(Request $request)
    {

        try {
            // Decode the JSON data
            $StoreData = json_decode($request->input('CompletionData'), true);

            $Project_id = $StoreData['project_id'];

            $ProjectSignOffSave = tbl_projectSignoff::where('project_id', $Project_id)->delete();

            $SignoffDeliverables = $StoreData['Deliverables'];
            $SignoffCreated_by = $StoreData['Created_By'];
            $SignoffCreated_date = $StoreData['CreatedDateTime'];

            $ProjectSignOffSave = new tbl_projectSignoff();
            $ProjectSignOffSave->project_id = $Project_id;
            $ProjectSignOffSave->deliverables = $SignoffDeliverables;
            $ProjectSignOffSave->created_by = $SignoffCreated_by;
            $ProjectSignOffSave->date_created = $SignoffCreated_date;
            $ProjectSignOffSave->status = 1;
            $ProjectSignOffSave->save();


            //////////////////////// Update tbl_projectSignoffApproval /////////////////////////////////////////

            $ProjectSignOffSave = tbl_projectSignoffApproval::where('project_signoff_id', $Project_id)->delete();

            // Save approvers
            $Approvers = $StoreData['approversArray'];

            foreach ($Approvers as $approver) {
                $ProjectSignOffSave = new tbl_projectSignoffApproval();
                $ProjectSignOffSave->project_signoff_id = $Project_id;
                $ProjectSignOffSave->company = $approver['company'];
                $ProjectSignOffSave->name = $approver['approver'];
                $ProjectSignOffSave->position = $approver['position'];
                $ProjectSignOffSave->email_address = $approver['email'];
                $ProjectSignOffSave->status = "PENDING";
                $ProjectSignOffSave->save();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    //////////////////////////// Attachment File ////////////////////////////////////////

    public function SignoffAttachment(Request $request)
{
    $files = $request->file('files');
    $project_id = $request->input('project_id');

    // Retrieve existing attachments from the database
    $existingAttachments = tbl_project_signoff_attachment::where('project_id', $project_id)->get();

    // Delete existing files from the directory and remove the database records
    foreach ($existingAttachments as $attachment) {
        $filePath = public_path('uploads/Sign-off-Attachments/' . $attachment->attachment);
        if (File::exists($filePath)) {
            File::delete($filePath);  // Delete the file from the directory
        }
        $attachment->delete();  // Delete the record from the database
    }

    if ($files && count($files) > 0) {
        foreach ($files as $file) {
            // Generate a unique filename
            $filename = uniqid() . '_' . $file->getClientOriginalName();

            // Specify the destination path
            $destinationPath = public_path('uploads/Sign-off-Attachments');

            // Move the uploaded file to the destination path
            $file->move($destinationPath, $filename);

            // Save the file path to the database
            $imageModel = new tbl_project_signoff_attachment();
            $imageModel->project_id = $project_id;
            $imageModel->attachment = $filename;
            $imageModel->save();
        }

        // Return success message
        return response()->json(['message' => 'Files saved successfully'], 200);
    } else {
        Log::error("Error in Saving Files");
        return response()->json(['error' => 'Error while uploading files'], 400);
    }
}


    public function RetrieveAttachment(Request $request)
{
    $project_id = $request->input('project_id');

    if ($project_id) {
        $getfiles = tbl_project_signoff_attachment::select('attachment')
            ->where('project_id', '=', $project_id)
            ->get();
        
        return response()->json(['success' => true, 'attachments' => $getfiles]);
    } else {
        Log::error("Missing Project Id");
        return response()->json(['success' => false, 'error' => 'Error while uploading files'], 400);
    }
}


    public function ProjectSignOffView(Request $request)
    {

        $projectId = $request->input('Projectlist_id');

        $Getprojects = tbl_project_list::leftJoin('tbl_projectSignoff', 'tbl_project_list.id', '=', 'tbl_projectSignoff.project_id')
            ->leftJoin('tbl_projectSignoffApproval', 'tbl_projectSignoff.project_id', '=', 'tbl_projectSignoffApproval.project_signoff_id')
            ->select(
                'tbl_project_list.id',
                'tbl_project_list.proj_name',
                'tbl_project_list.created_by',
                'tbl_project_list.created_date',
                'tbl_project_list.reseller',
                'tbl_project_list.endUser',

                'tbl_projectSignoff.deliverables',
                'tbl_projectSignoff.status',

                'tbl_projectSignoffApproval.company',
                'tbl_projectSignoffApproval.name',
                'tbl_projectSignoffApproval.position',
                'tbl_projectSignoffApproval.email_address',
                'tbl_projectSignoffApproval.status AS ApproverStatus'
            )

            ->where('tbl_project_list.id', '=',  $projectId)
            ->get();

        return view('tab-isupport-service.project-sign-off.Completion-Acceptance-Approval', compact('Getprojects'));
    }


    public function ProjectSenttoClient(Request $request)
    {
        try {
            // Decode the JSON data
            $Act_CompletionData = json_decode($request->input('CompletionData'), true);

            $ApprovalId = $Act_CompletionData['id'];

            // Retrieve the instance of the model
            $signOffApproval = tbl_projectSignoff::where('project_id', $ApprovalId)->first();
            if ($signOffApproval) {
                $signOffApproval->status = 2;
                $signOffApproval->save();
            } else {
                abort(500, 'Failed to retrieve the activity acceptance record.');
            }

         

            $Approvers = $Act_CompletionData['approversArray'];

            foreach ($Approvers as $approverData) {

         

                $email = $approverData['email'];
                $randomHash = Str::random(64);

                // Retrieve or create a new instance for each approver
                $signOffApproval = tbl_projectSignoffApproval::firstOrNew(
                    ['project_signoff_id' => $ApprovalId, 'email_address' => $email]
                );

                $signOffApproval->status = "FOR APPROVAL";
                $signOffApproval->link_hash = $randomHash;
                $signOffApproval->save();

                $ApproversInfo = [
                    'name' => $approverData['approver'],
                    'email' => $approverData['email']
                ];

                // Create a new email instance
                $emailInstance = new ProjectSendtoClient($ApproversInfo, $Act_CompletionData, $randomHash);

                // Send the email to the current approver
                Mail::to($ApproversInfo['email'])->send($emailInstance);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function projectapprove(Request $request, $hash, $type, $action)
    {
        // Find the approval record based on aaa_link_hash
        $approvalRecord = tbl_projectSignoffApproval::where('link_hash', $hash)->first();

        if (!$approvalRecord) {
            return response()->json(['message' => 'Approval not found'], 404);
        }

        if ($approvalRecord->status == "APPROVED" || $approvalRecord->status == "DISAPPROVED") {
            // If already approved or disapproved
            return view('EmailTemplate.AlreadyEvaluated');
        }

        $project_signoff_id = $approvalRecord->project_signoff_id;

        $ProjectSignedOff = tbl_projectSignoff::where('project_id', $project_signoff_id)->first();
        if ($ProjectSignedOff) {
            $ProjectSignedOff->status = 3;
            $ProjectSignedOff->save();
        } else {
            abort(500, 'Failed to retrieve the activity acceptance record.');
        }


        // Update the aaa_status to "APPROVED"
        $approvalRecord->status = "APPROVED";
        $approvalRecord->save();

        return view('EmailTemplate.Approve-Message', compact('type', 'action'));
    }

    public function projectdisapprovedpage($hash)
    {

        $approvalRecord = tbl_projectSignoffApproval::where('link_hash', $hash)->first();

        if ($approvalRecord->status == "APPROVED" || $approvalRecord->status == "DISAPPROVED") {
            // If already approved or disapproved
            return view('EmailTemplate.AlreadyEvaluated');
        }

        return view('EmailTemplate.disapprove-Message-project', ['hash' => $hash]);
    }



    public function savecommentproject(Request $request)
    {
        // Validate the request
        $request->validate([
            'txtDisapproveReason' => 'required|string',
            'hash' => 'required|string'
        ]);

        // Find the approval record based on aaa_link_hash
        $approvalRecord = tbl_projectSignoffApproval::where('link_hash', $request->hash)->first();

        // Check if a record was found
        if (!$approvalRecord) {
            return response()->json(['message' => 'Approval not found'], 404);
        }

        $project_signoff_id = $approvalRecord->project_signoff_id;

        $ApproveCompletionAcceptance = tbl_projectSignoff::where('project_id',  $project_signoff_id)->first();
        if ($ApproveCompletionAcceptance) {
            $ApproveCompletionAcceptance->status = 4;
            $ApproveCompletionAcceptance->save();
        } else {
            abort(500, 'Failed to retrieve the activity acceptance record.');
        }

        // Update the record
        $approvalRecord->disapprove_reason = $request->txtDisapproveReason;
        $approvalRecord->status = "DISAPPROVED";
        $approvalRecord->save();

        return view('EmailTemplate.disapprove-notification-project');
    }
}
