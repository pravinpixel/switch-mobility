<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Email\EmailController;
use App\Imports\EmployeeImport;
use App\Imports\EmployeesImport;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectApprover;
use App\Models\ProjectEmployee;
use App\Models\ProjectLevels;
use App\Models\ReAssignedEmployee;
use App\Models\User;
use App\Models\WorkflowLevelDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    protected $ProjectController, $workflowController,$email;
    public function __construct(ProjectController $ProjectController, WorkflowController $workflowController,EmailController $email)
    {
        $this->ProjectController = $ProjectController;
        $this->workflowController = $workflowController;
        $this->email = $email;
    }

    public function create()
    {
        $departments = Department::where('is_active', 1)->get();
        $designation = Designation::where('is_active', 1)->get();

        $model = array();
        return view('Employee/EmployeeDetails', ['model' => $model, 'departments' => $departments, 'designation' => $designation]);
    }
    public function edit($id)
    {
        $departments = Department::where('is_active', 1)->get();
        $designation = Designation::where('is_active', 1)->get();

        $model = Employee::findOrFail($id);
        return view('Employee/EmployeeDetails', ['model' => $model, 'departments' => $departments, 'designation' => $designation]);
    }
    public function employeeEdit(Request $request)
    {
        $id = $request->id;
        $departments = Department::where('is_active', 1)->get();
        $designation = Designation::where('is_active', 1)->get();

        $model = Employee::findOrFail($id);
        return view('Employee/EmployeeDetails', ['model' => $model, 'departments' => $departments, 'designation' => $designation]);
    }
    function employeeValidation(Request $request)
    {
        dd($request->all());
    }
    public function store(Request $request)
    {

        $row = $request->all();

        $errors = array();
        $mobileCheck = $this->mobileCheckFunction($row['mobile'], $row['id']);

        if ($mobileCheck) {
            $error = ["alertField" => "mobileAlert", "name" => "Mobile", "type" => "Exists"];
            array_push($errors, $error);
        }
        $emailCheck = $this->emailCheckFunction($row['email'], $row['id']);
        if ($emailCheck) {
            $error = ["alertField" => "emailAlert", "name" => "Email", "type" => "Exists"];
            array_push($errors, $error);
        }
        $sapIdCheck = $this->sapIdCheckFunction($row['sap_id'], $row['id']);
        if ($sapIdCheck) {
            $error = ["alertField" => "sapIdAlert", "name" => "SapID", "type" => "Exists"];
            array_push($errors, $error);
        }
        if (count($errors)) {
            return response()->json(['status' => "failed", 'errors' => $errors]);
        } else {
            // try {
            //     Excel::import(new EmployeesImport, "bulk1.xlsx");  


            // } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            //      $failures = $e->failures();

            //      dd($failures);
            // }

            if ($request->id) {
                $model = Employee::findOrFail($request->id);
                $msg = "Updated";
            } else {
                $model = new Employee();
                $msg = "stored";
            }
            $model->first_name = $request->first_name;
            $model->last_name = $request->last_name;
            $model->email = $request->email;
            $model->mobile = $request->mobile;
            $model->department_id = $request->department_id;
            $model->designation_id = $request->designation_id;
            $model->address = $request->address;
            $model->sap_id = $request->sap_id;
            $model->save();
            if ($request->id != null && $request->IsProfileImage == null) {
                $removeProfileImagePath = public_path('/images/Employee/') . $model->profile_image;

                if (file_exists($removeProfileImagePath)) {
                    unlink($removeProfileImagePath);
                    $model->profile_image = null;
                    $model->save();
                }
            }
            if ($request->id != null && $request->IsSignImage == null) {
                $removeSignImagePath = public_path('/images/Employee/') . $model->sign_image;
                if (file_exists($removeSignImagePath)) {
                    unlink($removeSignImagePath);

                    $model->sign_image =  null;
                    $model->save();
                }
            }

            if ($request->hasFile('profile_image')) {

                $image = $request->file('profile_image');
                $profile_image = "p" . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/Employee');
                $image->move($destinationPath, $profile_image);

                $model->profile_image =  $profile_image;
                $model->save();
            }

            if ($request->hasFile('sign_image')) {
                $image = $request->file('sign_image');
                $sign_image = "s" . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/Employee');
                $image->move($destinationPath, $sign_image);
                $model->sign_image =  $sign_image;
                $model->save();
            }

            return response()->json(['status' => "success"]);

            // return redirect('employees')->with('success', "Employee " . $msg . " Successfully!.");
        }
    }
    public function employeeSearch(Request $request)
    {

        $searchData = $request->searchData;
        $searchData1 = "";
        if ($searchData == "active" || $searchData == "Active") {
            $searchData1 = 1;
        }
        if ($searchData == "in active" || $searchData == "In-active") {
            $searchData1 = 0;
        }

        $model = Employee::select('employees.id', 'employees.first_name', 'employees.email', 'employees.last_name', 'employees.profile_image', 'employees.mobile', 'employees.is_active', 'employees.sap_id', 'departments.name as deptName', 'designations.name as desgName')
            ->leftjoin('departments', 'departments.id', '=', 'employees.department_id')
            ->leftjoin('designations', 'designations.id', '=', 'employees.designation_id')
            ->where(function ($query) use ($searchData) {
                $query->where('employees.first_name', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('employees.last_name', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('employees.email', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('employees.mobile', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('employees.sap_id', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('designations.name', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('departments.name', 'LIKE', '%' . $searchData . '%');
            })
            ->whereNull('employees.deleted_at')
            ->get();

        return response()->json($model);
    }
    public function getEmployeeDetailByParams(Request $request)
    {

        $model = Employee::with('user')->where('id', '!=', $request->pkey)->whereNull('employees.deleted_at');
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

        $employees = Employee::whereNull('deleted_at')->get()->toArray();
        $departments = Department::where('is_active', 1)->whereNull('deleted_at')->get()->toArray();
        $designation = Designation::where('is_active', 1)->whereNull('deleted_at')->get()->toArray();
        return view('Employee/list', ['employee_all' => $employee_all, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }
    public function getEmployeeListData()
    {
        $model = $this->get_all_employee();
        return response()->json($model);
    }
    public function get_all_employee()
    {
        $models = Employee::with('department', 'designation')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        $datas = array();
        foreach ($models as $model) {
            $departmentModel = $model->department;
            $designationModel = $model->designation;


            $id = $model->id;
            $name = $model->first_name . " " . $model->middle_name . " " . $model->last_name;
            $profileImage = $model->profile_image;
            $email = $model->email;
            $sapId = $model->sap_id;
            $mobile = $model->mobile;
            $designationName = $designationModel->name;
            $departmentName = $departmentModel->name;
            $is_active = $model->is_active;
            $itsDepend = false;



            $runningProjects = $this->ProjectController->getRunningProjectsByEmpId($id);
            Log::info('get running Projects for empId' . $id . " " . json_encode($runningProjects));
            $runningWorkflow = $this->workflowController->getWorkflowApproverByEmpId($id);
            Log::info('get running Workflow for empId' . $id . " " . json_encode($runningWorkflow));
            if (count($runningProjects) || count($runningWorkflow)) {
                $itsDepend = true;
            }

            $response = ['itsDepend' => $itsDepend, 'id' => $id, 'name' => $name, 'profileImage' => $profileImage, 'email' => $email, 'sapId' => $sapId, 'mobile' => $mobile, 'designationName' => $designationName, 'departmentName' => $departmentName, 'is_active' => $is_active];

            Log::info('getemployee response for empId' . $id . " " . json_encode($response));
            array_push($datas, $response);
        }

        $employees = DB::table('employees as e')
            ->select('e.*', 'd.id as department_id', 'd.name as department_name', 'de.id as designation_id', 'de.name as designation_name', 'e.is_active as employee_status')
            ->join('departments as d', 'd.id', '=', 'e.department_id')
            ->join('designations as de', 'de.id', '=', 'e.designation_id')
            ->whereNull('e.deleted_at')


            ->get();
        return  $datas;
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
        $model->whereNull('employees.deleted_at');
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
    public function store1(Request $request)
    {

        if ($request->id == "") {
            $check_email = Employee::where('email', $request->email)->whereNull('employees.deleted_at')->pluck('id')->first();
        } else {
            $check_email = null;
        }

        if ($request->id == "") {
            $check_mobile = Employee::where('mobile', $request->mobile)->whereNull('employees.deleted_at')->pluck('id')->first();
        } else {
            $check_mobile = null;
        }

        if ($request->id == "") {
            $check_sap = Employee::where('sap_id', $request->sap_id)->whereNull('employees.deleted_at')->pluck('id')->first();
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
                    return redirect('employees')->with('error', "SAP-ID already exists.");
                }
            } else {
                return redirect('employees')->with('error', "Mobile already exists.");
            }
        } else {
            return redirect('employees')->with('error', "Email already exists.");
        }
    }

    public function destroy($id)
    {

        $checkChildData = ProjectEmployee::where('employee_id', $id)->first();

        $checkChildData1 = WorkflowLevelDetail::where('employee_id', $id)->first();

        // $checkChildData2 = User::where('emp_id', $id)->first();

        if ($checkChildData || $checkChildData1) {
            $data = [
                "message" => "Failed",
                "data" => "Reference Data exists, Can’t delete."
            ];
        } else {
            $model = Employee::where("id", $id)->delete();
            $data = [
                "message" => "Success",
                "data" => "Employee Deleted Successfully."
            ];
        }

        return response()->json($data);


        $employee_update = Employee::where("id", $id)->delete();
        echo json_encode($employee_update);
    }

    public function changeActiveStatus(Request $request)
    {
        $id =  $request->id;
        $checkChildData = ProjectEmployee::where('employee_id', $id)->first();
        $checkChildData1 = WorkflowLevelDetail::where('employee_id', $id)->first();

        if ($checkChildData || $checkChildData1) {
            $data = [
                "message" => "Failed",
                "data" => "Reference Data exists, Can’t delete."
            ];
        } else {

            $employee_update = Employee::where("id", $request->id)->update(["is_active" => $request->status]);
            //$models  = Employee::with('department','designation')->whereNull('deleted_at')->get()->toArray();
            $data = [
                "message" => "Success",
                "data" => "Employee Status Changed Successfully."
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function bulkUploadCreate()
    {
        $departments = Department::get();
        $designation = Designation::get();
        $model = array();
        return view('Employee/bulkUpload', ['model' => $model, 'departments' => $departments, 'designation' => $designation]);
    }
    public function bulkUploadStore(Request $request)
    {

        $employeeImport = new EmployeesImport;
        Log::info("Employee Import" . json_encode($employeeImport));
        $sheet = Excel::import($employeeImport, $request->file('bulkupload')->store('temp'));
        $rows = $employeeImport->data;
        $errors = array();
        foreach ($rows as $key => $row) {
            $rowNo = $key + 1;
            $validationResult = $this->EmployeeValidations($row);

            if ($validationResult) {
                for ($i = 0; $i < count($validationResult); $i++) {
                    $error = "Row:" . $rowNo . "  Error:" . $validationResult[$i];
                    array_push($errors, $error);
                }
            }

            $employeeModel = Employee::where('sap_id', $row['sap_id'])->first();

            if ($employeeModel) {

                $baseValidation = $this->basicValidation($rowNo, $row, $employeeModel->id);
                if (count($baseValidation) || $validationResult) {
                    for ($j = 0; $j < count($baseValidation); $j++) {
                        array_push($errors, $baseValidation[$j]);
                    }
                } else {
                    $model = $employeeModel;
                    $convertModel = $this->employeeModel($model, $row);
                }
            } else {
                $baseValidation = $this->basicValidation($rowNo, $row);
                if (count($baseValidation) || $validationResult) {
                    for ($j = 0; $j < count($baseValidation); $j++) {
                        array_push($errors, $baseValidation[$j]);
                    }
                } else {

                    $model = new Employee();
                    $convertModel = $this->employeeModel($model, $row);
                }
            }
        }


        if (count($errors)) {
            return response()->json(['result' => "failed", 'data' => $errors]);
        } else {
            return response()->json(['result' => "success", 'data' => '']);
        }
    }
    public function basicValidation($rowNo, $row, $id = null)
    {
        $errors = array();
        $mobileCheck = $this->mobileCheckFunction($row['mobile'], $id);
        if ($mobileCheck) {
            $error = "Row:" . $rowNo . "  Error: Mobile Number already Exist!(" . $row['mobile'] . ").";
            array_push($errors, $error);
        }
        $emailCheck = $this->emailCheckFunction($row['email'], $id);
        if ($emailCheck) {
            $error = "Row:" . $rowNo . " Error: Email already Exist!(" . $row['email'] . ").";
            array_push($errors, $error);
        }
        $department = $this->departemntCheckFunction($row['department']);

        if (!$department) {
            $departmentModel = new Department();
            $departmentModel->name = $row['department'];
            $departmentModel->save();
        }
        $designation = $this->designationCheckFunction($row['designation']);
        if (!$designation) {
            $designationModel = new Designation();
            $designationModel->name = $row['designation'];
            $designationModel->save();
        }
        return $errors;
    }

    public function mobileCheckFunction($mobileNo, $id = null)
    {
        return Employee::where('mobile', $mobileNo)->where('id', '!=', $id)->first();
    }
    public function emailCheckFunction($email, $id = null)
    {
        return Employee::where('email', $email)->where('id', '!=', $id)->first();
    }
    public function sapIdCheckFunction($sapId, $id = null)
    {
        return Employee::where('sap_id', $sapId)->where('id', '!=', $id)->first();
    }
    public function departemntCheckFunction($name)
    {
        return Department::where('name', $name)->first();
    }
    public function designationCheckFunction($name)
    {
        return Designation::where('name', $name)->first();
    }
    public function employeeModel($model, $datas)
    {
        $datas  = (object)$datas;
        $deptId = Department::where('name', $datas->department)->first()->id;
        $descId = Designation::where('name', $datas->designation)->first()->id;

        $model->first_name = $datas->first_name;
        $model->middle_name = $datas->middle_name;
        $model->last_name = $datas->last_name;
        $model->email = $datas->email;
        $model->mobile = $datas->mobile;
        $model->department_id = $deptId;
        $model->designation_id = $descId;
        $model->sap_id = $datas->sap_id;
        $model->save();

        return $model;
    }

    public function EmployeeValidations($datas)
    {
        //$datas  = (object)$datas;

        $validator = Validator::make($datas, [
            'first_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|size:10',
            'department' => 'required',
            'designation' => 'required',
            'sap_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        } else {
            return null;
        }
    }

    public function reAssignEmployee(Request $request)
    {
        $empId = $request->id;
        $actionType = $request->actionType;

        $projectWiseEmployees = $this->ProjectController->getRunningProjectsByEmpId($empId);
        Log::info("projectWiseEmployees   By empId " . $empId . " Data " . json_encode($projectWiseEmployees));
        $responseDatas = array();
        $wfIds = array();
        foreach ($projectWiseEmployees as $projectWiseEmployee) {
            $type = "";
            $projectName = $projectWiseEmployee->project_name;
            $wfId = $projectWiseEmployee->workflow_id;
            array_push($wfIds, $wfId);
            $wfData = $this->workflowController->getWorkflowDetailById($wfId);
            $wfName = $wfData->workflow_name;
            $level = "";
            if ($empId == $projectWiseEmployee->initiator_id) {
                $response = ['type' => "Initiator", 'wfName' => $wfName, 'projectName' => $projectName, 'level' => ""];
                array_push($responseDatas, $response);
            }

            $wfModels = $this->workflowController->getWorkflowApproverByEmpIdAndWfId($wfId, $empId);
            Log::info("Wf With projects  By empId " . $empId . " Data " . json_encode($wfModels));
            foreach ($wfModels as $wfModel) {
                $wfLevelModel = $wfModel->workflowLevel;
                $workflowModel = $wfModel->workFlow;

                $type = "Approver";

                $wfName = $workflowModel->workflow_name;
                $level =  $wfLevelModel->levels;

                $response = ['type' => $type, 'wfName' => $wfName, 'projectName' => $projectName, 'level' => $level];

                array_push($responseDatas, $response);
            }
        }

        if ($wfIds) {
            $wfIds = array_unique($wfIds);
        }

        $getWfModels = $this->workflowController->getAllWorkflowByEmpIdWithoutProjectWf($empId, $wfIds);
        Log::info("Wf Without projects  By empId " . $empId . " Data " . json_encode($getWfModels));
        foreach ($getWfModels as $getWfModel) {

            $wfLevelModel = $getWfModel->workflowLevel;
            $wfModel = $getWfModel->workFlow;

            $type = "Approver";
            $projectName = "";
            $wfName = $wfModel->workflow_name;
            $level =  $wfLevelModel->levels;

            $response = ['type' => $type, 'wfName' => $wfName, 'projectName' => $projectName, 'level' => $level];
            array_push($responseDatas, $response);
        }

        $employeeModels = Employee::where('is_active', 1)
            ->where('id', '!=', $empId)
            ->whereNull('deleted_at')
            ->get();
        $employeeDatas = array();
        foreach ($employeeModels as $employeeModel) {
            $id = $employeeModel->id;
            $name = $employeeModel->first_name . " " . $employeeModel->middle_name . " " . $employeeModel->last_name;

            $res = ['id' => $id, 'name' => $name];
            array_push($employeeDatas, $res);
        }

        return view('Employee.reAssignEmployee', compact('empId', 'actionType', 'responseDatas', 'employeeDatas'));
    }

    public function reAssignEmployeeUpdate(Request $request)
    {
        $oldEmployeeId = $request->empId;
        $NewEmployeeId = $request->reAssignEmployeeId;
        $actionType = $request->actionType;
        $toAllowType = $request->toAllowType;

        $workflowModels = $this->workflowController->getAllWorkflowByEmpIdWithoutProjectWf($oldEmployeeId);
        Log::info("Get Workflows By Emp id " . json_encode($workflowModels));

        foreach ($workflowModels as $key => $value) {
            $wfDetailModel = WorkflowLevelDetail::findOrFail($value->id);

            if ($wfDetailModel) {
                $wfDetailModel->employee_id = $NewEmployeeId;
                $wfDetailModel->save();
            }

            $type = "Approver";
            $wfId = $value->workflow_id;
            $workflowLevel = $value->workflowLevel;
            $level = $workflowLevel->levels;
            $projectId = null;

            $reAssignedEmployeeModel = $this->convertToModelReAssignedEmployee($wfId, $projectId, $level, $type, $oldEmployeeId, $NewEmployeeId);
        }
        $projectWiseEmployees = $this->ProjectController->getRunningProjectsEmployeesByEmpId($oldEmployeeId);
        Log::info("Get projectWiseEmployees  By Emp id " . json_encode($projectWiseEmployees));
        $projectIdArrays = [];
        foreach ($projectWiseEmployees as $projectWiseEmployee) {
            $projectModel = $this->ProjectController->getProjectDetailsByPrimaryId($projectWiseEmployee->project_id);
            $wfId = "";
            $level = $projectWiseEmployee->level;
            $projectId = $projectWiseEmployee->project_id;
            array_push($projectIdArrays, $projectId);
            if ($projectModel) {
                $wfId = $projectModel->workflow_id;
                if ($projectModel->initiator_id == $oldEmployeeId) {
                    $projectModel->initiator_id = $oldEmployeeId;
                    $projectModel->save();
                }
            }

            if ($projectWiseEmployee->type == 1) {
                $type = "Initiator";

                $updateProjectEmployee =  $this->updateProjectEmployees($projectWiseEmployee->id, $NewEmployeeId);
                $updateProjectApprover =  $this->updateProjectApprovers($projectWiseEmployee->project_id, $projectWiseEmployee->level, $NewEmployeeId);
            }
            if ($projectWiseEmployee->type == 2) {
                $type = "Approver";
                if ($toAllowType == 2) {
                    $updateProjectEmployee =  $this->updateProjectEmployees($projectWiseEmployee->id, $NewEmployeeId);
                    $updateProjectApprover =  $this->updateProjectApprovers($projectWiseEmployee->project_id, $projectWiseEmployee->level, $NewEmployeeId);
                } else {
                    $documentStatus = $this->ProjectController->getProjectslevelStatusByProjectIdAndLevelId($projectWiseEmployee->project_id, $projectWiseEmployee->level);
                    if ($documentStatus) {
                        if ($documentStatus->status != 4) {

                            $updateProjectEmployee =  $this->updateProjectEmployees($projectWiseEmployee->id, $NewEmployeeId);
                            $updateProjectApprover =  $this->updateProjectApprovers($projectWiseEmployee->project_id, $projectWiseEmployee->level, $NewEmployeeId);
                        }
                    }
                }
            }
            $reAssignedEmployeeModel = $this->convertToModelReAssignedEmployee($wfId, $projectId, $level, $type, $oldEmployeeId, $NewEmployeeId);
        }
        $sendEmail = $this->reAssignEmployeeSendmail($NewEmployeeId, $projectIdArrays);
        $employeeModel = Employee::findOrFail($oldEmployeeId);
        Log::info("Get employeeModel  By Emp id " . json_encode($employeeModel));
        if ($employeeModel) {
            if ($actionType == "delete") {
                $employeeModel->delete();
            }
            if ($actionType == "status") {
                $employeeModel->is_active = 0;
                $employeeModel->save();
            }
        }
        Log::info("Get projectIdArrays " . json_encode($projectIdArrays));
        Log::info("Get NewEmployeeId " . json_encode($NewEmployeeId));
       
        return redirect()->route('employees.index')->with('success', 'Re-Assigned Employee has been updating.');
    }

    public function reAssignEmployeeSendmail($employeeId, $allProjectIds)
    {
        Log::info("Get reAssignEmployeeSendmail allProjectIds" . json_encode($allProjectIds));
        Log::info("Get reAssignEmployeeSendmail employeeId" . json_encode($employeeId));
        $projectIds = array_unique($allProjectIds);
        $email = $this->email->reAssignEmployeeEmail($employeeId,$projectIds);
        return $email;
    }

    public function updateProjectEmployees($id, $newEmployeeId)
    {
        $model = ProjectEmployee::findOrFail($id);
        if ($model) {
            $model->employee_id = $newEmployeeId;
            $model->save();
        }
        return $model;
    }
    public function updateProjectApprovers($projectId, $level, $newEmployeeId)
    {
        $levelIdModel = ProjectLevels::where('project_id', $projectId)
            ->where('project_level', $level)
            ->first();
        if ($levelIdModel) {
            $model = ProjectApprover::where('project_id', $projectId)->where('project_level_id', $levelIdModel->id)->first();

            if ($model) {
                $model->approver_id = $newEmployeeId;
                $model->save();
            }
        }
        return true;
    }
    public function convertToModelReAssignedEmployee($wfId, $projectId = null, $level, $type, $oldEmployeeId, $NewEmployeeId)
    {
        $model = new ReAssignedEmployee();
        $model->workflow_id = $wfId;
        $model->project_id = $projectId;
        $model->level = $level;
        $model->type = $type;
        $model->old_employee_id = $oldEmployeeId;
        $model->new_employee_id = $NewEmployeeId;
        $model->assigned_date = now();
        $model->save();
        return $model;
    }

    public function getEmployeeAllDataByEmpid($empId)
    {
        return Employee::select(DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS employee_name"))->where('id', $empId)->first();
    }
}
