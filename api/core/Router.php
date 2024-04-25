<?php
namespace Core;

class Router
{
  // routes cache
  private $routes = [];

  // method types (only needed ones)
  public function get($uri, $controllerName)
  {
    $this->AddRoute($uri, $controllerName, 'GET');
  }
  public function post($uri, $controllerName)
  {
    $this->AddRoute($uri, $controllerName, 'POST');
  }
  public function delete($uri, $controllerName)
  {
    $this->AddRoute($uri, $controllerName, 'DELETE');
  }

  // handle and validate incoming requests
  public function HandleRequest($uri, $method)
  {
    if(count($this->routes) == 0)
    {
      abort();
    }

    $uri = parse_url($uri);
    $route = null;

    foreach ($this->routes as $routeItem) {
      if($routeItem['uri'] == $uri["path"] && $routeItem['method'] == $method) {
        $route = $routeItem;
        break;
      }
    }

    if($route == null) {
      return abort();
    }

    require base_path($route['controllerPath']);
    
    $controller = new $route['controllerName'];
    $controller->{$route['action']}();
  }

  // helpers
  private function AddRoute($uri, $controller, $method)
  {
    $controllerName = "";
    $actionName = "";

    if(str_contains($controller, ':'))
    {
      $controllerArray = explode(':', $controller);
      $controllerName = $controllerArray[0];
      $actionName = $controllerArray[1];
    }
    else
    {
      $controllerName = $controller;
      $actionName = 'Index';
    }

    $this->routes[] = [
      'method' => $method,
      'uri' => $uri,
      'controllerName' => "\Controllers\\{$controllerName}Controller",
      'controllerPath' => "controllers/{$controllerName}Controller.php",
      'action' => $actionName
    ];
  }
}