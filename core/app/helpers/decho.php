<?php

function decho($message) {
     if(_env('APP_DEV')) return $message;
     return false;
}