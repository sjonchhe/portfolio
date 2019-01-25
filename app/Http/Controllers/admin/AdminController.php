<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class AdminController extends Controller
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
        //$users=User::all();
        // return view('backend.pages.adminlist')->withuser($users);
        $role=Role::all();
        return view('backend.manage.adminlist')->withrole($role);
    }

    public function getAdmins(Datatables $datatables)
    {
      $users=User::all();
      $role=Role::all();
 
      //$role_user=$users->roles->pluck('id','id');
      return Datatables::of($users)
                    ->addColumn('role',function($users){
                             $userid=$users->id;
                        $roleuser=DB::table('role_user')->where('user_id',$userid)->pluck('role_id');
                            $roletab=DB::table('roles')->where('id',$roleuser[0])->pluck('name');
                        return '<span class="badge badge-pill badge-light text-capitalize">'.$roletab[0].'</span>';
                       })
                    ->addColumn('delete',function($users){
                        return '<button class="btn btn-danger btn-sm deleteadmin" data-id="'.$users->id.'">Delete</button>';
                    })

               
                    ->rawColumns(['role','delete'])
                    ->make(true);
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
          'username'=> 'required',
          'email'=>'required',
          'password'=>'required',
        ]);
        $password=$request-> password;
        $user= new User();
      $user-> name=$request-> username;
      $user-> email=$request-> email;
      $user-> password=Hash::make($password);
      if($user->save())
      {
      $output="inserted";
    }
    else {
      $output="error";
    }
    $roleid=$request->role;
    $user->attachRole($roleid);
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
        $users=User::find($id);
        $users->delete();
        $output='deleted';
        return compact('output');
            }
}
