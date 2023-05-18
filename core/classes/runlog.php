<?php

namespace App\Errors\Log;

class RunLog {

     private static $log = array();

     public static function add($message){
          if(_env('APP_DEV') || _env('APP_DEBUG')) self::$log[] = array((microtime(true) - START_TIME) . 's', $message);
     }

     public static function write(){
          if(!_env('APP_DEV') && !_env('APP_DEBUG')) return;
          $message = '';
          foreach(self::$log as $log){
               $data = $log[1];
               if(is_array($data) || is_object($data)) $data = var_export($data, true);
               $message .= $log[0] . "\n" . $data . "\n" . (str_repeat('-', 50)) . "\n";
          }
          file_put_contents(root('runtime.log'), $message);
     }

}