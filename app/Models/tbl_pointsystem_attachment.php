<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_pointsystem_attachment extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_pointsystem_attachment';

    protected $primaryKey = 'id';
    protected $fillable = ['ps_att_id, ps_att_name'];

    use HasFactory;
}
