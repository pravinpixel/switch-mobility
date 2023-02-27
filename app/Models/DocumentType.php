<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentType extends Model
{
    use HasFactory,SoftDeletes;  
    public function workflow()
    {
        return $this->hasOne(Workflow::class, 'id', 'workflow_id');
    }
}
