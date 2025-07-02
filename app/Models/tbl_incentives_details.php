<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_incentives_details extends Model
{
    protected $table = 'tbl_incentives_details';
    protected $primaryKey = 'incDetails_id';
    use HasFactory;
}
