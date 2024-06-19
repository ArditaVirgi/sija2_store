<?php

namespace App;

use App\Request;

// error_reporting(0);

class Route
{

    protected static array $route = [];

    public static function setParam($path)
    {
        $request = new Request;
        $url = explode('/', $request::getPath()); //Mengambil Alamat URL
        $jmlh = count($url);
        if ($jmlh > 2) {
            $path = explode('/', $path);
            $path = preg_replace('/{id}/', $url[2], $path);
            $path = implode('/', $path);
        }
        return $path;
    }

    public static function get($path, $callback)
    {
        $path = self::setParam($path);
        self::$route['get'][$path] = $callback;
    }

    public static function post($path, $callback)
    {
        self::$route['post'][$path] = $callback;
    }

    public static function resource($path, $callback)
    {
        $request = new Request;
        $url = explode('/', $request::getPath()); //Mengambil Alamat URL

        $alamat = '/' . $url[1];

        if ($path === $alamat) { // Menampilkan halaman sesuai controller dan alamat urlnya
            self::$route['get'][$path] = $callback;
        }
    }

    public static function resolve()
    {
        $request = new Request;
        $path = $request::getPath(); //Mengambil Alamat URL
        $method = $request::getMethod(); //Mengambil method dari 
        //Route yaitu get, post, dll
        $url = explode('/', $path);
        if (isset($url[2]) and !isset($url[3])) {
            if ($url[2] === 'create' || $url[2] === 'store') {
                $fungsi = $url[2];
            } elseif (count($url) === 4) {
                $param = $url[3];
            } elseif (count($url) === 3) {
                $fungsi = $url[2] ?? '';
            }
        } elseif (isset($url[2]) and isset($url[3])) {
            $param = $url[2];
            $fungsi = $url[3];
        } elseif (count($url) === 2) {
            $fungsi = 'index';
        }

        $callback = self::$route[$method]['/' . $url[1]];
        if (!$callback) {
            require_once __DIR__ . '../../resources/views/error404.php';
        }

        if (is_callable($callback)) {
            return call_user_func($callback);
        }

        if (is_array($callback)) {
            if (method_exists($callback[0], $callback[1]) === false) {
                return "<h3 style='background-color: #F7F6BB;padding: 15px;
                border: 1px solid #87A922;border-radius: 5px;'>
                Method $callback[0]::$callback[1] does not exist.</h3>";
            }
            $callback[0] = new $callback[0]; //Mengubah Class Controller menjadi object 

            return call_user_func($callback, $param);
        }

        if (is_string($callback)) {
            $callback = explode('/', $callback . '/' . $fungsi);

            if (method_exists($callback[0], $callback[1]) === false) {
                return "<h3 style='background-color: #F7F6BB;padding: 15px;
                border: 1px solid #87A922;border-radius: 5px;'>
                Method $callback[0]::[$callback[1]] does not exist.</h3>";
            }

            $callback[0] = new $callback[0]; //Mengubah Class Controller menjadi object 
            return call_user_func($callback, isset($param));
        }
    }
}
