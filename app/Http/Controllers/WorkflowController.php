<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Workflow;
use App\Models\WorkflowLevelDetail;
use App\Models\Workflowlevels;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkflowController extends Controller
{

    public function getWorkflowCodeFormat(Request $request)
    {
       $wfname = $request->wfname;   
       $wfcode =$this->genarateWFCode($wfname);
       return response()->json($wfcode);

    }
    public function genarateWFCode($wfname)
    {
        $workflow = Workflow::latest('id')->first();

        $runningNo = ($workflow) ? ($workflow->id + 1) : 1;
        $digit = strlen($runningNo);
        $genNo = "";
        if ($digit == 1) {
            $genNo = "000" . $runningNo;
        } elseif ($digit == 2) {
            $genNo = "00" . $runningNo;
        } else {
            $genNo = "0" . $runningNo;
        } 
     
     
        $wfCode = "SWF".date('Y').substr($wfname, 0, 3).$genNo;
        return $wfCode;
    }
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
        $workflow = Workflow::latest('id')->first();

        $runningNo = ($workflow) ? ($workflow->id + 1) : 1;

        $digit = strlen($runningNo);
        $genNo = "";
        if ($digit == 1) {
            $genNo = "0000" . $runningNo;
        } elseif ($digit == 2) {
            $genNo = "000" . $runningNo;
        } else {
            $genNo = "00" . $runningNo;
        }

        $wfCode = "";

        $designationDatas = Designation::where('is_active', 1)->where('is_active', 1)->get();

        $employeeModels = Employee::with('designation')->whereNull('deleted_at')->where('is_active', 1)->get();
        $employeeDatas = collect($employeeModels)->map(function ($employeeData) {
            $designationData = ($employeeData['designation']);

            $designationName = $designationData->name;
            $name = $employeeData->first_name." ".$employeeData->middle_name." ".$employeeData->last_name.'('.$employeeData->sap_id.')'.'-('.$designationName.')';
         
           return ['id'=>$employeeData->id,'data'=>$name];
           
        });
        
        // dd($employeeDatas[0]['designation']->name);

        return view('Workflow/addPage', compact('designationDatas', 'wfCode', 'employeeDatas'));
    }

    public function edit($id)
    {
        $designationDatas = Designation::where('is_active', 1)->where('is_active', 1)->get();
        $models = Workflowlevels::with('workflowLevelDetail')->where('workflow_id', $id)->get();

        $modelWorkflow = Workflow::find($id);
        $entities = collect($models)->map(function ($model) {
            $levelDetails = $model['workflowLevelDetail'];

            $e = collect($levelDetails)->map(function ($levelDetail) {
                $designationId = $levelDetail->employee_id;

                return $designationId;
            });
            $designationArray =  $e->toArray();


            $datas = ['levelId' => $model->levels, 'designationId' => $designationArray];

            return $datas;
        });

        $employeeModels = Employee::with('designation')->whereNull('deleted_at')->where('is_active', 1)->get();
        $employeeDatas = collect($employeeModels)->map(function ($employeeData) {
            $designationData = ($employeeData['designation']);

            $designationName = $designationData->name;
            $name = $employeeData->first_name." ".$employeeData->last_name.'('.$employeeData->sap_id.')'.'-('.$designationName.')';
         
           return ['id'=>$employeeData->id,'data'=>$name];
           
        });
        return view('Workflow/editPage', compact('designationDatas', 'entities', 'modelWorkflow', 'employeeDatas'));
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
        //  dd($input);

        if (!$request->workflow_id) {
            if ($input['workflow_type'] == 1) {
                $levels = array();
                for ($i = 1; $i < 12; $i++) {
                    array_push($levels, $i);
                }
                $input['levels'] = $levels;
            }
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
                        Log::info('WorkflowController->Store:-level ' . json_encode($levels));
                        if ($input['workflow_type'] == 1) {
                            Log::info('WorkflowController->Store:-Level With fApprover designation  ' . json_encode($input['fapprover_designation' . $levels][$j]));
                        } else {
                            Log::info('WorkflowController->Store:-Level With Approver designation  ' . json_encode($input['approver_designation' . $levels][$j]));
                        }



                        $workflow_level_details = new WorkflowLevelDetail();
                        $workflow_level_details->workflow_id = $id;
                        $workflow_level_details->workflow_level_id = $workflow_levels->id;
                        if ($input['workflow_type'] == 1) {
                            $workflow_level_details->employee_id = $input['fapprover_designation' . $levels][$j];
                        } else {
                            $workflow_level_details->employee_id = $input['approver_designation' . $levels][$j];
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



        $entities = $this->getLevelLooping($workflow_id);
        //dd($entities);
        echo json_encode(["workflow" => $workflow, 'workflow_level' => $entities]);
    }
    public function getLevelLooping($workflow_id)
    {
        $models = Workflowlevels::with('workflowLevelDetail', 'workflowLevelDetail.employeeData')->where('workflow_id', $workflow_id)->get();

        $entities = collect($models)->map(function ($model) {
            $empModel = WorkflowLevelDetail::select('employees.*','designations.name as designation_name')->leftjoin('employees', 'employees.id', '=', 'workflow_level_details.employee_id')->leftjoin('designations', 'designations.id', '=', 'employees.designation_id')->where('workflow_level_id', $model->id)->get()->toArray();


            // $e = collect($levelDetails)->map(function ($levelDetail) use($empModel) {
            //     $empData = $levelDetail->employeeData;

            //     // $designationId = $levelDetail->designation_id;

            //     // $designationName = Designation::with('employee')->where('id', $designationId)->first();
            //     // $desEmployee = $designationName->employee;
            //     $employeeId = $levelDetail->employee_id;
            //     $desEmployee = Employee::where('id', $employeeId)->first();


            //     // $desEmployee

            //     $desData = ['desEmployee' => $desEmployee];

            //     return $desData;
            // });

            // $designationArray =  array_fla($e);


            $datas = ['levelId' => $model->levels, 'designationId' => $empModel];

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
                // $employeeId = $levelDetail->employee_id;
                // $designationName = Designation::where('id', $designationId)->first()->name;
                $employeeId = $levelDetail->employee_id;
                $designationDetail = Employee::with('designation')->where('id', $employeeId)->first();
              
                $designationData = $designationDetail->first_name . " " . $designationDetail->last_name . "(" . $designationDetail->sap_id . ")" . "-(" . $designationDetail['designation']['name'] . ")";

                return $designationData;
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

        $model = Workflow::where('workflow_code', $request->code)->where('id', '!=', $request->id)->first();

        $response = ($model) ? false : true;
        return response()->json(['response' => $response]);
    }

    public function search(Request $request)
    {

        $searchData = $request->searchData;
        $model = Workflow::select('*')

            ->where(function ($query) use ($searchData) {
                $query->where('workflow_code', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('workflow_name', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('total_levels', 'LIKE', '%' . $searchData . '%');
            })
            ->whereNull('deleted_at')
            ->get();

        return response()->json($model);
    }
}
