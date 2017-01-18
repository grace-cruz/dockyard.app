<?php

namespace App;

use App\Hashable;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
use Hashable;
  
  protected $table='downloads';

  public $timestamps = false;

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function folder()
  {
    return $this->belongsTo('App\Folder');
  }

  public function file()
  {
    return $this->belongsTo('App\File');
  }
}
