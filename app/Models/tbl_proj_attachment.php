<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_proj_attachment extends Model
{

    
    public $timestamps = false;
    protected $table = 'tbl_proj_attachment';

    protected $primaryKey = 'id';
    protected $fillable = ['proj_id' ,'attachment'];
    
    use HasFactory;
}
