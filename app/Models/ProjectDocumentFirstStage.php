<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDocumentFirstStage extends Model
{
    use HasFactory;

    public function GetDocDetail()
    {
        return $this->hasMany('App\Models\ProjectDocumentDetail', 'project_doc_id', 'doc_id');
    }
}
