<?php

namespace Core\Flame\Orm\Result;

use Core\Flame\Orm\Model;

class ObjectMappedResult {
     public function __construct(private array $fields, private array $datas, private Model $baseModel) {}

     private function getBelongsToRelation() {
          $models = [];
          foreach($this->datas as $values) {
               $base = new $this->baseModel;
               $baseData = [];
               $relatedData = [];
               foreach($values as $i => $value) {
                    [$field, $model] = $this->fields[$i];
                    $_fMod = explode('\\', $model::class);
                    $foreign_model = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', end($_fMod)));
                    if($model::class == $this->baseModel::class) $baseData[$field] = $value;
                    else {
                         if(isset($base->{$foreign_model})) $relatedData[$foreign_model][$field] = $value;
                         else {
                              $relatedData[$foreign_model] = [$field => $value];
                              $base->{$foreign_model} = new $model;
                         }
                    }
                    $models[] = $base;
               }
               $base->make($baseData);
               foreach(array_keys($relatedData) as $relKey) {
                    $base->{$relKey} = $base->{$relKey}->make($relatedData[$relKey]);
               }
          }
          return $models;
     }

     public function createMappedObjects() {
          return $this->getBelongsToRelation();
     }
}