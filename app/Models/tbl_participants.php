<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_participants extends Model
{

    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $fillable = ['participant, position'];
    protected $table = 'tbl_participants';
    use HasFactory;
}
