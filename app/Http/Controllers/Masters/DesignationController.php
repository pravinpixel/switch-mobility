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
        $designation = Designation::get()->toArray();
        return view('Designation/list', ['designation' => $designation]);
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

        if (isset($request->is_active)) {
            if ($request->is_active) {
                $input['is_active'] = 1;
            } else {
                $input['is_active'] = 0;
            }
        } else {
            $input['is_active'] = 0;
        }
        if ($request->id == "") {
            $check = Designation::where('name', $request->name)->pluck('id')->first();
        } else {
            $check = null;
        }
        if ($check == null) {
            unset($input['_token']);
            $id = Designation::updateOrInsert(
                ['id' => $request->id],
                $input
            );
            if ($id) {
                return redirect('designation')->with('success', "Designation Stored successfully.");
            } else {
                return redirect()->back()->withErrors(['error' => ['Insert Error']]);
            }
        } else {
            return redirect('designation')->with('error', "Designation Already Exists.");
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
        if ($checkChildData&&$checkChildData2) {
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
}
