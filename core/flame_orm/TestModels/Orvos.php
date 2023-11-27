<?php

namespace Flame\TestModels;

use Core\Flame\Orm\Model;

class Orvos extends Model {
     protected static array $all_mysql_fields = [];
     protected static ?string $table = 'orvos';

     protected array $writable = [
          'nev',
          'szakirany',
          'kepzettseg',
          'ertekeles',
          'tapasztalat',
     ];

     protected array $hidden = [];

     public function osztaly() {
          return $this->hasOne(new Osztaly);
     }
}