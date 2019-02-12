<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Education;
use Session;
use Yajra\Datatables\Datatables;


class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function __construct()
    {
        $this->middleware('role:superadministrator')->except('index','getEducations');
    }
    public function index()
    {
        return view('backend.pages.education.education');
    }

  public function getEducations(Datatables $datatables)
    {
      $education=Education::orderBy('id','desc');

      return Datatables::of($education)
                                    ->addColumn('action',function($education){
                                          return '<button class="btn btn-sm btn-info editeducation" data-institution="'.$education->institution.'" data-board="'.$education->board.'" data-id="'.$education->id.'" data-level="'.$education->level.'" data-start="'.$education->start.'" data-end="'.$education->end.'" data-percentage="'.$education->percentage.'" data-grade="'.$education->grade.'" data-other="'.$education->other.'">Edit</button>
                                            <button class="btn btn-sm btn-danger deleteeducation" data-id="'.$education->id.'"  data-token="{{ csrf_token() }}" >Delete</button>
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
        $education=new Education;
        $education->institution=$request->institution;
        $education->board=$request->board;
        $education->level=$request->level;
        $education->start=$request->start;
        $education->end=$request->end;
        $education->percentage=$request->percentage;
        $education->grade=$request->grade;
        $education->other=$request->other;
        $education->save();
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
        $education=Education::find($id);
        $education->institution=$request->institution;
        $education->board=$request->board;
        $education->level=$request->level;
        $education->start=$request->start;
        $education->end=$request->end;
        $education->percentage=$request->percentage;
        $education->grade=$request->grade;
        $education->other=$request->other;
        $education->save();
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
      $education = Education::find($id);
      $education -> delete();

        $output='deleted';
        return compact('output');        
    }
}
