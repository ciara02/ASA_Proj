<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import the Log facade

class ProductLineQuery extends Model
{
   protected const connection = 'oracle';

   public function getProductLine()
   {

      $sql = "SELECT flex_value_id,
    flex_value, 
    A.description,
    attribute1,
    attribute2,------------ MSI_DFF_BUSINESS,
    attribute3,------------- MSI_DFF_TYPE,
    attribute4,------------ MSI_DFF_BUSINESS_UNIT,
    attribute5,--------- MSI_DFF_BUSINESS_GROUP
    attribute6--------- pm_llb
   FROM fnd_flex_values_vl A, fnd_flex_value_sets b
   WHERE     A.flex_value_set_id = b.flex_value_set_id
   AND flex_value_set_name = 'MSI_Product_Line'
   AND enabled_flag = 'Y'
   ORDER BY DESCRIPTION ASC";

      // log::info($sql);die;
      // echo $sql;die;
      return DB::connection(self::connection)->select($sql);
   }

   public function searchProductLines($term)
{
   // Convert the search term to lowercase
   $term = strtolower($term);
   
   $sql = "SELECT flex_value_id,
                  flex_value, 
                  A.description,
                  attribute1,
                  attribute2 AS MSI_DFF_BUSINESS,
                  attribute3 AS MSI_DFF_TYPE,
                  attribute4 AS MSI_DFF_BUSINESS_UNIT,
                  attribute5 AS MSI_DFF_BUSINESS_GROUP,
                  attribute6 AS pm_llb
           FROM fnd_flex_values_vl A, fnd_flex_value_sets b
           WHERE A.flex_value_set_id = b.flex_value_set_id
           AND flex_value_set_name = 'MSI_Product_Line'
           AND enabled_flag = 'Y'
           AND (LOWER(flex_value) LIKE '%$term%' OR LOWER(A.description) LIKE '%$term%')
           ORDER BY A.description ASC";

   return DB::connection(self::connection)->select($sql);
}



   public function getProductCode($productName)
   {
      $sql = "SELECT A.flex_value
      FROM fnd_flex_values_vl A
      JOIN fnd_flex_value_sets B ON A.flex_value_set_id = B.flex_value_set_id
      WHERE A.description = :productName
      AND B.flex_value_set_name = 'MSI_Product_Line'
      AND A.enabled_flag = 'Y'";

      $result = DB::connection(self::connection)
         ->select($sql, ['productName' => $productName]);

      if (!empty($result)) {
         return $result[0]->flex_value;
      } else {
         return null; // Return null if product code not found
      }
   }

   public function getProductName($productCode)
   {
      $sql = "SELECT A.description
            FROM fnd_flex_values_vl A
            JOIN fnd_flex_value_sets B ON A.flex_value_set_id = B.flex_value_set_id
            WHERE A.flex_value = :productCode
            AND B.flex_value_set_name = 'MSI_Product_Line'
            AND A.enabled_flag = 'Y'";

      $result = DB::connection(self::connection)
         ->select($sql, ['productCode' => $productCode]);

      if (!empty($result)) {
         return $result[0]->description;
      } else {
         return null; // Return null if product name not found
      }
   }
}
