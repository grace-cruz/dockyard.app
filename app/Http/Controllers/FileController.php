<?php

namespace App\Http\Controllers;

use App\File;
use App\Folder;
use App\Http\Requests\UploadFile;
use App\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;

class FileController extends Controller
{
    public function fileUploader(Request $request,$folder_id)
    {
      $user = $request->user();
      $folder = (new Folder)->findOrFailByHashid($folder_id);

      return view('files.uploader',[
        'user'=> $user,
        'folder' => $folder,
        'form_url' =>"/folders/$folder_id/upload",
      ]);
    }

public function uploadFile(Request $request, $folder_id)
{
  $user = $request->user();
  $ids = Hashids::decode($folder_id);
  $id = !empty($ids) ? $ids[0] : 0;
  $folder = (new Folder)->where('id', $id)->get()->first();
  $uploads = $request->file('uploads');
  $response = ['files' => []];
  foreach ($uploads as $upload) {
    $rules = array('upload' => 'required|file|mimes:pdf,docx,xlsx,ppt|max:30000');
    $validator = Validator::make(array('upload'=> $upload), $rules);
    $filename = $upload->getClientOriginalName();
    if (!$folder->exists()) {
      $response['files'][] = [
      'name' => $filename,
      'error' => 'Invalid folder'
      ];
    } elseif ($validator->passes()) {
      list($usec, $sec) = explode(" ", microtime());
      $timestamp = ((float)$usec + (float)$sec);
      $path = $upload->storeAs('uploads',"$folder->id-$timestamp-$user->id");
      $file=new File;
      $file->path = $path;
      $file->name = $filename;
      $file->folder_id = $folder->id;
      $file->save();
      $response['files'][] = [
      'name' => $filename
      ];
    } else {
      $response['files'][] = (object) [
      'name' => $filename,
      'error' => $validator->errors()->first()
      ];
    }
  }
  return response()->json($response);
}

    public function downloadFile(Request $request,$folder_id,$file_id)
    {
      $user=$request->user();
      $folder = (new Folder)->findOrFailByHashid($folder_id);
      $file = (new File)->findOrFailByHashid($file_id);

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
      $folder = (new Folder)->findOrFailByHashid($folder_id);
      //$file=(new File)->findOrFail($file_id);

      $download=new Download;
      $download->user_id = $user->id;
      $download->folder_id= $folder->id;
      $download->timestamp= (new \DateTime)->format('Y-m-d H:i:s');
      $download->save();

      //Code for ZIP Download
      $zipPath = storage_path().'/app/uploads/'.$folder->id.'-'.(new \DateTime)->format('YmdHisu').'-'.$user->id.'.zip';
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


    public function  deleteFile(Request $request,$folder_id,$file_id)
    {
      $file = (new File)->findOrFailByHashid($file_id);

      $path=storage_path().'/app/'.$file->path;
      unlink($path);
      $file->delete();

      $request->session()->flash('status','File deleted succesfully');
      return redirect("/folders/$folder_id");

    }

    public function  deleteAll(Request $request,$folder_id)
    {
      $folder = (new Folder)->findOrFailByHashid($folder_id);
      $folder->deleteAllFiles();


      $request->session()->flash('status','All files deleted succesfully');
      return redirect("/folders/$folder_id");

    }
}
