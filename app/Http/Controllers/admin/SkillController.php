<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Skill;
use Auth;
use Yajra\Datatables\Datatables;
use Session;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $skill=Skill::all();
        // return view('backend.pages.skill')->withskill($skill);
        return view('backend.pages.skill');

    }

    public function getSkills(Datatables $datatables)
    {
      $skill=Skill::orderBy('id','desc');

      return Datatables::of($skill)->addColumn('edit', function($skill){
                                        return  '<button class="btn btn-sm btn-info editskill" data-skill="'.$skill->skill.'" data-percentage="'.$skill->percentage.'" data-id="'.$skill->id.'">Edit</button>';                                                                      })
                                    ->addColumn('delete',function($skill){
                                          return '<button class="btn btn-sm btn-danger deleteskill" data-id="'.$skill->id.'"  data-token="{{ csrf_token() }}">Delete</button>';

                                        })
                                    ->rawColumns(['edit','delete'])
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
          'skill' => 'required|min:2',
          'percentage' => 'required|integer'


      ],[
        'skill.required'=>'skill field is required most',
        'skill.min'=>'Enter more than 2'
      ]);

      $skill = new Skill();
      $skill -> skill = $request -> skill;
      $skill -> percentage = $request -> percentage;
      $skill -> save();
      $output="inserted";

     // toastr()->success('Data has been saved successfully!');
      return compact('output');

      //return redirect()->route('skill.index', $skill->id);
      // return redirect('admin/skill');
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
      $skill=Skill::find($id);
    $skill->skill = $request->skill;
    $skill->percentage = $request->percentage;
    $skill->save();
    $output="updated";
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
      // return "hello";
      // die;
        $skill = Skill::find($id);
      $skill -> delete();

        $output='deleted';
        return compact('output');

    }
}
