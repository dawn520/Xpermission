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


//Route::auth();
Route::post('/login', 'Auth\LoginController@postLogin');
Route::get('/logout', 'Auth\LoginController@logout');

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
