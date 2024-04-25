<?php
namespace Controllers;

class HomeController 
{
  public function Index()
  {
    $users = new \Models\User;

    print_r($users->SelectAll());
  }
}