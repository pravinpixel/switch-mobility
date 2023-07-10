<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Role::orderBy('id', 'DESC')->get();
        $permissions = Permission::get();


        return view('Settings/Role/list', ['models' => $models, 'permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Settings.Role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function roleNameValidation(Request $request)
    {

        $model = Role::where('name', $request->name)->where('id', '!=', $request->id)->get();
        //   dd($model);
        $response = (count($model)) ? false : true;
        return response()->json(['response' => $response]);
    }
    public function store(Request $request)
    {

        Log::info('RoleController->Store:-Inside ' . json_encode($request->all()));
        $input = $request->all();
        $ispermission = (isset($request->permission)) ? true : false;

        if (!$ispermission) {
            $input['permission'] = ['dashboard-view'];
        }

        $input['guard_name'] = 'web';
        $permissionitems = array();
        $permissionsDatas = $input['permission'];


        Log::info('ProjectController->Store:-Inside $permissionsDatas' . json_encode($permissionsDatas));
        foreach ($permissionsDatas as $permissionsData) {

            Log::info('ProjectController->Store:-Inside $permissionsData' . json_encode($permissionsData));
            $permissionitems[] = Permission::where('name', $permissionsData)->first()->id;
            Log::info('ProjectController->Store:-Inside permissionitems[]' . json_encode($permissionitems));

            // $values = array('permission_id' =>  $permissionitemsId, 'role_id' => $role->id);
            // DB::table('role_has_permissions')->insert($values);
        }

        $permissionitems1 = implode(",", $permissionitems);


        $permissionsNew = explode(",", $permissionitems1);


        unset($input['_token']);
        $id = isset($request->id) ? $request->id : '';

        if ($id) {
            $role = Role::find($id);
        } else {

            $role = new Role();
        }

        $role->name = $input['name'];
        $role->guard_name = $input['guard_name'];
        $role->authority_type = $input['authority_type'];
        $role->save();

        if (isset($permissionsDatas)) {

            $role->syncPermissions($permissionsNew);
        } else {

            //If no role is selected remove exisiting permissions associated to a role
            $p_all = Permission::all(); //Get all permissions
            foreach ($p_all as $p) {
                $role->revokePermissionTo($p); //Remove all permissions associated with role
            }
        }
        if ($role) {
            return redirect('roles')->with('success', "Roles Stored successfully.");
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
        $roles = Role::where('id', $id)->first();
        return view('Settings.Role.edit', ['roles' => $roles]);
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

        $role = Role::find($id);

        $users = $role->users;
    

        if (count($users)) {
            return response()->json([
                "status" => "failed",
                'message' => 'You cannot delete a role that has permissions assigned!'
            ]);
            
        } else {
            $department_update = Role::where("id", $id)->delete();
            return response()->json([
                "status" => "success",
                'message' => 'Deleted Success!'
            ]);
        }
        // $department_update = Role::where("id", $id)->delete();
        // echo json_encode($department_update);
    }
    public function search(Request $request)
    {
        $searchData = $request->searchData;
        $model = Role::Where('roles.name', 'LIKE', '%' . $searchData . '%')->get();
        return response()->json($model);
    }
}
