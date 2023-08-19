<?php

function _makeenv(array $data){
    eglob('env',$data);
}

function _env($type, $else = NULL){
    $_ENV = eglob('env');
    if(isset($_ENV[$type])){
        return $_ENV[$type];
    }
    return $else;
}

$file = ROOT . '/app_env.php';
if(!file_exists($file) && !(include $file)) {
    require ROOT . '/env.dev.php';
} else require ROOT . '/env.php';