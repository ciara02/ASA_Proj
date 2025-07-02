<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_cashAdvance extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $table = 'tbl_cashAdvance';

    protected $fillable = ['cash_advance', 'project_id'];

    use HasFactory;
}
