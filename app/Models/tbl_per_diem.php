<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_per_diem extends Model
{
    // public $timestamps = false;
    protected $table = 'tbl_per_diem';

    protected $primaryKey = 'perDiem_id';
    protected $fillable = [
        'perDiem_currency',
        'perDiem_rate',
        'perDiem_days',
        'perDiem_pax',
        'group',
        'proj_ref_id',
        'hash',
        'perDiem_total'];
        
    use HasFactory;
}
