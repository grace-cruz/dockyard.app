<?php

namespace App\Http\Controllers;

use App\User;
use App\Folder;
use App\Http\Requests\AddFolder;
use App\Http\Requests\UpdateFolder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function showFolders(Request $request)
    {
      $user=$request->user();
      $folders=$user->admin ? (new Folder)->all() : $user->folders;

      return view('folders.list',[
        'user' => $user,
        'folders'=> $folders,
      ]);
    }


    public function showFolder(Request $request,$folder_id)
    {
      $user=$request->user();
      $folder= (new Folder)->findOrFail($folder_id);

      return view('folders.item',[
        'user' => $user,
        'folder'=> $folder,
      ]);
    }

    public function editFolder(Request $request, $folder_id)
    {
      $user=$request->user();
      $folder=(new Folder)->findOrFail($folder_id);

      //TODO
      $users = (new User)->where('admin',false)->get();

      return view('folders.editor',[
        'user' => $user,
        'users' => $users,
        'folder' => $folder,
        'title' =>'Edit Folder',
        'form_url' =>"/folders/$folder_id/edit",
        'delete_url' => "/folders/$folder_id/delete",
      ]);
    }


    public function updateFolder(updateFolder $request, $folder_id)
    {
      $folder=(new Folder)->findOrFail($folder_id);
      $folder->name = $request->name;
      $folder->save();

      //TODO
      $folder->users()->detach();
      $folder->users()->attach($request->users);

      $request->session()->flash('status','Folder edited successfully');
      return redirect("/folders/$folder_id/edit");
    }


    public function deleteFolder(Request $request, $folder_id)
    {
      $folder=(new Folder)->findOrFail($folder_id);
      $folder->deleteAllFiles();
      $folder->delete();


      $request->session()->flash('status','Folder deleted successfully');
      return redirect("/folders");
    }

    public function newFolder(Request $request)
    {
      $user=$request->user();

      //TODO
      $users = (new User)->where('admin',false)->get();

      return view('folders.editor',[
        'user' =>$user,
        'users' =>$users,
        'folder' =>new Folder,
        'title'=>'New Folder',
        'form_url'=>'/folders/new'
      ]);

    }

    public function addFolder(AddFolder $request)
    {
      $folder = new Folder;
      $folder->name = $request->name;
      $folder->save();

      //TODO
      $folder->users()->attach($request->users);

      $request->session()->flash('status','Folder added successfully');
      return redirect("/folders/$folder->id/edit");
    }
}
