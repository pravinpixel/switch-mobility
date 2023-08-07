<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Doclistings;
use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectDocumentStatusByLevel;
use App\Models\Workflow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectwiseController extends Controller
{
    public $Doclistings;
    public function __construct(Doclistings $Doclistings)
    {
        $this->Doclistings = $Doclistings;
    }
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

        $departmentDatas = Department::where('is_active', 1)->whereNull('deleted_at')->get();
        $workflowDatas = Workflow::where('is_active', 1)->whereNull('deleted_at')->get();
        $entities = $this->ReportDataLooping($models);
        //dd($entities);
        $projectDatas = $models;
        return view('Reports/ProjectwiseReport/list', compact(['entities', 'projectDatas', 'departmentDatas', 'workflowDatas']));
    }
    public function filterSearch(Request $request)
    {
        $deptId = ($request->department) ? $request->department : "";
        $workflowId = $request->workflowId;
        $projectId = $request->projectId;
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";

        $workflowDatas = $this->getWorkflowDatasByDepartmentId($deptId);


        $models = $this->getModelDatas($deptId, $workflowId, $projectId, $empId);



        $entities = $this->ReportDataLooping($models);
        return response()->json(['entities' => $entities, 'workflowDatas' => $workflowDatas]);
    }
    public function getWorkflowDatasByDepartmentId($deptId)
    {
        return Workflow::select('workflows.workflow_code', 'workflows.workflow_name', 'workflows.id')

            ->leftjoin('projects', 'projects.workflow_id', '=', 'workflows.id')
            ->leftjoin('employees', 'employees.id', '=', 'projects.initiator_id')
            ->leftjoin('departments', 'departments.id', '=', 'employees.department_id')
            ->where('departments.id', $deptId)
            ->groupBy('projects.workflow_id')
            ->get();
    }
    public function getModelDatas($deptId, $workflowId = null, $projectId = null, $empId = null)
    {
        $modelDatas = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
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
            $lastlevel = $this->Doclistings->getLastLevelProject($model->id);
            $status = "No Documents";
            if ($lastlevel) {
                $LastLevelmodels = ProjectDocumentStatusByLevel::where('project_id', $model->id)
                    ->where('level_id', $lastlevel)
                    ->first();
                if ($LastLevelmodels) {
                    if ($LastLevelmodels->status == 2) {
                        $status = "Declined";
                    } else if ($LastLevelmodels->status == 3)
                    {
                        $status = "Change Request";
                    } else if ($LastLevelmodels->status == 4)
                    {
                        $status = "Approved";
                    }else{
                        $status = "Waiting For Approval";
                    }
                   
                }
            }
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
            $ticketNo = $model->ticket_no;

            $workflowId = $workflowModel->id;
            $workflowCode = $workflowModel->workflow_code;
            $workflowName = $workflowModel->workflow_name;
            $workflowLevel = $workflowModel->total_levels;
            $initiater = $employeeModel->first_name . " " . $employeeModel->last_name;
            $department = ($departmentModel) ? $departmentModel->name : "";
            $data = ['status'=>$status,'ticketNo' => $ticketNo, 'workflowId' => $workflowId, 'noOfDays' => $noOfDays, 'dueDate' => $model->end_date, 'workflowLevel' => $workflowLevel, 'projectId' => $projectId, 'workflowName' => $workflowName, 'projectCode' => $projectCode, 'projectName' => $projectName, 'workflowCode' => $workflowCode, 'initiater' => $initiater, 'department' => $department];

            return $data;
        });
        return $entities;
    }
}
