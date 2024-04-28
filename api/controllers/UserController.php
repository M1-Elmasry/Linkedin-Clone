<?php
namespace API\Controllers;

use \API\Core\Authenticator;

class UserController extends Authenticator
{
  public function Login($email, $password)
  {
    //$user = $this->Attempt($email, $password);
    echo "User Login";
  }

  public function Register()
  {

  }
}