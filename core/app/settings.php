<?php

function Settings($key){
     $data = require root('/app/settings.php');
     if(isset($data[$key])) {
          return $data[$key];
     } else throw new \Exception ("{$key} key not found in settings.php");
}