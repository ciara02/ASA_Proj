<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_project_type_list extends Model
{
    protected $table = 'tbl_project_type_list';
    use HasFactory;

    public function proj_type()
    {
        return $this->hasOne(tbl_project_list::class, 'proj_type_id', 'id');
    }

    // protected $fillable = ['id', 'name'];


}
