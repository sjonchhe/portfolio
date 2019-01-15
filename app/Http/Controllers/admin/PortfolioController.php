<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Portfolio;
use Session;
use Image;
use File;
class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $portfolio=Portfolio::orderBy('id','desc')->first()->get();
        return view('backend.pages.portfolio',compact('portfolio'));
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
        //
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
      // echo "here";
      // die;

    $this->validate($request, array(
      'image'=>'mimes:jpeg,jpg,png ',
        'cv' =>'mimes:pdf'
    ));

    $portfolio=Portfolio::find($id);
    $portfolio->firstname= $request->firstname;
    $portfolio->middlename = $request->middlename;
    $portfolio->lastname= $request->lastname;
    $portfolio->email= $request->email;
    $portfolio->contact= $request->contact;
    $portfolio->dob= $request->dob;
    $portfolio->address= $request->address;
    $portfolio->about= $request->about;
    if($request->hasFile('image'))
    {
      //add the new photo
      $image=$request->file('image');
      $originalname=preg_replace('/\..+$/', '', $image->getClientOriginalName());

      $filename=$originalname.time().'.'.$image->getClientOriginalExtension();
      $location=public_path('uploads/profile/'.$filename);
      Image::make($image)->resize(500,500)->save($location);

      $oldfilename = $portfolio->image;
      $oldfilelocation=public_path('uploads/profile/'.$oldfilename);
      if(File::exists($oldfilelocation))
      {
        $delete = File::delete($oldfilelocation);
      }
      $portfolio->image=$filename;
    }
    if($request->hasFile('cv'))
    {
      $cv=$request->file('cv');
      $originalname=preg_replace('/\..+$/', '', $cv->getClientOriginalName());

      $cvfilename=$originalname.time().'.'.$cv->getClientOriginalExtension();
      $location=public_path('uploads/cv');

      $oldcvname = $portfolio->cv;
      $oldcvlocation=public_path('uploads/cv/'.$oldcvname);
      if(File::exists($oldcvlocation))
      {
        $delete = File::delete($oldcvlocation);
      }
      $cv->move($location,$cvfilename);
      $portfolio->cv=$cvfilename;
    }
    // dd($request->all());die;
    $portfolio->save();
  $output="updated";

  return compact('output');
    // Session::flash('updated', 'Profile has been successfully updated!');
    // return redirect('admin/portfolio');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
