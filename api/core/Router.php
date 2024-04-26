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
    $path = $uri["path"];
    $pathContent = explode('/', substr($path, 1));
    $route = null;
    $params = [];
    if(count($pathContent) > 1)
    {
      $pathContentCount = count($pathContent);
      
      foreach ($this->routes as $routeItem)
      {
        // skip the ones with diffrent method type from the start
        if($routeItem['method'] != $method) {
          continue;
        }
        
        $checkedPath = "";
        
        for($i = 0; $i < $pathContentCount; $i++)
        {
          // if already fount the route, add to parametars
          if($route != null) 
          {
            $params[] = $pathContent[$i];
            continue;
          }
          
          $checkedPath = $checkedPath . '/' . $pathContent[$i];
          
          if($checkedPath != $routeItem['uri'] || count($routeItem['params']) != $pathContentCount - $i - 1)
          {
            continue;
          }
          $route = $routeItem;
        }
        if($route != null) 
        {
          break;
        }
      }
    }
    else
    {
      foreach ($this->routes as $routeItem)
      {
        if($path == $routeItem['uri'] && $method == $routeItem['method'] && $routeItem['params'] == []) {
          $route = $routeItem;
          break;
        }
      }
    }

    if($route == null) {
      return abort();
    }

    require base_path($route['controllerPath']);
    
    $controller = new $route['controllerName'];
    call_user_func_array(array($controller, $route['action']), $params);
  }

  // helpers
  private function AddRoute($uri, $controller, $method)
  {
    $controllerName = "";
    $actionName = "";
    $param = [];

    // separate controller name and function name
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

    // extract parametars if any
    if(str_contains($uri, '{'))
    {
      $paramArray = explode('{', $uri);
      $uri = rtrim($paramArray[0], '/');
      
      for($i = 1; $i < count($paramArray); $i++)
      {
        $paramArray[$i] = rtrim($paramArray[$i], '/}');
        $param[] = $paramArray[$i];
      }
    }

    // cache the new route
    $this->routes[] = [
      'method' => $method,
      'uri' => $uri,
      'controllerName' => "\Controllers\\{$controllerName}Controller",
      'controllerPath' => "controllers/{$controllerName}Controller.php",
      'action' => $actionName,
      'params' => $param
    ];
  }
}