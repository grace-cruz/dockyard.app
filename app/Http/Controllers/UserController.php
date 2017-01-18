<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UpdateProfile;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\AddUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getProfile(Request $request)
    {
      $user=$request->user();

      return view('users.profile',[
        'user'=> $user,
      ]);
    }

    public function updateProfile(UpdateProfile $request)
    {
      $user = $request->user();
      $user->name = $request->name;
      $user->email = $request->email;

      if(!empty($request->password)) $user->password= bcrypt($request->password);
      $user->save();

      $request->session()->flash('status','Profile edited successfully');
      return redirect('/profile');

    }

    public function getUsers(Request $request)
    {
      $users = (new User)->all();

      return view('users.list',[
        'users'=>$users
      ]);

    }


    public function editUser(Request $request,$user_id)
    {
      $user = (new User)->findOrFailByHashid($user_id);
      return view('users.editor',[
        'user' =>$user,
        'title' =>'Edit User',
        'logged_in_user' =>$user->id === $request->user()->id,
        'form_url'=>"/users/$user_id",
        'delete_url' =>"users/$user_id/delete",

      ]);
    }

    public function updateUser(UpdateUser $request,$user_id)
    {
      $user = (new User)->findOrFailByHashid($user_id);

      $user->name = $request->name;
      $user->email = $request->email;
      if(!empty($request->password)) $user->password= bcrypt($request->password);
      $user->admin=isset($request->admin) && !empty($request->admin) ? true : false;
      $user->save();

      $request->session()->flash('status','User edited successfully');
      return redirect("/users/$user_id");
    }

    public function deleteUser(Request $request, $user_id)
    {
      $user = (new User)->findOrFailByHashid($user_id);
      $user->delete();

      $request->session()->flash('status','User deleted successfully');
      return redirect("/users");
    }

    public function newUser(){
      return view('users.editor',[
        'user' =>new User,
        'title' =>'Add User',
        'form_url' => "/users/new",
      ]);
    }

    public function addUser(Request $request)
    {
      $user= new User;
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->admin=isset($request->admin) && !empty($request->admin) ? true : false;
      $user->save();

      $request->session()->flash('status','User added successfully');
      return redirect('/users/' . $user->getHashid());
    }

}
