<?php
namespace API\Core;

class Validator
{
  private $errors = [];

  public function ValidateEmail()
  {

  }

  public function HasErrors()
  {
    return count($this->errors) > 0;
  }
  public function GetErrors()
  {
    return $this->errors;
  }
}