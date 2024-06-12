<?php
namespace App\Http\Controllers;

class RegisterController extends Controller{
    public static function index(){
        return view('register.index', [
            'title' => 'REGISTER - SIJA\'s Store'
        ]);
    }

    public function create(){
        echo "REGISTER/CREATE";
    }

    public function edit(string $id){
        echo "REGISTER/EDIT" . $id;
    }

    public function show(string $id){
        return 'REGISTER/SHOW' . $id;
    }
}