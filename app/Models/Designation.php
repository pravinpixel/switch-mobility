<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    use HasFactory,SoftDeletes;

    public function employee()
    {
        return $this->hasMany('App\Models\Employee', 'designation_id', 'id');
    }
}
