<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_projectSignoffApproval extends Model
{
    protected $table = 'tbl_projectSignoffApproval';

    public $timestamps = false;
    protected $primaryKey = 'id';
       protected $fillable = [
           'company',
           'name',
           'position',
           'email_address',

       ];
    use HasFactory;
    public function getProjSignoffMany(){
        return $this->hasMany(tbl_projectSignoff::class, 'id', 'project_signoff_id');
    }
}
