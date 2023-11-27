<?php

namespace Core\Flame\Orm;

use Core\Flame\Orm\Helpers\CustomDataType\Date;
use Core\Flame\Orm\Helpers\CustomDataType\Json;

class VarTypeTranslator {
     public function __construct(protected string $var) {}

     public function get() {
          $e = explode('(', $this->var);
          $type = match(strtolower($e[0])) {
               'int', 'tinyint', 'smallint', 'mediumint', 'bigint', 'serial', 'bit' => 'int',
               'decimal', 'float', 'double', 'real' => 'float',
               'boolean' => 'bool',
               'date', 'datetime', 'timestamp', 'time', 'year' => Date::class,
               'json' => Json::class,
               default => 'string',
          };
          $len = intval(string_between($this->var, '(', ')'));
          return [$type, $len];
     }
}