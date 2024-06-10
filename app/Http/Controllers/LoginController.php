<?php 
namespace app\Http\Controllers;

class LoginController extends Controller{
    public function index(){
        return view('login.index', [
            'title' => 'LOGIN - SIJA\'s Store'
        ]);
    }
}