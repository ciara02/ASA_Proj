<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_exam_list extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_exam_list';

    protected $primaryKey = 'exam_id';

    protected $fillable = ['exam_name'];
    use HasFactory;
}
