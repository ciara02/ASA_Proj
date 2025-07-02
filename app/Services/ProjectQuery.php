<?php

namespace App\Services;

use App\Models\tbl_project_list;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectQuery extends Model
{
    use HasFactory;

    protected const connection = 'oracle';

    public function get_ERPprojects($term)
    {
        // Retrieve unique project codes from the database
        $existingCodes = tbl_project_list::pluck('proj_code')->unique()->filter(function($value) {
            return !empty($value) && $value !== 'N/A';
        })->toArray();
    
        // Create a comma-separated list of unique existing codes
        $existingCodesList = count($existingCodes) > 0 ? "'" . implode("','", $existingCodes) . "'" : "''";
    
        // Log the existing codes list for debugging
        Log::info('Filtered Existing Codes List: ' . $existingCodesList);
    
        $erpProjectCode = "SELECT LOOKUP_CODE AS code
                           FROM FND_LOOKUP_VALUES_VL
                           WHERE LOOKUP_TYPE = 'MSI TPS PROJECTS'
                           AND LOOKUP_CODE LIKE '%$term%'
                           AND LOOKUP_CODE NOT IN ($existingCodesList)
                           ORDER BY code ASC";
    
        // Log the final query for debugging
        Log::info('ERP Project Code Query: ' . $erpProjectCode);
    
        try {
            return DB::connection(self::connection)->select($erpProjectCode);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error executing ERP Project Code Query: ' . $e->getMessage());
            return [];
        }
    }
    


    public function get_ERP_BusinessUnit($term)
    {
        // Convert the search term to lowercase
        $term = strtolower($term);
    
        $erpBusinessUnit = "SELECT DISTINCT a.flex_value, a.description
                            FROM fnd_flex_values_vl A, fnd_flex_value_sets b
                            WHERE A.flex_value_set_id = b.flex_value_set_id
                            AND flex_value_set_name = 'MSI_DFF_BUSINESS UNIT'
                            AND A.ENABLED_FLAG = 'Y'
                            AND (LOWER(a.flex_value) LIKE '%$term%')
                            ORDER BY a.flex_value";
    
        return DB::connection(self::connection)->select($erpBusinessUnit);
    }
    

    public function getBusinessUnitId($flexValue)
    {
        $query = "SELECT a.id 
              FROM fnd_flex_values_vl a
              JOIN fnd_flex_value_sets b ON a.flex_value_set_id = b.flex_value_set_id
              WHERE b.flex_value_set_name = 'MSI_DFF_BUSINESS UNIT'
              AND a.flex_value = :flex_value
              AND a.ENABLED_FLAG = 'Y'";

        $result = DB::connection(self::connection)->select($query, ['flex_value' => $flexValue]);

        if (!empty($result)) {
            return $result[0]->id;
        }

        return null;
    }
}
