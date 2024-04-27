<?php
namespace Core;

interface Middleware
{
  public function Verify();
  public function OnApprove();
  public function OnReject();
}