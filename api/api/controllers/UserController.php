<?php
namespace API\Controllers;

use \API\Core\Authenticator;
use \Database\Models\User;

class UserController extends Authenticator
{
  public function Login($email, $password)
  {
    //$user = $this->Attempt($email, $password);
  }

  public function Register()
  {

  }
}