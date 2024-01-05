<?php

class Router
{
    protected $routes = [];

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

    public function route($uri, $method)
    {
        foreach ($this->routes as $route)
        {
            if ($route['uri'] == $uri && $route['method'] == $method)
            {
                return require $route['controller'];
            }
        }

        abort();
    }
}