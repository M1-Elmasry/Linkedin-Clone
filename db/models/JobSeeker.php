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

        $this->tableName = "job_seekers";
        $this->isRecruiter = 0; // False

        if ($is_new) {
            $this->createNewRecord();
        } else {
            $this->userId = $id;
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
        }
    }

    public static function getJobSeekerById(string $JobSeekerId): ?JobSeeker
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
}
