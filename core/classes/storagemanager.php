<?php

namespace Core\Flame\Storage;

use Core\Base\Base;
use Exception;

class Manager extends Base {

     private static array $files = array();

     public static function boot(): void {
          if($path = _env('STORE_PATH', false)) {
               createPath($path);
          }
     }

     public static function collect(array|string $names) {
          if(request()->method() == 'get') throw new Exception('Hey! Files can not be uploaded with "GET" request method.');
          $requested_file_names = array_keys($_FILES);
          if(!is_array($names)) $names = array($names);
          foreach($names as $name) {
               if(in_array($name, $requested_file_names)) {
                    $tmpFile = self::blobUser($_FILES[$name]);
                    $file = new File(
                         true, // creating a new file and not pre-loading existing
                         $tmpFile->blobUrl,
                         $tmpFile->filename,
                         $tmpFile->size,
                         $tmpFile->type
                    );
                    self::$files[$name] = $file;
               }
          }
     }

     public static function get(string $name): File|false {
          if(isset(self::$files[$name])) return self::$files[$name];
          return false;
     }

     private static function blobUser($blob) {
          return (object) array(
               'filename' => $blob['name'],
               'size' => $blob['size'],
               'blobUrl' => $blob['tmp_name'],
               'type' => $blob['type'],
          );
     }

}