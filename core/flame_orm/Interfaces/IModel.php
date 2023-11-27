<?php

namespace Core\Flame\Orm;

use Core\Flame\Request;

interface IModel {
     /**
      * @param array|string $fields The fields to select
      * @return static The builder
      */
     public static function select(array|string $fields): IBuilder;
     public static function delete(?int $id): IBuilder|bool;
     public static function update(array|Request $data, ?int $id, string $by): bool|Builder;
     public static function insert(array|Request $data): bool;
}