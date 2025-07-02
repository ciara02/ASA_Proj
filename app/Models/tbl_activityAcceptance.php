<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_activityAcceptance extends Model
{
    protected $table = 'tbl_activityAcceptance';
    protected $primaryKey = 'aa_id';
    use HasFactory;
    public $timestamps = false;

    public function Approval()
    {
        return $this->belongsTo(tbl_activityAcceptanceApproval::class, 'aa_id', 'aaa_activityAcceptance');
    }

    //Activity Completion Acceptance Approver

    public function Approver()
    {
        return $this->belongsTo(tbl_activityAcceptanceApproval::class, 'aa_id', 'aaa_activityAcceptance');
    }
}
