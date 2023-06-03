<?php

function winpath($path){
     return str_replace('\\', '/', $path);
}

function path($path){
     if(PHP_OS == 'WINNT') return str_replace('/', '\\', $path);
     return winpath('\\', '/', $path);
}