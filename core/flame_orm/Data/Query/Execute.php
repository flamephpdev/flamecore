<?php

namespace Core\Flame\Orm\Query;

use DB;
use PDO;

class Execute {
     public function __construct(
          protected string $query,
          protected array $binding,
     ) {}

     public function fetch() {
          $pdo = DB::getConnection();
          $statement = $pdo->prepare($this->query);
          foreach($this->binding as $i => $bind) $statement->bindValue($i+1, $bind);
          $exec = $statement->execute();
          return $statement->fetchAll(PDO::FETCH_NUM);
     }
}