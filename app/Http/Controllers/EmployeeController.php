<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function getEmployeeDetailByParams(Request $request)
    {

        $model = Employee::with('user');
        if ($request->fieldname == "sapId") {
            $model->where('sap_id', $request->fieldData);
        }
        if ($request->fieldname == "email") {
            $model->where('email', $request->fieldData);
        }
        if ($request->fieldname == "mobile") {
            $model->where('mobile', $request->fieldData);
        }
        if ($request->fieldname == "EmpId") {
            $model->where('id', $request->fieldData);
        }
        $data = $model->first();

        return json_encode($data);
    }
    public function index()
    {
        $employee_all = $this->get_all_employee();
        $employees = Employee::where('delete_flag', 1)->get()->toArray();
        $departments = Department::where('is_active', 1)->where('delete_flag', 1)->get()->toArray();
        $designation = Designation::where('is_active', 1)->where('delete_flag', 1)->get()->toArray();
        return view('Employee/list', ['employee_all' => $employee_all, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }

    public function get_all_employee()
    {
        $employees = DB::table('employees as e')
            ->select('e.*', 'd.id as department_id', 'd.name as department_name', 'de.id as designation_id', 'de.name as designation_name', 'e.is_active as employee_status')
            ->join('departments as d', 'd.id', '=', 'e.department_id')
            ->join('designations as de', 'de.id', '=', 'e.designation_id')
            ->where('e.delete_flag', 1)
            ->get();
        return $employees;
    }
    public function employeeDetailById(Request $request)
    {
        $model = Employee::select('employees.id', 'employees.first_name', 'employees.email', 'employees.last_name', 'employees.profile_image', 'employees.mobile', 'employees.is_active', 'employees.sap_id', 'departments.name as deptName', 'designations.name as desgName')
            ->leftjoin('departments', 'departments.id', '=', 'employees.department_id')
            ->leftjoin('designations', 'designations.id', '=', 'employees.designation_id')
            ->where('employees.id', $request->id)
            ->get();
        return response()->json($model);

    }
    public function employeeDetailByDesDept(Request $request)
    {
        $model = Employee::select('employees.id', 'employees.first_name', 'employees.email', 'employees.last_name', 'employees.profile_image', 'employees.mobile', 'employees.is_active', 'employees.sap_id', 'departments.name as deptName', 'designations.name as desgName');
        $model->leftjoin('departments', 'departments.id', '=', 'employees.department_id');
        $model->leftjoin('designations', 'designations.id', '=', 'employees.designation_id');
        if ($request->deptId) {
            $model->where('department_id', $request->deptId);
        }
        if ($request->descId) {
            $model->where('designation_id', $request->descId);
        }

        $data = $model->get();
        return response()->json($data);
    }
    public function getDetailsById(Request $request)
    {
        $id = $request->emp_id;
        $employees = DB::table('employees as e')
            ->select('*', 'd.name as department_name', 'de.name as designation_name', 'e.is_active as employee_status')
            ->join('departments as d', 'd.id', '=', 'e.department_id')
            ->join('designations as de', 'de.id', '=', 'e.designation_id')
            ->where('e.id', '=', $id)
            ->get();
        echo json_encode($employees);
    }
    public function store(Request $request)
    {

        if ($request->id == "") {
            $check_email = Employee::where('email', $request->email)->pluck('id')->first();
        } else {
            $check_email = null;
        }

        if ($request->id == "") {
            $check_mobile = Employee::where('mobile', $request->mobile)->pluck('id')->first();
        } else {
            $check_mobile = null;
        }

        if ($request->id == "") {
            $check_sap = Employee::where('sap_id', $request->sap_id)->pluck('id')->first();
        } else {
            $check_sap = null;
        }

        if ($check_email == null) {

            if ($check_mobile == null) {

                if ($check_sap == null) {

                    if ($request->hasFile('profile_image')) {

                        $image = $request->file('profile_image');
                        $profile_image = "p" . time() . '.' . $image->getClientOriginalExtension();
                        $destinationPath = public_path('/images');
                        $image->move($destinationPath, $profile_image);
                    } else {
                        $profile_image = DB::table('employees')->where(['id' => $request->id])->value('profile_image');
                    }

                    if ($request->hasFile('sign_image')) {
                        $image = $request->file('sign_image');
                        $sign_image = "s" . time() . '.' . $image->getClientOriginalExtension();
                        $destinationPath = public_path('/images');
                        $image->move($destinationPath, $sign_image);
                    } else {
                        $sign_image = DB::table('employees')->where(['id' => $request->id])->value('sign_image');
                    }

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
                    unset($input['_token']);
                    $input['profile_image'] = $profile_image;
                    $input['sign_image'] = $sign_image;
                    $id = Employee::updateOrInsert(
                        ['id' => $request->id],
                        $input
                    );
                    if ($id) {
                        return redirect('employees')->with('success', "Employee Stored successfully.");
                    } else {
                        return redirect()->back()->withErrors(['error' => ['Insert Error']]);
                    }
                } else {
                    return redirect('employees')->with('error', "SAP-ID Already Exists.");
                }
            } else {
                return redirect('employees')->with('error', "Mobile Already Exists.");
            }
        } else {
            return redirect('employees')->with('error', "Email Already Exists.");
        }
    }

    public function destroy($id)
    {

        $employee_update = Employee::where("id", $id)->update(["delete_flag" => 0]);
        echo json_encode($employee_update);
    }

    public function changeActiveStatus(Request $request)
    {

        $employee_update = Employee::where("id", $request->id)->update(["is_active" => $request->status]);
        echo json_encode($employee_update);
    }
}
