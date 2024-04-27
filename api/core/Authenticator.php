<?php
namespace Core;
use \Models\User;
class Authenticator
{
  protected function Attempt($email, $password) {

  }
  
  protected function Authenticate($user)
  {
    $_SESSION['user'] = [

    ];
    session_regenerate_id(true);
  }

  protected function Unauthenticate($user) {

  }
}