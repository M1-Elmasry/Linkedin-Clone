<?php

namespace DB\Models;

require('db/models/User.php');
require('db/Database.php');
require('utils/utils.php');
use DB\Models\User as User;
use DB\Database as Database;
use utils\Utils as Utils;

class JobSeeker extends User
{
    private $id;
    private $createdAt;
    private $updatedAt;

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
        string $about,
        bool $is_new = true, // this for encapsulate obj without create new record in db
        string $id = null,  // dependency for $is_new
        string $createdAt = null, // dependency for $is_new
        string $updatedAt = null, // dependency for $is_new
    ) {
        parent::__construct(
            $imagePath,
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

        if ($is_new) {
            $this->id = Utils::generateUUID();
            $this->createdAt = date("Y-m-d H:i:s");
            $this->updatedAt = $this->createdAt;

            Database::Query("
              INSERT INTO
              job_seekers(id, image, first_name, last_name, email, phone, password,
                    industry, current_company, title, about, is_recruiter, created_at, updated_at)
              VALUES('$this->id', '$this->ImagePath', '$this->Fname', '$this->Lname', '$this->email', '$this->pswd',
                     '$this->phone', '$this->industry', '$this->currentCompany', '$this->title', '$this->about', FALSE,
                     '$this->createdAt', '$this->updatedAt');
            ");
        } else {
            $this->id = $id;
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
        }
    }

    public static function getJobSeekerById(string $JobSeekerId): JobSeeker | null
    {
        $record = Database::Query("SELECT * FROM job_seekers WHERE id = '$JobSeekerId' ")->fetch();

        if (empty($record)) {
            return null;
        }

        return new JobSeeker(
            $record['image'],
            $record['first_name'],
            $record['last_name'],
            $record['email'],
            $record['phone'],
            $record['password'],
            $record['industry'],
            $record['title'],
            $record['current_company'],
            $record['about'],
            false,
            $record["id"],
            $record["created_at"],
            $record["updated_at"]
        );
    }

    public function getAllData(): array
    {
        return [
          "id" => $this->id,
          "imagePath" => $this->ImagePath,
          ...$this->getData(),
          "createdAt" => $this->createdAt,
          "updatedAt" => $this->updatedAt
        ];
    }

    public function updateImagePath(string $newImagePath)
    {
        $this->updatedAt = $this->upImgPath($newImagePath, "job_seekers", $this->id);
        $this->ImagePath = $newImagePath;
    }

    public function updatePassword(string $newPassword)
    {
        $this->updatedAt = $this->upPswd($newPassword, "job_seekers", $this->id);
        $this->pswd = $newPassword;
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

        $this->updatedAt = $this->upData(
            $Fname,
            $Lname,
            $email,
            $phone,
            $industry,
            $title,
            $currentCompany,
            $about,
            "job_seekers",
            $this->id
        );
        $this->Fname = $Fname;
        $this->Lname = $Lname;
        $this->email = $email;
        $this->phone = $phone;
        $this->industry = $industry;
        $this->title = $title;
        $this->currentCompany = $currentCompany;
        $this->about = $about;
    }
}
