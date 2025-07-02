<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_misc_fee extends Model
{
    // public $timestamps = false;
    protected $table = 'tbl_misc_fee';

    protected $primaryKey = 'misc_id';
    protected $fillable = [
        'misc_particulars',
        'misc_pax',
        'misc_amount',
        'group',
        'proj_ref_id',
        'hash',
        'misc_total'];
        
    use HasFactory;
}
