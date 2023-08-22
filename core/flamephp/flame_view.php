<?php

namespace Views\Views;

use Exception;
use Views\Files\FlameFile;

class FlameView {

     private static int $currentInx = 0;
     private static array $__Files;

     public function fileSetConfigFlameFile(FlameFile $file) {
          self::$__Files[$file->path('@')] = $file;
          self::$currentInx = count(self::$__Files) - 1;
          return self::file();
     }

     public function file() {
          if(!isset(self::$__Files[self::$currentInx])) throw new Exception("Using outside a view file");
          return self::$__Files;
     }

     public function back() {
          unset(self::$__Files[self::$currentInx]);
          self::$__Files = [self::$__Files];
          self::$currentInx = count(self::$__Files) - 1;
     }

}
