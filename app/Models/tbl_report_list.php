<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_report_list extends Model
{

    protected $table = 'tbl_report_list';
    use HasFactory;

    public function category()
    {
        
        return $this->hasOne(tbl_activityReport::class, 'report_id', 'ar_report');
    }
}
