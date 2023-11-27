<?php

namespace Core\Flame\Orm\BuilderTools;

class Select {
     public function __construct(protected array $selections) {}

     public function generated(): array {
          $arrayFields = [];
          $query = '';
          foreach($this->selections as $i => $selection) {
               [$s, $model] = $selection;
               $table = $model->getTable();
               if($i != 0) $query .= ' ';
               foreach($s as $j => $field) {
                    if($j !== 0 && substr($query, -1) !== ' ') $query .= ' ';
                    $query .= $table . '.' . $field;
                    if($field == '*') $arrayFields = [...$arrayFields, ...array_map(function($f) use ($model) {
                         return [$f, $model];
                    }, $model->getAllField())];
                    else $arrayFields[] = [$field, $model];
                    if(array_key_last($s) !== $j) $query .= ',';
               }
               if(array_key_last($this->selections) !== $i) $query .= ',';
          }
          return [$query, $arrayFields];
     }
}