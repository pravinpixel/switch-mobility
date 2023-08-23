<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Email\EmailController;
use App\Models\Department;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectApprover;
use App\Models\projectDocument;
use App\Models\ProjectDocumentDetail;
use App\Models\ProjectDocumentFirstStage;
use App\Models\ProjectDocumentStatusByLevel;
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
    protected $basicController, $projectController, $emailController;
    public function __construct(BasicController $basicController, ProjectController $projectController, EmailController $emailController)
    {
        $this->basicController = $basicController;
        $this->projectController = $projectController;
        $this->emailController = $emailController;
    }
    public function filterindex($type = null)
    {


        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";



        $getmodels = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
        if ($empId) {
            $getmodels->whereHas('projectEmployees', function ($q) use ($empId) {
                if ($empId != "") {
                    $q->where('employee_id', '=', $empId);
                }
            });
        }

        $getmodels->whereNull('deleted_at');
        $getAllmodels = $getmodels->get();
        $approvedmodelIds = [];
        $declinedmodelIds = [];
        $overDuemodelIds = [];
        $pandingDocumentModelIds = [];
        foreach ($getAllmodels as $getAllmodel) {
            $projectId = $getAllmodel->id;
            $dueDate = $getAllmodel->end_date;
            $toDayDate = now()->toDateString();

            $date1 = \Carbon\Carbon::parse($dueDate);
            $date2 = \Carbon\Carbon::parse($toDayDate);

            $getLastLevel = $this->getLastLevelProject($projectId);
            $getStatus = ProjectDocumentStatusByLevel::where('level_id', $getLastLevel)
                ->where('project_id', $projectId)
                ->first();
            if ($getStatus->status == 4) {
                array_push($approvedmodelIds, $projectId);
            } elseif ($getStatus->status == 2) {
                if ($date1->lt($date2)) {
                    array_push($overDuemodelIds, $projectId);
                } else {
                    array_push($declinedmodelIds, $projectId);
                }
            } else {
                if ($date1->lt($date2)) {
                    array_push($overDuemodelIds, $projectId);
                } else {
                    array_push($pandingDocumentModelIds, $projectId);
                }
            }
        }


        $findmodels = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
        if ($empId) {
            $findmodels->whereHas('projectEmployees', function ($q) use ($empId) {
                if ($empId != "") {
                    $q->where('employee_id', '=', $empId);
                }
            });
        }
        $findmodels->whereNull('deleted_at');
        if ($type == "declined") {

            $findmodels->whereIn('projects.id', $declinedmodelIds);
        }
        if ($type == "approved") {
            $findmodels->whereIn('projects.id', $approvedmodelIds);
        }
        if ($type == "pending") {

            $findmodels->whereIn('projects.id', $pandingDocumentModelIds);
        }
        if ($type == "overdue") {

            $findmodels->whereIn('projects.id', $overDuemodelIds);
        }
        $findAllmodels = $findmodels->get();

        $project = $this->projectLooping($findAllmodels);
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
            $model->where('projects.id', $request->ticket_no);
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
        $levelCount = Workflow::leftjoin('projects', 'projects.workflow_id', '=', 'workflows.id')
            ->where('projects.id', $id)->first()->total_levels;

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
        // $dataArray = array();
        // for ($i = 0; $i < count($models); $i++) {

        //     $empId = Session::get('employeeId');

        //     if ($empId) {
        //         $lastLimitLevel = ProjectEmployee::where('project_id', $id)->where('type', 2)->where('employee_id', $empId)->latest()->first();
        //     }

        //     $empModel = WorkflowLevelDetail::select('employees.*')->leftjoin('employees', 'employees.id', '=', 'workflow_level_details.employee_id')->where('workflow_level_id', $models[$i]->id)->get()->toArray();
        //     if ($empId) {
        //         if ($models[$i]->levels <= $lastLimitLevel->level) {
        //             Log::info('Looping model Level ' . $models[$i]->levels . "Last Level " . $lastLimitLevel->level);

        //             $datas = ['levelId' => $models[$i]->levels, 'designationId' => $empModel, 'test' => 1];
        //             array_push($dataArray, $datas);
        //         }
        //     } else {
        //         $datas = ['levelId' => $models[$i]->levels, 'designationId' => $empModel];
        //         array_push($dataArray, $datas);
        //     }
        // }

        $milestoneDatas = ProjectMilestone::where('project_id', $id)->get();

        $loginedPersonRole = "";
        if ($empId) {
            if ($empId == $projectModel->initiator_id) {
                $loginedPersonRole = "initiator";
            } else {
                $loginedPersonRole = "approver";
            }
        } else {
            $loginedPersonRole = "admin";
        }

        $getAllLevels = [];
        if ($loginedPersonRole != "approver") {
            $projectEmpModels = ProjectEmployee::where('project_id', $projectModel->id)
                ->where('type', 1)
                ->get();
            foreach ($projectEmpModels as $projectEmpModel) {
                $response = ['levelId' => $projectEmpModel->level];
                array_push($getAllLevels, $response);
            }
        } else {


            $dataArray = array();
            for ($i = 0; $i < count($models); $i++) {



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
            $getAllLevels = $dataArray;
        }


        return view('Docs/editDocument', ['milestoneDatas' => $milestoneDatas, 'levelsArray' => $getAllLevels, 'levelCount' => $levelCount, 'maindocument' => $maindocument, 'auxdocument' => $auxdocument, 'details' => $details, 'details1' => $details1, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }

    public function viewDocListing(Request $request)
    {
        $id = $request->id;

        $empId = (Session::get('employeeId')) ? Session::get('employeeId') : "";
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




        $milestoneDatas = ProjectMilestone::where('project_id', $id)->get();

        $loginedPersonRole = "";
        if ($empId) {
            if ($empId == $projectModel->initiator_id) {
                $loginedPersonRole = "initiator";
            } else {
                $loginedPersonRole = "approver";
            }
        } else {
            $loginedPersonRole = "admin";
        }

        $getAllLevels = [];
        if ($loginedPersonRole != "approver") {
            $projectEmpModels = ProjectEmployee::where('project_id', $projectModel->id)
                ->where('type', 1)
                ->get();
            foreach ($projectEmpModels as $projectEmpModel) {
                $response = ['levelId' => $projectEmpModel->level];
                array_push($getAllLevels, $response);
            }
        } else {


            $dataArray = array();
            for ($i = 0; $i < count($models); $i++) {



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
            $getAllLevels = $dataArray;
        }



        return view('Docs/viewDocument', ['milestoneDatas' => $milestoneDatas, 'levelsArray' => $getAllLevels, 'levelCount' => count($getAllLevels), 'maindocument' => $maindocument, 'auxdocument' => $auxdocument, 'details' => $details, 'details1' => $details1, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
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

    public function getlevelwiseDocument(Request $request)
    {

        $level = $request->level;
        $projectId = $request->project_id;
        $lastLevel = $this->getLastLevelProject($projectId);
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";
        $approverLevels = [];
        if ($empId) {

            $projectEmpModels = ProjectEmployee::where('project_id', $projectId)->where('employee_id', $empId)->where('type', 2)->get();
            foreach ($projectEmpModels as $projectEmpModel) {
                array_push($approverLevels, $projectEmpModel->level);
            }
        }

        $mainAreaDocument = ProjectDocumentFirstStage::with(['GetDocDetail' => function ($q) use ($level) {
            // Query the name field in status table
            $q->where('upload_level', '<', $level)
                ->orWhere('upload_level', '=', $level); // '=' is optional
        }, 'GetDocDetail.employee'])
            ->where('level_id', $level)
            ->where('project_id', $projectId)->get();
        if (count($mainAreaDocument) != 0) {
            $auxdocument = projectDocument::select('*')
                ->leftjoin('project_document_details', 'project_document_details.project_doc_id', '=', 'project_documents.id')
                ->where("project_documents.project_id", '=', $projectId)
                ->where("project_documents.type", '=', 2)
                ->get();
        } else {
            $auxdocument = 0;
        }

        $ApproverExactLevel = false;
        if (in_array($level, $approverLevels)) {
            $ApproverExactLevel = true;
        }
        $response = ['ApproverExactLevel' => $ApproverExactLevel, 'main_docs' => $mainAreaDocument, 'aux_docs' => $auxdocument, 'lastLevel' => $lastLevel, 'approverLevels' => $approverLevels];
        return response()->json($response);
    }

    public function updatelevelwiseDocumentStatus(Request $request)
    {

        Log::info("DocListings Started " . json_encode($request->all()));

        $status = $request->status;
        $documentId = $request->documentId;

        $level = $request->levelId;
        $statusdocumentId = $request->statusdocumentId;
        $statuslevelId = $request->statuslevelId;
        $remark = $request->statusremarks;
        $empId = Auth::user()->emp_id;

        $getMainDocs = projectDocument::where('id', $documentId)->first();
        if ($getMainDocs) {
            $getMainDocs->status = $status;
            $getMainDocs->save();
        }

        $getParentModel = projectDocument::select('ticket_no', 'type', 'project_name', 'projects.id as projectId')
            ->leftjoin('projects', 'projects.id', 'project_documents.project_id')
            ->where('project_documents.id', $documentId)
            ->first();
        Log::info("DocListings get Parent Model " . json_encode($getParentModel));
        if ($getParentModel) {
            $projectId = $getParentModel->projectId;
            $ticketNo = $getParentModel->ticket_no;
            $finalApprovement = $this->finalApproveProject($projectId);

            $sendToInitiaterMail = $this->emailController->statusChange($projectId, $level, $status);




            Log::info("DocListings Project Id " . json_encode($projectId));

            if ($status == 4) {

                Log::info("DocListings Project Id " . json_encode($projectId));
                $nextLevel = $this->getNextLevel($documentId, $level);

                Log::info("DocListings nextLevel " . json_encode($nextLevel));
                if ($nextLevel) {
                    $levelApprovermail = $this->emailController->NewApprovalToApprover($projectId, $nextLevel);

                    Log::info('ProjectController->Store:-Approver Mail Response ' . json_encode($levelApprovermail));
                    $updateOldDocDetail = $this->updateDocDetails($documentId, $level, $status, $remark);
                    if ($updateOldDocDetail) {
                        Log::info("DocListings updateOldDocDetail Id " . json_encode($projectId));

                        $createNewLevelDocDetail = $this->upgradeNextLevelDocDetail($updateOldDocDetail->id, $nextLevel);
                        Log::info("DocListings createNewLevelDocDetail Id" . json_encode($createNewLevelDocDetail));

                        $updateDocFirstStage = $this->updateStage1Document($documentId, $level, $status);

                        Log::info("DocListings updateDocFirstStage Id " . json_encode($updateDocFirstStage));
                        if ($updateDocFirstStage) {

                            $createDocFirstStage = $this->createFirstStageModel($updateDocFirstStage, $nextLevel);

                            Log::info("DocListings createDocFirstStage Id " . json_encode($createDocFirstStage));

                            $updateStatusLevelOld = $this->UpdateToStatusLevelModel($projectId, $level, $documentId, $status);
                            Log::info("DocListings updateStatusLevelOld Id " . json_encode($updateStatusLevelOld));

                            $updateStatusLevelOld1 = $this->UpdateToStatusLevelModel($projectId, $nextLevel, $documentId, 1);
                            Log::info("DocListings updateStatusLevelOld1 Id " . json_encode($updateStatusLevelOld1));
                        }
                    }
                } else {
                    $updateOldDocDetail = $this->updateDocDetails($documentId, $level, $status, $remark, 1);
                    $updateDocFirstStage = $this->updateStage1Document($documentId, $level, $status);
                    $updateStatusCurrentLevel = $this->UpdateToStatusLevelModel($projectId, $level, $documentId, $status);
                    $getMainDocs = projectDocument::where('id', $documentId)->first();
                    if ($getMainDocs) {
                        $getMainDocs->status = 4;
                        $getMainDocs->save();
                    }
                    $sendMailfinalApproveProject = $this->finalApproveProject($projectId);
                }
            } else {
                $changeunApproveProjectStatus = Project::where('id', $projectId)->first();
                if ($changeunApproveProjectStatus)
                {
                    $changeunApproveProjectStatus->current_status = 1;
                    $changeunApproveProjectStatus->document_size = $request->document_size;
                    $changeunApproveProjectStatus->document_orientation = $request->document_orientation;
                    $changeunApproveProjectStatus->save();
                }

                if ($status == 2) {


                    $previousLevel = $this->getPreviousLevel($documentId, $level);
                    Log::info("DocListings previousLevel Id " . json_encode($previousLevel));
                    if ($previousLevel) {
                        $levelApprovermail = $this->emailController->NewApprovalToApprover($projectId, $previousLevel);
                        $updateStatusCurrentLevel = $this->UpdateToStatusLevelModel($projectId, $level, $documentId, $status);
                        Log::info("DocListings updateStatusCurrentLevel Id " . json_encode($updateStatusCurrentLevel));

                        $updateStatusPreviousLevel = $this->UpdateToStatusLevelModel($projectId, $previousLevel, $documentId, 1);
                        Log::info("DocListings updateStatusPreviousLevel Id " . json_encode($updateStatusPreviousLevel));

                        $updateDocDetail = $this->updateDocDetails($documentId, $level, $status, $remark);
                        Log::info("DocListings updateDocDetail Id " . json_encode($updateDocDetail));

                        // $fileUpload = $this->fileUpload($request->all(), $projectId, $getParentModel->ticket_no, $documentId, $previousLevel, 1);
                        // Log::info("DocListings updateStatusLevelOld1 Id " . json_encode($fileUpload));

                        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";
                        Log::info("fileupload empId" . json_encode($empId));

                        if ($request->file('againestDocument')) {


                            $typeOfDoc = 'main_document/';
                            $typeOfDocFile = 'MainDocument-v';

                            // $halfPath1 =  $parentModel->ticket_no . '/level-' . $request->levelId . "/" . $typeOfDoc;
                            // Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
                            // $upload_path1 = public_path() . '/projectDocuments/' . $halfPath1;

                            $path = public_path() . '/projectDocuments/' . $ticketNo . '/' . $typeOfDoc;
                            Log::info("fileupload >path " . json_encode($path));

                            $banner = $request->file('againestDocument')->getClientOriginalName();
                            $expbanner = explode('.', $banner);
                            $filePart0 = $expbanner[0];
                            $filePart1 = $expbanner[1];
                            Log::info('fileUpload ->filePart1' . json_encode($filePart1));
                            $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;
                            Log::info('fileUpload ->lastversion' . json_encode($lastversion));
                            $ed = date('YmdHis');
                            // Remove white spaces from the input string
                            $inputString = str_replace(' ', '', $expbanner[0]);
                            // Resize the string to 5 characters
                            $fileOrgName = substr($inputString, 0, 5);
                            Log::info('Doclisting->updatelevelwiseDocumentStatus :-fileOrgName ' . $fileOrgName);
                            $fileName1 = $ticketNo . "_" . $filePart0 . '_' . $ed . "." . $filePart1;


                            //$fileName1 = $parentModel->ticket_no . $typeOfDocF . $request->levelId . "s" . ($lastversion + 1) . "v" . ($lastversion + 1) . "." . $filePart1;
                            Log::info('fileupload ->:-fileName1' . json_encode($fileName1));
                            $bannerpath = $path . $fileName1;
                            if (move_uploaded_file($request->againestDocument->path(), $bannerpath)) {

                                $model = new ProjectDocumentDetail;
                                $model->version = $lastversion + 1;
                                $model->remark = "";
                                $model->project_doc_id = $request->documentId;
                                $model->status = 1;
                                $model->document_name = $ticketNo . '/' . $typeOfDoc . $fileName1;
                                $model->updated_by = $empId;
                                $model->project_id = $projectId;
                                $model->is_latest = 1;
                                $model->upload_level = $previousLevel;
                                $model->save();
                            }
                            Log::info('fileUpload ->Previous Level' . json_encode($previousLevel));
                            Log::info('fileUpload ->Current Level' . json_encode($level));

                            $stage1Model = $this->findProjectDocumentFirstStage($projectId, $documentId, $previousLevel);
                            Log::info('fileUpload ->stage1Model' . json_encode($stage1Model));
                            if ($stage1Model) {
                                $stage1Model->file_name = $fileName1;
                                $stage1Model->status = 1;
                                $stage1Model->save();
                            }
                            $stage2Model = $this->findProjectDocumentFirstStage($projectId, $documentId, $level);
                            Log::info('fileUpload ->stage2Model' . json_encode($stage2Model));
                            if ($stage2Model) {
                                $stage2Model->delete();
                            }
                        }
                        Log::info('fileUpload ->return');
                    } else {
                        $levelApprovermail = $this->emailController->NewApprovalToApprover($projectId, $level);
                        if ($request->file('againestDocument')) {

                            $updateOldData = $this->updateDocDetails($documentId, $level, $status, $remark);

                            $typeOfDoc = 'main_document/';
                            $typeOfDocFile = 'MainDocument-v';

                            // $halfPath1 =  $parentModel->ticket_no . '/level-' . $request->levelId . "/" . $typeOfDoc;
                            // Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
                            // $upload_path1 = public_path() . '/projectDocuments/' . $halfPath1;

                            $path = public_path() . '/projectDocuments/' . $ticketNo . '/' . $typeOfDoc;
                            Log::info("fileupload2 >path " . json_encode($path));

                            $banner = $request->file('againestDocument')->getClientOriginalName();
                            $expbanner = explode('.', $banner);
                            $filePart1 = $expbanner[1];
                            $filePart0 = $expbanner[0];
                            Log::info('fileUpload2 ->filePart1' . json_encode($filePart1));
                            $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;
                            Log::info('fileUpload2 ->lastversion' . json_encode($lastversion));



                            $ed = date('YmdHis');
                            // Remove white spaces from the input string
                            $inputString = str_replace(' ', '', $expbanner[0]);
                            // Resize the string to 5 characters
                            $fileOrgName = substr($inputString, 0, 5);
                            Log::info('Doclisting->updatelevelwiseDocumentStatus :-fileOrgName ' . $fileOrgName);
                            $fileName1 = $ticketNo . "_" . $filePart0 . '_' . $ed . "." . $filePart1;



                            //$fileName1 = $parentModel->ticket_no . $typeOfDocF . $request->levelId . "s" . ($lastversion + 1) . "v" . ($lastversion + 1) . "." . $filePart1;
                            Log::info('fileupload2 ->:-fileName1' . json_encode($fileName1));
                            $bannerpath = $path . $fileName1;
                            if (move_uploaded_file($request->againestDocument->path(), $bannerpath)) {

                                $model = new ProjectDocumentDetail;
                                $model->version = $lastversion + 1;
                                $model->remark = "";
                                $model->project_doc_id = $request->documentId;
                                $model->status = 1;
                                $model->document_name = $ticketNo . '/' . $typeOfDoc . $fileName1;
                                $model->updated_by = $empId;
                                $model->project_id = $projectId;
                                $model->is_latest = 1;
                                $model->upload_level = $level;
                                $model->save();
                            }

                            $stage1Model = $this->findProjectDocumentFirstStage($projectId, $documentId, $level);
                            Log::info('fileUpload2 ->stage1Model' . json_encode($stage1Model));
                            if ($stage1Model) {
                                $stage1Model->file_name = $fileName1;
                                $stage1Model->status = $status;
                                $stage1Model->save();
                            }
                        }
                        Log::info('fileUpload ->return 2');
                    }
                } else {
                    $updateStatusCurrentLevel = $this->UpdateToStatusLevelModel($projectId, $level, $documentId, $status);

                    $nextLevel = $this->getNextLevel($documentId, $level);
                    $updateOldData = $this->updateDocDetails($documentId, $level, $status, $remark);
                    if ($nextLevel) {
                        $setLevel = $nextLevel;
                    } else {
                        $setLevel = $level;
                    }
                    $typeOfDoc = 'main_document/';
                    $typeOfDocFile = 'MainDocument-v';
                    $levelApprovermail = $this->emailController->NewApprovalToApprover($projectId, $setLevel);
                    // $halfPath1 =  $parentModel->ticket_no . '/level-' . $request->levelId . "/" . $typeOfDoc;
                    // Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
                    // $upload_path1 = public_path() . '/projectDocuments/' . $halfPath1;

                    $path = public_path() . '/projectDocuments/' . $ticketNo . '/' . $typeOfDoc;
                    Log::info("fileupload2 >path " . json_encode($path));

                    $banner = $request->file('againestDocument')->getClientOriginalName();
                    $expbanner = explode('.', $banner);
                    $filePart0 = $expbanner[0];
                    $filePart1 = $expbanner[1];
                    Log::info('fileUpload2 ->filePart1' . json_encode($filePart1));
                    $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;
                    Log::info('fileUpload2 ->lastversion' . json_encode($lastversion));

                    $ed = date('YmdHis');
                    // Remove white spaces from the input string
                    $inputString = str_replace(' ', '', $expbanner[0]);
                    // Resize the string to 5 characters
                    $fileOrgName = substr($inputString, 0, 5);
                    Log::info('Doclisting->updatelevelwiseDocumentStatus :-fileOrgName ' . $fileOrgName);
                    $fileName1 = $ticketNo . "_" . $filePart0 . '_' . $ed . "." . $filePart1;

                    //$fileName1 = $parentModel->ticket_no . $typeOfDocF . $request->levelId . "s" . ($lastversion + 1) . "v" . ($lastversion + 1) . "." . $filePart1;
                    Log::info('fileupload2 ->:-fileName1' . json_encode($fileName1));
                    $bannerpath = $path . $fileName1;
                    if (move_uploaded_file($request->againestDocument->path(), $bannerpath)) {

                        $model = new ProjectDocumentDetail;
                        $model->version = $lastversion + 1;
                        $model->remark = "";
                        $model->project_doc_id = $request->documentId;
                        $model->status = 1;
                        $model->document_name = $ticketNo . '/' . $typeOfDoc . $fileName1;
                        $model->updated_by = $empId;
                        $model->project_id = $projectId;
                        $model->is_latest = 1;
                        $model->upload_level = $setLevel;
                        $model->save();
                    }

                    $stage1Model = $this->findProjectDocumentFirstStage($projectId, $documentId, $level);

                    Log::info('fileUpload2 ->stage1Model' . json_encode($stage1Model));
                    if ($stage1Model) {
                        $stage1Model->status = $status;
                        $stage1Model->save();
                        $createDocFirstStage = $this->createFirstStageModel($stage1Model, $setLevel, $fileName1);
                        if (!$nextLevel) {
                            $stage1Model->delete();
                        }
                    }
                }
                Log::info('fileUpload ->return 2');
            }
        }

        // if ($getParentModel) {
        //     $projectId = $getParentModel->projectId;
        //     //$updateDocDetail = $this->covertDocDetailModel(1, $projectId, $level, $empId, $documentId, $status, $remark);


        //     if ($status == 4) {


        //         $levelModel = $this->ConvertToStatusLevelModel($projectId, $level, $documentId, $status);

        //         $updateDocs = $this->updateApproveStatusDocs($documentId, $level, $remark);
        //         if ($updateDocs) {



        //             $stage1Model = $this->findStage1Document($documentId, $level);

        //             if ($stage1Model) {
        //                 $stage1Model->status = $status;
        //                 $stage1Model->save();
        //                 //create New Stage
        //                 $getNextRecord = ProjectDocumentStatusByLevel::where('project_id', $projectId)
        //                     ->where('doc_id', $documentId)
        //                     ->where('level_id', '>', $level)
        //                     ->orderBy('id', 'asc')
        //                     ->first();
        //                 if ($getNextRecord) {
        //                     $newStage = $this->projectController->convertToModelProjectDocumentStage1($projectId, $documentId, $stage1Model->file_name, $getNextRecord->level_id);
        //                     $newDetail = $this->covertDocDetailModel($updateDocs->id, $getNextRecord->level_id);
        //                 }
        //             }
        //         }
        //     } else {

        //         if ($status == 2) {

        //             $checkCurrentLevelStatus = ProjectDocumentDetail::where('project_doc_id', $documentId)
        //                 ->where('upload_level', $level)
        //                 ->where('status', '!=', 1)
        //                 ->where('is_latest',  1)
        //                 ->get();
        //             // dd(count($checkCurrentLevelStatus));
        //             if (count($checkCurrentLevelStatus) == 0) {

        //                 $getPreviousLevelRecord = ProjectDocumentStatusByLevel::where('project_id', $projectId)
        //                     ->where('doc_id', $documentId)
        //                     ->where('level_id', '<', $level)
        //                     ->orderBy('id', 'asc')
        //                     ->first();

        //                 if ($getPreviousLevelRecord) {
        //                     $removeWaitingApproval = ProjectDocumentDetail::where('project_doc_id', $documentId)
        //                         ->where('upload_level', $level)
        //                         ->where('status', '=', 1)
        //                         ->first();
        //                     if ($removeWaitingApproval) {
        //                         $preLevel = $getPreviousLevelRecord->level_id;
        //                         $updatecurrentLevelStatus = $this->ConvertToStatusLevelModel($projectId, $level, $documentId, 2);
        //                         $updatePreviousLevelStatus = $this->ConvertToStatusLevelModel($projectId, $preLevel, $documentId, 1);
        //                         //$removeWaitingApproval->delete();
        //                         $stage2Model = $this->findStage1Document($documentId, $level);
        //                         if ($stage2Model) {
        //                             $stage2Model->delete();
        //                         }
        //                         if ($request->file('againestDocument')) {


        //                             $typeOfDoc = 'main_document/';
        //                             $typeOfDocFile = 'MainDocument-v';

        //                             // $halfPath1 =  $parentModel->ticket_no . '/level-' . $request->levelId . "/" . $typeOfDoc;
        //                             // Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
        //                             // $upload_path1 = public_path() . '/projectDocuments/' . $halfPath1;

        //                             $path = public_path() . '/projectDocuments/' . $getParentModel->ticket_no . '/' . $typeOfDoc;


        //                             $banner = $request->file('againestDocument')->getClientOriginalName();
        //                             $expbanner = explode('.', $banner);
        //                             $filePart1 = $expbanner[1];
        //                             Log::info('ProjectController->Store:-filePart1' . json_encode($filePart1));
        //                             $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;
        //                             $ed = date('ymdhms');
        //                             $fileName1 = $expbanner[0] . '_' . $ed . "." . $filePart1;


        //                             //$fileName1 = $parentModel->ticket_no . $typeOfDocF . $request->levelId . "s" . ($lastversion + 1) . "v" . ($lastversion + 1) . "." . $filePart1;
        //                             Log::info('ProjectController->Store:-fileName1' . json_encode($fileName1));
        //                             $bannerpath = $path . $fileName1;
        //                             if (move_uploaded_file($request->againestDocument->path(), $bannerpath)) {

        //                                 $model = new ProjectDocumentDetail;
        //                                 $model->version = $lastversion + 1;
        //                                 $model->remark = "";
        //                                 $model->project_doc_id = $request->documentId;
        //                                 $model->status = 1;
        //                                 $model->document_name = $getParentModel->ticket_no . '/' . $typeOfDoc . $fileName1;
        //                                 $model->updated_by = $empId;
        //                                 $model->project_id = $projectId;
        //                                 $model->is_latest = 1;
        //                                 $model->upload_level = $preLevel;
        //                                 $model->save();
        //                             }

        //                             $stage1Model = $this->findStage1Document($documentId, $preLevel);
        //                             if ($stage1Model) {
        //                                 $stage1Model->file_name = $fileName1;
        //                                 $stage1Model->status = $status;
        //                                 $stage1Model->save();
        //                             }
        //                         }
        //                     }
        //                 } else {
        //                     $updateDocs = $this->updateUnApproveStatusDocs($documentId, $level, $remark, $empId, $status);
        //                     if ($request->file('againestDocument')) {


        //                         $typeOfDoc = 'main_document/';
        //                         $typeOfDocFile = 'MainDocument-v';

        //                         // $halfPath1 =  $parentModel->ticket_no . '/level-' . $request->levelId . "/" . $typeOfDoc;
        //                         // Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
        //                         // $upload_path1 = public_path() . '/projectDocuments/' . $halfPath1;

        //                         $path = public_path() . '/projectDocuments/' . $getParentModel->ticket_no . '/' . $typeOfDoc;


        //                         $banner = $request->file('againestDocument')->getClientOriginalName();
        //                         $expbanner = explode('.', $banner);
        //                         $filePart1 = $expbanner[1];
        //                         Log::info('ProjectController->Store:-filePart1' . json_encode($filePart1));
        //                         $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;
        //                         $ed = date('ymdhms');
        //                         $fileName1 = $expbanner[0] . '_' . $ed . "." . $filePart1;


        //                         //$fileName1 = $parentModel->ticket_no . $typeOfDocF . $request->levelId . "s" . ($lastversion + 1) . "v" . ($lastversion + 1) . "." . $filePart1;
        //                         Log::info('ProjectController->Store:-fileName1' . json_encode($fileName1));
        //                         $bannerpath = $path . $fileName1;
        //                         if (move_uploaded_file($request->againestDocument->path(), $bannerpath)) {

        //                             $model = new ProjectDocumentDetail;
        //                             $model->version = $lastversion + 1;
        //                             $model->remark = "";
        //                             $model->project_doc_id = $request->documentId;
        //                             $model->status = 1;
        //                             $model->document_name = $getParentModel->ticket_no . '/' . $typeOfDoc . $fileName1;
        //                             $model->updated_by = $empId;
        //                             $model->project_id = $projectId;
        //                             $model->is_latest = 1;
        //                             $model->upload_level = $level;
        //                             $model->save();
        //                         }

        //                         $stage1Model = $this->findStage1Document($documentId, $level);
        //                         if ($stage1Model) {
        //                             $stage1Model->file_name = $fileName1;
        //                             $stage1Model->status = $status;
        //                             $stage1Model->save();
        //                         }
        //                     }
        //                 }
        //             } else {
        //                 // $updateDocs = $this->updateUnApproveStatusDocs($documentId, $level, $remark, $empId, $status);
        //                 if ($request->file('againestDocument')) {


        //                     $typeOfDoc = 'main_document/';
        //                     $typeOfDocFile = 'MainDocument-v';

        //                     // $halfPath1 =  $parentModel->ticket_no . '/level-' . $request->levelId . "/" . $typeOfDoc;
        //                     // Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
        //                     // $upload_path1 = public_path() . '/projectDocuments/' . $halfPath1;

        //                     $path = public_path() . '/projectDocuments/' . $getParentModel->ticket_no . '/' . $typeOfDoc;


        //                     $banner = $request->file('againestDocument')->getClientOriginalName();
        //                     $expbanner = explode('.', $banner);
        //                     $filePart1 = $expbanner[1];
        //                     Log::info('ProjectController->Store:-filePart1' . json_encode($filePart1));
        //                     $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;
        //                     $ed = date('ymdhms');
        //                     $fileName1 = $expbanner[0] . '_' . $ed . "." . $filePart1;


        //                     //$fileName1 = $parentModel->ticket_no . $typeOfDocF . $request->levelId . "s" . ($lastversion + 1) . "v" . ($lastversion + 1) . "." . $filePart1;
        //                     Log::info('ProjectController->Store:-fileName1' . json_encode($fileName1));
        //                     $bannerpath = $path . $fileName1;
        //                     if (move_uploaded_file($request->againestDocument->path(), $bannerpath)) {

        //                         $model = new ProjectDocumentDetail;
        //                         $model->version = $lastversion + 1;
        //                         $model->remark = "";
        //                         $model->project_doc_id = $request->documentId;
        //                         $model->status = 1;
        //                         $model->document_name = $getParentModel->ticket_no . '/' . $typeOfDoc . $fileName1;
        //                         $model->updated_by = $empId;
        //                         $model->project_id = $projectId;
        //                         $model->is_latest = 1;
        //                         $model->upload_level = $level;
        //                         $model->save();
        //                     }

        //                     $stage1Model = $this->findStage1Document($documentId, $level);
        //                     if ($stage1Model) {
        //                         $stage1Model->file_name = $fileName1;
        //                         $stage1Model->status = $status;
        //                         $stage1Model->save();
        //                     }
        //                 }
        //             }
        //         } else {
        //             $levelModel = $this->ConvertToStatusLevelModel($projectId, $level, $documentId, $status);
        //             $updateDocs = $this->updateUnApproveStatusDocs($documentId, $level, $remark, $empId, $status);

        //             if ($request->file('againestDocument')) {


        //                 $typeOfDoc = 'main_document/';
        //                 $typeOfDocFile = 'MainDocument-v';

        //                 // $halfPath1 =  $parentModel->ticket_no . '/level-' . $request->levelId . "/" . $typeOfDoc;
        //                 // Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
        //                 // $upload_path1 = public_path() . '/projectDocuments/' . $halfPath1;

        //                 $path = public_path() . '/projectDocuments/' . $getParentModel->ticket_no . '/' . $typeOfDoc;


        //                 $banner = $request->file('againestDocument')->getClientOriginalName();
        //                 $expbanner = explode('.', $banner);
        //                 $filePart1 = $expbanner[1];
        //                 Log::info('ProjectController->Store:-filePart1' . json_encode($filePart1));
        //                 $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;
        //                 $ed = date('ymdhms');
        //                 $fileName1 = $expbanner[0] . '_' . $ed . "." . $filePart1;


        //                 //$fileName1 = $parentModel->ticket_no . $typeOfDocF . $request->levelId . "s" . ($lastversion + 1) . "v" . ($lastversion + 1) . "." . $filePart1;
        //                 Log::info('ProjectController->Store:-fileName1' . json_encode($fileName1));
        //                 $bannerpath = $path . $fileName1;
        //                 if (move_uploaded_file($request->againestDocument->path(), $bannerpath)) {

        //                     $model = new ProjectDocumentDetail;
        //                     $model->version = $lastversion + 1;
        //                     $model->remark = "";
        //                     $model->project_doc_id = $request->documentId;
        //                     $model->status = 1;
        //                     $model->document_name = $getParentModel->ticket_no . '/' . $typeOfDoc . $fileName1;
        //                     $model->updated_by = $empId;
        //                     $model->project_id = $projectId;
        //                     $model->is_latest = 1;
        //                     $model->upload_level = $level;
        //                     $model->save();
        //                 }

        //                 $stage1Model = $this->findStage1Document($documentId, $level);
        //                 if ($stage1Model) {
        //                     $stage1Model->file_name = $fileName1;
        //                     $stage1Model->status = $status;
        //                     $stage1Model->save();
        //                 }
        //             }
        //         }
        //     }
        // }
        return response()->json(['staus' => "Success"]);
    }
    public function finalApproveProject($projectId)
    {
        $totCompletedDocs = 0;
        $projectDocumentModels = projectDocument::where('project_id', $projectId)->where('type', 1)->get();
        $totalDocs = count($projectDocumentModels);
        Log::info("Total Docs" . json_encode($totalDocs));
        foreach ($projectDocumentModels as $projectDocumentModel) {
            $documentId = $projectDocumentModel->id;
            $lastDocLeveId = $this->getLastLevelProject($projectId);
            $subDocLevelModel = $this->findProjectDocumentFirstStage($projectId, $documentId, $lastDocLeveId);

            if ($subDocLevelModel) {
                $totCompletedDocs += ($subDocLevelModel->status == 4) ? 1 : 0;
            }
        }
        Log::info("totCompletedDocs " . json_encode($totCompletedDocs));
        if ($totalDocs == $totCompletedDocs) {
            $pModel = Project::where('id', $projectId)->first();
            if ($pModel) {
                $pModel->current_status = 4;
                $pModel->save();
            }
            $finalApproveMail = $this->emailController->finalApprovementProject($projectId);
        }
        return true;
    }

    public function updateDocDetails($documentId, $level, $status, $remark = null, $type = null)
    {
        Log::info("updateDocDetails >documentId " . json_encode($documentId));
        Log::info("updateDocDetails >level " . json_encode($level));
        Log::info("updateDocDetails >status " . json_encode($status));
        Log::info("updateDocDetails >remark " . json_encode($remark));

        $model = ProjectDocumentDetail::where('project_doc_id', $documentId)
            ->where('upload_level', $level)
            ->where('is_latest', 1)
            ->first();
        Log::info("updateDocDetails >model " . json_encode($model));
        if ($model) {
            if ($type) {
                $model->is_latest = 1;
            } else {
                $model->is_latest = 0;
            }
            $model->status = $status;
            $model->remark = $remark;
            $model->save();
        }
        Log::info("updateDocDetails >model response " . json_encode($model));
        return $model;
    }
    public function upgradeNextLevelDocDetail($oldRecordId, $nextLevel)
    {
        $oldModel  = ProjectDocumentDetail::where('id', $oldRecordId)->first();
        if ($oldModel) {

            $model = new ProjectDocumentDetail;
            $model->version = $oldModel->version + 1;
            $model->project_doc_id = $oldModel->project_doc_id;
            $model->status = 1;
            $model->document_name = $oldModel->document_name;
            $model->project_id = $oldModel->project_id;
            $model->is_latest = 1;
            $model->upload_level = $nextLevel;
            $model->save();
        }

        return $model;
    }
    public function getPreviousLevel($documentId, $level)
    {
        $model  = ProjectDocumentStatusByLevel::where('doc_id', $documentId)
            ->where('level_id', '<', $level)
            ->orderBy('id', 'desc')
            ->first();

        if ($model) {
            $level = $model->level_id;
        } else {
            $level = false;
        }
        return $level;
    }
    public function getNextLevel($documentId, $level)
    {


        $model  = ProjectDocumentStatusByLevel::where('doc_id', $documentId)
            ->where('level_id', '>', $level)
            ->orderBy('id', 'asc')
            ->first();

        if ($model) {
            $level = $model->level_id;
        } else {
            $level = false;
        }
        return $level;
    }

    public function findProjectDocumentFirstStage($projectId, $documentId, $level)
    {
        return ProjectDocumentFirstStage::where('project_id', $projectId)->where('doc_id', $documentId)->where('level_id', $level)->first();
    }
    public function createFirstStageModel($oldStageModel, $nextLevel, $fileName = null)
    {

        $model = new ProjectDocumentFirstStage();
        $model->project_id = $oldStageModel->project_id;
        $model->doc_id = $oldStageModel->doc_id;
        $model->level_id = $nextLevel;
        $model->file_name = ($fileName) ? $fileName : $oldStageModel->file_name;
        $model->status = 1;
        $model->save();

        return $model;
    }

    public function UpdateToStatusLevelModel($projectId, $level, $documentId, $status)
    {
        $levelModel = ProjectDocumentStatusByLevel::where('project_id', $projectId)
            ->where('level_id', $level)
            ->where('doc_id', $documentId)
            ->first();

        if ($levelModel) {
            $levelModel->status = $status;
            $levelModel->save();
            return $levelModel;
        } else {
            return false;
        }
    }

    public function updateStage1Document($docId, $level, $status = null)
    {
        $model = ProjectDocumentFirstStage::where('doc_id', $docId)->where('level_id', $level)->first();
        if ($model) {
            $model->status = ($status) ? $status : 1;
            $model->save();
            return $model;
        }
        return false;
    }

    public function getLastLevelProject($projectId, $documentId = null)
    {
        if ($documentId) {
            $models = ProjectDocumentStatusByLevel::where('project_id', $projectId)->where('doc_id', $documentId)->get();
        } else {
            $models = ProjectDocumentStatusByLevel::where('project_id', $projectId)->get();
        }
        $array = $models->toArray();
        if (count($array)) {
            $lastElement = array_slice($array, -1)[0];
            $level = $lastElement['level_id'];
        } else {
            $level = false;
        }
        return $level;
    }

    public function fileUpload($request, $projectId, $ticketNo, $documentId, $level, $status)
    {
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";
        Log::info("fileupload empId" . json_encode($empId));

        if ($request->file('againestDocument')) {


            $typeOfDoc = 'main_document/';
            $typeOfDocFile = 'MainDocument-v';

            // $halfPath1 =  $parentModel->ticket_no . '/level-' . $request->levelId . "/" . $typeOfDoc;
            // Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
            // $upload_path1 = public_path() . '/projectDocuments/' . $halfPath1;

            $path = public_path() . '/projectDocuments/' . $ticketNo . '/' . $typeOfDoc;
            Log::info("fileupload >path " . json_encode($path));

            $banner = $request->file('againestDocument')->getClientOriginalName();
            $expbanner = explode('.', $banner);
            $filePart0 = $expbanner[0];
            $filePart1 = $expbanner[1];
            Log::info('fileUpload ->filePart1' . json_encode($filePart1));
            $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;
            Log::info('fileUpload ->lastversion' . json_encode($lastversion));
            $ed = date('YmdHis');
            // Remove white spaces from the input string
            $inputString = str_replace(' ', '', $expbanner[0]);
            // Resize the string to 5 characters
            $fileOrgName = substr($inputString, 0, 5);
            Log::info('Doclisting->updatelevelwiseDocumentStatus :-fileOrgName ' . $fileOrgName);
            $fileName1 = $ticketNo . '_' . $filePart0 . '_' . $ed . "." . $filePart1;



            //$fileName1 = $parentModel->ticket_no . $typeOfDocF . $request->levelId . "s" . ($lastversion + 1) . "v" . ($lastversion + 1) . "." . $filePart1;
            Log::info('fileupload ->:-fileName1' . json_encode($fileName1));
            $bannerpath = $path . $fileName1;
            if (move_uploaded_file($request->againestDocument->path(), $bannerpath)) {

                $model = new ProjectDocumentDetail;
                $model->version = $lastversion + 1;
                $model->remark = "";
                $model->project_doc_id = $request->documentId;
                $model->status = 1;
                $model->document_name = $ticketNo . '/' . $typeOfDoc . $fileName1;
                $model->updated_by = $empId;
                $model->project_id = $projectId;
                $model->is_latest = 1;
                $model->upload_level = $level;
                $model->save();
            }

            $stage1Model = $this->findStage1Document($documentId, $level);
            Log::info('fileUpload ->stage1Model' . json_encode($stage1Model));
            if ($stage1Model) {
                $stage1Model->file_name = $fileName1;
                $stage1Model->status = $status;
                $stage1Model->save();
            }
        }
        Log::info('fileUpload ->return');
        return true;
    }

    public function covertDocDetailModel($oldId, $nextLevel)
    {

        $oldModel  = ProjectDocumentDetail::where('id', $oldId)->first();
        if ($oldModel) {

            $model = new ProjectDocumentDetail;
            $model->version = $oldModel->version + 1;
            $model->project_doc_id = $oldModel->project_doc_id;
            $model->status = 1;
            $model->document_name = $oldModel->document_name;
            $model->project_id = $oldModel->project_id;
            $model->is_latest = 1;
            $model->upload_level = $nextLevel;
            $model->save();
        }
        return $model;
    }


    public function updateApproveStatusDocs($documentId, $level, $remark)
    {
        $model =  ProjectDocumentDetail::where('project_doc_id', $documentId)
            ->where('upload_level', $level)
            ->where('is_latest', 1)
            ->first();
        if ($model) {

            $model->remark = $remark;
            $model->status = 4;
            $model->save();
        }
        return $model;
    }
    public function updateUnApproveStatusDocs($documentId, $level, $remark, $empId, $status)
    {
        $model =  ProjectDocumentDetail::where('project_doc_id', $documentId)
            ->where('upload_level', $level)
            ->where('is_latest', 1)
            ->first();
        //dd($model);
        if ($model) {
            $model->updated_by = $empId;
            $model->remark = $remark;
            $model->status = $status;
            $model->is_latest = 0;
            $model->save();
        }
        return $model;
    }
    public function getProjectByWorkflow(Request $request)
    {
        $wfId = $request->workflow;

        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";


        $models = Project::with('employee', 'employee.department', 'projectEmployees', 'workflow');
        if ($empId) {
            $models->whereHas('projectEmployees', function ($q) use ($empId) {
                if ($empId != "") {
                    $q->where('employee_id', '=', $empId);
                }
            });
        }
        if ($wfId) {
            $models->whereHas('workflow', function ($q1) use ($wfId) {

                $q1->where('workflow_id', '=', $wfId);
            });
        }
        $models->whereNull('deleted_at');
        $models1 = $models->get();

        $entities = collect($models1)->map(function ($model) {

            $ticket_no = $model->ticket_no;
            $projectName = $model->project_name . ' & ' . $model->project_code;
            $workflowModel = $model->workflow;
            $workflowName = $workflowModel->workflow_name . ' & ' . $workflowModel->workflow_code;
            $employeeModel = $model->employee;
            $initiaterName = $employeeModel->first_name . ' ' . $employeeModel->middle_name . ' ' . $employeeModel->last_name;
            $departmentModel = $employeeModel->department;
            $department = $departmentModel->name;

            $response = ['projectId' => $model->id, 'department' => $department, 'ticketNo' => $ticket_no, 'projectName' => $projectName, 'workflowName' => $workflowName, 'initiaterName' => $initiaterName];
            return $response;
        });
        return response()->json(['datas' => $entities]);
    }

    public function getProjectById(Request $request)
    {
        $projectId = $request->projectId;

        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";


        $models = Project::with('employee', 'employee.department', 'projectEmployees', 'workflow');
        if ($empId) {
            $models->whereHas('projectEmployees', function ($q) use ($empId) {
                if ($empId != "") {
                    $q->where('employee_id', '=', $empId);
                }
            });
        }
        if ($projectId) {
            $models->where('id', '=', $projectId);
        }
        $models->whereNull('deleted_at');
        $models1 = $models->get();

        $entities = collect($models1)->map(function ($model) {

            $ticket_no = $model->ticket_no;
            $projectName = $model->project_name . ' & ' . $model->project_code;
            $workflowModel = $model->workflow;
            $workflowName = $workflowModel->workflow_name . ' & ' . $workflowModel->workflow_code;
            $employeeModel = $model->employee;
            $initiaterName = $employeeModel->first_name . ' ' . $employeeModel->middle_name . ' ' . $employeeModel->last_name;
            $departmentModel = $employeeModel->department;
            $department = $departmentModel->name;

            $response = ['projectId' => $model->id, 'department' => $department, 'ticketNo' => $ticket_no, 'projectName' => $projectName, 'workflowName' => $workflowName, 'initiaterName' => $initiaterName];
            return $response;
        });

        return response()->json(['datas' => $entities]);
    }

    public function approverDownloadDocs(Request $request)
    {

        $model = ProjectDocumentDetail::where('id', $request->documentId)->where('is_downloaded', 0)->first();
        if ($model) {
            $model->is_downloaded = 1;
            $model->is_downloaded_time = date('Y-m-d H:i:s');
            $model->save();
        }
        return response()->json(['status' => "success"]);
    }
}
