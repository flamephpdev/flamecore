<?php

use Core\Flame\Request;

function response(){
    return Request::Current()->response();
}

function request(){
    return Request::Current();
}