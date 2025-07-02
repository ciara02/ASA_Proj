<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_project_signoff_attachment extends Model
{

    protected $table = 'tbl_project_signoff_attachment';
    public $timestamps = false;

    protected $primaryKey = 'id';
    use HasFactory;

}
