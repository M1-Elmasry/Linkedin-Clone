<?php
namespace Controllers;

use \Models\User;
use \Core\Authenticator;

class UserController extends Authenticator
{
  public function Login($email, $password)
  {
    $user = $this->Attempt($email, $password);
  }
}