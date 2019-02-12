<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\Testimonial;
use Illuminate\Http\Request;
use Session;
use Yajra\Datatables\Datatables;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function __construct()
    {
        $this->middleware('role:superadministrator')->except('index','getTestimonials');
    }
    public function index()
    {
        return view('backend.pages.testimonial.testimonial');
    }

    public function getTestimonials(Datatables $datatables)
    {
      $testimonial=Testimonial::orderBy('id','desc');

      return Datatables::of($testimonial) ->addColumn('status',function($blogs){
                                       
                                        if($blogs->status=='0')
                                        {
                                            return '<badge class="badge badge-danger p-1">Hidden</badge>';    
                                        }
                                        else
                                        {
                                            return '<badge class="badge badge-success p-1">Shown</badge>';
                                        }
                                        
                                    })                                                            
                                    ->addColumn('action',function($testimonial){
                                          return '<button class="btn btn-sm btn-info edittestimonial" data-name="'.$testimonial->name.'" data-about="'.$testimonial->about.'" data-description="'.$testimonial->description.'" data-status="'.$testimonial->status.'" data-id="'.$testimonial->id.'">Edit</button>
                                          <button class="btn btn-sm btn-danger deletetestimonial" data-id="'.$testimonial->id.'"  data-token="{{ csrf_token() }}">Delete</button>';

                                        })
                                    ->rawColumns(['action','status'])
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
       


      ],[
        'testimonial.required'=>'testimonial field is required most',
        'testimonial.min'=>'Enter more than 2'
      ]);

      $testimonial = new Testimonial();
      $testimonial -> name = $request -> name;
      $testimonial -> about = $request -> about;
      $testimonial -> description = $request -> description;
      $testimonial -> status ="1";


      $testimonial -> save();
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

      $testimonial = Testimonial::find($id);
      $testimonial -> name = $request -> name;
      $testimonial -> about = $request -> about;
      $testimonial -> description = $request -> description;
      $testimonial -> status =$request-> status;


      $testimonial -> save();
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
        $testimonial = Testimonial::find($id);
        $testimonial -> delete();

        $output='deleted';
        return compact('output');
    }
}
