<?php
namespace API\Controllers;

use \API\Core\Authenticator;
use \API\Core\Validator;
use DB\Models\JobSeeker;
use DB\Models\Recruiter;
use \DB\Models\User;

class UserController extends Authenticator
{
  public function Login($email, $password)
  {
    $validator = new Validator();
    $validator->ValidateEmail($email, ['required']);
    $validator->ValidateText($password, ['required']);
    
    if($validator->HasErrors())
    {
      return $this->response($validator->GetErrors(), false);
    }
    
    $user = $this->Attempt($email, $password);
    
    if(is_string($user))
    {
      return $this->response($user, false);
    }

    $token = $this->Authenticate($user);

    return $this->response($token);
  }

  public function Register($first_name, $last_name, $email, $password, $is_recruiter)
  {
    $validator = new Validator();
    $validator->ValidateText($first_name, 'First Name', ['required', 'min:3', 'max:50']);
    $validator->ValidateText($last_name,  'Last Name',['required', 'min:3', 'max:50']);
    $validator->ValidateEmail($email, ['required']);
    $validator->ValidateText($password, 'Password', ['required']);

    if($validator->HasErrors())
    {
      return $this->response($validator->GetErrors(), false);
    }
    // check if email is registerd before
    if(User::checkEmailExist($email, $is_recruiter)) {
      return $this->response("Email already registered", false);
    }
    
    // add record
    $user = boolval($is_recruiter) ? new Recruiter($first_name, $last_name, $email, $password, true) 
                          : new JobSeeker($first_name, $last_name, $email, $password, true);
    // return response
    return $this->response("Registered Successfully");
  }

  public function Logout()
  {
    $this->Unauthenticate();
    $this->response("logged out successfully");
  }
}