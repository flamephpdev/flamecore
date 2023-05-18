<?php

namespace Core\App\Helpers;

use Core\Base\Base;

class Log extends Base {

     private static $log_path = '/core/logs/';

     public static function boot():void {
          createPath(root(self::$log_path));
     }

     public static function write($data){
          if(is_object($data) || is_array($data)){
               $data = var_export($data, true);
          }
          $file = root(self::$log_path . date('Y-m-d') . '.dev.log');
          return file_put_contents($file, "[Log " . date('H:i:s') . "]\n" . $data . "\n\n", FILE_APPEND);
     }

}