<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::post('/addUser', 'UserController@addUser');
Route::get('/userList', 'UserController@showUserList');
Route::post('/addPermission', 'UserController@addPermission');
Route::get('/permissionList', 'UserController@showPermissionList');
Route::post('/addRole', 'UserController@addRole');
Route::get('/roleList', 'UserController@showRoleList');
Route::get('/allPermissions', 'UserController@showaAllPermissions');
Route::get('/groupList', 'UserController@showGroupList');
Route::post('/addGroup', 'UserController@addGroup');
Route::get('/allGroup', 'UserController@showAllGroup');