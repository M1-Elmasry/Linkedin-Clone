<?php
namespace DB\Models;

use \DB\Models\User;
use \DB\Database;

class Recruiter extends User
{
    public function __construct(
        string $Fname,
        string $Lname,
        string $email,
        string $pswd,
        bool $is_new = false, // this for encapsulate obj without create new record in db
        string $imagePath = '-',
        string $phone = '-',
        string $industry = '-',
        string $title = '-',
        string $currentCompany = '-',
        string $about = '-',
        string $id = null,  // dependency for $is_new
        string $createdAt = null, // dependency for $is_new
        string $updatedAt = null, // dependency for $is_new
    ) {
        parent::__construct(
            $Fname,
            $Lname,
            $email,
            $pswd,
            true,
            $imagePath,
            $phone,
            $industry,
            $title,
            $currentCompany,
            $about
        );

        $this->tableName = "recruiters";

        if ($is_new) {
            $this->createNewRecord();
        } else {
            $this->userId = $id;
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
        }
    }

    public static function getRecruiterById(string $RecruiterId): Recruiter | null
    {
        $record = Database::Query("SELECT * FROM recruiters WHERE id = '$RecruiterId' LIMIT 1")->fetch();

        if (empty($record)) {
            return null;
        }

        return new Recruiter(
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
}