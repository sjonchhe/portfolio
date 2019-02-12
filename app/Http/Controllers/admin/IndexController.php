<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\Education;
use App\Model\Experience;
use App\Model\Portfolio;
use App\Model\Project;
use App\Model\Skill;
use App\Model\Testimonial;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skillc=Skill::count();
        $projectc=Project::count();
        $userc=User::count();
        $rolec=Role::count();
        $blogc=Blog::count();
        $testimonialc=Testimonial::count();
        $educationc=Education::count();
        $experiencec=Experience::count();
        $projects=Project::latest('id')->limit(5)->get();
        return view('backend.pages.dashboard')->withskillcount($skillc)
                                              ->withprojectcount($projectc)
                                              ->withusercount($userc)
                                              ->withrolecount($rolec)
                                              ->withprojects($projects)
                                              ->withblogcount($blogc)
                                              ->withEducationcount($educationc)
                                              ->withexperiencecount($experiencec)
                                              ->withtestimonialcount($testimonialc);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function generateCv()
    {

    }

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
        //
    }
}
