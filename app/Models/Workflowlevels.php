<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflowlevels extends Model
{
    use HasFactory;
    protected $table = "workflow_levels";
      protected $fillable = [
        'workflow_id',
        'levels',
        'approver_designation'
    ];
    public function designationData()
    {
        return $this->hasOne('App\Models\Designation', 'id', 'approver_designation');
    }
    public function workflowLevelDetail()
    {
        return $this->hasMany('App\Models\WorkflowLevelDetail', 'workflow_level_id', 'id');
    }
   
}
