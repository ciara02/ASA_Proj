<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class tbl_projectSignOff extends Model
{

    public $timestamps = false;
    protected $table = 'tbl_projectSignoff';
 
    protected $primaryKey = 'id';
    protected $fillable = [
        'deliverables'
    ];
    use HasFactory;

    public function getProjSignoffApprovers(){
        return $this->hasMany(tbl_projectSignoffApproval::class, 'project_signoff_id', 'id');
    }

    private function getNameMappings()
     {
         return [
             'Jon Oliquino' => ['Jon Oliquino', 'Jonel Oliquino']
         ];
     }
     public function projectSignOffSearch($dateFrom, $dateTo, $engineers)
     {
         $ldapUsername = Auth::user()->email;
     
         // Transform the email to match LDAP format (if needed)
         $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
     
         // Log the transformed email for debugging
         Log::info('Transformed email for LDAP search: ' . $ldapUsername);
     
         // Fetch the LDAP user data
         $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);
     
         // You can add additional filtering here if you need to use LDAP information
         $ldapEngineerName = $ldapEngineer ? $ldapEngineer->name : null;
     
         return $this->select(
                 'tbl_project_list.*',
                 'tbl_project_list.id',
                 'tbl_business_unit.business_unit',
                 'tbl_projectSignoff.date_created',
                 'tbl_projectSignoff.deliverables',
                 'tbl_project_signoff_attachment.attachment',
                 DB::raw("STUFF((SELECT ', ' + eng_name
                     FROM tbl_projectMember
                     WHERE project_id = tbl_project_list.id
                     FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, ' ') AS ProjectMember"),
                 'tbl_projectSignoff.status'
             )
             ->leftJoin('tbl_project_list', 'tbl_project_list.id', '=', 'tbl_projectSignoff.project_id')
             ->leftJoin('tbl_business_unit', 'tbl_project_list.business_unit_id', '=', 'tbl_business_unit.id')
             ->leftJoin('tbl_project_signoff_attachment', 'tbl_project_signoff_attachment.project_id', '=', 'tbl_projectSignoff.project_id')
             ->when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                 $query->whereDate('tbl_projectSignoff.date_created', '>=', $dateFrom)
                       ->whereDate('tbl_projectSignoff.date_created', '<=', $dateTo);
             })
             ->when($engineers, function ($query) use ($engineers, $ldapEngineerName) {
                 $nameMappings = $this->getNameMappings();  // Use the name mapping function
     
                 // Generate all possible names to search
                 $allNamesToSearch = [];
                 foreach ((array) $engineers as $engineer) {
                     $allNamesToSearch[] = $engineer;
                     if (isset($nameMappings[$engineer])) {
                         $allNamesToSearch = array_merge($allNamesToSearch, $nameMappings[$engineer]);
                     }
                 }
     
                 // Optionally, add LDAP engineer name to the search criteria
                 if ($ldapEngineerName) {
                     $allNamesToSearch[] = $ldapEngineerName;
                 }
     
                 // Apply the search with mapped names
                 $query->whereIn('tbl_projectSignoff.project_id', function ($subquery) use ($allNamesToSearch) {
                     $subquery->select('project_id')
                         ->from('tbl_projectMember')
                         ->where(function ($subquery) use ($allNamesToSearch) {
                             foreach (array_unique($allNamesToSearch) as $name) {
                                 // Normalize the name to account for variations (e.g., diacritics, spelling)
                                 $normalizedEngineerName = $this->removeDiacritics(strtolower($name));
     
                                 // Flexible LIKE search (case-insensitive)
                                 $subquery->orWhere('eng_name', 'LIKE', '%' . $name . '%');
                                 
                                 // Exact match search
                                 $subquery->orWhereRaw("LOWER(eng_name) = ?", [$normalizedEngineerName]);
     
                                 // Handle variations (like ñ) by adding strict checks
                                 if (stripos($normalizedEngineerName, 'n') !== false) {
                                     $variationWithTilde = str_replace('n', 'ñ', $normalizedEngineerName);
                                     $subquery->orWhereRaw("LOWER(eng_name) = ?", [$variationWithTilde]);
                                 }
                             }
                         });
                 });
             })
             ->get();
     }
    private function removeDiacritics($str)
      {
          $diacritics = [
              'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n',
              'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ñ' => 'N',
              'ü' => 'u', 'ö' => 'o', 'ä' => 'a', 'ß' => 'ss'
          ];
      
          return strtr($str, $diacritics);
      }
}

     /**
      * Remove diacritics from a string.
      *
      * @param string $str
      * @return string
      */
      
