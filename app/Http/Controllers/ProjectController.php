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

        $output = array(
            'project' => $project,
            'milestone' => $milestone,
            'levels' => $levels,
            'emp' => array_values($arr1),
            'employees' => $employees,
            'main_documents' => $main_documents,
            'aux_documents' => $aux_documents
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
        Log::info('ProjectController->Store:-Inside ' . json_encode($request->all()));

        $workflow_id = $request->workflow_id;

        $workflowLevelmodels = Workflowlevels::with('workflowLevelDetail')->where('workflow_id', $workflow_id)->get();
        //    $f = $workflowLevelmodels[0]->workflowLevelDetail;
        //   dd($f[0]->designation_id);
        try {
            if (isset($request->project_id) != null) {
                $project = Project::findOrFail($request->project_id);
            } else {
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
                $project->ticket_no = "WF".  date('Y-m-d').'/'.$project->id;
                                $project->save();

                if (isset($request->project_id) != null) {
                    $milestone_delete = ProjectMilestone::where("project_id", $request->project_id)->delete();
                    $PL = ProjectLevels::where("project_id", $request->project_id)->delete();
                    $PA = ProjectApprover::where("project_id", $request->project_id)->delete();
                    $PDocDet = ProjectDocumentDetail::leftjoin('project_document', 'project_document.id', '=', 'project_document_details.project_doc_id')
                        ->leftjoin('projects', 'projects.id', '=', 'project_document.project_id')
                        ->where("projects.id", $request->project_id)
                        ->delete();
                    $PDoc = projectDocument::where("project_id", $request->project_id)->delete();
                    $path = public_path().'/projectDocuments/'.$project->ticket_no;
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
            return redirect('projects')->with('success', "Projects Stored successfully.");
        } catch (Exception $e) {
            return [

                'message' => "failed",
                'data' => $e
            ];
        }






        $input = $request->all();
        if (isset($request->project_id)) {
            // dd($input);
            $project_level_array = array();
            $project_update = Project::where("id", $request->project_id)->update(
                [
                    "project_name" => $request->project_name,
                    "project_code" => $request->project_code,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'initiator_id' => $request->initiator_id,
                    'document_type_id' => $request->document_type_id,
                    'workflow_id' => $request->workflow_id,
                    'role' => $request->role,
                    'is_active' => $request->is_active ? 1 : 0,
                ]
            );
            $milestone_delete = ProjectMilestone::where("project_id", $request->project_id)->delete();
            foreach ($request->milestone as $key => $miles) {
                $project_milestone = new ProjectMilestone();
                $project_milestone->project_id = $request->project_id;
                $project_milestone->milestone = $miles;
                $project_milestone->mile_start_date = $request->mile_start_date[$key];
                $project_milestone->mile_end_date = $request->mile_end_date[$key];
                $project_milestone->levels_to_be_crossed = $request->level_to_be_crosssed[$key];
                $project_milestone->is_active = 1;
                $project_milestone->save();
            }
            $levels_delete = ProjectLevels::where("project_id", $request->project_id)->delete();
            foreach ($request->priority as $plkey => $level) {

                if ($files = $request->file('main_document')) {
                    foreach ($files as $file) {
                        $name = $file->getClientOriginalName();
                        $file->move('main_document', $name);
                        $main_document[] = $name;
                    }
                }

                if ($files = $request->file('auxillary_document')) {
                    foreach ($files as $file) {
                        $name = $file->getClientOriginalName();
                        $file->move('auxillary_document', $name);
                        $auxillary_document[] = $name;
                    }
                }

                if (isset($input['staff' . $plkey])) {
                    foreach ($input['staff' . $plkey] as $skey => $staff) {

                        $project_level_array[] = array(
                            'project_id' => $request->project_id,
                            'project_level' => $request->project_level_edit[count($project_level_array)],
                            'due_date' => $request->due_date[$plkey],
                            'priority' => $request->priority[$plkey],
                            'staff' => $input['staff' . $plkey][$skey]
                        );
                        // $project_level = new ProjectLevels();
                        // $project_level->project_id = $request->project_id;
                        // $project_level->project_level = $request->project_level_edit[$c];
                        // $project_level->due_date = $request->due_date[$plkey];
                        // $project_level->priority = $request->priority[$plkey];
                        // $project_level->staff = $input['staff' . $plkey][$skey];
                        // $project_level->save();

                    }
                }



                if (isset($main_document[$plkey]) && $main_document[$plkey] != "") {
                    $doc_update = projectDocument::where(["project_id" => $request->project_id, 'type' => 1])->update(["is_latest" => 0]);
                    $doc = new projectDocument();
                    $doc->type = 1;
                    $doc->project_id = $request->project_id;
                    $doc->project_level = $request->project_level[$plkey];
                    $doc->document = $main_document[$plkey];
                    $doc->is_latest = 1;
                    $doc->save();
                }

                if (isset($auxillary_document[$plkey]) && $auxillary_document[$plkey] != "") {
                    $doc_update = projectDocument::where(["project_id" => $request->project_id, 'type' => 2])->update(["is_latest" => 0]);
                    $doc = new projectDocument();
                    $doc->type = 2;
                    $doc->project_id = $request->project_id;
                    $doc->project_level = $request->project_level[$plkey];
                    $doc->document = $auxillary_document[$plkey];
                    $doc->is_latest = 1;
                    $doc->save();
                }
            }
            ProjectLevels::insert($project_level_array);
            // dd($project_level_array);

        } else {

            // echo "<pre>";
            // print_r($_FILES);
            // die();
            // dd($input);
            $project_level_array = array();
            $check_project_name = Project::where('project_name', $request->project_name)->pluck('id')->first();
            $check_project_code = Project::where('project_code', $request->project_code)->pluck('id')->first();

            if ($check_project_name == null) {
                if ($check_project_code == null) {
                    $project = new Project();
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
                    $id = $project->id;
                    if ($id) {
                        foreach ($request->milestone as $key => $miles) {
                            $project_milestone = new ProjectMilestone();
                            $project_milestone->project_id = $id;
                            $project_milestone->milestone = $miles;
                            $project_milestone->mile_start_date = $request->mile_start_date[$key];
                            $project_milestone->mile_end_date = $request->mile_end_date[$key];
                            $project_milestone->levels_to_be_crossed = $request->level_to_be_crosssed[$key];
                            $project_milestone->is_active = 1;
                            $project_milestone->save();
                        }

                        foreach ($request->priority as $plkey => $level) {

                            //Main Document//
                            $length = count($_FILES['main_document' . $plkey]['name']);
                            for ($i = 0; $i < $length; $i++) {
                                if ($_FILES['main_document' . $plkey]['name'][$i]) {
                                    if (!is_dir(public_path() . '/main_document/' . $request->project_name . '/')) {
                                        mkdir(public_path() . '/main_document/' . $request->project_name . '/', 0777, true);
                                    }
                                    $upload_path = public_path() . '/main_document/' . $request->project_name . '/';
                                    $upload_path_table = public_path() . '/main_document/' . $request->project_name . '/';
                                    $banner = $_FILES['main_document' . $plkey]['name'][$i];
                                    $expbanner = explode('.', $banner);
                                    $bannerexptype = $expbanner[1];
                                    $date = date('m/d/Yh:i:sa', time());
                                    $rand = rand(10000, 99999);
                                    $encname = $date . $rand;
                                    $bannername = md5($encname) . '.' . $bannerexptype;
                                    $bannerpath = $upload_path . $bannername;
                                    move_uploaded_file($_FILES["main_document" . $plkey]["tmp_name"][$i], $bannerpath);
                                    $main_document = $upload_path_table . $bannername;

                                    $doc_update = projectDocument::where(["project_id" => $id, 'type' => 1])->update(["is_latest" => 0]);
                                    $doc = new projectDocument();
                                    $doc->type = 1;
                                    $doc->project_id = $id;
                                    $doc->project_level = $request->project_level[$plkey];
                                    $doc->document = '/main_document/' . $request->project_name . '/' . $bannername;
                                    $doc->is_latest = 1;
                                    $doc->original_name = $_FILES['main_document' . $plkey]['name'][$i];
                                    $doc->save();

                                    $docdetail = new ProjectDocumentDetail();
                                    $docdetail->project_doc_id =  $doc->id;
                                    $docdetail->document_name = '/main_document/' . $request->project_name . '/' . $bannername;
                                    $docdetail->status = 1;
                                    $docdetail->save();
                                }
                            }
                            //Main Document ENDS//

                            //AUXILLARY DOC//
                            $length = count($_FILES['auxillary_document' . $plkey]['name']);
                            for ($i = 0; $i < $length; $i++) {
                                if ($_FILES['auxillary_document' . $plkey]['name'][$i]) {
                                    if (!is_dir(public_path() . '/auxillary_document/' . $request->project_name . '/')) {
                                        mkdir(public_path() . '/auxillary_document/' . $request->project_name . '/', 0777, true);
                                    }
                                    $upload_path = public_path() . '/auxillary_document/' . $request->project_name . '/';
                                    $upload_path_table = public_path() . '/auxillary_document/' . $request->project_name . '/';
                                    $banner = $_FILES['auxillary_document' . $plkey]['name'][$i];
                                    $expbanner = explode('.', $banner);
                                    $bannerexptype = $expbanner[1];
                                    $date = date('m/d/Yh:i:sa', time());
                                    $rand = rand(10000, 99999);
                                    $encname = $date . $rand;
                                    $bannername = md5($encname) . '.' . $bannerexptype;
                                    $bannerpath = $upload_path . $bannername;
                                    move_uploaded_file($_FILES["auxillary_document" . $plkey]["tmp_name"][$i], $bannerpath);
                                    $auxillary_document = $upload_path_table . $bannername;

                                    $doc_update = projectDocument::where(["project_id" => $id, 'type' => 2])->update(["is_latest" => 0]);
                                    $doc = new projectDocument();
                                    $doc->type = 2;
                                    $doc->project_id = $id;
                                    $doc->project_level = $request->project_level[$plkey];
                                    $doc->document = '/auxillary_document/' . $request->project_name . '/' . $bannername;
                                    $doc->is_latest = 1;
                                    $doc->original_name = $_FILES['auxillary_document' . $plkey]['name'][$i];
                                    $doc->save();

                                    $docdetail = new ProjectDocumentDetail();
                                    $docdetail->project_doc_id =  $doc->id;
                                    $docdetail->document_name = '/auxillary_document/' . $request->project_name . '/' . $bannername;
                                    $docdetail->status = 1;
                                    $docdetail->save();
                                }
                            }
                            //AUXILLARY DOC//
                            if (isset($input['staff' . $plkey])) {
                                foreach ($input['staff' . $plkey] as $skey => $staff) {
                                    if ($staff != null) {
                                        $project_level_array[] = array(
                                            'level' => $request->project_level,
                                        );
                                        $project_level = new ProjectLevels();
                                        $project_level->project_id = $id;
                                        $project_level->project_level = $request->project_level[$plkey];
                                        $project_level->due_date = $request->due_date[$plkey];
                                        $project_level->priority = $request->priority[$plkey];
                                        $project_level->staff = $input['staff' . $plkey][$skey];
                                        $project_level->save();
                                    }
                                }
                            }
                        }
                    } else {
                        return redirect()->back()->withErrors(['error' => ['Insert Error']]);
                    }
                } else {
                    return redirect('projects')->with('error', "Project Code Already Exists.");
                }
            } else {
                return redirect('projects')->with('error', "Project Name Already Exists.");
            }
        }
        return redirect('projects')->with('success', "Project Stored successfully.");
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
            ->leftJoin('project_milestone as pm', 'pm.project_id', '=', 'p.id')
            ->leftjoin('employees as staff', 'staff.id', '=', 'pl.staff')
            ->where("p.id", '=', $id)
            ->select('p.ticket_no', 'pl.staff', 'pm.created_at as milestone_created', 'pm.mile_start_date', 'staff.profile_image as staff_image', 'staff.first_name as staff_first_name', 'staff.last_name as staff_last_name');
        $details1 = $project_details1->get();
        // dd($details1);

        $main_doc = DB::table('project_document as p')
            ->where("p.project_id", '=', $id)
            ->where("p.type", '=', 1)
            ->select('*');
        $maindocument = $main_doc->get();

        $aux_doc = DB::table('project_document as p')
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

        return view('Projects/view', ['levelsArray' => $entities, 'levelCount' => $levelCount, 'maindocument' => $maindocument, 'auxdocument' => $auxdocument, 'details' => $details, 'details1' => $details1, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }

    public function getProjectLevel(Request $request)
    {
        $id = $request->project_id;
        $level = $request->level;
        $projectDataWithLevelId = Project::leftjoin('project_milestone', 'project_milestone.project_id', '=', 'projects.id')
            ->leftjoin('project_levels', 'project_levels.project_id', '=', 'projects.id')
            ->leftjoin('project_approvers', 'project_approvers.project_level_id', '=', 'project_levels.id')
            ->leftjoin('employees as staff', 'staff.id', '=', 'project_approvers.approver_id')
            ->where('projects.id', $id)
            ->where('project_levels.project_level', $level)
            ->get();
        // dd($projectDataWithLevelId);
        $project_details1 = DB::table('projects as p')
            ->leftjoin('project_levels as pl', 'pl.project_id', '=', 'p.id')
            ->leftJoin('project_milestone as pm', 'pm.project_id', '=', 'p.id')
            ->leftjoin('employees as staff', 'staff.id', '=', 'pl.staff')
            ->where("p.id", '=', $id)
            ->where("pl.project_level", '=', $level)

            ->select('pl.staff', 'pm.created_at as milestone_created', 'pm.mile_start_date', 'staff.profile_image as staff_image', 'staff.first_name as staff_first_name', 'staff.last_name as staff_last_name');
        $details1 = $project_details1->get();

        echo json_encode($details1);
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
            ->leftjoin('projects', 'projects.id', 'project_document.project_id')
            ->where('project_document.id', $request->documentId)
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
    public function getProjectLevelLooping($projectId)
    {
        $projectModel = Project::where('id', $projectId)->first();
        $models = Workflowlevels::with('workflowLevelDetail')->where('workflow_id', $projectModel->workflow_id)->get();
        $entities = collect($models)->map(function ($model) use ($projectId) {
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


            $datas = ['levelId' => $model->levels, 'designationId' => $designationArray, 'projectMasterData' => $projectMasterData, 'projectApprovers' => $projectApproversArray];

            return $datas;
        });
        return $entities;
    }
}
