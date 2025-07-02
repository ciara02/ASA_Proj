<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_productLine extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_productLine';
    use HasFactory;

    protected $primaryKey = 'ar_id';
    protected $fillable = ['ProductLine, ProductCode'];

    public function prod_line()
    {
        return $this->hasOne(tbl_productLine::class, 'ar_id', 'ar_id');
    }



}
