<?php

namespace DB\Models;

use UnexpectedValueException;

abstract class User
{
    protected string $Fname;
    protected string $Lname;
    protected string $email;
    protected string $pswd;
    protected string $phone;
    protected string $industry;
    protected string $title;
    protected string $currentCompany;
    protected string $about;
    protected $createdAt;
    protected $updatedAt;

    public function __construct(
        string $Fname,
        string $Lname,
        string $email,
        string $pswd,
        string $phone,
        string $industry,
        string $title,
        string $currentCompany,
        string $about
    ) {
        $this->setFname($Fname);
        $this->setLname($Lname);
        $this->setEmail($email);
        $this->setPass($pswd);
        $this->setPhone($phone);
        $this->setIndustry($industry);
        $this->setTitle($title);
        $this->setCurrentCompany($currentCompany);
        $this->setAbout($about);
    }



    public function setFname($name): void
    {
        if (!empty($name) && strlen($name) <= 50) {
            $this->Fname = $name;
        } else {
            throw new UnexpectedValueException('$name cannot be empty and more than 50 char');
        }
    }

    public function setLname($name): void
    {
        if (!empty($name) && strlen($name) <= 50) {
            $this->Lname = $name;
        } else {
            throw new UnexpectedValueException('$name cannot be empty and more than 50 char');
        }
    }

    public function setEmail($email): void
    {
        if (!empty($email) && strlen($email) <= 100) {
            $this->email = $email;
        } else {
            throw new UnexpectedValueException('$email cannot be empty and more than 100 char');
        }
    }

    public function setPass($pass): void
    {
        if (!empty($pass) && strlen($pass) <= 256 && strlen($pass) >= 8) {
            $this->pswd = $pass;
        } else {
            throw new UnexpectedValueException('$password cannot be empty and more than 256 chars or less than 8 chars');
        }
    }

    public function setPhone($phone): void
    {
        if (!empty($phone) && strlen($phone) <= 25) {
            $this->phone = $phone;
        } else {
            throw new UnexpectedValueException('$phone cannot be empty and more than 25 chars');
        }
    }

    public function setIndustry($industry): void
    {
        if (!empty($industry) && strlen($industry) <= 50) {
            $this->industry = $industry;
        } else {
            throw new UnexpectedValueException('$industry cannot be empty and more than 50 chars');
        }
    }

    public function setTitle(string $title): void
    {
        if (!empty($title) && strlen($title) <= 100) {
            $this->title = $title;
        } else {
            throw new UnexpectedValueException('$title cannot be empty and more than 100 chars');
        }
    }

    public function setCurrentCompany(string $company): void
    {
        if (strlen($company) <= 100) {
            $this->currentCompany = $company;
        } else {
            throw new UnexpectedValueException('$currentCompany cannot be more than 50 chars');
        }
    }

    public function setAbout(string $about): void
    {
        if (!empty($about)) {
            $this->about = $about;
        } else {
            throw new UnexpectedValueException('$about cannot be empty');
        }
    }

    protected function getData(): array
    {
        return [
          "Fame" => $this->Fname,
          "Lname" => $this->Lname,
          "email" => $this->email,
          "password" => $this->pswd,
          "phone" => $this->phone,
          "industry" => $this->industry,
          "title" => $this->title,
          "about" => $this->about,
          "currentCompany" => $this->currentCompany
        ];
    }
}
