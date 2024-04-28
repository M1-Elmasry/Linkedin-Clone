<?php
namespace API\Core;

use \Database\Models\User;

class Authenticator extends Controller
{
  protected function Attempt($email, $password) {

  }

  protected function Authenticate($user)
  {
    $_SESSION['user'] = [
      'id' => $user['id']
    ];
    session_regenerate_id(true);
  }

  protected function Unauthenticate($user) {

  }
}