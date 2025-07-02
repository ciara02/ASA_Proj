<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_copyTo extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_copyTo';

    protected $primaryKey = 'copy_id';

    protected $fillable = ['copy_name', 'copy_email'];
    use HasFactory;
}
