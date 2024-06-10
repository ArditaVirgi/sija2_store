<?php
namespace app;
use app\Route;

class Application{
    public function run(){
        echo Route::resolve();
    }
}