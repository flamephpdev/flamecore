<?php

function winpath($path){
     return str_replace('\\', '/', $path);
}

function path($path){
     if(PHP_OS == 'WINNT' && _env('ENA_WINPATH')) return str_replace('/', '\\', $path);
     return str_replace('\\', '/', $path);
}