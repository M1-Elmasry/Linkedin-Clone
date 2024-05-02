<?php

namespace DB\Models;

// require("db/Database.php");
use DB\Database as Database;
use UnexpectedValueException;

class User
{
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
        $this->validateProperty("ImagePath", $ImagePath, 256, 1); // if no value insert '-'
        $this->validateProperty("Fname", $Fname, 50, 2);
        $this->validateProperty("Lname", $Lname, 50, 2);
        $this->validateProperty("email", $email, 50, 2);
        $this->validateProperty("pswd", $pswd, 256, 6);
        $this->validateProperty("phone", $phone, 25, 7);
        $this->validateProperty("industry", $industry, 50, 5);
        $this->validateProperty("title", $title, 50, 5);
        $this->validateProperty("currentCompany", $currentCompany, 50, 0);
        $this->validateProperty("about", $about, 1024 * 1024, 0);
    }

    protected function validateProperty(string $propName, string $propValue, int $maxLength, int $minLength)
    {
        if (!(!empty($propValue) && strlen($propValue) <= $maxLength && strlen($propValue) >= $minLength)) {
            throw new UnexpectedValueException("$propName cannot be null and more than $maxLength char or less than $minLength");
        }
    }


    public final static function authenticateUser(string $email, string $password): ?array
    {
        $result = Database::Query("SELECT * FROM users WHERE email = '$email' LIMIT 1")->fetch();

        if (empty($result)) {
            return null;
        }

        if ($password === $result['password']) {
            return [
                    'id' => $result['id'],
                    'is_recruiter' => $result['is_recruiter']
                    ];
        }

        return null;
    }

    // wrapper method for the child classes (Recruiter, JobSeeker)
    protected function upImgPath(string $newImagePath, string $tableName, string $userId): string
    {
        $this->validateProperty("newImagePath", $newImagePath, 256, 1); // if no value insert '-'
        $updateDate = date("Y-m-d H:i:s");
        Database::Query("
            UPDATE $tableName SET image = '$newImagePath', updated_at = '$updateDate' WHERE id = '$userId';
        ");
        return $updateDate;
    }

    // wrapper method for the child classes (Recruiter, JobSeeker)
    protected function upPswd(string $newPswd, string $tableName, string $userId): string
    {
        $this->validateProperty("newPswd", $newPswd, 256, 6);
        $updateDate = date("Y-m-d H:i:s");
        Database::Query("
            UPDATE $tableName SET image = '$newPswd', updated_at = '$updateDate' WHERE id = '$userId';
        ");
        return $updateDate;
    }

    // wrapper method for the child classes (Recruiter, JobSeeker)
    protected function upData(
        string $Fname,
        string $Lname,
        string $email,
        string $phone,
        string $industry,
        string $title,
        string $currentCompany,
        string $about,
        string $tableName,
        string $userId
    ) {
        $this->validateProperty("Fname", $Fname, 50, 2);
        $this->validateProperty("Lname", $Lname, 50, 2);
        $this->validateProperty("email", $email, 50, 2);
        $this->validateProperty("phone", $phone, 25, 7);
        $this->validateProperty("industry", $industry, 50, 5);
        $this->validateProperty("title", $title, 50, 5);
        $this->validateProperty("currentCompany", $currentCompany, 50, 0);
        $this->validateProperty("about", $about, 1024 * 1024, 0);

        $updateDate = date("Y-m-d H:i:s");
        Database::Query("
        UPDATE $tableName SET first_name = '$Fname', last_name = '$Lname',
        email = '$email', phone = '$phone', industry = '$industry', title = '$title',
        current_company = '$currentCompany', about = '$about', updated_at = '$updateDate'
        WHERE id = '$userId';
        ");
        return $updateDate;
    }

    // wrapper method for the child classes (Recruiter, JobSeeker)
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
