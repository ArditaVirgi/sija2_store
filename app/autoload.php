<?php
// Mengganti penggunaan require dengan menggunakan namespace
spl_autoload_register(function ($class) {
    //Konversi dari namespace menjadi alamt file
    $file = str_replace('\\', '/', $class) . '.php';

    //Mencari nama filenya jika ada file di-require
    if(file_exists($file)) {
        require $file;
    }
});