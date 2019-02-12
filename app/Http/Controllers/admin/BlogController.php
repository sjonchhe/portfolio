<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\User;
use Auth;
use File;
use Illuminate\Http\Request;
use Image;
use Session;
use Yajra\Datatables\Datatables;



class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function __construct()
    {
        $this->middleware('role:superadministrator')->except('index','getBlogs');
    }
    public function index()
    {
        return view('backend.pages.blog.blog');
    }

    public function getBlogs(Datatables $datatables)
    {
        $blogs=Blog::all();
        return Datatables::of($blogs)
                                    ->addColumn('title',function($blogs){
                                        return '<a href="'.$blogs->id.'" class="link">'.$blogs->title.' <badge class="badge badge-info">View</badge></a>';
                                    })
                                    ->addColumn('status',function($blogs){
                                       
                                        if($blogs->status=='0')
                                        {
                                            return '<badge class="badge badge-danger p-1">Hidden</badge>';    
                                        }
                                        else
                                        {
                                            return '<badge class="badge badge-success p-1">Shown</badge>';
                                        }
                                        
                                    })
                                    ->addColumn('addedby',function($blogs){
                                        return $blogs->user->name;
                                    })
                                    ->addColumn('delete',function($blogs){
                                        return '<button class="btn btn-sm btn-danger deleteblog" data-id="'.$blogs->id.'">Delete</button>';
                                        })
                                    ->addColumn('views',function($blogs){
                                        return '<badge class="badge badge-secondary">'.$blogs->views.'</badge>';
                                    })
                                    ->rawColumns(['title','addedby','status','delete','views'])
                                    ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.blog.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
        ));

        
        $blog=new Blog;
        $blog-> title=$request-> title;
        $blog-> blog=$request-> description;
        $blog-> addedby=Auth::User()->id;
        $blog-> url=$request->url;
        if($request->hasfile('image'))
        {
            $image=$request->file('image');
            $originalname=preg_replace('/\..+$/', '', $image->getClientOriginalName());
            $filename=$originalname.time().'.'.$image->getClientOriginalExtension();
            $location=public_path('uploads/blogs/'.$filename);
            Image::make($image)->resize(800,400)->save($location);
            $blog->image=$filename;
        }
        $blog->status=$request->status;
        $blog->views="0";
        $blog->save();
        return back();


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
        return view('backend.pages.blog.edit');
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
        $blog=Blog::find($id);
        $image=$blog->image;
        $location=public_path('uploads/blogs/'.$image);
        if(File::exists($location))
        {
            $delete=File::delete($location);
            $blog->delete();
            $output="deleted";
        }
        return compact('output');

    }
}
