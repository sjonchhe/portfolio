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

Auth::routes(['verify' => true]);


Route::get('/', 'HomeController@index')->name('home');
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');



// Route::group(['prefix'=>'admin'],function(){
  // Route::prefix('admin')->middleware('role:superadministrator|administrator|editor|subscriber')->group(function(){
Route::group(['middleware'=>'verified'],function(){
  Route::group( [
           'prefix'     => 'admin',
           // 'as'         => 'dashboard.',
           'namespace'  => 'admin',
           'middleware' => 'role:superadministrator|administrator|editor|subscriber'
       ], function () {

Route::resource('skill','SkillController');
Route::get('getskill','SkillController@getSkills')->name('get.skills');
//Route::post('deleteskill/{id}','SkillController@destroy');
Route::resource('portfolio','PortfolioController');
Route::resource('project','ProjectController');
Route::get('getproject','ProjectController@getProjects')->name('get.projects');
Route::get('project/view/{id}','ProjectController@show');
Route::post('image-submit','ProjectController@imagestore');
Route::post('singledelete','ProjectController@singledelete')->name('project.imagedelete');

Route::resource('adminlist','AdminController');
Route::get('getadmin','AdminController@getAdmins')->name('get.admins');

Route::resource('permission','PermissionController');
Route::resource('role','RoleController');

Route::resource('message','MessageController');
Route::resource('blog','BlogController');
Route::resource('dashboard','IndexController');

Route::post('sendmail','MailController@send');

});
});
