<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/login/{role_id}', 'API\UserController@login');
Route::post('/login_customer', 'API\UserController@login_customer');
Route::post('/login_emp', 'API\UserController@login_emp');
Route::post('/login_admin', 'API\UserController@login_admin');
Route::post('/get_current_user', 'API\UserController@getCurrentUser');
Route::get('/logout', 'API\UserController@logout');

Route::get('/projects', 'API\ProjectController@index');
Route::get('/project_dates', 'API\ProjectController@project_dates');
Route::get('/project_status', 'API\ProjectController@project_status');

Route::get('/tasks/{project_id}', 'API\TaskController@index');
Route::get('/tasks_list', 'API\TaskController@index');
Route::get('/task_images', 'API\TaskController@task_images');

Route::get('/cms', 'API\CmsController@index');

Route::post('/log_attendence', 'API\AttendanceController@store');
Route::post('/log_out', 'API\AttendanceController@edit');
Route::post('/attendence', 'API\AttendanceController@index');
Route::get('/clients', 'API\ClientController@index');

Route::get('/employees', 'API\UserController@employees');

Route::get('/tickets', 'API\SupportTicketController@index');
Route::post('/client_tickets', 'API\SupportTicketController@client_tickets');
Route::post('/ticket/add', 'API\SupportTicketController@store');

Route::post('/work/add', 'API\TaskDiscussionController@store');
Route::post('/work/details', 'API\TaskDiscussionController@work_details');
Route::post('/project/work_details', 'API\TaskDiscussionController@project_work_details');
