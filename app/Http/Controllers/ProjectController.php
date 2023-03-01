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
use App\Models\ProjectLevels;
use App\Models\ProjectMilestone;
use App\Models\Workflow;
use App\Models\Workflowlevels;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    protected $wfController;
    public function __construct(WorkflowController $wfController)
    {
        $this->wfController = $wfController;
    }
    public function index()
    {

        $projects_all = $this->get_all_projects();
        $employees = Employee::where('is_active', 1)->get()->toArray();

        $departments = Department::where('is_active', 1)->get()->toArray();
        $designation = Designation::where('is_active', 1)->get()->toArray();
        $document_type = DocumentType::where('is_active', 1)->get()->toArray();
        $workflow = Workflow::where('is_active', 1)->get()->toArray();
        return view('Projects/list', ['document_type' => $document_type, 'workflow' => $workflow, 'projects_all' => $projects_all, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
        //return view('Projects/listPageOrg', ['document_type' => $document_type, 'workflow' => $workflow, 'projects_all' => $projects_all, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }
    public function create()
    {
        $employee = Employee::whereNull('deleted_at')->get();
        $document_type = DocumentType::whereNull('deleted_at')->get();
        $workflow = Workflow::whereNull('deleted_at')->get();
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
        // dd($levelModels);
        return view('Projects/edit', compact('employee', 'document_type', 'workflow', 'project', 'levelModels'));
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
            'levelArray'=>$levelArray
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
        //Log::info('ProjectController->Store:-Inside ' . json_encode($request->all()));
        // dd($request->all());
        $workflow_id = $request->workflow_id;

        $workflowLevelmodels = Workflowlevels::with('workflowLevelDetail')->where('workflow_id', $workflow_id)->get();
        //    $f = $workflowLevelmodels[0]->workflowLevelDetail;
        //   dd($f[0]->designation_id);
        try {
            if (isset($request->project_id) != null) {
                $project = Project::findOrFail($request->project_id);
                $msg = "Updated";
            } else {
                $msg = "Stored";
                $project = new Project();
            }

            $project->project_name = $request->project_name;
            $project->project_code = $request->project_code;
            $project->start_date = $request->start_date;
            $project->end_date = $request->end_date;
            $project->initiator_id = $request->initiator_id;
            $project->role = $request->role;
            $project->document_type_id = $request->document_type_id;
            $project->workflow_id = $request->workflow_id;
            $project->is_active = $request->is_active ? 1 : 0;
            $project->save();


            Log::info('ProjectController->Store:-ProjectData ' . json_encode($project));
            if ($project) {
                $project->ticket_no = "WF" .  date('Y-m-d') . '-' . $project->id;
                $project->save();

                if (isset($request->project_id) != null) {
                    $milestone_delete = ProjectMilestone::where("project_id", $request->project_id)->delete();
                    $PL = ProjectLevels::where("project_id", $request->project_id)->delete();
                    $PA = ProjectApprover::where("project_id", $request->project_id)->delete();
                    // $PDocDet = ProjectDocumentDetail::leftjoin('project_documents', 'project_documents.id', '=', 'project_document_details.project_doc_id')
                    //     ->leftjoin('projects', 'projects.id', '=', 'project_documents.project_id')
                    //     ->where("projects.id", $request->project_id)
                    //     ->delete();
                    // $PDoc = projectDocument::where("project_id", $request->project_id)->delete();
                    $path = public_path() . '/projectDocuments/' . $project->ticket_no;
                    if (File::exists($path)) {
                        File::deleteDirectory($path);
                    }
                }
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
                    Log::info('ProjectController->Store:-Level Iteration ' . $a . "Level-Id " . ($levelId));
                    $projectLevelModel = new ProjectLevels();
                    $projectLevelModel->project_id = $project->id;
                    $projectLevelModel->project_level = $request->project_level[$a];
                    $projectLevelModel->priority = (isset($request->priority[$a])) ? $request->priority[$a] : 4;
                    $projectLevelModel->due_date = (isset($request->due_date[$a])) ? $request->due_date[$a] : date('Y-m-d');
                    $projectLevelModel->save();
                    Log::info('ProjectController->Store:-Level Iteration ' . $a . "Level-Id " . ($levelId) . "ProjectLevel " . json_encode($projectLevelModel));
                    if ($projectLevelModel) {
                        for ($b = 0; $b < count($workflowLevelmodels[$a]->workflowLevelDetail); $b++) {
                            $getname = "approver_" . $levelId . "_" . $b;
                            if ($request->$getname) {



                                $approverArrayCount = (isset($request->$getname)) ? count($request->$getname) : 0;
                                for ($c = 0; $c < $approverArrayCount; $c++) {

                                    $projectApproverModel = new ProjectApprover();
                                    $projectApproverModel->project_id = $project->id;
                                    $projectApproverModel->project_level_id = $projectLevelModel->id;
                                    $projectApproverModel->approver_id = $request->$getname[$c];
                                    $projectApproverModel->designation_id = $workflowLevelmodels[$a]->workflowLevelDetail[$b]->designation_id;
                                    $projectApproverModel->save();
                                }
                            }
                        }
                        $mainDocName = "main_document" . $levelId;
                        Log::info('ProjectController->Store:-Level Iteration ' . $a . "Level-Id " . ($levelId) . "DocName " . json_encode($mainDocName));
                        $MainDocCount = (isset($request->$mainDocName) ? count($request->$mainDocName) : 0);
                        Log::info('ProjectController->Store:-Level Iteration ' . $a . "Level-Id " . ($levelId) . "MainDocCount " . json_encode($MainDocCount));
                        if ($MainDocCount) {
                            $halfPath =  $project->ticket_no . '/level-' . $levelId . '/main_document/';
                            $upload_path = public_path() . '/projectDocuments/' . $halfPath;
                            mkdir($upload_path . '/', 0777, true);
                        }
                        for ($d = 0; $d < $MainDocCount; $d++) {
                            $fileArray = $_FILES['main_document' . $levelId]['name'][$d];
                            $filePart = explode('.', $fileArray);
                            $fileName = $project->ticket_no . "Main" . $levelId . "s" . ($d + 1) . "v1." . $filePart[1];
                            $banner = $_FILES['main_document' . $levelId]['name'][$d];
                            $bannerpath = $upload_path . $fileName;

                            if (move_uploaded_file($_FILES["main_document" . $levelId]["tmp_name"][$d], $bannerpath)) {
                                $doc = new projectDocument();
                                $doc->type = 1;
                                $doc->project_id = $project->id;
                                $doc->project_level = $request->project_level[$a];
                                $doc->document = $halfPath . $fileName;
                                $doc->is_latest = 1;
                                $doc->original_name = $fileName;
                                $doc->save();

                                $docdetail = new ProjectDocumentDetail();
                                $docdetail->project_doc_id =  $doc->id;
                                $docdetail->version = 1;
                                $docdetail->document_name = $halfPath . $fileName;
                                $docdetail->status = 1;
                                $docdetail->save();
                            }
                        }
                        $auxDocName = "auxillary_document" . $levelId;
                        Log::info('ProjectController->Store:-Level Iteration ' . $a . "Level-Id " . ($levelId) . "auxDocName " . json_encode($auxDocName));

                        $AuxDocCount = (isset($request->$auxDocName) ? count($request->$auxDocName) : 0);
                        Log::info('ProjectController->Store:-Level Iteration ' . $a . "Level-Id " . ($levelId) . "AuxDocCount " . json_encode($AuxDocCount));

                        if ($AuxDocCount) {
                            $halfPath1 =  $project->ticket_no . '/level-' . $levelId . '/auxillary_document/';
                            Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
                            $upload_path1 = public_path() . '/projectDocuments/' . $halfPath1;
                            mkdir($upload_path1 . '/', 0777, true);
                        }
                        for ($d = 0; $d < $AuxDocCount; $d++) {



                            $fileArray1 = $_FILES['auxillary_document' . $levelId]['name'][$d];
                            Log::info('ProjectController->Store:-fileArray1' . json_encode($fileArray1));
                            $filePart1 = explode('.', $fileArray1);
                            Log::info('ProjectController->Store:-filePart1' . json_encode($filePart1));

                            $fileName1 = $project->ticket_no . "Aux" . $levelId . "s" . ($d + 1) . "v1." . $filePart1[1];

                            Log::info('ProjectController->Store:-fileName1' . json_encode($fileName1));
                            $banner = $_FILES['auxillary_document' . $levelId]['name'][$d];
                            $bannerpath = $upload_path1 . $fileName1;
                            Log::info('ProjectController->Store:-bannerpath' . json_encode($bannerpath));

                            if (move_uploaded_file($_FILES["auxillary_document" . $levelId]["tmp_name"][$d], $bannerpath)) {
                                $doc = new projectDocument();
                                $doc->type = 2;
                                $doc->project_id = $project->id;
                                $doc->project_level = $request->project_level[$a];
                                $doc->document = $halfPath1 . $fileName1;
                                $doc->is_latest = 1;
                                $doc->original_name = $fileName1;
                                $doc->save();

                                $docdetail = new ProjectDocumentDetail();
                                $docdetail->version = 1;
                                $docdetail->project_doc_id =  $doc->id;
                                $docdetail->document_name = $halfPath1 . $fileName1;
                                $docdetail->status = 1;
                                $docdetail->save();
                            } else {
                                Log::info('ProjectController->Store:-Not Stored' . $levelId);
                            }
                        }
                    }
                }
            }
            return redirect('projects')->with('success', "Projects ".$msg." successfully.");
        } catch (Exception $e) {
            return [

                'message' => "failed",
                'data' => $e
            ];
        }
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
            ->select('p.ticket_no', 'p.id', 'p.project_name', 'p.project_code', 'e.profile_image', 'des.name as designation', 'doc.name as document_type', 'w.workflow_code', 'w.workflow_name', 'e.first_name', 'e.last_name', 'd.name as department', 'p.is_active');
        $details = $project_details->first();

        $project_details1 = DB::table('projects as p')
            ->leftjoin('project_levels as pl', 'pl.project_id', '=', 'p.id')
            ->leftJoin('project_milestones as pm', 'pm.project_id', '=', 'p.id')
            ->leftjoin('employees as staff', 'staff.id', '=', 'pl.staff')
            ->where("p.id", '=', $id)
            ->select('p.ticket_no', 'pl.staff', 'pm.created_at as milestone_created', 'pm.mile_start_date', 'staff.profile_image as staff_image', 'staff.first_name as staff_first_name', 'staff.last_name as staff_last_name');
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

            $e = collect($levelDetails)->map(function ($levelDetail) {
                $designationId = $levelDetail->designation_id;

                $designationName = Designation::with('employee')->where('id', $designationId)->first();
                $desEmployee = $designationName->employee;

                $desData = ['desName' => $designationName->name, 'desEmployee' => $desEmployee];

                return $desData;
            });

            $designationArray =  $e;


            $datas = ['levelId' => $model->levels, 'designationId' => $designationArray];

            return $datas;
        });
        // dd($entities);

        return view('Docs/view', ['levelsArray' => $entities, 'levelCount' => $levelCount, 'maindocument' => $maindocument, 'auxdocument' => $auxdocument, 'details' => $details, 'details1' => $details1, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }

    public function getProjectLevel(Request $request)
    {
        $id = $request->project_id;
        $level = $request->level;
        $projectDataWithLevelId = Project::select('employees.first_name', 'designations.name as desName', 'employees.profile_image', 'employees.last_name')
            ->leftjoin('project_milestones', 'project_milestones.project_id', '=', 'projects.id')
            ->leftjoin('project_levels', 'project_levels.project_id', '=', 'projects.id')
            ->leftjoin('project_approvers', 'project_approvers.project_level_id', '=', 'project_levels.id')
            ->leftjoin('employees', 'employees.id', '=', 'project_approvers.approver_id')
            ->leftjoin('designations', 'designations.id', '=', 'employees.designation_id')
            ->where('projects.id', $id)
            ->where('project_levels.project_level', $level)
            ->get();

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

        $maindocument = projectDocument::select('*')->with('docDetail')
            ->where('project_level', $level)
            ->where("project_id", '=', $request->project_id)
            ->where("type", '=', 1)
            ->get();
        $auxdocument = projectDocument::select('*')->with('docDetail')
            ->where('project_level', $level)
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

        $model = ProjectDocumentDetail::where('id', $request->statusdocumentId)->first();

        $model->status = $request->status;
        $model->remark = $request->statusremarks;
        $model->save();

        return response()->json(['staus' => "Success"]);
    }

    public function destroy($id)
    {
        $project_update = Project::where("id", $id)->update(["is_active" => 0]);
        echo json_encode($project_update);
    }
    public function uploadDocumentVersion(Request $request)
    {

        $parentModel = projectDocument::select('ticket_no', 'type', 'project_name', 'projects.id as projectId')
            ->leftjoin('projects', 'projects.id', 'project_documents.project_id')
            ->where('project_documents.id', $request->documentId)
            ->first();

        $typeOfDoc = ($parentModel->type == 2) ? 'auxillary_document' : 'main_document/';
        $typeOfDocF = ($parentModel->type == 2) ? 'Aux' : 'Main';

        $halfPath1 =  $parentModel->ticket_no . '/level-' . $request->levelId . "/" . $typeOfDoc;
        Log::info('ProjectController->Store:-HalfPath' . json_encode($halfPath1));
        $upload_path1 = public_path() . '/projectDocuments/' . $halfPath1;




        $banner = $request->file('againestDocument')->getClientOriginalName();
        $expbanner = explode('.', $banner);
        $filePart1 = $expbanner[1];
        Log::info('ProjectController->Store:-filePart1' . json_encode($filePart1));
        $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;


        $fileName1 = $parentModel->ticket_no . $typeOfDocF . $request->levelId . "s" . ($lastversion + 1) . "v" . ($lastversion + 1) . "." . $filePart1;
        Log::info('ProjectController->Store:-fileName1' . json_encode($fileName1));
        $bannerpath = $upload_path1 . $fileName1;







        if (move_uploaded_file($request->againestDocument->path(), $bannerpath)) {

            $model = new ProjectDocumentDetail;
            $model->version = $lastversion + 1;
            $model->remark = $request->remarks;
            $model->project_doc_id = $request->documentId;
            $model->status = 1;
            $model->document_name =  $halfPath1 . $fileName1;

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
        $model = Project::where('project_code', $request->code)->where('id', '!=', $request->id)->whereNull('deleted_at')->get();

        $response = (count($model)) ? false : true;

        return response()->json(['response' => $response]);
    }
    public function projectNameValidation(Request $request)
    {

        $model = Project::where('project_name', $request->name)->where('id', '!=', $request->id)->whereNull('deleted_at')->get();


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

            $e = collect($levelDetails)->map(function ($levelDetail) {
                $designationId = $levelDetail->designation_id;

                $designationName = Designation::with('employee')->where('id', $designationId)->first();
                $desEmployee = $designationName->employee;

                $desData = ['desName' => $designationName->name, 'desEmployee' => $desEmployee];

                return $desData;
            });

            $designationArray =  $e;


            $datas = ['levelId' => $model->levels, 'levelPkId' => $model->id, 'designationId' => $designationArray, 'projectMasterData' => $projectMasterData, 'projectApprovers' => $projectApproversArray, 'MaindocumentCount' => $MaindocumentCount, 'AuxdocumentCount' => $AuxdocumentCount,'milstoneArray'=>$milstoneArray];

            return $datas;
        });

        return $entities;
    }
}
