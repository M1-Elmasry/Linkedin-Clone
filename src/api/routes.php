<?php
// responsible for defining all API routes
// http://www.domainName.domain/api/{route}
// $router->method(route, controllerName:functionName, params);

// test routes
$router->get('', 'Home');
$router->get('test/{id}/{data}', 'Home:Test');

// Auth routes
$router->post('login', 'User:Login', ['email', 'password'])->only('Guest');
$router->post('register', 'User:Register', ['first_name', 'last_name', 'email', 'password', 'is_recruiter'])->only('Guest');
$router->post('logout', 'User:Logout')->only('Auth');

// Post routes
$router->get('post/latest', 'Post:Latest');