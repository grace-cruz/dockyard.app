<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $table = 'folders';

    public $timestamps = true;


    public function users()
    {
        return $this->belongsToMany('App\User');
    }


    public function files()
    {
        return $this->hasMany('App\File');
    }


    public function downloads()
    {
        return $this->hasMany('App\Download');
    }

    public function deleteAllFiles()
    {
      foreach($this->files as $file)
      {
        $path=storage_path().'/app/'.$file->path;
        unlink($path);
        $file->delete();
      }
    }
}
