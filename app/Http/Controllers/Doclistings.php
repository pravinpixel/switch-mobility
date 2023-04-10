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
use App\Models\ProjectMilestone;
use App\Models\Workflow;
use App\Models\WorkflowLevelDetail;
use App\Models\Workflowlevels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Doclistings extends Controller
{
    protected $basicController;
    public function __construct(BasicController $basicController)
    {
        $this->basicController = $basicController;
    }
    public function filterindex($type = null)
    {


        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";

        if ($empId) {
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
            $includedFilterProject = array();
            $finalFilterProject = array();

            foreach ($models1 as $modelData) {
                array_push($includedFilterProject, $modelData->id);
            }

            if ($type == "approved") {

                $filterModels = projectDocument::select('project_id')->whereIn('project_id', $includedFilterProject)
                    ->where('status', 4)
                    ->whereNull('deleted_at')
                    ->get();
            } else if ($type == "declined") {

                $filterModels = projectDocument::select('project_id')
                    ->whereIn('project_id', $includedFilterProject)
                    ->where('status', 2)
                    ->whereNull('deleted_at')
                    ->get();
            } else if ($type == "pending") {

                $filterModels = projectDocument::select('project_id')->whereIn('project_id', $includedFilterProject)
                    ->where('status', 1)
                    ->whereNull('deleted_at')
                    ->get();
            }

            foreach ($filterModels as $filterModel) {

                array_push($finalFilterProject, $filterModel->project_id);
            }
            $finalFilterProject = array_unique($finalFilterProject);
            $models = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
            if ($empId) {
                $models->whereHas('projectEmployees', function ($q) use ($empId) {
                    if ($empId != "") {
                        $q->where('employee_id', '=', $empId);
                    }
                });
            }

            $models->whereIn('id', $finalFilterProject);
            $models->whereNull('deleted_at');
            $models1 = $models->get();
        } else {

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
        }

        $project = $this->projectLooping($models1);
        $employees = Employee::where(['is_active' => 1])->get();
        $departments = Department::where(['is_active' => 1])->get();
        $designation = Designation::where(['is_active' => 1])->get();
        $document_type = DocumentType::where(['is_active' => 1])->get();
        $workflow = Workflow::where(['is_active' => 1])->get();
        $projectList = $project;

        return view('Docs/index', ['order_at' => $projectList, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation, 'projects' => $project]);
    }
    public function index()
    {

        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";

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

        $project = $this->projectLooping($models1);
        $employees = Employee::where(['is_active' => 1])->get();
        $departments = Department::where(['is_active' => 1])->get();
        $designation = Designation::where(['is_active' => 1])->get();
        $document_type = DocumentType::where(['is_active' => 1])->get();
        $workflow = Workflow::where(['is_active' => 1])->get();
        $projectList = $project;

        return view('Docs/index', ['order_at' => $projectList, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation, 'projects' => $project]);
    }
    public function projectLooping($models)
    {
        $empId = (Auth::user()->emp_id) ? Auth::user()->emp_id : "";


        $entities = collect($models)->map(function ($model) use ($empId) {

            $initiatorStatus = "no";
            $approverStatus = "no";
            if ($empId) {
                $initiatorStatus = ($model->initiator_id == $empId) ? "yes" : "no";
                $approverDatas = ProjectApprover::where('project_id', $model->id)->where('approver_id', $empId)->count();
                //dd($approverDatas);

                $approverStatus = ($approverDatas) ? "yes" : "no";
            }
            $model['initiatorStatus'] = $initiatorStatus;
            $model['approverStatus'] = $approverStatus;
            return $model;
        });
        return $entities;
    }
    public function docListingSearch(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $model = Project::select('projects.id', 'projects.id as projectId', 'projects.ticket_no', 'projects.project_code', 'projects.project_name', 'workflows.workflow_code', 'workflows.workflow_name', 'employees.first_name', 'departments.name as deptName');
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
        if ($startDate || $endDate) {
            $model->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate]);
            });
        }
        if ($request->department) {
            $model->where('departments.id', $request->department);
        }
        if ($request->designation) {
            $model->where('designations.id', $request->designation);
        }
        $data = $model->get();
        $models = $this->projectLooping($data);

        return response()->json($models);
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
    public function editDocument(Request $request)
    {

        if (Session::get('tempProject')) {
            $this->basicController->BasicFunction();
            Session::forget('tempProject');
        }

        $id = $request->id;
        $empId = Session::get('employeeId');
        if ($empId) {
            $includeEmployees = $this->getEmployeeInProject($id);
            if ($includeEmployees) {
                if (!in_array($empId, $includeEmployees)) {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }



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

        // $entities = collect($models)->map(function ($model) {

        //     $levelDetails = $model['workflowLevelDetail'];

        //     $empModel = WorkflowLevelDetail::select('employees.*')->leftjoin('employees', 'employees.id', '=', 'workflow_level_details.employee_id')->where('workflow_level_id', $model->id)->get()->toArray();


        //     $datas = ['levelId' => $model->levels, 'designationId' => $empModel];

        //     return $datas;
        // });
        // dd($entities);
        // dd($models);
        $dataArray = array();
        for ($i = 0; $i < count($models); $i++) {

            $empId = Session::get('employeeId');

            if ($empId) {
                $lastLimitLevel = ProjectEmployee::where('project_id', $id)->where('employee_id', $empId)->latest()->first();
            }

            $empModel = WorkflowLevelDetail::select('employees.*')->leftjoin('employees', 'employees.id', '=', 'workflow_level_details.employee_id')->where('workflow_level_id', $models[$i]->id)->get()->toArray();
            if ($empId) {
                if ($models[$i]->levels <= $lastLimitLevel->level) {
                    Log::info('Looping model Level ' . $models[$i]->levels . "Last Level " . $lastLimitLevel->level);

                    $datas = ['levelId' => $models[$i]->levels, 'designationId' => $empModel, 'test' => 1];
                    array_push($dataArray, $datas);
                }
            } else {
                $datas = ['levelId' => $models[$i]->levels, 'designationId' => $empModel];
                array_push($dataArray, $datas);
            }
        }

        $milestoneDatas = ProjectMilestone::where('project_id', $id)->get();

        return view('Docs/view', ['milestoneDatas' => $milestoneDatas, 'levelsArray' => $dataArray, 'levelCount' => $levelCount, 'maindocument' => $maindocument, 'auxdocument' => $auxdocument, 'details' => $details, 'details1' => $details1, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }

    public function viewDocListing(Request $request)
    {
        $id = $request->id;


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

        // dd($models);
        $dataArray = array();
        for ($i = 0; $i < count($models); $i++) {

            $empId = Session::get('employeeId');

            if ($empId) {
                $lastLimitLevel = ProjectEmployee::where('employee_id', $empId)->latest()->first();
            }

            $empModel = WorkflowLevelDetail::select('employees.*')->leftjoin('employees', 'employees.id', '=', 'workflow_level_details.employee_id')->where('workflow_level_id', $models[$i]->id)->get()->toArray();
            if ($empId) {
                if ($models[$i]->levels <= $lastLimitLevel->level) {
                    Log::info('Looping model Level ' . $models[$i]->levels . "Last Level " . $lastLimitLevel->level);

                    $datas = ['levelId' => $models[$i]->levels, 'designationId' => $empModel, 'test' => 1];
                    array_push($dataArray, $datas);
                }
            } else {
                $datas = ['levelId' => $models[$i]->levels, 'designationId' => $empModel];
                array_push($dataArray, $datas);
            }
        }
        $milestoneDatas = ProjectMilestone::where('project_id', $id)->get();

        return view('Docs/viewDocument', ['milestoneDatas' => $milestoneDatas, 'levelsArray' => $dataArray, 'levelCount' => count($dataArray), 'maindocument' => $maindocument, 'auxdocument' => $auxdocument, 'details' => $details, 'details1' => $details1, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }
    public function getEmployeeInProject($projectId)
    {
        $models = ProjectEmployee::with('employee')->where('project_id', $projectId)->groupBy('employee_id')->get();
        $employeeArray = [];
        foreach ($models as $model) {
            $employee = $model['employee'];
            $email = $employee->id;

            $employeeArray[] = $email;
        }
        return $employeeArray;
    }
}
