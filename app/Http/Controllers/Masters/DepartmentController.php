<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Email\EmailController;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;
use \App\Mail\SendMail;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $emailController;
    public function __construct(EmailController $emailController)
    {
        $this->emailController = $emailController;
    }
    public function index()
    {
        $departments = Department::orderBy('id', 'desc')->get()->toArray();
        return view('Departments/list', ['departments' => $departments]);
    }
    public function create()
    {
        $model = array();
        return view('Departments/DepartmentDetail', compact('model'));
    }
    public function edit($id)
    {

        $model = Department::findOrFail($id);
        return view('Departments/DepartmentDetail', compact('model'));
    }
    public function departmentValidation(Request $request)
    {
        $model = Department::where('name', $request->name)->where('id', '!=', $request->id)->whereNull('deleted_at')->first();

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
        //         $details = [
        //             'title' => 'Title: Mail from Real Programmer',
        //             'body' => 'Body: This is for testing email using smtp'
        //         ];
        //         $ccMail = "smartdhana20@gmail.com";
        //         $mail = Mail::to('dhanaraj7927@gmail.com') ->cc($ccMail)->send(new SendMail("New Project assigned to Initiator",$details));


        // dd("well");

       
        $input = $request->all();
        if ($request->id) {
            $model = Department::findOrFail($request->id);
            $msg = "Updated";
        } else {
            $msg = "stored";
            $model = new Department();
        }
        $model->name = $request->name;
        $model->description = $request->description;
        $model->save();

        if ($model) {
            return redirect('department')->with('success', "Department " . $msg . " successfully.");
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

    public function deptSearch(Request $request)
    {

        $searchData = $request->searchData;
        $model = Department::Where('departments.name', 'LIKE', '%' . $searchData . '%')->whereNull('departments.deleted_at')->get();
        return response()->json($model);
    }
    public function departmentEdit(Request $request)
    {

        $id = $request->id;
        $model = Department::findOrFail($id);

        return view('Departments/DepartmentDetail', compact('model'));
    }
}
