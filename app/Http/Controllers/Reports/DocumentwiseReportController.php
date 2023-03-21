<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectController;
use App\Models\DocumentType;
use App\Models\Project;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
       // $models= Project::with('workflow', 'employee', 'employee.department', 'docType')->whereNull('deleted_at')->get();
       
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";
        $modeldatas = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees', 'docType');

   
        if ($empId) {
            $modeldatas->whereHas('projectEmployees', function ($q) use ($empId) {
                if ($empId != "") {
                    $q->where('employee_id', '=', $empId);
                }
            });
        }
        $modeldatas->whereNull('deleted_at');
        $models= $modeldatas->get();
      
        $entities = $this->projectController->ReportDataLooping($models);
        return view('Reports/DocumentwiseReport/list', compact(['projectDatas', 'documentDatas', 'workflowDatas','entities']));
    }
    public function filterSearch(Request $request)
    {
        $workflowId = $request->workflowCode;
        $projectId = $request->projectName;
        $documentId = $request->docuName;
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";
        $modelDatas = Project::with('workflow', 'employee', 'employee.department', 'docType','projectEmployees');
        if ($empId) {
            $modelDatas->whereHas('projectEmployees', function ($q) use ($empId) {
                if ($empId != "") {
                    $q->where('employee_id', '=', $empId);
                }
            });
        }
        if ($workflowId) {
            $modelDatas->whereHas('workflow', function ($query) use ($workflowId) {
                $query->where('id', $workflowId);
            });
        }
        if ($documentId) {
            $modelDatas->where('document_type_id', $documentId);
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
  
}
