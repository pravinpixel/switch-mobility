<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\WorkflowLevelDetail;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designation = $this->findAll();
        return view('Designation/list', ['designation' => $designation]);
    }
    public function getDesignationListData()
    {
        $models = $this->findAll();

        return response()->json(['data' => $models]);
    }
    public function findAll()
    {
        return  Designation::orderBy('id', 'desc')->get()->toArray();
    }
    public function create()
    {
        $model = array();
        return view('Designation/DesignationDetail', compact('model'));
    }
    public function edit($id)
    {

        $model = Designation::findOrFail($id);

        return view('Designation/DesignationDetail', compact('model'));
    }
    public function designationEdit(Request $request)
    {
        $id = $request->id;
        $model = Designation::findOrFail($id);

        return view('Designation/DesignationDetail', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function designationValidation(Request $request)
    {
        $model = Designation::where('name', $request->name)->where('id', '!=', $request->id)->whereNull('deleted_at')->first();

        $response = ($model) ? false : true;

        return response()->json(['response' => $response]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $input = $request->all();
        if ($request->id) {
            $model = Designation::findOrFail($request->id);
            $msg = "Updated";
        } else {
            $model = new Designation();
            $msg = "Stored";
        }
        $model->name = $request->name;
        $model->description = $request->description;
        $model->save();

        if ($model) {
            return redirect('designation')->with('success', "Designation " . $msg . "  successfully.");
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
        $checkChildData = Employee::where('designation_id', $id)->first();
        $checkChildData2 = WorkflowLevelDetail::where('designation_id', $id)->first();
        if ($checkChildData || $checkChildData2) {
            $data = [
                "message" => "Failed",
                "data" => "Designation already exist.cannot delete."
            ];
        } else {
            $model = Designation::where("id", $id)->delete();
            $data = [
                "message" => "Success",
                "data" => "Designation Deleted Successfully."
            ];
        }
        return response()->json($data);
    }
    public function changeDesignationActiveStatus(Request $request)
    {
       
        $checkChildData = Employee::where('designation_id', $request->id)->first();
        $checkChildData2 = WorkflowLevelDetail::where('designation_id',  $request->id)->first();
        if ($checkChildData || $checkChildData2) {
            $data = [
                "message" => "Failed",
                "data" => "Designation Reference Are Found! Cannot Change Status."
            ];
        } else {
            $employee_update = Designation::where("id", $request->id)->update(["is_active" => $request->status]);
            $data = [
                "message" => "Success",
                "data" => "Designation Status Changed Successfully."
            ];
        }
        return response()->json(["data"=>$data]);
    }
    public function designationSearch(Request $request)
    {
        $searchData = $request->data;
        $model = Designation::select('*')
            ->where(function ($query) use ($searchData) {
                $query->where('name', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchData . '%');
            })
            ->whereNull('deleted_at')
            ->get();
        return response()->json($model);
    }
}
