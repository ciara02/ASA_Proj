<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class crud_model extends Model
{
    protected $table = 'tbl_activityReport';

    ////////////////////////// Activity Report Datatable Show Data /////////////////////////////////
    public static function ActivityReportFirst100($engrName)
    {
        return self::query()
            ->leftJoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
            ->leftJoin('tbl_report_list', 'tbl_activityReport.ar_report', '=', 'tbl_report_list.report_id')
            ->leftJoin('tbl_status_list', 'tbl_activityReport.ar_status', '=', 'tbl_status_list.status_id')
            ->leftJoin('tbl_time_list as tr', 'tbl_activityReport.ar_timeReported', '=', 'tr.key_id')
            ->leftJoin('tbl_time_list as t_exited', 'tbl_activityReport.ar_timeExited', '=', 't_exited.key_id')
            ->leftJoin('tbl_time_list as t_expected', 'tbl_activityReport.ar_timeExpected', '=', 't_expected.key_id')
            ->leftJoin('tbl_activityType_list', 'tbl_activityReport.ar_activityType', '=', 'tbl_activityType_list.type_id')
            ->leftJoin('tbl_program_list', 'tbl_activityReport.ar_program', '=', 'tbl_program_list.program_id')
            ->select(
                'ar_activityDate',
                'ar_date_filed',
                'ar_refNo',
                DB::raw("
                    (SELECT 
                        STUFF(
                            (SELECT ', ' + eng.engr_name 
                             FROM tbl_engineers eng 
                             WHERE eng.engr_ar_id = tbl_activityReport.ar_id 
                             FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 
                        1, 1, '') 
                    ) as EngrNames
                "),
                'engr_name',
                'tr.key_time as time_reported',
                't_exited.key_time as time_exited',
                'report_name',
                'type_name',
                DB::raw("
                    (SELECT 
                        STUFF(
                            (SELECT ', ' + pl.ProductLine 
                             FROM tbl_productLine pl 
                             WHERE pl.ar_id = tbl_activityReport.ar_id 
                             FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 
                        1, 1, '') 
                    ) as ProductLine
                "),
                'ar_activity',
                'ar_resellers',
                'ar_venue',
                'status_name',
                'program_name'
            )
            ->where('tbl_engineers.engr_name', '=', $engrName)
            ->whereDate('ar_activityDate', '>=', now()->subYears(2)->toDateString())
            ->orderBy('ar_activityDate', 'DESC')
            ->orderBy('ar_activity', 'ASC')
            ->get();
    }
    
    
    
}    
