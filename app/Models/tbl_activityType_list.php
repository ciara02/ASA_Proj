<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_activityType_list extends Model
{

    public $timestamps = false;
    protected $table = 'tbl_activityType_list';
    use HasFactory;

    public function activitytype()
    {
        return $this->hasOne(tbl_activityReport::class, 'type_id', 'ar_activityType');
    }
}
