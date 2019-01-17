<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


// Route::group(['prefix'=>'admin'],function(){
  Route::prefix('admin')->middleware('role:superadministrator|administrator|editor|subscriber')->group(function(){

Route::resource('skill','admin\SkillController');
Route::get('getskill','admin\SkillController@getSkills')->name('get.skills');
//Route::post('deleteskill/{id}','admin\SkillController@destroy');
Route::resource('portfolio','admin\PortfolioController');
Route::resource('project','admin\ProjectController');
Route::get('getproject','admin\ProjectController@getProjects')->name('get.projects');
Route::get('project/view/{id}','admin\ProjectController@show');
Route::post('image-submit','admin\ProjectController@imagestore');

Route::resource('adminlist','admin\AdminController');
Route::get('getadmin','admin\AdminController@getAdmins')->name('get.admins');

Route::resource('permission','admin\PermissionController');

Route::resource('message','admin\MessageController');
Route::resource('blog','admin\BlogController');
Route::resource('dashboard','admin\IndexController');

});
