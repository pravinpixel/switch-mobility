<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectController;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Workflow;
use Illuminate\Http\Request;

class UserwiseReportController extends Controller
{
    protected $projectController;
    public function __construct(ProjectwiseController $projectController)
    {
        $this->projectController = $projectController;
    }
    protected $service;
    public function index()
    {

        $models = Project::with('workflow', 'employee', 'employee.department')->whereNull('deleted_at')->get();
        $entities = $this->projectController->ReportDataLooping($models);

        $initiatorDatas = Employee::whereNull('deleted_at')->get();
        $workflowDatas = Workflow::whereNull('deleted_at')->get();
        return view('Reports/UserwiseReport/list', compact(['entities', 'initiatorDatas', 'workflowDatas']));
    }
    public function filterSearch(Request $request)
    {

        $workflowId = $request->workflow;
        $employeeId = $request->Employee;
        $modelDatas = Project::with('workflow', 'employee', 'employee.department');
        if ($workflowId) {
            $modelDatas->whereHas('workflow', function ($query) use ($workflowId) {
                $query->where('id', $workflowId);
            });
        }
        if ($employeeId) {
            $modelDatas->whereHas('employee', function ($query) use ($employeeId) {
                $query->where('id', $employeeId);
            });
        }
        $modelDatas->whereNull('deleted_at');
        $models = $modelDatas->get();
        $entities = $this->projectController->ReportDataLooping($models);
        if(isset($workflowId)){
         $datas = Project::select('employees.first_name','employees.id','employees.sap_id')
            ->leftjoin('employees', 'employees.id', '=', 'projects.initiator_id')
            ->leftjoin('workflows', 'workflows.id', '=', 'projects.workflow_id')
            ->where('workflow_id', $workflowId)
            ->get();
        }else{
            $datas='';
        }
        return response()->json(['entities' => $entities,'datas'=>$datas]);
    }
}
