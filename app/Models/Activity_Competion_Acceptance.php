<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_Competion_Acceptance extends Model
{
    use HasFactory;

    protected $table = 'tbl_activityReport';
    protected $primaryKey = 'ar_id';

    private function getNameMappings()
    {
        return [
            'Jon Oliquino' => ['Jon Oliquino', 'Jonel Oliquino']
        ];
    }
    public static function searchCompletionAcceptanceReport($startDate = null, $endDate = null, $engineerName = null)
    {
        $query = self::baseQuery();
    
        // Apply date range filter if provided
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('tbl_activityReport.ar_activityDate', [$startDate, $endDate]);
        }
    
        // Apply engineer name filter if provided
        if (!empty($engineerName)) {
            $nameMappings = self::getNameMappings();  // Use the name mapping function
    
            // Handle cases where $engineerName is an array
            if (is_array($engineerName)) {
                $allNamesToSearch = [];
                foreach ($engineerName as $name) {
                    // Add both the original and mapped names
                    $allNamesToSearch[] = $name;
                    if (isset($nameMappings[$name])) {
                        $allNamesToSearch = array_merge($allNamesToSearch, $nameMappings[$name]);
                    }
                }
    
                // Remove duplicates and search for names
                $query->whereIn('tbl_engineers.engr_name', array_unique($allNamesToSearch));
            } else {
                // Handle single name search
                $allNamesToSearch = [$engineerName];
                if (isset($nameMappings[$engineerName])) {
                    $allNamesToSearch = array_merge($allNamesToSearch, $nameMappings[$engineerName]);
                }
    
                // Apply LIKE search for flexible matching
                $query->where(function ($subquery) use ($allNamesToSearch) {
                    foreach (array_unique($allNamesToSearch) as $name) {
                        // Normalize the name to account for variations (e.g., diacritics, spelling)
                        $normalizedEngineerName = self::removeDiacritics(strtolower($name));
    
                        // Flexible LIKE search (case-insensitive)
                        $subquery->orWhere('tbl_engineers.engr_name', 'LIKE', '%' . $name . '%');
                        
                        // Exact match search
                        $subquery->orWhereRaw("LOWER(tbl_engineers.engr_name) = ?", [$normalizedEngineerName]);
    
                        // Handle variations (like ñ) by adding strict checks
                        if (stripos($normalizedEngineerName, 'n') !== false) {
                            $variationWithTilde = str_replace('n', 'ñ', $normalizedEngineerName);
                            $subquery->orWhereRaw("LOWER(tbl_engineers.engr_name) = ?", [$variationWithTilde]);
                        }
                    }
                });
            }
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
 

    public static function getLimitedCompletionAcceptanceReport()
    {
        return self::baseQuery()->take(100)->get();
    }

    protected static function baseQuery()
    {
        return self::leftjoin('tbl_activityAcceptance', 'tbl_activityReport.ar_id', '=', 'tbl_activityAcceptance.aa_activity_report')
            ->leftjoin('tbl_activityAcceptanceApproval', 'tbl_activityAcceptance.aa_id', '=', 'tbl_activityAcceptanceApproval.aaa_id')
            ->leftjoin('tbl_engineers', 'tbl_activityReport.ar_id', '=', 'tbl_engineers.engr_ar_id')
            ->leftjoin('tbl_report_list', 'tbl_activityReport.ar_report', '=', 'tbl_report_list.report_id')
            ->leftjoin('tbl_activityType_list', 'tbl_activityReport.ar_activityType', '=', 'tbl_activityType_list.type_id')
            ->leftjoin('tbl_productLine', 'tbl_activityReport.ar_id', '=', 'tbl_productLine.ar_id')
            ->leftjoin('tbl_project_list', 'tbl_activityReport.ar_project', '=', 'tbl_project_list.id')
            ->select(
                'tbl_activityReport.ar_id',
                'tbl_activityReport.ar_activityDate',
                'tbl_activityReport.ar_activityDone',
                'tbl_activityReport.ar_resellers_contact',
                'tbl_activityReport.ar_endUser_contact',
                'tbl_project_list.rs_contact',
                'tbl_project_list.eu_contact',
                'tbl_project_list.proj_name',
                'tbl_engineers.engr_name',
                'tbl_activityReport.ar_refNo',
                'tbl_activityReport.ar_activity',
                'tbl_activityReport.ar_resellers',
                'tbl_activityReport.ar_endUser',
                'tbl_report_list.report_name',
                'tbl_activityType_list.type_name',
                'tbl_activityAcceptance.aa_status',
                'tbl_activityAcceptance.aa_created_by',
                'tbl_activityAcceptance.aa_date_created',
                'tbl_productLine.ProductLine',
                
            )
            ->whereNotNull('tbl_activityAcceptance.aa_activity_report');
    }

    public function getAaStatusAttribute()
    {
        switch ($this->attributes['aa_status']) {
            case 1:
                return 'Draft';
            case 2:
                return 'For Approval';
            case 3:
                return 'Approved';
            case 4:
                return 'Disapproved';
            default:
                return '';
        }
    }
    
}
