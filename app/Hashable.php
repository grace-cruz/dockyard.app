<?php
namespace App;
use Vinkla\Hashids\Facades\Hashids;
trait Hashable
{
  public function findOrFailByHashid($hashid)
  {
    $ids = Hashids::decode($hashid);
    $id = array_pop($ids);
    return $this->findOrFail($id);
  }
  public function getHashid()
  {
    if ($this->id) {
    return Hashids::encode($this->id);
    }
    return null;
  }
}
