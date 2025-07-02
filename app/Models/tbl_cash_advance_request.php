<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_cash_advance_request extends Model
{
    // public $timestamps = false;
    protected $table = 'tbl_cash_advance_request';

    protected $primaryKey = 'proj_id';
    protected $fillable = [
        'project_type',
        'status' , 
        'requested_by', 
        'requester_email', 
        'approver_email', 
        'approver_name', 
        'person_implementing', 
        'date_filed', 
        'reseller_name', 
        'proj_name', 
        'reseller_contact', 
        'reseller_location', 
        'reseller_email', 
        'date_start', 
        'date_end', 
        'enduser_name', 
        'enduser_contact', 
        'enduser_email', 
        'enduser_location', 
        'mandays', 
        'cost_manday', 
        'proj_cost', 
        'po_number',
        'so_number',
        'payment_status',
        'expenses', 
        'margin' , 
        'charged_to_margin' , 
        'charged_to_parked_funds' , 
        'charged_to_others' ,  
        'charged_others_input' ,  
        'division' ,  
        'division2' ,  
        'prod_line' ,  
        'expense_DigiOne' ,  
        'expense_marketingEvent' ,  
        'expense_travel' ,  
        'expense_training' ,  
        'expense_promos' ,  
        'expense_advertising' ,  
        'expense_freight' ,  
        'expense_representation' ,  
        'expense_others' ,  
        'expense_others_input' ,  
        'group' ,  
        'proj_ref_id',
        'grand_total'];
    use HasFactory;

    public function per_diem()
    {
        return $this->hasMany(tbl_per_diem::class, 'perDiem_id', 'proj_id');
    }
    public function transportation()
    {
        return $this->hasMany(tbl_transportation::class, 'transpo_id', 'proj_id');
    }
    
    public function accommodation()
    {
        return $this->hasMany(tbl_accomodation::class, 'accomodation_id', 'proj_id');
    }

    public function miscFee()
    {
        return $this->hasMany(tbl_misc_fee::class, 'misc_id', 'proj_id');
    }
}
