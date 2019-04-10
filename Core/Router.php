<?php

namespace Core;

class Router {
    private static $routes = [];
    private static $base = '';

    public static function addRoute($route) {
        Router::$routes[] = $route;
    }

    public static function base($base = null) {
        if ($base != null)
            self::$base = $base;
        return self::$base;
    }

    public static function getRoutes() {
        return Router::$routes;
    }

    public function resolve(Request $request) {
        foreach (Router::$routes as $route) {
            if ($route->isMatching($request))
                return $route->generateMatch($request);
        }
        return null;
    }
}
