<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_actionPlan extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'PlanId';
    protected $fillable = ['PlanTargetDate, PlanDetails,PlanOwner'];
    protected $table = 'tbl_actionPlan';
    use HasFactory;
}
