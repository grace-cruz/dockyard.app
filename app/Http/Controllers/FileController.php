<?php

namespace App\Http\Controllers;

use App\File;
use App\Folder;
use App\Http\Requests\UploadFile;
use App\Download;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function fileUploader(Request $request,$folder_id)
    {
      $user = $request->user();
      $folder=(new Folder)->findOrFail($folder_id);

      return view('files.uploader',[
        'user'=> $user,
        'folder' => $folder,
        'form_url' =>"/folders/$folder_id/upload",
      ]);
    }

    public function uploadFile(UploadFile $request,$folder_id)
    {
      $user=$request->user();
      $folder=(new Folder)->findOrFail($folder_id);

      //TODO
      $timestamps = (new \DateTime)->format('YmdHisu');
      $upload = $request->file('upload');
      $path = $upload->storeAs('uploads',"$folder_id-$timestamps-$user->id");

      $file=new File;
      $file->path = $path;
      $file->name = $upload->getClientOriginalName();
      $file->folder_id = $folder_id;
      $file->save();

      $request->session()->flash('status','Files uploaded succesfully');
      return redirect("/folders/$folder_id");
    }

    public function downloadFile(Request $request,$folder_id,$file_id)
    {
      $user=$request->user();
      $folder=(new Folder)->findOrFail($folder_id);
      $file=(new File)->findOrFail($file_id);

      $download=new Download;
      $download->user_id = $user->id;
      $download->file_id= $file->id;
      $download->timestamp= (new \DateTime)->format('Y-m-d H:i:s');
      $download->save();

      $path=storage_path().'/app/'.$file->path;

      return response()->download($path,$file->name);

    }

    public function downloadZip(Request $request,$folder_id)
    {
      $user=$request->user();
      $folder=(new Folder)->findOrFail($folder_id);
      //$file=(new File)->findOrFail($file_id);

      $download=new Download;
      $download->user_id = $user->id;
      $download->folder_id= $folder->id;
      $download->timestamp= (new \DateTime)->format('Y-m-d H:i:s');
      $download->save();

      //Code for ZIP Download
      $zipPath = storage_path().'/app/uploads/'.$folder_id.'-'.(new \DateTime)->format('YmdHisu').'-'.$user->id.'.zip';
      $zip=new \ZipArchive();
      $zip->open($zipPath,\ZIPARCHIVE::CREATE);
      foreach($folder->files as $file)
      {
        $path = storage_path().'/app/'.$file->path;
        $zip->addfile($path,$file->name);

      }
      $zip->close();

      return response()->download($zipPath,"$folder->name.zip");

    }


    public function  deleteFile(Request $request,$file_id)
    {
      $file = (new File)->findOrFail($file_id);

      $path=storage_path().'/app/'.$file->path;
      unlink($path);
      $file->delete();

      $request->session()->flash('status','File deleted succesfully');
      return redirect("/folders/$folder_id");

    }

    public function  deleteAll(Request $request,$folder_id)
    {
      $folder = (new Folder)->findOrFail($folder_id);
      $folder->deleteAllFiles();


      $request->session()->flash('status','All files deleted succesfully');
      return redirect("/folders/$folder_id");

    }
}
