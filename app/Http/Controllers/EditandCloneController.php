<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_actionPlan;
use App\Models\tbl_engineers;
use App\Models\tbl_project_type_list;
use App\Models\tbl_time_list;
use App\Models\tbl_prodEngineers;
use App\Models\tbl_activityReport;
use App\Models\tbl_attachments;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\tbl_activityType_list;
use App\Models\tbl_participants;
use App\Models\tbl_productLine;
use App\Models\tbl_program_list;
use App\Models\tbl_project_list;
use App\Models\LDAPEngineer;
use App\Models\tbl_copyTo;
use App\Models\tbl_digiKnow_flyer;
use App\Models\tbl_projectMember;
use App\Services\ProductLineQuery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class EditandCloneController extends Controller
{
    public function getReferenceforCloning()
    {
        // Get current date
        $currentDate = now();
        $formattedDate = $currentDate->format('Ymd');

        // Generate random 5-digit number
        $randomNumber = str_pad(mt_rand(1, 99999), 6, '0', STR_PAD_LEFT);

        // Combine date and random number to create the ASA number
        $asaNumber = $formattedDate . '-' . $randomNumber;

        return response()->json($asaNumber);
    }

    public function saveCloneModal(Request $request)
    {
        $report = $request->input('report');
        $status = $request->input('status');
        $ref_no = $request->input('reference_num');
        $projtype = $request->input('projtype');
        $projname = $request->input('projname');

        $projnameID = $request->input('projnameID');

        $activity_detailsClone = $request->input('act_details');
        $act_details_requesterClone = $request->input('act_details_req');
        $ProductEngineerClone = $request->input('product_engr');
        $copyToClone = $request->input('copy_to');
        $DatefiledClone = $request->input('date_filed');
        $ActivityDetailsActivityClone = $request->input('act_details_activity');
        $DateNeededClone = $request->input('date_needed');
        $SpecialInstructionClone = $request->input('special_instr');

        $resellerClone = $request->input('reseller');
        $reseller_contactClone = $request->input('reseller_contact');
        $reseller_phone_emailClone = $request->input('reseller_phone_email');
        $enduser_nameClone = $request->input('enduser_name');
        $enduser_contactClone = $request->input('enduser_contact');
        $enduser_emailClone = $request->input('enduser_email');
        $enduser_locationClone = $request->input('enduser_location');

        $Act_dateClone = $request->input('Act_date');
        $Activity_typeClone = $request->input('Activity_type');
        $ProgramClone = $request->input('Program');
        $Product_lineClone = $request->input('Product_line');
        $Time_expectedClone = $request->input('Time_expected1');
        $Time_reportedClone = $request->input('Time_reported1');
        $Time_exitedClone = $request->input('Time_exited1');
        $engineer_nameClone = $request->input('engineer_name');
        $VenueClone = $request->input('Venue');
        $Send_copy_toClone = $request->input('Send_copy_to');

        $ParticipantandPosition = $request->input('formData');

        $CustomerRequirements = $request->input('customer_req');
        $ActivityDone = $request->input('Activity_Done');
        $Agreements_modal = $request->input('Agreements');

        $ActionPlanandRecommendation = $request->input('ActionPlanRecommendation');


        $Stra_TopicName = $request->input('Stra_TopicName');
        $Stra_DateStart = $request->input('Stra_DateStart');
        $Stra_DateEnd = $request->input('Stra_DateEnd');

        $POC_ProdModel = $request->input('POC_ProdModel');
        $POC_AssetCode = $request->input('POC_AssetCode');
        $POC_DateStart = $request->input('POC_DateStart');
        $POC_DateEnd = $request->input('POC_DateEnd');

        $Tech_Title = $request->input('Tech_Title');
        $Tech_examCode = $request->input('Tech_examCode');
        $Tech_status = $request->input('Tech_status');
        $Tech_ScoreDropdown = $request->input('Tech_ScoreDropdown');
        $Tech_examType = $request->input('Tech_examType');
        $Tech_incStatus = $request->input('Tech_incStatus');
        $Tect_incDetails = $request->input('Tect_incDetails');
        $Tech_examAmount = $request->input('Tech_examAmount');

        $Tech_ProdLearned = $request->input('Tech_ProdLearned');

        $Skills_trainingName = $request->input('Skills_trainingName');
        $Skills_speaker = $request->input('Skills_speaker');
        $Skills_location = $request->input('Skills_location');
        $Skill_bpcheckBox = $request->input('Skill_bpcheckBox');
        $Skills_eucheckbox = $request->input('Skills_eucheckbox');
        $Skill_msicheckbox = $request->input('Skill_msicheckbox');

        $Bp_digiCheckbox = $request->input('Bp_digiCheckbox');
        $Eu_digiCheckbox = $request->input('Eu_digiCheckbox');

        $Internal_Msi = $request->input('Internal_Msi');
        $Internal_Percent = $request->input('Internal_Percent');
        $Internal_Attendance = $request->input('Internal_Attendance');

        $Memo_Issued = $request->input('Memo_Issued');
        $Memo_Details = $request->input('Memo_Details');

        $Engr_feedback = $request->input('Engr_feedback');
        $Engr_rating = $request->input('Engr_rating');

        $T2R_topic = $request->input('T2R_topic');
        $T2R_datestart = $request->input('T2R_datestart');
        $T2R_dateEnd = $request->input('T2R_dateEnd');

        $reportconvert = 0;
        $statusconvert = 0;
        $projtypeconvert = 0;

        switch ($report) {
            case "Support Request":
                $reportconvert = 1;
                break;
            case "iSupport Services":
                $reportconvert = 2;
                break;
            case "Client Calls":
                $reportconvert = 3;
                break;
            case "Internal Enablement":
                $reportconvert = 4;
                break;
            case "Partner Enablement/Recruitment":
                $reportconvert = 5;
                break;
            case "Supporting Activity":
                $reportconvert = 6;
                break;
            case "Skills Development":
                $reportconvert = 7;
                break;
            case "Others":
                $reportconvert = 8;
                break;
            default:
                // Handle default case
                break;
        }

        switch ($status) {
            case "Pending":
                $statusconvert = 1;
                break;
            case "Cancelled":
                $statusconvert = 2;
                break;
            case "For Follow Up":
                $statusconvert = 3;
                break;
            case "Activity Report being created":
                $statusconvert = 4;
                break;
            case "Completed":
                $statusconvert = 5;
                break;
            default:
                // Handle default case
                break;
        }

        switch ($projtype) {
            case "Implementation":
                $projtypeconvert = 1;
                break;
            case "Maintenance Agreement":
                $projtypeconvert = 2;
                break;
            default:
                // Handle default case
                break;
        }

        try {
            ///////////// Header /////////
            // Save the data to tbl_project_list
            $project = new tbl_project_list();
            $project->proj_type_id = $projtypeconvert;
            $project->proj_name = $projname;
            $project->save();

            // Save the data to tbl_activityReport
            $activityReport = new tbl_activityReport();
            $activityReport->ar_report = $reportconvert;
            $activityReport->ar_status = $statusconvert;
            $activityReport->ar_refNo = $ref_no;
            $activityReport->ar_project = $projnameID; // Use the ID of tbl_project_list

            ///////////// Activity Details /////////
            if (!empty($request->input('act_details'))) {
                $activityReport->ar_activity = $request->input('act_details');
            } elseif (!empty($request->input('act_details_activity'))) {
                $activityReport->ar_activity = $request->input('act_details_activity');
            } else {
                $activityReport->ar_activity = null; // Handle empty case if needed
            }
            $activityReport->ar_requester = $act_details_requesterClone;
            $activityReport->ar_date_filed = $DatefiledClone;
            $activityReport->ar_date_needed =  $DateNeededClone;
            $activityReport->ar_instruction = $SpecialInstructionClone;

            ///////////// Contract Details /////////
            $activityReport->ar_resellers = $resellerClone;
            $activityReport->ar_resellers_contact = $reseller_contactClone;
            $activityReport->ar_resellers_phoneEmail = $reseller_phone_emailClone;
            $activityReport->ar_endUser = $enduser_nameClone;
            $activityReport->ar_endUser_contact = $enduser_contactClone;
            $activityReport->ar_endUser_phoneEmail = $enduser_emailClone;
            $activityReport->ar_endUser_loc = $enduser_locationClone;

            ///////////// Activity Summary Report /////////

            $activityReport->ar_activityDate = $Act_dateClone;
            $activityReport->ar_venue = $VenueClone;
            $activityReport->ar_sendCopyTo = $Send_copy_toClone;


            //////////Customer Req,  Activity Done, Agreements ///////////////////

            $activityReport->ar_custRequirements = $CustomerRequirements;
            $activityReport->ar_activityDone = $ActivityDone;
            $activityReport->ar_agreements = $Agreements_modal;

            ////////////////////StraCert && T2R //////////////////////////////////
            $activityReport->ar_topic = $Stra_TopicName ?? $T2R_topic;
            $activityReport->ar_dateStart = $Stra_DateStart ?? $T2R_datestart;
            $activityReport->ar_dateEnd = $Stra_DateEnd ?? $T2R_dateEnd;

            ///////////////////POC/////////////////////////////////////////
            $activityReport->ar_POCproductModel = $POC_ProdModel;
            $activityReport->ar_POCassetOrCode = $POC_AssetCode;
            $activityReport->ar_POCdateStart = $POC_DateStart;
            $activityReport->ar_POCdateEnd = $POC_DateEnd;

            ///////////////////Tech Certificate/////////////////////////////////////////
            $activityReport->ar_title = $Tech_Title;
            $activityReport->ar_examName = $Tech_examCode;
            $activityReport->ar_takeStatus = $Tech_status;
            $activityReport->ar_score = $Tech_ScoreDropdown;
            $activityReport->ar_examType = $Tech_examType;
            $activityReport->ar_incStatus = $Tech_incStatus;
            $activityReport->ar_incDetails = $Tect_incDetails;
            $activityReport->ar_incAmount = $Tech_examAmount;

            ////////////////////TechLearned///////////////////////////////////////
            $activityReport->ar_prodLearned = $Tech_ProdLearned;

            /////////////////////Skills Dev/////////////////////////////////////
            $activityReport->ar_trainingName = $Skills_trainingName;
            $activityReport->ar_speakers = $Skills_speaker;
            $activityReport->ar_location = $Skills_location;
            $activityReport->ar_attendeesBPs = $Skill_bpcheckBox;
            $activityReport->ar_attendeesEUs = $Skills_eucheckbox;
            $activityReport->ar_attendeesMSI = $Skill_msicheckbox;

            /////////////////////DigiKnow/////////////////////////////////////
            $activityReport->ar_recipientBPs = $Bp_digiCheckbox;
            $activityReport->ar_recipientEUs = $Eu_digiCheckbox;

            /////////////////////Internal Proj/////////////////////////////////////
            $activityReport->ar_projName = $Internal_Msi;
            $activityReport->ar_compPercent = $Internal_Percent;
            $activityReport->ar_perfectAtt = $Internal_Attendance;

            /////////////////////Memo/////////////////////////////////////
            $activityReport->ar_memoIssued = $Memo_Issued;
            $activityReport->ar_memoDetails = $Memo_Details;

            /////////////////////Engr Feedback/////////////////////////////////////
            $activityReport->ar_feedbackEngr = $Engr_feedback;
            $activityReport->ar_rating = $Engr_rating;


            /////////////////// Time Expected, Reported, Exited //////////////////

            $keyId_reported = tbl_time_list::where('key_time', $Time_reportedClone)->value('key_id');
            $activityReport->ar_timeReported = $keyId_reported;

            $keyId_expected = tbl_time_list::where('key_time', $Time_expectedClone)->value('key_id');
            $activityReport->ar_timeExpected =  $keyId_expected;

            $keyId_exited = tbl_time_list::where('key_time', $Time_exitedClone)->value('key_id');
            $activityReport->ar_timeExited = $keyId_exited;

            $activityType_id = tbl_activityType_list::where('type_name',  $Activity_typeClone)->value('type_id');
            $activityReport->ar_activityType = $activityType_id;

            $program_id = tbl_program_list::where('program_name', $ProgramClone)->value('program_id');
            $activityReport->ar_program = $program_id;

            $activityReport->save();

            // Save the ar_id for use in the response
            $arId = $activityReport->ar_id;


            /////////////////// Participant and Position //////////////////
            if (is_array($ParticipantandPosition) && !empty($ParticipantandPosition)) {
                foreach ($ParticipantandPosition as $ParticipantandPositions) {
                    // Extract participant and position data
                    $participant = $ParticipantandPositions['participant'];
                    $position = $ParticipantandPositions['position'];

                    // Create a new instance of tbl_participants model
                    $participantModel = new tbl_participants();

                    // Set participant and position attributes
                    $participantModel->participant = $participant;
                    $participantModel->position = $position;

                    $participantModel->ar_id = $activityReport->ar_id;

                    // Save the participant to the database
                    $participantModel->save();
                }
            } else {
                Log::error("Error occurred while Saving Participants and Position");
            }

            /////////////////// Action Plan and Recommendation //////////////////
            if (is_array($ActionPlanandRecommendation) && !empty($ActionPlanandRecommendation)) {
                foreach ($ActionPlanandRecommendation as $ActionPlanandRecommendations) {
                    // Extract participant and position data
                    $Plantargetdate = $ActionPlanandRecommendations['plantarget'];
                    $Plandetails = $ActionPlanandRecommendations['details'];
                    $Planowner = $ActionPlanandRecommendations['planowner'];

                    // Create a new instance of tbl_participants model
                    $ActionPlanModel = new tbl_actionPlan();

                    // Set participant and position attributes
                    $ActionPlanModel->PlanTargetDate = $Plantargetdate;
                    $ActionPlanModel->PlanDetails = $Plandetails;
                    $ActionPlanModel->PlanOwner = $Planowner;

                    $ActionPlanModel->ar_id = $activityReport->ar_id;

                    // Save the participant to the database
                    $ActionPlanModel->save();
                }
            } else {
                Log::error("Error occurred while Saving Action Plan and Recommendation ");
            }


            $productLineQuery = new ProductLineQuery();
            if (is_array($Product_lineClone)) {
                foreach ($Product_lineClone as $productName) {
                    $product_line = new tbl_productLine();

                    // Set the product name
                    $product_line->ProductLine = $productName;

                    // Fetch product code based on product name
                    $productCode = $productLineQuery->getProductCode($productName);

                    // Check if product code is fetched successfully
                    if ($productCode) {
                        $product_line->ProductCode = $productCode;
                    } else {
                        $product_line->ProductCode = "Unknown";
                    }

                    // Assuming $activityReport is defined somewhere in your code
                    $product_line->ar_id = $activityReport->ar_id;

                    // Save the product line
                    $product_line->save();
                }
            } else {
                // Log an error if $ldapEngineers1 is not an array
                Log::error("Did not return an array.");
            }


            /////////////////// Product Engineer Only //////////////////
            $engineerNames = explode(',', $ProductEngineerClone);
            $ldapEngineers1 = LDAPEngineer::fetchFromLDAP();

            if (is_array($engineerNames)) {
                foreach ($engineerNames as $engineerName) {
                    // Find the engineer in LDAP data
                    $ldapEngineer = null;
                    foreach ($ldapEngineers1 as $ldap) {
                        if ($ldap->fullName === trim($engineerName)) {
                            $ldapEngineer = $ldap;
                            break;
                        }
                    }
                    // Only save if engineer name exists and either email is found or no email is provided
                    if (!empty($engineerName) && ($ldapEngineer && !empty($ldapEngineer->email))) {
                        // Save engineer's name
                        $engineer = new tbl_prodEngineers();
                        $engineer->prodEngr_name = $engineerName;
                        $engineer->prodEngr_email = $ldapEngineer->email;
                        $engineer->prodEngr_ar_id = $activityReport->ar_id;
                        $engineer->save();
                    } else {
                        Log::error("No Product Engineer Found ");
                    }
                }
            } else {
                // Log an error if $ldapEngineers1 is not an array
                Log::error("LDAPEngineer::fetchFromLDAP() did not return an array.");
            }


            // /////////////////// Engineer  //////////////////
            // $ldapEngineers = LDAPEngineer::fetchFromLDAP();

            // // Iterate over the array of engineer names
            // if (is_array($engineer_nameClone)) {
            //     foreach ($engineer_nameClone as $engineerNameModal) {
            //         // Find the engineer in LDAP data
            //         $ldapEngineer = null;
            //         foreach ($ldapEngineers as $ldap) {
            //             if ($ldap->fullName === trim($engineerNameModal)) {
            //                 $ldapEngineer = $ldap;
            //                 break;
            //             }
            //         }
            //         if ($ldapEngineer) {
            //             $engineer = new tbl_engineers();
            //             $engineer->engr_name = $ldapEngineer->fullName;
            //             $engineer->engr_email = $ldapEngineer->email;
            //             $engineer->engr_ar_id = $activityReport->ar_id;
            //             $engineer->save();
            //         } else {
            //             Log::error("Error occurred while finding Engineer Email ");
            //         }
            //     }
            // } else {
            //     // Log an error if $ldapEngineers1 is not an array
            //     Log::error("LDAPEngineer::fetchFromLDAP() did not return an array.");
            // }

            /////////////////// Engineer  //////////////////
            $ldapEngineers = LDAPEngineer::fetchFromLDAP();

            // Check if engineer_nameClone is empty and set it to the current user's name if it is
            if (empty($engineer_nameClone)) {
                $engineer_nameClone = [Auth::user()->name];
            }

            // Iterate over the array of engineer names
            if (is_array($engineer_nameClone)) {
                foreach ($engineer_nameClone as $engineerNameModal) {
                    $foundInLDAP = false;
                    foreach ($ldapEngineers as $ldapEngineer) {
                        if ($ldapEngineer->fullName === trim($engineerNameModal)) {
                            $engineer = new tbl_engineers();
                            $engineer->engr_name = $ldapEngineer->fullName;
                            $engineer->engr_email = $ldapEngineer->email;
                            $engineer->engr_ar_id = $activityReport->ar_id;
                            $engineer->save();
                            $foundInLDAP = true;
                            break;
                        }
                    }

                    // If not found in LDAP, use the authenticated user
                    if (!$foundInLDAP) {
                        $engineer = new tbl_engineers();
                        $engineer->engr_name = Auth::user()->name;
                        $engineer->engr_email = Auth::user()->email ?? null; // Use null if email is not available
                        $engineer->engr_ar_id = $activityReport->ar_id;
                        $engineer->save();
                    }
                }
            } else {
                Log::error("Error occurred while processing Engineers.");
            }



            /////////////////// Copy To Engineers //////////////////
            $CopyToEngineer = explode(',', $copyToClone);
            $ldapEngineers3 = LDAPEngineer::fetchFromLDAP();

            if (is_array($CopyToEngineer)) {
                foreach ($CopyToEngineer as $CopyToEngineers) {
                    // Find the engineer in LDAP data
                    $ldapEngineer = null;
                    foreach ($ldapEngineers3 as $ldap) {
                        if ($ldap->fullName === trim($CopyToEngineers)) {
                            $ldapEngineer = $ldap;
                            break;
                        }
                    }

                    // Only save if engineer name exists and either email is found or no email is provided
                    if (!empty($CopyToEngineers) && ($ldapEngineer && !empty($ldapEngineer->email))) {
                        // Save engineer's name
                        $copytoengineer = new tbl_copyTo();
                        $copytoengineer->copy_name = $CopyToEngineers;
                        $copytoengineer->copy_email = $ldapEngineer->email;
                        $copytoengineer->copy_ar_id = $activityReport->ar_id;
                        $copytoengineer->save();
                    } else {
                        Log::error("No Copy To Engineer Found ");
                    }
                }
            } else {
                // Log an error if $ldapEngineers1 is not an array
                Log::error("LDAPEngineer::fetchFromLDAP() did not return an array.");
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error occurred while saving activity report: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred while saving data'], 500);
        }
        // Return success message
        // return response()->json(['message' => 'Data saved successfully'], 200);
        return response()->json(['message' => 'Data saved successfully', 'ar_id' => $arId], 200);
    }

    public function GetImage(Request $request)
    {
        $file = $request->file('file');
        $ar_id = $request->input('ar_id'); // Get the ar_id from the request

        // Check if the record with the given ar_id exists
        $imageModel = tbl_attachments::where('att_ar_id', $ar_id)->first();

        if (!$imageModel) {
            // No existing record found, save the file instead

            Log::info("Existing Record not found, Save file Instead");

            // Generate unique filenames
            $filename = uniqid() . '_' . $file->getClientOriginalName();

            // Specify the destination path
            $destinationPath = public_path('uploads');

            // Move the uploaded files to the destination path
            $file->move($destinationPath, $filename);

            // Save the file paths to the database
            $imageModel = new tbl_attachments();
            $imageModel->att_ar_id = $ar_id;
            $imageModel->att_name = $filename;
            $imageModel->save();


            // Return success message
            return response()->json(['message' => 'File Data saved successfully'], 200);
        } else {
            Log::error("Error in Saving Image");
            return response()->json(['error' => 'Error while uploading file'], 400);
        }
    }

    public function GetDigiknowImage(Request $request)
    {
        $digiknow_file = $request->file('digiknow_file'); // Retrieve digiknow_file
        $ar_id = $request->input('ar_id'); // Get the ar_id from the request

        $digiKnow_imageModel = tbl_digiKnow_flyer::where('ar_id', $ar_id)->first();

        if (!$digiKnow_imageModel) {
            // No existing record found, save the file instead

            Log::info("Existing Record not found, Save file Instead");

            // Generate unique filenames
            $digiKnow_filename = uniqid() . '_' . $digiknow_file->getClientOriginalName();

            // Specify the destination path
            $destinationPath = public_path('uploads');

            $digiknow_file->move($destinationPath, $digiKnow_filename);

            $digiKnow_imageModel = new tbl_digiKnow_flyer();
            $digiKnow_imageModel->ar_id = $ar_id;
            $digiKnow_imageModel->attachment = $digiKnow_filename;
            $digiKnow_imageModel->save();


            // Return success message
            return response()->json(['message' => 'File Data saved successfully'], 200);
        } else {
            Log::error("Error in Saving Image");
            return response()->json(['error' => 'Error while uploading file'], 400);
        }
    }

    public function editModal(Request $request)
    {
        $ref_no = $request->input('reference_num'); // Get the ID of the record to update

        // Fetch the existing activity report by ID

        $activityReport = tbl_activityReport::where('ar_refNo', $ref_no)->firstOrFail();
        if (!$activityReport) {
            return response()->json(['error' => 'Activity Report not found'], 404);
        }


        $report = $request->input('report');
        $status = $request->input('status');
        // $ref_no = $request->input('reference_num');
        $projtype = $request->input('projtype');
        $projname = $request->input('projname');
        $projnameID = $request->input('projnameID');

        $activity_detailsClone = $request->input('act_details');
        $act_details_requesterClone = $request->input('act_details_req');
        $ProductEngineerClone = $request->input('product_engr');
        $copyToClone = $request->input('copy_to');
        $DatefiledClone = $request->input('date_filed');
        $ActivityDetailsActivityClone = $request->input('act_details_activity');
        $DateNeededClone = $request->input('date_needed');
        $SpecialInstructionClone = $request->input('special_instr');

        $resellerClone = $request->input('reseller');
        $reseller_contactClone = $request->input('reseller_contact');
        $reseller_phone_emailClone = $request->input('reseller_phone_email');
        $enduser_nameClone = $request->input('enduser_name');
        $enduser_contactClone = $request->input('enduser_contact');
        $enduser_emailClone = $request->input('enduser_email');
        $enduser_locationClone = $request->input('enduser_location');

        $Act_dateClone = $request->input('Act_date');
        $Activity_typeClone = $request->input('Activity_type');
        $ProgramClone = $request->input('Program');
        $Product_lineClone = $request->input('Product_line');
        $Time_expectedClone = $request->input('Time_expected1');
        $Time_reportedClone = $request->input('Time_reported1');
        $Time_exitedClone = $request->input('Time_exited1');
        $engineer_nameClone = $request->input('engineer_name');
        $VenueClone = $request->input('Venue');
        $Send_copy_toClone = $request->input('Send_copy_to');

        $ParticipantandPosition = $request->input('formData');

        $CustomerRequirements = $request->input('customer_req');
        $ActivityDone = $request->input('Activity_Done');
        $Agreements_modal = $request->input('Agreements');

        $ActionPlanandRecommendation = $request->input('ActionPlanRecommendation');

        $Stra_TopicName = $request->input('Stra_TopicName');
        $Stra_DateStart = $request->input('Stra_DateStart');
        $Stra_DateEnd = $request->input('Stra_DateEnd');

        $POC_ProdModel = $request->input('POC_ProdModel');
        $POC_AssetCode = $request->input('POC_AssetCode');
        $POC_DateStart = $request->input('POC_DateStart');
        $POC_DateEnd = $request->input('POC_DateEnd');

        $Tech_Title = $request->input('Tech_Title');
        $Tech_examCode = $request->input('Tech_examCode');
        $Tech_status = $request->input('Tech_status');
        $Tech_ScoreDropdown = $request->input('Tech_ScoreDropdown');
        $Tech_examType = $request->input('Tech_examType');
        $Tech_incStatus = $request->input('Tech_incStatus');
        $Tect_incDetails = $request->input('Tect_incDetails');
        $Tech_examAmount = $request->input('Tech_examAmount');

        $Tech_ProdLearned = $request->input('Tech_ProdLearned');

        $Skills_trainingName = $request->input('Skills_trainingName');
        $Skills_speaker = $request->input('Skills_speaker');
        $Skills_location = $request->input('Skills_location');
        $Skill_bpcheckBox = $request->input('Skill_bpcheckBox');
        $Skills_eucheckbox = $request->input('Skills_eucheckbox');
        $Skill_msicheckbox = $request->input('Skill_msicheckbox');

        $Bp_digiCheckbox = $request->input('Bp_digiCheckbox');
        $Eu_digiCheckbox = $request->input('Eu_digiCheckbox');

        $Internal_Msi = $request->input('Internal_Msi');
        $Internal_Percent = $request->input('Internal_Percent');
        $Internal_Attendance = $request->input('Internal_Attendance');

        $Memo_Issued = $request->input('Memo_Issued');
        $Memo_Details = $request->input('Memo_Details');

        $Engr_feedback = $request->input('Engr_feedback');
        $Engr_rating = $request->input('Engr_rating');

        $T2R_topic = $request->input('T2R_topic');
        $T2R_datestart = $request->input('T2R_datestart');
        $T2R_dateEnd = $request->input('T2R_dateEnd');

        $reportconvert = 0;
        $statusconvert = 0;
        $projtypeconvert = 0;

        switch ($report) {
            case "Support Request":
                $reportconvert = 1;
                break;
            case "iSupport Services":
                $reportconvert = 2;
                break;
            case "Client Calls":
                $reportconvert = 3;
                break;
            case "Internal Enablement":
                $reportconvert = 4;
                break;
            case "Partner Enablement/Recruitment":
                $reportconvert = 5;
                break;
            case "Supporting Activity":
                $reportconvert = 6;
                break;
            case "Skills Development":
                $reportconvert = 7;
                break;
            case "Others":
                $reportconvert = 8;
                break;
            default:
                // Handle default case
                break;
        }

        switch ($status) {
            case "Pending":
                $statusconvert = 1;
                break;
            case "Cancelled":
                $statusconvert = 2;
                break;
            case "For Follow up":
                $statusconvert = 3;
                break;
            case "Activity Report being created":
                $statusconvert = 4;
                break;
            case "Completed":
                $statusconvert = 5;
                break;
            default:
                // Handle default case
                break;
        }

        switch ($projtype) {
            case "Implementation":
                $projtypeconvert = 1;
                break;
            case "Maintenance Agreement":
                $projtypeconvert = 2;
                break;
            default:
                // Handle default case
                break;
        }

        try {
            ///////////// Header /////////
            // Update the data in tbl_project_list
            $project = tbl_project_list::where('proj_name', $projname)->first();

            if (!$project) {
                // If the project doesn't exist, create a new one
                $project = new tbl_project_list();
                $project->proj_type_id = $projtypeconvert;
                $project->proj_name = $projname;
                $project->save(); // Save the new project to generate an ID
            } else {
                // If the project exists, update its fields
                $project->proj_type_id = $projtypeconvert;
                $project->proj_name = $projname;
                $project->save(); // Save the updated project
            }

            // Update the data in tbl_activityReport
            $activityReport->ar_report = $reportconvert;
            $activityReport->ar_status = $statusconvert;
            $activityReport->ar_refNo = $ref_no;
            $activityReport->ar_project = $projnameID; // Use the ID of tbl_project_list

            ///////////// Activity Details /////////
            if ($ActivityDetailsActivityClone !== $activityReport->ar_activity) {
                $activityReport->ar_activity = $ActivityDetailsActivityClone;
            } elseif ($activity_detailsClone !== $activityReport->ar_activity) {
                $activityReport->ar_activity = $activity_detailsClone;
            }

            $activityReport->ar_requester = $act_details_requesterClone;
            $activityReport->ar_date_filed = $DatefiledClone;

            $activityReport->ar_date_needed = $DateNeededClone;
            $activityReport->ar_instruction = $SpecialInstructionClone;

            ///////////// Contract Details /////////
            $activityReport->ar_resellers = $resellerClone;
            $activityReport->ar_resellers_contact = $reseller_contactClone;
            $activityReport->ar_resellers_phoneEmail = $reseller_phone_emailClone;
            $activityReport->ar_endUser = $enduser_nameClone;
            $activityReport->ar_endUser_contact = $enduser_contactClone;
            $activityReport->ar_endUser_phoneEmail = $enduser_emailClone;
            $activityReport->ar_endUser_loc = $enduser_locationClone;

            ///////////// Activity Summary Report /////////
            $activityReport->ar_activityDate = $Act_dateClone;
            $activityReport->ar_venue = $VenueClone;
            $activityReport->ar_sendCopyTo = $Send_copy_toClone;

            //////////Customer Req, Activity Done, Agreements ///////////////////
            $activityReport->ar_custRequirements = $CustomerRequirements;
            $activityReport->ar_activityDone = $ActivityDone;
            $activityReport->ar_agreements = $Agreements_modal;

            ////////////////////StraCert && T2R //////////////////////////////////
            $activityReport->ar_topic = $Stra_TopicName ?? $T2R_topic;
            $activityReport->ar_dateStart = $Stra_DateStart ?? $T2R_datestart;
            $activityReport->ar_dateEnd = $Stra_DateEnd ?? $T2R_dateEnd;

            ///////////////////POC/////////////////////////////////////////
            $activityReport->ar_POCproductModel = $POC_ProdModel;
            $activityReport->ar_POCassetOrCode = $POC_AssetCode;
            $activityReport->ar_POCdateStart = $POC_DateStart;
            $activityReport->ar_POCdateEnd = $POC_DateEnd;

            ///////////////////Tech Certificate/////////////////////////////////////////
            $activityReport->ar_title = $Tech_Title;
            $activityReport->ar_examName = $Tech_examCode;
            $activityReport->ar_takeStatus = $Tech_status;
            $activityReport->ar_score = $Tech_ScoreDropdown;
            $activityReport->ar_examType = $Tech_examType;
            $activityReport->ar_incStatus = $Tech_incStatus;
            $activityReport->ar_incDetails = $Tect_incDetails;
            $activityReport->ar_incAmount = $Tech_examAmount;

            ////////////////////TechLearned///////////////////////////////////////
            $activityReport->ar_prodLearned = $Tech_ProdLearned;

            /////////////////////Skills Dev/////////////////////////////////////
            $activityReport->ar_trainingName = $Skills_trainingName;
            $activityReport->ar_speakers = $Skills_speaker;
            $activityReport->ar_location = $Skills_location;
            $activityReport->ar_attendeesBPs = $Skill_bpcheckBox;
            $activityReport->ar_attendeesEUs = $Skills_eucheckbox;
            $activityReport->ar_attendeesMSI = $Skill_msicheckbox;

            /////////////////////DigiKnow/////////////////////////////////////
            $activityReport->ar_recipientBPs = $Bp_digiCheckbox;
            $activityReport->ar_recipientEUs = $Eu_digiCheckbox;

            /////////////////////Internal Proj/////////////////////////////////////
            $activityReport->ar_projName = $Internal_Msi;
            $activityReport->ar_compPercent = $Internal_Percent;
            $activityReport->ar_perfectAtt = $Internal_Attendance;

            /////////////////////Memo/////////////////////////////////////
            $activityReport->ar_memoIssued = $Memo_Issued;
            $activityReport->ar_memoDetails = $Memo_Details;

            /////////////////////Engr Feedback/////////////////////////////////////
            $activityReport->ar_feedbackEngr = $Engr_feedback;
            $activityReport->ar_rating = $Engr_rating;


            /////////////////// Time Expected, Reported, Exited //////////////////
            $keyId_reported = tbl_time_list::where('key_time', $Time_reportedClone)->value('key_id');
            $activityReport->ar_timeReported = $keyId_reported;

            $keyId_expected = tbl_time_list::where('key_time', $Time_expectedClone)->value('key_id');
            $activityReport->ar_timeExpected = $keyId_expected;

            $keyId_exited = tbl_time_list::where('key_time', $Time_exitedClone)->value('key_id');
            $activityReport->ar_timeExited = $keyId_exited;

            $activityType_id = tbl_activityType_list::where('type_name', $Activity_typeClone)->value('type_id');
            $activityReport->ar_activityType = $activityType_id;

            $program_id = tbl_program_list::where('program_name', $ProgramClone)->value('program_id');
            $activityReport->ar_program = $program_id;

            $activityReport->save();

            $arId = $activityReport->ar_id;

            // Handle Participants
            tbl_participants::where('ar_id', $activityReport->ar_id)->delete();
            if (is_array($ParticipantandPosition) && !empty($ParticipantandPosition)) {
                foreach ($ParticipantandPosition as $ParticipantandPositions) {
                    $participant = $ParticipantandPositions['participant'];
                    $position = $ParticipantandPositions['position'];

                    $participantModel = new tbl_participants();
                    $participantModel->participant = $participant;
                    $participantModel->position = $position;
                    $participantModel->ar_id = $activityReport->ar_id;
                    $participantModel->save();
                }
            } else {
                Log::error("Error occurred while saving Participants and Position");
            }

            // Handle Action Plan and Recommendation
            tbl_actionPlan::where('ar_id', $activityReport->ar_id)->delete();
            if (is_array($ActionPlanandRecommendation) && !empty($ActionPlanandRecommendation)) {
                foreach ($ActionPlanandRecommendation as $ActionPlanandRecommendations) {
                    $Plantargetdate = $ActionPlanandRecommendations['plantarget'];
                    $Plandetails = $ActionPlanandRecommendations['details'];
                    $Planowner = $ActionPlanandRecommendations['planowner'];

                    $ActionPlanModel = new tbl_actionPlan();
                    $ActionPlanModel->PlanTargetDate = $Plantargetdate;
                    $ActionPlanModel->PlanDetails = $Plandetails;
                    $ActionPlanModel->PlanOwner = $Planowner;
                    $ActionPlanModel->ar_id = $activityReport->ar_id;
                    $ActionPlanModel->save();
                }
            } else {
                Log::error("Error occurred while saving Action Plan and Recommendation");
            }

            // Handle Product Lines
            tbl_productLine::where('ar_id', $activityReport->ar_id)->delete();
            $productLineQuery = new ProductLineQuery();
            if (is_array($Product_lineClone)) {
                foreach ($Product_lineClone as $productName) {
                    $product_line = new tbl_productLine();
                    $product_line->ProductLine = $productName;

                    $productCode = $productLineQuery->getProductCode($productName);
                    $product_line->ProductCode = $productCode ?: "Unknown";
                    $product_line->ar_id = $activityReport->ar_id;
                    $product_line->save();
                }
            } else {
                Log::error("Product line data is not an array.");
            }

            // Handle Product Engineers
            tbl_prodEngineers::where('prodEngr_ar_id', $activityReport->ar_id)->delete();
            $engineerNames = explode(',', $ProductEngineerClone);
            $ldapEngineers1 = LDAPEngineer::fetchFromLDAP();
            if (is_array($engineerNames)) {
                foreach ($engineerNames as $engineerName) {
                    foreach ($ldapEngineers1 as $ldapEngineer) {
                        if ($ldapEngineer->fullName === trim($engineerName) && !empty($ldapEngineer->email)) {
                            $engineer = new tbl_prodEngineers();
                            $engineer->prodEngr_name = $engineerName;
                            $engineer->prodEngr_email = $ldapEngineer->email;
                            $engineer->prodEngr_ar_id = $activityReport->ar_id;
                            $engineer->save();
                        }
                    }
                }
            } else {
                Log::error("Error occurred while processing Product Engineers.");
            }

            // // Handle Engineers
            // tbl_engineers::where('engr_ar_id', $activityReport->ar_id)->delete();
            // $ldapEngineers = LDAPEngineer::fetchFromLDAP();
            // if (is_array($engineer_nameClone)) {
            //     foreach ($engineer_nameClone as $engineerNameModal) {
            //         foreach ($ldapEngineers as $ldapEngineer) {
            //             if ($ldapEngineer->fullName === trim($engineerNameModal)) {
            //                 $engineer = new tbl_engineers();
            //                 $engineer->engr_name = $ldapEngineer->fullName;
            //                 $engineer->engr_email = $ldapEngineer->email;
            //                 $engineer->engr_ar_id = $activityReport->ar_id;
            //                 $engineer->save();
            //             }
            //         }
            //     }
            // } else {
            //     Log::error("Error occurred while processing Engineers.");
            // }

            // Handle Engineers
            tbl_engineers::where('engr_ar_id', $activityReport->ar_id)->delete();
            $ldapEngineers = LDAPEngineer::fetchFromLDAP();

            // Check if engineer_nameClone is empty and set it to the current user's name if it is
            if (empty($engineer_nameClone)) {
                $engineer_nameClone = [Auth::user()->name];
            }

            if (is_array($engineer_nameClone)) {
                foreach ($engineer_nameClone as $engineerNameModal) {
                    $foundInLDAP = false;
                    foreach ($ldapEngineers as $ldapEngineer) {
                        if ($ldapEngineer->fullName === trim($engineerNameModal)) {
                            $engineer = new tbl_engineers();
                            $engineer->engr_name = $ldapEngineer->fullName;
                            $engineer->engr_email = $ldapEngineer->email;
                            $engineer->engr_ar_id = $activityReport->ar_id;
                            $engineer->save();
                            $foundInLDAP = true;
                            break;
                        }
                    }

                    // If not found in LDAP, use the authenticated user
                    if (!$foundInLDAP) {
                        $engineer = new tbl_engineers();
                        $engineer->engr_name = Auth::user()->name;
                        $engineer->engr_email = Auth::user()->email ?? null; // Use null if email is not available
                        $engineer->engr_ar_id = $activityReport->ar_id;
                        $engineer->save();
                    }
                }
            } else {
                Log::error("Error occurred while processing Engineers.");
            }



            // Handle Copy To Engineers
            tbl_copyTo::where('copy_ar_id', $activityReport->ar_id)->delete();
            $CopyToEngineer = explode(',', $copyToClone);
            $ldapEngineers3 = LDAPEngineer::fetchFromLDAP();
            if (is_array($CopyToEngineer)) {
                foreach ($CopyToEngineer as $CopyToEngineers) {
                    foreach ($ldapEngineers3 as $ldapEngineer) {
                        if ($ldapEngineer->fullName === trim($CopyToEngineers)) {
                            $copytoengineer = new tbl_copyTo();
                            $copytoengineer->copy_name = $ldapEngineer->fullName;
                            $copytoengineer->copy_email = $ldapEngineer->email;
                            $copytoengineer->copy_ar_id = $activityReport->ar_id;
                            $copytoengineer->save();
                        }
                    }
                }
            } else {
                Log::error("Error occurred while processing Copy To Engineers.");
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error occurred while updating activity report: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating data'], 500);
        }

        // Return success message
        return response()->json(['message' => 'Data updated successfully', 'ar_id' => $arId], 200);
    }

    public function editImage(Request $request)
    {

        $ar_id = $request->input('ar_id'); // Get the ar_id from the request

        // If no ar_id provided, create a new one
        if (!$ar_id) {
            $ar_id = uniqid();  // Or however you generate your unique ar_id
        }

        $destinationPath = public_path('uploads');

        // Retrieve multiple files
        $file = $request->file('file_data');

        if ($file) {
            // Iterate through each uploaded file
            foreach ($file as $file_upload) {
                // Generate unique filename for each file
                $fileup_filename = uniqid() . '_' . $file_upload->getClientOriginalName();

                // Move the uploaded file to the destination path
                $file_upload->move($destinationPath, $fileup_filename);

                // Create a new record for each file
                $fileupload_Model = new tbl_attachments();
                $fileupload_Model->att_ar_id = $ar_id;
                $fileupload_Model->att_name = $fileup_filename;
                $fileupload_Model->save();
            }
        }

        // Handle updating existing records (if needed)
        // For simplicity, I'll skip this part assuming your logic for updating existing records is correct.

        // Return success message
        return response()->json(['message' => 'Files updated successfully'], 200);
    }

    public function editDigiknowImage(Request $request)
    {
        // Retrieve ar_id from the request or generate a new one
        $ar_id = $request->input('ar_id');

        // If no ar_id provided, create a new one
        if (!$ar_id) {
            $ar_id = uniqid();  // Or however you generate your unique ar_id
        }

        // Specify the destination path
        $destinationPath = public_path('uploads');

        // Retrieve multiple files
        $digiknow_files = $request->file('file_data');

        if ($digiknow_files) {
            // Iterate through each uploaded file
            foreach ($digiknow_files as $digiknow_file) {
                // Generate unique filename for each file
                $digiKnow_filename = uniqid() . '_' . $digiknow_file->getClientOriginalName();

                // Move the uploaded file to the destination path
                $digiknow_file->move($destinationPath, $digiKnow_filename);

                // Create a new record for each file
                $digiKnow_imageModel = new tbl_digiKnow_flyer();
                $digiKnow_imageModel->ar_id = $ar_id;
                $digiKnow_imageModel->attachment = $digiKnow_filename;
                $digiKnow_imageModel->save();
            }
        }

        // Return success message with ar_id
        return response()->json(['message' => 'Files saved successfully', 'ar_id' => $ar_id], 200);
    }


    public function deleteImage(Request $request)
    {
        $ar_id = $request->input('ar_id');
        $files = $request->input('files');
        $digiknow_files = $request->input('digiknow_files'); // Expecting an array of files

        Log::info("Delete request received", ['ar_id' => $ar_id, 'files' => $files, 'digiknow_files' => $digiknow_files]);

        if ($ar_id) {
            if (is_array($files)) {
                foreach ($files as $file) {
                    $filePath = public_path('uploads/' . $file);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    // Delete the records from the database
                    tbl_attachments::where('att_ar_id', $ar_id)
                        ->where('att_name', $file)
                        ->delete();
                }
            }

            if (is_array($digiknow_files)) {
                foreach ($digiknow_files as $file) {
                    $filePath = public_path('uploads/' . $file);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    // Delete the records from the database
                    tbl_digiKnow_flyer::where('ar_id', $ar_id)
                        ->where('attachment', $file)
                        ->delete();
                }
            }

            return response()->json(['message' => 'Files and records deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'ar_id is required'], 400);
        }
    }


    // public function deleteImage(Request $request)
    // {
    //     $ar_id = $request->input('ar_id');
    //     $file = $request->input('file');
    //     $digiknow_file = $request->input('digiknow_file');

    //     Log::info("Delete request received", ['ar_id' => $ar_id, 'file' => $file, 'digiknow_file' => $digiknow_file]);

    //     if ($ar_id) {
    //         // Delete the files from the file system
    //         if ($file) {
    //             $filePath = public_path('uploads/' . $file);
    //             if (file_exists($filePath)) {
    //                 unlink($filePath);
    //             }
    //         }

    //         if ($digiknow_file) {
    //             $digiknowFilePath = public_path('uploads/' . $digiknow_file);
    //             if (file_exists($digiknowFilePath)) {
    //                 unlink($digiknowFilePath);
    //             }
    //         }

    //         // Delete the records from the database
    //         // Adjust these conditions based on your actual table and column names
    //         if ($file) {
    //             tbl_attachments::where('att_ar_id', $ar_id)
    //                 ->where('att_name', $file)
    //                 ->delete();
    //         }

    //         if ($digiknow_file) {
    //             tbl_digiKnow_flyer::where('ar_id', $ar_id)
    //                 ->where('attachment', $digiknow_file)
    //                 ->delete();
    //         }

    //         return response()->json(['message' => 'Files and records deleted successfully'], 200);
    //     } else {
    //         return response()->json(['message' => 'ar_id is required'], 400);
    //     }

    //   } 
    public function CompletionAcceptance(Request $request)
    {
        $refNo = $request->reportnumber;

        $getCompletionAcceptance = tbl_activityReport::getCompletionAcceptance($refNo);

        return response()->json($getCompletionAcceptance);
    }

    public function GetEngr(Request $request)
    {
        $refNo = $request->refNo;

        $getEngr = tbl_activityReport::leftJoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
            ->select('engr_name')
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->get();

        $engineerNames = $getEngr->pluck('engr_name')->toArray();


        $engineerString = implode(',', $engineerNames);

        return response()->json($engineerString);
    }
}
