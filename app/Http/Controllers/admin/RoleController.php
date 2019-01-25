<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
    }
    public function index()
    {
        $permission=Permission::all();
        $role=Role::orderBy('id','desc')->get();
        return view('backend.manage.role')->withrole($role)->withpermission($permission);
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
        $this->validate($request,[

        ]);
        /*return $request->permission;
        dd;*/
        $role=new Role();
        $role->name=$request->name;
        $role->display_name=$request->display_name;
        $role->description=$request->description;
        $role->save();

        foreach($request->permission as $key=>$value)
        {
            $role->attachPermission($value);
        }
        $output="inserted";
        return compact('output');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::all();
        $role=Role::find($id);
        $role_permission = $role->permissions->pluck('id','id')->toArray();
        return view('backend.manage.editrole')->withrole($role)->withpermission($permission)->withroleperm($role_permission);
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

        $role=Role::find($id);
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        DB::table('permission_role')->where('role_id',$id)->delete();
        foreach($request->permission as $key=>$value)
        {
            $role->attachPermission($value);
        }
        $output="Updated";
        //return view('backend.manage.editrole');
        //notificationMsg('success','Successfully Updated!');
        return back()->withoutput($output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role=Role::find($id);
        $role->delete();
        $output="deleted";
        return compact('output');
    }
}
