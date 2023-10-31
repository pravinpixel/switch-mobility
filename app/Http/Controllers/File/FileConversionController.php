<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\ProjectDocumentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class FileConversionController extends Controller
{
    protected $excelController;
    public function __construct(ExcelFileConversionController $excelController)
    {
        $this->excelController = $excelController;
    }
    public function approvedDocsDownload(Request $request)
    {
        $id = $request->id;
        $model = ProjectDocumentDetail::with('documentName')->where('project_doc_id', $id)
            ->where('is_latest', 1)
            ->first();
        $extension = \File::extension($model->document_name);
        $filePath = public_path('projectDocuments/' . $model->document_name);
        $projectDocModel = $model->documentName;


        $projectId = $projectDocModel->project_id;

        if ($extension == "xlsx" || $extension == "xls") {
            $fileC = $this->excelController->fileConverter($projectId, $filePath);
            dd($fileC);
        }else{
            dd("under construction");
        }
    }
}
