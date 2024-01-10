<?php

//router for web
class Router
{
    protected $routes = [];

    //add path to router
    public function add($uri, $controller, $method)
    {
        $this->routes[] = [
            'uri'=> $uri,
            'controller' => $controller,
            'method' => $method,
        ];
    }

    public function get($uri, $controller)
    {
        $this->add($uri, $controller, 'GET');
    }

    public function post($uri, $controller)
    {
        $this->add($uri, $controller, 'POST');
    }

    public function put($uri, $controller)
    {
        $this->add($uri, $controller, 'PUT');
    }

    public function delelte($uri, $controller)
    {
        $this->add($uri, $controller, 'DELETE');
    }

    //route the request to controller
    public function route($uri, $method)
    {
        foreach ($this->routes as $route)
        {
            //using regular expression to find route like exercise/{id}
            if (strpos($route['uri'], '$') !== false) {
                $regex = str_replace('$', '(\d+)', $route['uri']);
                if (preg_match("#^$regex$#", $uri) && $route['method'] == $method) {
                    return require_once $route['controller'];
                }
            } else {
                if ($route['uri'] == $uri && $route['method'] == $method) {
                    return require_once $route['controller'];
                }
            }
        }

        abort();
    }
}