<?php
namespace app;

class Request{
    public static function getPath(){
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        // =======================================
        $path = explode('/', $path);
        unset($path[0]);
        if($path[1] === '11sija2_store'){
            unset($path[1]);
            if($path[2] === ''){
                $path[2] = '/';
            }
        }else if($path[1] === '11sija2_store'){
            if($path[1] === ''){
                $path[1] = '/';
            }
        } 
        $path = implode('/', $path);
        if($path !== '/'){
            $path = '/' . $path;
        }
        // =====================================
        $position = strpos($path, '?');
        if($position === false){
           return $path;
    }
    return substr($path, 0, $position);
    }
    public static function getMethod(){
    return strtolower($_SERVER['REQUEST_METHOD']);
    }      
}
