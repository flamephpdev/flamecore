<?php

namespace DEV;

class Console extends ClassROOT {

     public static function single() {
          console()->run('Main');
     }

     public static function custom($args) {
          if(!isset($args[0])) {
               console()->run();
          } else console()->run($args[0]);
     }

}