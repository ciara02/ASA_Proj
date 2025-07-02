<?php

namespace App\Http\Controllers;

use App\Models\LDAPEngineer;
use App\Models\tbl_project_list;
use App\Models\tbl_activityReport;
use App\Models\tbl_engineers;
use App\Models\tbl_productLine;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{

    public function index()
    {
        $ldapUsername = Auth::user()->email;
    
        // Transform the email to match LDAP format (adjust this transformation based on your requirement)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email to ensure it's correct
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data for the currently logged-in user
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);
        return view('tab-report.index', compact('ldapEngineer'));
    }

    private function convertTakeStatusToWord($takestatus)
    {
        switch ($takestatus) {
            case 1:
                return '1 Take';
            case 2:
                return '2 Takes';
            default:
                return 'Nth Take';
        }
    }

    public function ProjName(Request $request)
    {
        $projName = $request->projName;

        $getEngrNames = tbl_project_list::with('getProjMember')

            ->where('proj_name', 'like', '%' . ($projName) . '%')
            ->get();

        $resultArray = [];

        foreach ($getEngrNames as $project) {
            $projectData = [
                'proj_name' => $project->proj_name,
                'eng_names' => $project->getProjMember->pluck('eng_name'),
                'project_ids' => $project->getProjMember->pluck('project_id')
            ];

            $resultArray[] = $projectData;
        }
        return response()->json($resultArray);
    }

    public function DigiKnowPerEngr(Request $request)
    {

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $projectCategory = $request->input('projectCategory');
        $engineers = $request->input('engineers');

        if ($projectCategory == 'DigiKnow') {

            $DigiknowEngr = tbl_activityReport::join('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
            ->join('tbl_report_list', 'tbl_activityReport.ar_report', '=', 'tbl_report_list.report_id')
            ->leftJoin('tbl_productLine', 'tbl_activityReport.ar_id', '=', 'tbl_productLine.ar_id')
            ->join('tbl_activityType_list', 'tbl_activityReport.ar_activityType', '=', 'tbl_activityType_list.type_id')
            ->join('tbl_status_list', 'tbl_activityReport.ar_status', '=', 'tbl_status_list.status_id')
            ->leftJoin('tbl_program_list', 'tbl_activityReport.ar_program', '=', 'tbl_program_list.program_id')
            ->leftJoin('tbl_copyTo', 'tbl_activityReport.ar_id', '=', 'tbl_copyTo.copy_ar_id')
            ->leftJoin('tbl_prodEngineers', 'tbl_activityReport.ar_id', '=', 'tbl_prodEngineers.prodEngr_ar_id')
            ->leftjoin('tbl_time_list as reported_time', 'tbl_activityReport.ar_timeReported', '=', 'reported_time.key_id')
            ->leftjoin('tbl_time_list as exited_time', 'tbl_activityReport.ar_timeExited', '=', 'exited_time.key_id')
            ->leftjoin('tbl_time_list as expected_time', 'tbl_activityReport.ar_timeExpected', '=', 'expected_time.key_id')
            ->select(
                'tbl_activityReport.ar_id',
                'engr_name',
                'ar_activityDate',
                'ar_instruction',
                'ProductLine',
                'ar_activity',
                'report_name',
                'type_name',
                'ar_owner',
                'ar_resellers',
                'ar_resellers_contact',
                'ar_resellers_phoneEmail',
                'ar_title',
                'ar_examName',
                'ar_takeStatus',
                'ar_score',
                'ar_examType',
                'ar_incDetails',
                'ar_incAmount',
                'ar_incStatus',
                'ar_topic',
                'ar_trainingName',
                'ar_POCproductModel',
                'ar_POCassetOrCode',
                'ar_POCdateStart',
                'ar_POCdateEnd',
                'ar_location',
                'ar_speakers',
                'ar_endUser',
                'ar_endUser_contact',
                'ar_endUser_phoneEmail',
                'ar_endUser_loc',
                'status_name',
                'ar_venue',
                'ar_status',
                'reported_time.key_time as reported_key_time',
                'exited_time.key_time as exited_key_time',
                'expected_time.key_time as expected_key_time',
                'ar_refNo',
                'ar_requester',
                'ar_date_filed',
                'ar_projName',
                'ar_date_needed',
                'program_name',
                'prodEngr_name',
                'copy_name',
                'ar_dateStart',
                'ar_dateEnd',
                'ar_recipientBPs',
                'ar_recipientEUs',
                'ar_attendeesBPs',
                'ar_attendeesEUs',
                'ar_attendeesMSI',
                'ar_sendCopyTo',
                'ar_custRequirements',
                'ar_details',
                'ar_activityDone',
                'ar_agreements',
                'ar_prodLearned',
                'ar_targetDate'
            )
            ->where('ar_activityType', 43)
            ->orderByDesc('ar_activityDate');

            if (!empty($startDate) && !empty($endDate)) {
                $DigiknowEngr = $DigiknowEngr->whereBetween('ar_activityDate', [$startDate, $endDate]);
            }
            if (!empty($engineers)) {
                $DigiknowEngr = $DigiknowEngr->whereIn('engr_name', (array) $engineers);
            }
        } 
        elseif ($projectCategory == 'DigiKnow Per Engineer') {
            
            $DigiknowEngr = tbl_activityReport::join('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
            ->leftJoin('tbl_productLine', 'tbl_activityReport.ar_id', '=', 'tbl_productLine.ar_id')
            ->leftJoin('tbl_report_list', 'tbl_activityReport.ar_report', '=', 'tbl_report_list.report_id')
            ->join('tbl_activityType_list', 'tbl_activityReport.ar_activityType', '=', 'tbl_activityType_list.type_id')
            ->join('tbl_status_list', 'tbl_activityReport.ar_status', '=', 'tbl_status_list.status_id')
            ->leftJoin('tbl_program_list', 'tbl_activityReport.ar_program', '=', 'tbl_program_list.program_id')
            ->leftJoin('tbl_copyTo', 'tbl_activityReport.ar_id', '=', 'tbl_copyTo.copy_ar_id')
            ->leftJoin('tbl_prodEngineers', 'tbl_activityReport.ar_id', '=', 'tbl_prodEngineers.prodEngr_ar_id')
            ->leftJoin('tbl_time_list as reported_time', 'tbl_activityReport.ar_timeReported', '=', 'reported_time.key_id')
            ->leftJoin('tbl_time_list as exited_time', 'tbl_activityReport.ar_timeExited', '=', 'exited_time.key_id')
            ->leftJoin('tbl_time_list as expected_time', 'tbl_activityReport.ar_timeExpected', '=', 'expected_time.key_id')
            ->select(
                'tbl_activityReport.ar_id',
                'engr_name',
                'ar_activityDate',
                'ar_owner',
                'ar_instruction',
                'ProductLine',
                'ar_activity',
                'report_name',
                'type_name',
                'ar_resellers',
                'ar_resellers_contact',
                'ar_resellers_phoneEmail',
                'ar_endUser',
                'ar_endUser_contact',
                'ar_endUser_phoneEmail',
                'ar_endUser_loc',
                'status_name',
                'ar_venue',
                'ar_title',
                'ar_trainingName',
                'ar_examName',
                'ar_takeStatus',
                'ar_score',
                'ar_examType',
                'ar_incDetails',
                'ar_incAmount',
                'ar_incStatus',
                'ar_speakers',
                'ar_topic',
                'ar_POCproductModel',
                'ar_POCassetOrCode',
                'ar_POCdateStart',
                'ar_POCdateEnd',
                'ar_status',
                'reported_time.key_time as reported_key_time',
                'exited_time.key_time as exited_key_time',
                'expected_time.key_time as expected_key_time',
                'ar_refNo',
                'ar_requester',
                'ar_projName',
                'ar_date_filed',
                'ar_date_needed',
                'program_name',
                'prodEngr_name',
                'ar_location',
                'copy_name',
                'ar_dateStart',
                'ar_dateEnd',
                'ar_recipientBPs',
                'ar_recipientEUs',
                'ar_attendeesBPs',
                'ar_attendeesEUs',
                'ar_attendeesMSI',
                'ar_sendCopyTo',
                'ar_custRequirements',
                'ar_activityDone',
                'ar_agreements',
                'ar_details',
                'ar_prodLearned',
                'ar_targetDate'
            )
            ->where('ar_activityType', 43)
            ->orderBy('engr_name', 'ASC')
            ->orderByDesc('ar_activityDate');
            
        
        
            // Apply date range condition if both start date and end date are provided
            if (!empty($startDate) && !empty($endDate)) {
                $DigiknowEngr = $DigiknowEngr->whereBetween('ar_activityDate', [$startDate, $endDate]);
            }
            if (!empty($engineers)) {
                $DigiknowEngr = $DigiknowEngr->whereIn('engr_name', (array) $engineers);
            }
        }  elseif ($projectCategory == 'DigiKnow Per Product Line') {


            $DigiknowEngr = tbl_activityReport::leftjoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
                ->leftjoin('tbl_report_list', 'tbl_activityReport.ar_report', '=', 'tbl_report_list.report_id')
                ->leftjoin('tbl_productLine', 'tbl_activityReport.ar_id', '=', 'tbl_productLine.ar_id')
                ->leftjoin('tbl_activityType_list', 'tbl_activityReport.ar_activityType', '=', 'tbl_activityType_list.type_id')
                ->leftjoin('tbl_status_list', 'tbl_activityReport.ar_status', '=', 'tbl_status_list.status_id')
                ->leftJoin('tbl_program_list', 'tbl_activityReport.ar_program', '=', 'tbl_program_list.program_id')
                ->leftJoin('tbl_copyTo', 'tbl_activityReport.ar_id', '=', 'tbl_copyTo.copy_ar_id')
                ->leftJoin('tbl_prodEngineers', 'tbl_activityReport.ar_id', '=', 'tbl_prodEngineers.prodEngr_ar_id')
                ->leftjoin('tbl_time_list as reported_time', 'tbl_activityReport.ar_timeReported', '=', 'reported_time.key_id')
                ->leftjoin('tbl_time_list as exited_time', 'tbl_activityReport.ar_timeExited', '=', 'exited_time.key_id')
                ->leftjoin('tbl_time_list as expected_time', 'tbl_activityReport.ar_timeExpected', '=', 'expected_time.key_id')
                ->select(
                    'tbl_activityReport.ar_id',
                    'engr_name',
                    'ar_activityDate',
                    'ar_instruction',
                    'ProductLine',
                    'ar_activity',
                    'report_name',
                    'type_name',
                    'ar_owner',
                    'ar_title',
                    'ar_examName',
                    'ar_takeStatus',
                    'ar_score',
                    'ar_examType',
                    'ar_incDetails',
                    'ar_incAmount',
                    'ar_incStatus',
                    'ar_topic',
                    'ar_POCproductModel',
                    'ar_POCassetOrCode',
                    'ar_POCdateStart',
                    'ar_POCdateEnd',
                    'ar_resellers',
                    'ar_resellers_contact',
                    'ar_resellers_phoneEmail',
                    'ar_endUser',
                    'ar_endUser_contact',
                    'ar_endUser_phoneEmail',
                    'ar_endUser_loc',
                    'status_name',
                    'ar_trainingName',
                    'ar_projName',
                    'ar_venue',
                    'ar_status',
                    'reported_time.key_time as reported_key_time',
                    'exited_time.key_time as exited_key_time',
                    'expected_time.key_time as expected_key_time',
                    'ar_refNo',
                    'ar_requester',
                    'ar_speakers',
                    'ar_date_filed',
                    'ar_date_needed',
                    'program_name',
                    'prodEngr_name',
                    'copy_name',
                    'ar_recipientBPs',
                    'ar_recipientEUs',
                    'ar_attendeesBPs',
                    'ar_attendeesEUs',
                    'ar_attendeesMSI',
                    'ar_sendCopyTo',
                    'ar_custRequirements',
                    'ar_location',
                    'ar_activityDone',
                    'ar_agreements', 
                    'ar_dateStart',
                    'ar_dateEnd',
                    'ar_details',
                    'ar_prodLearned',
                    'ar_targetDate'
                )
                ->where('ar_activityType', 43)
                ->orderBy('ProductLine', 'ASC')
                ->orderByRaw('YEAR(ar_activityDate) DESC,
                MONTH(ar_activityDate) DESC, 
                DAY(ar_activityDate) DESC');

            // Apply date range condition if both start date and end date are provided
            if (!empty($startDate) && !empty($endDate)) {
                $DigiknowEngr = $DigiknowEngr->whereBetween('ar_activityDate', [$startDate, $endDate]);
            }
            if (!empty($engineers)) {
                $DigiknowEngr = $DigiknowEngr->whereIn('engr_name', (array) $engineers);
            }
        }elseif ($projectCategory == 'Ongoing Projects') {
            $DigiknowEngr = tbl_project_list::select(
                'proj_name',
                'proj_startDate',
                'proj_endDate',
                'proj_amount',
                'status',
                'approved_date',
                'reseller',
                'endUser'
            )
                ->where('status', 'On Going');

            if (!empty($startDate) && !empty($endDate)) {
                $DigiknowEngr = $DigiknowEngr->whereBetween('proj_endDate', [$startDate, $endDate]);
            }
        } elseif ($projectCategory == 'Project Progress Report') {
            $DigiknowEngr = tbl_activityReport::leftjoin('tbl_project_list', 'tbl_activityReport.ar_project', '=', 'tbl_project_list.id')
                ->leftjoin('tbl_project_type_list', 'tbl_project_list.proj_type_id', '=', 'tbl_project_type_list.id')
                ->leftjoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
                ->leftjoin('tbl_productLine', 'tbl_activityReport.ar_id', '=', 'tbl_productLine.ar_id')
                ->leftjoin('tbl_status_list', 'tbl_activityReport.ar_status', '=', 'tbl_status_list.status_id')
                ->leftjoin('tbl_time_list as reported_time', 'tbl_activityReport.ar_timeReported', '=', 'reported_time.key_id')
                ->leftjoin('tbl_time_list as exited_time', 'tbl_activityReport.ar_timeExited', '=', 'exited_time.key_id')
                ->leftjoin('tbl_time_list as expected_time', 'tbl_activityReport.ar_timeExpected', '=', 'expected_time.key_id')
                ->leftjoin('tbl_report_list', 'tbl_activityReport.ar_report', '=', 'tbl_report_list.report_id')
                ->leftjoin('tbl_activityType_list', 'tbl_activityReport.ar_activityType', '=', 'tbl_activityType_list.type_id')
                ->leftJoin('tbl_program_list', 'tbl_activityReport.ar_program', '=', 'tbl_program_list.program_id')
                ->leftJoin('tbl_prodEngineers', 'tbl_activityReport.ar_id', '=', 'tbl_prodEngineers.prodEngr_ar_id')
                ->leftJoin('tbl_copyTo', 'tbl_activityReport.ar_id', '=', 'tbl_copyTo.copy_ar_id')
                ->select(
                    'proj_name',
                    'name',
                    'ar_activityDate',
                    'ar_status',
                    'ar_project',
                    'status_name',
                    'ar_owner',
                    'ar_activity',
                    'reported_time.key_time as reported_key_time',
                    'exited_time.key_time as exited_key_time',
                    'expected_time.key_time as expected_key_time',
                    'report_name',
                    'type_name',
                    'ar_productLine',
                    'ar_resellers',
                    'ar_resellers_contact',
                    'ar_resellers_phoneEmail',
                    'ar_endUser',
                    'ar_endUser_contact',
                    'ar_endUser_phoneEmail',
                    'ar_endUser_loc',
                    'ar_venue',
                    'ar_refNo',
                    'ProductLine',
                    'ar_requester',
                    'ar_date_filed',
                    'ar_date_needed',
                    'program_name',
                    'prodEngr_name',
                    'copy_name',
                    'ar_instruction',
                    'engr_name',
                    'ar_title',
                    'ar_examName',
                    'ar_takeStatus',
                    'ar_score',
                    'ar_examType',
                    'ar_incDetails',
                    'ar_incAmount',
                    'ar_incStatus',
                    'ar_topic',
                    'ar_POCproductModel',
                    'ar_POCassetOrCode',
                    'ar_POCdateStart',
                    'ar_POCdateEnd',
                    'ar_recipientBPs',
                    'ar_recipientEUs',
                    'ar_projName',
                    'ar_compPercent',
                    'ar_perfectAtt',
                    'ar_memoIssued',
                    'ar_memoDetails',
                    'ar_feedbackEngr',
                    'ar_rating',
                    'ar_dateStart',
                    'ar_dateEnd',
                    'ar_prodLearned',
                    'ar_attendeesBPs',
                    'ar_attendeesEUs',
                    'ar_attendeesMSI',
                    'ar_trainingName',
                    'ar_location',
                    'ar_speakers',
                    'ar_custRequirements',
                    'ar_activityDone',
                    'ar_agreements',
                    'ar_sendCopyTo',
                    'ar_details',
                    'ar_targetDate'

                )
                ->limit(100)
                ->orderBy('ar_project', 'ASC')
                ->orderByRaw('YEAR(ar_activityDate) DESC')
                ->orderByRaw('MONTH(ar_activityDate) DESC')
                ->orderByRaw('DAY(ar_activityDate) DESC');

            if (!empty($startDate) && !empty($endDate)) {
                $DigiknowEngr = $DigiknowEngr->whereBetween('ar_activityDate', [$startDate, $endDate]);
            }
            if (!empty($engineers)) {
                $DigiknowEngr = $DigiknowEngr->whereIn('engr_name', (array) $engineers);
            }
        } elseif ($projectCategory == 'Solution Center') {
            $DigiknowEngr = tbl_activityReport::leftjoin('tbl_productLine', 'tbl_activityReport.ar_id', '=', 'tbl_productLine.ar_id')
                ->leftjoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
                ->leftjoin('tbl_report_list', 'tbl_activityReport.ar_report', '=', 'tbl_report_list.report_id')
                ->leftjoin('tbl_activityType_list', 'tbl_activityReport.ar_activityType', '=', 'tbl_activityType_list.type_id')
                ->leftjoin('tbl_status_list', 'tbl_activityReport.ar_status', '=', 'tbl_status_list.status_id')
                ->leftJoin('tbl_program_list', 'tbl_activityReport.ar_program', '=', 'tbl_program_list.program_id')
                ->leftJoin('tbl_copyTo', 'tbl_activityReport.ar_id', '=', 'tbl_copyTo.copy_ar_id')
                ->leftJoin('tbl_prodEngineers', 'tbl_activityReport.ar_id', '=', 'tbl_prodEngineers.prodEngr_ar_id')
                ->leftjoin('tbl_time_list as reported_time', 'tbl_activityReport.ar_timeReported', '=', 'reported_time.key_id')
                ->leftjoin('tbl_time_list as exited_time', 'tbl_activityReport.ar_timeExited', '=', 'exited_time.key_id')
                ->leftjoin('tbl_time_list as expected_time', 'tbl_activityReport.ar_timeExpected', '=', 'expected_time.key_id')

                ->select(
                'tbl_activityReport.ar_id',
                'ar_activityDate',
                'ar_status',
                'ar_project',
                'status_name',
                DB::raw("(SELECT STUFF((SELECT ',' + pl.ProductLine 
                FROM tbl_productLine pl 
                WHERE pl.ar_id = tbl_activityReport.ar_id 
                FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '')) as ProductLine"),
                'ar_activity',
                'reported_time.key_time as reported_key_time',
                'exited_time.key_time as exited_key_time',
                'expected_time.key_time as expected_key_time',
                'report_name',
                'type_name',
                'ar_owner',
                'ar_resellers',
                'ar_resellers_contact',
                'ar_resellers_phoneEmail',
                'ar_endUser',
                'ar_endUser_contact',
                'ar_endUser_phoneEmail',
                'ar_endUser_loc',
                'ar_venue',
                'ar_refNo',
                'ar_requester',
                'ar_date_filed',
                'ar_date_needed',
                'program_name',
                'prodEngr_name',
                'copy_name',
                'ar_instruction',
                'engr_name',
                'ar_title',
                'ar_examName',
                'ar_takeStatus',
                'ar_score',
                'ar_examType',
                'ar_incDetails',
                'ar_incAmount',
                'ar_incStatus',
                'ar_topic',
                'ar_POCproductModel',
                'ar_POCassetOrCode',
                'ar_POCdateStart',
                'ar_POCdateEnd',
                'ar_recipientBPs',
                'ar_recipientEUs',
                'ar_projName',
                'ar_compPercent',
                'ar_perfectAtt',
                'ar_memoIssued',
                'ar_memoDetails',
                'ar_feedbackEngr',
                'ar_rating',
                'ar_dateStart',
                'ar_dateEnd',
                'ar_prodLearned',
                'ar_attendeesBPs',
                'ar_attendeesEUs',
                'ar_attendeesMSI',
                'ar_trainingName',
                'ar_location',
                'ar_speakers',
                'ar_custRequirements',
                'ar_activityDone',
                'ar_agreements',
                'ar_sendCopyTo',
                'ar_details',
                'ar_targetDate'
                
                )
                ->orderBy('ar_activityDate', 'DESC')
                ->where('ar_program', 2)
                ->get();


            if (!empty($startDate) && !empty($endDate)) {
                $DigiknowEngr = $DigiknowEngr->whereBetween('ar_activityDate', [$startDate, $endDate]);
            }
            if (!empty($engineers)) {
                $DigiknowEngr = $DigiknowEngr->whereIn('engr_name', (array) $engineers);
            }

            $DigiknowEngr = $DigiknowEngr->values()->toArray();

            return response()->json($DigiknowEngr);
        } elseif ($projectCategory == 'Solution Center per Product Line') {
            $DigiknowEngr = tbl_activityReport::leftjoin('tbl_productLine', 'tbl_activityReport.ar_id', '=', 'tbl_productLine.ar_id')
                ->leftjoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
                ->leftjoin('tbl_report_list', 'tbl_activityReport.ar_report', '=', 'tbl_report_list.report_id')
                ->leftjoin('tbl_activityType_list', 'tbl_activityReport.ar_activityType', '=', 'tbl_activityType_list.type_id')
                ->leftjoin('tbl_status_list', 'tbl_activityReport.ar_status', '=', 'tbl_status_list.status_id')
                ->leftJoin('tbl_program_list', 'tbl_activityReport.ar_program', '=', 'tbl_program_list.program_id')
                ->leftJoin('tbl_copyTo', 'tbl_activityReport.ar_id', '=', 'tbl_copyTo.copy_ar_id')
                ->leftJoin('tbl_prodEngineers', 'tbl_activityReport.ar_id', '=', 'tbl_prodEngineers.prodEngr_ar_id')
                ->leftjoin('tbl_time_list as reported_time', 'tbl_activityReport.ar_timeReported', '=', 'reported_time.key_id')
                ->leftjoin('tbl_time_list as exited_time', 'tbl_activityReport.ar_timeExited', '=', 'exited_time.key_id')
                ->leftjoin('tbl_time_list as expected_time', 'tbl_activityReport.ar_timeExpected', '=', 'expected_time.key_id')
                ->select(
                'tbl_activityReport.ar_id',
                'ProductLine',
                'ar_activity',
                'ar_activityDate',
                'ar_status',
                'ar_project',
                'status_name',
                'reported_time.key_time as reported_key_time',
                'exited_time.key_time as exited_key_time',
                'expected_time.key_time as expected_key_time',
                'report_name',
                'type_name',
                'ar_owner',
                'ar_resellers',
                'ar_resellers_contact',
                'ar_resellers_phoneEmail',
                'ar_endUser',
                'ar_endUser_contact',
                'ar_endUser_phoneEmail',
                'ar_endUser_loc',
                'ar_venue',
                'ar_refNo',
                'ar_requester',
                'ar_date_filed',
                'ar_date_needed',
                'program_name',
                'prodEngr_name',
                'copy_name',
                'ar_instruction',
                'engr_name',
                'ar_title',
                'ar_examName',
                'ar_takeStatus',
                'ar_score',
                'ar_examType',
                'ar_incDetails',
                'ar_incAmount',
                'ar_incStatus',
                'ar_topic',
                'ar_POCproductModel',
                'ar_POCassetOrCode',
                'ar_POCdateStart',
                'ar_POCdateEnd',
                'ar_recipientBPs',
                'ar_recipientEUs',
                'ar_projName',
                'ar_compPercent',
                'ar_perfectAtt',
                'ar_memoIssued',
                'ar_memoDetails',
                'ar_feedbackEngr',
                'ar_rating',
                'ar_dateStart',
                'ar_dateEnd',
                'ar_prodLearned',
                'ar_attendeesBPs',
                'ar_attendeesEUs',
                'ar_attendeesMSI',
                'ar_trainingName',
                'ar_location',
                'ar_speakers',
                'ar_custRequirements',
                'ar_activityDone',
                'ar_agreements',
                'ar_sendCopyTo',
                'ar_details',
                'ar_targetDate'
                )
                ->where('ar_program', 2)
                ->orderBy('tbl_productLine.ProductLine', 'ASC')
                ->orderByRaw('YEAR(ar_activityDate) DESC,
                MONTH(ar_activityDate) DESC, 
                DAY(ar_activityDate) DESC');

            if (!empty($startDate) && !empty($endDate)) {
                $DigiknowEngr = $DigiknowEngr->whereBetween('ar_activityDate', [$startDate, $endDate]);
            }
            if (!empty($engineers)) {
                $DigiknowEngr = $DigiknowEngr->whereIn('engr_name', (array) $engineers);
            }
        } elseif ($projectCategory == 'sTraCert') {
            $DigiknowEngr = tbl_activityReport::leftjoin('tbl_productLine', 'tbl_activityReport.ar_id', '=', 'tbl_productLine.ar_id')
                ->leftjoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
                ->leftjoin('tbl_report_list', 'tbl_activityReport.ar_report', '=', 'tbl_report_list.report_id')
                ->leftjoin('tbl_activityType_list', 'tbl_activityReport.ar_activityType', '=', 'tbl_activityType_list.type_id')
                ->leftjoin('tbl_status_list', 'tbl_activityReport.ar_status', '=', 'tbl_status_list.status_id')
                ->leftJoin('tbl_program_list', 'tbl_activityReport.ar_program', '=', 'tbl_program_list.program_id')
                ->leftJoin('tbl_copyTo', 'tbl_activityReport.ar_id', '=', 'tbl_copyTo.copy_ar_id')
                ->leftJoin('tbl_prodEngineers', 'tbl_activityReport.ar_id', '=', 'tbl_prodEngineers.prodEngr_ar_id')
                ->leftjoin('tbl_time_list as reported_time', 'tbl_activityReport.ar_timeReported', '=', 'reported_time.key_id')
                ->leftjoin('tbl_time_list as exited_time', 'tbl_activityReport.ar_timeExited', '=', 'exited_time.key_id')
                ->leftjoin('tbl_time_list as expected_time', 'tbl_activityReport.ar_timeExpected', '=', 'expected_time.key_id')
                ->select(
                'tbl_activityReport.ar_id',
                'ProductLine',
                'ar_activity',
                'ar_activityDate',
                'ar_status',
                'ar_project',
                'status_name',
                'reported_time.key_time as reported_key_time',
                'exited_time.key_time as exited_key_time',
                'expected_time.key_time as expected_key_time',
                'report_name',
                'type_name',
                'ar_resellers',
                'ar_resellers_contact',
                'ar_resellers_phoneEmail',
                'ar_endUser',
                'ar_endUser_contact',
                'ar_endUser_phoneEmail',
                'ar_endUser_loc',
                'ar_venue',
                'ar_title',
                'ar_examName',
                'ar_takeStatus',
                'ar_score',
                'ar_examType',
                'ar_incDetails',
                'ar_incAmount',
                'ar_incStatus',
                'ar_POCproductModel',
                'ar_POCassetOrCode',
                'ar_POCdateStart',
                'ar_POCdateEnd',
                'ar_refNo',
                'ar_requester',
                'ar_date_filed',
                'ar_date_needed',
                'program_name',
                'prodEngr_name',
                'copy_name',
                'ar_instruction',
                'engr_name',
                'ar_topic',
                'ar_dateStart',
                'ar_dateEnd',
                'ar_recipientBPs',
                'ar_recipientEUs',
                'ar_prodLearned',
                'ar_attendeesBPs',
                'ar_attendeesEUs',
                'ar_attendeesMSI',
                'ar_trainingName',
                'ar_projName',
                'ar_location',
                'ar_speakers',
                'ar_custRequirements',
                'ar_activityDone',
                'ar_agreements',
                'ar_sendCopyTo',
                'ar_details',
                'ar_targetDate'
                )
                ->orderByRaw('ar_activityDate DESC')
                ->where('ar_program', 1);

            if (!empty($startDate) && !empty($endDate)) {
                $DigiknowEngr = $DigiknowEngr->whereBetween('ar_activityDate', [$startDate, $endDate]);
            }
            if (!empty($engineers)) {
                $DigiknowEngr = $DigiknowEngr->whereIn('engr_name', (array) $engineers);
            }
        } elseif ($projectCategory == 'Compiled Reports') {
            $DigiknowEngr = tbl_activityReport::leftjoin('tbl_project_list', 'tbl_activityReport.ar_project', '=', 'tbl_project_list.id')
                ->leftjoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
                ->leftjoin('tbl_time_list as reported_time', 'tbl_activityReport.ar_timeReported', '=', 'reported_time.key_id')
                ->leftjoin('tbl_time_list as exited_time', 'tbl_activityReport.ar_timeExited', '=', 'exited_time.key_id')
                ->leftjoin('tbl_time_list as expected_time', 'tbl_activityReport.ar_timeExpected', '=', 'expected_time.key_id')
                ->leftjoin('tbl_report_list', 'tbl_activityReport.ar_report', '=', 'tbl_report_list.report_id')
                ->leftjoin('tbl_program_list', 'tbl_activityReport.ar_program', '=', 'tbl_program_list.program_id')
                ->leftjoin('tbl_productLine', 'tbl_activityReport.ar_id', '=', 'tbl_productLine.ar_id')
                ->leftjoin('tbl_participants', 'tbl_activityReport.ar_id', '=', 'tbl_participants.ar_id')
                ->leftjoin('tbl_activityType_list', 'tbl_activityReport.ar_activityType', '=', 'tbl_activityType_list.type_id')
                ->leftjoin('tbl_exam_list', 'tbl_activityReport.ar_examType', '=', 'tbl_exam_list.exam_id')
                ->leftjoin('tbl_incentives_details', 'tbl_activityReport.ar_incDetails', '=', 'tbl_incentives_details.incDetails_id')
                ->leftjoin('tbl_incentives_status', 'tbl_activityReport.ar_incStatus', '=', 'tbl_incentives_status.incStatus_id')
                ->leftjoin('tbl_status_list', 'tbl_activityReport.ar_status', '=', 'tbl_status_list.status_id')
                ->select(
                    'tbl_activityReport.ar_id',
                    'ar_activityDate',
                    'proj_name',
                    'ar_refNo',
                    'engr_name',
                    'reported_time.key_time as reported_key_time',
                    'exited_time.key_time as exited_key_time',
                    'expected_time.key_time as expected_key_time',
                    'report_name',
                    'ar_activity',
                    'program_name',
                    'ProductLine',
                    'ProductCode',
                    'ar_resellers',
                    'ar_resellers_contact',
                    'ar_resellers_phoneEmail',
                    'ar_endUser',
                    'ar_endUser_contact',
                    'ar_endUser_loc',
                    'ar_endUser_phoneEmail',
                    'ar_custRequirements',
                    'participant',
                    'position',
                    'ar_activityDone',
                    'ar_agreements',
                    'ar_targetDate',
                    'ar_details',
                    'ar_owner',
                    'type_name',
                    'ar_title',
                    'ar_examName',
                    'ar_takeStatus',
                    'ar_score',
                    'exam_name',
                    'ar_examType',
                    'ar_incDetails',
                    'ar_incStatus',
                    'incDetails_name',
                    'ar_incAmount',
                    'incStatus_name',
                    'ar_prodLearned',
                    'ar_trainingName',
                    'ar_location',
                    'ar_speakers',
                    'ar_projName',
                    'ar_compPercent',
                    'ar_perfectAtt',
                    'ar_memoDetails',
                    'ar_memoIssued',
                    'ar_feedbackEngr',
                    'ar_rating',
                    'ar_recipientBPs',
                    'ar_recipientEUs',
                    'ar_attendeesBPs',
                    'ar_attendeesEUs',
                    'ar_attendeesMSI',
                    'ar_POCproductModel',
                    'ar_POCassetOrCode',
                    'ar_POCdateStart',
                    'ar_POCdateEnd',
                    'ar_topic',
                    'ar_dateStart',
                    'ar_dateEnd',
                    'ar_venue',
                    'ar_requester',
                    'proj_code',
                    'status_name',
                    'ar_sendCopyTo',
                    'ar_date_filed',
                    'ar_date_needed',
                    'ar_instruction'
                )
                ->orderByRaw('ar_activityDate DESC');

            if (!empty($startDate) && !empty($endDate)) {
                $DigiknowEngr = $DigiknowEngr->whereBetween('ar_activityDate', [$startDate, $endDate]);
            }
            if (!empty($engineers)) {
                $DigiknowEngr = $DigiknowEngr->whereIn('engr_name', (array) $engineers);
            }
        } elseif ($projectCategory == 'Maintain Projects') {
            $DigiknowEngr = tbl_project_list::leftjoin('tbl_business_unit as BU', 'tbl_project_list.business_unit_id', '=', 'BU.id')
                ->leftjoin('tbl_payment as payment', 'tbl_project_list.id', '=', 'payment.project_id')
                ->leftjoin('tbl_projectSignoff as Projsignoff', 'tbl_project_list.id', '=', 'Projsignoff.project_id')
                ->leftjoin('tbl_projectMember as ProjMember', 'tbl_project_list.id', '=', 'ProjMember.project_id')
                ->select(
                    'proj_code',
                    'proj_name',
                    'created_date',
                    'BU.business_unit as BusinessUnit',
                    'product_line',
                    'service_category',
                    'original_receipt',
                    'inv',
                    'mbs',
                    'po_number',
                    'so_number',
                    'ft_number',
                    'proj_startDate',
                    'proj_endDate',
                    'proj_amount',
                    'tbl_project_list.status as ProjListStatus',
                    'reseller',
                    'endUser',
                    'manday',
                    'payment.payment_status as Payment',
                    'Projsignoff.status as SignoffStatus',
                    'ProjMember.eng_name as Engineers',
                    'special_instruction',
                    'ProjMember.project_id as ProjId'
                );

            if (!empty($startDate) && !empty($endDate)) {

                $DigiknowEngr = $DigiknowEngr->whereBetween('proj_startDate', [$startDate, $endDate]);
            }
        }
        $DigiknowEngr = $DigiknowEngr->get();

        // Iterate through each result and apply the display format
        $DigiknowEngr->transform(function ($item, $key) {
            $item->take_display = $this->getTakeStatusDisplay($item->ar_takeStatus);
            return $item;
        });


        return response()->json($DigiknowEngr);
    }

    public function getTakeStatusDisplay($ar_takeStatus)
    {
        switch ($ar_takeStatus) {
            case '1':
                return "Take 1";
            case '2':
                return "Take 2";
            case 'nth':
                return "Nth Take";
            default:
                return "N/A";
        }
    }
}
