<?php

namespace Core\Flame\Orm\BuilderTools;

class Joins {
     public function __construct(protected array $relations, protected string $base) {}

     public function generated() {
          $first = true;
          $query = '';
          foreach($this->relations as $related => $info) {
               if(!$first && substr($query, -1) !== ' ') $query .= ' ';
               else $first = false;
               [$baseField, $relatedField, $type, $as] = $info;
               $query .= $type->value . ' join `' . $related . '`';
               $query .= ' on `' . $this->base . '`.`' . $baseField . '` = `' . $related . '`.`' . $relatedField . '`';
          }
          return $query;
     }

}

/*
$relation->baseField,     0
$relation->relatedField,  1
$type,                    2
$as                       3
*/