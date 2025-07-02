<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_transportation extends Model
{
    // public $timestamps = false;
    protected $table = 'tbl_transportation';

    protected $primaryKey = 'transpo_id';
    protected $fillable = [
        'transpo_date',
        'transpo_description',
        'transpo_from',
        'transpo_to',
        'transpo_amount',
        'group',
        'proj_ref_id',
        'hash',
        'transpo_total'];
        
    use HasFactory;
}
