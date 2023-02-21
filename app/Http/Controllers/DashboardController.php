<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Project;
use App\Models\projectDocument;
use App\Models\ProjectLevels;
use App\Models\ProjectMilestone;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    $project = $this->get_all_projects();
    
  
    $project_document = projectDocument::all();
    $approved_project_document = projectDocument::where('status', 1)->get()->toArray();
    $pending_project_document = projectDocument::where('status', 0)->get()->toArray();
    $declined_project_document = projectDocument::where('status', 2)->get()->toArray();
    $overdue_project_document = $this->overdue_project_document();
    $order_at =$project;
    return view('Dashboard/index', ['order_at' => $order_at, 'project' => $project, 'project_document' => $project_document, 'approved_project_document' => $approved_project_document, 'pending_project_document' => $pending_project_document, 'declined_project_document' => $declined_project_document, 'overdue_project_document' => $overdue_project_document]);
  }
  public function get_all_projects()
    {
        $projects = DB::table('projects as p')
            ->select('p.*', 'p.id as project_id', 'p.is_active as project_status','w.*','e.*')
            ->join('employees as e', 'e.id', '=', 'p.initiator_id')
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
