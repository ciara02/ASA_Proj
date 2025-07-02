<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_digiKnow_flyer extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_digiKnow_flyer';

    protected $primaryKey = 'id';

    protected $fillable = ['ar_id', 'attachment'];
    use HasFactory;
}
