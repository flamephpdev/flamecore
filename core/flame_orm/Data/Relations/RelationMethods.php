<?php

namespace Core\Flame\Orm\Relations;

use Core\Flame\Orm\Model;

trait RelationMethods {
     public function belongsTo(Model $model, $baseField = '@auto', $relatedField = 'id') {
          if($baseField == '@auto') $baseField = $model->getTable() . '_id';
          return new Relation($this, $model, $baseField, $relatedField);
     }

     public function hasOne(Model $model, $relatedField = '@auto', $baseField = 'id') {
          if($relatedField == '@auto') $relatedField = $this->getTable() . '_id';
          return new Relation($this, $model, $baseField, $relatedField);
     }

     public function hasMany(Model $model, $baseField = '@auto', $relatedField = 'id') {
          if($baseField == '@auto') $baseField = $model->getTable() . '_id';
          return new Relation($this, $model, $relatedField, $baseField, true);
     }

     public function belongToMany(Model $model, $baseField = '@auto', $relatedField = 'id') {
          if($baseField == '@auto') $baseField = $model->getTable() . '_id';
          return new Relation($this, $model, $relatedField, $baseField, true);
     }
}