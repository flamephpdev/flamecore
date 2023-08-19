<?php

use Core\App\Config\Config;

function config($file){
    return Config::get($file);
}