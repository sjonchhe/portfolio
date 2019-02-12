<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Experience;
use Session;
use Yajra\Datatables\Datatables;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function __construct()
    {
        $this->middleware('role:superadministrator')->except('index','getExperiences');
    }
    public function index()
    {
        return view('backend.pages.experience.experience');
    }

public function getExperiences(Datatables $datatables)
    {
      $experience=Experience::orderBy('id','desc');

      return Datatables::of($experience)
                                    ->addColumn('action',function($experience){
                                          return '<button class="btn btn-sm btn-info editexperience" data-organization="'.$experience->organization.'" data-designation="'.$experience->designation.'" data-id="'.$experience->id.'" data-start="'.$experience->start.'" data-end="'.$experience->end.'" data-about="'.$experience->about.'" data-other="'.$experience->other.'">Edit</button>
                                            <button class="btn btn-sm btn-danger deleteexperience" data-id="'.$experience->id.'"  data-token="{{ csrf_token() }}" >Delete</button>
                                          ';

                                        })
                                    ->rawColumns(['action'])
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

        ]);
        $experience=new Experience;
        $experience->organization=$request->organization;
        $experience->designation=$request->designation;
        $experience->start=$request->start;
        $experience->end=$request->end;
        $experience->about=$request->about;
        $experience->other=$request->other;
        $experience->save();
        $output='inserted';
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
          $this->validate($request,[

        ]);
        $experience=Experience::find($id);
        $experience->organization=$request->organization;
        $experience->designation=$request->designation;
        $experience->start=$request->start;
        $experience->end=$request->end;
        $experience->about=$request->about;
        $experience->other=$request->other;
        $experience->save();
        $output='updated';
        return compact('output');   
     }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $experience = Experience::find($id);
      $experience -> delete();

        $output='deleted';
        return compact('output');       }
}
