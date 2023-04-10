<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = User::whereNull('is_super_admin')->orderBy('id', 'DESC')->get();
        $roles = Role::select('name', 'id')->get();     
        $employees = Employee::doesntHave('user')->get();
        return view('Settings/User/list', ['models' => $models, 'roles' => $roles, 'employees' => $employees]);
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
        $empModel = Employee::find($request->initiator_id);
        if ($request->id) {
            $user = User::find($request->id);
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
        } else {
            $user = new User();
            $user->name = $empModel->first_name;
            $user->username = $empModel->sap_id;
            $user->email = $empModel->email;
            $user->is_admin = 1;
            $user->emp_id = $empModel->id;
            $user->password = Hash::make($request->password);
        }
        $user->save();
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
        //
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
        $employees = Employee::where('id', $userDetails->emp_id)->get();
        $userModel = User::with('roles', 'employee')->where('id', $id)->first();

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
        $users = User::where("id", $id)->delete();
        echo json_encode($users);
    }
    public function search(Request $request)
    {
        $searchData = $request->searchData;
        $model = User::Where('users.name', 'LIKE', '%' . $searchData . '%')->whereNull('is_super_admin')->whereNull('deleted_at')->get();
        return response()->json($model);
    }
}
