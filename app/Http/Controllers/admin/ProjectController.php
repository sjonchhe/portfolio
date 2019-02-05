<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Project;
use Yajra\Datatables\Datatables;
use Image;
use Session;
use File;
use Storage;
use App\Model\Photo;
use Mail;
use App\Mail\newProject; 

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.pages.project');
    }

    public function getProjects(Datatables $datatables)
    {
      $project=Project::orderBy('id','desc');
      return Datatables::of($project)
      ->addColumn('link',function($project){
        return '<a href="http://'.$project->link1.'" target="_blank">'.$project->link1.'</a>';
      })
      ->addColumn('view',function($project){
        return '<a href="/admin/project/view/'.$project->id.'"><button class="btn btn-sm btn-primary viewproject">View</button></a>';
      })
    ->addColumn('delete',function($project){
        return '<button class="btn btn-sm btn-danger deleteproject" data-id="'.$project->id.'" onsubmit="return confirm(Are you sure you want to delete??)">Delete</button>';
      })
      ->addColumn('views',function($project){
        return '<span class="badge badge-pill badge-light">'.$project->views.'</span>';
      })
      ->rawColumns(['link','view','views','delete'])
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

  $this->validate($request, array (
    'title' => 'required | max:255',
    'client' => 'required',
    'date' => 'required',
    'description' => 'required',
    'link1' => 'required',
    'image1'=> 'sometimes | image '
  ));

  $project= new Project();
  $project->title = $request->title;
  $project->client = $request->client;
  $project->date = $request->date;
  $project->description = $request->description;
  $project->link1 = $request->link1;
  $project->link2 = $request->link2;
  $project->contribution = $request->contribution;
  $project->keyword = $request->keyword;
  $project->status = $request->status;
  $project->views = "1";

  if($request->hasFile('image'))
  {
    $image = $request->file('image');
    $originalname=preg_replace('/\..+$/', '', $image->getClientOriginalName());
    $filename = $originalname.time() . '.' . $image->getClientOriginalExtension();
    $location = public_path('uploads/projects/' . $filename  );
    Image::make($image)->resize(640,390)->save($location);

    $project->image = $filename;
    // echo $img_tmp=Input::file('image1');
    // die;
  }
  else
  {
    $project->image= "image.jpg";
  }


  $project->save();

    $data=[
      'title' => $request->title,
      'client' => $request->client,
      'description' => $request->description,
      'contribution' => $request->contribution,
      'status' => $request->status,
 
    ];
    Mail::send(new newProject($data));

  // Session::flash('success','New Project Successfully added');
  // return redirect('admin/projects');
  $output="inserted";
  return compact('output');

    }

    public function imagestore(Request $request)
    {
      $imagename=[];

    $imageName=$request->file->getClientOriginalName();
    $request->file->move(public_path('uploads/projectimages/'),$imageName);
    $response= response()->json(['uploaded'=>'/uploads/projectimages/'.$imageName]);
    $imagename[]=$imageName;

    // return $imagename;
    // die;
    foreach($imagename as $iname)
    {

      $images= new Photo();
      $images->project_id=$request->projectid;
      $images->image=$iname;

      $images->save();
      return $response;

    }
    return back()->with('success','photo uploaded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project=Project::find($id);
        $photo=Photo::where('project_id',$id)->get();
        return view('backend.pages.projects.projectedit')->withproject($project)
                                                        ->withPhoto($photo);
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
      $this->validate($request, array(
          'image1'=>'sometimes | image'

        ));
        $project=Project::find($id);
        $project->title = $request->title;
        $project->client = $request->client;
        $project->date = $request->date;
        $project->description = $request->description;
        $project->link1 = $request->link1;
        $project->link2 = $request->link2;
        $project->contribution = $request->contribution;
        $project->keyword = $request->keyword;
        $project->status = $request->status;
        if($request->hasFile('image'))
        {
          //add the new photo
          $image=$request->file('image');
          $originalname=preg_replace('/\..+$/', '', $image->getClientOriginalName());
          $filename=$originalname.time().'.'.$image->getClientOriginalExtension();
          $location=public_path('uploads/projects/'.$filename);
          Image::make($image)->resize(640,390)->save($location);

          //Delete the old image
          $oldfilename = $project->image;
          $oldfilelocation=public_path('uploads/projects/'.$oldfilename);
          if(File::exists($oldfilelocation))
          {
            $delete = File::delete($oldfilelocation);
          }

          //update the database
          $project->image=$filename;


        }
        $project->save();
        Session::flash('success','Successfully Updated!');
        return back();
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project=Project::find($id);  
        $image=$project->image;
        $location=public_path('uploads/projects/'.$image);
        if(File::exists($location))
        {
          $delete=File::delete($location);
        
          if($delete)
          {
            $projectimages=Photo::where('project_id',$id)->get();
            foreach($projectimages as $images)
            {
              $locations=public_path('uploads/projectimages/'.$images->image);
              $deleteimages=File::delete($locations);
              $images->delete();

            }
          }
          $deleted=$project->delete();
          $output='deleted';
      
        }
        else
        {
          $output='missing';
        }


          return compact('output'); 
        
       
    }

    public function singledelete(request $request)
    {
   
      if(isset($request->image))
      {
        foreach($request->image as $image)
        {
          $image=Photo::find($image);
          $imagename=$image->image;
          $image_path=public_path('uploads/projectimages/'.$imagename);
          if(File::exists($image_path))
          {
            $deleteimg=File::delete($image_path);
            if($deleteimg)
            {
              $image->delete();
              $status='Image removed successfully';
            }
          }
          else
          {
            $status='File doesnt exist';
          }

        }

      }
      else{
          $status= "Please choose some file to delete";

      }
    return back()->with('success',$status);
      
    }

}
