<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class tbl_activityReport extends Model
{
    public $timestamps = false;
    protected $fillable = [
        // Add other fillable attributes here
        'ar_id',
        'ar_refNo',
        'ar_requester',
        'ar_date_filed',
        'ar_date_needed',
        'ar_activity',
        'ar_instruction',
        'ar_sendCopyTo',
        'ar_resellers',
        'ar_resellers_contact',
        'ar_resellers_phoneEmail',
        'ar_endUser',
        'ar_endUser_contact',
        'ar_endUser_loc',
        'ar_activityDate',
        'ar_timeReported',
        'ar_timeExited',
        'ar_productLine',
        'ar_productCode',
        'ar_timeExpected',
        'ar_venue',
        'ar_activityType',
        'ar_program',
        'ar_venue',
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
        'ar_project',
        'ar_compPercent',
        'ar_perfectAtt',
        'ar_memoIssued',
        'ar_memoDetails',
        'ar_feedbackEngr',
        'ar_rating',
        'ar_dateStart',
        'ar_dateEnd',

    ];
    protected $table = 'tbl_activityReport';
    protected $primaryKey = 'ar_id';
    use HasFactory;

    //Activity Report Engineer
    public function act_reportEngr()
    {
        return $this->belongsTo(tbl_engineers::class, 'ar_id', 'engr_ar_id');
    }
    //End of Activity Report Engineer

    public function engr()
    {
        return $this->belongsTo(tbl_engineers::class, 'engr_ar_id', 'ar_id');
    }


    public function timeFrom()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeReported', 'key_id');
    }

    public function timeTo()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeExited', 'key_id');
    }


    public function category()
    {

        return $this->belongsTo(tbl_report_list::class, 'ar_report', 'report_id');
    }

    public function activitytype()
    {
        return $this->belongsTo(tbl_activityType_list::class, 'ar_activityType', 'type_id');
    }

    public function prod_line()
    {

        return $this->belongsTo(tbl_productLine::class, 'ar_id', 'ar_id');
    }

    public function statustype()
    {
        return $this->belongsTo(tbl_status_list::class, 'ar_status', 'status_id');
    }

    public function productLines()
    {
        return $this->hasMany(tbl_productLine::class, 'ar_id', 'ar_id');
    }

    // Mandays Relationship
    public function projectname()
    {
        return $this->belongsTo(tbl_project_list::class, 'ar_project', 'id');
    }

    public function MandayEngr()
    {
        return $this->hasMany(tbl_engineers::class, 'engr_ar_id', 'ar_id');
    }

    public function MandaytimeFrom()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeReported', 'key_id');
    }

    public function MandaytimeTo()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeExited', 'key_id');
    }

    //Activity Completion Acceptance Relationship

    public function ActCompletionEngr()
    {
        return $this->belongsTo(tbl_engineers::class, 'ar_id', 'engr_ar_id');
    }

    public function ActCompletioncategory()
    {
        return $this->belongsTo(tbl_report_list::class, 'ar_report', 'report_id');
    }

    public function ActCompletionActivityType()
    {
        return $this->belongsTo(tbl_activityType_list::class, 'ar_activityType', 'type_id');
    }

    public function ActCompletionproductLines()
    {
        return $this->belongsTo(tbl_productLine::class, 'ar_id', 'ar_id');
    }

    public function ActCompletionStatus()
    {

        return $this->belongsTo(tbl_activityAcceptance::class, 'ar_id', 'aa_activity_report');
    }

    public function actCompletionProjectList()
    {
        return $this->belongsTo(tbl_project_list::class, 'ar_project', 'id');
    }

    //Activity Completion Approver Relationship


    public function ActivityAcceptance()
    {

        return $this->belongsTo(tbl_activityAcceptance::class, 'ar_id', 'aa_activity_report');
    }

    // Reports Manday

    // Mandays Relationship

    public function Getprojectname()
    {
        return $this->belongsTo(tbl_project_list::class, 'ar_project', 'id');
    }

    public function GetMandayEngr()
    {
        return $this->belongsTo(tbl_engineers::class, 'ar_id', 'engr_ar_id');
    }

    public function GetMandaytimeFrom()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeReported', 'key_id');
    }

    public function GetMandaytimeTo()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeExited', 'key_id');
    }


    ///Experience Center

    public function engr_ExpCenter()
    {
        return $this->belongsTo(tbl_engineers::class, 'ar_id', 'engr_ar_id');
    }

    public function program_ExpCenter()
    {
        return $this->belongsTo(tbl_program_list::class, 'ar_program', 'program_id');
    }
    public function productLine_ExpCenter()
    {
        return $this->belongsTo(tbl_productLine::class, 'ar_id', 'ar_id');
    }
    public function status_ExpCenter()
    {
        return $this->belongsTo(tbl_status_list::class, 'ar_status', 'status_id');
    }

    public function activity_report_ExpCenter()
    {
        return $this->belongsTo(tbl_activityType_list::class, 'ar_activityType', 'type_id');
    }
    public function timeReported_ExpCenter()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeReported', 'key_id');
    }
    public function timeExited_ExpCenter()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeExited', 'key_id');
    }
    public function timeExpected_ExpCenter()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeExpected', 'key_id');
    }
    public function participants_ExpCenter()
    {
        return $this->belongsTo(tbl_participants::class, 'ar_id', 'ar_id');
    }
    public function productLineList()
    {
        return $this->hasMany(tbl_productLine::class, 'ar_id', 'ar_id');
    }
    public function manyEngineers()
    {
        return $this->hasMany(tbl_engineers::class, 'engr_ar_id', 'ar_id');
    }
     public function manyparticipants_ExpCenter()
    {
        return $this->hasMany(tbl_participants::class, 'ar_id', 'ar_id');
    }
    public function actionPlan_ExpCenter(){
        return $this->belongsTo(tbl_actionPlan::class, 'ar_id', 'ar_id');
    }
    public function manyactionPlan_ExpCenter(){
        return $this->hasMany(tbl_actionPlan::class, 'ar_id', 'ar_id');
    }
    public function attachment_ExpCenter(){
     return $this->belongsTo(tbl_attachments::class, 'ar_id', 'att_ar_id');
    }

    // DigiKnow Per Engineer
    public function digiEngr(){
        return $this->hasMany(tbl_engineers::class, 'engr_ar_id', 'ar_id');
    }
   

