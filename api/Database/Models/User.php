<?php
namespace Database\Models;

use \Database\Model;

class User extends Model
{
  protected $table = "users";
  
  public function getall() {
    return $this->SelectAll();
  }
  
}