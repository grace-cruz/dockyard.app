<?php

namespace App;

use App\Hashable;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
  use Hashable;
  
    protected $table='files';

    public $timestamps= true;

    public function folder()
    {
      return $this->belongsTo('App\Folder');
    }

    public function downloads()
    {
      return $this->hasMany('App\Download');
    }
}
