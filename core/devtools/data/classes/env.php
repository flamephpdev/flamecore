<?php

namespace DEV;

class Env extends ClassROOT {

     public static function main($args){
          if(isset($args[0]) && in_array($args[0], ['dev', 'production'])) {
               file_put_contents(core('app_env.php'), "<?php\nreturn " . var_export($args[0] == "production", true) . ";" );
          } else info('Please choose "dev" or "production"');
     }

}