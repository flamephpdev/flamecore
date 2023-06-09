<?php

function createIdeHelperPlugin() {
     $content = array();
     $file = core('Ide@ModelHelp.php');
     $fileContent = "<?php\n\n/* <auto-generated/>\nIde Model Helper File */\n\n";

     if(class_exists('DB')) {
          $models = array();
          foreach(get_declared_classes() as $class){
               if(is_subclass_of($class, 'Core\Base\ModelBase')) $models[] = $class;
          }
          foreach($models as $model) {
               $model = new $model;
               $model->classBooter($model);
               $table = $model->getDBTable();
               $fields = NULL;
               try {
                    $fields = DB::query('DESCRIBE ' . $table);
               } catch(Exception $e) {
                    _e('Undefined table: ' . $table);
               }

               if($fields != NULL) {
                    $content[] = array(
                         'modelFullName' => $model::class,
                         'modelfields' => $fields,
                         'table' => $table,
                    );
               }
          }
          foreach($content as $c) {
               $x = explode('\\', $c['modelFullName']);
               $x = array_reverse($x);
               $class = array_shift($x);
               $x = array_reverse($x);
               $fileContent .= 'namespace ' . implode('\\', $x);
               $fileContent .= "\n{\n";
               $fileContent .= "\tclass " . $class;
               $fileContent .= "\n\t{\n";
               $fileContent .= "\t\t// Fields loaded from the database \"$c[table]\" table";
               foreach($c['modelfields'] as $f){
                    $fileContent .= "\n\t\tpublic \$$f;";
               }
               $fileContent .= "\n\t}\n";
               $fileContent .= "\n}\n\n";
          }
          file_put_contents($file, $fileContent);
     } else throw new Exception('Databases is required for this plugin');
}