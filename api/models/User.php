<?php
namespace Models;

require base_path('Core\Model.php');

class User extends \Core\Model
{
  protected $table = "users";
  
  public function getall() {
    return $this->SelectAll();
  }
  
}