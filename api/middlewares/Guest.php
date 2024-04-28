<?php
namespace API\Middlewares;

use \utils\Utils;

class Guest extends \API\Core\Middleware
{
  public function Verify()
  {
    return $_SESSION['user'] ?? true;
  }

  public function OnApprove()
  {
    // nothing
  }

  public function OnReject()
  {
    Utils::abort();
  }
}