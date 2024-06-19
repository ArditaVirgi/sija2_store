<?php

function view($view, $data = [])
{
    $viewPath = __DIR__ . '/resources/views/';
    $adaview = file_exists($viewPath . str_replace('.', '/', $view) . '.blade.php');
    if ($adaview) {
        extract($data);
        $content = file_get_contents($viewPath . str_replace('.', '/', $view) . '.blade.php');

        // Mengubah php echo menjadi {{}} di html
        // $content = str_replace('{{', '<?=', $content);
        /* $content = str_replace('}}', '?>', $content); */
        $content = preg_replace('/{{\s*(.+?)\s*}}/', '<?= $1; ?>', $content);

        // Membuat tag buka tutup php di html
        $content = preg_replace('/@php\s*(.+?)\s*@endphp/', '<?php $1; ?>', $content);

        // Membuat tag if, elseif, else dan endif di html
        $content = preg_replace('/@if\s*\(\s*(.+?)\s*\)/', '<?php if($1): ?>', $content);
        $content = preg_replace('/@elseif\s*\(\s*(.+?)\s*\)/', '<?php elseif($1): ?>', $content);
        $content = str_replace('@else', '<?php else: ?>', $content);
        $content = str_replace('@endif', '<?php endif; ?>', $content);

        // Membuat tag switch
        $content = preg_replace('/@switch\s*\(\s*(.+?)\s*\)/', '<?php switch($1):', $content);
        $content = preg_replace('/@case\s*\(\s*(.+?)\s*\)/', 'case $1: ?>', $content);
        $content = str_replace('@break', '<?php break;', $content);
        $content = str_replace('@default', 'default: ?>', $content);
        $content = str_replace('@endswitch', '<?php endswitch; ?>', $content);

        // Membuat tag foreach
        $content = preg_replace('/@foreach\s*\(\s*(.+?)\s*\)/', '<?php foreach($1): ?>', $content);
        $content = str_replace('@endforeach', '<?php endforeach; ?>', $content);

        // Membuat tag if isset
        $content = preg_replace('/@isset\s*\(\s*(.+?)\s*\)/', '<?php if(isset($1)): ?>', $content);
        $content = str_replace('@endisset', '<?php endif; ?>', $content);


        ob_start();
        eval('?>' . $content);
        $final = ob_get_clean();
        return $final;
    } else {
        echo "<h3 style='background-color: #F7F6BB;padding: 15px;
        border: 1px solid #87A922;border-radius: 5px;'>View [$view] not found.</h3>";
    }
}

function route($alamat, $param = [])
{

    $url = explode('.', $alamat);
    if ($param) {
        $link = $url[0] . '/' . $param . '/' . $url[1];
    } elseif ($url[1] === 'index') {
        $link = $url[0];
    } else {
        $link = $url[0] . '/' . $url[1];
    }
    return $link;
}

require_once __DIR__ . '/App/autoload.php';

use App\Application;

$app = new Application;
require_once __DIR__ . "/routes/web.php";
$app->run();
