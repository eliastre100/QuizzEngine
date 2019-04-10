<?php

namespace Core;

class Route {
    private $uri;
    private $controller;
    private $action;
    private $params;
    private $roles;

    public static function get($uri, $to, $roles = []) {
        self::add($uri, $to, 'GET', $roles);
    }

    public static function post($uri, $to, $roles = []) {
        self::add($uri, $to, 'POST', $roles);
    }

    public static function add($uri, $to, $method, $roles = []) {
        $route = new Route(Router::base().$uri, $to, $method, $roles);
        Router::addRoute($route);
    }

    public function __construct($uri, $to, $method, $roles = [])
    {
        $to = explode('#', $to, 2);
        $this->uri = $uri;
        $this->method = $method;
        $this->controller = $to[0];
        $this->action = $to[1];
        $this->params = [];
        $this->roles = $roles;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function isMatching(Request $request) {
        $uriParts = explode('/', $this->uri);
        $requestParts = explode('/', $request->getUri());

        if (count($uriParts) != count($requestParts) || $this->method != $request->getMethod()) return false;
        foreach ($uriParts as $k => $part) {
            if ((!isset($part[0]) || $part[0] != ':') && $part != $requestParts[$k]) return false;
            else if (isset($part[0]) && $part[0] == ':') {
                $this->params[ltrim($part, ':')] = $requestParts[$k];
            }
        }
        return true;
    }

    public function generateMatch($uri) {
        return [
            'uri' => $uri,
            'controller' => '\\App\\Controllers\\'.$this->controller,
            'action' => $this->action,
            'params' => $this->params,
            'route' => $this
        ];
    }
}