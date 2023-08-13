<?php

namespace DEV;

class CrossProject extends ClassROOT {

     private static string $conf_file = '';
     private static array $aliases = [];

     private static function init(){
          self::$conf_file = CORE . '/cache/dev/cross-project.php';
          if(!file_exists(self::$conf_file)){
               createPath(dirname(self::$conf_file));
               file_put_contents(self::$conf_file, "<?php\nreturn " . var_export([
                    'aliases' => []
               ],true) . ";");
          } else {
               $data = require_once self::$conf_file;
               self::$aliases = $data['aliases'];
          }
     }

     public static function main($args){
          self::init();
          $args = self::mkprops($args);
          $path = '';
          $path_or_alias = array_shift($args);
          $args = implode(" ", $args);
          if(in_array($path_or_alias, array_keys(self::$aliases))){
               $path = self::$aliases[$path_or_alias];
          } else {
               $path = $path_or_alias;
          }
          if(!str_ends_with($path, '/') || !str_ends_with($path, '\\')) $path .= '/';
          if(file_exists($path . 'ignite')){
               $dev_file = $path . 'ignite';
               $output = '';
               $rc = 0;
               exec("php $dev_file $args", $output, $rc);
               headerPrintBg("Executed, code: $rc\nOutput:", true);
               echo $output;
          } else {
               headerPrintBg("Invalid Project path: $path", true);
          }
     }

     public static function alias($args){
          self::init();
          $args = self::mkprops($args, true);
          $name = array_keys($args)[0];
          $path = array_values($args)[0];
          self::$aliases[$name] = $path;
          file_put_contents(self::$conf_file, "<?php\nreturn " . var_export([
               'aliases' => self::$aliases,
          ],true) . ";");
          headerPrintBg('Successfully added!', true);
     }

}