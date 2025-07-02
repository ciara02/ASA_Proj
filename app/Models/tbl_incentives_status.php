<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_incentives_status extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_incentives_status';

    protected $primaryKey = 'incStatus_id';

    protected $fillable = ['incStatus_name'];
    use HasFactory;
}
