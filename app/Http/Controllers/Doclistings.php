<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectLevels;
use App\Models\ProjectMilestone;
use App\Models\Workflow;
use Illuminate\Support\Facades\DB;

class Doclistings extends Controller
{
    public function index()
    {       

        $project=Project::where('is_active', 1)->get()->toArray();
        $employees = Employee::where('is_active', 1)->get()->toArray();
        $departments = Department::where('is_active', 1)->get()->toArray();
        $designation = Designation::where('is_active', 1)->get()->toArray();
        $document_type = DocumentType::where('is_active', 1)->get()->toArray();
        $workflow = Workflow::where('is_active', 1)->get()->toArray();
        return view('Docs/index', ['order_at'=>[],'document_type' => $document_type, 'workflow' => $workflow,'employee' => $employees, 'departments' => $departments, 'designation' => $designation,'projects'=>$project]);

    }

    public function search(Request $request){

        $input=$request->all();
        if($input){
            $order_att = DB::table('projects as p')
             ->leftjoin('project_levels as pl','pl.project_id','=','p.id')
            ->leftJoin('workflows as w', 'w.id', '=', 'p.workflow_id')
            ->leftjoin('employees as e','e.id','=','p.initiator_id')
            ->leftjoin('departments as d','d.id','=','e.department_id')
            ->select('p.id','p.project_name','p.project_code','w.workflow_code','w.workflow_name','e.first_name','e.last_name','d.name as department','p.is_active');
              if($input['ticket_no'])
              {
                $order_att=$order_att->orWhere('p.id', 'like', '%' . $input['ticket_no'] . '%');
              }
              if($input['project_code_name'])
              {
                $order_att=$order_att->where('p.project_name',$input['project_code_name']);
                $order_att=$order_att->orWhere('p.project_code', 'like', '%' . $input['project_code_name'] . '%');
              }
              if($input['start_date'])
              {
                $order_att=$order_att->where('p.start_date',$input['start_date']);
              }
              if($input['end_date'])
              {
                $order_att=$order_att->where('p.end_date',$input['end_date']);
              }
              if($input['users'])
              {
                $order_att=$order_att->where('p.initiator_id',$input['users']);
              }
              if($input['workflow'])
              {
                $order_att=$order_att->where('p.workflow_id',$input['workflow']);
              }
              $order_at=$order_att->get();
              $project=Project::where('is_active', 1)->get()->toArray();
              $employees = Employee::where('is_active', 1)->get()->toArray();
              $departments = Department::where('is_active', 1)->get()->toArray();
              $designation = Designation::where('is_active', 1)->get()->toArray();
              $document_type = DocumentType::where('is_active', 1)->get()->toArray();
              $workflow = Workflow::where('is_active', 1)->get()->toArray();
              return view('Docs/index', ['order_at'=>$order_at,'document_type' => $document_type, 'workflow' => $workflow,'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
        }
    }
}
