<?php

namespace Routing;

use Core\App\Error;

class Router {

    private static string $prefix = '';
    private static string $suffix = '';
    private static bool $loaded = false;

    private static function preLoad() {
        if(static::$loaded) return;
        $pattern = _env('ROUTE_PATTERN');
        if(str_starts_with($pattern, '/')) $pattern = substr($pattern, 1);
        $split = explode(':path', $pattern);
        static::$prefix .= $split[0];
        static::$suffix .= $split[1] ?? '';
        static::$loaded = false;
    }

    public static function getPrefix(): string {
        return static::$prefix;
    }

    public static function getSuffix(): string {
        return static::$suffix;
    }

    public static function route(){
        self::preLoad();
        $route = substr($_SERVER['REQUEST_URI'],1);
        if(str_starts_with($route,'?')) $route = '';
        $route = strtok($route,'?');
        if(static::$prefix !== '' && !(str_ends_with(static::$prefix, '/') && $route == substr(static::$prefix, 0, -1))) {
            if(
                $route != static::$prefix &&
                !str_starts_with($route, static::$prefix) ||
                (str_ends_with('/', static::$prefix) && substr(static::$prefix, 0, -1) != $route) &&
                !str_starts_with(substr($route, strlen(static::$prefix)), '/')
            ) Error::NotFound();
        }
        $route = substr($route, URL_SUBSTR_COUNT + strlen(static::$prefix));
        if(strlen(static::$suffix) != 0) $route = substr($route, 0, -strlen(static::$suffix));
        if($route == '' || !$route) $route = '/';
        return $route;
    }

    public static function exploded(){
        $route = self::route();
        if($route == '/') return $route;
        return(array_filter(explode('/',$route),function($var){
            return $var !== '';
        }));
    }

}