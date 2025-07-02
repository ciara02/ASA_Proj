<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_cash_advance_attachments extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_cash_advance_attachments';

    protected $primaryKey = 'id';
    protected $fillable = ['proj_id', 'attachment_file'];

    use HasFactory;
}
