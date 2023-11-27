<?php

namespace Core\Flame\Orm\Relations;

use Core\Flame\Orm\Model;

class Relation {
     public function __construct(
          public readonly Model $base,
          public readonly Model $related,
          public readonly string $baseField,
          public readonly string $relatedField = 'id',
          public readonly bool $multiQuery = false
     ) {}
}