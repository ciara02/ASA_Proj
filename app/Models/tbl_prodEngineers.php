<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_prodEngineers extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_prodEngineers';
    protected $primaryKey = 'prodEngr_id';
    protected $fillable = ['prodEngr_name, prodEngr_ar_id'];

    use HasFactory;

    
}
