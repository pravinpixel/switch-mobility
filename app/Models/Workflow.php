<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

   
    public function workflowl()
    {
        return $this->hasMany('App\Models\Workflowlevels', 'workflow_id', 'id');
    }
}
