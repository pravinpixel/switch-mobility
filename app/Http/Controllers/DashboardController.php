<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectApprover;
use App\Models\projectDocument;
use App\Models\ProjectDocumentDetail;
use App\Models\ProjectEmployee;
use App\Models\ProjectLevels;
use App\Models\ProjectMilestone;
use App\Models\Workflow;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session as FacadesSession;

class DashboardController extends Controller
{
  protected $basicController;
  public function __construct(BasicController $basicController)
  {
    $this->basicController = $basicController;
  }
  public function index()
  {
    $empId = Auth::user()->emp_id;
    // if ($empId) {
    //   $employee = Employee::where('id', $empId)->first();

    //   $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;
    //   Session()->put('employeeId', $empId);
    // } else {
    //   $name = "Admin";
    //   Session()->put('employeeId', "");
    // }
    // Session()->put('logginedUser', $name);
    $this->basicController->BasicFunction();
    $role = auth()->user()->roles->first();
    if ($role) {
      $type = ($role->authority_type == 1) ? 1 : 0;

      Session()->put('authorityType', $type);
    } else {
      Session()->put('authorityType', 1);
    }
    $data = Session('authorityType');

    $models = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
    if ($empId) {
      $models->whereHas('projectEmployees', function ($q) use ($empId) {
        if ($empId != "") {
          $q->where('employee_id', '=', $empId);
        }
      });
    }

    $models->whereNull('deleted_at');
    $models1 = $models->get();

    $totalAppprovedmodels = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
    if ($empId) {
      $totalAppprovedmodels->whereHas('projectEmployees', function ($q) use ($empId) {
        if ($empId != "") {
          $q->where('employee_id', '=', $empId);
        }
      });
    }

    $totalAppprovedmodels->whereNull('deleted_at');
    $totalAppprovedmodels->where('current_status', 4);
    $totalAppprovedProjects = $totalAppprovedmodels->count();





    $totalPendingmodels = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
    if ($empId) {
      $totalPendingmodels->whereHas('projectEmployees', function ($q) use ($empId) {
        if ($empId != "") {
          $q->where('employee_id', '=', $empId);
        }
      });
    }

    $totalPendingmodels->whereNull('deleted_at');
    $totalPendingmodels->where('current_status', 0);
    $totalPendingProjects = $totalPendingmodels->count();


    $includedProjects = array();

    foreach ($models1 as $key => $value) {

      $includedProjects[$key] = $value['id'];
    }

    $totProject = count($models1);

    $totalOverDuemodels = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
    if ($empId) {
      $totalOverDuemodels->whereHas('projectEmployees', function ($q) use ($empId) {
        if ($empId != "") {
          $q->where('employee_id', '=', $empId);
        }
      });
    }

    $totalOverDuemodels->whereNull('deleted_at');
    $totalOverDuemodels->where('current_status', '!=', 4);
    $totalOverDuemodels->where('end_date', '<', now()->toDateString());
    $totalOverDueProjects = $totalOverDuemodels->count();

    if ($empId) {
      $gettotDocs = ProjectDocument::whereIn('project_id', $includedProjects)->get();
      $totDocs = count($gettotDocs);
      $gettotApprovedDocs = projectDocument::whereIn('project_id', $includedProjects)->where('status', 4)->whereNull('deleted_at')->get();

      $totApprovedDocs = count($gettotApprovedDocs);
      $gettotDeclinedDocs = projectDocument::whereIn('project_id', $includedProjects)->where('status', 2)->whereNull('deleted_at')->get();
      $gettotPendingDocs = projectDocument::whereIn('project_id', $includedProjects)->where('status', 1)->whereNull('deleted_at')->get();

      $totDeclinedDocs = count($gettotDeclinedDocs);

      $totPendingDocs = count($gettotPendingDocs);
    } else {
      $totDocs = projectDocument::whereNull('deleted_at')
        ->count();
      $totApprovedDocs = projectDocument::where('status', 4)->whereNull('deleted_at')->count();
      $totDeclinedDocs = projectDocument::where('status', 2)->whereNull('deleted_at')->count();
      $totPendingDocs = projectDocument::where('status', 1)->whereNull('deleted_at')->count();
    }



    // dd($totProject);
    $project = $this->get_all_projects();

    $order_at = $models1;
    $initiatingProjects = array();
    $approvingProjects = array();
    if ($empId) {

      $initiaterProjectModels = Project::with('workflow', 'employee', 'employee.department')->where('initiator_id', $empId)->get();
      foreach ($initiaterProjectModels as $initiaterProjectModel) {
        $projectId = $initiaterProjectModel->id;
        $DocsModel = ProjectDocumentDetail::where('project_id', $projectId)->count();
        if (!$DocsModel) {
          array_push($initiatingProjects, $initiaterProjectModel);
        }
      }

      $myAprovingProjectModels = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
      if ($empId) {
        $myAprovingProjectModels->whereHas('projectEmployees', function ($q) use ($empId) {
          if ($empId != "") {
            $q->where('employee_id', '=', $empId);
          }
        });
      }

      $myAprovingProjectModels->whereNull('deleted_at');
      $myAprovingProjects = $myAprovingProjectModels->get();

      foreach ($myAprovingProjects as $myApprovingProject) {
        $projectId = $myApprovingProject->id;
        $workflowModel = $myApprovingProject['workflow'];
        $employeeModel = $myApprovingProject['employee'];
        $departmentModel = $employeeModel['department'];


        $getMyApproverLevels = ProjectEmployee::where('project_id', $projectId)->where('employee_id', $empId)->where('type', 2)->get();
        foreach ($getMyApproverLevels as $getMyApproverLevel) {

          $level = $getMyApproverLevel->level;
          $getProjectLevelModel = ProjectLevels::where('project_id', $projectId)->where('project_level', $level)->first();

          $DocsModel2 = ProjectDocumentDetail::where('project_id', $projectId)->where('upload_level', $level)->count();
          if (!$DocsModel2) {
            $newDatas = [
              'projectId' => $myApprovingProject->id,
              'ticketNo' => $myApprovingProject->ticket_no,
              'projectName' => $myApprovingProject->project_name,
              'projectCode' => $myApprovingProject->project_code,
              'wfname' => $workflowModel->workflow_name,
              'wfCode' => $workflowModel->workflow_code,
              'department' => $departmentModel->name,
              'startDate' => date("d-m-Y", strtotime($myApprovingProject->start_date)),
              'endDate' => date("d-m-Y", strtotime($myApprovingProject->end_date)),
              'dueDate' => ($getProjectLevelModel) ? date("d-m-Y", strtotime($getProjectLevelModel->due_date)) : "",
              'level' => $level
            ];
            array_push($approvingProjects, $newDatas);
          }
        }
      }
    }

    return view('Dashboard/index', ['totalOverDueProjects' => $totalOverDueProjects, 'totalAppprovedProjects' => $totalAppprovedProjects, 'totalPendingProjects' => $totalPendingProjects, 'approvingProjects' => $approvingProjects, 'initiatingProjects' => $initiatingProjects, 'totPendingDocs' => $totPendingDocs, 'totDeclinedDocs' => $totDeclinedDocs, 'totApprovedDocs' => $totApprovedDocs, 'totProject' => $totProject, 'totDocs' => $totDocs, 'order_at' => $order_at, 'project' => $project]);
  }
  public function get_all_projects()
  {
    $projects = DB::table('projects as p')
      ->select('p.*', 'p.id as project_id', 'p.is_active as project_status', 'w.*', 'e.*', 'departments.name as deptname')
      ->join('employees as e', 'e.id', '=', 'p.initiator_id')
      ->join('departments', 'departments.id', '=', 'e.department_id')
      ->join('workflows as w', 'p.workflow_id', '=', 'w.id')
      ->where('p.is_active', 1)
      ->limit(10)
      ->get();

    return $projects;
  }


  public function overdue_project_document()
  {
    $now = date('Y-m-d');
    $order_att = DB::table('project_documents as p')
      ->leftjoin('project_levels as pl', 'pl.project_id', '=', 'p.id')
      ->select('*')
      ->where('pl.due_date', '<', $now);
    $order_at = $order_att->get();
    return $order_at;
  }

  public function search()
  {
    $to_date = date('Y-m-d');
    $from_date = date('Y-m-d', strtotime('-2 days'));
    $order_att = DB::table('projects as p')
      ->leftjoin('project_levels as pl', 'pl.project_id', '=', 'p.id')
      ->leftJoin('workflows as w', 'w.id', '=', 'p.workflow_id')
      ->leftjoin('employees as e', 'e.id', '=', 'p.initiator_id')
      ->leftjoin('departments as d', 'd.id', '=', 'e.department_id')
      ->select('p.id', 'p.project_name', 'p.project_code', 'w.workflow_code', 'w.workflow_name', 'e.first_name', 'e.last_name', 'd.name as department', 'p.is_active')
      ->WhereBetween('pl.due_date', [$from_date, $to_date]);
    $order_at = $order_att->get();
    return $order_at;
  }
}
