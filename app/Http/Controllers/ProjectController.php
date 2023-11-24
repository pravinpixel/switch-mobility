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
use App\Models\ProjectLevels;
use App\Models\ProjectMilestone;
use App\Models\Workflow;
use App\Models\WorkflowLevelDetail;
use App\Models\Workflowlevels;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PDO;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    protected $wfController, $emailController;
    public function __construct(WorkflowController $wfController, EmailController $emailController)
    {
        $this->wfController = $wfController;
        $this->emailController = $emailController;
    }
    public function index()
    {

        $projects_all = $this->get_all_projects();
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

        // dd($models1[0]['employee']);


        $employees = Employee::where('is_active', 1)->get()->toArray();

        $departments = Department::where('is_active', 1)->get()->toArray();
        $designation = Designation::where('is_active', 1)->get()->toArray();
        $document_type = DocumentType::where('is_active', 1)->get()->toArray();
        $workflow = Workflow::where('is_active', 1)->get()->toArray();

        $initiaterModels = $models1;
        $initiaterDatas = array();
        $initiaterEntities = collect($models1)->map(function ($initiaterModel) {
            return  $initiaterModel['employee']->id;
        });
        $initiaterIds = ($initiaterEntities->unique())->toArray();
        $initiaters = Employee::whereIn('id', $initiaterIds)->where('is_active', 1)->whereNull('deleted_at')->get()->toArray();



        return view('Projects/list', ['initiaters' => $initiaters, 'document_type' => $document_type, 'workflow' => $workflow, 'projects_all' => $models1, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
        //return view('Projects/listPageOrg', ['document_type' => $document_type, 'workflow' => $workflow, 'projects_all' => $projects_all, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }
    public function create()
    {
        $employee = Employee::where('is_active', 1)->whereNull('deleted_at')->get();
        $document_type = DocumentType::where('is_active', 1)->whereNull('deleted_at')->get();
        $workflow = Workflow::where('is_active', 1)->whereNull('deleted_at')->get();
        $project = array();
        return view('Projects/create', compact('employee', 'document_type', 'workflow', 'project'));
    }
    public function edit($id)
    {
        $employee = Employee::whereNull('deleted_at')->get();
        $document_type = DocumentType::whereNull('deleted_at')->get();
        $workflow = Workflow::whereNull('deleted_at')->get();
        $project = Project::with('employee', 'employee.department', 'employee.designation', 'docType', 'workflow', 'milestone')->where('id', $id)->first();

        $levelModels = $this->getProjectLevelLooping($id);

        return view('Projects/edit', compact('employee', 'document_type', 'workflow', 'project', 'levelModels'));
    }
    public function show($id)
    {

        $employee = Employee::whereNull('deleted_at')->get();
        $document_type = DocumentType::whereNull('deleted_at')->get();
        $workflow = Workflow::whereNull('deleted_at')->get();
        $project = Project::with('employee', 'employee.department', 'employee.designation', 'docType', 'workflow', 'milestone')->where('id', $id)->first();

        $levelModels = $this->getProjectLevelLooping($id);

        // dd($levelModels);
        return view('Projects/edit', compact('employee', 'document_type', 'workflow', 'project', 'levelModels'));
    }
    public function projectEdit(Request $request)
    {

        $id = $request->id;

        $employee = Employee::whereNull('deleted_at')->get();
        $document_type = DocumentType::whereNull('deleted_at')->get();
        $workflow = Workflow::whereNull('deleted_at')->get();
        $project = Project::with('employee', 'employee.department', 'employee.designation', 'docType', 'workflow', 'milestone')->where('id', $id)->first();

        $levelModels = $this->getProjectLevelLooping($id);
        $isDocuments = projectDocument::where('project_id', $id)->count();
        $wfLevel = $this->getWorkflowFirstLevel($project->workflow_id);

        $mainDocumentPath = "";

        if ($isDocuments && $wfLevel) {
            $getFile = ProjectDocumentDetail::leftjoin('project_documents', 'project_documents.id', '=', 'project_document_details.project_doc_id')
                ->where('project_documents.project_id', $id)
                ->where('upload_level', $wfLevel->levels)
                ->where('project_documents.type', 1)
                ->where('version', 1)
                ->first();
            if ($getFile) {
                $mainDocumentPath = "projectDocuments/" . $getFile->document_name;
            }
        }

        $getDocDetails = ProjectDocumentDetail::leftjoin('project_documents', 'project_documents.id', '=', 'project_document_details.project_doc_id')
            ->where('project_documents.project_id', $id)
            ->where('project_documents.type', 1)
            ->get();
        $totDocCount = count($getDocDetails);

        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";
        $isLogginedPerson = "";

        $isAllowDeleteMainDocument = false;
        if ($empId) {
            if ($empId == $project->initiater_id) {
                if ($totDocCount == 0 || $totDocCount == 1) {
                    $isAllowDeleteMainDocument = true;
                }
            }
        } else {
            if ($totDocCount == 0 || $totDocCount == 1) {
                $isAllowDeleteMainDocument = true;
            }
        }

        return view('Projects/edit', compact('isAllowDeleteMainDocument', 'mainDocumentPath', 'employee', 'document_type', 'workflow', 'project', 'levelModels', 'isDocuments'));
    }

    public function getWorkflowFirstLevel($wfId)
    {
        return  Workflowlevels::where('workflow_id', $wfId)->first();
    }
    public function get_all_projects()
    {
        $projects = DB::table('projects as p')
            ->select('*', 'p.id as project_id', 'p.is_active as project_status')
            ->join('employees as e', 'e.id', '=', 'p.initiator_id')
            ->where('p.is_active', 1)
            ->get();
        return $projects;
    }

    public function getProjectDetailsById(Request $request)
    {
        $project_id = $request->project_id;
        $level = $request->level;
        $output = array();
        $project = Project::where('id', $project_id)->first();
        $milestone = ProjectMilestone::where('project_id', $project_id)->get()->toArray();
        $levels = ProjectLevels::where('project_id', $project_id)->get()->toArray();
        $main_documents = projectDocument::where(['project_id' => $project_id, 'project_level' => $level ? $level : 1, 'type' => 1])->get()->toArray();
        $aux_documents = projectDocument::where(['project_id' => $project_id, 'project_level' => $level ? $level : 1, 'type' => 2])->get()->toArray();
        $employees = DB::table('employees')->where(['is_active' => 1])->get();

        $arr = array();
        $arr1 = array();
        foreach ($levels as $l) {
            $arr[$l['project_level']] = $l['project_level'];
        }
        $arr = array_values($arr);
        foreach ($arr as $level) {
            $arr1[] = ProjectLevels::where('project_level', $level)->pluck('staff')->toArray();
        }
        $levelArray = $this->getProjectLevelLooping($request->project_id);

        $output = array(
            'project' => $project,
            'milestone' => $milestone,
            'levels' => $levels,
            'emp' => array_values($arr1),
            'employees' => $employees,
            'main_documents' => $main_documents,
            'aux_documents' => $aux_documents,
            'levelArray' => $levelArray
        );
        echo json_encode($output);
    }

    public function getWorkflowByDocumentType(Request $request)
    {
        $id = $request->document_type_id;
        $workflow_id = DocumentType::where('id', $id)->pluck('workflow_id')->first();
        $workflow = Workflow::where("id", $workflow_id)->get();
        echo json_encode($workflow);
    }



    public function store(Request $request)
    {

        $MainDocumentCount = (isset($request->main_document)) ? count($request->main_document) : 0;


        Log::info('ProjectController->Store:-Inside ' . json_encode($request->all()));

        $workflow_id = $request->workflow_id;

        $workflowLevelmodels = Workflowlevels::with('workflowLevelDetail')->where('workflow_id', $workflow_id)->get();

        $firstWfLevel = $workflowLevelmodels[0]->levels;

        try {
            if (isset($request->project_id) != null) {
                $project = Project::findOrFail($request->project_id);
                $msg = "Updated";
            } else {
                $msg = "Stored";
                $project = new Project();
            }
            Log::info('ProjectController->Store:-Message ' . $msg);
            $project->project_name = $request->project_name;
            $project->project_code = $request->project_code;
            $project->start_date = $request->start_date;
            $project->end_date = $request->end_date;
            $project->initiator_id = $request->initiator_id;
            $project->role = $request->role;
            $project->document_type_id = $request->document_type_id;
            $project->workflow_id = $request->workflow_id;
            $project->is_active = $request->is_active ? 1 : 0;
            $project->document_size = $request->document_size;
            $project->document_orientation = $request->document_orientation;
            $project->save();




            Log::info('ProjectController->Store:-ProjectData ' . json_encode($project));
            if ($project) {

                if (!$request->project_id) {
                    $ticket = substr($project->project_name, 0, 3) . date('YmdHis');
                    $project->ticket_no = $ticket;
                    $project->save();
                    $mail = $this->emailController->SendProjectInitiaterEmail(1, $request->initiator_id, $project->id, $request->project_name, $request->project_code);
                    Log::info('ProjectController->Store:-InitiaterMail Response ' . json_encode($mail));
                }

                if (isset($request->project_id) != null) {
                    $milestone_delete = ProjectMilestone::where("project_id", $request->project_id)->delete();
                    $PL = ProjectLevels::where("project_id", $request->project_id)->delete();
                    $PA = ProjectApprover::where("project_id", $request->project_id)->delete();
                    $PE1 = ProjectEmployee::where("project_id", $request->project_id)->delete();

                    $path = public_path() . '/projectDocuments/' . $project->ticket_no;
                    Log::info('ProjectController->Store:-documentPath ' . $path);

                    $PE = projectDocument::where("project_id", $request->project_id)
                        ->where("type", 1)
                        ->first();
                    $allowDeleteDocs = false;
                    if ($PE && $MainDocumentCount != 0) {

                        $allowDeleteDocs = true;
                    }
                    if ($PE && $request->isDeletedOldMainDocument == 0) {

                        $allowDeleteDocs = true;
                    }

                    Log::info('ProjectController->Store:-get docsmain  Edit  Response ' . json_encode($PE));
                    Log::info('ProjectController->Store:-get MainDocumentCount  Edit  Response ' . json_encode($MainDocumentCount));
                    if ($allowDeleteDocs) {
                        $docDetailDels = ProjectDocumentDetail::where('project_doc_id', $PE->id)->get();
                        Log::info('ProjectController->Store:-get docs docDetailDel Edit  Response ' . json_encode($docDetailDels));
                        foreach ($docDetailDels as $docDetailDel) {
                            $fullPath =  public_path() . '/projectDocuments/' . $docDetailDel->document_name;
                            Log::info('ProjectController->Store:-get docs $fullPath Response ' . json_encode($fullPath));
                            if (File::exists($fullPath)) {
                                File::delete($fullPath);
                            }
                            $docDetailDel->delete();
                        }
                        $docFirstStageDels = ProjectDocumentFirstStage::where('doc_id', $PE->id)->get();
                        Log::info('ProjectController->Store:-get docs docFirstStageDel Edit  Response ' . json_encode($docFirstStageDels));
                        foreach ($docFirstStageDels as $docFirstStageDel) {
                            $docFirstStageDel->delete();
                        }
                        $docStatusByLevels = ProjectDocumentStatusByLevel::where('doc_id', $PE->id)->get();
                        foreach ($docStatusByLevels as $docStatusByLevel) {

                            $docStatusByLevel->delete();
                        }
                        Log::info('ProjectController->Store:-get docs docStatusByLevel Edit  Response ' . json_encode($docStatusByLevels));
                        $PE->delete();
                    }


                    // $PDocDet = ProjectDocumentDetail::leftjoin('project_documents', 'project_documents.id', '=', 'project_document_details.project_doc_id')
                    //     ->leftjoin('projects', 'projects.id', '=', 'project_documents.project_id')
                    //     ->where("projects.id", $request->project_id)
                    //     ->delete();
                    // $PDoc = projectDocument::where("project_id", $request->project_id)->delete();

                } else {
                    //  $mail = $this->emailController->SendProjectInitiaterEmail(1, $request->initiator_id, 1, $request->project_name, $request->project_code);

                    // Log::info('ProjectController->Store:-InitiaterMail Response ' . json_encode($mail));
                }

                $ed = date('YmdHis');
                Log::info('ProjectController->Store:-Random Number' . json_encode($ed));

                $MainDocumentCount = (isset($request->main_document)) ? count($request->main_document) : 0;

              
                foreach ($request->milestone as $key => $miles) {
                    $project_milestone = new ProjectMilestone();
                    $project_milestone->project_id = $project->id;
                    $project_milestone->milestone = $request->milestone[$key];
                    $project_milestone->mile_start_date = $request->mile_start_date[$key];
                    $project_milestone->mile_end_date = $request->mile_end_date[$key];
                    $project_milestone->levels_to_be_crossed = $request->level_to_be_crosssed[$key];
                    $project_milestone->is_active = 1;
                    $project_milestone->save();
                }

                for ($a = 0; $a < count($workflowLevelmodels); $a++) {

                    $levelId = $workflowLevelmodels[$a]->levels;
                    $projectEmployee3 = $this->storeProjectEmployee($request->initiator_id, $project->id, '1', $levelId);
                    Log::info('ProjectController->Store:-Level Iteration ' . $a . "Level-Id " . ($levelId));
                    $projectLevelModel = new ProjectLevels();
                    $projectLevelModel->project_id = $project->id;
                    $projectLevelModel->project_level = $request->project_level[$a];
                    $projectLevelModel->priority = (isset($request->priority[$a])) ? $request->priority[$a] : 4;
                    $projectLevelModel->due_date = (isset($request->due_date[$a])) ? $request->due_date[$a] : date('Y-m-d');
                    $projectLevelModel->save();
                    Log::info('ProjectController->Store:-Level Iteration ' . $a . "Level-Id " . ($levelId) . "ProjectLevel " . json_encode($projectLevelModel));
                    if ($projectLevelModel) {
                        // for ($b = 0; $b < count($workflowLevelmodels[$a]->workflowLevelDetail); $b++) {
                        $getname = "approver_" . $levelId;

                        if ($request->$getname) {



                            $approverArrayCount = (isset($request->$getname)) ? count($request->$getname) : 0;
                            for ($c = 0; $c < $approverArrayCount; $c++) {

                                $projectApproverModel = new ProjectApprover();
                                $projectApproverModel->project_id = $project->id;
                                $projectApproverModel->project_level_id = $projectLevelModel->id;
                                $projectApproverModel->approver_id = $request->$getname[$c];
                                $projectApproverModel->designation_id = null;
                                $projectApproverModel->save();

                                $projectEmployee2 = $this->storeProjectEmployee($request->$getname[$c], $project->id, '2', $request->project_level[$a]);
                            }
                        }
                    }
                }
                Log::info('ProjectController->Store:-Main Document Count ' . $MainDocumentCount);
                if ($MainDocumentCount) {
                   // if (isset($request->project_id) == null) {

                        $levelApprovermail = $this->emailController->NewApprovalToApprover($project->id, $firstWfLevel);
                        Log::info('ProjectController->Store:-Approver Mail Response ' . json_encode($levelApprovermail));
                   // }
                    $halfPath =  $project->ticket_no . '/main_document/';
                    $upload_path = public_path() . '/projectDocuments/' . $halfPath;
                    Log::info('ProjectController->Store:-Main Doc upload Path  ' . $upload_path);
                    if (!File::exists($upload_path)) {
                        mkdir($upload_path . '/', 0777, true);
                    }


                    for ($d = 0; $d < $MainDocumentCount; $d++) {
                        $fileArray = $_FILES['main_document']['name'][$d];
                        $filePart = explode('.', $fileArray);
                        Log::info('ProjectController->Store:-fileNameExtension With ' . ($d + 1) . " " . $filePart[1]);
                        Log::info('ProjectController->Store:-$filePart[0] With ' . ($d + 1) . " " . $filePart[0]);
                        // Remove white spaces from the input string
                        $inputString = str_replace(' ', '', $filePart[0]);
                        // Resize the string to 5 characters
                        $fileOrgName = substr($inputString, 0, 5);
                        Log::info('ProjectController->Store:-fileOrgName ' . $fileOrgName);

                        $fileName = $project->ticket_no . "_" . $filePart[0] . '_' . $ed . "." . $filePart[1];
                        $fileName = str_replace(' ', '', $fileName);
                        //  $fileName = "MainDocument" . ($d + 1) . "." . $filePart[1];
                        Log::info('ProjectController->Store:-filename ' . $fileName);

                        $banner = $_FILES['main_document']['name'][$d];
                        $bannerpath = $upload_path . $fileName;
                        Log::info('ProjectController->Store:-banner Path  ' . $bannerpath);
                        if (move_uploaded_file($_FILES["main_document"]["tmp_name"][$d], $bannerpath)) {

                            $doc = new projectDocument();
                            $doc->type = 1;
                            $doc->project_id = $project->id;
                            $doc->project_level = 1;
                            $doc->document = $halfPath . $fileName;
                            $doc->is_latest = 1;
                            $doc->original_name = $fileName;
                            $doc->status = 1;
                            $doc->save();

                            $docdetail = new ProjectDocumentDetail();
                            $docdetail->project_doc_id =  $doc->id;
                            $docdetail->project_id = $project->id;
                            $docdetail->version = 1;
                            $docdetail->document_name = $halfPath . $fileName;
                            $docdetail->status = 1;
                            $docdetail->is_latest = 1;
                            $docdetail->upload_level = $firstWfLevel;
                            $docdetail->save();

                            $docStatusAss = $this->storeProjectDocumentStatusByLevel($project->id, $workflowLevelmodels, $doc->id, $fileName);
                        }
                    }
                }
                $AuxilaryDocumentCount = (isset($request->auxillary_document)) ? count($request->auxillary_document) : 0;
                Log::info('ProjectController->Store:-Aux Doc Count ' . $AuxilaryDocumentCount);
                if ($AuxilaryDocumentCount) {
                    $halfPath =  $project->ticket_no . '/auxillary_document/';
                    $upload_path = public_path() . '/projectDocuments/' . $halfPath;
                    Log::info('ProjectController->Store:-Aux Doc upload_path ' . $upload_path);
                    if (!File::exists($upload_path)) {
                        mkdir($upload_path . '/', 0777, true);
                    }
                    for ($d = 0; $d < $AuxilaryDocumentCount; $d++) {
                        $fileArray = $_FILES['auxillary_document']['name'][$d];
                        $filePart1 = explode('.', $fileArray);
                        log::info('Aux fileNamePart ' . json_encode($filePart1));
                        //$fileName = "AuxilaryDocument" . ($d + 1) . "." . $filePart1[1];
                        Log::info('ProjectController->Store:-$filePart[0] With ' . ($d + 1) . " " . $filePart1[0]);
                        // Remove white spaces from the input string
                        $inputString1 = str_replace(' ', '', $filePart1[0]);
                        // Resize the string to 5 characters
                        $fileOrgName1 = substr($inputString1, 0, 5);
                        Log::info('ProjectController->Store:-fileOrgName1 ' . $fileOrgName1);

                        $fileName = $project->ticket_no . "_" . $filePart1[0] . '_' . $ed . "." . $filePart1[1];
                        //  $fileName = "MainDocument" . ($d + 1) . "." . $filePart[1];
                        Log::info('ProjectController->Store:-filename ' . $fileName);

                        $banner = $_FILES['auxillary_document']['name'][$d];
                        $bannerpath = $upload_path . $fileName;

                        log::info('$bannerpath ' . json_encode($bannerpath));

                        if (move_uploaded_file($_FILES["auxillary_document"]["tmp_name"][$d], $bannerpath)) {
                            $doc = new projectDocument();
                            $doc->type = 2;
                            $doc->project_id = $project->id;
                            $doc->project_level = 1;
                            $doc->document = $halfPath . $fileName;
                            $doc->is_latest = 1;
                            $doc->status = 1;
                            $doc->original_name = $fileName;
                            $doc->save();

                            $docdetail = new ProjectDocumentDetail();
                            $docdetail->project_doc_id =  $doc->id;
                            $doc->project_id = $project->id;
                            $docdetail->version = 1;
                            $docdetail->document_name = $halfPath . $fileName;
                            $docdetail->status = 1;
                            $docdetail->is_latest = 1;
                            $docdetail->save();
                        }
                    }
                }
            }

            return redirect('projects')->with('success', "Projects " . $msg . " successfully.");
        } catch (Exception $e) {

            return [

                'message' => "failed",
                'data' => $e
            ];
        }
    }
    public function storeProjectDocumentStatusByLevel($projectId, $wfLevels, $documentId, $fileName)
    {

        foreach ($wfLevels as $key => $wfLevel) {
            if ($key == 0) {
                $stage1 = $this->convertToModelProjectDocumentStage1($projectId, $documentId, $fileName, $wfLevel->levels);
            }
            $model = new ProjectDocumentStatusByLevel();
            $model->project_id = $projectId;
            $model->doc_id = $documentId;
            $model->file_name = $fileName;
            $model->level_id = $wfLevel->levels;
            $model->save();
        }
        return true;
    }
    public function convertToModelProjectDocumentStage1($projectId, $documentId, $fileName, $levelId)
    {
        $model = new ProjectDocumentFirstStage();
        $model->project_id = $projectId;
        $model->level_id = $levelId;
        $model->doc_id = $documentId;
        $model->file_name = $fileName;
        $model->save();

        return true;
    }
    public function storeProjectEmployee($empId, $projectId, $type, $levelId = null)
    {
        $model = new ProjectEmployee();
        $model->employee_id = $empId;
        $model->project_id = $projectId;
        $model->type = $type;
        $model->level = $levelId;
        $model->save();

        return $model;
    }
    public function viewProject($id)
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

        return view('Docs/view', ['milestoneDatas' => $milestoneDatas, 'levelsArray' => $entities, 'levelCount' => $levelCount, 'maindocument' => $maindocument, 'auxdocument' => $auxdocument, 'details' => $details, 'details1' => $details1, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }

    public function getProjectLevel(Request $request)
    {
        $id = $request->project_id;
        $level = $request->level;
        $projectDataWithLevelId = Project::select('project_levels.priority', 'project_levels.due_date', 'employees.first_name', 'designations.name as desName', 'employees.profile_image', 'employees.last_name', DB::raw("CONCAT(employees.first_name, ' ', COALESCE(employees.middle_name, ''), ' ', employees.last_name) AS employee_full_name"))
            //->leftjoin('project_milestones', 'project_milestones.project_id', '=', 'projects.id')
            ->leftjoin('project_levels', 'project_levels.project_id', '=', 'projects.id')
            ->leftjoin('project_approvers', 'project_approvers.project_level_id', '=', 'project_levels.id')
            ->leftjoin('employees', 'employees.id', '=', 'project_approvers.approver_id')
            ->leftjoin('designations', 'designations.id', '=', 'employees.designation_id')
            ->where('projects.id', $id)
            ->where('project_levels.project_level', $level)
            ->get();

        //dd($projectDataWithLevelId);

        $project_details1 = DB::table('projects as p')
            ->leftjoin('project_levels as pl', 'pl.project_id', '=', 'p.id')
            ->leftJoin('project_milestones as pm', 'pm.project_id', '=', 'p.id')
            ->leftjoin('employees as staff', 'staff.id', '=', 'pl.staff')
            ->where("p.id", '=', $id)
            ->where("pl.project_level", '=', $level)

            ->select('pl.staff', 'pm.created_at as milestone_created', 'pm.mile_start_date', 'staff.profile_image as staff_image', 'staff.first_name as staff_first_name', 'staff.last_name as staff_last_name');
        $details1 = $project_details1->get();

        echo json_encode($projectDataWithLevelId);
    }

    public function getProjectDocs(Request $request)
    {
        $id = $request->project_id;
        $level = $request->level;
        // $getLevelRecords = ProjectDocumentStatusByLevel::where('level_id', $level)->where('project_id', $id)->get();

        //     foreach ($getLevelRecords as $getLevelRecord) {
        //         $previousRecord = ProjectDocumentStatusByLevel::where('id', '<', $getLevelRecord->id)               
        //         ->where('project_id', $id)

        //         ->orderBy('id', 'desc')
        //         ->first();
        //         dd($previousRecord);
        //        if($previousRecord){

        //        }else{

        //        }
        //     }


        // dd($getFrontRecord);

        $maindocument = projectDocument::select('*')->with(['docDetail', 'docDetail.employee', 'docStatusWithLevel' => function ($q) use ($level) {
            // Query the name field in status table
            $q->where('level_id', '=', $level); // '=' is optional
        }])
            //  ->leftjoin('project_document_status_by_levels', 'project_document_status_by_levels.doc_id', '=', 'project_documents.id')
            ->where("project_documents.project_id", '=', $request->project_id)
            ->where("project_documents.type", '=', 1)
            //    ->where("project_document_status_by_levels.level_id", '=', $level)
            ->get();
        //dd($maindocument);

        $auxdocument = projectDocument::select('*')->with('docDetail', 'docDetail.employee')
            ->where("project_id", '=', $request->project_id)
            ->where("type", '=', 2)
            ->get();

        // $main_doc = DB::table('project_document as p')
        //     ->where("p.project_id", '=', $id)
        //     ->where("p.type", '=', 1)
        //     ->where("p.project_level", '=', $level)
        //     ->select('*');
        // $maindocument = $main_doc->get();

        // $aux_doc = DB::table('project_document as p')
        //     ->where("p.project_id", '=', $id)
        //     ->where("p.type", '=', 2)
        //     ->where("p.project_level", '=', $level)
        //     ->select('*');
        // $auxdocument = $aux_doc->get();

        echo json_encode(array("main_docs" => $maindocument, "aux_docs" => $auxdocument));
    }

    public function getEmployeeByWorkFlow(Request $request)
    {
        $workflow_id = $request->workflow_id;
        $level = $request->level ? $request->level : 1;
        $models = Workflowlevels::with('workflowLevelDetail')->where(['workflow_id' => $workflow_id, 'levels' => 5])->first();

        // $entities = collect($models)->map(function ($model) {
        //     $levelDetails = $model['workflowLevelDetail'];

        //     $e = collect($levelDetails)->map(function ($levelDetail) {
        //         $designationId = $levelDetail->designation_id;
        //         $designationName = Designation::where('id',$designationId)->first()->name;

        //         return $designationName;
        //     });

        //     $designationArray =  $e;


        //     $datas = ['levelId' => $model->levels, 'designationId' => $designationArray];

        //     return $datas;
        // });


        // $designation = DB::table('workflow_levels')->where(['workflow_id' => $workflow_id, 'levels' => $level])->pluck('approver_designation');
        // $designation_name = DB::table('designations')->where(['id' => $designation[0]])->pluck('name')->first();
        // $employees = DB::table('employees')->whereIn('designation_id', $designation)->get();
        echo json_encode(["employees" => "", "designation_name" => "", 'destination' => ""]);
    }


    public function docStatus(Request $request)
    {





        $level = $request->levelId;
        $empId = Auth::user()->emp_id;

        $parentModel = projectDocument::select('ticket_no', 'type', 'project_name', 'projects.id as projectId')
            ->leftjoin('projects', 'projects.id', 'project_documents.project_id')
            ->where('project_documents.id', $request->documentId)
            ->first();
        if ($parentModel) {
            $projectId = $parentModel->projectId;


            $levelModel = ProjectDocumentStatusByLevel::where('project_id', $projectId)
                ->where('level_id', $level)
                ->where('doc_id', $request->documentId)
                ->first();

            if ($levelModel) {
                $levelModel->status = $request->status;
                $levelModel->save();
            }

            $modelData = ProjectDocumentDetail::where('id', $request->statusdocumentId)->first();
            $modelData->status = $request->status;
            $modelData->remark = $request->statusremarks;
            $modelData->updated_by = $empId;
            $modelData->project_id = $projectId;
            $modelData->upload_level = $level;
            if ($request->status != 4) {
                $modelData->is_latest = 0;
            }

            $modelData->save();

            if ($request->status == 4) {
                $getNextRecord = ProjectDocumentStatusByLevel::where('project_id', $projectId)
                    ->where('doc_id', $request->documentId)
                    ->where('level_id', '>', $level)
                    ->orderBy('id', 'asc')
                    ->first();
                if ($getNextRecord) {
                    $getNextRecord->file_name = $levelModel->file_name;
                    $getNextRecord->save();
                }
            }


            if ($request->file('againestDocument')) {


                $typeOfDoc = ($parentModel->type == 2) ? 'auxillary_document/' : 'main_document/';
                $typeOfDocFile = ($parentModel->type == 2) ? 'AuxillaryDocument-v' : 'MainDocument-v';

                // $halfPath1 =  $parentModel->ticket_no . '/level-' . $request->levelId . "/" . $typeOfDoc;
                // Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
                // $upload_path1 = public_path() . '/projectDocuments/' . $halfPath1;

                $path = public_path() . '/projectDocuments/' . $parentModel->ticket_no . '/' . $typeOfDoc;


                $banner = $request->file('againestDocument')->getClientOriginalName();
                $expbanner = explode('.', $banner);
                $filePart1 = $expbanner[1];
                Log::info('ProjectController->Store:-filePart1' . json_encode($filePart1));
                $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;
                $ed = date('YmdHis');
                Log::info('ProjectController->Store:-Random Number' . json_encode($ed));
                //date('ymdhms');
                $fileName1 = $expbanner[0] . '_' . $ed . "." . $filePart1;


                //$fileName1 = $parentModel->ticket_no . $typeOfDocF . $request->levelId . "s" . ($lastversion + 1) . "v" . ($lastversion + 1) . "." . $filePart1;
                Log::info('ProjectController->Store:-fileName1' . json_encode($fileName1));
                $bannerpath = $path . $fileName1;
                if (move_uploaded_file($request->againestDocument->path(), $bannerpath)) {

                    $model = new ProjectDocumentDetail;
                    $model->version = $lastversion + 1;
                    $model->remark = "";
                    $model->project_doc_id = $request->documentId;
                    $model->status = 1;
                    $model->document_name = $parentModel->ticket_no . '/' . $typeOfDoc . $fileName1;
                    $model->updated_by = $empId;
                    $model->project_id = $projectId;
                    $model->is_latest = 1;
                    $model->save();


                    $levelModel->file_name  = $fileName1;
                    $levelModel->save();
                }
            }

            $getAllDocmentStatusModel = ProjectDocumentStatusByLevel::where('project_id', $projectId)->where('doc_id', $request->documentId)->count();
            $getUnApprovedDocmentStatusModel = ProjectDocumentStatusByLevel::where('project_id', $projectId)
                ->where('doc_id', $request->documentId)
                ->where('status', '!=', 4)
                ->get();
            if (count($getUnApprovedDocmentStatusModel) == 1) {
                if ($getUnApprovedDocmentStatusModel[0]->level_id == $level && $request->status == 4) {
                    $modelMain = projectDocument::where('id', $request->documentId)->first();
                    $modelMain->status = $request->status;
                    $modelMain->save();

                    $getAllProjectDocument = projectDocument::where('project_id', $projectId)->get();
                    $getAllApprovedProjectDocument = projectDocument::where('project_id', $projectId)
                        ->where('status', 4)
                        ->get();
                    if ($getAllProjectDocument == $getAllApprovedProjectDocument) {

                        $pModel = Project::where('id', $projectId)->first();
                        $pModel->current_status = 4;
                        $pModel->save();

                        $mail = $this->emailController->SendApprovedStatusChangeEmail($parentModel->projectId, $empId, $request->levelId, $request->status);
                    }
                }
            } else {
                $mail = $this->emailController->SendStatusChangeEmail($parentModel->projectId, $empId, $request->levelId, $request->status);
            }



            // if (count($getAllunApprovedDocMentModel) == 1) {
            //     if ($getAllunApprovedDocMentModel[0]->id == $request->documentId && $request->status == 4) {

            //         // $pModel = Project::where('id', $projectId)->first();
            //         // $pModel->current_status = 4;
            //         // $pModel->save();

            //         $mail = $this->emailController->SendApprovedStatusChangeEmail($parentModel->projectId, $empId, $request->levelId, $request->status);
            //     }
            // } else {
            //     $mail = $this->emailController->SendStatusChangeEmail($parentModel->projectId, $empId, $request->levelId, $request->status);
            // }
        }

        return response()->json(['staus' => "Success"]);
    }

    public function destroy($id)
    {

        $model = Project::where("id", $id)->delete();
        $data = [
            "message" => "Success",
            "data" => "Project Deleted Successfully."
        ];
        return response()->json($data);
    }
    public function uploadDocumentVersion(Request $request)
    {

        $parentModel = projectDocument::select('ticket_no', 'type', 'project_name', 'projects.id as projectId')
            ->leftjoin('projects', 'projects.id', 'project_documents.project_id')
            ->where('project_documents.id', $request->documentId)
            ->first();

        $typeOfDoc = ($parentModel->type == 2) ? 'auxillary_document' : 'main_document/';
        $typeOfDocF = ($parentModel->type == 2) ? 'Aux' : 'Main';

        // $halfPath1 =  $parentModel->ticket_no . '/level-' . $request->levelId . "/" . $typeOfDoc;
        // Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
        $upload_path1 = public_path() . '/projectDocuments/' . $typeOfDoc;




        $banner = $request->file('againestDocument')->getClientOriginalName();
        $expbanner = explode('.', $banner);
        $filePart1 = $expbanner[1];
        Log::info('ProjectController->Store:-filePart1' . json_encode($filePart1));
        $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;

        $fileName1 = "MainDocument" . ($lastversion + 1) . "." . $filePart1;
        // $fileName1 = $parentModel->ticket_no . $typeOfDocF . $request->levelId . "s" . ($lastversion + 1) . "v" . ($lastversion + 1) . "." . $filePart1;
        Log::info('ProjectController->Store:-fileName1' . json_encode($fileName1));
        $bannerpath = $upload_path1 . $fileName1;







        if (move_uploaded_file($request->againestDocument->path(), $bannerpath)) {

            $model = new ProjectDocumentDetail;
            $model->version = $lastversion + 1;
            $model->remark = $request->remarks;
            $model->project_doc_id = $request->documentId;
            $model->status = 1;
            $model->document_name =  $fileName1;

            $model->save();

            $ProjectDocumentModelVersion = projectDocument::findOrFail($request->documentId);
            $ProjectDocumentModelVersion->original_name = $fileName1;
            $ProjectDocumentModelVersion->save();
        }
        if ($model) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'failed']);
    }

    public function deleteDocument(Request $request)
    {
        $id = $request->id;
        $document_delete = projectDocument::where("id", $id)->delete();
        echo json_encode($document_delete);
    }

    public function projectCodeValidation(Request $request)
    {
        $model = Project::where('project_code', $request->code);
        $model->where('id', '!=', $request->id);
        $model->whereNull('deleted_at');
        $getModel = $model->get();
        

        $response = (count($getModel)) ? false : true;

        return response()->json(['response' => $response]);
    }
    public function projectNameValidation(Request $request)
    {

        $models = Project::where('project_name', $request->name);
        if ($request->id) {
            $models->where('id', '!=', $request->id);
        }
        $models->whereNull('deleted_at');
        $model = $models->get();

        $response = (count($model)) ? false : true;

        return response()->json(['response' => $response]);
    }

    public function getWorkflowByProjectId(Request $request)
    {

        $projectModel = Project::where('id', $request->project_id)->first();
        $levelArray = $this->getProjectLevelLooping($request->project_id);


        $response = ['workflow_level' => $levelArray];
        return response()->json(['response' => $response]);
    }
    public function  getProjectLevelLooping($projectId)
    {
        $projectModel = Project::where('id', $projectId)->first();

        $models = Workflowlevels::with('workflowLevelDetail')->where('workflow_id', $projectModel->workflow_id)->get();
        $entities = collect($models)->map(function ($model) use ($projectId) {

            $MaindocumentCount = projectDocument::select('project_documents.id')->where('project_level', $model->levels)
                ->where('project_id', $projectId)
                ->where('type', 1)
                ->count();
            $AuxdocumentCount = projectDocument::select('project_documents.id')->where('project_level', $model->levels)
                ->where('project_id', $projectId)
                ->where('type', 2)
                ->count();
            $milstoneArray = ProjectMilestone::where('levels_to_be_crossed', $model->levels)
                ->where('project_id', $projectId)
                ->first();


            $levelDetails = $model['workflowLevelDetail'];

            $projectMasterData = ProjectLevels::where('project_id', $projectId)->where('project_level', $model->levels)->first();
            $projectApproversArray = array();
            if ($projectMasterData) {
                $projectApprovers = ProjectApprover::select('approver_id')->where('project_level_id', $projectMasterData->id)->get();



                foreach ($projectApprovers as $key => $value) {
                    $projectApproversArray[$key] = $value['approver_id'];
                }
            }

            $empModel = WorkflowLevelDetail::select('employees.*', 'designations.name as designation_name')->leftjoin('employees', 'employees.id', '=', 'workflow_level_details.employee_id')->leftjoin('designations', 'designations.id', '=', 'employees.designation_id')->where('workflow_level_id', $model->id)->get()->toArray();



            $datas = ['levelId' => $model->levels, 'levelPkId' => $model->id, 'designationId' => $empModel, 'projectMasterData' => $projectMasterData, 'projectApprovers' => $projectApproversArray, 'MaindocumentCount' => $MaindocumentCount, 'AuxdocumentCount' => $AuxdocumentCount, 'milstoneArray' => $milstoneArray];

            return $datas;
        });

        return $entities;
    }

    public function getProjectDetailsByPrimaryId($id)
    {
        return Project::where('id', $id)->first();
    }

    function projectListFilters(Request $request)
    {
        $projectId = null;
        $initiatorId = null;
        $dateFilter = null;
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";
        if ($request->paramName == "projectId") {
            $projectId = $request->projectId;
        } elseif ($request->paramName == "initiatorId") {
            $initiatorId = $request->initiatorId;
        }
        if ($request->paramName == "") {
        } else {
            $dateFilter = $request->paramName;
            $startDate = $request->startDate;
            $endDate = $request->endDate;
        }
        //$models = Project::where('id',$projectId)->get();
        $models = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
        if ($projectId) {
            $models->where('id', $projectId);
        }
        if ($initiatorId) {
            $models->where('initiator_id', $initiatorId);
        }
        if ($dateFilter) {
            if ($empId) {
                $projects = $this->getProjectIdByEmployee($empId);
                $models->whereIn('id', $projects);
            }

            if ($startDate || $endDate) {
                $models->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate]);
                });
            }
        }
        $models->whereNull('deleted_at');
        $searchingModels = $models->get();


        return response()->json(['datas' => $searchingModels]);
    }
    public function getProjectIdByEmployee()
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
        $ids = collect($models1)->map(function ($model) {
            return  $model->id;
        });
        $initiaterIds = ($ids->unique())->toArray();
        return $initiaterIds;
    }

    public function getRunningProjectsByEmpId($empId)
    {
        $models = Project::with('projectEmployees')
            ->whereRelation('projectEmployees', 'employee_id', $empId)
            ->where('current_status', '!=', 4)
            ->get();

        return $models;
    }

    public function getRunningProjectsEmployeesByEmpId($empId)
    {
        $models = ProjectEmployee::with('project')
            ->whereRelation('project', 'current_status', '!=', 4)
            ->where('employee_id', $empId)
            ->get();

        return $models;
    }
    public function getProjectslevelStatusByProjectIdAndLevelId($projectId, $levelId)
    {
        return ProjectDocumentStatusByLevel::where('project_id', $projectId)->where('level_id', $levelId)->first();
    }

    public function getProjectModelsByWfId($wfId, $projectId = null)
    {
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";

        $models = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
        $models->whereHas('workflow', function ($q) use ($wfId) {

            $q->where('id', '=', $wfId);
        });
        if ($empId) {
            $models->whereHas('projectEmployees', function ($q) use ($empId) {
                if ($empId != "") {
                    $q->where('employee_id', '=', $empId);
                }
            });
        }
        if ($projectId) {
            $models->where('projects.id', $projectId);
        }
        $models->whereNull('deleted_at');
        $models1 = $models->get();
        return $models1;
    }
    public function getMaindocumentFileNameById($projectId)
    {
        return projectDocument::where('project_id', $projectId)->where('type', 1)->first();
    }
    public function getProjectLevelByProjectId($projectId)
    {
        return ProjectLevels::where('project_id', $projectId)->get();
    }
    public function getProjectLevelStausBylevelIdandProjectId($projectId, $levelId)
    {
        return ProjectDocumentStatusByLevel::where('project_id', $projectId)
            ->where('level_id', $levelId)
            ->first();
    }
    public function getProjectLevelApproverByProjectIdAndLevelId($projectId, $levelId)
    {

        return ProjectApprover::select(DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS employee_name"))
            ->leftjoin('project_levels', 'project_levels.id', 'project_approvers.project_level_id')
            ->leftjoin('employees', 'employees.id', 'project_approvers.approver_id')
            ->where('project_level', $levelId)
            ->where('project_levels.project_id', $projectId)
            ->first();
    }
}
