<?php

namespace Core\Flame\Orm;

use Core\Flame\Orm\BuilderTools\Conditions;
use Core\Flame\Orm\BuilderTools\Joins;
use Core\Flame\Orm\BuilderTools\Select;
use Core\Flame\Orm\Enums\JoinTypesEnum;
use Core\Flame\Orm\Query\Execute;
use Core\Flame\Orm\Relations\Relation;
use Core\Flame\Orm\Result\ObjectMappedResult;
use Exception;

class Builder implements IBuilder {
     protected bool $dryRun = false;

     protected array $fields = [];
     protected array $relations = [];
     protected array $whereConditions = [];
     protected JoinTypesEnum $joinType = JoinTypesEnum::INNER;

     protected ?string $orderType = NULL;
     protected array $orderFields = [];
     protected ?int $limit = NULL;
     protected ?int $offset = NULL;

     protected bool $onlyFirst = false;

     public function __construct(protected Model $model) {}

     public function select(array|string $select = '*', ?Model $model = NULL) {
          if(!is_array($select)) $select = explode(',', $select);
          $this->fields[] = [$select, is_null($model) ? $this->model : $model];
          return $this;
     }

     public function where(string $field, mixed $value, string $operator = '='): self {
          $this->whereConditions[] = [
               $field,
               $value,
               $operator,
               $this->model->getTable(),
               'and'
          ];
          return $this;
     }

     public function orWhere(string $field, mixed $value, string $operator = '='): self {
          $this->whereConditions[] = [
               $field,
               $value,
               $operator,
               $this->model->getTable(),
               'or'
          ];
          return $this;
     }

     public function whereWith(Relation $relation, string $field, mixed $value, string $operator = '='): self {
          $this->with($relation);
          $this->whereConditions[] = [
               $field,
               $value,
               $operator,
               $relation->related->getTable(),
               'and'
          ];
          return $this;
     }

     public function orWhereWith(Relation $relation, string $field, mixed $value, string $operator = '='): self {
          $this->with($relation);
          $this->whereConditions[] = [
               $field,
               $value,
               $operator,
               $relation->related->getTable(),
               'or'
          ];
          return $this;
     }

     public function orderBy(array|string $field = 'id', $type = 'desc'): self {
          $this->orderType = $type;
          $this->orderFields = array_merge($this->orderFields, is_array($field) ? $field : explode(',', $field));
          return $this;
     }

     public function desc(array|string $field = 'id'): self {
          return $this->orderBy($field, 'desc');
     }

     public function asc(array|string $field = 'id'): self {
          return $this->orderBy($field, 'asc');
     }

     public function limit(int $limit): self {
          $this->limit = $limit;
          return $this;
     }

     public function offset(int $offset): self {
          $this->offset = $offset;
          return $this;
     }

     public function first(string $via = 'id', ?Model $model = null) {
          if(is_null($model)) $model = $this->model;
          $this->onlyFirst = true;
          return $this->limit(1)->asc($this->model->getTable() . '.' . $via)->get();
     }

     public function latest(string $via = 'id', ?Model $model = null) {
          if(is_null($model)) $model = $this->model;
          $this->onlyFirst = true;
          return $this->limit(1)->desc($this->model->getTable() . '.' . $via)->get();
     }

     public function with(Relation|string|array $relation, JoinTypesEnum $type = JoinTypesEnum::INNER) {
          $_iterator = [];
          if(is_array($relation)) $_iterator = $relation;
          else $_iterator[] = $relation;
          foreach($_iterator as $rel) {
               if(is_string($rel)) {
                    try {
                         $rel = $this->model->{$rel}();
                    } catch(Exception) {
                         throw new Exception('Invalid relation method: ' . $rel);
                    }
               }
               if(!in_array(($table = $rel->related->getTable()), array_keys($this->relations))) {
                    $this->relations[$table] = [
                         $rel->baseField,
                         $rel->relatedField,
                         $type,
                    ];
               }
          }
          return $this;
     }

     public function get() {
          $bindings = [];
          $baseTable = $this->model->getTable();
          
          [$select, $genFields] = (new Select($this->fields))->generated();
          $query = 'select ' . $select . ' from ' . $baseTable . ' ';
          $query .= trim((new Joins(
               relations: $this->relations,
               base: $baseTable,
          ))->generated()) . ' ';

          [$conditions, $condBind] = (new Conditions($this->whereConditions))->generated();
          $query .= trim($conditions);
          $bindings = array_merge($bindings, $condBind);

          if(!is_null($this->orderType)) $query .= ' order by ' . implode(', ', $this->orderFields) . ' ' . $this->orderType;
          if(gettype($this->limit) == 'integer') $query .= ' limit ' . $this->limit;
          if(gettype($this->offset) == 'integer') $query .= ' offset ' . $this->limit;


          if($this->dryRun) return ['query' => $query, 'binding' => $bindings];

          $exec = (new Execute($query, $bindings))->fetch();
          if(empty($exec)) return false;
          
          $generated = (new ObjectMappedResult($genFields, $exec, $this->model))->createMappedObjects();

          return ($this->onlyFirst) ? $generated[0] : $generated;
     }

     /**
      * @return self Enables a dry mode where the query is not executed
      */
     public function dry(): self {
          $this->dryRun = true;
          return $this;
     }
}