<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_pointSystem extends Model
{
    use HasFactory;

    protected $table = 'tbl_pointSystem';

    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'engineer',
        'details',
        'points',
        'amount',
        'defense',
        'status',
        'type',
        'created_date',
        'author',
        'approver',
        'approval_date'

    ];
        public function pointSystemEngr(){
            return $this->hasMany(tbl_engineers::class, 'engr_ar_id', 'id');
    }
}
