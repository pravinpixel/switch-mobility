<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLevels extends Model
{
    use HasFactory;
    public function projectDocument()
    {
        return $this->hasMany(projectDocument::class, 'project_level', 'project_level');
    }
  
}
