<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::get()->toArray();
        return view('Departments/list', ['departments' => $departments]);
    }


    public function create()
    {
      
       return view('Departments/DeptDetails');
    }

    public function edit($id)
    {
       
        return view('formError');
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
        dd($input);
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
            $check = Department::where('name', $request->name)->pluck('id')->first();
        } else {
            $check = null;
        }
        if ($check == null) {
            unset($input['_token']);
            $id = Department::updateOrInsert(
                ['id' => $request->id],
                $input
            );
            if ($id) {
                return redirect('department')->with('success', "Department Stored successfully.");
            } else {
                return redirect()->back()->withErrors(['error' => ['Insert Error']]);
            }
        } else {
            return redirect('department')->with('error', "Department Already Exists.");
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
        $checkChildData = Employee::where('department_id', $id)->first();
        if ($checkChildData) {
            $data = [
                "message" => "Failed",
                "data" => "Department already exist.cannot delete."
            ];
        } else {
            $model = Department::where("id", $id)->delete();
            $data = [
                "message" => "Success",
                "data" => "Department Deleted Successfully."
            ];
        }
        return response()->json($data);
    }
    public function changedepartmentActiveStatus(Request $request)
    {
        $employee_update = Department::where("id", $request->id)->update(["is_active" => $request->status]);
        echo json_encode($employee_update);
    }
    public function departmentValidation(Request $request)
    {
        dd($request->all());
    }
}
