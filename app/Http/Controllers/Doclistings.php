<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectMilestone;
use App\Models\Workflow;
use App\Models\WorkflowLevelDetail;
use App\Models\Workflowlevels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Doclistings extends Controller
{
    public function index()
    {

        $project = Project::with('workflow', 'employee', 'employee.department')->whereNull('deleted_at')->get();
        $employees = Employee::where(['is_active'=>1])->get();
        $departments = Department::where(['is_active'=>1])->get();
        $designation = Designation::where(['is_active'=>1])->get();
        $document_type = DocumentType::where(['is_active'=>1])->get();
        $workflow = Workflow::where(['is_active'=>1])->get();  
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
    public function viewDocListing($id)
    {
      
            $project_details = DB::table('projects as p')
                ->leftjoin('project_levels as pl', 'pl.project_id', '=', 'p.id')
                ->leftJoin('workflows as w', 'w.id', '=', 'p.workflow_id')
                ->leftjoin('employees as e', 'e.id', '=', 'p.initiator_id')
                ->leftjoin('departments as d', 'd.id', '=', 'e.department_id')
                ->leftjoin('document_types as doc', 'doc.id', '=', 'p.document_type_id')
                ->leftjoin('designations as des', 'des.id', '=', 'e.designation_id')
                ->where("p.id", '=', $id)
                ->select('p.ticket_no', 'p.created_at', 'p.id', 'p.project_name', 'p.project_code', 'e.profile_image', 'des.name as designation', 'doc.name as document_type', 'w.workflow_code', 'w.workflow_name', 'e.first_name', 'e.last_name', 'd.name as department', 'p.is_active');
            $details = $project_details->first();
    
            $project_details1 = DB::table('projects as p')
                ->leftjoin('project_levels as pl', 'pl.project_id', '=', 'p.id')
                ->leftJoin('project_milestones as pm', 'pm.project_id', '=', 'p.id')
                ->leftjoin('employees as staff', 'staff.id', '=', 'pl.staff')
                ->where("p.id", '=', $id)
                ->select('p.ticket_no', 'p.created_at', 'pl.staff', 'pm.created_at as milestone_created', 'pm.mile_start_date', 'staff.profile_image as staff_image', 'staff.first_name as staff_first_name', 'staff.last_name as staff_last_name');
            $details1 = $project_details1->get();
            // dd($details1);
    
            $main_doc = DB::table('project_documents as p')
                ->where("p.project_id", '=', $id)
                ->where("p.type", '=', 1)
                ->select('*');
            $maindocument = $main_doc->get();
    
            $aux_doc = DB::table('project_documents as p')
                ->where("p.project_id", '=', $id)
                ->where("p.type", '=', 2)
                ->select('*');
            $auxdocument = $aux_doc->get();
    
            $project = Project::where('is_active', 1)->get()->toArray();
            $employees = Employee::where('is_active', 1)->get()->toArray();
            $departments = Department::where('is_active', 1)->get()->toArray();
            $designation = Designation::where('is_active', 1)->get()->toArray();
            $document_type = DocumentType::where('is_active', 1)->get()->toArray();
            $workflow = Workflow::where('is_active', 1)->get()->toArray();
            $levelCount = Workflow::leftjoin('projects', 'projects.workflow_id', '=', 'workflows.id')->where('projects.id', $id)->first()->total_levels;
    
            $projectModel  = Project::where('id', $id)->first();
    
            $models = Workflowlevels::with('workflowLevelDetail')->where('workflow_id', $projectModel->workflow_id)->get();
    
            $entities = collect($models)->map(function ($model) {
                $levelDetails = $model['workflowLevelDetail'];
    
                $empModel = WorkflowLevelDetail::select('employees.*')->leftjoin('employees', 'employees.id', '=', 'workflow_level_details.employee_id')->where('workflow_level_id', $model->id)->get()->toArray();
    
    
                $datas = ['levelId' => $model->levels, 'designationId' => $empModel];
    
                return $datas;
            });
            // dd($entities);
            $milestoneDatas = ProjectMilestone::where('project_id', $id)->get();
    
            return view('Docs/viewDocument', ['milestoneDatas' => $milestoneDatas, 'levelsArray' => $entities, 'levelCount' => $levelCount, 'maindocument' => $maindocument, 'auxdocument' => $auxdocument, 'details' => $details, 'details1' => $details1, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
       
    
    }
}
