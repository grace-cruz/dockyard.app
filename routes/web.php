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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware'=>['admin']],function() {
  Route::get('folders/{folder_id}/edit','FolderController@editFolder');
  Route::post('folders/{folder_id}/edit','FolderController@updateFolder');
  Route::get('folders/{folder_id}/delete','FolderController@deleteFolder');
  Route::get('folders/new','FolderController@newFolder');
  Route::post('folders/new','FolderController@addFolder');

  Route::get('folders/{folder_id}/upload','FileController@fileUploader');
  Route::post('folders/{folder_id}/upload','FileController@uploadFile');
  Route::get('folders/{folder_id}/delete/all','FileController@deleteAll');
  Route::get('folders/{folder_id}/delete/{file_id}','FileController@deleteFile');

  Route::get('/users','UserController@getUsers');
  Route::get('/users/new','UserController@newUser');
  Route::post('/users/new','UserController@addUser');
  Route::get('/users/{user_id}','UserController@editUser');
  Route::post('/users/{user_id}','UserController@updateUser');
  Route::get('/users/{user_id}/delete','UserController@deleteUser');


});


// Index routes
Route::group(['middleware' => ['auth']],function() {
  Route::get('/','FolderController@showFolders');
  Route::get('/folders','FolderController@showFolders');

  Route::get('/profile','UserController@getProfile');
  Route::post('/profile','UserController@updateProfile');
  Route::get('/logout','\App\Http\Controllers\Auth\LoginController@logout');
});

//Folder Routes
Route::group(['middleware'=>['folder']],function(){
  Route::get('/folders/{folder_id}','FolderController@showFolder');
  Route::get('/folders/{folder_id}/download/zip','FileController@downloadZip');
  Route::get('/folders/{folder_id}/download/{file_id}','FileController@downloadFile');
});

//

// Route::get('/home', 'HomeController@index');
