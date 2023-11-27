<?php

namespace Core\Flame\Orm;

class SubQuery {
     public readonly string $query;
     public readonly array $bindings;

     public function __construct(Builder $builder) {
          $dry = $builder->dry()->get();
          $this->query = $dry[0];
          $this->bindings = $dry[1];
     }
}