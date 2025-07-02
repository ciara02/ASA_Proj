<?php

namespace App\Http\Controllers;

use App\Models\LDAPEngineer;
use Illuminate\Http\Request;
use App\Models\tbl_activityReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CertificationController extends Controller
{
    public function fetchIncentives()
    {
        $incentives = tbl_activityReport::select(
            'ar_activityDate',
            'ar_examType',
            'engr_name',
            'exam_name',
            'ar_title',
            'ar_examName',
            'type_name',
            'ar_score',
            'ar_takeStatus',
            'incDetails_name',
            'incStatus_name',
            'engr_ar_id',
            DB::raw("(SELECT STUFF((SELECT ',' + pl.ProductLine 
            FROM tbl_productLine pl 
            WHERE pl.ar_id = tbl_activityReport.ar_id 
            FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '')) as ProductLine"),
            'ar_incAmount',
            'ar_productCode',
            'ar_refNo',
            'ar_program',
            'program_name',
            'report_name',
            'ar_report',
            'ar_status',
            'status_name',
            'att_name',
            'att_id',
            'ar_activity',
            'ar_venue',
            'tbl_activityReport.ar_id',
            'ar_sendCopyTo'
        )
            ->leftJoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
            ->leftJoin('tbl_activityType_list', 'tbl_activityReport.ar_activityType', '=', 'tbl_activityType_list.type_id ')
            ->leftJoin('tbl_exam_list', 'tbl_activityReport.ar_examType', '=', 'tbl_exam_list.exam_id ')
            ->leftJoin('tbl_report_list', 'tbl_activityReport.ar_report', '=', 'tbl_report_list.report_id ')
            ->leftJoin('tbl_incentives_details', 'tbl_activityReport.ar_incDetails', '=', 'tbl_incentives_details.incDetails_id ')
            ->leftJoin('tbl_incentives_status', 'tbl_activityReport.ar_incStatus', '=', 'tbl_incentives_status.incStatus_id ')
            ->leftJoin('tbl_program_list', 'tbl_activityReport.ar_program', '=', 'tbl_program_list.program_id')
            ->leftJoin('tbl_status_list', 'tbl_activityReport.ar_status', '=', 'tbl_status_list.status_id')
            ->leftJoin('tbl_attachments', 'tbl_activityReport.ar_id', '=', 'tbl_attachments.att_ar_id')
            ->leftJoin('tbl_productLine', 'tbl_activityReport.ar_id', '=', 'tbl_productLine.ar_id')
            ->whereIn('ar_activityType', [33, 34])
            ->orderByRaw('YEAR(tbl_activityReport.ar_activityDate) DESC,
            MONTH(tbl_activityReport.ar_activityDate) DESC, 
            DAY(tbl_activityReport.ar_activityDate) DESC')
            ->orderBy('tbl_activityReport.ar_incStatus', 'DESC')
            ->orderBy('tbl_engineers.engr_name', 'ASC')
            ->orderBy('tbl_productLine.ProductLine', 'ASC')
            ->get();

        return $incentives;
    }

    public function index() {
        $incentives = $this->fetchIncentives();
        $ldapUsername = Auth::user()->email;
    
        // Transform the email to match LDAP format (adjust this transformation based on your requirement)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email to ensure it's correct
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data for the currently logged-in user
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);

        return view('tab-certifications.certification', compact('incentives', 'ldapEngineer'));
    }

    public function print($columnOrder = null) {
        $incentives = $this->fetchIncentives();
        // Assuming $columnOrder is a comma-separated string, convert it to an array
        $columnOrderArray = explode(',', $columnOrder);
        // dd($columnOrderArray);
        return view('tab-certifications.print', compact('incentives', 'columnOrderArray'));
    }    
    
}
