<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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


        return view('settings/Role/list', ['models' => $models, 'permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
      
        $input['guard_name'] = 'web';

        $permissionitems = array();
        $permissionsDatas = $input['permission'];
       

        foreach ($permissionsDatas as $permissionsData) {
           
            $permissionitems[] = Permission::where('name', $permissionsData)->first()->id;

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
       
       $role->name =$input['name'];
       $role->guard_name =$input['guard_name'];
       $role->authority_type =$input['authority_type'];
       $role->save();
      
        if (isset($permissionsDatas)) {
          
               $role->syncPermissions($permissionsNew); 
              
             //If one or more role is selected associate user to roles
            } else {
               //If no role is selected remove exisiting permissions associated to a role
               $p_all = Permission::all(); //Get all permissions
               foreach ($p_all as $p) {
                  $role->revokePermissionTo($p); //Remove all permissions associated with role
               }
            }

          
        if ($id) {

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
        //
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
        $department_update = Role::where("id", $id)->update(["delete_flag" => 0]);
        echo json_encode($department_update);
    }
}
