<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_activityReport;
use App\Models\tbl_project_list;
use App\Models\tbl_engineers;
use App\Models\tbl_project_type_list;
use Illuminate\Support\Facades\DB; 




class MandaysController extends Controller
{


    public function index(Request $request)
    {
        $engName = $request->query('engName');
        $projectId = $request->query('projectId');

       
        // return view('tab-manday.index', ['engName' => $engName, 'projectId' => $projectId]);
        return view('tab-manday.index', compact('engName', 'projectId'));
    }

    // public function getTotalMandays(Request $request)
    // {
    //     $engineerNames = $request->input('engineers');
    //     $ProjId = $request->input('projNameDropdown');

    //     // dd($engineerNames, $ProjId);

    //     $EngineerId = tbl_engineers::select('engr_ar_id')
    //     ->where(function ($query) use ($engineerNames) {
    //         foreach ($engineerNames as $name) {
    //             $query->orWhere('engr_name', 'like', '%' . $name . '%');
    //         }
    //     })
    //     ->pluck('engr_ar_id');
        
    //     // Convert $ProjId to an array if it's not already one
    //     if (!is_array($ProjId)) {
    //         $ProjId = [$ProjId];
    //     }

    //     $getTotalManday = tbl_activityReport::with('projectname', 'MandayEngr', 'MandaytimeFrom', 'MandaytimeTo')
    //         ->select(
    //             'ar_id',
    //             'ar_project',
    //             'ar_timeExited',
    //             'ar_timeReported'
    //         )
        
    //         ->when(!empty($engineerNames), function ($query) use ($engineerNames) {
    //             $query->whereHas('MandayEngr', function ($subquery) use ($engineerNames) {
    //                 $subquery->whereIn('engr_name', $engineerNames);
    //             });
    //         })

    //         ->when(!empty($ProjId), function ($query) use ($ProjId) {
    //             $query->whereIn('ar_project', $ProjId);
    //         })
    //         ->get();
           
    
    //     $totalMandaysAll = 0; 
    //     $engineerMandays = []; 

    //     foreach ($getTotalManday as $manday) {
    //         if (isset($manday->MandaytimeFrom) && isset($manday->MandaytimeTo)) {
    //             $MandaytimeFrom = $manday->MandaytimeFrom->key_timestamp;
    //             $MandaytimeTo = $manday->MandaytimeTo->key_timestamp;
        
    //             $MandaytimeFrom = strval($MandaytimeFrom);
    //             $MandaytimeTo = strval($MandaytimeTo);
        
    //             $durationInHours = (strtotime($MandaytimeTo) - strtotime($MandaytimeFrom)) / (60 * 60);
        
    //             // Calculate the duration in days
    //             $manday->durationInDays = $durationInHours / 8;
        
    //             // Add durationInDays to respective engineer's mandays
    //             $engineerName = $manday->MandayEngr->engr_name;
    //             if (!isset($engineerMandays[$engineerName])) {
    //                 $engineerMandays[$engineerName] = 0;
    //             }
    //             $engineerMandays[$engineerName] += $manday->durationInDays;
        
    //             // Add durationInDays to total mandays for all engineers
    //             $totalMandaysAll += $manday->durationInDays;
    //         }
    //     }
        
    //     // Create a new property to store the total mandays for all engineers
    //     $getTotalManday->totalMandaysAll = $totalMandaysAll;
        
    //     // Add a property to store the total mandays for each engineer
    //     $getTotalManday->engineerMandays = $engineerMandays;
        
    //     return view('tab-manday.index', compact('getTotalManday'));
        
    // }


    //   public function getTotalMandays(Request $request)
    // {
    //     $engineerNames = $request->input('engineers');

        
    //     $EngineerId = tbl_engineers::select('engr_ar_id')
    //     ->where(function ($query) use ($engineerNames) {
    //         foreach ($engineerNames as $name) {
    //             $query->orWhere('engr_name', 'like', '%' . $name . '%');
    //         }
    //     })
    //     ->pluck('engr_ar_id');

    //     $GetEngineerManday = tbl_activityReport::leftJoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
    //     ->leftjoin('tbl_project_list', 'tbl_activityReport.ar_project', '=', 'tbl_project_list.id')
    //     ->leftJoin('tbl_time_list as reported_time', 'tbl_activityReport.ar_timeReported', '=', 'reported_time.key_id')
    //     ->leftJoin('tbl_time_list as exited_time', 'tbl_activityReport.ar_timeExited', '=', 'exited_time.key_id')
    //     ->select(
    //         'tbl_activityReport.ar_id',
    //         'tbl_activityReport.ar_timeExited',
    //         'tbl_activityReport.ar_timeReported',
    //         'tbl_project_list.proj_name',
    //         'reported_time.key_time as reported_key_time',
    //         'exited_time.key_time as exited_key_time',
    //         'reported_time.key_timestamp as reported_key_timestamp',
    //         'exited_time.key_timestamp as exited_key_timestamp',
            
