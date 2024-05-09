<?php

namespace DB\Models;

// require("db/Database.php");
use DB\Database as Database;
use utils\Utils as Utils;
use UnexpectedValueException;

abstract class User
{
    protected $tableName;
    protected $userId;
    protected $createdAt;
    protected $updatedAt;
    protected $isRecruiter;

    protected function __construct(
        protected string $ImagePath,
        protected string $Fname,
        protected string $Lname,
        protected string $email,
        protected string $pswd,
        protected string $phone,
        protected string $industry,
        protected string $title,
        protected string $currentCompany,
        protected string $about
    ) {
        $this->validateProperties();
    }

    protected function validateProperties(): void
    {
        Utils::validateProperty("ImagePath", $this->ImagePath, 256, 1); // if no value insert '-'
        Utils::validateProperty("Fname", $this->Fname, 50, 2);
        Utils::validateProperty("Lname", $this->Lname, 50, 2);
        Utils::validateProperty("email", $this->email, 50, 2);
        Utils::validateProperty("pswd", $this->pswd, 256, 6);
        Utils::validateProperty("phone", $this->phone, 25, 7);
        Utils::validateProperty("industry", $this->industry, 50, 5);
        Utils::validateProperty("title", $this->title, 50, 5);
        Utils::validateProperty("currentCompany", $this->currentCompany, 50, 0);
        Utils::validateProperty("about", $this->about, 1024 * 1024, 0);
    }


    protected function createNewRecord()
    {
        $this->userId = Utils::generateUUID();
        $this->createdAt = date("Y-m-d H:i:s");
        $this->updatedAt = $this->createdAt;

        Database::Query("
        INSERT INTO
        $this->tableName(id, image, first_name, last_name, email, phone, password,
              industry, current_company, title, about, is_recruiter, created_at, updated_at)
        VALUES('$this->userId', '$this->ImagePath', '$this->Fname', '$this->Lname', '$this->email', '$this->pswd',
               '$this->phone', '$this->industry', '$this->currentCompany', '$this->title', '$this->about', '$this->isRecruiter',
               '$this->createdAt', '$this->updatedAt');
        ");
    }



    public static function authenticateUser(string $email, string $password): ?string
    {
        $result = Database::Query("SELECT * FROM users WHERE email = '$email' LIMIT 1")->fetch();

        if (empty($result)) {
            return null;
        }

        if ($password === $result['password']) {
            return [
              "userId" => $result['id'],
              "isRecuirter" => $result['is_recruiter']
            ];
        }

        return null;
    }

    public function updateImagePath(string $newImagePath): void
    {
        Utils::validateProperty("newImagePath", $newImagePath, 256, 1); // if no value insert '-'
        $this->updatedAt = date("Y-m-d H:i:s");
        Database::Query("
            UPDATE $this->tableName SET image = '$newImagePath', updated_at = '$this->updatedAt' WHERE id = '$this->userId';
        ");
        $this->ImagePath = $newImagePath;
    }

    public function updatePassword(string $newPswd): void
    {
        Utils::validateProperty("newPswd", $newPswd, 256, 6);
        $this->updatedAt = date("Y-m-d H:i:s");
        Database::Query("
            UPDATE $this->tableName SET image = '$newPswd', updated_at = '$this->updatedAt' WHERE id = '$this->userId';
        ");
        $this->pswd = $newPswd;
    }

    public function updateData(
        string $Fname = null,
        string $Lname = null,
        string $email = null,
        string $phone = null,
        string $industry = null,
        string $title = null,
        string $currentCompany = null,
        string $about = null,
    ) {
        $Fname = $Fname ?? $this->Fname;
        $Lname = $Lname ?? $this->Lname;
        $email = $email ?? $this->email;
        $phone = $phone ?? $this->phone;
        $industry = $industry ?? $this->industry;
        $title = $title ?? $this->title;
        $currentCompany = $currentCompany ?? $this->currentCompany;
        $about = $about ?? $this->about;

        $this->validateProperties();

        $this->updatedAt = date("Y-m-d H:i:s");
        Database::Query("
        UPDATE $this->tableName SET first_name = '$Fname', last_name = '$Lname',
        email = '$email', phone = '$phone', industry = '$industry', title = '$title',
        current_company = '$currentCompany', about = '$about', updated_at = '$this->updatedAt'
        WHERE id = '$this->userId';
        ");

        $this->Fname = $Fname;
        $this->Lname = $Lname;
        $this->email = $email;
        $this->phone = $phone;
        $this->industry = $industry;
        $this->title = $title;
        $this->currentCompany = $currentCompany;
        $this->about = $about;
    }

    public function getData(): array
    {
        return [
            "userId" => $this->userId,
            "imagePath" => $this->ImagePath,
            "Fame" => $this->Fname,
            "Lname" => $this->Lname,
            "email" => $this->email,
            "password" => $this->pswd,
            "phone" => $this->phone,
            "industry" => $this->industry,
            "title" => $this->title,
            "about" => $this->about,
            "currentCompany" => $this->currentCompany,
            "createdAt" => $this->createdAt,
            "updatedAt" => $this->updatedAt
          ];
    }

    public function delete(): void
    {
        // also will delete any record on any table related with this record
        Database::Query("DELETE FROM '$this->tableName' WHERE id = '$this->userId'");
    }
}
