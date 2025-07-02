<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_engineers extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_engineers';
    protected $primaryKey = 'engr_id';
    protected $fillable = ['engr_name, engr_ar_id'];
    use HasFactory;

    public function engr()
    {
        return $this->hasOne(tbl_activityReport::class, 'ar_id', 'engr_ar_id');
    }

    //DigiKnow Per Engr
    public function Act_Report()
    {
        return $this->hasMany(tbl_activityReport::class, 'ar_id', 'engr_ar_id');
    }
}
