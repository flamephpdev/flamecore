<?php

namespace Flame\TestModels;

use Core\Flame\Orm\Model;

class Osztaly extends Model {
     protected static array $all_mysql_fields = [];
     protected static ?string $table = 'osztaly';
     protected array $writable = [
          'nev',
          'agyak',
          'foorvos_id',
     ];

     public function orvos() {
          return $this->belongsTo(new Orvos);
     }
}