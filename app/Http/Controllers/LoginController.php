<?php 
namespace App\Http\Controllers;

class LoginController extends Controller{
    public static function index(){
        return view('login.index', [
            'title' => 'LOGIN - SIJA\'s Store'
        ]);
    }
}