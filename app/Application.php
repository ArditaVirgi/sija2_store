<?php
namespace App;
use App\Route;

class Application{
    public function run(){
        echo Route::resolve();
    }
}