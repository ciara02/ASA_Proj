<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_accomodation extends Model
{
    // public $timestamps = false;
    protected $table = 'tbl_accomodation';

    protected $primaryKey = 'accomodation_id';
    protected $fillable = [
        'accom_hotel',
        'accom_rate',
        'accom_rooms',
        'accom_nights',
        'accom_amount',
        'group',
        'proj_ref_id',
        'hash',
        'accom_total'];
        
    use HasFactory;
}
