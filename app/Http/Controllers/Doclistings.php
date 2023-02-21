<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Doclistings extends Controller
{
    public function index()
    {

        $project = Project::with('workflow', 'employee', 'employee.department')->whereNull('deleted_at')->get();
        $employees = Employee::where(['is_active'=>1,'delete_flag'=>1])->get();
        $departments = Department::where(['is_active'=>1,'delete_flag'=>1])->get();
        $designation = Designation::where(['is_active'=>1,'delete_flag'=>1])->get();
        $document_type = DocumentType::where(['is_active'=>1,'delete_flag'=>1])->get();
        $workflow = Workflow::where(['is_active'=>1,'delete_flag'=>1])->get();  
        $projectList = $project;
       
        return view('Docs/index', ['order_at' => $projectList, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation, 'projects' => $project]);
    }
    public function docListingSearch(Request $request)
    {
        $model = Project::select('projects.id as projectId','projects.ticket_no', 'projects.project_code', 'projects.project_name', 'workflows.workflow_code', 'workflows.workflow_name', 'employees.first_name', 'departments.name as deptName');
        $model->leftjoin('employees', 'employees.id', '=', 'projects.initiator_id');
        $model->leftjoin('departments', 'departments.id', '=', 'employees.department_id');
        $model->leftjoin('designations', 'designations.id', '=', 'employees.designation_id');
        $model->leftjoin('workflows', 'workflows.id', '=', 'projects.workflow_id');
        if ($request->ticket_no) {
            $model->where('projects.ticket_no', $request->ticket_no);
        }
        if ($request->project_code_name) {
            $model->where('projects.project_code', $request->project_code_name);
            $model->orWhere('projects.project_name', $request->project_code_name);
        }
        if ($request->workflow_code_name) {
            $model->where('workflows.workflow_code', $request->workflow_code_name);
            $model->orWhere('workflows.workflow_name', $request->workflow_code_name);
        }
        if ($request->users) {
            $model->where('employees.id', $request->users);
        }
        if ($request->start_date) {
            $model->where('projects.start_date', $request->start_date);
        }
        if ($request->end_date) {
            $model->where('projects.end_date', $request->end_date);
        }
        if ($request->department) {
            $model->where('departments.id', $request->department);
        }
        if ($request->designation) {
            $model->where('designations.id', $request->designation);
        }
        $data = $model->get();
        return response()->json($data);
    }
    public function search(Request $request)
    {

        $input = $request->all();
        if ($input) {
            $order_att = DB::table('projects as p')
                ->leftjoin('project_levels as pl', 'pl.project_id', '=', 'p.id')
                ->leftJoin('workflows as w', 'w.id', '=', 'p.workflow_id')
                ->leftjoin('employees as e', 'e.id', '=', 'p.initiator_id')
                ->leftjoin('departments as d', 'd.id', '=', 'e.department_id')
                ->select('p.id', 'p.project_name', 'p.project_code', 'w.workflow_code', 'w.workflow_name', 'e.first_name', 'e.last_name', 'd.name as department', 'p.is_active');
            if ($input['ticket_no']) {
                $order_att = $order_att->orWhere('p.id', 'like', '%' . $input['ticket_no'] . '%');
            }
            if ($input['project_code_name']) {
                $order_att = $order_att->where('p.project_name', $input['project_code_name']);
                $order_att = $order_att->orWhere('p.project_code', 'like', '%' . $input['project_code_name'] . '%');
            }
            if ($input['start_date']) {
                $order_att = $order_att->where('p.start_date', $input['start_date']);
            }
            if ($input['end_date']) {
                $order_att = $order_att->where('p.end_date', $input['end_date']);
            }
            if ($input['users']) {
                $order_att = $order_att->where('p.initiator_id', $input['users']);
            }
            if ($input['workflow']) {
                $order_att = $order_att->where('p.workflow_id', $input['workflow']);
            }
            $order_at = $order_att->get();
            $project = Project::where('is_active', 1)->get()->toArray();
            $employees = Employee::where('is_active', 1)->get()->toArray();
            $departments = Department::where('is_active', 1)->get()->toArray();
            $designation = Designation::where('is_active', 1)->get()->toArray();
            $document_type = DocumentType::where('is_active', 1)->get()->toArray();
            $workflow = Workflow::where('is_active', 1)->get()->toArray();
            return view('Docs/index', ['order_at' => $order_at, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
        }
    }
}
