<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workflow extends Model
{
    use HasFactory,SoftDeletes;

   
    public function workflowl()
    {
        return $this->hasMany('App\Models\Workflowlevels', 'workflow_id', 'id');
    }

    public function workflowEmployees()
    {
        return $this->hasMany('App\Models\WorkflowLevelDetail', 'workflow_id', 'id');
    }
}
