<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectDocument extends Model
{
    use HasFactory;
    protected $table = "project_document";
    public function docDetail()
    {
        return $this->hasMany('App\Models\ProjectDocumentDetail', 'project_doc_id', 'id');
    }
}