////////////////// Completion Acceptance /////////////////////////////////////////////////

    public static function getCompletionAcceptance($refNo)
    {
        return self::leftjoin('tbl_project_list', 'tbl_activityReport.ar_project', '=', 'tbl_project_list.id')
        ->select(
                'ar_id',
                'ar_refNo',
                'ar_date_filed',
                'ar_requester',
                'ar_resellers',
                'ar_resellers_contact',
                'ar_activityDate',
                'ar_endUser',
                'ar_endUser_contact',
                'ar_activity',
                'ar_activityDone',
                'proj_name'
            )
            ->where('tbl_activityReport.ar_refNo', '=', $refNo)
            ->first();

    }

     ///////////////////////////// Activity Report  //////////////////////////////////////////////
     private function getNameMappings()
     {
         return [
             'Jon Oliquino' => ['Jon Oliquino', 'Jonel Oliquino']
         ];
     }
     
 
     public function searchActivityReport($startDate, $endDate, $engineerNames)
     {
         $query = $this->leftJoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
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
                 DB::raw("(
                     SELECT STUFF(
                         (SELECT ', ' + eng.engr_name 
                          FROM tbl_engineers eng 
                          WHERE eng.engr_ar_id = tbl_activityReport.ar_id 
                          FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 
                     1, 1, '') 
                 ) as EngrNames"),
                 'tr.key_time as time_reported',
                 't_exited.key_time as time_exited',
                 'report_name',
                 'type_name',
                 DB::raw("(SELECT STUFF((SELECT ',' + pl.ProductLine 
                                         FROM tbl_productLine pl 
                                         WHERE pl.ar_id = tbl_activityReport.ar_id 
                                         FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '')) as ProductLine"),
                 'ar_activity',
                 'ar_resellers',
                 'ar_venue',
                 'status_name',
                 'program_name'
             )
             ->orderByRaw('YEAR(ar_activityDate) DESC')
             ->orderByRaw('MONTH(ar_activityDate) DESC')
             ->orderByRaw('DAY(ar_activityDate) DESC')
             ->orderBy('ar_activity', 'ASC');
     
         if (!empty($startDate) && !empty($endDate)) {
             $query->whereBetween('ar_activityDate', [$startDate, $endDate]);
         }
     
         if (!empty($engineerNames)) {
            $engineerNames = is_array($engineerNames) ? $engineerNames : explode(',', $engineerNames);
            $nameMappings = $this->getNameMappings();
        
            $allNamesToSearch = [];
            foreach ($engineerNames as $name) {
                $name = trim($name);
                $name = mb_convert_encoding($name, 'UTF-8', 'UTF-8');
                $allNamesToSearch[] = $name;
        
                if (isset($nameMappings[$name])) {
                    foreach ($nameMappings[$name] as $mapped) {
                        $mapped = mb_convert_encoding($mapped, 'UTF-8', 'UTF-8');
                        $allNamesToSearch[] = $mapped;
                    }
                }
            }
        
            $query->where(function ($subquery) use ($allNamesToSearch) {
                foreach ($allNamesToSearch as $name) {
                    $variants = [];
                    $normalized = $this->removeDiacritics($name);
        
                    $variants[] = $name;
                    $variants[] = $normalized;
        
                    if (str_contains($name, 'n') || str_contains($name, 'ñ')) {
                        $variants[] = str_replace('n', 'ñ', $name);
                        $variants[] = str_replace('ñ', 'n', $name);
                    }
        
                    foreach (array_unique($variants) as $v) {
                        $v = mb_convert_encoding($v, 'UTF-8', 'UTF-8');
        
                        $subquery->orWhereRaw("LOWER(tbl_engineers.engr_name) LIKE ?", ['%' . mb_strtolower($v, 'UTF-8') . '%']);
                        $subquery->orWhereRaw("tbl_engineers.engr_name COLLATE Latin1_General_BIN2 LIKE ?", ['%' . $v . '%']);
                    }
                }
            });
        
            Log::info('Names to search: ' . implode(', ', $allNamesToSearch));
        }
        
     
         return $query->get();
     }     
     
     
     
     
     
     /**
      * Remove diacritics from a string.
      *
      * @param string $str
      * @return string
      */
     private function removeDiacritics($str)
     {
         $diacritics = [
             'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n',
             'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ñ' => 'N',
             'ü' => 'u', 'ö' => 'o', 'ä' => 'a', 'ß' => 'ss'
         ];
     
         return strtr($str, $diacritics);
     }

     
     
    ///////////////////////////// Experience Center //////////////////////////////////////////////

    public static function getDashboardData()
    {
        // return Cache::remember('experience_dashboard', 60, function () {
        $experience = self::with(
            'engr_ExpCenter', 
            'program_ExpCenter', 
            'productLine_ExpCenter', 
            'status_ExpCenter', 
            'activity_report_ExpCenter', 
            'timeReported_ExpCenter', 
            'timeExited_ExpCenter', 
            'timeExpected_ExpCenter', 
            'participants_ExpCenter', 
            'productLineList', 
            'manyEngineers', 
            'manyparticipants_ExpCenter', 
            'actionPlan_ExpCenter',
            'attachment_ExpCenter', 
            'manyactionPlan_ExpCenter'
        )->select(
            'ar_activityDate',
            'ar_id',
            'ar_refNo',
            'ar_program',
            'ar_status',
            'ar_resellers',
            'ar_activity',
            'ar_project',
            'ar_timeReported',
            'ar_timeExited',
            'ar_timeExpected',
            'ar_report',
            'ar_requester',
            'ar_examName',
            'ar_title',
            'ar_takeStatus',
            'ar_score',
            'ar_examType',
            'ar_activityType',
            'ar_incDetails',
            'ar_incStatus',
            'ar_incAmount',
            'ar_resellers_contact',
            'ar_endUser',
            'ar_endUser_contact',
            'ar_endUser_loc',
            'ar_resellers_phoneEmail',
            'ar_endUser_phoneEmail',
            'ar_venue',
            'ar_custRequirements',
            'ar_activityDone',
            'ar_agreements',
            'ar_owner',
            'ar_details',
            'ar_requester',
            'ar_date_filed',
            'ar_date_needed',
            'ar_instruction',
            'ar_sendCopyTo',
            'ar_POCproductModel',
            'ar_POCassetOrCode',
            'ar_POCdateStart',
            'ar_POCdateEnd',
            'ar_prodLearned',
            'ar_trainingName',
            'ar_location',
            'ar_speakers',
            'ar_attendeesBPs',
            'ar_attendeesEUs',
            'ar_attendeesMSI'
        )
        ->where('ar_program', 2)
        ->orderByRaw('YEAR(ar_activityDate) DESC, MONTH(ar_activityDate) DESC, DAY(ar_activityDate) DESC')
        ->get();

        $experience = $experience->map(function ($exp) {
            $exp->productLines = $exp->productLineList->pluck('ProductLine')->toArray();
            $exp->productCodes = $exp->productLineList->pluck('ProductCode')->toArray();
            $exp->engineers = $exp->manyEngineers->pluck('engr_name')->toArray();
            $exp->position = $exp->manyparticipants_ExpCenter->pluck('position')->toArray();
            $exp->participant = $exp->manyparticipants_ExpCenter->pluck('participant')->toArray();

            return $exp;
        });

        return $experience;

    // });


    }
   
    /////REPORT TAB

    public function report_Engr(){
        return $this->belongsTo(tbl_engineers::class, 'ar_id', 'engr_ar_id');
    }
    
    public function report_timeFrom()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeReported', 'key_id');
    }

    public function report_timeTo()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeExited', 'key_id');
    }

    public function report_timeExpected()
    {
        return $this->belongsTo(tbl_time_list::class, 'ar_timeExpected', 'key_id');
    }


    public function report_category()
    {

        return $this->belongsTo(tbl_report_list::class, 'ar_report', 'report_id');
    }

    public function report_activitytype()
    {
        return $this->belongsTo(tbl_activityType_list::class, 'ar_activityType', 'type_id');
    }

  public function report_statustype()
    {
        return $this->belongsTo(tbl_status_list::class, 'ar_status', 'status_id');
    }

    public function report_productLines()
    {
        return $this->belongsTo(tbl_productLine::class, 'ar_id', 'ar_id');
    }

    public function report_projectname()
    {
        return $this->belongsTo(tbl_project_list::class, 'ar_project', 'id');
    }

    public function report_program()
    {
        return $this->belongsTo(tbl_program_list::class, 'ar_program', 'program_id');
    }

    public function report_manyparticipants()
    {
        return $this->hasMany(tbl_participants::class, 'ar_id', 'ar_id');
    }

    public function report_incStatus()
    {
        return $this->belongsTo(tbl_incentives_status::class, 'ar_incStatus', 'incStatus_id');
    }
    public function report_incDetails()
    {
        return $this->belongsTo(tbl_incentives_details::class, 'ar_incDetails', 'incDetails_id');
    }
    public function report_examType()
    {
        return $this->belongsTo(tbl_exam_list::class, 'ar_examType', 'exam_id');
    }
}



