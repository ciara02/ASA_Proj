<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_time_list extends Model
{
    protected $table = 'tbl_time_list';
    protected $primaryKey = 'key_id';
    protected $fillable = ['key_time'];
    use HasFactory;

    public function timeFrom()
    {
        return $this->hasOne(tbl_activityReport::class, 'key_id', 'ar_timeReported');
    }

    public function timeTo()
    {
        return $this->hasOne(tbl_activityReport::class, 'key_id', 'ar_timeExited');
    }
}
