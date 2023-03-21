<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Project;
use App\Models\projectDocument;
use App\Models\ProjectDocumentDetail;
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
  public function index()
  {
    $empId = Auth::user()->emp_id;
    if ($empId) {
      $employee = Employee::where('id', $empId)->first();
      $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;
      $EmployeePic=$employee->profile_image;
if($EmployeePic==null){
  $image='images/admin-icon-3.jpg';
}else{
  $image='images/Employee/'.$EmployeePic;

}
Session()->put('profile', $image);
      Session()->put('employeeId', $empId);
    } else {
      $name = "Admin";
       Session()->put('employeeId', "");
    }
    Session()->put('logginedUser', $name);
    $role = auth()->user()->roles->first();
    if ($role) {
      $type = ($role->authority_type == 1) ? 1 : 0;

      Session()->put('authorityType', $type);
    } else {
      Session()->put('authorityType', 1);
    }
    $data = Session('authorityType');

    $totProject = Project::whereNull('deleted_at')->count();
    $totDocs = ProjectDocumentDetail::whereNull('deleted_at')->count();
    $totApprovedDocs = ProjectDocumentDetail::where('status', 4)->whereNull('deleted_at')->count();
    $totDeclinedDocs = ProjectDocumentDetail::where('status', 2)->whereNull('deleted_at')->count();
    // dd($totProject);
    $project = $this->get_all_projects();


    $project_document = projectDocument::all();
    $approved_project_document = projectDocument::where('status', 1)->get()->toArray();
    $pending_project_document = projectDocument::where('status', 0)->get()->toArray();
    $declined_project_document = projectDocument::where('status', 2)->get()->toArray();
    $overdue_project_document = $this->overdue_project_document();
    $order_at = $project;
    return view('Dashboard/index', ['totDeclinedDocs' => $totDeclinedDocs, 'totApprovedDocs' => $totApprovedDocs, 'totProject' => $totProject, 'totDocs' => $totDocs, 'order_at' => $order_at, 'project' => $project, 'project_document' => $project_document, 'approved_project_document' => $approved_project_document, 'pending_project_document' => $pending_project_document, 'declined_project_document' => $declined_project_document, 'overdue_project_document' => $overdue_project_document]);
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
