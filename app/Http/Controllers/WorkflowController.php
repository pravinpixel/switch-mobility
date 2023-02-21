<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Workflow;
use App\Models\WorkflowLevelDetail;
use App\Models\Workflowlevels;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class WorkflowController extends Controller
{
 public function changeWorkflowActiveStatus(Request $request)
 {
    $model = Workflow::where("id", $request->id)->update(["is_active" => $request->status]);
    echo json_encode($model);
 }
    public function index()
    {
        $designation = Designation::where('is_active', 1)->whereNull('deleted_at')->get()->toArray();
        $designation_edit = Designation::where('is_active', 1)->whereNull('deleted_at')->get();
        $workflow = Workflow::whereNull('deleted_at')->get()->toArray();
        $allwork_flow = $this->get_all_workflow();
        return view('Workflow/list', ['designation_edit' => $designation_edit, 'all_workflow' => $allwork_flow, 'workflow' => $workflow, 'designation' => $designation]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designationDatas = Designation::where('is_active', 1)->where('is_active', 1)->get();

        return view('Workflow/addPage', compact('designationDatas'));
    }

    public function edit($id)
    {
        $designationDatas = Designation::where('is_active', 1)->where('is_active', 1)->get();
        $models = Workflowlevels::with('workflowLevelDetail')->where('workflow_id', $id)->get();

        $modelWorkflow = Workflow::find($id);
        $entities = collect($models)->map(function ($model) {
            $levelDetails = $model['workflowLevelDetail'];

            $e = collect($levelDetails)->map(function ($levelDetail) {
                $designationId = $levelDetail->designation_id;

                return $designationId;
            });
            $designationArray =  $e->toArray();


            $datas = ['levelId' => $model->levels, 'designationId' => $designationArray];

            return $datas;
        });


        return view('Workflow/editPage', compact('designationDatas', 'entities', 'modelWorkflow'));
    }
    public function get_all_workflow()
    {
        $workflow = DB::table('workflows as w')
            ->select('*', 'wl.id as work_level_id', 'd.name as designation')
            ->join('workflow_levels as wl', 'wl.workflow_id', '=', 'w.id')
            ->join('designations as d', 'd.id', '=', 'wl.approver_designation')
            ->get();

        return $workflow;
    }

    public function store(Request $request)
    {
        $input = $request->all();       

        if ($input['workflow_type'] == 1) {
            $levels = array();
            for ($i = 1; $i < 12; $i++) {
                array_push($levels, $i);
            }
            $input['levels'] = $levels;
        }

        if ($request->workflow_id) {
            $id = $request->workflow_id;
            Workflowlevels::where('workflow_id', $request->workflow_id)->delete();
            WorkflowLevelDetail::where('workflow_id', $request->workflow_id)->delete();
            Workflow::where('id', $id)->update(['workflow_code' => $input['workflow_code'], 'workflow_name' => $input['workflow_name'], 'workflow_type' => $input['workflow_type'] ? 1 : 0, 'total_levels' => count($input['levels'])]);
        } else {
            $workflow = new Workflow();
            $workflow->workflow_code = $input['workflow_code'];
            $workflow->workflow_name = $input['workflow_name'];
            $workflow->workflow_type = $input['workflow_type'] ? 1 : 0;
            $workflow->total_levels = count($input['levels']);
            $workflow->is_active = 1;
            $workflow->save();
            $id = $workflow->id;
        }
        if ($id) {
            foreach ($input['levels'] as $levels) {
                if ($levels != 0) {
                    $workflow_levels = new Workflowlevels();
                    $workflow_levels->workflow_id = $id;
                    $workflow_levels->levels = $levels;
                    $workflow_levels->is_active = 1;
                    $workflow_levels->save();
                    if ($input['workflow_type'] == 1) {
                        $totDesignation = $input['fapprover_designation' . $levels];
                    } else {
                        $totDesignation = $input['approver_designation' . $levels];
                    }
                    for ($j = 0; $j < count($totDesignation); $j++) {
                        $workflow_level_details = new WorkflowLevelDetail();
                        $workflow_level_details->workflow_id = $id;
                        $workflow_level_details->workflow_level_id = $workflow_levels->id;
                        if ($input['workflow_type'] == 1) {
                            $workflow_level_details->designation_id = $input['fapprover_designation' . $levels][$j];
                        } else {
                            $workflow_level_details->designation_id = $input['approver_designation' . $levels][$j];
                        }


                        $workflow_level_details->save();
                    }
                }
            }
            return redirect('workflow')->with('success', "Work Flow Stored successfully.");
        } else {
            return redirect()->back()->withErrors(['error' => ['Insert Error']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checkChildData = DocumentType::where('workflow_id', $id)->first();
        if ($checkChildData) {
            $data = [
                "message" => "Failed",
                "data" => "Document Type already exist.cannot delete."
            ];
        } else {
            $model = Workflow::where("id", $id)->delete();
            $data = [
                "message" => "Success",
                "data" => "Document Type Deleted Successfully."
            ];
        }
        return response()->json($data);
    }

    public function getWorkflowById(Request $request)
    {
        $workflow_id = $request->workflow_id;
        $workflow = Workflow::where('id', $workflow_id)->get()->first();

        

        $entities =$this->getLevelLooping($workflow_id);
        //dd($entities);
        echo json_encode(["workflow" => $workflow, 'workflow_level' => $entities]);
    }
public function getLevelLooping($workflow_id)
{
    $models = Workflowlevels::with('workflowLevelDetail')->where('workflow_id', $workflow_id)->get();
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
    return $entities;
}
    public function getWorkflowLevels(Request $request)
    {
        $workflow_id = $request->workflow_id;
        $designation = Designation::where('is_active', 1)->get()->toArray();
        $workflow = Workflow::where('id', $workflow_id)->get()->first();
        $workflow_levels = DB::table('workflows as w')
            ->select('*', 'wl.id as work_level_id', 'd.name as designation')
            ->join('workflow_levels as wl', 'wl.workflow_id', '=', 'w.id')
            ->join('designations as d', 'd.id', '=', 'wl.approver_designation')
            ->where('workflow_id', '=', $workflow_id)
            ->get();

        $arr = array();
        $arr1 = array();
        foreach ($workflow_levels as $wl) {
            $arr[$wl->levels] = $wl->levels;
        }
        $arr = array_values($arr);
        foreach ($arr as $levels) {
            $arr1[] = Workflowlevels::where('levels', $levels)->pluck('approver_designation');
        }



        $models = Workflowlevels::with('workflowLevelDetail')->where('workflow_id', $workflow_id)->get();

        $entities = collect($models)->map(function ($model) {
            $levelDetails = $model['workflowLevelDetail'];

            $e = collect($levelDetails)->map(function ($levelDetail) {
                $designationId = $levelDetail->designation_id;
                $designationName = Designation::where('id', $designationId)->first()->name;

                return $designationName;
            });

            $designationArray =  $e;


            $datas = ['levelId' => $model->levels, 'designationId' => $designationArray];

            return $datas;
        });



        $output = array(
            'workflow' => $workflow,
            'workflow_levels' => $arr,
            'designation' => $designation,
            'approver' => $arr1,
            'workflow_levels_details' => $workflow_levels,
            'entities' => $entities
        );
        return response()->json($output);
    }
    public function workflowValidation(Request $request)
    {
       
        $model = Workflow::where('workflow_code',$request->code)->where('id', '!=', $request->id)->first();
 
        $response = ($model)?false:true;
        return response()->json(['response'=>$response]);
    }
}
