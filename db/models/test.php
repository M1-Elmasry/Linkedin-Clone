<?php

require('db/models/Recruiter.php');
// require('db/models/JobSeeker.php');
use DB\Models\Recruiter as Recruiter;
// use DB\Models\JobSeeker as JobSeeker;

$x1 = new Recruiter("public/image.jpg", "mostafa", "elmasry", "mmf@gmail.com", "asdfj*&Ynj", "+201145551878", "software development", "software Engineer", "-", "-");
