<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_payment extends Model
{
    protected $table = 'tbl_payment';
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'project_id',
    ];
}
