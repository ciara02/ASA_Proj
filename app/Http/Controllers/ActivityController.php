<?php

namespace App\Http\Controllers;

use App\Models\Activity_Competion_Acceptance;
use App\Models\tbl_actionPlan;
use App\Models\tbl_digiKnow_flyer;
use Illuminate\Http\Request;
use App\Models\tbl_engineers;
use App\Models\tbl_project_type_list;
use App\Models\tbl_time_list;
use App\Models\tbl_prodEngineers;
use App\Models\tbl_activityReport;
use App\Models\tbl_attachments;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\tbl_activityType_list;
use App\Models\tbl_copyTo;
use App\Models\tbl_participants;
use App\Models\tbl_productLine;
use App\Models\tbl_program_list;
use App\Models\tbl_project_list;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\crud_model;
use App\Models\LDAPEngineer;
use App\Models\tbl_projectMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user's email
        $engrName = Auth::user()->name;
        $ldapUsername = Auth::user()->email;
    
        // Transform the email to match LDAP format (adjust this transformation based on your requirement)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email to ensure it's correct
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data for the currently logged-in user
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);
    
        // Fetch the first 100 activity reports for the authenticated engineer
        $results = crud_model::ActivityReportFirst100($engrName);
    
        // Pass the data to the view
        return view('tab-activity.index', compact('engrName', 'ldapEngineer', 'results'));
    }

    

    public function generateASAnumber()
    {
        // Get current date
        $currentDate = now();
        $formattedDate = $currentDate->format('Ymd');

        // Generate random 5-digit number
        $randomNumber = str_pad(mt_rand(1, 99999), 6, '0', STR_PAD_LEFT);

        // Combine date and random number to create the ASA number
        $asaNumber = $formattedDate . '-' . $randomNumber;
        return $asaNumber;
    }

    public function createActivity()
    {
        $asaNumber = $this->generateASAnumber();
        $ldapUsername = Auth::user()->email;
    
        // Transform the email to match LDAP format (adjust this transformation based on your requirement)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email to ensure it's correct
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data for the currently logged-in user
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);
        return view('tab-activity.create', compact('asaNumber', 'ldapEngineer'));
    }

    public function backtohomepage()
    {
        return view('tab-activity.index');
    }

    public function search(Request $request)
    {
        $dateFrom = $request->input('StartDate');
        $dateTo = $request->input('EndDate');
        $engineers = $request->input('engineers');

        // Handle empty dates
        if ((empty($dateFrom) || empty($dateTo)) && empty($engineers)) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Please provide both start and end dates.', 'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'engineers' => $engineers]);
            }
            return back()->withErrors(['message' => 'Please provide both start and end dates.']);
        }

        // Calculate the difference between the dates in days
        $dateDifference = Carbon::parse($dateFrom)->diffInDays(Carbon::parse($dateTo));

        // Check date range
        if ($dateDifference > 32) {
            if ($request->ajax()) {
                return response()->json(['status' => 'info', 'message' => 'Date range must be limited to exactly one year', 'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'engineers' => $engineers]);
            }
            return back()->withErrors(['message' => 'Date range must be limited to exactly one year']);
        }

        // If it's not an Ajax request, return the view with the data
        $act_report = tbl_activityReport::with('act_reportEngr', 'timeFrom', 'timeTo', 'category', 'activitytype', 'prod_line', 'statustype')
            ->select(
                'ar_id',
                'ar_activityType',
                'ar_report',
                'ar_activityDate',
                'ar_refNo',
                'ar_resellers',
                'ar_activity',
                'ar_endUser',
                'ar_venue',
                'ar_status',
            );

        if (!empty($engineers)) {
            $act_report = $act_report
                ->whereHas('act_reportEngr', function ($query) use ($engineers) {
                    $query->whereIn('engr_name', $engineers);
                });
        }

        if (!empty($dateFrom) && !empty($dateTo)) {
            $act_report = $act_report->whereBetween('ar_activityDate', [$dateFrom, $dateTo]);
        }

        $act_report = $act_report->get();

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'data' => $act_report, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'engineers' => $engineers]);
        } else {
            return view('tab-activity.index', compact('act_report'));
        }
    }


    public function getProjectName(Request $request)
    {
        $projectType = $request->input('projecttypenumber');
    
        // Fetch project data based on the project type and join tables
        $projectData = tbl_project_type_list::select('tbl_project_list.id', 'tbl_project_list.proj_name')
            ->join('tbl_project_list', 'tbl_project_type_list.id', '=', 'tbl_project_list.proj_type_id')
            ->where('tbl_project_type_list.id', $projectType)
            ->where(function ($query) {
                $query->whereIn('tbl_project_list.status', ['On Going', 'Completed']) 
                      ->orWhereNull('tbl_project_list.status') 
                      ->orWhere('tbl_project_list.status', '');
            })
            ->whereNotNull('tbl_project_list.proj_name')
            ->orderBy('tbl_project_list.proj_name', 'ASC')   
            ->orderBy('tbl_project_list.status', 'ASC')      
            ->get();
    
        // Check if the projectData is not empty
        if ($projectData->isNotEmpty()) {
            // Return the project data with the id and proj_name
            return response()->json($projectData);
        } else {
            return response()->json(['error' => 'Project not found'], 404);
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

    public function getTime(Request $request)
    {
        $term = $request->input('term');

        $timeData = tbl_time_list::where('key_time', 'like', "%$term%")
            ->orderBy('key_id')
            ->get(['key_id', 'key_time']); // Select both key_id and key_time

        // Map the data to the format expected by Select2
        $formattedData = $timeData->map(function ($time) {
            return [
                'id' => $time->key_id,
                'text' => $time->key_time
            ];
        });

        return response()->json(['data' => $formattedData]);
    }

    ////////////////////// For updates /////////////////////////////
    public function getTime_update(Request $request)
    {
        $term = $request->input('term');

        $get_time = tbl_time_list::where('key_time', 'like', "%$term%")
            ->orderBy('key_id')
            ->pluck('key_time');

        return response()->json(['data' => $get_time]);
    }

    public function print(Request $request)
    {
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');
        $engineers = $request->input('engineers');

        // Split the $engineers string into an array of individual names
        $engineersArray = explode(',', $engineers);

        $act_report = tbl_activityReport::with('act_reportEngr', 'timeFrom', 'timeTo', 'category', 'activitytype', 'prod_line', 'statustype')
            ->select(
                'ar_id',
                'ar_activityType',
                'ar_report',
                'ar_activityDate',
                'ar_refNo',
                'ar_resellers',
                'ar_activity',
                'ar_endUser',
                'ar_venue',
            );

        // Filter by engineers if provided
        if (!empty($engineersArray) && $engineersArray[0] !== "null") {
            $act_report = $act_report->whereHas('act_reportEngr', function ($query) use ($engineersArray) {
                $query->whereIn('engr_name', $engineersArray);
            });
        }

        // Filter by date range if provided
        if ($dateFrom !== "null" && $dateTo !== "null") {
            $dateFrom = Carbon::parse($dateFrom)->startOfDay();
            $dateTo = Carbon::parse($dateTo)->endOfDay();
            $act_report = $act_report->whereBetween('ar_activityDate', [$dateFrom, $dateTo]);
        }

        // Retrieve the filtered results
        $act_report = $act_report->get();

        return view('tab-activity.print', compact('act_report'));
    }

    //------------------------------ ACTIVITY COMPLETION ACCEPTANCE -------------------------------------

    public function ActCompletionAcceptanceIndex()
    {
        $ldapUsername = Auth::user()->email;
    
        // Transform the email to match LDAP format (adjust this transformation based on your requirement)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email to ensure it's correct
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data for the currently logged-in user
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);
    
        // Fetch the report data
        $results = Activity_Competion_Acceptance::getLimitedCompletionAcceptanceReport();
        
        // Pass the results and ldapEngineer to the view
        return view('tab-activity.act-completion-accept', ['results' => $results, 'ldapEngineer' => $ldapEngineer]);
    }    

    public function getSearch(Request $request)
    {
        $reports = $this->fetchReports($request);
        return view('tab-activity.act-completion-accept', compact('reports'));
    }

    // This holds a common/reusable query for this page. (used in index and report page)
    public function fetchReports(Request $request)
    {
        $dateFrom = $request->input('StartDate');
        $dateTo = $request->input('EndDate');
        $engineers = (array) $request->input('engineers'); // Ensure engineers is always an array

        $reports = tbl_activityReport::with(
            'ActCompletionEngr',
            'ActCompletioncategory',
            'ActCompletionActivityType',
            'ActCompletionproductLines',
            'ActCompletionStatus',
            'ActCompletionProjectList',
            'ActCompletionStatus.Approval'
        )
            ->select(
                'ar_id',
                'ar_project',
                'ar_activityType',
                'ar_report',
                'ar_activityDate',
                'ar_activityDone',
                'ar_refNo',
                'ar_resellers',
                'ar_activity',
                'ar_endUser',
            );

        if (!empty($engineers)) {
            $reports = $reports
                ->whereHas('ActCompletionEngr', function ($query)  use ($engineers) {
                    $query->whereIn('engr_name', $engineers);
                })
                ->whereHas('ActCompletionStatus');
        }

        if (!empty($dateFrom) && !empty($dateTo)) {
            $reports = $reports->whereBetween('ar_activityDate', [$dateFrom, $dateTo]);
        }

        $reports = $reports->whereHas('ActCompletionStatus', function ($query) {
            $query->whereNotNull('aa_activity_report');
        });

        $reports = $reports->get();

        foreach ($reports as $report) {
            $report->ActCompletionStatus->aa_status = $this->convertStatusToString($report->ActCompletionStatus->aa_status);
        }

        // Return variable instead of page view
        return $reports;
    }

    private function convertStatusToString($statusCode)
    {

        switch ($statusCode) {
            case 1:
                return 'Draft';
            case 2:
                return 'For Approval';
            case 3:
                return 'Approved';
            case 4:
                return 'Disapproved';
            default:
                return 'Unknown Status';
        }
    }

    public function getRefNumber(Request $request)
    {
        $refNumber = $request->refNumber;

        $GetApprovers = tbl_activityReport::leftjoin('tbl_activityAcceptance', 'tbl_activityReport.ar_id', '=', 'tbl_activityAcceptance.aa_activity_report')
            ->leftjoin('tbl_activityAcceptanceApproval', 'tbl_activityAcceptance.aa_id', '=', 'tbl_activityAcceptanceApproval.aaa_activityAcceptance')
            ->select('ar_id', 'aaa_company', 'aaa_name', 'aaa_position', 'aaa_email', 'aaa_status', 'aa_status')
            ->where('tbl_activityReport.ar_refNo',  '=', $refNumber)
            ->get();

        return response()->json($GetApprovers);
    }

    public function actCmpltAcptPrint(Request $request)
    {
        $reports = $this->fetchReports($request);
        return view('tab-activity.act-completion-accept-print', compact('reports'));
    }

    //////////// Activity Report Modal /////////////////////////
    public function getProjName(Request $request)
    {
        $refNo = $request->refNo;

        $getProject = tbl_activityReport::leftJoin('tbl_project_list', 'tbl_activityReport.ar_project', '=', 'tbl_project_list.id')
            ->leftJoin('tbl_project_type_list', 'tbl_project_list.proj_type_id', '=', 'tbl_project_type_list.id')
            ->select('tbl_project_list.id','proj_name', 'name')

            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->first();

        return response()->json([ 'projectId' => $getProject->id ?? '','projectName' => $getProject->proj_name ?? '', 'projectTypeName' => $getProject->name ?? '']);
    }

    //////////// Get Product Engineer Only /////////////////////////

    public function GetProductEngr(Request $request)
    {
        $refNo = $request->refNo;

        $getProdEngr = tbl_activityReport::leftJoin('tbl_prodEngineers', 'tbl_activityReport.ar_id', '=', 'tbl_prodEngineers.prodEngr_ar_id ')
            ->select('prodEngr_name')
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->get();

        $engineerNames = $getProdEngr->pluck('prodEngr_name')->toArray();


        $engineerString = implode(',', $engineerNames);

        return response()->json($engineerString);
    }

    ///////////////////// Get Program /////////////////////
    public function GetProgramActReport(Request $request)
    {
        $refNo = $request->refNo;

        $getProgram = tbl_activityReport::leftjoin('tbl_program_list', 'tbl_activityReport.ar_program', '=', 'tbl_program_list.program_id')
            ->select('program_name')
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->get();

        $getProgram = $getProgram->pluck('program_name')->toArray();

        $getProgram = implode(',', $getProgram);

        return response()->json($getProgram);
    }


    //////////// Get Copy To Engineer Only /////////////////////////

    public function CopyToEngineer(Request $request)
    {
        $refNo = $request->refNo;

        $getCopyToEngr = tbl_activityReport::leftJoin('tbl_copyTo', 'tbl_activityReport.ar_id', '=', 'tbl_copyTo.copy_ar_id ')
            ->select('copy_name')
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->get();

        $getCopyToEngineer = $getCopyToEngr->pluck('copy_name')->toArray();
        $copyengineerString = implode(',', $getCopyToEngineer);

        return response()->json($copyengineerString);
    }
    //////////// Get ProductLine /////////////////////////

    public function GetProductline(Request $request)
{
    $refNo = $request->refNo;

    $getProductData = tbl_activityReport::leftjoin('tbl_productLine', 'tbl_activityReport.ar_id', '=', 'tbl_productLine.ar_id')
        ->where('tbl_activityReport.ar_refNo', '=', $refNo)
        ->get(['ProductLine', 'ProductCode']);

    // Convert the result to arrays
    $productlines = $getProductData->pluck('ProductLine')->toArray();
    $productcodes = $getProductData->pluck('ProductCode')->toArray();

    // Convert arrays to comma-separated strings
    $productlineString = implode(',', $productlines);
    $productcodeString = implode(',', $productcodes);

    // Return both productline and productcode as a JSON response
    return response()->json([
        'productlines' => $productlineString,
        'productcodes' => $productcodeString,
    ]);
}

    


    //////////// Activity Report Contract Details Modal /////////////////////////
    public function getContractDetails(Request $request)
    {
        $refNo = $request->refNo;
        $getContractDetails = tbl_activityReport::select(
            'ar_requester',
            'ar_resellers_contact',
            'ar_resellers_phoneEmail',
            'ar_endUser',
            'ar_endUser_contact',
            'ar_endUser_loc',
            'ar_endUser_phoneEmail',
            'ar_targetDate',
            'ar_details',
            'ar_owner',
            'ar_date_needed',
            'ar_sendCopyTo',
            'ar_instruction',
            'ar_date_filed',
            'ar_custRequirements',
            'ar_activityDone',
            'ar_agreements',
            'ar_id',
        )
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->first();

        return response()->json([
            'requester' => $getContractDetails->ar_requester ?? '',
            'reseller_contact' => $getContractDetails->ar_resellers_contact ?? '',
            'reseller_phoneEmail' => $getContractDetails->ar_resellers_phoneEmail ?? '',
            'endUser_name' => $getContractDetails->ar_endUser ?? '',
            'endUser_contact' => $getContractDetails->ar_endUser_contact ?? '',
            'endUser_loc' => $getContractDetails->ar_endUser_loc ?? '',
            'endUser_phoneEmail' => $getContractDetails->ar_endUser_phoneEmail ?? '',
            'target_date' => $getContractDetails->ar_targetDate ?? '',
            'details' => $getContractDetails->ar_details ?? '',
            'owner' => $getContractDetails->ar_owner ?? '',
            'date_needed' => $getContractDetails->ar_date_needed ?? '',
            'send_copy' => $getContractDetails->ar_sendCopyTo ?? '',
            'special_instruction' => $getContractDetails->ar_instruction ?? '',
            'date_filed' => $getContractDetails->ar_date_filed ?? '',
            'cust_requirements' => $getContractDetails->ar_custRequirements ?? '',
            'activity_done' => $getContractDetails->ar_activityDone ?? '',
            'agreements' => $getContractDetails->ar_agreements ?? '',
            'ar_id' => $getContractDetails->ar_id ?? ''
        ]);
    }

    //////////// Action Plan / Recommendation Modal /////////////////////////
    public function ActionPlanRecommendation(Request $request)
    {
        $refNo = $request->refNo;
        $ActionPlanRecommendation = tbl_activityReport::leftjoin('tbl_actionPlan', 'tbl_activityReport.ar_id', '=', 'tbl_actionPlan.ar_id')
            ->select('PlanTargetDate', 'PlanDetails', 'PlanOwner')
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->get();

        return response()->json($ActionPlanRecommendation);
    }

    //////////// Activity Report  Participant/Position Modal /////////////////////////
    public function getSummaryReport(Request $request)
    {
        $refNo = $request->refNo;
        $getSummaryReport = tbl_activityReport::leftjoin('tbl_participants', 'tbl_activityReport.ar_id', '=', 'tbl_participants.ar_id')
            ->select('participant', 'position')
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->get();

        return response()->json($getSummaryReport);
        // return response()->json(['time_expected' => $getSummaryReport->key_time ?? '', 'Participant' => $getSummaryReport->participant ?? '' , 'Position' => $getSummaryReport->position ?? '' ]);
    }

    //////////// Activity Report Get Get Time Expected ////////////////////////////////
    public function getSummaryReport_time(Request $request)
    {
        $refNo = $request->refNo;
        $getSummaryReport = tbl_activityReport::leftjoin('tbl_time_list', 'tbl_activityReport.ar_timeExpected', '=', 'tbl_time_list.key_id')
            ->select('key_time')
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->first();

        return response()->json(['time_expected' => $getSummaryReport->key_time ?? '']);
    }

    public function getFile(Request $request)
    {
        $refNo = $request->refNo;

        // Fetch all attachments associated with the given $refNo
        $getfiles = tbl_activityReport::leftJoin('tbl_attachments', 'tbl_activityReport.ar_id', '=', 'tbl_attachments.att_ar_id')
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->select('att_name')
            ->get();

        $files = [];
        foreach ($getfiles as $file) {
            $files[] = $file->att_name; // Assuming 'att_name' is the column containing the file name or path
        }

        return response()->json(['retrieve_files' => $files]);
    }

    public function getDigiknowFile(Request $request)
    {
        $refNo = $request->refNo;

        // Fetch all attachments associated with the given $refNo
        $getdigiknowfiles = tbl_activityReport::leftJoin('tbl_digiKnow_flyer', 'tbl_activityReport.ar_id', '=', 'tbl_digiKnow_flyer.ar_id')
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->select('attachment')
            ->get();

        $digiknowfiles = [];
        foreach ($getdigiknowfiles as $file) {
            $digiknowfiles[] = $file->attachment; // Assuming 'attachment' is the column containing the file name or path
        }

        return response()->json(['retrieve_digiknowfiles' => $digiknowfiles]);
    }


    public function getOthers(Request $request)
    {
        $refNo = $request->refNo;
        $getOtherInputFields = tbl_activityReport::leftjoin('tbl_digiKnow_flyer', 'tbl_activityReport.ar_id', '=', 'tbl_digiKnow_flyer.ar_id')
            ->select(
                'ar_projName',
                'ar_compPercent',
                'ar_perfectAtt',
                'ar_memoIssued',
                'ar_memoDetails',
                'ar_feedbackEngr',
                'ar_rating',
                'ar_topic',
                'ar_dateStart',
                'ar_dateEnd',
                'ar_POCproductModel',
                'ar_POCassetOrCode',
                'ar_POCdateStart',
                'ar_POCdateEnd',
                'attachment',
                'ar_recipientBPs',
                'ar_recipientEUs',

            )
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->first();

        return response()->json([
            'msi_proj' => $getOtherInputFields->ar_projName ?? '',
            'percentage' => $getOtherInputFields->ar_compPercent ?? '',
            'perfect_att' => $getOtherInputFields->ar_perfectAtt ?? '',
            'memo_issued' => $getOtherInputFields->ar_memoIssued ?? '',
            'memo_details' => $getOtherInputFields->ar_memoDetails ?? '',
            'engr_feedback' => $getOtherInputFields->ar_feedbackEngr ?? '',
            'engr_rating' => $getOtherInputFields->ar_rating ?? '',
            'topic' => $getOtherInputFields->ar_topic ?? '',
            'dateStart' => $getOtherInputFields->ar_dateStart ?? '',
            'dateEnd' => $getOtherInputFields->ar_dateEnd ?? '',
            //POC
            'product_model' => $getOtherInputFields->ar_POCproductModel ?? '',
            'asset_code' => $getOtherInputFields->ar_POCassetOrCode ?? '',
            'poc_dateStart' => $getOtherInputFields->ar_POCdateStart ?? '',
            'poc_dateEnd' => $getOtherInputFields->ar_POCdateEnd ?? '',
            // Digiknow
            'digiknow_flyers' => $getOtherInputFields->attachment ?? '',
            'receipentBP' => $getOtherInputFields->ar_recipientBPs ?? '',
            'recipientEU' => $getOtherInputFields->ar_recipientEUs ?? '',
        ]);
    }

    public function get_skills_dev(Request $request)
    {
        $refNo = $request->refNo;
        $getOtherInputFields = tbl_activityReport::select(
            'ar_prodLearned',
            'ar_trainingName',
            'ar_location',
            'ar_speakers',
            'ar_attendeesBPs',
            'ar_attendeesEUs',
            'ar_attendeesMSI',
            'ar_title',
            'ar_examName',
            'ar_takeStatus',
            'ar_score',
            'ar_examType',
            'ar_incStatus',
            'ar_incDetails',
            'ar_incAmount',

        )
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->first();

        return response()->json([
            'prod_learned' => $getOtherInputFields->ar_prodLearned ?? '',
            'training_name' => $getOtherInputFields->ar_trainingName ?? '',
            'training_location' => $getOtherInputFields->ar_location ?? '',
            'training_speaker' => $getOtherInputFields->ar_speakers ?? '',
            'bp_attendees' => $getOtherInputFields->ar_attendeesBPs ?? '',
            'eu_attendees' => $getOtherInputFields->ar_attendeesEUs ?? '',
            'msi_attendees' => $getOtherInputFields->ar_attendeesMSI ?? '',
            'exam_title' => $getOtherInputFields->ar_title ?? '',
            'exam_name' => $getOtherInputFields->ar_examName ?? '',
            'take_status' => $getOtherInputFields->ar_takeStatus ?? '',
            'exam_score' => $getOtherInputFields->ar_score ?? '',
            'exam_type' => $getOtherInputFields->ar_examType ?? '',
            'exam_incStatus' => $getOtherInputFields->ar_incStatus ?? '',
            'exam_incdetails' => $getOtherInputFields->ar_incDetails ?? '',
            'exam_incAmount' => $getOtherInputFields->ar_incAmount ?? '',
        ]);
    }



    //////////// Activity Report Activity Type Dynamic Dropdown /////////////////////////

    public function getActivityTypes($category)
    {
        // Define type_report_id based on category
        $typeReportId = 0;
        switch ($category) {
            case 'iSupport Services':
            case 2:
                $typeReportId = 2;
                break;
            case 'Client Calls':
            case 3:
                $typeReportId = 3;
                break;
            case 'Internal Enablement':
            case 4:
                $typeReportId = 4;
                break;
            case 'Partner Enablement_Recruitment':
            case 5:
                $typeReportId = 5;
                break;
            case 'Supporting Activity':
            case 6:
                $typeReportId = 6;
                break;
            case 'Skills Development':
            case 7:
                $typeReportId = 7;
                break;
            case 'Others':
            case 8:
                $typeReportId = 8;
                break;
        }

        // Perform a query to fetch the activity types based on the category
        $activityTypes = tbl_activityType_list::where('type_report_id', $typeReportId)->pluck('type_name');

        return response()->json($activityTypes);
    }

    //Quick Add Activity Query
    public function getQuickActivityTypes($category)
    {
        // Perform a query to fetch the activity types based on the category
        $activityTypes = tbl_activityType_list::where('type_report_id', $category)->get(['type_id', 'type_name']);

        return response()->json($activityTypes);
    }

    //////////// Activity Report Program Dynamic Dropdown   /////////////////////////

    public function getProgram($category)
    {


        switch ($category) {
            case 'Support Request':
            case 1:
            case 'iSupport Services':
            case 2:
            case 'Client Calls':
            case 3:
            case 'Supporting Activity':
            case 6:
            case 'Skills Development':
            case 7:
                $programIds = [2, 4];
                break;
            case 'Internal Enablement':
            case 4:
                $programIds = [2, 3, 4];
                break;
            case 'Partner Enablement_Recruitment':
            case 5:
                $programIds = [1, 2, 4];
                break;
            case 'Others':
            case 8:
                $programIds = [4];
                break;
            default:
                $programIds = [];
                break;
        }
        // Perform a query to fetch the activity types based on the category
        $programs = tbl_program_list::whereIn('program_id', $programIds)->pluck('program_name');
        return response()->json($programs);
    }

    public function getProductCode(Request $request)
    {
        $productLine = $request->input('product_line');
        $productCode = tbl_productLine::where('ProductLine', $productLine)->value('ProductCode');
        return response()->json($productCode);
    }

    public function searchActivityReport(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $engineerName = $request->input('engineerName');

        $activityReportModel = new tbl_activityReport();
        $results = $activityReportModel->searchActivityReport($startDate, $endDate, $engineerName);

        return response()->json($results);
    }

    public function searchActCompletionAcceptanceReport(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $engineerName = $request->input('engineerName');

        $results = Activity_Competion_Acceptance::searchCompletionAcceptanceReport($startDate, $endDate, $engineerName);

        return response()->json($results);
    }

    public function storeModal(Request $request)
    {
        try {
            $validatedData = $request->validate([
                //Header
                'report_Dropdown_Input' => 'required',
                'projectType_Dropdown_Input' => 'nullable',
                'status_Dropdown_Input' => 'required',

                //Quick Add Activity
                'quick_ref_input' => 'nullable',

                // //activity Details
                'quick_activityForm_input' => 'nullable',
                'quick_requester_Input' => 'nullable',
                'quick_productEng_input' => 'nullable',
                'quick_dateFiled_input' => 'nullable',
                'quick_activity_input' => 'nullable',
                'quick_send_copy_toInput' => 'nullable',
                'quick_date_needed_Input' => 'nullable',
                'quick_special_instruct_Input' => 'nullable',

                //Contract Details
                'quick_reseller_input' => 'nullable',
                'quick_resellers_contact_Input' => 'nullable',
                'quick_resellers_email_Input' => 'nullable',
                'quick_enduser_Input' => 'nullable',
                'quick_enduser_contact_Input' => 'nullable',
                'quick_enduser_email_Input' => 'nullable',
                'quick_enduser_loc_Input' => 'nullable',

                //Activity Summary
                'quick_act_date_Input' => 'nullable',
                'quick_act_type_Input' => 'nullable',
                'quick_program_Input' => 'nullable',
                'quick_productLines' => 'nullable',
                'quick_time_expected' => 'nullable',
                'quick_time_reported_Input' => 'nullable',
                'quick_time_exited_Input' => 'nullable',
                'quick_engineer_Input' => 'nullable',
                'quick_venue_Input' => 'nullable',
                'quick_send_copy_To' => 'nullable',

                //Participants Position
                'quick_participant_Input' => 'nullable',
                'quick_position_Input' => 'nullable',

                //TextField
                'quick_cust_requirements_Input' => 'nullable',
                'quick_activity_done_Input' => 'nullable',
                'quick_agreements_Input' => 'nullable',

                //Action Plan
                'quick_starting_date' => 'nullable',
                'quick_details_input' => 'nullable',
                'quick_owner_input' => 'nullable',

                //Attachment
                'quick_attachment' => 'nullable|mimes:jpeg,png,jpg,gif,pdf,xlsx,xls,pptx,txt,html,htm,ppt,pptx,doc,docx|max:10000',




            ]);

            $tbl_quickCreate = new tbl_activityReport();

            $quickproductLinesArray = $request->input('quick_productLines');
            $quick_productCodes = $request->input('quick_productCodes');
            $quickproductCodesArray = explode(',', $quick_productCodes[0]);
            $quick_add_engr_name = $request->input('quick_engineer_Input');
            $quick_add_prod_engr_name = $request->input('quick_productEng_input');
            $quick_copy_to = $request->input('quick_copytoInput');
            $quick_participant_Input = $request->input('quick_participant_Input');
            $quick_position_Input = $request->input('quick_position_Input');
            $quick_starting_date = $request->input('quick_starting_date');
            $quick_details_input = $request->input('quick_details_input');
            $quick_owner_input = $request->input('quick_owner_input');
            $quick_program_dropdown = $request->input('quick_program_Input');
            $quick_activityType =  $request->input('quick_act_type_Input');

            switch ($quick_program_dropdown) {
                case 'sTraCert':
                    $quick_program_dropdown = 1;
                    break;
                case 'VSTECS Experience Center':
                    $quick_program_dropdown = 2;
                    break;
                case 'PKOC / MSLC':
                    $quick_program_dropdown = 3;
                    break;
                case 'None':
                    $quick_program_dropdown = 4;
                    break;
                default:
                    $quick_program_dropdown = null;
                    break;
            }


            //header
            $tbl_quickCreate->ar_report = $validatedData['report_Dropdown_Input']  ?? null;
            $tbl_quickCreate->ar_status = $validatedData['status_Dropdown_Input']  ?? null;

            //Quick Add Activity

            $tbl_quickCreate->ar_refNo = $validatedData['quick_ref_input'] ?? null;
            $tbl_quickCreate->ar_activity = $validatedData['quick_activityForm_input'] ?? null;
            $tbl_quickCreate->ar_requester = $validatedData['quick_requester_Input'] ?? null;
            $tbl_quickCreate->ar_date_filed = $validatedData['quick_dateFiled_input']  ?? null;
            $tbl_quickCreate->ar_activity = $validatedData['quick_activity_input']  ?? null;
            $tbl_quickCreate->ar_activity = $validatedData['quick_activity_input']  ?? null;
            $tbl_quickCreate->ar_sendCopyTo = $validatedData['quick_send_copy_toInput']  ?? null;
            $tbl_quickCreate->ar_date_needed = $validatedData['quick_date_needed_Input']  ?? null;
            $tbl_quickCreate->ar_instruction = $validatedData['quick_special_instruct_Input']  ?? null;

            // //Contract
            $tbl_quickCreate->ar_resellers = $validatedData['quick_reseller_input'] ?? null;
            $tbl_quickCreate->ar_resellers_contact = $validatedData['quick_resellers_contact_Input']  ?? null;
            $tbl_quickCreate->ar_resellers_phoneEmail = $validatedData['quick_resellers_email_Input']  ?? null;
            $tbl_quickCreate->ar_endUser = $validatedData['quick_enduser_Input']  ?? null;
            $tbl_quickCreate->ar_endUser_contact = $validatedData['quick_enduser_contact_Input']  ?? null;
            $tbl_quickCreate->ar_endUser_phoneEmail = $validatedData['quick_enduser_email_Input']  ?? null;
            $tbl_quickCreate->ar_endUser_loc = $validatedData['quick_enduser_loc_Input']  ?? null;

            // //Act Summary
            $tbl_quickCreate->ar_activityDate = $validatedData['quick_act_date_Input'];
            $tbl_quickCreate->ar_program = $quick_program_dropdown;
            $tbl_quickCreate->ar_timeExpected = $validatedData['quick_time_expected']  ?? null;
            $tbl_quickCreate->ar_timeReported = $validatedData['quick_time_reported_Input'] ?? null;
            $tbl_quickCreate->ar_timeExited = $validatedData['quick_time_exited_Input']  ?? null;
            $tbl_quickCreate->ar_venue = $validatedData['quick_venue_Input'] ?? null;
            $tbl_quickCreate->ar_sendCopyTo = $validatedData['quick_send_copy_To']  ?? null;

            // //TextField
            $tbl_quickCreate->ar_custRequirements = $validatedData['quick_cust_requirements_Input']  ?? null;
            $tbl_quickCreate->ar_activityDone = $validatedData['quick_activity_done_Input']  ?? null;
            $tbl_quickCreate->ar_agreements = $validatedData['quick_agreements_Input']  ?? null;

            //Activity Type ID
            $activityType_id = tbl_activityType_list::where('type_name',  $quick_activityType)->value('type_id');
            $tbl_quickCreate->ar_activityType = $activityType_id;

            // dd($request->all());
            $tbl_quickCreate->save();

            // Retrieve the uploaded file
            $file = $request->file('quick_attachment');

            // Check if a file has been uploaded
            if ($file) {
                // Generate a unique filename
                $filename = uniqid() . '_' . $file->getClientOriginalName();

                // Specify the destination path
                $destinationPath = storage_path('app/public/uploads');

                // Move the uploaded file to the destination path
                $file->move($destinationPath, $filename);

                // Save the file path to the database
                $imageModel = new tbl_attachments();
                $imageModel->att_ar_id = $tbl_quickCreate->ar_id;
                $imageModel->att_name = $filename;
                $imageModel->save();
            } else {
                // Handle the case where no file has been uploaded
                // For example, you can display a message to the user or perform other actions
                // Here, we're setting a default value for the filename
                $filename = null;

                // You can also display a message to the user if needed
                // For example:
                // return redirect()->back()->with('error', 'No file uploaded.');
            }

            if (is_array($quick_add_engr_name) && count($quick_add_engr_name)) {
                // Iterate over the array of engineers' names
                for ($i = 0; $i < count($quick_add_engr_name); $i++) {
                    $engineer = new tbl_engineers();
                    $engineer->engr_ar_id = $tbl_quickCreate->ar_id; // Set the foreign key to the id of the newly created activity report
                    $engineer->engr_name = $quick_add_engr_name[$i]; // Set the engineer's name
                    $engineer->save();
                }
            }

            if (is_array($quick_add_prod_engr_name) && count($quick_add_prod_engr_name)) {
                // Iterate over the array of engineers' names
                for ($i = 0; $i < count($quick_add_prod_engr_name); $i++) {
                    $prod_engineer = new tbl_prodEngineers();
                    $prod_engineer->prodEngr_ar_id = $tbl_quickCreate->ar_id; // Set the foreign key to the id of the newly created activity report
                    $prod_engineer->prodEngr_name = $quick_add_prod_engr_name[$i]; // Assuming you have a field to store the engineer's id or name
                    $prod_engineer->save();
                }
            }


            if (is_array($quickproductLinesArray) && is_array($quickproductCodesArray) && count($quickproductLinesArray) === count($quickproductCodesArray)) {
                // Iterate over the array of product lines and product codes
                for ($i = 0; $i < count($quickproductLinesArray); $i++) {
                    $productLineVert = new tbl_productLine();
                    $productLineVert->ar_id = $tbl_quickCreate->ar_id; // Set the foreign key to the id of the newly created activity report
                    $productLineVert->ProductLine = $quickproductLinesArray[$i]; // Set the product line name
                    $productLineVert->ProductCode = $quickproductCodesArray[$i]; // Set the product code value
                    $productLineVert->save();
                }
            }



            //participants position
            if (is_array($quick_participant_Input) && is_array($quick_position_Input) && count($quick_participant_Input) === count($quick_position_Input)) {
                // Iterate over the array of participants and positions
                for ($i = 0; $i < count($quick_participant_Input); $i++) {
                    $participantId = new tbl_participants();
                    $participantId->ar_id = $tbl_quickCreate->ar_id; // Set the foreign key to the id of the newly created activity report
                    $participantId->participant = $quick_participant_Input[$i]; // Assuming you have a field to store the participant's id or name
                    $participantId->position = $quick_position_Input[$i]; // Assuming you have a field to store the participant's position
                    $participantId->save();
                }
            }

            // Action Plan
            if (is_array($quick_starting_date) && is_array($quick_details_input) && is_array($quick_owner_input) && count($quick_starting_date) === count($quick_details_input) && count($quick_details_input) === count($quick_owner_input)) {
                // Iterate over the array of starting dates, details, and owners
                for ($i = 0; $i < count($quick_starting_date); $i++) {
                    // Create and save the action plan
                    $actionPlan = new tbl_actionPlan();
                    $actionPlan->ar_id = $tbl_quickCreate->ar_id; // Set the foreign key to the id of the newly created activity report
                    $actionPlan->PlanTargetDate = $quick_starting_date[$i]; // Assuming you have a field to store the starting date
                    $actionPlan->PlanDetails = $quick_details_input[$i]; // Assuming you have a field to store the details
                    $actionPlan->PlanOwner = $quick_owner_input[$i]; // Assuming you have a field to store the owner
                    $actionPlan->save();
                }
            }


            return redirect()->route('tab-activity.index')->with('success', 'New Quick Activity Created Successfully');
        } catch (ValidationException $e) {

            // Redirect back with errors
            //   return redirect()->back()->withErrors($e->validator->errors())->withInput();


            // Handle validation errors
            dd($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                //Header
                'report_Dropdown_Input' => 'required',
                'projectType_Dropdown_Input' => 'nullable',
                'status_Dropdown_Input' => 'required',


                //activity details    
                'activityForm_Input' => 'nullable',
                'requester_Input' => 'nullable',
                'activity_Input' => 'nullable',
                'special_instruct_Input' => 'nullable',
                'reference_No' => 'nullable',
                'date_filed_Input' => 'nullable',
                'date_needed_Input' => 'nullable',


                //Contract Details
                'resellers_Input' => 'nullable',
                'resellers_contact_Input' => 'nullable',
                'resellers_email_Input' => 'nullable',
                'enduser_Input' => 'nullable',
                'enduser_contact_Input' => 'nullable',
                'enduser_email_Input' => 'nullable',
                'enduser_loc_Input' => 'nullable',

                //Activity Summary Report
                'act_date_Input' => 'nullable',
                'act_type_Input' => 'nullable',
                'program_Input' => 'nullable',
                'productLines'  => 'nullable',
                'productCodes' => 'nullable',
                'time_expected_Input' => 'nullable',
                'time_reported_Input' => 'nullable',
                'time_exited_Input' => 'nullable',
                'venue_Input' => 'nullable',
                'send_copy_To' => ['nullable', 'string'],

                //participants/position
                'participant_Input' => 'nullable',
                'position_Input' => 'nullable',

                //Customer Requirements
                'cust_requirements_Input' => 'nullable',

                //Activity Done
                'activity_done_Input' => 'nullable',

                //agreements
                'agreements_Input' => 'nullable',

                //actionPlan
                'starting_date' => 'nullable',
                'details_input' => 'nullable',
                'owner_input' => 'nullable',

                'image' => 'nullable|mimes:jpeg,png,jpg,gif,pdf,xlsx,xls,pptx,txt,html,htm,ppt,pptx,doc,docx|max:10000',

                // New Created Fields
                // ---------------------------------------------------
                // Technology Prod
                'techProdLearnedInput' => 'nullable',

                // Training name
                'training_Name_Input' => 'nullable',
                'training_location' => 'nullable',
                'training_speaker' => 'nullable',

                // Attendees
                'BPsInput' => 'nullable',
                'EUsInput' => 'nullable',
                'MSIInput' => 'nullable',

                //Exam Status
                'exam_title' => 'nullable',
                'exam_code' => 'nullable',
                'takeStatusDropdown' => 'nullable',
                'score_type' => 'nullable',
                'examTypeDropdown' => 'nullable',
                'incentiveStatusDropdown' => 'nullable',
                'incentiveDetailsDropdown' => 'nullable',
                'incentive_amt' => 'nullable',

                // Topic
                'topicName' => 'nullable',
                'dateStart' => 'nullable',
                'dateEnd' => 'nullable',

                // POC
                'poc_dateStart' => 'nullable',
                'poc_dateEnd' => 'nullable',
                'prod_model' => 'nullable',
                'asset_code' => 'nullable',


                //DigiKnow
                'digiknowFlyers' => 'nullable|mimes:jpeg,png,jpg,gif,pdf,xlsx,xls,pptx,txt,html,htm,ppt,pptx,doc,docx|max:10000',
                'BPsInputDigiknow' => 'nullable',
                'EUsInputDigiknow' => 'nullable',

                // Internal Project
                'MSIProjName' => 'nullable',
                'CompliancePercentage' => 'nullable',
                'perfectAttendance' => 'nullable',

                // Memo
                'memoIssued' => 'nullable',
                'memoDetails' => 'nullable',
                'engrFeedbackInput' => 'nullable',
                'rating_input' => 'nullable',

            ]);


            $productLines = $request->input('productLines');
            $productCodes = $request->input('productCodes');
            $productLinesArray = explode(',', $productLines[0]);
            $productCodesArray = explode(',', $productCodes[0]);
            $engr_input = $request->input('engineer_Input');
            $prod_engr_name = $request->input('prod_engineers_Input');
            $participants = $request->input('participant_Input');
            $position = $request->input('position_Input');
            $starting_Date = $request->input('starting_date');
            $details = $request->input('details_input');
            $owner = $request->input('owner_input');
            $act_reportsendCopyTo = $request->input('send_copy_toInput');
            $act_copyToManagerEmail = $request->input('copyToManagerEmail');
            $act_copyToManagerEmailArray = explode(',', $act_copyToManagerEmail[0]);
            $act_reportProgram = $request->input('program_Input');
            $act_report_activityType = $request->input('act_type_Input');
            $act_ProjectName = $request->input('myDropdown');
            $act_ProjectNameID = $request->input('selected_project_id');

            // dd($act_ProjectName);

            switch ($act_reportProgram) {
                case 'sTraCert':
                    $act_reportProgram = 1;
                    break;
                case 'VSTECS Experience Center':
                    $act_reportProgram = 2;
                    break;
                case 'PKOC / MSLC':
                    $act_reportProgram = 3;
                    break;
                case 'None':
                    $act_reportProgram = 4;
                    break;
                default:
                    $act_reportProgram = null;
                    break;
            }



            /////////////////////Project List/////////////////////////////////////////

            $tbl_project_list = new tbl_project_list();
            $tbl_project_list->proj_name = $act_ProjectName;
            $tbl_project_list->proj_type_id = isset($validatedData['projectType_Dropdown_Input']) ? $validatedData['projectType_Dropdown_Input'] : null;
            $tbl_project_list->save();

            ///////////////////////////////////////////////////////////////////////////////


            $tbl_activityCreate = new tbl_activityReport();

            //Header
            $tbl_activityCreate->ar_report = $validatedData['report_Dropdown_Input'];

            $tbl_activityCreate->ar_project =  $act_ProjectNameID;

            $tbl_activityCreate->ar_status = $validatedData['status_Dropdown_Input'];


            // activity details    
            // Check if 'activityForm_Input' is set and not null
            if (isset($validatedData['activityForm_Input']) && $validatedData['activityForm_Input'] !== null) {
                $tbl_activityCreate->ar_activity = $validatedData['activityForm_Input'];
            } elseif (isset($validatedData['activity_Input']) && $validatedData['activity_Input'] !== null) {
                // If 'activityForm_Input' is not set or null, check 'activity_Input'
                $tbl_activityCreate->ar_activity = $validatedData['activity_Input'];
            } else {
                // If neither is set, you can set it to null or handle it accordingly
                $tbl_activityCreate->ar_activity = null;
            }

            $tbl_activityCreate->ar_requester = $validatedData['requester_Input'];
            $tbl_activityCreate->ar_instruction = $validatedData['special_instruct_Input'];
            $tbl_activityCreate->ar_refNo = $validatedData['reference_No'];
            $tbl_activityCreate->ar_date_filed = $validatedData['date_filed_Input'];
            $tbl_activityCreate->ar_date_needed = isset($validatedData['date_needed_Input']) ? $validatedData['date_needed_Input'] : null;

            // contract
            $tbl_activityCreate->ar_resellers = isset($validatedData['resellers_Input']) ? $validatedData['resellers_Input'] : null;
            $tbl_activityCreate->ar_resellers_contact = isset($validatedData['resellers_contact_Input']) ? $validatedData['resellers_contact_Input'] : null;
            $tbl_activityCreate->ar_resellers_phoneEmail = isset($validatedData['resellers_email_Input']) ? $validatedData['resellers_email_Input'] : null;
            $tbl_activityCreate->ar_endUser = isset($validatedData['enduser_Input']) ? $validatedData['enduser_Input'] : null;
            $tbl_activityCreate->ar_endUser_contact = isset($validatedData['enduser_contact_Input']) ? $validatedData['enduser_contact_Input'] : null;
            $tbl_activityCreate->ar_endUser_phoneEmail = isset($validatedData['enduser_email_Input']) ? $validatedData['enduser_email_Input'] : null;
            $tbl_activityCreate->ar_endUser_loc = isset($validatedData['enduser_loc_Input']) ? $validatedData['enduser_loc_Input'] : null;

            //Activity Summary Report
            $tbl_activityCreate->ar_activityDate = isset($validatedData['act_date_Input']) ? $validatedData['act_date_Input'] : null;
            $tbl_activityCreate->ar_timeReported = isset($validatedData['time_reported_Input']) ? $validatedData['time_reported_Input'] : null;
            $tbl_activityCreate->ar_timeExited = isset($validatedData['time_exited_Input']) ? $validatedData['time_exited_Input'] : null;
            $tbl_activityCreate->ar_timeExpected = isset($validatedData['time_expected_Input']) ? $validatedData['time_expected_Input'] : null;
            // Store the arrays in your database
            $tbl_activityCreate->ar_program = $act_reportProgram;
            $tbl_activityCreate->ar_venue = isset($validatedData['venue_Input']) ? $validatedData['venue_Input'] : null;
            $tbl_activityCreate->prod_engr_name;

            // Get the input value
            $sendCopyTo = $request->input('send_copy_To');

            if (!empty($sendCopyTo)) {
                $emailArray = array_map('trim', explode(',', $sendCopyTo));

                // Validate each email
                foreach ($emailArray as $email) {
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        return back()->withErrors(['send_copy_To' => 'Please enter valid email addresses separated by commas.']);
                    }
                }

                // Convert the array back to a comma-separated string
                $emailString = implode(', ', $emailArray);
            } else {
                $emailString = null;
            }

            // Store the string in the database
            $tbl_activityCreate->ar_sendCopyTo = $emailString;


            // New Createad fields
            // -----------------------------------------
            // Tech Prod
            $tbl_activityCreate->ar_prodLearned = isset($validatedData['techProdLearnedInput']) ? $validatedData['techProdLearnedInput'] : null;
            // Training Name
            $tbl_activityCreate->ar_trainingName = isset($validatedData['training_Name_Input']) ? $validatedData['training_Name_Input'] : null;
            $tbl_activityCreate->ar_location = isset($validatedData['training_location']) ? $validatedData['training_location'] : null;
            $tbl_activityCreate->ar_speakers = isset($validatedData['training_speaker']) ? $validatedData['training_speaker'] : null;
            // Attendees
            $tbl_activityCreate->ar_attendeesBPs = $request->has('BPsInput') ? ($request->input('BPsInput') === '1' ? true : false) : null;
            $tbl_activityCreate->ar_attendeesEUs = $request->has('EUsInput') ? ($request->input('EUsInput') === '1' ? true : false) : null;
            $tbl_activityCreate->ar_attendeesMSI = $request->has('MSIInput') ? ($request->input('MSIInput') === '1' ? true : false) : null;
            //Exam Status
            $tbl_activityCreate->ar_title = isset($validatedData['exam_title']) ? $validatedData['exam_title'] : null;
            $tbl_activityCreate->ar_examName = isset($validatedData['exam_code']) ? $validatedData['exam_code'] : null;
            $tbl_activityCreate->ar_takeStatus = isset($validatedData['takeStatusDropdown']) ? $validatedData['takeStatusDropdown'] : null;
            $tbl_activityCreate->ar_score = isset($validatedData['score_type']) ? $validatedData['score_type'] : null;
            $tbl_activityCreate->ar_examType = isset($validatedData['examTypeDropdown']) ? $validatedData['examTypeDropdown'] : null;
            $tbl_activityCreate->ar_incStatus = isset($validatedData['incentiveStatusDropdown']) ? $validatedData['incentiveStatusDropdown'] : null;
            $tbl_activityCreate->ar_incDetails = isset($validatedData['incentiveDetailsDropdown']) ? $validatedData['incentiveDetailsDropdown'] : null;
            $tbl_activityCreate->ar_incAmount = isset($validatedData['incentive_amt']) ? $validatedData['incentive_amt'] : null;

            //  Topic
            $tbl_activityCreate->ar_topic = isset($validatedData['topicName']) ? $validatedData['topicName'] : null;
            $tbl_activityCreate->ar_dateStart = isset($validatedData['dateStart']) ? $validatedData['dateStart'] : null;
            $tbl_activityCreate->ar_dateEnd = isset($validatedData['dateEnd']) ? $validatedData['dateEnd'] : null;

            // Internal Enablement
            $tbl_activityCreate->ar_POCproductModel = isset($validatedData['prod_model']) ? $validatedData['prod_model'] : null;
            $tbl_activityCreate->ar_POCassetOrCode = isset($validatedData['asset_code']) ? $validatedData['asset_code'] : null;
            $tbl_activityCreate->ar_POCdateStart = isset($validatedData['poc_dateStart']) ? $validatedData['poc_dateStart'] : null;
            $tbl_activityCreate->ar_POCdateEnd = isset($validatedData['poc_dateEnd']) ? $validatedData['poc_dateEnd'] : null;

            // DigiKnow
            $tbl_activityCreate->ar_recipientBPs = $request->has('BPsInputDigiknow') ? ($request->input('BPsInputDigiknow') === '1' ? true : false) : null;
            $tbl_activityCreate->ar_recipientEUs = $request->has('EUsInputDigiknow') ? ($request->input('EUsInputDigiknow') === '1' ? true : false) : null;

            // Internal Project
            $tbl_activityCreate->ar_projName = isset($validatedData['MSIProjName']) ? $validatedData['MSIProjName'] : null;
            $tbl_activityCreate->ar_compPercent = isset($validatedData['CompliancePercentage']) ? $validatedData['CompliancePercentage'] : null;
            $tbl_activityCreate->ar_perfectAtt = isset($validatedData['perfectAttendance']) ? $validatedData['perfectAttendance'] : null;

            // Memo
            $tbl_activityCreate->ar_memoIssued = isset($validatedData['memoIssued']) ? $validatedData['memoIssued'] : null;
            $tbl_activityCreate->ar_memoDetails = isset($validatedData['memoDetails']) ? $validatedData['memoDetails'] : null;
            $tbl_activityCreate->ar_feedbackEngr = isset($validatedData['engrFeedbackInput']) ? $validatedData['engrFeedbackInput'] : null;
            $tbl_activityCreate->ar_rating = isset($validatedData['rating_input']) ? $validatedData['rating_input'] : null;

            //Customer Requirements
            $tbl_activityCreate->ar_custRequirements = isset($validatedData['cust_requirements_Input']) ? $validatedData['cust_requirements_Input'] : null;

            //Act Done
            $tbl_activityCreate->ar_activityDone = isset($validatedData['activity_done_Input']) ? $validatedData['activity_done_Input'] : null;

            //agreements
            $tbl_activityCreate->ar_agreements = isset($validatedData['agreements_Input']) ? $validatedData['agreements_Input'] : null;

            //Activity Type ID
            $activityType_id = tbl_activityType_list::where('type_name',  $act_report_activityType)->value('type_id');
            $tbl_activityCreate->ar_activityType = $activityType_id;

            // dd($act_ProjectName);
            $tbl_activityCreate->save();



            // Retrieve the uploaded file
            $act_digiFlyers = $request->file('digiknowFlyers');
            $act_reportfile = $request->file('image');

            try {
                if ($act_digiFlyers) {
                    $act_digiFlyername = uniqid() . '_' . $act_digiFlyers->getClientOriginalName();
                    $destinationPath = public_path('uploads');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $act_digiFlyers->move($destinationPath, $act_digiFlyername);

                    if (isset($tbl_activityCreate) && isset($tbl_activityCreate->ar_id)) {
                        $tbl_digiKnow_flyer = new tbl_digiKnow_flyer();
                        $tbl_digiKnow_flyer->ar_id = $tbl_activityCreate->ar_id;
                        $tbl_digiKnow_flyer->attachment = $act_digiFlyername;
                        $tbl_digiKnow_flyer->save();
                    } else {
                        throw new Exception('Activity ID not found.');
                    }
                } else {
                    $act_digiFlyername = null;
                }

                if ($act_reportfile) {
                    $act_filename = uniqid() . '_' . $act_reportfile->getClientOriginalName();
                    $destinationPath = public_path('uploads');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $act_reportfile->move($destinationPath, $act_filename);

                    if (isset($tbl_activityCreate) && isset($tbl_activityCreate->ar_id)) {
                        $act_imageModel = new tbl_attachments();
                        $act_imageModel->att_ar_id = $tbl_activityCreate->ar_id;
                        $act_imageModel->att_name = $act_filename;
                        $act_imageModel->save();
                    } else {
                        throw new Exception('Activity ID not found.');
                    }
                } else {
                    $act_filename = null;
                }
            } catch (Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'File upload failed.');
            }
            //////////////////////////////////////////////////////////////////////////

            $engineerEmails = $request->input('engineer_email');

            if (is_array($engr_input) && is_array($engineerEmails) && count($engr_input) === count($engineerEmails)) {
                foreach ($engr_input as $index => $engr_name) {
                    $email = trim($engineerEmails[$index]); // Get the corresponding email
            
                    try {
                        // Save the engineer and email
                        $engineer = new tbl_engineers();
                        $engineer->engr_ar_id = $tbl_activityCreate->ar_id; 
                        $engineer->engr_name = $engr_name; 
                        $engineer->engr_email = $email; 
                        $engineer->save();
                    } catch (\Exception $e) {
                        Log::error('Error saving engineer:', [
                            'name' => $engr_name,
                            'email' => $email,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            } else {
                Log::warning('Mismatch between engineer names and emails.', [
                    'names' => $engr_input,
                    'emails' => $engineerEmails,
                ]);
            }


            if (is_array($prod_engr_name) && count($prod_engr_name)) {
                // Iterate over the array of engineers' names
                for ($i = 0; $i < count($prod_engr_name); $i++) {
                    $prod_engineer = new tbl_prodEngineers();
                    $prod_engineer->prodEngr_ar_id = $tbl_activityCreate->ar_id; // Set the foreign key to the id of the newly created activity report
                    $prod_engineer->prodEngr_name = $prod_engr_name[$i]; // Assuming you have a field to store the engineer's id or name
                    $prod_engineer->save();
                }
            }

            if (is_array($act_reportsendCopyTo) && is_array($act_copyToManagerEmailArray) && count($act_reportsendCopyTo) === count($act_copyToManagerEmailArray)) {
                // Iterate over the array of engineers' names
                for ($i = 0; $i < count($act_reportsendCopyTo); $i++) {
                    $copyTo_Act = new tbl_copyTo();
                    $copyTo_Act->copy_ar_id = $tbl_activityCreate->ar_id; // Set the foreign key to the id of the newly created activity report
                    $copyTo_Act->copy_name = $act_reportsendCopyTo[$i];
                    $copyTo_Act->copy_email = $act_copyToManagerEmailArray[$i];
                    $copyTo_Act->save();
                }
            }

            if (is_array($productLinesArray) && is_array($productCodesArray) && count($productLinesArray) === count($productCodesArray)) {
                // Iterate over the array of product lines and product codes
                for ($i = 0; $i < count($productLinesArray); $i++) {
                    $productLineVert = new tbl_productLine();
                    $productLineVert->ar_id = $tbl_activityCreate->ar_id; // Set the foreign key to the id of the newly created activity report
                    $productLineVert->ProductLine = $productLinesArray[$i]; // Set the product line name
                    $productLineVert->ProductCode = $productCodesArray[$i]; // Set the product code value
                    $productLineVert->save();
                }
            }



            //participants position
            if (is_array($participants) && is_array($position) && count($participants) === count($position)) {
                // Iterate over the array of participants and positions
                for ($i = 0; $i < count($participants); $i++) {
                    $participantId = new tbl_participants();
                    $participantId->ar_id = $tbl_activityCreate->ar_id; // Set the foreign key to the id of the newly created activity report
                    $participantId->participant = $participants[$i]; // Assuming you have a field to store the participant's id or name
                    $participantId->position = $position[$i]; // Assuming you have a field to store the participant's position
                    $participantId->save();
                }
            }

            // Action Plan
            if (is_array($starting_Date) && is_array($details) && is_array($owner) && count($starting_Date) === count($details) && count($details) === count($owner)) {
                // Iterate over the array of starting dates, details, and owners
                for ($i = 0; $i < count($starting_Date); $i++) {
                    // Create and save the action plan
                    $actionPlan = new tbl_actionPlan();
                    $actionPlan->ar_id = $tbl_activityCreate->ar_id; // Set the foreign key to the id of the newly created activity report
                    $actionPlan->PlanTargetDate = $starting_Date[$i]; // Assuming you have a field to store the starting date
                    $actionPlan->PlanDetails = $details[$i]; // Assuming you have a field to store the details
                    $actionPlan->PlanOwner = $owner[$i]; // Assuming you have a field to store the owner
                    $actionPlan->save();
                }
            }


            return redirect()->route('tab-activity.index')->with('success', 'Activity report created successfully with <strong> Reference #: ' . $tbl_activityCreate->ar_refNo .  '</strong>. Thank you.');
        } catch (ValidationException $e) {
            // Handle validation errors
            dd($e->getMessage());
        }
    }
}
