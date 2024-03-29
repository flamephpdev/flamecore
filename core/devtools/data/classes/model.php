<?php

namespace DEV;

use DB;

class Model extends ClassROOT {

    private static $model_root = ROOT . '/app/Models/';

    public static function main($args){
        $args = self::mkprops($args,true);
        if(isset($args['name'])){
            $mkname = self::mknPath($args['name']);
            $name = toCamelCase($mkname['name'], true);
            $model_file = self::$model_root . $mkname['path'] . $name . '.php';
            if(!file_exists($model_file)){
                $table = $args['table'] ?: 'Please Fill Me :)';
                createPath(self::$model_root . $mkname['path']);

                $fields = [ 'name', 'password' ];

                $content = file_get_contents(__DIR__ . '/model.file');
                if($table != 'Please Fill Me :)'){
                    $description = DB::query('DESCRIBE ' . $table);
                    if(!isset($description['error']) && is_array($description)){
                        if(isset($description['id'])){
                            unset($description['id']);
                        }
                        $fields = $description;
                    }
                }
                

                
                $mrfields = "array(\n            // don't add 'id' if you don't have a writable config\n";

                $mreadfields = "array(\n            // fields that you want to allow to read)\n";

                foreach($fields as $field){
                    $f = "            '" . $field . "',\n";
                    if($field != 'id') $mrfields .= $f;
                    if(!in_array($field, ['password', 'pw', 'secret_token', 'protected'])) $mreadfields .= $f;
                }
                $mrfields .= '        ),';

                $mreadfields .= "            // 'password'   password is a sensitive data so it's ignored\n";
                $mreadfields .= '        ),';

                $content = str_replace('{ModelRealFields}', $mrfields, $content);

                $content = str_replace('{ModelReadableFields}', $mreadfields, $content);

                $content = str_replace('{ModelName}',$name,$content);
                $content = str_replace('{ModelTable}',$table,$content);
                
                if($mkname['path'] != '') $content = str_replace('{NS}','\\' . str_replace('/','\\',substr($mkname['path'], 0, -1)), $content);

                file_put_contents($model_file, $content);
                headerPrintBg("{$name} Model Successfully created!",true);
                exit;
            }
            headerPrintBg("{$name} Model Already exists!", true);
            exit;
        } else {
            _e('Unknow model command :/',true);
        }
    }

    public static function mknPath($name){
        if(!str_contains($name, '/')) return [
            'path' => '',
            'name' => $name,
        ];
        $path = explode('/', $name);
        $built = '';
        foreach($path as $key => $value){
            if($key != array_key_last($path)) $built .= toCamelCase($value, true) . '/';
        }
        return [
            'path' => $built,
            'name' => $path[array_key_last($path)],
        ];
    }

}