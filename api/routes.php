<?php
// responsible for defining all API routes
// http://www.domainName.domain/api/{route}
// $router->method(route, controllerName:functionName);

$router->get('/', 'Home');
$router->get('/test/{id}/{data}', 'Home:Test');