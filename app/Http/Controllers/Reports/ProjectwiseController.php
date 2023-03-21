<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Project;
use App\Models\Workflow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectwiseController extends Controller
{
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
       $models= $modeldatas->get();

        $departmentDatas = Department::whereNull('deleted_at')->get();
        $workflowDatas = Workflow::whereNull('deleted_at')->get();
        $entities = $this->ReportDataLooping($models);
        //dd($entities);
        $projectDatas = $models;
        return view('Reports/ProjectwiseReport/list', compact(['entities','projectDatas', 'departmentDatas', 'workflowDatas']));
    }
    public function filterSearch(Request $request)
    {
        $deptId = $request->department;
        $workflowId = $request->workflowId;
        $projectId = $request->projectId;
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";

        $workflowDatas =$this->getWorkflowDatasByDepartmentId($deptId);
       

        $models = $this->getModelDatas($deptId, $workflowId, $projectId,$empId);



        $entities = $this->ReportDataLooping($models);
        return response()->json(['entities' => $entities,'workflowDatas'=>$workflowDatas]);
    }
    public function getWorkflowDatasByDepartmentId($deptId)
    {
        return Workflow::select('workflows.workflow_code','workflows.workflow_name', 'workflows.id')

            ->leftjoin('projects', 'projects.workflow_id', '=', 'workflows.id')
            ->leftjoin('employees', 'employees.id', '=', 'projects.initiator_id')
            ->leftjoin('departments', 'departments.id', '=', 'employees.department_id')
            ->where('departments.id', $deptId)
            ->groupBy('projects.workflow_id')
            ->get();
    }
    public function getModelDatas($deptId, $workflowId = null, $projectId = null, $empId=null)
    {
        $modelDatas = Project::with('workflow', 'employee', 'employee.department','projectEmployees');
        if ($empId) {
            $modelDatas->whereHas('projectEmployees', function ($q) use ($empId) {
                if ($empId != "") {
                    $q->where('employee_id', '=', $empId);
                }
            });
        }

        if ($deptId) {
            $modelDatas->whereHas('employee.department', function ($query) use ($deptId) {
                $query->where('id', $deptId);
            });
        }
        if ($workflowId) {
            $modelDatas->whereHas('workflow', function ($query) use ($workflowId) {
                $query->where('id', $workflowId);
            });
        }
        if ($projectId) {
            $modelDatas->where('id', $projectId);
        }

        $modelDatas->whereNull('deleted_at');
        $models =  $modelDatas->get();
        return $models;
    }

    public function ReportDataLooping($models)
    {
        $entities = collect($models)->map(function ($model) {

            $workflowModel = $model['workflow'];
            $employeeModel = $model['employee'];
            $departmentModel = "";
            if ($employeeModel) {
                $departmentModel = $employeeModel->department;
            }


            $startDate = Carbon::parse($model->start_date);
            $endDate = Carbon::parse($model->end_date);

            $noOfDays = $startDate->diffInDays($endDate);

            $projectId = $model->id;
            $projectCode = $model->project_code;
            $projectName = $model->project_name;

            $workflowId = $workflowModel->id;
            $workflowCode = $workflowModel->workflow_code;
            $workflowName = $workflowModel->workflow_name;
            $workflowLevel = $workflowModel->total_levels;
            $initiater = $employeeModel->first_name . " " . $employeeModel->last_name;
            $department = ($departmentModel) ? $departmentModel->name : "";
            $data = ['workflowId' => $workflowId, 'noOfDays' => $noOfDays, 'dueDate' => $model->end_date, 'workflowLevel' => $workflowLevel, 'projectId' => $projectId, 'workflowName' => $workflowName, 'projectCode' => $projectCode, 'projectName' => $projectName, 'workflowCode' => $workflowCode, 'initiater' => $initiater, 'department' => $department];

            return $data;
        });
        return $entities;
    }
}
