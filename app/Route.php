<?php
namespace App;
use App\Request;

class Route
{
    protected static array $route = [];

    public static function setParam($path)
    {
        $request = new Request;
        $url = explode('/', $request::getPath());
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
        $url = explode('/', $request::getPath());
        $jmlh = count($url);

        if ($jmlh == 2) {
            $path = '/' . $url[1];
        } elseif ($jmlh == 3) {
            if (!isset($url[2])) {
            } else {
                $path = '/' . $url[1] . '/' . $url[2];
            }
        } elseif ($jmlh == 4) {
            $path = '/' . $url[1] . '/' . $url[2] . '/' . $url[3];
        }
        self::$route['get'][$path] = $callback;
    }

    public static function resolve()
    {
        $request = new Request; //Mengambil alamat URL
        $path = $request::getPath(); //Mengambil method dari route get, post, dll
        $method = $request::getMethod();
        $param = explode('/', $path)[2] ?? '';
        $callback = self::$route[$method][$path] ?? false; //Mengambil nama class controller dan methodnya

        if ($callback === false) {
            require_once __DIR__ . '../../resources/views/error404.php';
        }
        if (is_callable($callback)) {
            return call_user_func($callback);
        }

        if (is_array($callback)) {
            if (method_exists($callback[0], $callback[1]) === false) {
                return "<h3 style='background-color: #F7F6BB;
                padding: 15px;border: 1px solid #87A922;
                border-radius: 5px;'>Method $callback[0]::$callback[1] does not exist</h3>";
            }
            $callback[0] = new $callback[0]; //Mengubah Class Controller menjadi object
            return call_user_func($callback, $param);
        }

        if (is_string($callback)) {
            if ($method === 'get') {
                $path = explode('/', $path);
                if (count($path) == 3 and $path[2] === 'create') {
                    $method = $path[2];
                } elseif (count($path) == 3 and $path[2] !== 'create') {
                    $method = 'show';
                    $param = $path[2];
                } elseif (count($path) == 4 and $path[3] === 'edit') {
                    $method = $path[3];
                    $param = $path[2];
                } elseif (count($path) < 3) {
                    $method = 'index';
                }
                $callback = explode('/', $callback . '/' . $method);
            }
            if (method_exists($callback[0], $callback[1]) === false) {
                return "<h3 style='background-color: #F7F6BB;padding: 15px;
                border: 1px solid #87A922;border-radius: 5px;'>
                Method $callback[0]::$callback[1] does not exist.</h3>";
            }
            $callback[0] = new $callback[0]; //Mengubah Class Controller menjadi object
            return call_user_func($callback, $param);
        }
    }
}
