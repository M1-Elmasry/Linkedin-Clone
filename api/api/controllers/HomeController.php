<?php
namespace API\Controllers;

use \Database\Models\User;

class HomeController 
{
  public function Index()
  {
    $user = new User;
    
    print_r($user->Find(2));
  }
  public function Test($id, $data) {
    echo $id . " and " . $data;
  }
}