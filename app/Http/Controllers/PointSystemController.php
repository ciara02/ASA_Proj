<?php

namespace App\Http\Controllers;

use App\Models\tbl_pointSystem;
use Illuminate\Http\Request;
use App\Models\tbl_engineers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MeritUpdateNotification; // Import your mail class
use App\Mail\MeritCreatedNotification; // Import your mail class
use App\Mail\MeritApprovedNotif; // Import your mail class
use App\Mail\MeritDisapprovedNotif;
use App\Mail\UpdateSeverityLevel;
use App\Models\LDAPEngineer;
use App\Models\tbl_pointsystem_attachment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PointSystemController extends Controller
{
    public function index()
    {
        $records = tbl_pointSystem::with('pointSystemEngr')
            ->orderBy('created_date', 'desc')->get();
        session()->forget(['selectedType', 'selectedApproval']);

        $ldapUsername = Auth::user()->email;
    
        // Transform the email to match LDAP format (adjust this transformation based on your requirement)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email to ensure it's correct
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data for the currently logged-in user
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);

        return view('tab-point-system.merit-demerit', compact('records', 'ldapEngineer'));
    }

    public function meritdemeritPrint(Request $request)
    {
        $type = $request->input('type', null);
        $approval = $request->input('approval', null);

        $query = tbl_pointSystem::query();

        if ($type !== "null" && $type !== null) {
            $query->where('type', $type);
        }

        if ($approval !== "null" && $approval !== null) {
            $query->where('status', $approval);
        }

        $records = $query->orderBy('created_date', 'desc')->get();

        return view('tab-point-system.print-merit-demerit', compact('records'));
    }

    public function create()
    {
        $ldapUsername = Auth::user()->email;
    
        // Transform the email to match LDAP format (adjust this transformation based on your requirement)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email to ensure it's correct
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data for the currently logged-in user
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);
        return view('tab-point-system.create-merit-demerit', compact('ldapEngineer'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'type' => 'required|in:0,1',
                'engineer' => 'required|array', // Ensure 'engineer' is an array
                'details' => 'required',
                'defense' => 'nullable',
                'amount' => 'required',
                'points' => 'required',
                'author' => 'required',
                'createdDate' => 'required',
            ]);

            // Create a new tbl_pointSystem instance for each engineer
            foreach ($validatedData['engineer'] as $engineerName) {
                // Create a new tbl_pointSystem instance
                $tbl_pointSystem = new tbl_pointSystem();
                $tbl_pointSystem->type = $validatedData['type'];
                $tbl_pointSystem->engineer = $engineerName;
                $tbl_pointSystem->details = $validatedData['details'];
                $tbl_pointSystem->defense = $validatedData['defense'];
                $tbl_pointSystem->points = $validatedData['points'];
                $tbl_pointSystem->amount = $validatedData['amount'];
                $tbl_pointSystem->author = $validatedData['author'];
                $tbl_pointSystem->created_date = $validatedData['createdDate'];
                $tbl_pointSystem->status = 'For Approval';

                // Save the instance to the database
                $tbl_pointSystem->save();

                // Create a new engineer entry
                $engineer = new tbl_engineers();
                $engineer->engr_ar_id = $tbl_pointSystem->id; // Associate with tbl_pointSystem ID
                $engineer->engr_name = $engineerName;
                $engineer->save();
                
                   // Optional: Send email notification (commented out for now)
                   $editUrl = route('tab-point-system.edit-approval') . '?id=' . $tbl_pointSystem->id;
                   Log::info('Requested Point System ID: ' . $tbl_pointSystem->id);

                //    Mail::to(['ciara_dymosco@msi-ecs.com.ph'])
                //    ->send(new MeritCreatedNotification($tbl_pointSystem, $editUrl));
                
                   Mail::to(['MSITPSHeads@msi-ecs.com.ph'])
                       ->cc(['TPSB@msi-ecs.com.ph', 'TPSA@msi-ecs.com.ph'])
                       ->send(new MeritCreatedNotification($tbl_pointSystem, $editUrl));

                session()->flash('status', 'You have successfully created a merit and demerit request. Kindly wait for approval. Thank you');
    
                // Return JSON response with redirect URL and status message
                return response()->json([
                    'status' => 'success',
                    'id' => $tbl_pointSystem->id,
                    'message' => 'Point system created successfully.',
                    'redirect_url' => route('tab-point-system.index'), // Redirect URL
                    'status_message' => 'You have successfully created a merit and demerit request. Kindly wait for approval. Thank you' // Status message to display
                ]);
                
                
             
            }
            
            // Redirect with success message
            return redirect()->route('tab-point-system.index')->with('status', 'You have successfully created a merit and demerit request. Kindly wait for approval. Thank you');
          } catch (\Exception $e) {
            // Log the error message for further debugging
            Log::error('Error occurred while storing point system data: ' . $e->getMessage());
        
            // Log the full exception trace for further inspection
            Log::error($e->getTraceAsString());
        
            // Optionally, display the error to the user in a more controlled manner
            return redirect()->route('tab-point-system.index')->with('error', 'An error occurred while processing your request. Please try again.');
                
        }
    }
    
    public function uploadPSFiles(Request $request)
    {
        try {
            $id = $request->input('id');
            Log::info('uploadPSFiles Data ID received: ' . $id);
            $tbl_pointSystem = tbl_pointSystem::findOrFail($id);
    
            // Ensure files are present
            if ($request->hasFile('files')) {
                $files = $request->file('files'); // This should now be an array of files
    
                // Make sure it's an array before calling count()
                if (is_array($files) && count($files) > 0) {
                    foreach ($files as $file) {
                        // Check if the file is valid before proceeding
                        if ($file->isValid()) {
                            $filename = uniqid() . '_' . $file->getClientOriginalName();
                            $destinationPath = public_path('uploads/PointSystem-Attachments');
    
                            // Ensure directory exists
                            if (!is_dir($destinationPath)) {
                                mkdir($destinationPath, 0777, true); // Create folder if it doesn't exist
                            }
    
                            // Log file information (for debugging)
                            Log::info('Uploading file: ' . $filename);
    
                            // Move the file to the destination folder
                            $file->move($destinationPath, $filename);
    
                            // Save the file information in the database
                            $imageModel = new tbl_pointsystem_attachment();
                            $imageModel->ps_att_id = $tbl_pointSystem->id;
                            $imageModel->ps_att_name = $filename;
                            $imageModel->save();
                        } else {
                            // Return an error if the file is invalid
                            return response()->json(['error' => 'Invalid file uploaded'], 400);
                        }
                    }
                    session()->flash('status', 'You have successfully created a merit and demerit request with the provided attachment. Kindly wait for approval. Thank you');
    
                    // After successful upload, return a success response
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Files uploaded successfully',
                        'redirect_url' => route('tab-point-system.index'),
                        'status_message' => 'You have successfully created a merit and demerit request with the provided attachment. Kindly wait for approval. Thank you.' // Status message
                    ]);

                } else {
                    // Return an error if no files were uploaded
                    return response()->json(['error' => 'No files uploaded or invalid input'], 400);
                }
            } else {
                // Return an error if no files are uploaded
                return response()->json(['error' => 'No files uploaded'], 400);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error uploading files: ' . $e->getMessage());
            
            // Return a 500 error response
            return response()->json(['error' => 'An error occurred during file upload: ' . $e->getMessage()], 500);
        }
    }    

    private function getAllowedEmails()
    {
        return [
            'ciara_dymosco@msi-ecs.com.ph',
            'gary_delcastillo@msi-ecs.com.ph',
            'sonnie_calimutan@msi-ecs.com.ph',
            'jennie_dionisio@msi-ecs.com.ph',
            'justin_rivera@msi-ecs.com.ph',
            'louie_ladio@msi-ecs.com.ph',
            'maybel_estipular@msi-ecs.com.ph',
            'melvin_manzanares@msi-ecs.com.ph',
            'chux_lunar@msi-ecs.com.ph',
            'rey_fuyonan@msi-ecs.com.ph',
            'ed_recinto@msi-ecs.com.ph',
            'reeree_delosreyes@msi-ecs.com.ph',
            'el_linugo@msi-ecs.com.ph',
            'jay_ballesteros@msi-ecs.com.ph'
        ];
    }

        public function edit()
    {
        try {
            $id = request()->query('id');
         Log::info('EDIT Data ID received: ' . $id); // Log the ID

            $user = Auth::user();
            $allowedEmails = $this->getAllowedEmails();
            $isAllowedToEdit = in_array($user->email, $allowedEmails);

            // Fetch record
            $record = tbl_pointSystem::findOrFail($id);

            // Fetch attachments
            $attachments = tbl_pointSystem::leftJoin('tbl_pointsystem_attachment', 'tbl_pointSystem.id', '=', 'tbl_pointsystem_attachment.ps_att_id')
                ->where('tbl_pointSystem.id', '=', $id)
                ->pluck('ps_att_name'); // Only get the attachment names

            $action = route('tab-point-system.update', ['id' => $record->id]);

            $ldapUsername = Auth::user()->email;
    
            // Transform the email to match LDAP format (adjust this transformation based on your requirement)
            $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
        
            // Log the transformed email to ensure it's correct
            Log::info('Transformed email for LDAP search: ' . $ldapUsername);
        
            // Fetch the LDAP user data for the currently logged-in user
            $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);

            // Pass attachments to the view
            return view('tab-point-system.edit-merit-demerit', compact('record', 'attachments', 'isAllowedToEdit', 'ldapEngineer','action'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while loading the record. Please try again.');
        }
    }

    public function deleteAttachment(Request $request)
{
    try {
        $attachment = $request->input('attachment');

        // File path
        $filePath = public_path("uploads/PointSystem-Attachments/{$attachment}");

        // Delete the file
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Optionally, delete the attachment record in the database if applicable
        DB::table('tbl_pointsystem_attachment')
            ->where('ps_att_name', $attachment)
            ->delete();

        return response()->json(['success' => true, 'message' => 'Attachment deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Failed to delete attachment.']);
    }
}



    public function editForApproval(Request $request)
    {
        try {
            $id = $request->input('id');
            Log::info('EFA Data ID received: ' . $id);

            $user = Auth::user();
            $allowedEmails = $this->getAllowedEmails();
            $isAllowedToEdit = in_array($user->email, $allowedEmails);

            $record = tbl_pointSystem::findOrFail($id);
            $action = route('tab-point-system.update-approval');

            $attachments = tbl_pointSystem::leftJoin('tbl_pointsystem_attachment', 'tbl_pointSystem.id', '=', 'tbl_pointsystem_attachment.ps_att_id')
            ->where('tbl_pointSystem.id', '=', $id)
            ->pluck('ps_att_name'); // Only get the attachment names

            $ldapUsername = Auth::user()->email;
    
            // Transform the email to match LDAP format (adjust this transformation based on your requirement)
            $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
        
            // Log the transformed email to ensure it's correct
            Log::info('Transformed email for LDAP search: ' . $ldapUsername);
        
            // Fetch the LDAP user data for the currently logged-in user
            $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);
            
            return view('tab-point-system.edit-merit-demerit', compact('record','attachments', 'isAllowedToEdit', 'action', 'ldapEngineer'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while approving the record. Please try again.');
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('pointsystemID');
        Log::info('Update Data ID received: ' . $id); 
        return $this->processUpdate($request, $id, false);
    }
    

    public function updateForApproval(Request $request)
    {
        $id = $request->input('pointsystemID');
        Log::info('UFA Data ID received: ' . $id);
        return $this->processUpdate($request, $id, true);
    }

    public function approve(Request $request)
    {
        try {
            $id = $request->input('id');
            Log::info('Approve Data ID received: ' . $id); 

            $ldapUsername = Auth::user()->email;

            // Transform the email to match LDAP format (adjust if needed)
            $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
            
            // Log the transformed email for debugging
            Log::info('Transformed email for LDAP search: ' . $ldapUsername);

            // Fetch the LDAP user data for the currently logged-in user
            $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);

            // Log the response from LDAP
            Log::info('LDAP Engineer Data: ' . json_encode($ldapEngineer));

            if (!$ldapEngineer || !isset($ldapEngineer->fullName)) {
                throw new \Exception('LDAP user not found or missing name attribute.');
            }

            $record = tbl_pointSystem::findOrFail($id);

            // Update status to 'Approved'
            $record->update([
                'status' => 'Approved',
                'approver' => $ldapEngineer->fullName, 
                'approval_date' => Carbon::now()->format('Y-m-d'),
            ]);

            $editUrl = route('tab-point-system.edit-approval') . '?id=' . $record->id;

            Mail::to([
                'MSITPSHeads@msi-ecs.com.ph'
                ])->cc([
                    'TPSB@msi-ecs.com.ph',
                    'TPSA@msi-ecs.com.ph'])
                    ->send(new MeritApprovedNotif($record, $editUrl));

            // Perform other necessary actions...

            return redirect()->route('tab-point-system.edit-approval', ['id' => $id])->with('status', 'The record has been approved.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error approving record: ' . $e->getMessage());

            // Handle exceptions
            return redirect()->back()->with('error', 'An error occurred while approving the record. Please try again.');
        }
    }

    public function disapprove(Request $request)
    {
        try {
            $id = $request->input('id');
            Log::info('Disapprove Data ID received: ' . $id); 

            $ldapUsername = Auth::user()->email;

            // Transform the email to match LDAP format (adjust if needed)
            $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
            
            // Log the transformed email for debugging
            Log::info('Transformed email for LDAP search: ' . $ldapUsername);

            // Fetch the LDAP user data for the currently logged-in user
            $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);

            // Log the response from LDAP
            Log::info('LDAP Engineer Data: ' . json_encode($ldapEngineer));

            if (!$ldapEngineer || !isset($ldapEngineer->fullName)) {
                throw new \Exception('LDAP user not found or missing name attribute.');
            }

            $record = tbl_pointSystem::findOrFail($id);

            // Update status to 'Disapproved'
            $record->update([
                'status' => 'Disapproved',
                'approver' => $ldapEngineer->fullName, 
                'approval_date' => Carbon::now()->format('Y-m-d'),
            ]);

            $editUrl = route('tab-point-system.edit-approval') . '?id=' . $record->id;

            Mail::to([
                'MSITPSHeads@msi-ecs.com.ph'
                ])->cc([
                    'TPSB@msi-ecs.com.ph',
                    'TPSA@msi-ecs.com.ph'])
                ->send(new MeritDisapprovedNotif($record, $editUrl));


            return redirect()->route('tab-point-system.edit-approval', ['id' => $id])->with('status', 'The record has been disapproved.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error disapproving record: ' . $e->getMessage());

            // Handle exceptions
            return redirect()->back()->with('error', 'An error occurred while disapproving the record. Please try again.');
        }
    }
    private function processUpdate(Request $request,$id, bool $isApproval)
    {
        $id = $request->input('pointsystemID');
        Log::info('Process Update Data ID received: ' . $id);
        Log::info('Entered processUpdate method');
        try {
            // Find the record to update
            $record = tbl_pointSystem::findOrFail($id);
    
            // Validate the request input
            $request->validate([
                'type' => 'required|in:0,1',
                'details' => 'required',
                'defense' => 'nullable',
                'amount' => 'required',
                'points' => 'required',
                'author' => 'required',
                'createdDate' => 'required',
                'files' => 'nullable|array',  
               'files.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,zip,rar|max:20480',
            ]);
    
            // Handle file upload only if there are new files
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                Log::info('Files received: ' . count($files)); // Log number of files received
    
                $destinationPath = public_path('uploads/PointSystem-Attachments');
    
                // Ensure the directory exists
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true); // Create folder if it doesn't exist
                    Log::info('Created folder: ' . $destinationPath);
                }
    
                // Remove old attachments if necessary
                if ($isApproval && $request->has('remove_attachments')) {
                    foreach ($request->input('remove_attachments', []) as $attachmentId) {
                        $attachment = tbl_pointsystem_attachment::find($attachmentId);
                        if ($attachment) {
                            // Delete the file from disk
                            $filePath = $destinationPath . '/' . $attachment->ps_att_name;
                            if (file_exists($filePath)) {
                                unlink($filePath); // Delete the file
                            }
                            // Remove from database
                            $attachment->delete();
                            Log::info('Deleted attachment: ' . $attachment->ps_att_name);
                        }
                    }
                }
    
                // Upload new files
                foreach ($files as $file) {
                    // Check if the file is valid before proceeding
                    if ($file->isValid()) {
                        $filename = uniqid() . '_' . $file->getClientOriginalName();
    
                        // Move the file to the destination folder
                        $file->move($destinationPath, $filename);
                        Log::info('File uploaded: ' . $filename);
    
                        // Save the file information in the database
                        $attachment = new tbl_pointsystem_attachment();
                        $attachment->ps_att_id = $record->id;
                        $attachment->ps_att_name = $filename;
                        $attachment->save();
                        Log::info('Attachment saved to DB: ' . $filename);
                    } else {
                        Log::error('Invalid file: ' . $file->getClientOriginalName());
                        return response()->json(['error' => 'Invalid file uploaded'], 400);
                    }
                }
            } else {
                Log::info('No files uploaded');
            }
    
            // Proceed with other updates (but do not overwrite existing attachments)
            $record->update($request->only([
                'type',
                'details',
                'defense',
                'amount',
                'points',
                'author',
                'createdDate'
            ]));
    
            // No need to check for changes since the record is being updated directly
            $record = tbl_pointSystem::findOrFail($id);
          
            $editUrl = route('tab-point-system.edit-approval') . '?id=' . $record->id;

                 // Check if the email has been sent recently (within the last 3 seconds)
            $lastEmailSent = Cache::get('last_email_sent_' . $id);

            if (!$lastEmailSent || now()->diffInSeconds($lastEmailSent) >= 3) {
                // Send email only if enough time has passed or if it hasn't been sent before
               Mail::to([
                    'MSITPSHeads@msi-ecs.com.ph'
                     ])->cc([
                    'TPSB@msi-ecs.com.ph',
                    'TPSA@msi-ecs.com.ph'])
                ->send(new MeritUpdateNotification($record, $editUrl));

                // Update cache to track the last email sent timestamp
                // Store for 3 seconds, allowing resend after this period
                Cache::put('last_email_sent_' . $id, now(), now()->addSeconds(3)); 
            } else {
                Log::info('Email already sent recently. Not sending again.');
            }

            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'redirect' => route('tab-point-system.index'), 'message' => 'You have successfully updated a merit and demerit request. Kindly wait for approval. Thank you']);
            }
    
            return redirect()->route('tab-point-system.index')->with('status', 'You have successfully updated a merit and demerit request. Kindly wait for approval. Thank you');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
    
            dd($e->getMessage());
        }
    }
    

    public function getEngineers(Request $request)
    {
        $term = $request->input('term'); // Get the search term from the request

        $engineers = tbl_engineers::where('engr_name', 'like', "%$term%")
            ->distinct()
            ->orderBy('engr_name')
            ->pluck('engr_name');

        return response()->json(['data' => $engineers]);
    }

    public function severityUpdate(Request $request)
    {
        try {
            
        $id = $request->input('approval_pointsystemID');
        Log::info('Severity update Process Update Data ID received: ' . $id); 

            $record = tbl_pointSystem::findOrFail($id);

            $request->validate([
                'points' => 'required',
            ]);

            // Update only the points field
            $record->update([
                'points' => $request->input('points'),
            ]);

            $editUrl = route('tab-point-system.edit-approval') . '?id=' . $record->id;

            Mail::to([
                'MSITPSHeads@msi-ecs.com.ph'
                ])->cc([
                    'TPSB@msi-ecs.com.ph',
                    'TPSA@msi-ecs.com.ph'])
                    ->send(new UpdateSeverityLevel($record, $editUrl));

            return redirect()->route('tab-point-system.index', ['id' => $id])->with('status', 'Points updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tab-point-system.index', ['id' => $id])->with('error', 'Error updating points: ' . $e->getMessage());
        }
    }
}
