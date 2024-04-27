<?php
namespace Middlewares;

use \Core\Middleware;

class Guest implements Middleware
{
  public function Verify()
  {
    return $_SESSION['user'] ?? true;
  }

  public function OnApprove()
  {
    echo 'middleware';
  }

  public function OnReject()
  {
    abort();
  }
}