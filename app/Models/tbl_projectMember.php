<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_projectMember extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_projectMember';
    protected $primaryKey = 'id';

    protected $fillable = ['eng_name' ,'eng_email', 'date_assigned','project_id'];
    use HasFactory;
}
