<?php

namespace Core\App\Config;

use Core\Base\Base;

class Config extends Base {

     private static $config = array();
     private static $config_file;

     public static function boot(): void {
          createPath(cache('/config/'));
          self::$config_file = cache('/config/config.php');
          if(!file_exists(self::$config_file) || _env('APP_DEV')) {
               self::$config = self::cache();
          } else self::$config = require self::$config_file;
     }

     public static function cache() {
          $configs = getDirContents($root = path(root('/app/config/')));
          $confs = [];
          foreach($configs as $config) {
               $file = substr(str_replace($root, '', path($config)), 0, -4);
               $confs[$file] = require $config;
          }
          file_put_contents(self::$config_file, "<?php\nreturn " . var_export($confs, true) . ";\n");
          return $confs;
     }

     public static function get($file) {
          self::classBooter(new self);
          if(isset(self::$config[$file])) return self::$config[$file];
          return false;
     }

}