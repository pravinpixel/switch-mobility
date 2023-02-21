<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    public function workflow()
    {
        return $this->hasOne('App\Models\Workflow', 'id', 'workflow_id');
    }
    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'initiator_id');
    }
    public function department()
    {
        return $this->hasOne('App\Models\department', 'id', 'initiator_id');
    }
}
