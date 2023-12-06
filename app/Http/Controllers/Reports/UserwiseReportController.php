<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectController;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // $models = Project::with('workflow', 'employee', 'employee.department')->whereNull('deleted_at')->get();
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";

        $modeldatas = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');


        if ($empId) {
            $modeldatas->whereHas('projectEmployees', function ($q) use ($empId) {
                if ($empId != "") {
                    $q->where('employee_id', '=', $empId);
                }
            });
        }
        $modeldatas->whereNull('deleted_at');
        $models = $modeldatas->get();
        $entities = $this->projectController->ReportDataLooping($models);


        $workflowDatas = Workflow::where('is_active', 1)->whereNull('deleted_at')->get();


        $initiaterDatas = array();
        $initiaterEntities = collect($models)->map(function ($initiaterModel) {
            return  $initiaterModel['employee']->id;
        });
        $initiaterIds = ($initiaterEntities->unique())->toArray();
        $initiatorDatas = Employee::whereIn('id', $initiaterIds)->where('is_active', 1)->whereNull('deleted_at')->get()->toArray();
       // dd($initiatorDatas);

        return view('Reports/UserwiseReport/list', compact(['entities', 'initiatorDatas', 'workflowDatas']));
    }
    public function filterSearch(Request $request)
    {

        $workflowId = $request->workflow;
        $employeeId = $request->Employee;
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";

        $modelDatas = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
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
        if ($employeeId) {
            $modelDatas->whereHas('employee', function ($query) use ($employeeId) {
                $query->where('id', $employeeId);
            });
        }
        $modelDatas->whereNull('deleted_at');
        $models = $modelDatas->get();


        $entities = $this->projectController->ReportDataLooping($models);

        if (isset($workflowId)) {
         
        $initiaterDatas = array();
        $initiaterEntities = collect($models)->map(function ($initiaterModel) {
            return  $initiaterModel['employee']->id;
        });
        $initiaterIds = ($initiaterEntities->unique())->toArray();
        $datas = Employee::select('id', 'sap_id', DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS fullName"))
        ->whereIn('id', $initiaterIds)
        ->where('is_active', 1)
        ->whereNull('deleted_at')
        ->get()
        ->toArray();
    
        } else {
            $datas = '';
        }
       
        return response()->json(['entities' => $entities, 'datas' => $datas]);
    }
}
