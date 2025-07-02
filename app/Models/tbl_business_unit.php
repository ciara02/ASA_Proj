<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_business_unit extends Model
{
    protected $table = 'tbl_business_unit';
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'id',
    ];

    
}
