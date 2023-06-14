<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Reports\ProjectwiseController;
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
use PHPUnit\Framework\Constraint\Count;

class DashboardController extends Controller
{
  protected $basicController, $projectwiseController;
  public function __construct(BasicController $basicController, ProjectwiseController $projectwiseController)
  {
    $this->basicController = $basicController;
    $this->projectwiseController = $projectwiseController;
  }
  public function index()
  {
    $empId = Auth::user()->emp_id;
  
    $countArray = $this->getCount();
   
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




    // dd($totProject);
    $project = $this->get_all_projects();

    $order_at = $models1;
    $initiatingProjects = array();
    $approvingProjects = array();
    if ($empId) {

      $initiaterProjectModels = Project::with('workflow', 'employee', 'employee.department')->where('initiator_id', $empId)->get();
    
      foreach ($initiaterProjectModels as $initiaterProjectModel) {
        $projectId = $initiaterProjectModel->id;
       // 
       // dd($projectId);
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

    return view('Dashboard/index', ['countArray' => $countArray, 'totalOverDueProjects' => $totalOverDueProjects, 'totalAppprovedProjects' => $totalAppprovedProjects, 'totalPendingProjects' => $totalPendingProjects, 'approvingProjects' => $approvingProjects, 'initiatingProjects' => $initiatingProjects, 'totProject' => $totProject,  'order_at' => $order_at, 'project' => $project]);
  }

  public function getCount()
  {
   
    $empId = Auth::user()->emp_id;

    $projectModels = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
    if ($empId) {
      $projectModels->whereHas('projectEmployees', function ($q) use ($empId) {
        if ($empId != "") {
          $q->where('employee_id', '=', $empId);
        }
      });
    }

    $projectModels->whereNull('deleted_at');
    $getProjectModels = $projectModels->get();
    $totalProject = Count($getProjectModels);
    $totalDocumentCount = 0;
    $totalApprovedDocumentCount = 0;
    $totalPendingDocumentCount = 0;
    $totalDeclinedDocumentCount = 0;
    $totalOverDueDocumentCount = 0;

if($totalProject){
    foreach ($getProjectModels as $key => $getProjectModel) {

      $projectId = $getProjectModel->id;

      $ProjectDocumentCount = projectDocument::where('project_id', $projectId)->where('type', 1)->count();
      $totalDocumentCount += $ProjectDocumentCount;

      $approvedProjectDocumentCount = projectDocument::where('project_id', $projectId)->where('type', 1)->where('status', 4)->count();
      $totalApprovedDocumentCount += $approvedProjectDocumentCount;

      $pendingProjectDocumentCount = projectDocument::where('project_id', $projectId)->where('type', 1)->where('status', 1)->count();
      $totalPendingDocumentCount += $pendingProjectDocumentCount;

      $declinedProjectDocumentCount = projectDocument::where('project_id', $projectId)->where('type', 1)->where('status', 2)->count();
      $totalDeclinedDocumentCount += $declinedProjectDocumentCount;

      $projectLevelModels = ProjectLevels::where('project_id', $projectId)->get();
      foreach ($projectLevelModels as $projectLevelModel) {
        $dueDate = $projectLevelModel->due_date;
        $level = $projectLevelModel->project_level;



        $toDayDate = now()->toDateString();
        $date1 = \Carbon\Carbon::parse($dueDate);
        $date2 = \Carbon\Carbon::parse($toDayDate);

        if ($date1->lt($date2)) {

          $getOverDueDocs = ProjectDocumentDetail::where('project_id', $projectId)
            ->where('is_latest', 1)
            ->where('status', '!=', 4)
            ->count();
          $totalOverDueDocumentCount += ($getOverDueDocs) ? 1 : 0;
        }
      }


      $response = [
        'totalProjectCount' => $totalProject,
        'totalDocumentCount' => $totalDocumentCount,
        'totalApprovedDocumentCount' => $totalApprovedDocumentCount,
        'totalPendingDocumentCount' => $totalPendingDocumentCount,
        'totalDeclinedDocumentCount' => $totalDeclinedDocumentCount,
        'totalOverDueDocumentCount' => $totalOverDueDocumentCount
      ];
    
      return $response;
    }
  }else{
    $response = [
      'totalProjectCount' => $totalProject,
      'totalDocumentCount' => $totalDocumentCount,
      'totalApprovedDocumentCount' => $totalApprovedDocumentCount,
      'totalPendingDocumentCount' => $totalPendingDocumentCount,
      'totalDeclinedDocumentCount' => $totalDeclinedDocumentCount,
      'totalOverDueDocumentCount' => $totalOverDueDocumentCount
    ];
  
    return $response;
  }
  }


  public function dashboardSearch(Request $request)
  {
    $startDate = $request->fromDate;
    $endDate = $request->toDate;

    $empId = Auth::user()->emp_id;
    $activeModels = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
    if ($empId) {
      $activeModels->whereHas('projectEmployees', function ($q) use ($empId) {
        if ($empId != "") {
          $q->where('employee_id', '=', $empId);
        }
      });
    }

    $activeModels->whereNull('deleted_at');
    $activeModels->where(function ($query) use ($startDate, $endDate) {
      $query->whereBetween('start_date', [$startDate, $endDate])
        ->orWhereBetween('end_date', [$startDate, $endDate]);
    });
    $activatedProjectModels = $activeModels->get();
    $allProjectsentities = $this->projectwiseController->ReportDataLooping($activatedProjectModels);

    $initiatingProjects = array();
    $approvingProjects = array();
    if ($empId) {

      $initiaterAllProjectModels = Project::with('workflow', 'employee', 'employee.department')
        ->where('initiator_id', $empId);
      $initiaterAllProjectModels->where(function ($query) use ($startDate, $endDate) {
        $query->whereBetween('start_date', [$startDate, $endDate])
          ->orWhereBetween('end_date', [$startDate, $endDate]);
      });
      $initiaterProjectModels = $initiaterAllProjectModels->get();
     
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
      $myAprovingProjectModels->where(function ($query) use ($startDate, $endDate) {
        $query->whereBetween('start_date', [$startDate, $endDate])
          ->orWhereBetween('end_date', [$startDate, $endDate]);
      });
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

    return response()->json(['activeProjects' => $allProjectsentities, 'approvingProjects' => $approvingProjects, 'myProjects' => $initiatingProjects]);
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
