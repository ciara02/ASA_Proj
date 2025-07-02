<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_activityAcceptanceApproval extends Model
{
    protected $table = 'tbl_activityAcceptanceApproval';
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'aaa_id';

    protected $fillable = [
        'aaa_activityAcceptance', // Add this line
        'aaa_email',
        'aaa_name',
        'aaa_company',
        'aaa_position',
        'aaa_status',
    ];
    
}


