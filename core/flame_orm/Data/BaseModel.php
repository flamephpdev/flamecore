<?php

namespace Core\Flame\Orm;

use Core\Base\Base;
use DB;
use Exception;

class BaseModel extends Base {
     public static function boot(): void {
          createPath(cache('/flame_orm/database_informations/'));
     }

     protected static function GetTableInformation(string $table) {
          $cachedFile = cache('/flame_orm/database_informations/__' . $table . '__table__.php');
          if(_env('APP_DEV') || !file_exists($cachedFile)) {
               try {
                    $data = DB::_select('EXPLAIN ' . $table);
               } catch(Exception) {
                    throw new Exception('Invalid database table name: ' . $table);
               }
               $fields = [];
               foreach($data as $col) {
                    $type = (new VarTypeTranslator($col['Type']))->get();
                    $fields[$col['Field']] = [
                         'type' => $type,
                         'default' => $col['Default'],
                         'is_nullable' => $col['Null'] == 'Yes' ? true : false,
                         'key' => $col['Key'] == '' ? NULL : strtolower($col['Key']),
                         'extra' => $col['Extra'] == '' ? NULL : $col['Extra'],
                    ];
               }
               file_put_contents($cachedFile, phpvar($fields));
          } else $fields = require $cachedFile;
          return $fields;
     }
}