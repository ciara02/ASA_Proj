<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_attachments extends Model
{

    public $timestamps = false;
    protected $table = 'tbl_attachments';

    protected $primaryKey = 'att_id';
    protected $fillable = ['att_ar_id, att_name'];
    use HasFactory;
}