    //         DB::raw('STUFF((SELECT \', \' + engr_name 
    //         FROM tbl_engineers 
    //         WHERE tbl_engineers.engr_ar_id = tbl_activityReport.ar_id 
    //         FOR XML PATH(\'\')), 1, 2, \'\') as engr_names'),
    //         DB::raw('(CAST(exited_time.key_timestamp AS FLOAT) / CAST(reported_time.key_timestamp AS FLOAT)) / 8 as manday')
    //     )
    //     ->whereIn('tbl_activityReport.ar_id', $EngineerId)
    //     ->groupBy(
    //         'tbl_activityReport.ar_id',
    //         'tbl_activityReport.ar_timeExited',
    //         'tbl_activityReport.ar_timeReported',
    //         'tbl_project_list.proj_name',
    //         'reported_time.key_time',
    //         'exited_time.key_time',
    //         'reported_time.key_timestamp',
    //         'exited_time.key_timestamp'
    //     )
    //     ->get();


    //     return view('tab-manday.index', compact('GetEngineerManday'));
    // }

    public function getTotalMandays(Request $request)
{
    $engineerNames = $request->input('engineers');

    $EngineerId = tbl_engineers::select('engr_ar_id')
        ->where(function ($query) use ($engineerNames) {
            foreach ($engineerNames as $name) {
                $query->orWhere('engr_name', 'like', '%' . $name . '%');
            }
        })
        ->pluck('engr_ar_id');

    $GetEngineerManday = tbl_activityReport::leftJoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
        ->leftJoin('tbl_project_list', 'tbl_activityReport.ar_project', '=', 'tbl_project_list.id')
        ->leftJoin('tbl_time_list as reported_time', 'tbl_activityReport.ar_timeReported', '=', 'reported_time.key_id')
        ->leftJoin('tbl_time_list as exited_time', 'tbl_activityReport.ar_timeExited', '=', 'exited_time.key_id')
        ->select(
            'tbl_activityReport.ar_id',
            'tbl_activityReport.ar_timeExited',
            'tbl_activityReport.ar_timeReported',
            'tbl_project_list.proj_name',
            'reported_time.key_time as reported_key_time',
            'exited_time.key_time as exited_key_time',
            'reported_time.key_timestamp as reported_key_timestamp',
            'exited_time.key_timestamp as exited_key_timestamp',
            DB::raw('STUFF((SELECT \', \' + engr_name 
                FROM tbl_engineers 
                WHERE tbl_engineers.engr_ar_id = tbl_activityReport.ar_id 
                AND engr_name IN (' . implode(',', array_map(function($name) {
                    return "'" . $name . "'";
                }, $engineerNames)) . ')
                FOR XML PATH(\'\')), 1, 2, \'\') as engr_names'),
                DB::raw('(CAST(exited_time.key_timestamp AS FLOAT) - CAST(reported_time.key_timestamp AS FLOAT)) / 8 as manday')
        )
        ->whereIn('tbl_activityReport.ar_id', $EngineerId)
        ->groupBy(
            'tbl_activityReport.ar_id',
            'tbl_activityReport.ar_timeExited',
            'tbl_activityReport.ar_timeReported',
            'tbl_project_list.proj_name',
            'reported_time.key_time',
            'exited_time.key_time',
            'reported_time.key_timestamp',
            'exited_time.key_timestamp'
        )
        ->get();

        // dd($GetEngineerManday);

    return view('tab-manday.index', compact('GetEngineerManday'));
}


    public function GetEngineers(Request $request)
    {
        $term = $request->input('term'); // Get the search term from the request

        $engineers = tbl_engineers::where('engr_name', 'like', "%$term%")
            ->distinct()
            ->orderBy('engr_name')
            ->pluck('engr_name');

        return response()->json(['data' => $engineers]);
    }

    public function GetProjName(Request $request)
    {
        $term = $request->input('term');

        $GetprojName = tbl_project_list::where('proj_name', 'like', "%$term%")
            ->distinct()
            ->orderBy('proj_name')
            ->pluck('proj_name');

        return response()->json(['data' => $GetprojName]);
    }
}
