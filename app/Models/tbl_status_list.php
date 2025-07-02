<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_status_list extends Model
{

    protected $table = 'tbl_status_list';
    use HasFactory;


    public function statustype()
    {
         return $this->hasOne(tbl_activityReport::class, 'status_id', 'ar_status');
    }
}
