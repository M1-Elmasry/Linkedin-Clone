<?php
namespace API\Controllers;

use \API\Core\Controller;
use \DB\Models\JobPost;

class PostController extends Controller
{
    public function Latest()
    {
        $records = JobPost::GetLatestPosts();
        return $this->response($records);
    }
}