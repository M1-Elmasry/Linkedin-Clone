<?php
namespace API\Core;

use \DB\Models\User;

class Authenticator extends Controller
{
  protected function Attempt($email, $password) {
    $user = User::authenticateUser($email, $password);
    return $user;
  }

  protected function Authenticate($user)
  {
    $_SESSION['userId'] = $user['userId'];
    $_SESSION['isRecuirter'] = $user['isRecuirter'];

    session_regenerate_id(true);

    $token = 'user token';
    
    return $token;
  }

  protected function Unauthenticate()
  {
    session_unset();
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
  }

  public static function IsAuthenticated()
  {
    return isset($_SESSION['userId']) && !empty($_SESSION['userId']);
  }
}