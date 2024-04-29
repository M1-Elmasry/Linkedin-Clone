<?php

namespace DB\Models;

require('db/models/User.php');
require('db/Database.php');
require('utils/utils.php');
use DB\Models\User as User;
use DB\Database as Database;
use utils\Utils as Utils;
use UnexpectedValueException;

class Recruiter extends User
{
    private $id;
    private $ImagePath;

    public function __construct(
        string $imagePath,
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
        $this->id = Utils::generateUUID();
        $this->setImagePath($imagePath);

        parent::__construct(
            $Fname,
            $Lname,
            $email,
            $pswd,
            $phone,
            $industry,
            $title,
            $currentCompany,
            $about
        );

        $this->createdAt = date("Y-m-d H:i:s");
        $this->updatedAt = $this->createdAt;

        Database::Query("
        INSERT INTO
        recruiters(id, image, first_name, last_name, email, phone, password,
              industry, current_company, title, about, is_recruiter, created_at, updated_at)
        VALUES('$this->id', '$this->ImagePath', '$this->Fname', '$this->Lname', '$this->email', '$this->pswd',
               '$this->phone', '$this->industry', '$this->currentCompany', '$this->title', '$this->about', TRUE,
               '$this->createdAt', '$this->updatedAt');");

    }

    public function setImagePath($path): void
    {
        if (!empty($path) && strlen($path) <= 256) {
            $this->ImagePath = $path;
        } else {
            throw new UnexpectedValueException('$newPath cannot be empty and more than 256 char');
        }
    }

    public function getAllData(): array
    {
        return [
          "id" => $this->id,
          "imagePath" => $this->ImagePath,
          ...$this->getData()
        ];
    }
}
