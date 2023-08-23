<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowLevelDetail extends Model
{
    use HasFactory;
    // protected $table = "workflow_levels";
    // protected $fillable = [
    //     'workflow_id',
    //     'levels',
    //     'approver_designation'
    // ];
    public function employeeData()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }
    public function workflowLevel()
    {
        return $this->hasOne('App\Models\WorkflowLevels', 'id', 'workflow_level_id');
    }
    public function workFlow()
    {
        return $this->hasOne('App\Models\Workflow', 'id', 'workflow_id');
    }
   
}
