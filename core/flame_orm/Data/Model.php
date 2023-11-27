<?php

namespace Core\Flame\Orm;

use Core\App\Error;
use Core\Flame\Orm\Relations\RelationMethods;
use Core\Flame\Request;
use DB;
use Exception;

abstract class Model extends BaseModel implements IModel {
     use RelationMethods;

     protected static array $all_mysql_fields = [];
     protected array $writable = [];
     protected array $hidden = [];
     protected static ?string $table = NULL;
     protected array $__fieldSet = [];
     public array $fields;

     public static function boot(): void {
          if(_env('USE_DB')) {
               parent::boot();
               static::$all_mysql_fields = array_keys(
                    static::GetTableInformation(static::$table)
               );
          }
     }

     public function __call($name, $arguments) {
          if(_env('USE_DB')) $this->{$name}(...$arguments);
          else if(!in_array($name, ['boot'])) throw new Exception('Enable the database to use models');
     }

     public function __construct(string|int|null $search = NULL, string $findBy = 'id', bool $fail = false) {
          if(is_null($search)) return $this;
          $find = $this->select('*')->where($findBy, $search)->first();
          if(!$find && $fail) Error::NotFound();
          $this->fields = $find->fields;
          $this->__fieldSet = $find->__fieldSet;
          foreach($find->fields as $key => $val) $this->{$key} = $val;
     }

     public static function builder(): Builder {
          return new Builder(new static);
     }

     protected function make(array $dataset): void {
          foreach($dataset as $key => $value) {
               $this->__fieldSet[$key] = $value;
               if(!in_array($key, $this->hidden)) {
                    $this->{$key} = $value;
                    $this->fields[$key] = $value;
               }
          }
     }

     public static function select(array|string $fields = '*'): Builder {
          return static::builder()->select($fields);
     }

     public static function delete(?int $id): Builder|bool {
          return static::builder();
     }

     public static function update(array|Request $data, ?int $id, string $by = 'id'): bool|Builder {
          return static::builder();
     }

     public static function insert(array|Request $data): bool {
          $model = new static;
          $fields = self::GetTableInformation(static::$table);
          if($data instanceof Request) {
               $validation = [];
               foreach($model->writable as $field) {
                    $info = $fields[$field];
                    if($info['extra'] == 'auto_increment') continue;
                    $validation[$field] = [];
                    $validation[$field][] = 'type:' . (class_exists($info['type'][0]) ? $info['type'][0]::$type : $info['type'][0]);
                    if($info['type'][1] !== NULL) $validation[$field][] = 'max:' . $info['type'][1];
               }
               $validator = $data->body->validate($validation);
               if($validator->isDataValid()) $data = $validator->getValidatedData();
               else return false;
          }
          if(in_array('created_at', array_keys($fields)) && !in_array('created_at', array_keys($data))) $data['created_at'] = $created = date('Y-m-d H:i:s');
          if(in_array('updated_at', array_keys($fields)) && !in_array('updated_at', array_keys($data))) $data['updated_at'] = $created;
          return DB::insert(static::$table, $data) === true;
     }

     //
     public function getTable() {
          return static::$table;
     }

     public function getAllField() {
          return static::$all_mysql_fields;
     }
}