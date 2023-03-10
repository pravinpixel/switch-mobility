<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectController;
use App\Models\DocumentType;
use App\Models\Project;
use App\Models\Workflow;
use Illuminate\Http\Request;

class DocumentwiseReportController extends Controller
{
    protected $projectController;
    public function __construct(ProjectwiseController $projectController)
    {
        $this->projectController = $projectController;
    }
    protected $service;

    public function index()
    {
        $projectDatas = Project::whereNull('deleted_at')->get();
        $workflowDatas = Workflow::whereNull('deleted_at')->get();
        $documentDatas = DocumentType::whereNull('deleted_at')->get();

        return view('Reports/DocumentwiseReport/list', compact(['projectDatas', 'documentDatas', 'workflowDatas']));
    }
    public function filterSearch(Request $request)
    {
        $workflowId = $request->workflowCode;
        $projectId = $request->projectName;
        $documentId = $request->docuName;
        $modelDatas = Project::with('workflow', 'employee', 'employee.department', 'docType');
        if ($workflowId) {
            $modelDatas->whereHas('workflow', function ($query) use ($workflowId) {
                $query->where('id', $workflowId);
            });
        }
        if ($projectId) {
            $modelDatas->where('id', $projectId);
        }
        $modelDatas->whereNull('deleted_at');
        $models = $modelDatas->get();
        $entities = $this->projectController->ReportDataLooping($models);
        if (isset($workflowId)) {
            $docType = DocumentType::where('workflow_id', $workflowId)->whereNull('deleted_at')->get(); 
        }else{
            $docType='';
        }
        return response()->json(['entities' => $entities,'document'=>$docType]); 
    }
    public function dependentwiseData(Request $request)
    {
        $workflowId = $request->workflowId;
        $documentId = $request->documentId;
        $projectId = $request->projectId;
        $modelDatas = Project::with('docType');
        $modelDatas->whereHas('docType', function ($query) use ($workflowId) {
            $query->where('id', $workflowId);
        });

        $modelDatas->whereNull('deleted_at');
        $models = $modelDatas->get();
        dd($models);
        // if($documentId){
        //     $modelDatas->where('document_type_id', $documentId);
        // }
        // $modelDatas->whereNull('deleted_at');
        //     $models =  $modelDatas->get();
        //     $entities = collect($models)->map(function ($model) {
        //         $documentModel = $model['docType'];

        //     });

    }
}
