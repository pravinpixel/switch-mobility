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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    public function index()
    {

        $projects_all = $this->get_all_projects();
        $employees = Employee::where('is_active', 1)->get()->toArray();
        $departments = Department::where('is_active', 1)->get()->toArray();
        $designation = Designation::where('is_active', 1)->get()->toArray();
        $document_type = DocumentType::where('is_active', 1)->get()->toArray();
        $workflow = Workflow::where('is_active', 1)->get()->toArray();
        return view('Projects/list', ['document_type' => $document_type, 'workflow' => $workflow, 'projects_all' => $projects_all, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
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

        $input = $request->all();
        if (isset($request->project_id)) {
            // dd($input);
            $project_level_array=array();
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

                if(isset($input['staff' . $plkey])){
                    foreach ($input['staff' . $plkey] as $skey=>$staff) {
                            
                            $project_level_array[]=array(
                                'project_id'=>$request->project_id,
                                'project_level'=>$request->project_level_edit[count($project_level_array)],
                                'due_date'=>$request->due_date[$plkey],
                                'priority'=>$request->priority[$plkey],
                                'staff'=>$input['staff' . $plkey][$skey]
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
            $project_level_array=array();
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
                            if(isset($input['staff' . $plkey])){
                                foreach ($input['staff' . $plkey] as $skey=>$staff) {
                                    if ($staff != null) {
                                        $project_level_array[]=array(
                                            'level'=>$request->project_level,
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
            ->select('p.id', 'p.project_name', 'p.project_code', 'e.profile_image', 'des.name as designation', 'doc.name as document_type', 'w.workflow_code', 'w.workflow_name', 'e.first_name', 'e.last_name', 'd.name as department', 'p.is_active');
        $details = $project_details->first();

        $project_details1 = DB::table('projects as p')
            ->leftjoin('project_levels as pl', 'pl.project_id', '=', 'p.id')
            ->leftJoin('project_milestone as pm', 'pm.project_id', '=', 'p.id')
            ->leftjoin('employees as staff', 'staff.id', '=', 'pl.staff')
            ->where("p.id", '=', $id)
            ->select('pl.staff', 'pm.created_at as milestone_created', 'pm.mile_start_date', 'staff.profile_image as staff_image', 'staff.first_name as staff_first_name', 'staff.last_name as staff_last_name');
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


        return view('Projects/view', ['levelCount' => $levelCount, 'maindocument' => $maindocument, 'auxdocument' => $auxdocument, 'details' => $details, 'details1' => $details1, 'document_type' => $document_type, 'workflow' => $workflow, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }

    public function getProjectLevel(Request $request)
    {
        $id = $request->project_id;
        $level = $request->level;
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
        $designation = DB::table('workflow_levels')->where(['workflow_id' => $workflow_id, 'levels' => $level])->pluck('approver_designation');
        $designation_name = DB::table('designations')->where(['id' => $designation[0]])->pluck('name')->first();
        $employees = DB::table('employees')->whereIn('designation_id', $designation)->get();
        echo json_encode(["employees" => $employees, "designation_name" => $designation_name, 'destination' => $designation]);
    }


    public function docStatus(Request $request)
    {

        $current_status = projectDocument::where('id', $request->id)->pluck('status')->first();
        $change_status = ($current_status == 1) ? 2 : 1;
        $document_update = projectDocument::where("id", $request->id)->update(["status" => $change_status]);
        echo json_encode($current_status);
    }

    public function destroy($id)
    {
        $project_update = Project::where("id", $id)->update(["is_active" => 0]);
        echo json_encode($project_update);
    }
    public function uploadDocumentVersion(Request $request)
    {

        $parentModel = projectDocument::select('type', 'project_name', 'projects.id as projectId')->leftjoin('projects', 'projects.id', 'project_document.project_id')->where('project_document.id', $request->documentId)->first();

        $typeOfDoc = ($parentModel->type == 2) ? 'auxillary_document' : 'main_document';
        $project_name = $parentModel->project_name;


        $upload_path = public_path() . '/' . $typeOfDoc . '/' . $project_name . '/';
        $upload_path_table = public_path() . '/' . $typeOfDoc . '/' . $project_name . '/';
        $banner = $request->file('againestDocument')->getClientOriginalName();
        $expbanner = explode('.', $banner);
        $bannerexptype = $expbanner[1];
        $date = date('m/d/Yh:i:sa', time());
        $rand = rand(10000, 99999);
        $encname = $date . $rand;
        $bannername = md5($encname) . '.' . $bannerexptype;
        $bannerpath = $upload_path . $bannername;

        move_uploaded_file($request->againestDocument->path(), $bannerpath);

        $auxillary_document = $upload_path_table . $bannername;
        $lastversion  = ProjectDocumentDetail::where('project_doc_id', $request->documentId)->latest('id')->first()->version;

        $model = new ProjectDocumentDetail;
        $model->version = $lastversion + 1.0;
        $model->remark = $request->remarks;
        $model->project_doc_id = $request->documentId;
        $model->status = $request->statusversion;
        $model->document_name = '/' . $typeOfDoc . '/' . $project_name . '/' . $bannername;

        $model->save();
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
}
