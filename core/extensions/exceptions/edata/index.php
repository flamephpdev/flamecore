<?php

use Core\Framework\Console\Color\BackgroundColor;
use Core\Framework\Console\Color\Color;
use Core\Framework\Console\Color\ForegroundColor;
use Core\Framework\Framework;

$rurl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$includes = array_map(function($str) { return str_replace(path(ROOT), '', path($str)); }, get_included_files());

if(Framework::isConsole() || (Framework::isWeb() && getallheaders()['Accept'] == 'application/json')){

    $error = [
        'exception' => [
            'type' => $type,
            'line' => $eline,
            'message' => $message,
            'file' => $file,
        ],
        'requested-url' => $rurl,
        'session' => $_SESSION,
        'includes' => $includes,
        'render_time' => getrtime(),
    ];

    if(Framework::isWeb() && getallheaders()['Accept'] == 'application/json') {
        echo json_encode($error,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    } else if(Framework::isConsole()) {
        $exception = $error['exception'];
        echo "\n";
        error("FATAL $exception[type]", BackgroundColor::RED);
        echo Color::Foreground("File: ", ForegroundColor::RED);
        echo $exception['file'] . ':' . $exception['line'];
        echo Color::Foreground("\nMessage:\n", ForegroundColor::RED);
        echo $exception['message'];
        $dir = core('/runtime/errors/');
        createPath($dir);
        $data = json_encode($error, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $file_name = 'exception-' . date('Y-m-d-H-i-s') . '.json';
        if(file_put_contents($dir  . $file_name, $data)) {
            echo Color::Background("\n\n   For more information, check this file:\n   $dir$file_name\n", BackgroundColor::BLUE);
        }
        echo "\nCode:";
        echo "\n$file_data";
    }
} else {
if(class_exists('\Cache\Views\Flame\FlameRender')){
    $message = str_replace(
        $p = path(\Cache\Views\Flame\FlameRender::$store_dir), 
        '<span title="' . $p . '" style="cursor:pointer;border-radius:5px;background-color:#ffca3a;color:black;padding: 3px 10px;">Views</span>', 
        path($message)
    );
}
if(file_exists($token = CORE . '/applock.token.php')) {
    $token = require $token;
    $message = str_replace(
        $p = path($token['framework_builtin_views_directory']), 
        '<span title="' . $p . '" style="cursor:pointer;border-radius:5px;background-color:#333;color:white;padding: 3px 10px;">FlameCore@Templates</span>', 
        path($message)
    );
}
flush();
ob_start();
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$type?> - Flame Core</title>
    <style>
        <?=file_get_contents(__DIR__ . '/app.css')?>
    </style>
</head>
<body>
    <div style="width: 90%;margin:auto;">
        <h1>Flame Core - ERROR</h1>
        <h2><?=$type?> &#10006; [ Line: <?=$eline?> ]</h2>
        <div style="display: flex;"><pre class="data-code"><?=$message?></pre></div>
        <div class="filename noselect" style="display: flex;">
        <span><?=$file?></span>
        <span style="margin-left:auto">&#9776;</span>
        </div>
        <div style="display: flex;">
            <pre class="data-lines noselect"><?=$lines?></pre>
            <pre class="data-code file-code-box"><code><?=$file_data?></code></pre>
        </div>
        <hr />
        <h2>Request</h2>
        <?=xdump($rurl,'URL',false,false)?>
        <?=xdump(apache_request_headers(),'Headers')?>
        <?=($_GET != []) ? xdump($_GET,'GET data') : '' ?>
        <?= (function_exists('post')) ? xdump(post(),'Post data') : '' ?>
        <?= (session_status() != PHP_SESSION_NONE) ? xdump($_SESSION,'Session') : '' ?>
        <?= xdump($includes,'Included files') ?>
        <?= xdump(getrtime() . 's','Render Time',false,true) ?>
    </div>
</body>
<?php
$page = ob_get_contents();
ob_get_clean(); 
?>
<script>document.querySelector('html').innerHTML = atob('<?=base64_encode($page)?>');</script>
<?php } ?>
