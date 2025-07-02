<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class tbl_project_list extends Model
{

    public $timestamps = false;

    protected $primaryKey = 'id';


    protected $table = 'tbl_project_list';

    protected $fillable = [
        'proj_code',
        'proj_startDate',
        'proj_endDate',
        'proj_name',
        'service_category',
        'created_by',
        'PM',
        'business_unit',
        'product_line',
        'inv',
        'mbs',
        'original_receipt',
        'manday',
        'manday_cost',
        'project_net',
        'proj_amount',
        'po_number',
        'so_number',
        'ft_number',
        'special_instruction',
        'reseller',
        'rs_contact',
        'rs_email',
        'endUser',
        'eu_contact',
        'eu_email',
        'eu_location',
        'status',
        'creator_email',
        'pm_email',
        'is_hidden'

    ];
    
    use HasFactory;

    public function project_type()
    {
        return $this->belongsTo(tbl_project_type_list::class, 'proj_type_id', 'id');
    }

    public function businessUnit()
    {
        return $this->belongsTo(tbl_business_unit::class, 'business_unit_id', 'id');
    }

    public function financial_status(){
        return $this->belongsTo(tbl_payment::class, 'id', 'project_id');
    }

    public function project_signoff(){
        return $this->belongsTo(tbl_projectSignoff::class, 'id', 'project_id');
    }

    public function doer_engineers(){
        return $this->hasMany(tbl_projectMember::class, 'project_id', 'id');
    }

    public function getproj_member() {
        return $this->hasOne(tbl_projectMember::class, 'project_id', 'id');
    }

    public function get_project_signoff() {
        return $this->hasOne(tbl_projectSignOff::class, 'project_id', 'id');
    }

    ////////////// Report Engineer Name ////////////////////////

    public function getProjMember(){
        return $this->hasMany(tbl_projectMember::class, 'project_id', 'id');
    }

    public function getTeamMember(){
        return $this->hasMany(tbl_projectMember::class, 'project_id', 'id');
    }

    public function cashAdvance(){
        return $this->hasOne(tbl_cashAdvance::class, 'project_id', 'id');
    }

    public function proj_attachments(){
        return $this->hasMany(tbl_proj_attachment::class, 'proj_id', 'id');
    }

    public function signOff_attachments(){
        return $this->hasMany(tbl_project_signoff_attachment::class, 'project_id', 'id');
    }

    public function cashRequest_status(){
        return $this->hasMany(tbl_cash_advance_request::class, 'proj_id', 'id');
    }

    public function getLatestCashRequestStatusAttribute()
    {
        return $this->cashRequest_status->sortByDesc('group')->first();
    }

     public function cashAdvance_attachments(){
        return $this->hasMany(tbl_cash_advance_attachments::class, 'proj_id', 'id');
    }
    ////////////////////////// Isupport Implementation and Maintenance Agreement Datatable Show Data /////////////////////////////////

    public function fetchImplementationProjects($projTypeId)
    {
        return $this->with('businessUnit', 'financial_status', 'project_signoff', 'doer_engineers', 'project_type', 'getTeamMember', 'cashAdvance', 'proj_attachments', 'signOff_attachments', 'cashRequest_status', 'cashAdvance_attachments')
        ->select(
            'proj_code',
            'proj_name',
            'created_date',
            'created_by',
            'business_unit_id',
            'business_unit',
            'product_line',
            'service_category',
            'original_receipt',
            'inv',
            'mbs',
            'po_number',
            'so_number',
            'ft_number',
            'proj_startDate',
            'proj_endDate',
            'proj_amount',
            'status',
            'reseller',
            'endUser',
            'manday',
            'id',
            'special_instruction',
            'proj_type_id',
            'PM',
            'manday_cost',
            'project_net',
            'rs_contact',
            'rs_email',
            'eu_contact',
            'eu_email',
            'eu_location',
            DB::raw("CASE 
            WHEN created_date IS NULL THEN 4 -- Null dates last
            WHEN YEAR(created_date) = YEAR(GETDATE()) THEN 1 -- Current year first
            WHEN YEAR(created_date) < YEAR(GETDATE()) THEN 2 -- Past years second
            WHEN YEAR(created_date) > YEAR(GETDATE()) THEN 3 -- Future years third
            ELSE 5 -- Any other case (unlikely)
        END AS order_priority")
        )
            ->where('proj_type_id', $projTypeId)
            ->where('is_hidden', 0)
            ->orderBy('order_priority', 'asc') // Custom order priority
            ->orderByRaw("YEAR(created_date) DESC, created_date DESC") // Ensure chronological order within priority
            ->orderBy('status', 'asc')
            ->orderBy('proj_name', 'asc')
            ->get()
            ->map(function ($project) {
                $status = optional($project->project_signoff)->status ?? null;
                $project->signoff = $this->convertStatusToWord($status);

                // Handle doer engineers
                $doerEngineers = $project->doer_engineers ?? collect([]);
                $project->stored_values = $doerEngineers->map(function ($engineer) {
                    return [
                        'engName' => $engineer->eng_name,
                    ];
                });

                return $project;
            });
    }
   


    private function convertStatusToWord($status)
    {
        switch ($status) {
            case 1:
                return 'Draft';
            case 2:
                return 'For Approval';
            case 3:
                return 'Approved';
            case 4:
                return 'Disapproved';
            default:
                return '';
        }
    }





}
