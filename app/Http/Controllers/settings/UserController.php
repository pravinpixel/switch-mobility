<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Email\EmailController;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $EmailController;
    public function __construct(EmailController $EmailController)
    {
        $this->EmailController = $EmailController;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('Settings/User/list');
    }
    public function userIndex()
    {

        $models = User::leftjoin('employees', 'employees.id', '=', 'users.emp_id')
            ->whereNull('employees.deleted_at')->whereNull('is_super_admin')->orderBy('users.id', 'DESC')->get();


        return response()->json($models);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('name', 'id')->get();
        $employees = Employee::doesntHave('user')->where('is_active', 1)->get();
        $userDetails = array();
        return view('Settings.User.userCreate', ['roles' => $roles, 'employees' => $employees, 'userDetails' => $userDetails]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        // dd($request->all());
        $empModel = Employee::find($request->employeeId);

        if ($request->id) {
            $user = User::find($request->id);
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
        } else {
            $user = new User();
            $user->name = $empModel->first_name . "" . $empModel->middle_name . " " . $empModel->last_name;
            $user->username = $empModel->sap_id;
            $user->email = $empModel->email;
            $user->is_admin = 1;
            $user->emp_id = $empModel->id;
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if ($request->password && $request->id) {

            $sendMail = $this->EmailController->userPasswordChange($user->emp_id, $request->password);
        }

        if (!$request->id) {

            $sendMail = $this->EmailController->userAddMail($user->emp_id, $request->password);

        }


        $roleModel = Role::where('id', $request->roles)->first();
        if ($request->id) {
            if (isset($roleModel)) {
                $user->roles()->sync($roleModel); //If one or more role is selected associate user to roles
            } else {
                $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
            }
        } else {
            if (isset($roleModel)) {
                $user->assignRole($roleModel);
            }
        }
        if ($user) {
            return redirect('users')->with('success', "User Stored successfully.");
        } else {
            return redirect()->back()->withErrors(['error' => ['Insert Error']]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $roles = Role::select('name', 'id')->get();
        $userDetails = User::select('employees.id as empId', 'employees.mobile', 'employees.email', 'users.emp_id')
            ->leftjoin('employees', 'employees.id', '=', 'users.emp_id')
            ->where('users.id', $id)->first();

        if(!$userDetails) {
            abort(404);
        }

        $employees = Employee::where('id', $userDetails->emp_id)->first();
        $userModel = User::with('roles', 'employee')->where('id', $id)->first();

        $roleId = $userModel->roles->pluck("id")->first();

        return view('Settings.User.edit', ['roles' => $roles, 'employees' => $employees, 'userDetails' => $userDetails, 'userModel' => $userModel, 'roleId' => $roleId]);
    }
    public function userEdit(Request $request)
    {

        $id = $request->id;

        $roles = Role::select('name', 'id')->get();
        $userDetails = User::select('employees.id as empId', 'employees.mobile', 'employees.email', 'users.id as userId', DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name, ' (', sap_id ,')') AS fullName"))
            ->leftjoin('employees', 'employees.id', '=', 'users.emp_id')
            ->where('users.emp_id', $id)->first();

        $employees = Employee::where('id', $userDetails->emp_id)->get();

        $userModel = User::with('roles', 'employee')->where('id',  $userDetails->userId)->first();

        $roleId = $userModel->roles->pluck("id")->first();

        return view('Settings.User.edit', ['roles' => $roles, 'employees' => $employees, 'userDetails' => $userDetails, 'userModel' => $userModel, 'roleId' => $roleId]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $users = User::where("emp_id", $id)->delete();
        return response()->json($users);
    }
    public function search(Request $request)
    {
        $searchData = $request->searchData;
        $model = User::Where('users.name', 'LIKE', '%' . $searchData . '%')->whereNull('is_super_admin')->whereNull('deleted_at')->get();
        return response()->json($model);
    }
}
